<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessData extends Model
{
    use HasFactory;
    protected $table = "process_emission_data";
    protected $fillable = ['customer_id','branch_id','year'];


    public function branch_data()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

}
