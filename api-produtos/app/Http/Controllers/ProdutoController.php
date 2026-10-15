<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class ProdutoController extends Controller
{
    public function __construct(private ProdutoService $service)
    {
    }

    public function index()
    {
        return ProdutoResource::collection(Produto::all());
    }

    public function store(ProdutoRequest $request)
    {
        try {
            $produto = $this->service->criar($request->validated());
        } catch (InvalidArgumentException $e) {
            throw ValidationException::withMessages(['preco' => $e->getMessage()]);
        }

        return (new ProdutoResource($produto))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Produto $produto)
    {
        return new ProdutoResource($produto);
    }

    public function update(ProdutoRequest $request, Produto $produto)
    {
        try {
            $produto = $this->service->update($produto->id, $request->validated());
        } catch (InvalidArgumentException $e) {
            throw ValidationException::withMessages(['preco' => $e->getMessage()]);
        }

        return new ProdutoResource($produto);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return response()->noContent();
    }
}
