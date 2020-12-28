<?php
$servername = "localhost";
$username = "root";
$password = "sql";

try 
{
  $wrs_node = new PDO("mysql:host=$servername;dbname=wrs_node", $username, $password);
  // set the PDO error mode to exception
  $wrs_node->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) 
{
  echo "Connection failed: " . $e->getMessage();
}
?>