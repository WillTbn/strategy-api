<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Account;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class AccountServices
{
    use FileHelper;
    public function getByPerson(string $person):Account
    {
        $accountPerson = Account::where('person', $person)->first();
        return $accountPerson;
    }
    public function upAvatar(UploadedFile $avatar, int $id)
    {
        try{
            $account = Account::where('user_id',$id)->first();
            // $account->avatar = $this->setDocOrAudio($audio,$report->type,'audio', 'reports' );
            $account->avatar = $this->setDocOrAudio($avatar, $account->user_id, 'avatar', 'users');
            $account->saveOrFail();
            // $account = Account::update([
            //     'document' => $this->setDocOrAudio($document,$type,'document', 'reports' ),

            // ]);
            return response()->json([
                'message'=> 'Avatar alterado com sucesso!',
                'account' => $account,
                'status'=> 200
            ], 200);
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao atualizar avatar!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
}
