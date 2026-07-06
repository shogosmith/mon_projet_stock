<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model {
    protected $fillable = ['reference', 'user_id', 'status', 'notes'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(InventoryItem::class);
    }
}