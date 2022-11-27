<?php namespace App\Controllers;

use App\Models\TestsModel;
use App\Models\DatabaseModel;
use CodeIgniter\API\ResponseTrait;

class Tests extends BaseController
{
    protected $db;
    use ResponseTrait;

    function __construct () 
    {
        $this->db = db_connect();
        // $db = \Config\Database::connect();
    }

    public function index() { }

    public function getTests()
    {
        $model = new DatabaseModel($this->db);
        // $data = $model->where('t_status', "Active")->first();
        $data = $model->getTests();
        return $this->respond($data, 200); 
    }

    public function getTestById($id = '0')
    {
        $model = new DatabaseModel($this->db);
        // $data = $model->where('t_status', "Active")->first();
        $data = $model->getTest($id);
        return $this->respond($data, 200); 
    }

    public function getQuestions($id = 1)
    {
        $model = new DatabaseModel($this->db);
        $questions = $model->questions($id);
        return $this->respond($questions, 200);
    }

    public function bo()
    {
        $stepsReset = [
            'category',
            'Driver',
            'VehiclePlateNumber',
            'Usage',
            'ConstructionMonth ',
            'ConstructionYear',
            'Brand',
            'BrandName',
            'Model',
            'ModelName',
            'ModelCode',
            'Trim',
            'TaxHP',
            'CC',
            'VehiclePrice',
            'LicenceFirstDate',
            'BoughtDate',
            'FuelType',
            'Tonaz',
            'Trailer',
            'Seats',
            'Immobilizer',
            'Alarm',
            'FirstHand',
            'HeavyVehicle',
            'Cabrio',
            'Afm',
            'Firstname',
            'Lastname',
            'Phone',
            'Email',
            'BirthDate',
            'DriverLicenseDate',
            'DrivingLicenceType',
            'Profession',
            'Sex',
            'Address',
            'City',
            'PostalCode',
            'Accidents',
            'Nationality',
            'BM',
            'StartingDate',
            'Duration',
            'IssueDate',
            'InsuranceType',
            'Partner',
            'odiki',
            'nomiki',
            'kristalla',
            'piros',
            'mikti',
            'klopi',
            'InsuranceName',
            'ProposalID',
            'NetPrice',
            'selectedCompanies',
          ];
          $string = '';
          foreach ($stepsReset as $key => $value) {
            // $string .= '
            // const '.$value.' = computed({
            //     get() { return store.state; },
            //     set(payload: string) { let mutationData = { field: "'.$value.'", value: payload, }; store.commit(Mutations.UPDATE_FORM_FIELD, mutationData); },
            // });
            // ';
            $string = '
            SET_FORMDATA_'.strtoupper($value).'(payload : string){
                this.formData.'.$value.' = payload
              }
            ';
            echo '<pre>';
             print_r($string);
            echo '</pre>';
          };
        // echo '<pre>';
        //  print_r($stepsReset);
        // echo '</pre>';

    }
}