<?php
$str = 'Yemane Gebremedhin Birhane';

// zero limit
// print_r(explode(',',$str,0));
$pep = explode(' ',$str);
print($pep[1]);
// // positive limit
// print_r(explode(',',$str,2));

// // negative limit
// print_r(explode(',',$str,-1));
$name = 'girl.png';
$ext = explode('.', $name);
$ext = strtolower(end($ext));
print($ext);
$usernaming = explode(' ', 'yemane birhane');
$use = $usernaming[0];
echo $use;
?>
