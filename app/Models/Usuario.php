<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'nome',
        'matricula',
        'tipo'
    ];

    
    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }
}
