<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pergunta
 *
 * @property $id
 * @property $pergunta
 * @property $categoria_id
 * @property $tipo
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Categoria $categoria
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Pergunta extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pergunta', 'categoria_id', 'tipo', 'user_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo(\App\Models\Categoria::class, 'categoria_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
