<?php

namespace App\Services;

use App\Models\Produto;
use InvalidArgumentException;

class ProdutoService
{
    public function criar(array $dados): Produto
    {
        $this->validarPreco($dados['preco']);

        return Produto::create($dados);
    }

    public function update(int $id, array $dados): Produto
    {
        $produto = Produto::findOrFail($id);

        if (isset($dados['preco'])) {
            $this->validarPreco($dados['preco']);
        }

        $produto->update($dados);

        return $produto->fresh();
    }

    private function validarPreco(float|int|string $preco): void
    {
        if ($preco <= 0) {
            throw new InvalidArgumentException('O preço deve ser maior que zero.');
        }
    }
}
