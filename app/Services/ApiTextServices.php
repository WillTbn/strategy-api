<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiTextServices
{
    public function getVerify(
        ?string $value = null ,
        ?string $type = null,
        ?string $token = null
    )
    {
        $params = array_filter(get_defined_vars());
        try{
           return Http::textapi()->get('validator', $params)->throw()->json();
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao conecta com api externa!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function cepVerifiy(string $cep)
    {
        $url = 'https://viacep.com.br/ws/'.$cep.'/json';
        try{
            return Http::get($url)->throw()->json();
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao conecta com api externa!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
}
