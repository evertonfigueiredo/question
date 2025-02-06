<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Question
 *
 * @property $id
 * @property $content
 * @property $survey_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Survey $survey
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Question extends Model
{

    protected $perPage = 20;

    const TYPE_RADIO = 'radio';
    const TYPE_OPEN = 'open';
    const TYPE_MULTIPLE = 'multiple';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['content', 'survey_id', 'type'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function answers()
    {
        return $this->hasMany(ResponseAnswer::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
