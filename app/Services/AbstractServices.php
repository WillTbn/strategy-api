<?php

namespace Services;

use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractServices
{
    public function messageSuccess(
        String $message = 'Dados atualizado com sucesso!',
        Array $addData = ['dados' =>  'Não há dados de retorno'],
        int $status
    ){
        return response()->json([
            'message' =>  $message,
            $addData,
            'status' => $status
        ], $status);
    }

}
