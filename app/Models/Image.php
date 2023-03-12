<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file',
        'enable'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_image', 'image_id', 'product_id');
    }
}
