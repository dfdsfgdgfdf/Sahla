<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LamaLama\Wishlist\HasWishlists;
use Laravel\Sanctum\HasApiTokens;
use Mindscms\Entrust\Traits\EntrustUserWithPermissionsTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, EntrustUserWithPermissionsTrait;
    use HasWishlists;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'mobile',
        'user_image',
        'status',
        'email',
        'password',
    ];

    protected $appends = ['full_name'];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFullNameAttribute(): string
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function status(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'user_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function cartProducts(): HasMany
    {
        return $this->hasMany(CartProduct::class, 'user_id', 'id')->latest();
    }
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'product_id', 'id');
    }
    public function maxLimit()
    {
        return $this->belongsTo(UserMaxLimit::class);
    }

    //Return product that still in shopping cart Before doing order of this products
//    public function shoppingCartProducts(): HasMany
//    {
//        return $this->hasMany(CartProduct::class, 'user_id', 'id')->where('status', 'shopping_cart');
//    }

    public function pendingOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id')
            ->where('status', 'pending')
            ->where('customer_status', 'waiting')
            ->latest();
    }
    public function completedOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id')
            ->where('status', 'completed')
            ->where('customer_status', 'waiting')
            ->latest();
    }
}
