<?php namespace App\Models;

use CodeIgniter\Model;

class ResultsModel extends Model{
  protected $table = 'results';
  protected $primaryKey = 'r_id';
  protected $allowedFields = [
    'r_s_id',
    'r_e_id',
    'r_q_id',
    'r_a_id',
    'r_seconds',
    'r_times_pass',
    'r_success',
    'r_exam_time',
  ];
  


  protected $returnType    = 'object';
  protected $createdField  = 'r_created_at';
  // protected $updatedField  = 'r_updated_at';

}
