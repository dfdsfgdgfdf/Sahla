<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class Unit extends Model
{

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
