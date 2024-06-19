<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\UserExtractServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $response = $this->extractServices->get($this->loggedUser->id);

        // $response = $this->accountServices->updateNameByTelephone($request->name, $request->phone, $this->loggedUser->id);
        if($response->exception){
            return response()->json([
                'message' => 'Error no upload do avatar.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;

    }
}
