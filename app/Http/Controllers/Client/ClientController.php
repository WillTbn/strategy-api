<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ClientServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    private ClientServices $clientServices;
    public function __construct(
        ClientServices $clientServices
    )
    {
        $this->clientServices = $clientServices;
    }
    public function index(int $id)
    {
        $get = $this->clientServices->get($id);
        if(!$get){
            return response()->json([
                'message' => 'Usuário não encontrado',
                'status'=> 402
            ], 402);
        }
        return response()->json([
            'status'=> '200',
            'message'=> 'Usuário encontrado!',
            'user' => $get
        ], 200);
    }
    public function store()
    {
        $clients = $this->clientServices->getAll();

        return response()->json([
            'clients' => $clients,
            'status'=> 200
        ], 200);
    }
    public function addInvestment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'investment_id' => 'required|integer|exists:investments,id',
            'transiction_wallet' => 'boolean|required'
        ]);
        $validator->validate();

        $response = $this->clientServices->addInvestimentUser($request->user_id, $request->investment_id, $request->transiction_wallet);
        if($response->exception){
            return response()->json([
                'message' => 'Error Ao tentar adicionar investimento.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
}
