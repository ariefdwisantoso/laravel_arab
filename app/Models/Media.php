<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table      = "media";
    protected $primaryKey = "id";
    public    $timestamps = true;

    // Relasi: Media hanya memiliki satu Theme
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id', 'id');
    }
}
