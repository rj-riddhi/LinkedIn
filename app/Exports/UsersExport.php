<?php

namespace App\Exports;

use App\Models\Usermodel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return[
            'Id',
            'Name',
            'Email',
            'Password',
            'Phone',
            'Profile',
            'Created_at',
            'Updated_at' 
        ];
    } 

    public function collection()
    {
        return Usermodel::all();
    }
}