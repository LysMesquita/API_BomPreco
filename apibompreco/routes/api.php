<?php

use App\Http\Controllers\ProdutosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// rotas para visualizar os registros
Route::get('/',function(){return response()->json(['Sucesso'=>true]);});
Route::get('/produtos',[ProdutosController::class,'index']);
Route::get('/produtos/{codigo}',[ProdutosController::class,'show']);

// rota para inserir os regiatros
Route::post('/produtos',[ProdutosController::class, 'store']);

// rota para alternar os registros
Route::put('/produtos/{codigo}',[ProdutosController::class,'update']);

// rota para excluir o registro por id/codigo
Route::delete('/produtos/{id}',[ProdutosController::class,'destroy']);
