<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name','description'];
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_category');
    }
}
