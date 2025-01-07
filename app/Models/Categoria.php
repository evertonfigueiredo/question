<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Categoria
 *
 * @property $id
 * @property $user_id
 * @property $name
 * @property $padrao
 * @property $resposta
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property Pergunta[] $perguntas
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Categoria extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'name', 'padrao', 'resposta'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function perguntas()
    {
        return $this->hasMany(\App\Models\Pergunta::class, 'id', 'categoria_id');
    }
    
}
