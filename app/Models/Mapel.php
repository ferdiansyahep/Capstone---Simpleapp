<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_mapel',
        'kelas',
        'kode_mapel',
        'user_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'mapel_user', 'mapel_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->hasMany(Category::class);
    }
}
