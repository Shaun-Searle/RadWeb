<?php

/**
 * MySQLI Connection Script
 *
 * PHP Version 7.4.3
 *
 * @category Script
 * @package  MovieDB
 * @author   Shaun Searle <M204225@tafe.wa.edu.au>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     No Link
 */

    // mysqli connection script
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "movie_db";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection

}
catch(Exception $e) 
{
    die("Connection failed: " . $conn->connect_error);
}
    
?>