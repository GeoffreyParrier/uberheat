<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CircProductConfiguration
 * @package App\Models
 * @mixin Builder
 */
class CircProductConfiguration extends ProductConfiguration
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        $fillable = [
            'diameter',
        ];
        $this->fillable = array_merge($fillable, $this->fillable);
        parent::__construct($attributes);
    }


    /**
     * @return float
     */
    public function getSurface(): float
    {
        return $this->depth * $this->diameter;
    }
}
