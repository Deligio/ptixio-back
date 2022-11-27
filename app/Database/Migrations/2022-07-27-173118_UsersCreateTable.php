<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    protected $table = 'users';
    protected $primary_key = 'u_id';
    public function up()
    {
        $this->forge->addField([
            $this->primary_key => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'u_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'u_surname' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'u_email' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'u_password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'u_comments' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'u_status' => [
                'type' => 'ENUM',
                'constraint' => ['Active','Inactive'],
                'default'        => 'Active',
            ],
            'u_created_at datetime default current_timestamp',
            'u_updated_at datetime default current_timestamp on update current_timestamp'
            
        ]);
        $this->forge->addPrimaryKey($this->primary_key);
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table());
        // $this->forge->dropTable('insurance_companies');
    }
}
