<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class DatabaseModel
{

    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
    }

    public function schema($table)
    {
        $query = "SHOW COLUMNS FROM $table";
        $result = $this->db->query($query)->getResult();
        return $result;
    }

    public function Tests()
    {
        $query = "
        Select *
        From tests
        inner join questions on t_id = q_t_id
        inner join answers on q_id = a_q_id
        where t_status = 'Active'
        ";//
        $result = $this->db->query($query)->getResult();
        // $result = $this->db->table('tests')->join('questions','q_id','a_q_id')->get()->getRow();
        return $result;
    }

    public function getTests()
    {
        $select = "SELECT t_id as id, t_name as name";
        $from = "\n"."FROM tests";
        // $innerQuestions = "\n"."inner join questions on q_t_id = t_id"; 
        // $innerAnswer = "\n"."inner join answers on a_q_id = q_id"; 
        $where = "\n"."WHERE t_status = 'Active'";
        $tests = $select.$from.$where;
        $result = $this->db->query($tests)->getResult();
        return $result;
    }

    public function getTest($id)
    {
        $select = "SELECT t_id as id, t_name as name";
        $from = "\n"."FROM tests";
        $where = "\n"."WHERE t_status = 'Active' AND t_id = ".$id;
        $test = $select.$from.$where;
        $result = $this->db->query($test)->getRow();//->getResult();
        return $result;
    }

    public function questions($test)
    {
        $select = "SELECT q_id as id, t_id as test, q_title as title, q_subtitle as subtitle";
        $from = "\n"."FROM tests";
        $innerQuestions = "\n"."inner join questions on q_t_id = t_id"; 
        // $innerAnswer = "\n"."inner join answers on a_q_id = q_id"; 
        $where = "\n"."WHERE t_id = ".(int)$test." AND t_status = 'Active' AND q_status = 'Active'";
        $questions = $select.$from.$innerQuestions.$where;
        $result = $this->db->query($questions)->getResult();
        return $result;
    }



    public function getItem($table, $where)
    {
        return $this->db->table($table)
            ->where($where)
            ->get()
            ->getRow();
    }

}