<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'invoice_number' ,
        'invoice_date' ,
        'due_date' ,
        'product',
        'section_id',
        'Amount_collection' ,
        'Amount_Commission' ,
        'discount' ,
        'value_vat',
        'rate_vat',
        'Total' ,
        'status' ,
        'value_status' ,
        'note' ,
        'Payment_Date'
    ];
    protected $dates=['deleted_at'];

    public function section()
    {
        return $this->belongsTo(sections::class);
    }
}
