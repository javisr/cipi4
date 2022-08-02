<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'site',
        'domain',
        'php',
        'username',
        'path',
    ];

    public function aliases()
    {
        return $this->hasMany(Alias::class)
                    ->orderBy('domain');
    }
}
