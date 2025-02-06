<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionOption
 *
 * @property $id
 * @property $question_id
 * @property $option_text
 * @property $created_at
 * @property $updated_at
 *
 * @property Question $question
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class QuestionOption extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['question_id', 'option_text'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class, 'question_id', 'id');
    }
    
}
