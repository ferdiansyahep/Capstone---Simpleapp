<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question_text', 'category_id'];

    public function questionOptions()
    {
        return $this->hasMany(Option::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function answeredQuestions()
    {
        return $this->hasMany(AnsweredQuestion::class);
    }
}
