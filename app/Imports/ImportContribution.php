<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Log;
use App\Models\EmployeeContribution;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\MasterAccount;
use App\Models\EmployeeNotification;


class ImportContribution implements ToModel,  WithHeadingRow, WithChunkReading, ShouldQueue, WithBatchInserts, WithCalculatedFormulas, WithStartRow
{
    private $date_of_contribution;
    private $i;

    public function __construct($date_of_contribution)
    {
        $this->date_of_contribution = $date_of_contribution;
        $this->i = 1;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            // $employee_salary_in_peso =  Currency::convert()
            // ->from('USD')
            // ->to('PHP')
            // ->amount($row['employee_salary'])
            // ->get();

            // $employee_contr_in_peso = ($row['employee_contribution']* $employee_salary_in_peso) / 100;
            // $employee_contr_in_usd = Currency::convert()
            // ->from('PHP')
            // ->to('USD')
            // ->amount($employee_contr_in_peso)
            // ->get();

            // $employer_contr_in_peso = ($row['employer_contribution']* $employee_salary_in_peso) / 100;
            // $employer_contr_in_usd = Currency::convert()
            // ->from('PHP')
            // ->to('USD')
            // ->amount($employer_contr_in_peso)
            // ->get();

            $master_account_amount = MasterAccount::select('master_account_amount')->get();
            $totalMasterAccount = $master_account_amount[0]['master_account_amount'] + ($row['employee_contribution'] +  $row['employer_contribution']);
            MasterAccount::find(1)->update(['master_account_amount' => $totalMasterAccount]);

            EmployeeContribution::create([
                'username' => $row['eclipse_id'],
                'employee_contribution' =>  $row['employee_contribution'],
                'employer_contribution' =>  $row['employer_contribution'],
                'employee_gained' =>  ($row['employee_contribution'] +  $row['employer_contribution']),
                'date_of_contribution' =>  $this->date_of_contribution,
                'uploaded_by' => Auth::user()->username
            ]);

            EmployeeNotification::create([
                'from' => Auth::user()->username,
                'to' =>   $row['eclipse_id'],
                'message' =>  'Admin ' .  Auth::user()->username . ' uploaded a new contribution at ' . $this->date_of_contribution,
                'is_read' =>  false,
            ]);

            $this->i++;
            

        }catch(\Exception $e){
            Log::alert($e);
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
