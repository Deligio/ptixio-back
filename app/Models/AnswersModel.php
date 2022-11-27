<?php namespace App\Models;

use CodeIgniter\Model;

class AnswersModel extends Model{
  protected $table = 'answers';
  protected $primaryKey = 'a_id';
  protected $allowedFields = [
    'a_q_id',
    'a_title',
    'a_subtitle',
    'a_result',
    'a_status',
  ];
  


  protected $returnType    = 'object';
  protected $createdField  = 'a_created_at';
  protected $updatedField  = 'a_updated_at';

}
