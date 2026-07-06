<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'order_number', 'supplier_id', 'user_id',
        'status', 'total', 'notes'
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}