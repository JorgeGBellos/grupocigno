<?php

namespace App\Support;

use Carbon\CarbonImmutable;

class MiraiBookingUrl
{
    public function __construct(
        private readonly array $config,
    ) {}

    public static function make(): self
    {
        return new self(config('booking'));
    }

    public function url(array $search): string
    {
        $checkin = CarbonImmutable::parse($search['checkin'])->startOfDay();
        $checkout = CarbonImmutable::parse($search['checkout'])->startOfDay();
        $nights = max(1, (int) $checkin->diffInDays($checkout));
        $rooms = max(1, (int) $search['rooms']);
        $roomAdults = $search['room_adults'] ?? null;

        if (is_array($roomAdults) && $roomAdults !== []) {
            $parties = array_map(static fn ($adults): array => [
                'adults' => max(1, (int) $adults),
                'children' => [],
            ], $roomAdults);
            $rooms = count($parties);
        } else {
            $adults = max(1, (int) $search['adults']);
            $parties = array_fill(0, $rooms, [
                'adults' => $adults,
                'children' => [],
            ]);
        }

        $locale = $search['locale'] ?? app()->getLocale();
        $hotel = $search['hotel'];
        $promotion = trim((string) ($search['promotion'] ?? ''));

        $query = http_build_query([
            'chainSelectorValue' => $this->config['hotels'][$hotel]['selector'],
            'checkin' => $checkin->format('m/d/Y'),
            'idtokenprovider' => $this->config['idtokenprovider'],
            'currency' => $this->config['currency'],
            'idchain' => $this->config['idchain'],
            'clientCode' => $promotion !== '' ? $promotion : $this->config['client_code'],
            'hsri' => $this->config['hsri'],
            'lang' => $locale,
            'nights' => $nights,
            'parties' => base64_encode(json_encode($parties)),
            'type' => 'chain',
            'step' => 1,
            'home' => rtrim((string) $this->config['home'], '/').'/',
        ], '', '&', PHP_QUERY_RFC3986);

        return rtrim($this->config['base_url'], '/').'/'.$locale.'/bookingstep1/?'.$query;
    }
}
