<?php

namespace Database\Seeders;

use App\Models\Emprestimo;
use App\Models\Usuario;
use App\Models\Equipamento;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmprestimoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();
        $equipamentos = Equipamento::all();

        // Empréstimo 1: Aluno com equipamento pendente
        Emprestimo::create([
            'user_id' => $usuarios->where('tipo', 'aluno')->first()->id,
            'equipamento_id' => $equipamentos->skip(0)->first()->id,
            'data_emprestimo' => Carbon::now()->subDays(3),
            'data_prevista_devolucao' => Carbon::now()->addDays(12),
            'data_devolucao' => null,
        ]);

        // Empréstimo 2: Professor com equipamento devolvido
        Emprestimo::create([
            'user_id' => $usuarios->where('tipo', 'professor')->first()->id,
            'equipamento_id' => $equipamentos->skip(1)->first()->id,
            'data_emprestimo' => Carbon::now()->subDays(20),
            'data_prevista_devolucao' => Carbon::now()->subDays(5),
            'data_devolucao' => Carbon::now()->subDays(4),
        ]);

        // Empréstimo 3: Aluno com equipamento atrasado
        Emprestimo::create([
            'user_id' => $usuarios->where('tipo', 'aluno')->skip(1)->first()->id,
            'equipamento_id' => $equipamentos->skip(2)->first()->id,
            'data_emprestimo' => Carbon::now()->subDays(10),
            'data_prevista_devolucao' => Carbon::now()->subDays(2),
            'data_devolucao' => null,
        ]);

        // Empréstimo 4: Professor com equipamento pendente
        Emprestimo::create([
            'user_id' => $usuarios->where('tipo', 'professor')->skip(1)->first()->id,
            'equipamento_id' => $equipamentos->skip(3)->first()->id,
            'data_emprestimo' => Carbon::now()->subDays(1),
            'data_prevista_devolucao' => Carbon::now()->addDays(29),
            'data_devolucao' => null,
        ]);

        // Empréstimo 5: Aluno com equipamento devolvido
        Emprestimo::create([
            'user_id' => $usuarios->where('tipo', 'aluno')->skip(2)->first()->id,
            'equipamento_id' => $equipamentos->skip(4)->first()->id,
            'data_emprestimo' => Carbon::now()->subDays(15),
            'data_prevista_devolucao' => Carbon::now()->subDays(1),
            'data_devolucao' => Carbon::now()->subDays(1),
        ]);

        // Empréstimo 6: Professor com equipamento recém devolvido
        Emprestimo::create([
            'user_id' => $usuarios->where('tipo', 'professor')->skip(2)->first()->id,
            'equipamento_id' => $equipamentos->skip(5)->first()->id,
            'data_emprestimo' => Carbon::now()->subDays(5),
            'data_prevista_devolucao' => Carbon::now(),
            'data_devolucao' => Carbon::now(),
        ]);
    }
}
