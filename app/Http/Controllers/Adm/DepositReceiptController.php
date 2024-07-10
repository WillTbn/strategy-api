<?php

namespace App\Http\Controllers\Adm;

use App\DataTransferObject\Deposit\DepositDTO;
use App\Http\Controllers\Controller;
use App\Services\DepositReceiptServices;
use Illuminate\Http\Request;

class DepositReceiptController extends Controller
{
    private DepositReceiptServices $depositReceiptServices;
    public function __construct(
        DepositReceiptServices $depositReceiptService,
    )
    {
        $this->depositReceiptServices = $depositReceiptService;
    }
    public function updateConfirm(Request $request)
    {
        $depositDTO = new DepositDTO(...$request->only([
            'user_id',
            'wallet_id',
            'transaction_code',
            'transaction_id',
            'receipt_image',
            'status',
            'note'
        ]));
        $response = $this->depositReceiptServices->setDepositChange($depositDTO);
        return response()->json([
            'message' => 'Deposito atualizado com sucesso!',
            'deposit' => $response,
            'status' => 200
        ], 200);
    }
}
