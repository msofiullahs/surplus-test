<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file',
        'enable'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_image', 'image_id', 'product_id');
    }
}
