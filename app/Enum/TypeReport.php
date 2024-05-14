<?php

namespace App\Enum;

enum TypeReport : String
{
    case CLASSIC = 'classic';
    case CRYPTO = 'crypto';
    public static function forSelectName(): array
    {
      return array_combine(
          array_column(self::cases(), 'name'),
          array_column(self::cases(), 'value'),
      );
    }
}
