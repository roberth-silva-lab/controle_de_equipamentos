<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar alunos
        Usuario::create([
            'nome' => 'João Silva',
            'matricula' => '0001',
            'tipo' => 'aluno',
        ]);

        Usuario::create([
            'nome' => 'Maria Santos',
            'matricula' => '0002',
            'tipo' => 'aluno',
        ]);

        Usuario::create([
            'nome' => 'Pedro Oliveira',
            'matricula' => '0003',
            'tipo' => 'aluno',
        ]);

        Usuario::create([
            'nome' => 'Ana Costa',
            'matricula' => '0004',
            'tipo' => 'aluno',
        ]);

        Usuario::create([
            'nome' => 'Lucas Ferreira',
            'matricula' => '0005',
            'tipo' => 'aluno',
        ]);

        // Criar professores
        Usuario::create([
            'nome' => 'Prof. Carlos Mendes',
            'matricula' => '1001',
            'tipo' => 'professor',
        ]);

        Usuario::create([
            'nome' => 'Prof. Fernanda Dias',
            'matricula' => '1002',
            'tipo' => 'professor',
        ]);

        Usuario::create([
            'nome' => 'Prof. Roberto Lima',
            'matricula' => '1003',
            'tipo' => 'professor',
        ]);
    }
}
