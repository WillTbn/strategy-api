<?php

namespace App\Models\Repository;

use App\DataTransferObject\Users\ClientDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository
{
    // public function all():int|Collection;
    // public function getByEmail(string $email):?User;
    public function createClient(ClientDTO $client):User;
}
