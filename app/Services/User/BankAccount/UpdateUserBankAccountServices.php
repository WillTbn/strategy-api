<?php

namespace App\Services\User\BankAccount;

use App\DataTransferObject\Users\ClientDTO;
use App\DataTransferObject\Users\UserBankAccountDTO;
use App\Exceptions\PatternMessageException;
use App\Models\Repository\Eloquent\BankRepositoryEloquent;
use App\Models\Repository\Eloquent\UserRepositoryEloquent;
use App\Models\User;
use App\Models\UserBankAccount;
use App\Services\Service;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUserBankAccountServices extends Service
{
    /**
     *  USerBankAccountDTO DataTranferObject
     *  @userBanckAccountDto
     */
    public UserBankAccountDTO $userBanckAccountDto;
    /**
     *  Bank
     *  @userBank
     */
    public UserBankAccount $userBank;

    /**
     * setando the array client and get datas
     */
    public function setBankData(array $bank):void
    {
        $this->userBanckAccountDto = new UserBankAccountDTO();
        $this->userBanckAccountDto->setBank($bank['bank']);
        $this->userBanckAccountDto->setUserId($this->getUserBank()->user_id);
        $this->userBanckAccountDto->setAgency($bank['agency']);
        $this->userBanckAccountDto->setNumber($bank['number']);
        $this->userBanckAccountDto->setNickname($bank['nickname'] ?? null );
        $this->userBanckAccountDto->setMainAccount($bank['main_account'] ?? null);
    }
    public function getBankData():UserBankAccountDTO
    {
        return $this->userBanckAccountDto;
    }
    public function setUserBank(UserBankAccount $userBank):void
    {
        $this->userBank = $userBank;
    }
    public function getUserBank():UserBankAccount
    {
        return $this->userBank;
    }
    /**
     * @return UpdateUserBankAccountServices|PatternMessageException
     */
    public function execute():UpdateUserBankAccountServices|PatternMessageException
    {
        try{
            $bankRepository = new BankRepositoryEloquent();
            $bankRepository->update($this->getBankData(), $this->getUserBank());

            return $this;
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Erro : '.json_encode($e));
            throw new PatternMessageException(message:'Erro ao atualiza dados bancários.', code:500);
        }
    }
}
