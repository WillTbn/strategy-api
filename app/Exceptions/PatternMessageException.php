<?php

namespace App\Exceptions;

use Exception;

class PatternMessageException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => $this->message ? $this->message : 'Verifique os parâmetros, estão incorretos!',
        ], 400);
    }
}
