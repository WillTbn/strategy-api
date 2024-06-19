<?php

namespace App\Console\Commands;

use App\Helpers\InvestmentHelper;
use App\Services\Actions\Wallet\UpdatewalletActions;
use Illuminate\Console\Command;

class UpdateInvestmentUsers extends Command
{
    use InvestmentHelper;
    // private UserWalletServices $userWalletServices;
    private UpdateWalletActions $updateWalletActions;
    public function __construct(
        UpdateWalletActions $updateWalletActions
    )
    {
        parent::__construct();
        $this->updateWalletActions = $updateWalletActions;
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
            $this->updateWalletActions->updateExec();
        } catch (\Exception $e) {
            $this->error('Error: '.$e);
        }
        // $this->userWalletServices->actionUpdateWalletInvuserestment();
    }
}
