<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadesFederativasModel extends Model
{
    protected $table = "unidades_federativas";
    protected $primaryKey = "uf_id";

    protected $useAutoIncrement = true;

    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $useTimestamps = false;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function lista($db)
    {
        $estados= [];
        $query = $db->table('unidades_federativas')->get();
        foreach ($query->getResult() as $row) {
            array_push($estados, $row->uf_nome);
        }
        return $estados;
    }
}
