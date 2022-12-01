<?php namespace App\Models;

use CodeIgniter\Model;

class CoursesModel extends Model{
  protected $table = 'courses';
  protected $primaryKey = 'c_id';
  protected $allowedFields = [
    'c_name',
    'c_semester',
    'c_season',
    'c_status',
  ];
  


  protected $returnType    = 'object';
  protected $createdField  = 'c_created_at';
  protected $updatedField  = 'c_updated_at';

}
