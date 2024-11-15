<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable=['title','content','image','status','category_id','service_id'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'blog_id', 'user_id')->withTimestamps();
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
