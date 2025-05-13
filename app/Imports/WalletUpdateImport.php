<?php

namespace App\Imports;

use App\Models\Account;
use App\Models\UserIncome;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WalletUpdateImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $chunk = 1000;
    /**
     * @var array
     */
    public $investments =  [
        [
            'name' => 'Investimento Personalizado',
            'value' => 'investimento_personalizado',
            'data_info' => 'personalizado_no_ultimo_mes',
        ],
        [
            'name' => 'Expansão Patrimonial',
            'value' => 'expansao_patrimonial',
            'data_info' => 'patrimonial_no_ultimo_mes',
        ],
        [
            'name' => 'Reserva de emergência',
            'value' => 'reserva_de_emergencia',
            'data_info' => 'emergencia_no_ultimo_mes',
        ]
    ];
    public function chunkSize(): int
    {
        return $this->chunk;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if(Account::where('person', $row['conta'])->exists()){
                $account = Account::where('person', $row['conta'])->first();
                Log::info('Account found: ' . $account);
                $account->userWallet()->update([
                    'current_investment' => $row['carteira'],
                    'updated_at' => now(),
                ]);
                foreach($this->investments as $investment) {
                    if($row[$investment['value']]){
                        Log::info('row: ' . $row);
                        if($account->userIncomes()->where('origin_name', $investment['name'])->exists()){
                            UserIncome::updateOrCreate(
                                [
                                    'user_id' => $account->user_id,
                                    'origin_name' => $investment['name'],
                                ],
                                [
                                    'value' => $row[$investment['value']],
                                    'data_info' => $row[$investment['data_info']],
                                    'updated_at' => now(),
                                ]
                            );

                            Log::info('Updating investment data for user: ' . $account->user_id);
                        } else {
                            UserIncome::create([
                                'user_id' => $account->user_id,
                                'origin_name' => $investment['name'],
                                'value' => $row[$investment['value']],
                                'data_info' => $row[$investment['data_info']],
                                'created_at' => now(),
                                'date_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }

                    }
                }
            }
        }
    }
}
