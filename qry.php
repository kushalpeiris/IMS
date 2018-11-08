<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'imsdb';
function connectDB($hostname, $username, $password)
   {
      $connect = mysql_connect($hostname, $username, $password);
      if(!$connect)
      {
         echo 'Database connection failed!<br/>';
      }
      else
      {
         echo "Database connection success.<br/>$connect<br/>";
         return $connect;
      }
   }
function opendb($dbname, $con)
   {
      if(!mysql_select_db($dbname, $con))
      {
         echo "Failed to open database $dbname!<br/>";
      }
      else
      {
         echo "Successfully connected to database $dbname<br/>";
      }
   }
$con = connectDB($hostname, $username, $password);
$str = "CREATE DATABASE $dbname;";
   if($result = mysql_query($str, $con))
   {
      echo "Database $dbname created successfully.<br/>";
   }
   else
   {
      echo "Failed to create database $dbname, check for duplicates!<br/>";
   }
   opendb($dbname, $con);
   
// Create Table: Users
   $str = "CREATE TABLE users(";
   $str .= "username varchar(12) NOT NULL, ";
   $str .= "password varchar(10) NOT NULL, ";
   $str .= "PRIMARY KEY (username) ";
   $str .= ") ENGINE=INNODB;";
   echo "<br/>Executing query: $str<br/>";
   if($result = mysql_query($str, $con))
   {
      echo 'Table users created successfully.<br/>';
   }
   else
   {
      echo 'Failed to create table users!<br/>';
   }
?>