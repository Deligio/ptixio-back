<?php namespace App\Models;

use CodeIgniter\Model;

class ExamsModel extends Model{
  protected $table = 'exams';
  protected $primaryKey = 'e_id';
  protected $allowedFields = [
    'e_c_id',
    'e_name',
    'e_end_date',
    'e_status',
    'e_start_date',
  ];

  protected $returnType    = 'object';
  protected $createdField  = 'e_created_at';
  protected $updatedField  = 'e_updated_at';

}
