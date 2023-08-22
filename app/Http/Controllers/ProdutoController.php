<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    private function validateProdutoRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'nome' => 'required',
            'preco' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
        ]);
    }

    public function index(): JsonResponse
    {
        $produtos = Produto::all();
        return response()->json($produtos);
    }

    public function show(Produto $produto): JsonResponse
    {
        return response()->json($produto);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = $this->validateProdutoRequest($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $produto = Produto::create($request->all());
        return response()->json($produto, 201);
    }

    public function update(Request $request, Produto $produto): JsonResponse
    {
        $validator = $this->validateProdutoRequest($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $produto->update($request->all());
        return response()->json($produto, 200);
    }

    public function destroy(Produto $produto): JsonResponse
    {
        Log::debug('Deleting product:', $produto->toArray());

        $produto->delete();
        return response()->json(null, 204);
    }

    public function buscarPorNome($nome): JsonResponse
    {
        $produtos = Produto::where('nome', 'like', '%' . $nome . '%')->get();
        return response()->json($produtos);
    }
}