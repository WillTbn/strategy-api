<?php

namespace App\Http\Controllers;

use App\Services\PaymentServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private PaymentServices $paymentServices;
    private $loggedUser;
    public function __construct(
        PaymentServices $paymentServices
    )
    {
        $this->paymentServices = $paymentServices;
        $this->loggedUser = Auth::user('api');
    }
    public function initialPix(Request $request)
    {
        $pix = $this->paymentServices->getPix($request->amount,$this->loggedUser->id, true);
        // $qrCode = $this->paymentServices->
        return response()->json([
            'code_pix' => $pix->qrcode,
            'deposit' => $pix,
            'status'=> 200
        ], 200);
    }
    public function verify()
    {
        $pix = $this->paymentServices->get($this->loggedUser->id);

        return response()->json([
            'payment' => $pix,
            'status' => 200
        ],200);

    }
    public function sendReceipt(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:59240',
        ]);

        return response()->json([
            'message' => ' Verificando recebimento de formulario',
            'status' => 202
        ], 202);
    }
    public function delete(int $id)
    {
        if(!$this->paymentServices->getDepositByWalletUser($this->loggedUser->id, $id))
        {
            return response()->json([
                'message' => 'Não foi encontrado deposito para delete...',
                'status' => 402
            ],402);
        }
        $this->paymentServices->delete($this->loggedUser->id, $id);

        return response()->json([
            'message' => 'Deletado com sucesso!',
            'status' => 202,
        ], 202);

    }
}
