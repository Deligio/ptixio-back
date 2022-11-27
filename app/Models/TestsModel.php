<?php
namespace App\Models;

use CodeIgniter\Model;

class TestsModel extends Model
{
    protected $table      = 'tests';
    protected $primaryKey = 't_id';

    protected $returnType     = 'object';
    protected $allowedFields = [
        't_c_id',
        't_name',
        't_start_date',
        't_end_date',
        't_status',
    ];

    protected $createdField  = 't_created_at';
    protected $updatedField  = 't_updated_at';

    function all()
    {
        $db = db_connect();
        $sql = 'SELECT 
        t_id as id,
        t_name as name
        From tests';
        return $db->query($sql)->getResult();
    }

}

