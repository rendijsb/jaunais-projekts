<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Property extends Model
{
    public const TABLE = 'properties';
    protected $table = self::TABLE;

    public const ID = 'id';
    public const FLAT_NUMBER = 'flat_number';
    public const FLOOR = 'floor';
    public const TERRACE_AREA = 'terrace_area';
    public const BALCONY_AREA = 'balcony_area';
    public const FLAT_AREA = 'flat_area';
    public const TOTAL_AREA = 'total_area';
    public const PRICE = 'price';
    public const STATUS = 'status';

    protected $fillable = [
        self::STATUS,
        self::FLAT_NUMBER,
        self::FLOOR,
        self::FLAT_AREA,
        self::TOTAL_AREA,
        self::BALCONY_AREA,
        self::TERRACE_AREA,
        self::PRICE,
    ];

    public const SORTABLE_COLUMNS = [
        self::FLAT_NUMBER,
        self::FLOOR,
        self::FLAT_AREA,
        self::TOTAL_AREA,
        self::TERRACE_AREA,
        self::BALCONY_AREA,
        self::PRICE,
        self::STATUS,
    ];
}
