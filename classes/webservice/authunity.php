<?php

require_once 'autentication.php';

$username = filter_input(INPUT_POST, 'username' , FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$password = filter_input(INPUT_POST, 'password');
$domain = filter_input(INPUT_POST, 'domain');

//$username = required_param('username', PARAM_USERNAME);
//$password = required_param('password', PARAM_RAW);

$Autentication = new Autentication($domain);
$token = $Autentication->requestToken($username, $password);        

if(isset($token) && $token != '')
{
   echo "succeed" . ',' . $token; 
}
else
{
    echo ("User login faild");
}

exit();



