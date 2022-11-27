<?php namespace App\Models;

use CodeIgniter\Model;

class ScoresModel extends Model{
  protected $table = 'scores';
  protected $primaryKey = 'sc_id';
  protected $allowedFields = [
    'sc_s_id',
    'sc_e_id',
    'sc_time',
    'sc_score',
  ];
  


  protected $returnType    = 'object';
  protected $createdField  = 'sc_created_at';
  // protected $updatedField  = 'r_updated_at';

}
