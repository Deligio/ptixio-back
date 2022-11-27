<?php namespace App\Models;

use CodeIgniter\Model;

class StudentsModel extends Model{
  protected $table = 'students';
  protected $primaryKey = 's_id';
  protected $allowedFields = [
    'u_name',
    'u_surname',
    'u_email',
    'u_password',
  ];

  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];
  protected $returnType    = 'object';

  protected function beforeInsert(array $data){
    $data = $this->passwordHash($data);
    return $data;
  }

  protected function beforeUpdate(array $data){
    $data = $this->passwordHash($data);
    $data = $this->removeEmail($data);
    return $data;
  }

  protected function removeEmail($data){
    if($data['u_email'] ?? false)//isset($data['u_email'])
      unset($data['u_email']);

    return $data;
  }

  protected function passwordHash(array $data){
    if(isset($data['data']['u_password']))
      $data['data']['u_password'] = password_hash($data['data']['u_password'], PASSWORD_DEFAULT);
    return $data;
  }
}
