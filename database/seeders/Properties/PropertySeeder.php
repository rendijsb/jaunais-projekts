<?php

declare(strict_types=1);

namespace Database\Seeders\Properties;

use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    use WithoutModelEvents;

    private const PAYLOAD = [
        [
            Property::FLAT_NUMBER => 101,
            Property::FLOOR => 1,
            Property::TERRACE_AREA => 49.00,
            Property::BALCONY_AREABALCONY_AREA => null,
            Property::FLAT_AREA => 49.94,
            Property::TOTAL_AREA => 98.94,
            Property::PRICE => 20000000,
        ],
        [
            Property::FLAT_NUMBER => 102,
            Property::FLOOR => 1,
            Property::TERRACE_AREA => 63.00,
            Property::BALCONY_AREABALCONY_AREA => null,
            Property::FLAT_AREA => 105.54,
            Property::TOTAL_AREA => 168.54,
            Property::PRICE => 25000000,
        ],
        [
            Property::FLAT_NUMBER => 103,
            Property::FLOOR => 1,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => null,
            Property::FLAT_AREA => 67.72,
            Property::TOTAL_AREA => 67.72,
            Property::PRICE => 15000000,
        ],
        [
            Property::FLAT_NUMBER => 104,
            Property::FLOOR => 1,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => null,
            Property::FLAT_AREA => 57.94,
            Property::TOTAL_AREA => 57.94,
            Property::PRICE => 13500000,
        ],
        [
            Property::FLAT_NUMBER => 105,
            Property::FLOOR => 1,
            Property::TERRACE_AREA => 91.00,
            Property::BALCONY_AREABALCONY_AREA => null,
            Property::FLAT_AREA => 127.66,
            Property::TOTAL_AREA => 218.66,
            Property::PRICE => 27500000,
        ],
        [
            Property::FLAT_NUMBER => 106,
            Property::FLOOR => 1,
            Property::TERRACE_AREA => 23.00,
            Property::BALCONY_AREABALCONY_AREA => null,
            Property::FLAT_AREA => 46.10,
            Property::TOTAL_AREA => 69.10,
            Property::PRICE => 15500000,
        ],
        [
            Property::FLAT_NUMBER => 201,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 19.52,
            Property::FLAT_AREA => 73.33,
            Property::TOTAL_AREA => 92.85,
            Property::PRICE => 28500000,
        ],
        [
            Property::FLAT_NUMBER => 202,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 18.88,
            Property::FLAT_AREA => 97.12,
            Property::TOTAL_AREA => 116,
            Property::PRICE => 23200000,
        ],
        [
            Property::FLAT_NUMBER => 203,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 12.85,
            Property::FLAT_AREA => 119.01,
            Property::TOTAL_AREA => 131.86,
            Property::PRICE => 28200000,
        ],
        [
            Property::FLAT_NUMBER => 204,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 9.34,
            Property::FLAT_AREA => 64.77,
            Property::TOTAL_AREA => 74.11,
            Property::PRICE => 19200000,
        ],
        [
            Property::FLAT_NUMBER => 205,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 8.4,
            Property::FLAT_AREA => 95.36,
            Property::TOTAL_AREA => 103.76,
            Property::PRICE => 21200000,
        ],
        [
            Property::FLAT_NUMBER => 206,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 8.95,
            Property::FLAT_AREA => 56.9,
            Property::TOTAL_AREA => 65.85,
            Property::PRICE => 15200000,
        ],
        [
            Property::FLAT_NUMBER => 207,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 12.46,
            Property::FLAT_AREA => 100.3,
            Property::TOTAL_AREA => 112.76,
            Property::PRICE => 17800000,
        ],
        [
            Property::FLAT_NUMBER => 207,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 12.46,
            Property::FLAT_AREA => 100.3,
            Property::TOTAL_AREA => 112.76,
            Property::PRICE => 17800000,
        ],
        [
            Property::FLAT_NUMBER => 208,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 7.05,
            Property::FLAT_AREA => 61.16,
            Property::TOTAL_AREA => 68.21,
            Property::PRICE => 14900000,
        ],
        [
            Property::FLAT_NUMBER => 209,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 14.93,
            Property::FLAT_AREA => 97.26,
            Property::TOTAL_AREA => 112.19,
            Property::PRICE => 17200000,
        ],
        [
            Property::FLAT_NUMBER => 210,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 20.17,
            Property::FLAT_AREA => 112.85,
            Property::TOTAL_AREA => 133.02,
            Property::PRICE => 18100000,
        ],
        [
            Property::FLAT_NUMBER => 211,
            Property::FLOOR => 2,
            Property::TERRACE_AREA => null,
            Property::BALCONY_AREABALCONY_AREA => 4.1,
            Property::FLAT_AREA => 91.38,
            Property::TOTAL_AREA => 95.48,
            Property::PRICE => 14500000,
        ],
    ];

    public function run(): void
    {
        foreach (self::PAYLOAD as $payload) {
            Property::firstOrCreate($payload);
        }
    }
}
