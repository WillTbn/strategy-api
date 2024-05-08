<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function unauthorized()
    {
        return response()->json(
        [
        'status' => '401',
        'error' => 'Não autorizado'
        ],401);
    }
}
