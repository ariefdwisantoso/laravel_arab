<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table      = "theme";
    protected $primaryKey = "id";
    public    $timestamps = true;

    // Relasi: Theme memiliki banyak Media
    public function media()
    {
        return $this->hasMany(Media::class, 'theme_id', 'id');
    }
}
