<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMaxLimit extends Model
{
    use HasFactory;

    protected $table = 'user_max_limit';

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
