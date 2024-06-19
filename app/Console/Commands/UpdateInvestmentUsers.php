<?php

namespace App\Console\Commands;

use App\Helpers\InvestmentHelper;
use App\Models\UserInvestment;
use App\Models\UserWallet;
use App\Services\UserWalletServices;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateInvestmentUsers extends Command
{
    use InvestmentHelper;
    private UserWalletServices $userWalletServices;
    public function __construct(
        UserWalletServices $userWalletServices
    )
    {
        parent::__construct();
        $this->userWalletServices = $userWalletServices;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-investment-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualizando carteira de investimento dos clientes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->userWalletServices->actionUpdateWalletInvestment();
        } catch (\Exception $e) {
            $this->error('Error: '.$e);
        }
        // $this->userWalletServices->actionUpdateWalletInvuserestment();
    }
}
