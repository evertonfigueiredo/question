<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Survey
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $created_at
 * @property $updated_at
 *
 * @property Question[] $questions
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Survey extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'description', 'slug', 'user_id'];

    // Gerar slug automaticamente antes de salvar
    public static function boot()
    {
        parent::boot();

        static::creating(function ($survey) {
            if (empty($survey->slug)) {
                // Gerar o slug com base no título da pesquisa
                $survey->slug = Str::slug($survey->title);
            }
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'survey_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
