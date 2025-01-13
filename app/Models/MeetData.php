<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetData extends Model
{
    use HasFactory;
    protected $table = 'meet_data';
    protected $fillable = [
        'user_id', 'name', 'agenda' , 'date', 'attend', 'file', 'record','to_do',  'cust_to_do', 'nas_link', 'place','created_by'
    ];

    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
