<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return response()->json($produtos);
    }

    public function show(Produto $produto)
    {
        return response()->json($produto);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $produto = Produto::create($request->all());
        return response()->json($produto, 201);
    }

    public function update(Request $request, Produto $produto)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $produto->update($request->all());
        return response()->json($produto, 200);
    }

    public function destroy(Produto $produto)
    {
        Log::debug('Deleting product:', $produto->toArray());

        $produto->delete();
        return response()->json(null, 204);
    }

    public function buscarPorNome($nome)
    {
        $produtos = Produto::where('nome', 'like', '%' . $nome . '%')->get();
        return response()->json($produtos);
    }
}