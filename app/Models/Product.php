<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Nicolaslopezj\Searchable\SearchableTrait;
use Freshbitsweb\LaravelCartManager\Traits\Cartable;

class Product extends Model
{
    use SearchableTrait;
    use Sluggable;
    use Cartable;

    protected $guarded = [];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name_ar',
                'source' => 'name_en',
                'source' => 'name_ur'
            ]
        ];
    }

    protected $searchable = [
        'columns' => [
            'products.name_ar'          => 10,
            'products.name_en'          => 10,
            'products.name_ur'          => 10,
            'products.description_ar'   => 10,
            'products.description_en'   => 10,
            'products.description_ur'   => 10,
        ],
    ];

    public function getName()
    {
        return $this->name_ar != '' ? $this->name_ar : ($this->name_en != '' ? $this->name_en : $this->name_ur );
    }

    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function featured()
    {
        return $this->featured ? 'YES' : 'NO';
    }

    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function scopeHasQuantity($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeActiveCategory($query)
    {
        return $query->whereHas('category', function ($query) {

            $query->whereStatus(1);
        });
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function tags(): MorphToMany
    {
        return $this->MorphToMany(Tag::class, 'taggable');
    }
    //علشان يجيب اول صوره تحمل الاسم يتاع البودكت
    public function firstMedia(): MorphOne
    {
        return $this->MorphOne(Media::class, 'mediable')->orderBy('file_sort', 'asc');
    }
    public function media(): MorphMany
    {
        return $this->MorphMany(Media::class, 'mediable');
    }
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class)->orderBy('id', 'desc');
    }
    public function units(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }

    public function cartProducts(): HasMany
    {
        return $this->hasMany(CartProduct::class, 'product_id', 'id');
    }
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'product_id', 'id');
    }

    public function avgRatings()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id')
            ->avg('rating');
    }

    // public function orders(): BelongsToMany
    // {
    //     return $this->belongsToMany(Order::class)->withPivot('quantity');
    // }

}
