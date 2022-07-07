<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alias extends Model
{
    use HasFactory;

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
