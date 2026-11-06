#Requires -Version 5.1
<#
.SYNOPSIS
  Arma dos ZIP para subir Cigno a cPanel solo con el Administrador de archivos.

.DESCRIPTION
  godaddy-app.zip    → extraer dentro de la carpeta cigno (hermana de public_html).
  godaddy-public.zip → extraer dentro de public_html.

  Incluye vendor/. No incluye .env, node_modules, .git ni public/videos.
  El setup.php del ZIP publico lleva un token nuevo, impreso al final.
#>
$ErrorActionPreference = 'Stop'
$root = Split-Path $PSScriptRoot -Parent
Set-Location $root

if (-not (Test-Path 'vendor\autoload.php')) {
    throw 'Falta vendor/. En esta carpeta corre: composer install'
}

if (-not (Test-Path 'public\build\manifest.json')) {
    throw 'Falta public/build. Corre: npm run build'
}

$out = Join-Path $root 'deploy'
New-Item -ItemType Directory -Force -Path $out | Out-Null

$token = -join ((48..57 + 65..90 + 97..122) | Get-Random -Count 32 | ForEach-Object { [char]$_ })

$stage = Join-Path ([System.IO.Path]::GetTempPath()) ("cigno-godaddy-" + [guid]::NewGuid().ToString('N'))
$appStage = Join-Path $stage 'cigno'
$publicStage = Join-Path $stage 'public_html'
New-Item -ItemType Directory -Force -Path $appStage, $publicStage | Out-Null

Write-Host 'Copiando aplicacion...'
robocopy $root $appStage /E /NFL /NDL /NJH /NJS /nc /ns /np `
    /XD node_modules .git public tests storage\logs storage\framework\cache storage\framework\sessions storage\framework\views .cursor .idea .vscode `
    /XF .env .env.backup .phpunit.result.cache | Out-Null
if ($LASTEXITCODE -ge 8) { throw "robocopy app fallo ($LASTEXITCODE)" }

New-Item -ItemType Directory -Force -Path `
    "$appStage\storage\logs", `
    "$appStage\storage\framework\cache\data", `
    "$appStage\storage\framework\sessions", `
    "$appStage\storage\framework\views", `
    "$appStage\bootstrap\cache" | Out-Null

Write-Host 'Copiando public_html...'
robocopy "$root\public" $publicStage /E /NFL /NDL /NJH /NJS /nc /ns /np `
    /XD videos storage hot | Out-Null
if ($LASTEXITCODE -ge 8) { throw "robocopy public fallo ($LASTEXITCODE)" }

Copy-Item "$root\deploy\godaddy\index.php" "$publicStage\index.php" -Force
$setup = Get-Content "$root\deploy\godaddy\setup.php" -Raw
$setup = $setup.Replace("`$setupToken = 'CAMBIA-ESTE-TOKEN';", "`$setupToken = '$token';")
Set-Content -Path "$publicStage\setup.php" -Value $setup -Encoding UTF8

$appZip = Join-Path $out 'godaddy-app.zip'
$publicZip = Join-Path $out 'godaddy-public.zip'
if (Test-Path $appZip) { Remove-Item $appZip -Force }
if (Test-Path $publicZip) { Remove-Item $publicZip -Force }

Write-Host 'Comprimiendo...'
tar.exe -a -cf $appZip -C $appStage .
if ($LASTEXITCODE -ne 0) { throw 'tar app fallo' }
tar.exe -a -cf $publicZip -C $publicStage .
if ($LASTEXITCODE -ne 0) { throw 'tar public fallo' }

Remove-Item $stage -Recurse -Force

Write-Host ''
Write-Host "App:    $appZip"
Write-Host "Public: $publicZip"
Write-Host "Token de setup.php: $token"
Write-Host 'Abre https://TU-DOMINIO/setup.php?token=ESE-TOKEN y borra setup.php al terminar.'
