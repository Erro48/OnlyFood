<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["title"] = "OnlyFood - Register";
$templateParams["name"] = "template/registration-content.php";
$templateParams["intolerances"] = $dbh->getMostFrequentIntolerances(5);

require 'template/login-base.php';
?>