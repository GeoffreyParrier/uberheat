<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class RectProductConfiguration extends ProductConfiguration
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diameter',
    ];

    /**
     * @return float
     */
    public function getSurface(): float
    {
        return $this->depth * $this->diameter;
    }

}
