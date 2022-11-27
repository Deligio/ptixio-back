<?php namespace App\Models;

use CodeIgniter\Model;

class QuestionsModel extends Model{
  protected $table = 'questions';
  protected $primaryKey = 'q_id';
  protected $allowedFields = [
    'q_e_id',
    'q_title',
    'q_subtitle',
    'q_status',
  ];
  


  protected $returnType    = 'object';
  protected $createdField  = 'q_created_at';
  protected $updatedField  = 'q_updated_at';

}
