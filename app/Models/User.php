<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nomer_induk',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kelas',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];    

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function isAdmin()
    {
        return $this->roles()->where('title', 'admin')->exists();
    }

    public function userResults()
    {
        return $this->hasMany(Result::class);
    }

    public function user()
    {
        return $this->hasMany(Category::class, 'user_id');
    }

    public function mapel()
    {
        return $this->hasMany(Mapel::class);
    }
    
    public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'mapel_user', 'user_id', 'mapel_id');
    }

    public function answeredQuestions()
    {
        return $this->hasMany(AnsweredQuestion::class);
    }

}
