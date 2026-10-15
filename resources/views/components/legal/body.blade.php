@props([
    'content',
])

@php
    $lines = preg_split("/\r\n|\n|\r/", trim($content)) ?: [];
    $blocks = [];
    $listItems = [];

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '') {
            if ($listItems !== []) {
                $blocks[] = ['type' => 'list', 'items' => $listItems];
                $listItems = [];
            }

            continue;
        }

        if (str_starts_with($line, '- ')) {
            $listItems[] = trim(substr($line, 2));

            continue;
        }

        if ($listItems !== []) {
            $blocks[] = ['type' => 'list', 'items' => $listItems];
            $listItems = [];
        }

        if (str_starts_with($line, '## ')) {
            $blocks[] = ['type' => 'heading', 'text' => trim(substr($line, 3))];
        } else {
            $blocks[] = ['type' => 'paragraph', 'text' => $line];
        }
    }

    if ($listItems !== []) {
        $blocks[] = ['type' => 'list', 'items' => $listItems];
    }
@endphp

<div {{ $attributes->merge(['class' => 'legal-content']) }}>
    @foreach ($blocks as $block)
        @if ($block['type'] === 'heading')
            <h2 class="type-h3 mt-10 first:mt-0">{{ $block['text'] }}</h2>
        @elseif ($block['type'] === 'list')
            <ul class="mt-4 list-disc space-y-2 pl-5">
                @foreach ($block['items'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <p class="mt-4 first:mt-0">{{ $block['text'] }}</p>
        @endif
    @endforeach
</div>
