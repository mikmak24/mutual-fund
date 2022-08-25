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



class ImportContribution implements ToModel,  WithHeadingRow, WithChunkReading, ShouldQueue, WithBatchInserts, WithCalculatedFormulas, WithStartRow
{
    private $date_of_contribution;

    public function __construct($date_of_contribution)
    {
        $this->date_of_contribution= $date_of_contribution;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {

            $employee_contr_in_peso = ($row['employee_contribution']*$row['employee_salary']) / 100;
            $employee_contr_in_usd = Currency::convert()
            ->from('PHP')
            ->to('USD')
            ->amount($employee_contr_in_peso)
            ->get();

            $employer_contr_in_peso = ($row['employer_contribution']*$row['employee_salary']) / 100;
            $employer_contr_in_usd = Currency::convert()
            ->from('PHP')
            ->to('USD')
            ->amount($employer_contr_in_peso)
            ->get();

            EmployeeContribution::create([
                'username' => $row['eclipse_id'],
                'employee_contribution' =>  $employee_contr_in_usd,
                'employer_contribution' =>  $employer_contr_in_usd,
                'employee_gained' =>  ($employee_contr_in_usd +  $employer_contr_in_usd),
                'date_of_contribution' =>  $this->date_of_contribution,
                'uploaded_by' => Auth::user()->username
            ]);

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
