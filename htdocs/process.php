<?php

/*
//used only for testing purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/

// include class
include("numberstowords.php");

// create object
$nw = new NumbersToWords();
setlocale(LC_MONETARY,"en_AU");

// retrieve amount from query-string
$amount = $_REQUEST["amount"];

$cheque_format->payeename = $_REQUEST["payeename"];
$cheque_format->currencynumeric = is_numeric($amount) ? money_format('%.2n', $amount) : 0;
$cheque_format->currencywords = is_numeric($amount) ? strtoupper($nw->convert($amount)) : 0;

echo json_encode($cheque_format);

?>