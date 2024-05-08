<?php

namespace App\Enum;

enum NotificationEnum:string
{
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';
    public static function forSelectName(): array
    {
      return array_combine(
          array_column(self::cases(), 'name'),
          array_column(self::cases(), 'value'),
      );
    }
}
