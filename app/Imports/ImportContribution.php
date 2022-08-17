<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Log;

class ImportContribution implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::alert("-=-=-=-=-=-=-=-=-=-=-=-=");
        Log::alert($row);
        dd();
    }
}
