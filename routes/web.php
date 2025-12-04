<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\EmprestimoController;


Route::get('/', function () {
    return redirect()->route('usuarios.inicio');
});

//rotas do usuarios
Route::get('/usuarios', [UsuarioController::class, 'index'])
    ->name('usuarios.inicio');

//rotas para CRUD de usuarios exceto index
Route::resource('usuarios', UsuarioController::class)->except(['index']);

//rotas para relatorio de usuarios
Route::get('/relatorio/usuarios', [UsuarioController::class, 'relatorio'])
    ->name('usuarios.relatorio');


    //rotas do equipamentos
Route::get('/equipamentos', [EquipamentoController::class, 'index'])
    ->name('equipamentos.inicio');

// Criar novo equipamento
Route::get('/equipamentos/criar', [EquipamentoController::class, 'create'])
    ->name('equipamentos.criar');
Route::post('/equipamentos', [EquipamentoController::class, 'store'])
    ->name('equipamentos.store');

// Editar equipamento
Route::get('/equipamentos/{id}/editar', [EquipamentoController::class, 'edit'])
    ->name('equipamentos.editar');
Route::put('/equipamentos/{id}', [EquipamentoController::class, 'update'])
    ->name('equipamentos.update');

// Excluir equipamento
Route::delete('/equipamentos/{id}', [EquipamentoController::class, 'destroy'])
    ->name('equipamentos.destroy');

// Relatório de equipamentos
Route::get('/relatorio/equipamentos', [EquipamentoController::class, 'relatorio'])
    ->name('equipamentos.relatorio');




// rotas dos emprestimos
Route::get('/emprestimos', [EmprestimoController::class, 'index'])
    ->name('emprestimos.inicio');

// Criar novo empréstimo
Route::get('/emprestimos/criar', [EmprestimoController::class, 'create'])
    ->name('emprestimos.criar');
Route::post('/emprestimos', [EmprestimoController::class, 'store'])
    ->name('emprestimos.store');

// Editar empréstimo
Route::get('/emprestimos/{id}/editar', [EmprestimoController::class, 'edit'])
    ->name('emprestimos.editar');
Route::put('/emprestimos/{id}', [EmprestimoController::class, 'update'])
    ->name('emprestimos.update');

// Excluir empréstimo
Route::delete('/emprestimos/{id}', [EmprestimoController::class, 'destroy'])
    ->name('emprestimos.destroy');

// Devolver empréstimo
Route::get('/emprestimos/{id}/devolver', [EmprestimoController::class, 'devolver'])
    ->name('emprestimos.devolver');

// Relatório de empréstimos
Route::get('/relatorio/emprestimos', [EmprestimoController::class, 'relatorio'])
    ->name('emprestimos.relatorio');
