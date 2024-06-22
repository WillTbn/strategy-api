<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\UserExtractServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserExtractController extends Controller
{
    private UserExtractServices $extractServices;
    private $loggedUser;
    public function __construct(
        UserExtractServices $extractServices
    )
    {
        $this->extractServices = $extractServices;
        $this->loggedUser =  Auth::user('api');;
    }
    public function index(int $user_id)
    {
        $extract = $this->extractServices->get($user_id);

        return response()->json([
            'extract' => $extract,
            'status'=> 200
        ], 200);
    }
    public function getExtract()
    {
        try{
            $response = $this->extractServices->get($this->loggedUser->id);
            return response()->json([
                'message' => 'Dados do extrato!',
                'extract' => $response,
                'status'=> 200
            ], 200);
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao pegar extrato!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function getExtractChart()
    {
        try{
            $response = $this->extractServices->getExtractByChart($this->loggedUser->id);
            return response()->json([
                'message' => 'Dados do extrato!',
                'extract_chart' => $response,
                'status'=> 200
            ], 200);
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao pegar extrato!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
}
