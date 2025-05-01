<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SbirFund05 extends Model
{
    use HasFactory;
    protected $table = 'sbir_fund05';
    protected $fillable = [
        'project_id',
        'user_id',
        'equipment_name',
        'asset_number',
        'purchase_amount',
        'purchase_date',
        'monthly_fee',
        'book_value',
        'set_count',
        'remaining_years',
        'investment_months',
        'total'
    ];
}
