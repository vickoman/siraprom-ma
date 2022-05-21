<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    
        protected $fecha_inicial;
        protected $fecha_final;
    
        function __construct($fecha_inicial,$fecha_final) {
                $this->fecha_inicial = $fecha_inicial;
                $this->fecha_final = $fecha_final;
        }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if($this->fecha_inicial){
            $fecha_inicial = date('Y-m-d 00:00:00', strtotime($this->fecha_inicial));
            $fecha_final = date('Y-m-d 00:00:00', strtotime($this->fecha_final));
        return User::whereBetween('created_at', [$fecha_inicial, $fecha_final])->get();
    }
    else{
        return User::get();
    }

    }
}
