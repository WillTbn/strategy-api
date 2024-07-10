<?php

namespace App\DataTransferObject\Deposit;

use App\DataTransferObject\AbstractDTO;
use App\DataTransferObject\InterfaceDTO;
use App\Enum\StatusDeposit;
use App\Enum\TransictionStatus;
use App\Helpers\FileHelper;
use App\Rules\CodeTransactionBelongsToWallet;
use App\Rules\VerifyStatusDeposit;
use App\Rules\WalletBelongsToUser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DepositDTO extends AbstractDTO implements InterfaceDTO
{
    use FileHelper;
    public function __construct(
        public readonly ?int  $user_id =null,
        public readonly ?int $wallet_id = null,
        public readonly ?string  $transaction_id =null,
        public readonly ?string  $transaction_code =null,
        public readonly ?UploadedFile  $receipt_image =null,
        public readonly ?string  $status = null,
        public readonly ?string  $note = null,
        // private InvestmentServices $investmentServices,
    )
    {
        $this->validate();
    }
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'wallet_id' => [
                'required','integer','exists:user_wallets,id',
                new WalletBelongsToUser($this->user_id)
            ],
            'transaction_code' => [
                'required','exists:deposit_receipts,transaction_code',
                new CodeTransactionBelongsToWallet($this->wallet_id)
            ],
            'transaction_id' => 'string|nullable',
            'receipt_image' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:49240',
            'status'=> ['required', Rule::enum(StatusDeposit::class)],
            'note' => [
                new VerifyStatusDeposit($this->status),
                // 'nullable'

            ]
            // 'person' => 'required|unique:accounts',
        ];
    }
    public function getTransactionId()
    {
        Log::info('Estou aqui ....'.$this->transaction_id);
        if(!$this->transaction_id && !$this->receipt_image){
            return TransictionStatus::DIADNR;
        }
        if(!$this->transaction_id && $this->receipt_image){
            return TransictionStatus::DIADWR;
        }
        if($this->transaction_id){
            return TransictionStatus::DIADWR;
        }
        if($this->transaction_id){
            return $this->transaction_id;
        }
    }
    public function getUserId():int
    {
        return (int)$this->user_id;
    }
    public function getImage():string|null
    {
        return !$this->receipt_image ? $this->receipt_image : $this->setDoc( $this->receipt_image, $this->getUserId(), 'users', 'receipt');
    }
    public function getStatus():string
    {
        return $this->status;
    }
    public function messages(): array
    {
        return[];
    }
    public function validator(): Validator
    {
        return validator($this->toArray(), $this->rules(), $this->messages());
    }
    public function validate():array
    {
        return $this->validator()->validate();
    }
}
