<?php

namespace App\Enum;

enum RoleEnum :int
{
    case Master = 1;
    case Employee = 2;
    case Client = 3;
    public static function forAbilitiesDefault(): array
    {
        return [
            self::Master->value =>[
                'name' => 'all-access'
            ],
            self::Employee->value =>[
                'name' => 'client-access'
            ],
            self::Client->value =>[
                'name' => 'control-personal'
            ]
        ];
    }
    public static function forRoleIdName(): array
    {
        return [
            self::Master->value =>[
                'name' => self::Master->name
            ],
            self::Employee->value =>[
                'name' => self::Employee->name
            ],
            self::Client->value =>[
                'name' => self::Client->name
            ]
        ];
    }
}
