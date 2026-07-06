<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {
    protected $fillable = [
        'invoice_number', 'client_id', 'user_id',
        'status', 'subtotal', 'tax', 'total',
        'notes', 'due_date'
    ];

    protected $casts = ['due_date' => 'date'];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(InvoiceItem::class);
    }
}