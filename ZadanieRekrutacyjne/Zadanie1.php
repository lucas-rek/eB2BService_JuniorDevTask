<?php
include("PhoneKeyboardConverter.php");
// Metody powinny byc przetestowane przykładowo w PHPUnit, ale na potrzeby tego zadania
// poniższy sposób jest wystarczający
$phoneKeyboardConverter = new PhoneKeyboardConverter();
echo $phoneKeyboardConverter->convertToNumeric('Ela nie ma kota') . "\n";
echo $phoneKeyboardConverter->convertToNumeric('abcdefghijklmnopqrstuvwxyz') . "\n";
echo $phoneKeyboardConverter->convertToString("5,2,22,555,33,222,9999,66,444,55") . "\n";
echo $phoneKeyboardConverter->convertToString("2,22,222,3,33,333,4,44,444,5,55,555,6,66,666,7,77,777,7777,8,88,888,9,99,999,9999");

