<?php

namespace App\Models;

use CodeIgniter\Model;
use MercadoPago\MercadoPagoConfig;

class PagamentoModel extends Model
{
    protected $table            = 'tb_pagamento';
    protected $primaryKey       = 'id_pagamento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function gerarPreference(string $pais, array $vendedor, array $produto, array $usuario): void
    {
        MercadoPagoConfig::setAccessToken($vendedor['token_vendedor']);

        $client = new PreferenceClient();

        // Posso tentar criar um foreach para cada produto, esperando receber mais de um produto.
        switch ($pais) {
            case "Brasil":
                $preference = $client->create([
                "back_urls"=>array(
                    "success" => "https://test.com/success",
                    "failure" => "https://test.com/failure",
                    "pending" => "https://test.com/pending"
                ),
                "items" => array(
                    array(
                        "id" => "{$produto['id_produto']}",
                        "title" => "{$produto['nome_produto']}",
                        "description" => "{$produto['descricao_produto']}",
                        "picture_url" => "{$produto['imagem_produto']}",
                        "category_id" => "{$produto['especificacao_produto']}",
                        "quantity" => $produto['quantidade_produto'],
                        "currency_id" => "BRL",
                        "unit_price" => $produto['preco_produto'] * $produto['quantidade_produto']
                    )
                ),
                "payer" => array(
                    "name" => "{$usuario['nome_usuario']}",
                    "email" => "{$usuario['email_usuario']}",
                    "phone" => array(
                        "area_code" => "11",
                        "number" => "4444-4444"
                    ),
                    "identification" => array(
                        "type" => "CPF",
                        "number" => "19119119100"
                    ),
                    "address" => array(
                        "zip_code" => "06233200",
                        "street_name" => "Street",
                        "street_number" => "123"
                    )
                ),
                "auto_return" => "all"
                ]);
        
                echo implode($preference);
            break;
            case "Chile":
                break;
            case "":
                break;
            default:
                exit();
        }
    }
}
