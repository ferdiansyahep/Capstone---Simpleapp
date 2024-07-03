<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnsweredQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'selected_option_id',
        'is_correct',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relasi ke model Option
    public function selectedOption()
    {
        return $this->belongsTo(Option::class, 'selected_option_id');
    }
}
