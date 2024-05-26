<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiTextServices;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private ApiTextServices $textapiServices;
    public function __construct(
        ApiTextServices $apitextServices
    )
    {
        $this->textapiServices = $apitextServices;
    }
    public function verifyPersonAPI(Request $request)
    {
        $request['token'] = env('APIINVERTTEXTO_TOKEN');

        return $this->textapiServices->getVerify(...$request->only([
            'token', 'value', 'type'
        ]));
    }
    public function verifyCep(Request $request)
    {
        return $this->textapiServices->cepVerifiy(...$request->only(['cep']));
    }
}
