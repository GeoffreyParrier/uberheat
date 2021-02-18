<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ProductConfiguration
 * @package App\Models
 * @mixin Builder
 */
abstract class ProductConfiguration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'depth',
        'db_1',
        'db_2',
        'db_5',
        'db_10'
    ];

    /**
     * @return float
     */
    abstract public function getSurface(): float;

    /**
     * Get all connected products
     * @return BelongsToMany
     */
    public function getProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
