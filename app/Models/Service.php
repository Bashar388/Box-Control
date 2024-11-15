<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable=['name','description','price','image','status'];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'service_category');
    }
    public function subscribers()
    {
        return $this->belongsToMany(User::class,'subscriptions', 'service_id', 'user_id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    public function blog()
    {
        return $this->hasOne(Blog::class);
    }

}
