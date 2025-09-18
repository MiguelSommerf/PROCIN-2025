<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioProdutoModel extends Model
{
    
    protected $table = 'tb_usuario_produto';

    protected $primaryKey = 'id';
    
    protected $allowedFields = ['id_usuario', 'id_produto'];
}
