<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use SoftDeletes;

    protected $fillable = ['subject', 'body'];


    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
