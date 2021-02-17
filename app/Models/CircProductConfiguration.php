<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CircProductConfiguration extends ProductConfiguration
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'width',
        'height',
        'thickness',
    ];

    /**
     * @return float
     */
    public function getSurface(): float
    {
        return $this->width * $this->height;
    }
}
