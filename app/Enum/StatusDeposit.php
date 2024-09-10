<?php

namespace App\Enum;

enum StatusDeposit :string
{
    case Initial = 'initial';
    case Wainting = 'wainting';
    // case Receipt = 'receipt';
    case Rejected = 'rejected';
    case Confirmed = 'confirmed';
    public static function forSelectName():array
    {
        return array_combine(
            array_column(self::cases(), 'name'),
            array_column(self::cases(),'value' )
        );
    }
}
