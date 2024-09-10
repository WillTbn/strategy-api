<?php

namespace App\Http\Controllers;

use App\Services\DepositReceiptServices;
use App\Services\PaymentServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private PaymentServices $paymentServices;
    private DepositReceiptServices $depositServices;
    private $loggedUser;
    public function __construct(
        PaymentServices $paymentServices,
        DepositReceiptServices $depositServices
    )
    {
        $this->paymentServices = $paymentServices;
        $this->depositServices = $depositServices;
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
            'transaction_id' => 'nullable|string|required_if:file,null',
            'id' => 'required|exists:deposit_receipts,id',
            'file' => 'required_if:transaction_id,null|file|mimes:pdf,jpg,jpeg,png|max:59240',
        ]);
        $payment = $this->depositServices->updateReceiptImage(
            $request->transaction_id,$request->id,$this->loggedUser->id, $request->file
        );
        return response()->json([
            'message' => 'Deposito atualizado com sucesso!',
            'payment' => $payment,
            'status' => 200
        ], 200);
    }
    public function getStatusWainting()
    {
        $waintings = $this->depositServices->getDepositByWarnig();
        return response()->json([
            'message' => 'Lista de depositos para avaliação!',
            'deposits' => $waintings,
            'status' => 200
        ], 200);
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
