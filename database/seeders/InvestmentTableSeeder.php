<?php

namespace Database\Seeders;

use App\Helpers\InvestmentHelper;
use App\Models\Investment;
use App\Models\InvestmentPerfomance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvestmentTableSeeder extends Seeder
{
    use InvestmentHelper;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getInvestments() as $invest)
        {
            $month = 30;
            $inv = Investment::factory()->create([
                'name' => $invest['name'],
                'type' => $invest['type'],
                'annual_estimate' => $invest['profAnnual'],
                'monthly_estimate' => $invest['profMonthly'],
                'initial' => $invest['initial'],
            ]);
            $calcM = $invest['profMonthly']/$month;
            for($i=1;$i<=$month;$i++){
                InvestmentPerfomance::factory()->create([
                    'investment_id' => $inv->id,
                    'day' => $i,
                    'perfomance' => number_format($calcM,3)

                ]);
            }
        }
    }
}
