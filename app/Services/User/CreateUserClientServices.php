<?php

namespace App\Services\User;

use App\DataTransferObject\Users\ClientDTO;
use App\Exceptions\PatternMessageException;
use App\Models\Repository\Eloquent\UserRepositoryEloquent;
use App\Models\User;
use App\Services\Service;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateUserClientServices extends Service
{
    /**
     *  ClientDTO DataTranferObject
     *  @client
     */
    public ClientDTO $clientData;
    /**
     *  User
     *  @userData
     */
    public User $userData;

    /**
     * setando the array client and get datas
     */
    public function setClientData(array $client):void
    {
        $this->clientData = new ClientDTO();
        $this->clientData->setName($client['name']);
        $this->clientData->setCurrentBalance($client['current_balance']);
        $this->clientData->setLastMonth($client['last_month']);
        $this->clientData->setAddressCity($client['address_city']);
        $this->clientData->setAddressNumber($client['address_number']);
        $this->clientData->setAddressState($client['address_state']);
        $this->clientData->setAddressDistrict($client['address_district']);
        $this->clientData->setAddressStreet($client['address_street']);
        $this->clientData->setAddressZipCode($client['address_zip_code']);
        $this->clientData->setBirthday($client['birthday']);
        $this->clientData->setEmail($client['email']);
        $this->clientData->setGenre($client['genre']);
        $this->clientData->setPerson($client['person']);
        $this->clientData->setPhone($client['phone']);
        $this->clientData->setNotifications($client['notifications']);
    }
    public function getClientData():ClientDTO
    {
        return $this->clientData;
    }
    public function setUserData(User $user):void
    {
        $this->userData = $user;
    }
    public function getUserData():User
    {
        return $this->userData;
    }
     /**
     * Execute from create User Client
     * @return CreateProductServices|PatternMessageException
     */
    public function execute(): CreateUserClientServices|PatternMessageException
    {
        try{
            DB::beginTransaction();
            $userRepository = new UserRepositoryEloquent();
            $user = $userRepository->createClient($this->getClientData());
            $this->setUserData($user);
            DB::commit();
            return $this;
        }catch(Exception $e){
            DB::rollBack();
            Log::error('Erro : '.json_encode($e));
            throw new PatternMessageException(message:'Erro ao atualiza registro do produto.');
        }
    }
}
