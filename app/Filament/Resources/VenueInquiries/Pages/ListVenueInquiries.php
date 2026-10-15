<?php

namespace App\Filament\Resources\VenueInquiries\Pages;

use App\Filament\Resources\VenueInquiries\VenueInquiryResource;
use Filament\Resources\Pages\ListRecords;

class ListVenueInquiries extends ListRecords
{
    protected static string $resource = VenueInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
