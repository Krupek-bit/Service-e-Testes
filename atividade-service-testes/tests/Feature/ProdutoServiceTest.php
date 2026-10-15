<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class ProdutoServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProdutoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProdutoService();
    }

    // TESTE 1: o produto não é criado se o valor não segue a regra de negócio
    public function test_nao_cria_produto_com_preco_invalido(): void
    {
        try {
            $this->service->criar([
                'nome'    => 'Produto inválido',
                'preco'   => -10,
                'estoque' => 5,
            ]);
            $this->fail('Deveria ter lançado InvalidArgumentException.');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('O preço deve ser maior que zero.', $e->getMessage());
        }

        $this->assertDatabaseCount('produtos', 0);
    }

    // TESTE 2 (update): altera os dados com sucesso
    public function test_update_altera_os_dados_do_produto(): void
    {
        $produto = Produto::create([
            'nome'    => 'Teclado',
            'preco'   => 100,
            'estoque' => 10,
        ]);

        $atualizado = $this->service->update($produto->id, [
            'nome'  => 'Teclado Mecânico',
            'preco' => 150,
        ]);

        $this->assertEquals('Teclado Mecânico', $atualizado->nome);
        $this->assertEquals(150, $atualizado->preco);
        $this->assertDatabaseHas('produtos', [
            'id'   => $produto->id,
            'nome' => 'Teclado Mecânico',
        ]);
    }

    // TESTE 3 (update): rejeita preço fora da regra e não altera o banco
    public function test_update_nao_aceita_preco_invalido(): void
    {
        $produto = Produto::create([
            'nome'    => 'Mouse',
            'preco'   => 80,
            'estoque' => 3,
        ]);

        try {
            $this->service->update($produto->id, ['preco' => 0]);
            $this->fail('Deveria ter lançado InvalidArgumentException.');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals('O preço deve ser maior que zero.', $e->getMessage());
        }

        $this->assertDatabaseHas('produtos', [
            'id'    => $produto->id,
            'preco' => 80,
        ]);
    }
}
