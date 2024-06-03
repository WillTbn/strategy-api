<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ClientServices;
use Illuminate\Http\Request;

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
}
