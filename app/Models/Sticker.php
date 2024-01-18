<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 1;
    public const STATUS_APPROVED = 2;

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_APPROVED
    ];

    public const IMAGE_MEDIA_COLLECTION = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'level_1',
        'level_2',
        'level_3',
        'price',
        'price_2',
        'count',
        'property',
        'unit',
        'shop',
        'image',
        'is_home',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
    ];

}
