<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    use HasFactory;
    protected $fillable=[
        'invoice_number' ,
        'invoice_id' ,
        'product',
        'section',
        'status' ,
        'value_status' ,
        'note' ,
        'user',
        'Payment_Date'
    ];

    
    public function invoice()
    {
        return $this->belongsTo(invoices::class);
    }
}
