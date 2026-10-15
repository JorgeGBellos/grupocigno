<x-layouts.app :title="'Design System — '.config('app.name')">
    <div class="min-h-screen bg-off-white-100 text-yellow-gold-500">
        <div class="border-b border-beige-300">
            <div class="mx-auto flex max-w-6xl flex-col gap-6 px-6 py-10 lg:flex-row lg:items-end lg:justify-between lg:px-12 lg:py-14">
                <div>
                    <p class="type-label">Cigno Hoteles</p>
                    <h1 class="type-h3 mt-4">Design System</h1>
                </div>
                <nav class="flex flex-wrap gap-x-8 gap-y-3">
                    <a href="#colores" class="type-btn-sm">Colores</a>
                    <a href="#tipografia" class="type-btn-sm">Tipografía</a>
                    <a href="#botones" class="type-btn-sm">Botones</a>
                </nav>
            </div>
        </div>

        <main class="mx-auto max-w-6xl px-6 py-16 lg:px-12 lg:py-24">
            <section id="colores">
                <p class="type-label">01</p>
                <h2 class="type-s1 mt-4">Colores</h2>
                <p class="type-b2 mt-4 max-w-2xl text-yellow-gold-300">Paletas de marca. Clases Tailwind: <span class="text-yellow-gold-500">bg-</span>, <span class="text-yellow-gold-500">text-</span> y <span class="text-yellow-gold-500">border-</span> + nombre del token.</p>

                <div class="mt-12 space-y-12">
                    <x-design-system.palette
                        name="Off White"
                        :shades="[
                            ['shade' => '100', 'hex' => '#FFFCF7', 'swatch' => 'bg-off-white-100', 'token' => 'off-white-100'],
                            ['shade' => '300', 'hex' => '#FBF8F3', 'swatch' => 'bg-off-white-300', 'token' => 'off-white-300'],
                            ['shade' => '500', 'hex' => '#F3EFE8', 'swatch' => 'bg-off-white-500', 'token' => 'off-white-500'],
                        ]"
                    />

                    <x-design-system.palette
                        name="Beige"
                        :shades="[
                            ['shade' => '100', 'hex' => '#EEEAE3', 'swatch' => 'bg-beige-100', 'token' => 'beige-100'],
                            ['shade' => '300', 'hex' => '#E2DBD0', 'swatch' => 'bg-beige-300', 'token' => 'beige-300'],
                            ['shade' => '500', 'hex' => '#D3CABC', 'swatch' => 'bg-beige-500', 'token' => 'beige-500'],
                        ]"
                    />

                    <x-design-system.palette
                        name="Yellow Gold"
                        :shades="[
                            ['shade' => '100', 'hex' => '#D4A247', 'swatch' => 'bg-yellow-gold-100', 'token' => 'yellow-gold-100', 'light' => true],
                            ['shade' => '300', 'hex' => '#BC9142', 'swatch' => 'bg-yellow-gold-300', 'token' => 'yellow-gold-300', 'light' => true],
                            ['shade' => '500', 'hex' => '#936F2E', 'swatch' => 'bg-yellow-gold-500', 'token' => 'yellow-gold-500', 'light' => true],
                        ]"
                    />

                    <x-design-system.palette
                        name="Green"
                        :shades="[
                            ['shade' => '100', 'hex' => '#EAECDC', 'swatch' => 'bg-green-100', 'token' => 'green-100'],
                            ['shade' => '300', 'hex' => '#C0C6A6', 'swatch' => 'bg-green-300', 'token' => 'green-300'],
                            ['shade' => '500', 'hex' => '#A8AE8C', 'swatch' => 'bg-green-500', 'token' => 'green-500'],
                        ]"
                    />

                    <x-design-system.palette
                        name="Blue"
                        :shades="[
                            ['shade' => '100', 'hex' => '#0A5B66', 'swatch' => 'bg-blue-100', 'token' => 'blue-100', 'light' => true],
                            ['shade' => '300', 'hex' => '#044F59', 'swatch' => 'bg-blue-300', 'token' => 'blue-300', 'light' => true],
                            ['shade' => '500', 'hex' => '#003A42', 'swatch' => 'bg-blue-500', 'token' => 'blue-500', 'light' => true],
                        ]"
                    />

                    <x-design-system.palette
                        name="Blue Ermita"
                        :shades="[
                            ['shade' => '100', 'hex' => '#1774B6', 'swatch' => 'bg-blue-ermita-100', 'token' => 'blue-ermita-100', 'light' => true],
                            ['shade' => '300', 'hex' => '#026C7B', 'swatch' => 'bg-blue-ermita-300', 'token' => 'blue-ermita-300', 'light' => true],
                            ['shade' => '500', 'hex' => '#01355A', 'swatch' => 'bg-blue-ermita-500', 'token' => 'blue-ermita-500', 'light' => true],
                        ]"
                    />

                    <x-design-system.palette
                        name="Mejorada (#2D3526)"
                        :shades="[
                            ['shade' => '100', 'hex' => '#4F5C43', 'swatch' => 'bg-blue-mejorada-100', 'token' => 'blue-mejorada-100', 'light' => true],
                            ['shade' => '300', 'hex' => '#2D3526', 'swatch' => 'bg-blue-mejorada-300', 'token' => 'blue-mejorada-300', 'light' => true],
                            ['shade' => '500', 'hex' => '#1A1F16', 'swatch' => 'bg-blue-mejorada-500', 'token' => 'blue-mejorada-500', 'light' => true],
                        ]"
                    />

                    <x-design-system.palette
                        name="Black"
                        :shades="[
                            ['shade' => '100', 'hex' => '#CCC', 'swatch' => 'bg-black-100', 'token' => 'black-100'],
                            ['shade' => '300', 'hex' => '#808080', 'swatch' => 'bg-black-300', 'token' => 'black-300', 'light' => true],
                            ['shade' => '500', 'hex' => '#000', 'swatch' => 'bg-black-500', 'token' => 'black-500', 'light' => true],
                        ]"
                    />

                    <x-design-system.palette
                        name="Medium Green"
                        :shades="[
                            ['shade' => '100', 'hex' => '#AFB6A4', 'swatch' => 'bg-medium-green-100', 'token' => 'medium-green-100'],
                            ['shade' => '300', 'hex' => '#9BA48B', 'swatch' => 'bg-medium-green-300', 'token' => 'medium-green-300'],
                            ['shade' => '500', 'hex' => '#7A8469', 'swatch' => 'bg-medium-green-500', 'token' => 'medium-green-500', 'light' => true],
                        ]"
                    />
                </div>
            </section>

            <section id="tipografia" class="mt-24 border-t border-beige-300 pt-24 lg:mt-32 lg:pt-32">
                <p class="type-label">02</p>
                <h2 class="type-s1 mt-4">Tipografía</h2>
                <p class="type-b2 mt-4 max-w-2xl text-yellow-gold-300">Junius VF para títulos, S2, body y labels. Anybody para S1 y botones.</p>

                <div class="mt-12 grid gap-6 md:grid-cols-2">
                    <div class="border border-beige-300 bg-off-white-300 p-8">
                        <p class="type-label">Serif</p>
                        <p class="type-h3 mt-4">Junius VF</p>
                        <p class="type-b3 mt-3 text-yellow-gold-300">H1 Medium · H2 Regular · H3 Bold · S2 Bold · B1 Bold · B2 / B3 Regular</p>
                    </div>
                    <div class="border border-beige-300 bg-off-white-300 p-8">
                        <p class="type-label">Sans</p>
                        <p class="type-s1 mt-4">Anybody</p>
                        <p class="type-b3 mt-3 text-yellow-gold-300">S1 Regular · Label · Botones lg / md / sm</p>
                    </div>
                </div>

                <div class="mt-16">
                    <p class="type-label">Títulos</p>
                    <x-design-system.specimen type="type-h1" token="type-h1" meta="Junius VF · Medium · 60 / 70px · lh 120%" sample="H1. Headline" />
                    <x-design-system.specimen type="type-h2" token="type-h2" meta="Junius VF · Regular · 40 / 60px · lh 120%" sample="H2. Headline" />
                    <x-design-system.specimen type="type-h3" token="type-h3" meta="Junius VF · Bold · 30 / 50px · lh 120%" sample="H3. Headline" />
                </div>

                <div class="mt-16">
                    <p class="type-label">Subtítulos</p>
                    <x-design-system.specimen type="type-s1" token="type-s1" meta="Anybody · Regular · 28px · uppercase · lh 120%" sample="S1. Subtitle" />
                    <x-design-system.specimen type="type-s2" token="type-s2" meta="Junius VF · Bold · 24px · lh 120%" sample="S2. Subtitle" />
                </div>

                <div class="mt-16">
                    <p class="type-label">Body</p>
                    <x-design-system.specimen type="type-b1" token="type-b1" meta="Junius VF · Bold · 18 / 26px · lh 120%" sample="B1. Body — texto de introducción." />
                    <x-design-system.specimen type="type-b2" token="type-b2" meta="Junius VF · Regular · 16 / 22px · lh 120%" sample="B2. Body — párrafo de lectura general para el sitio público." />
                    <x-design-system.specimen type="type-b3" token="type-b3" meta="Junius VF · Regular · 14 / 20px · lh 120%" sample="B3. Body — texto de apoyo, pies de foto y detalles." />
                </div>

                <div class="mt-16">
                    <p class="type-label">Label</p>
                    <x-design-system.specimen type="type-label" token="type-label" meta="Anybody · Medium · 12 / 16px · uppercase · tracking" sample="Label" />
                </div>
            </section>

            <section id="botones" class="mt-24 border-t border-beige-300 pt-24 lg:mt-32 lg:pt-32">
                <p class="type-label">03</p>
                <h2 class="type-s1 mt-4">Botones</h2>
                <p class="type-b2 mt-4 max-w-2xl text-yellow-gold-300">Estilos de texto subrayado. Todos los botones en Anybody. Small en caja alta.</p>

                <div class="mt-12 flex flex-col gap-10">
                    <div>
                        <p class="type-label mb-4">type-btn-lg · Anybody · 18 / 24px · lh 160%</p>
                        <a href="#botones" class="type-btn-lg">Large</a>
                    </div>
                    <div>
                        <p class="type-label mb-4">type-btn-md · Anybody · 16 / 20px · lh 160%</p>
                        <a href="#botones" class="type-btn-md">Medium</a>
                    </div>
                    <div>
                        <p class="type-label mb-4">type-btn-sm · Anybody · 14 / 16px · uppercase · lh 160%</p>
                        <a href="#botones" class="type-btn-sm">Small</a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</x-layouts.app>
