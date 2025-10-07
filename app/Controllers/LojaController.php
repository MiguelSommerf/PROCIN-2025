<?php

namespace App\Controllers;

use App\Models\LojaModel;
use CodeIgniter\RESTful\ResourceController;

class LojaController extends ResourceController
{
    protected $modelName = LojaModel::class;
    protected $format    = 'json';


    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondCreated([
            'message' => 'Loja criada com sucesso!',
            'id' => $this->model->getInsertID()
        ]);
    }

    // listo todos do model cadastrados
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // pegar uma loja especifíca
    public function show($id = null)
    {
        $loja = $this->model->find($id);
        if (!$loja) {
            return $this->failNotFound('Loja não encontrada.');
        }
        return $this->respond($loja);
    }

    // here i made a system that makes a method for updates
    
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondUpdated(['message' => 'Loja atualizada com sucesso!']);
    }

    // delet na loja, verificando se ela existe primeiro
    public function delete($id = null)
    {
        if (!$this->model->delete($id)) {
            return $this->failNotFound('Loja não encontrada.');
        }

        return $this->respondDeleted(['message' => 'Loja removida com sucesso.']);
    }
}
