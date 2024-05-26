<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObject\Register\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Services\ApiTextServices;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private ApiTextServices $textapiServices;
    private UserServices $userServices;
    public function __construct(
        ApiTextServices $apitextServices,
        UserServices $userServices
    )
    {
        $this->textapiServices = $apitextServices;
        $this->userServices = $userServices;
    }
    public function verifyPersonAPI(Request $request)
    {
        $request['token'] = env('APIINVERTTEXTO_TOKEN');
        $validator = Validator::make($request->all(), [
            'value' => 'required|unique:accounts,person'
        ],
            ['value.unique' => 'CPF já sendo utilizado em nossa plataforma!']
        );
        $validator->validate();
        // tem que verificar se o CPF já não tem cadastrado em nossa base de dados
        return $this->textapiServices->getVerify(...$request->only([
            'token', 'value', 'type'
        ]));
    }
    public function verifyCep(Request $request)
    {
        return $this->textapiServices->cepVerifiy(...$request->only(['cep']));
    }
    public function register(Request $request)
    {
        $registerDTO = new RegisterDTO(...$request->only([
            "address_city",
            "address_district" ,
            "address_numbers",
            "address_state" ,
            "address_street",
            "address_zip_code",
            "birthday",
            "email",
            "genre",
            "name",
            "notifications",
            "password",
            "password_confirmation",
            "person",
            "phone"
        ]));
        $response = $this->userServices->createClient($registerDTO);
        if($response->exception){
            return response()->json([
                'message' => 'error na criação do usuário.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
}
