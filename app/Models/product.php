<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = [
        'name', 'reference', 'description', 'price',
        'quantity', 'alert_quantity', 'category_id',
        'supplier_id', 'image', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'decimal:2'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function stockMovements() {
        return $this->hasMany(StockMovement::class);
    }

    public function isLowStock(): bool {
        return $this->quantity <= $this->alert_quantity;
    }
}