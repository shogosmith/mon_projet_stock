<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model {
    protected $fillable = [
        'inventory_id', 'product_id',
        'theoretical_quantity', 'physical_quantity', 'difference'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function inventory() {
        return $this->belongsTo(Inventory::class);
    }
}