<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnNumberSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_year',
        'city_code',
        'last_number',
        'prefix',
        'format',
    ];

    /**
     * Generate next CN number
     */
    public static function generateNext($systemYear = '2526', $cityCode = null)
    {
        $sequence = self::firstOrCreate(
            [
                'system_year' => $systemYear,
                'city_code' => $cityCode,
            ],
            [
                'last_number' => 0,
                'prefix' => 'CN',
                'format' => 'CN-{YEAR}-{NUMBER}',
            ]
        );

        $sequence->increment('last_number');
        $sequence->refresh();

        $number = str_pad($sequence->last_number, 5, '0', STR_PAD_LEFT);
        $cnNumber = str_replace(
            ['{YEAR}', '{NUMBER}', '{CITY}'],
            [$systemYear, $number, $cityCode ?? ''],
            $sequence->format
        );

        return trim($cnNumber, '-');
    }
}

