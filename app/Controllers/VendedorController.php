<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VendedorModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class VendedorController extends BaseController
{
    use ResponseTrait;

    public function cadastrarVendedor(): ResponseInterface
    {
        $request = $this->request->getJSON(true);
        $validation = \Config\Services::validation();

        $rules = [
            'nome_vendedor'       => 'required|min_length[3]|max_length[50]',
            'email_vendedor'      => 'required|valid_email|max_length[255]|is_unique[tb_vendedor.email_vendedor]',
            'senha_vendedor'      => 'required|min_length[8]',
            'nascimento_vendedor' => 'required',
            'pais_vendedor'       => 'required',
            'tipo_documento'      => 'required',
            'documento_vendedor'  => 'required|max_length[255]'
        ];

        $messages = [
            'nome_vendedor' => [
                'required'   => 'O nome de usuário é obrigatório.',
                'min_length' => 'O nome de usuário precisa conter no mínimo 3 caracteres.',
                'max_length' => 'O nome de usuário pode conter no máximo 50 caracteres.'
            ],

            'email_vendedor' => [
                'required'    => 'O endereço de e-mail é obrigatório.',
                'valid_email' => 'O endereço de e-mail precisa ser válido.',
                'max_length'  => 'O endereço de e-mail pode conter no máximo 255 caracteres.',
                'is_unique'   => 'O endereço de e-mail inserido já está cadastrado.'
            ],

            'senha_vendedor' => [
                'required'   => 'O campo senha é obrigatório.',
                'min_length' => 'O campo senha precisa conter no mínimo 8 caracteres.'
            ],

            'nascimento_vendedor' => [
                'required' => 'A data de nascimento é obrigatória.'
            ],

            'pais_vendedor' => [
                'required' => 'Você precisa selecionar um país.'
            ],

            'tipo_documento' => [
                'required' => 'Você precisa selecionar um tipo de documento.'
            ],

            'documento_vendedor' => [
                'required'   => 'O campo documento é obrigatório.',
                'max_length' => 'O campo documento não pode ultrapassar os 255 caracteres.'
            ],
        ];

        if (!$validation->setRules($rules, $messages)->run($request)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $vendedorModel = new VendedorModel();
        
        if ($vendedorModel->inserirVendedor($request)) {
            return $this->respondCreated('Cadastrado com sucesso!');
        }

        return $this->respondCreated($vendedorModel->errors());
    }
}
