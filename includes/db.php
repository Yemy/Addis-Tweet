<?php

  $server = "sql204.epizy.com";
  $username = "epiz_33062638";
  $password = "EprnmWn5Gy";
  $dbname = "epiz_33062638_addistweet";

  $conn = mysqli_connect($server, $username, $password, $dbname);

  if(!conn){
    die("Connection failed:".mysqli_connect_error());
  }

?>
