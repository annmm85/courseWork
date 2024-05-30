<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function boxes(): HasMany
    {
        return $this->hasMany(Boxes::class);
    }
    public function publishs(): HasMany
    {
        return $this->hasMany(Publishs::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comments::class);
    }
    public function authors(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'subscribes','user_id','author_id');
    }
    public function user(): BelongsToMany
    {
        return $this->BelongsToMany(User::class, 'subscribes','author_id','user_id');
    }
    public function notifies(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Notifies::class, 'usernotifies', 'user_id', 'notify_id');
    }

}
