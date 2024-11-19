<?php
// Database configuratie
$host  = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "boer-bert";

// Maak een  database connectie
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// if(mysqli_connect_error())
// {
//  echo "Connection establishing failed!";
// }
// else
// {
//  echo "Connection established successfully.";
// }