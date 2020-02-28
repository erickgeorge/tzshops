<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;



{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
           'fname'     => $row['fname'].''.$row['lname'],
            'mid_name'    => ''.$row['mname'], 
            'lname'    => ''.$row['lname'],
            'section_id'    => ''.$row['id'], 
            'name' => $row['fname'].''.$row['lname'],
            'password' => bcrypt($row['lname'].'@esmis')
        ]);
    }
} 
