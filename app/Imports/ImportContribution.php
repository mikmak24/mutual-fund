<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Log;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;



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
           
            Contribution::create([
                'user_id' => $row['eclipse_id'],
                'employee_contribution' =>  $row['employee_contribution'],
                'employer_contribution' =>  $row['employer_contribution'],
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
