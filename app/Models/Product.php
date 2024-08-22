<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'site_category', 'category_id', 'price', 'stock'];

    public function category() {
    	return $this->belongsTo(Category::class);
    }
}
