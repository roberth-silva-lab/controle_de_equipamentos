<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    protected $fillable = [
        'user_id',
        'equipamento_id',
        'data_emprestimo',
        'data_prevista_devolucao',
        'data_devolucao'
    ];

    //cada emprestimo vai pertencer a apenas um usuário
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
    

    //cada emprestimo vai pertencer a um equipamento 
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }

}
