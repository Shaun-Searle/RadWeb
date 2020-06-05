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
    
    // Constants for connection
    require_once 'config.php';

try {
    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection

}
catch(Exception $e) 
{
    die("Connection failed: " . $conn->connect_error);
}
    
?>