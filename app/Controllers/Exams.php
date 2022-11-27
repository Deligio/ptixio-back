<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\ExamsModel;
use App\Models\QuestionsModel;
use App\Models\AnswersModel;
use App\Models\ResultsModel;
use App\Models\CoursesModel;
use App\Models\ScoresModel;
use CodeIgniter\API\ResponseTrait;

class Exams extends BaseController
{
    protected $db;
    use ResponseTrait;

    function __construct () 
    {
        $this->db = db_connect();
        // $db = \Config\Database::connect();
    }

    public function index() { }

    public function getExams()
    {
        $model = new ExamsModel($this->db);
        // $data = $model->where('t_status', "Active")->first();
        $data = $model
                ->select('
                e_id as id,
                e_name as name,
                c_id as course_id
                ')
                // c_name as course,
                // e_end_date as ,
                // e_status as ,
                // e_start_date as ,
                // ')
                ->join('courses','e_c_id = c_id')
                ->findAll();
        return $this->respond($data, 200); 
    }

    public function getQuestions()
    {
        $model = new QuestionsModel($this->db);
        $where = [
            'q_e_id' => $this->request->getVar('id'),
        ];
        $data = $model
                ->select('
                q_id as id,
                q_e_id as exam,
                q_title as title,
                q_subtitle as subtitle')
                ->where($where)
                ->findAll();
        return $this->respond($data, 200);
    }
  
    public function getAnswers()
    {
        $model = new AnswersModel($this->db);
        $where = [
            'a_q_id' => $this->request->getVar('id'),
        ];
        $data = $model
                ->select('
                    a_id as id,
                    a_q_id as question,
                    a_title as title,
                    a_subtitle as subtitle,
                    a_result as result,
                    ')
                    // a_status as status
                ->where($where)
                ->findAll();
        return $this->respond($data, 200);
    }

    public function getAnswersByExam()
    {
        $model = new AnswersModel($this->db);
        $where = [
            'q_e_id' => $this->request->getVar('id'),
        ];
        $data = $model
                ->select('
                    a_id as id,
                    a_q_id as question,
                    a_title as title,
                    a_subtitle as subtitle,
                    a_result as result,
                    ')
                    // a_status as status
                    ->join('questions','a_q_id = q_id')
                ->where($where)
                ->findAll();
        return $this->respond($data, 200);
    }

    public function examComplete()
    {
        $resultsModel = new ResultsModel($this->db);
        $quest_Model = new QuestionsModel($this->db);
        $ans_Model = new AnswersModel($this->db);
        $score_Model = new ScoresModel($this->db);
        // $this->request->getVar('id')
        $student = $this->request->getVar('student');
        $results = $this->request->getVar('results');
        // $question = $this->request->getVar('question');
        
        $times = 0;
        $statistics = [];
        foreach ($results as $key => $value) {
            $q_where = [
                'q_id' => $value->question,
            ];
            $exam = $quest_Model->select('q_e_id')->where($q_where)->first()->q_e_id;
            if($times == 0){
                $t_where = [
                    'r_s_id' => $student,
                    'r_e_id' => $exam,
                ];
                $times = $resultsModel->select('MAX(r_exam_time) as times')->where($t_where)->first()->times;
                $times = ($times == null) ? 1 : ++$times;
            }
            //check
            $c_where = [
                'a_q_id' => $value->question,
                'a_result' => 'Correct',
            ];
            $a_id = $ans_Model->select('a_id')->where($c_where)->first()->a_id;
            //check
            $success = ($a_id == $value->answer) ? 1 : 0;
            $statistics[] = $success; 

            $data = [
                'r_s_id' => $student,
                'r_e_id' => $exam,
                'r_q_id' => $value->question,
                'r_a_id' => $value->answer,
                'r_seconds' => $value->seconds,
                'r_times_pass' => $value->times,
                'r_success' => $success,
                'r_exam_time' => $times,
            ];
            $resultsModel->save($data);
        }

        $all = count($statistics);
        $ases = count(array_filter($statistics));
        $score = round(($ases * 100) / $all) ;
        $scoreData = [
            'sc_s_id' => $student,
            'sc_e_id' => $exam,
            'sc_time' => $times,
            'sc_score' => $score,
        ];
        // echo '<pre>';
        //  print_r($scoreData);
        // echo '</pre>';exit;
        $score_Model->save($scoreData);
        
        return $this->respond($score, 200);

        // $where = [
        //     'r_s_id' => $student,
        //     'r_q_id' => $question,
        // ];
        // $time = $model
        //         ->select('MAX(r_time) as time')
        //         ->where($where)
        //         ->find();
        // echo 'exam complete';
        // echo 'student: '.$student;
        // echo '<pre>';
        //  print_r($exams);
        // echo '</pre>';
        // exit;
        // return $this->respond($data, 200); 
    }

    public function newExam()
    {
        $examModel = new ExamsModel($this->db);
        $questionModel = new QuestionsModel($this->db);
        $answerModel = new AnswersModel($this->db);

        $request = service('request');
        $data = $this->request->getJSON();
        $examData = [
            'e_name' => $data->name,
            'e_c_id' => $data->course,
        ];
        
        $exam_id = $examModel->insert($examData,true);

        for ($i=1; $i <= $data->quantity; $i++) { 
            $questionData = [
                'q_e_id' => (string) $exam_id,
                'q_title' => $data->{'questionTitle-'.$i},
                'q_subtitle' => $data->{'questionSubtitle-'.$i},
            ];

            $questionModel->save($questionData);
            $question_id = $questionModel->getInsertID();
            for ($j=1; $j <= 4; $j++) { 
                $answerData = [
                    'a_q_id' => (string) $question_id,
                    'a_title' => $data->{'answerTitle-'.$i.'-'.$j},
                    'a_subtitle' => '',
                    'a_result' => ($j == $data->{'correctAnswer-'.$i}) ? 'Correct' : 'Wrong',
                ];
                $answerModel->save($answerData);
            }
        }

        return $this->respond($exam_id, 200);

    }

    public function getCourses()
    {
        $model = new CoursesModel($this->db);
        $exams_model = new ExamsModel($this->db);
        $where = [
            'c_status' => 'Active',
        ];
        $courses = $model
                ->select("
                    c_id as id,
                    c_name as name,
                    c_season as season
                    ")
                ->where($where)
                ->findAll();
        $cwe = [];
        $cwe_obj = $exams_model->select('e_c_id')
                            ->distinct()
                            ->findAll();
        foreach ($cwe_obj as $key => $value) {
            $one = $value->e_c_id;
            $cwe[] = $one;
        }
        $data = [
            'courses' => $courses,
            'courses_with_exams' => $cwe
        ];
        return $this->respond($data, 200);
        // CASE
        //     WHEN c_season = 'Winter' THEN 'Χειμερινό'
        //     ELSE 'Θερινό'
        // END AS season
    }

    public function newCourse()
    {
        $model = new CoursesModel($this->db);
        $data = [
            'c_name' => $this->request->getVar('course'),
            'c_season' => $this->request->getVar('season'),
        ];
        $save = $model->save($data);
        if($save){
            return $this->respond($save, 200); 
        } else {
            return $this->respond($save, 402); 
        } 
    }

    public function saveCourse()
    {
        $model = new CoursesModel($this->db);
        $data = [
            'c_id' => $this->request->getVar('id'),
            'c_name' => $this->request->getVar('course'),
            'c_season' => $this->request->getVar('season'),
        ];
        echo '<pre>';
         print_r($data);
        echo '</pre>';exit;
        $save = $model->save($data);
        if($save){
            return $this->respond($save, 200); 
        } else {
            return $this->respond($save, 402); 
        } 
    }

    public function getScores()
    {
        $model = new ScoresModel($this->db);
        $user = $this->request->getVar('user');
        $userModel = new UsersModel($this->db);
        $u_where = [
            'u_id' => $user,
        ];
        $user_type = $userModel->select('u_type')->where($u_where)->first()->u_type;
        if($user_type == 'Student'){
            $where = [
                'sc_s_id' => $user,
            ];
        }else{
            $where = [];
        }
        $select = '
            sc_id as id,
            sc_s_id as student_id,
            u_name as student_name,
            u_surname as student_surname,
            sc_e_id as exam_id,
            e_name as exam_name,
            sc_score as score,
            sc_time as time';
        $scores = $model->select($select)
                ->join('exams','sc_e_id = e_id')
                ->join('users', 'sc_s_id = u_id')
                ->where($where)
                ->findAll();
        return $this->respond($scores, 200);
    }

// use CodeIgniter\Database\RawSql;
// $sql = "id > 2 AND name != 'Accountant'";
// $builder->where(new RawSql($sql));

    public function getAnalyticResults()
    {
        $model = new ScoresModel($this->db);
        // $user = $this->request->getVar('user');
        $exams = $this->request->getVar('selected_exams');

        $select = '
        sc_id as score_id,
        q_id as question_id,
        q_title as question_title,
        a_id as answer_id,
        a_title as answer_title,
        r_success as success,
        r_seconds as seconds,
        r_times_pass as times_pass       
        ';
        $students_select = '
        u_id as id,
        u_name as name,
        u_surname as surname
        ';
    
        $analytics = $model->select($select)
                ->join('results', 'r_s_id = sc_s_id AND r_exam_time = sc_time')
                ->join('questions','r_q_id = q_id')
                ->join('answers', 'r_a_id = a_id')
                ->whereIn('sc_e_id', $exams)
                // ->where($where)
                ->findAll();
        $students = $model->select($students_select)
                    ->distinct()
                    ->join('users','sc_s_id = u_id')
                    ->whereIn('sc_e_id', $exams)
                    ->findAll();
        $resp = [
            'analytics' => $analytics,
            'students' => $students
        ];
        return $this->respond($resp, 200);
    }

    public function submitUserDetails()
    {
        return $this->respond(true, 200);
    }

    public function userChangePass()
    {
        return $this->respond(true, 200);
    }
}