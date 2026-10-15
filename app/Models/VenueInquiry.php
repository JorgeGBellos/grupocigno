<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueInquiry extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'event_date',
        'event_type',
        'additional_information',
        'locale',
        'hotel',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function getNameAttribute(): string
    {
        return trim(($this->first_name ?? '').' '.($this->last_name ?? ''));
    }
}
