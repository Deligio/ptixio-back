<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsuranceCompanies extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ic_id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'ic_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'ic_car' => [
                'type' => 'ENUM',
                'constraint' => ['Yes','No'],
                'default'        => 'No',
            ],
            'ic_house' => [
                'type' => 'ENUM',
                'constraint' => ['Yes','No'],
                'default'        => 'No',
            ],
            'ic_api_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'ic_api_dev_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'ic_api_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'ic_api_user' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'ic_api_password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'ic_documentation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'ic_comments' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ic_status' => [
                'type' => 'ENUM',
                'constraint' => ['Active','Inactive'],
                'default'        => 'Active',
            ],
            'ic_created_at datetime default current_timestamp',
            'ic_updated_at datetime default current_timestamp on update current_timestamp'
            
        ]);
        // $this->forge->addPrimaryKey('ic_id');
        // $this->forge->createTable('insurance_companies');
    }

    public function down()
    {
        // $this->forge->dropTable('insurance_companies');
    }
}
