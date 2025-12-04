<?php

namespace Database\Seeders;

use App\Models\Equipamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipamentoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Equipamentos de áudio/vídeo
        Equipamento::create([
            'nome' => 'Projetor Multimídia',
            'descricao' => 'Projetor para sala de aula com 3000 lúmens',
            'patrimonio' => '000000000001',
            'quantidade' => 1,
            'quantidade_disponivel' => 1,
            'status' => 'disponivel',
        ]);

        Equipamento::create([
            'nome' => 'Caixa de Som Amplificada',
            'descricao' => 'Caixa de som para eventos e apresentações',
            'patrimonio' => '000000000002',
            'quantidade' => 2,
            'quantidade_disponivel' => 2,
            'status' => 'disponivel',
        ]);

        Equipamento::create([
            'nome' => 'Câmera Digital',
            'descricao' => 'Câmera DSLR para fotografia e vídeo',
            'patrimonio' => '000000000003',
            'quantidade' => 3,
            'quantidade_disponivel' => 2,
            'status' => 'emprestado',
        ]);

        // Equipamentos de informática
        Equipamento::create([
            'nome' => 'Notebook Dell',
            'descricao' => 'Notebook para uso em aulas práticas',
            'patrimonio' => '000000000004',
            'quantidade' => 5,
            'quantidade_disponivel' => 3,
            'status' => 'emprestado',
        ]);

        Equipamento::create([
            'nome' => 'Tablet Samsung',
            'descricao' => 'Tablet de 10 polegadas para pesquisa',
            'patrimonio' => '000000000005',
            'quantidade' => 4,
            'quantidade_disponivel' => 4,
            'status' => 'disponivel',
        ]);

        Equipamento::create([
            'nome' => 'Impressora Multifuncional',
            'descricao' => 'Impressora para laboratório de informática',
            'patrimonio' => '000000000006',
            'quantidade' => 1,
            'quantidade_disponivel' => 1,
            'status' => 'disponivel',
        ]);

        // Equipamentos científicos
        Equipamento::create([
            'nome' => 'Microscópio Óptico',
            'descricao' => 'Microscópio para laboratório de biologia',
            'patrimonio' => '000000000007',
            'quantidade' => 3,
            'quantidade_disponivel' => 1,
            'status' => 'emprestado',
        ]);

        Equipamento::create([
            'nome' => 'Balança Digital',
            'descricao' => 'Balança de precisão para laboratório',
            'patrimonio' => '000000000008',
            'quantidade' => 2,
            'quantidade_disponivel' => 2,
            'status' => 'disponivel',
        ]);

        Equipamento::create([
            'nome' => 'Termômetro Infravermelho',
            'descricao' => 'Termômetro sem contato para medições',
            'patrimonio' => '000000000009',
            'quantidade' => 5,
            'quantidade_disponivel' => 0,
            'status' => 'emprestado',
        ]);

        // Equipamentos esportivos
        Equipamento::create([
            'nome' => 'Bola de Futsal',
            'descricao' => 'Bola de futsal oficial para treinos',
            'patrimonio' => '000000000010',
            'quantidade' => 10,
            'quantidade_disponivel' => 7,
            'status' => 'emprestado',
        ]);

        Equipamento::create([
            'nome' => 'Rede de Voleibol',
            'descricao' => 'Rede de voleibol com postes',
            'patrimonio' => '000000000011',
            'quantidade' => 2,
            'quantidade_disponivel' => 2,
            'status' => 'disponivel',
        ]);

        Equipamento::create([
            'nome' => 'Cronômetro Digital',
            'descricao' => 'Cronômetro para aulas de educação física',
            'patrimonio' => '000000000012',
            'quantidade' => 6,
            'quantidade_disponivel' => 4,
            'status' => 'emprestado',
        ]);
    }
}
