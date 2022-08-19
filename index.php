<?php

require('EmployeeService.php');
require('MailService.php');

$employeeBirthdayNotification = new EmployeeService();
$employees = $employeeBirthdayNotification->fetchEmployeesDetails();
$doNotSendIds = $employeeBirthdayNotification->fetchDoNotSendIds();
$filterEdEmployee = $employeeBirthdayNotification->filterEmployee($employees, $doNotSendIds);

$mailService = new MailService();

echo '<pre>';
print_r($filterEdEmployee);
echo '</pre>';
exit;

foreach ($filterEdEmployee as $key => $value) {
    $to = $value['name'].'.'.$value['lastname'].'@example.com';
    $subject = "Happy Birth day";
    $message = 'Happy Birth day '.$value['name'];


    $mailService->send($to,$subject,$message);
}

