<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    const CARD_VISA = 'visa';
    const CARD_MASTER = 'master';
    const STATUS_DELETED = '0';
    const STATUS_ACTIVE = '1';
    const STATUS_NOT_ACTIVE = '2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'number', 'show_status',
    ];

    public function scopeActive($query)
    {
        return $query->where('show_status', self::STATUS_ACTIVE);
    }

    public static function getCards()
    {
        return [
          self::CARD_VISA,
          self::CARD_MASTER
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_DELETED,
            self::STATUS_ACTIVE,
            self::STATUS_NOT_ACTIVE
        ];
    }
}
