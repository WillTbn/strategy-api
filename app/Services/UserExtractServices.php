<?php

namespace App\Services;
use App\Models\UserExtract;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UserExtractServices
{
    public function createExtract(
        $user_id,
        $trans_name,
        $trans_value,
        $trans_date,
        $trans_data = null
    )
    {
        try{
            $trans = new UserExtract();
            $trans->user_id = $user_id;
            $trans->transaction_name = $trans_name;
            $trans->transaction_date = $trans_date;
            $trans->transaction_value = $trans_value;
            $trans->transaction_data = json_encode([
                'value' => $trans_value,
                'data' => $trans_data,
            ]);
            $trans->saveOrFail();
            return $trans;
            Log::info('deu tudo certo....., criando log no extrado de ->'.json_encode($trans) );
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao atualizar avatar!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function get(int $user):Collection
    {
        $response = UserExtract::where('user_id', $user)->get();
        return $response;
    }
}
