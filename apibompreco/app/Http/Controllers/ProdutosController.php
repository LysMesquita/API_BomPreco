<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // buscando todos os Produtos
        $registros = Produtos::all();

        // contando o numero de registros
        $contador = $registros->count();

        // verificando se ha registros
        if ($contador > 0) {
            return response()->json([
                'sucess' => true,
                'message' => 'Produtos encontrados com sucesso!',
                'data' => $registros,
                'total' => $contador
            ], 200); // retorna HTTP 200 (OK) com os dados e a contagem
        } else {
            return response()->json([
                'sucess' => false,
                'message' => 'Nenhum produto encontrado!',
            ], 404); // retorna HTTP 404 (Not Found ) se nao houver registros
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'marca' => 'required',
            'preco' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400); // retorna HTTP 400 (Bad Request) se houver erro de validação
        }

        // criando um produto no banco de dados
        $registros = Produtos::create($request->all());
        if ($registros) {
            return response()->json([
                'sucess' => true,
                'message' => 'Produtos cadastrados com sucesso!',
                'data' => $registros
            ], 201);
        } else {
            return response()->json([
                'sucess' => false,
                'message' => 'Erro ao cadastrar um produto'
            ], 500); // retorna HTTP 500 (Internal Server Error) se o cadastro falhar
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // buscando um produto pelo ID
        $registros = Produtos::find($id);
        
        // verificando se o produto foi encontrado
        if ($registros) {
            return responde()->json([
                'sucess' => true,
                'message' => 'Produto localizado com sucesso!',
                'data' => $registros
            ], 200); // retorna HTTP 200 (OK) com os dados do produto
        } else {
            return response()->json([
                'sucess' => false,
                'message' => 'Produto não localizado',
            ], 404); // retorna HTTP 404 (Not Found) se o produto nao for encontrado
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'marca' => 'required',
            'preco' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json ([
                'suceess' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400); // retorna HTTP 400 se houver erro de validação
        }

        // encontrando um produto no banco
        $registrosBanco = Produtos::find($id);

        if (!$registrosBanco) {
            return response()->json([
                'sucess' => false,
                'message' => 'Produto não encontrado'
            ], 404);
        }

        // atualizando os dados
        $registrosBanco->nome = $request->nome;
        $registrosBanco->marca = $request->marca;
        $registrosBanco->preco = $request->preco;

        // salvando as alterações
        if ($registrosBanco->save()) {
            return response()->json([
                'sucess' => true,
                'message' => 'Produto atualizado com sucesso!',
                'data' => $registrosBanco
            ], 200); // retorna HTTP 200 se a atualização for bem sucedida
        } else {
            return response()->json([
                'sucess' => false,
                'message' => 'Erro ao atualizar o produto'
            ], 500); // retorna HTTP 500 se houver erro ao salvar
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // encontrando um produto no banco
        $registros = Produtos::find($id);

        if (!$registros) {
        return response()->json([
            'sucess' => false,
            'message' => 'Produto não encontrado'
        ], 404); // retorna HTTP 404 se o produto nao for encontrado
        }
        // deletando um produto
        if ($registros->delete()) {
            return response()->json([
                'sucess' => true,
                'message' => 'Produto deletado com sucesso'
            ], 200); // retorna HTTP 200 se a exclusão for bem sucedida
        }
        return response()->json([
            'sucess' => false,
            'message' => 'Erro ao deletar um produto'
        ], 500); // retorna HTTP 500 se houver erro na exclusão
    }
}