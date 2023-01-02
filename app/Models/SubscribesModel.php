<?php namespace App\Models;

use CodeIgniter\Model;

class SubscribesModel extends Model{
  protected $table = 'subscribes';
  protected $primaryKey = 'sub_id';
  protected $allowedFields = [
    'sub_c_id',
    'sub_u_id',
    'sub_status',
  ];
  
  protected $returnType    = 'object';
  protected $createdField  = 'sub_created_at';
  // protected $updatedField  = 'r_updated_at';

}
