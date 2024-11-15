<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function subscribedServices()
    {
        return $this->belongsToMany(Service::class,'subscriptions', 'user_id', 'service_id');
    }
    public function likedBlogs()
    {
        return $this->belongsToMany(Blog::class, 'likes', 'user_id', 'blog_id')->withTimestamps();
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
