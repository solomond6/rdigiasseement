<?php

require('curl.php');

class EmployeeService {

    public $baseUrl;

    public function __construct() {
        $this->baseUrl = 'https://interview-assessment-1.realmdigital.co.za/';
    }

    public function year_check($dateOfBirth):bool
    {
        $date = strtotime($dateOfBirth);
        $year = date('Y', $date);
        if((0 == $year % 4) & (0 != $year % 100) | (0 == $year % 400))
        {
            return true;
        }
        else  
        {  
            return false;    
        }
    }

    public function fetchEmployeesDetails(): array 
    {
        $employeeDetails = [];

        $curl = new curl();
        $curl->url($this->baseUrl.'employees')
             ->method('get')
             ->send();

        // check status code of our request
        if( $curl->info['http_code'] == 200 ){
            // request is good.
            $employeeDetails = json_decode($curl->content, true);
        }

        $curl->close();

        return $employeeDetails;

    }

    public function fetchDoNotSendIds(): array 
    {   
        $doNotSendIds = [];

        $curl = new curl();
        $curl->url($this->baseUrl.'do-not-send-birthday-wishes')
                ->method('get')
                ->send();

        // check status code of our request
        if( $curl->info['http_code'] == 200 ){
            // request is good.
            $doNotSendIds = json_decode($curl->content, true);
        }
        $curl->close();

        return $doNotSendIds;
    }

    public function filterEmployee($employeeDetails, $doNotSendIds): array 
    {
        
        $filtered = array_filter($employeeDetails, fn($var) => (isset($var['employmentEndDate']) == null && isset($var['employmentStartDate']) != null
                && !in_array($var['id'], $doNotSendIds) && !$this->year_check($var['dateOfBirth']) ));

        return $filtered;
    }
}