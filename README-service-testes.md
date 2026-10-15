<div align="center">

# 🧱 Atividade de Service e Testes

**Camada de Service • Regra de negócio • Testes automatizados com PHPUnit**

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-3776AB?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)

![Testes](https://img.shields.io/badge/testes-3%20passando-success?style=flat-square)
![License](https://img.shields.io/badge/uso-acadêmico-lightgrey?style=flat-square)

</div>

---

## 📑 Sumário

- [📌 Sobre a atividade](#-sobre-a-atividade)
- [📏 Regra de negócio](#-regra-de-negócio)
- [📂 Estrutura](#-estrutura)
- [🧠 O Service](#-o-service)
- [🧪 Os testes](#-os-testes)
- [▶️ Como rodar](#️-como-rodar)
- [✅ Checklist](#-checklist)
- [👨‍💻 Autor](#-autor)

---

## 📌 Sobre a atividade

| Parte | Requisito |
|---|---|
| **Service** | Criar o método `update` dentro do service |
| **Testes** | Criar um teste para verificar que o produto **não é criado** se o valor não segue a regra de negócio |
| **Testes** | Criar **2 testes** para o método `update` do service |

---

## 📏 Regra de negócio

> O **preço do produto deve ser maior que zero**.
> Caso contrário, o service lança `InvalidArgumentException` com a mensagem `O preço deve ser maior que zero.`

A regra fica em um único método privado (`validarPreco`), reaproveitado por `criar` e `update`.

---

## 📂 Estrutura

```bash
.
├── 📁 app/
│   └── Services/
│       └── ProdutoService.php          # criar() e update() + regra de negócio
├── 📁 tests/
│   └── Feature/
│       └── ProdutoServiceTest.php      # 3 testes
├── 📄 phpunit.xml                      # SQLite em memória para os testes
└── 📄 README.md
```

---

## 🧠 O Service

| Método | O que faz |
|---|---|
| `criar(array $dados)` | Valida o preço e cria o produto |
| `update(int $id, array $dados)` | Busca o produto (`404` se não existir), valida o preço quando enviado e atualiza |
| `validarPreco($preco)` | _(privado)_ Lança `InvalidArgumentException` se o preço for `<= 0` |

```php
$service = new ProdutoService();

$service->criar(['nome' => 'Teclado', 'preco' => 100, 'estoque' => 10]);
$service->update(1, ['preco' => 150]);
```

---

## 🧪 Os testes

| # | Teste | Cobre | Resultado esperado |
|:-:|---|---|---|
| 1 | `test_nao_cria_produto_com_preco_invalido` | Criação com preço `-10` | ❌ Exceção lançada e **nenhum produto** no banco |
| 2 | `test_update_altera_os_dados_do_produto` | `update` com dados válidos | ✅ Produto atualizado no banco |
| 3 | `test_update_nao_aceita_preco_invalido` | `update` com preço `0` | ❌ Exceção lançada e **banco inalterado** |

---

## ▶️ Como rodar

> **Pré-requisitos:** PHP 8.2+, Composer e um projeto Laravel com o model `Produto` (campos `nome`, `preco`, `estoque`) e a tabela `produtos` migrada.

```bash
php artisan test --filter=ProdutoServiceTest
```

<details>
<summary>📤 <b>Saída esperada</b></summary>

```text
   PASS  Tests\Feature\ProdutoServiceTest
  ✓ nao cria produto com preco invalido
  ✓ update altera os dados do produto
  ✓ update nao aceita preco invalido

  Tests:    3 passed
```

</details>

> 🛡️ O `phpunit.xml` usa **SQLite em memória** (`:memory:`). Assim o `RefreshDatabase` roda os testes sem apagar o banco de desenvolvimento.

---

## ✅ Checklist

**Service**
- [x] Método `update` criado dentro do service

**Testes**
- [x] Teste: produto não é criado com valor fora da regra de negócio
- [x] 2 testes para o método `update` do service

---

## 👨‍💻 Autor

<div align="center">

**Gabriel Krupek**

[![GitHub](https://img.shields.io/badge/GitHub-Krupek--bit-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/Krupek-bit)

<sub>Projeto acadêmico — Engenharia de Software</sub>

</div>
