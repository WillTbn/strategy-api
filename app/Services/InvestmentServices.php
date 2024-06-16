<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Account;
use App\Models\Investment;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvestmentServices
{
    public function getInitialId(): int
    {
        $response = Investment::where('initial', true)->first();
        return $response->id;
    }
}
