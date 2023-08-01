<?php

namespace App\Imports;

use App\Models\Smtp;
use Maatwebsite\Excel\Concerns\ToModel;

class SmtpImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $data)
    {
        return new Smtp([
            'host_name' => $data[0],
            'imap_port' => $data[1],
            'from_email' => $data[2],
            'email_pass' => $data[3],
            'emails' => $data[4],
        
        ]);
    }
}
