<?php

namespace App\Services;

use App\Enum\StatusDeposit;
use App\EssentialUtil\PixGenerate;
use App\Models\DepositReceipt;
use App\Models\UserWallet;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentServices
{

    public function getPix( float $amount, int $user_id, bool $investment)
    {
        $pix = new PixGenerate();
        $code_id = substr(uniqid(rand()), 0, 5);
        $pix->setPixKey('15245342774');
        $pix->setDescription($investment);
        $pix->setMerchantName(env('PIX_MERCHANTNAME', 'Jorge Luiz'));
        $pix->setAmount($amount);
        $pix->setMerchantCity(env('PIX_MERCHANTCITY'));
        $pix->setTxid($user_id.$code_id);
        $payloadQrcode = $pix->getPayload();
        try{
            DB::beginTransaction();
            $wallet  =$this->getWalletByUser($user_id);
            $newWallet = new DepositReceipt();
            $newWallet->user_wallet_id = $wallet->id;
            $newWallet->investment = $investment;
            $newWallet->value = $amount;
            $newWallet->status = StatusDeposit::Wainting;
            $newWallet->transaction_code = $code_id;
            $newWallet->qrcode = $payloadQrcode;
            $newWallet->saveOrFail();
            DB::commit();
            return $newWallet;
        }catch(Exception $e){
            DB::rollBack();
            Log::error('exception'.$e);
            return response()->json([
                'message' =>  'Erro ao inserta dados no banco',
                'exception' => $e,
                'status' => 500
            ], 500);
        }

        // dd($payloadQrcode);
        // $pix->generateQrCode();
        // return $payloadQrcode;
    }
    public function getWalletByUser(int $user_id):UserWallet
    {
        $wallet = UserWallet::where('user_id', $user_id)->first();
        return  $wallet;

    }
    public function getDepositByWalletUser( int $user_id, int $id):DepositReceipt | null
    {
        $wallet = $this->getWalletByUser($user_id);
        $deposit = $wallet->DepositReceipts->where('id', $id)->first();
        return $deposit;
    }
    public function get(int $user_id)
    {
        try{
            DB::beginTransaction();
            $payment = $this->getWalletByUser($user_id);
            $deposit = DepositReceipt::where('user_wallet_id', $payment->id)->where('status', '!=', StatusDeposit::Confirmed)->first();

            return $deposit;
        }catch(Exception $e){
            DB::rollBack();
            Log::error('exception'.$e);
            return response()->json([
                'message' =>  'Erro ao pegar dados no banco',
                'exception' => $e,
                'status' => 500
            ], 500);
        }

    }
    public function delete(int $user_id, int $id )
    {
        try{
            DB::beginTransaction();
            $deposit = $this->getDepositByWalletUser($user_id, $id);
            $deposit->deleteOrFail();

            DB::commit();
            // $deposit = DepositReceipt::where('user_wallet_id', $payment->id)->where('status', '!=', StatusDeposit::Confirmed)->first();

            // return $deposit;
        }catch(Exception $e){
            DB::rollBack();
            Log::error('exception'.$e);
            return response()->json([
                'message' =>  'Erro ao pegar dados no banco',
                'exception' => $e,
                'status' => 500
            ], 500);
        }

    }
}
