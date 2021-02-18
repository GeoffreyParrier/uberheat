<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class RectProductConfiguration
 * @package App\Models
 * @mixin Builder
 */
class RectProductConfiguration extends ProductConfiguration
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        $fillable = [
            'width',
            'height',
            'thickness',
        ];
        $this->fillable = array_merge($fillable, $this->fillable);
        parent::__construct($attributes);
    }


    /**
     * @return float
     */
    public function getSurface(): float
    {
        return $this->width * $this->height;
    }

}
