<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model {
    protected $fillable = [
        'invoice_id', 'product_id', 'description',
        'quantity', 'unit_price', 'total'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }
}