<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
           'fname'     => ''.$row[2],
            'mid_name'    => ''.$row[3], 
            'lname'    => ''.$row[4], 
            'type'    => 'CLIENT', 
            'section_id'    => ''.$row[8], 
            'name' => $row[2].''.$row[4],
            'password' => bcrypt($row[4].'@esmis')
        ]);
    }
}
