<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'patrimonio',
        'quantidade',
        'quantidade_disponivel',
        'status'
    ];

    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }

    // Verificar se há quantidade disponível
    public function temDisponivel($quantidade = 1)
    {
        return $this->quantidade_disponivel >= $quantidade;
    }

    // Reduzir quantidade disponível ao emprestar
    public function emprestar($quantidade = 1)
    {
        if ($this->temDisponivel($quantidade)) {
            $this->decrement('quantidade_disponivel', $quantidade);
            return true;
        }
        return false;
    }

    // Aumentar quantidade disponível ao devolver
    public function devolver($quantidade = 1)
    {
        if (($this->quantidade_disponivel + $quantidade) <= $this->quantidade) {
            $this->increment('quantidade_disponivel', $quantidade);
            return true;
        }
        return false;
    }

    // Atualizar status baseado na disponibilidade
    public function atualizarStatus()
    {
        $this->status = $this->quantidade_disponivel > 0 ? 'disponivel' : 'emprestado';
        $this->save();
    }
}
