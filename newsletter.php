<!DOCTYPE html>

<?php

     /**
      * Newsletter Page
      *
      * PHP Version 7.4.3
      *
      * @category Page
      * @package  MovieDB
      * @author   Shaun Searle <M204225@tafe.wa.edu.au>
      * @license  MIT https://opensource.org/licenses/MIT
      * @link     No Link
      */

      $currentPage = "Newsletter";

    require 'template/header.php';
    require 'scripts/function.php';
?>

<body>

<div class="container subscribe-container d-flex justify-content-center ">
<form class="bg-primary subscribe-form" id="subscribeForm" action="newsletter.php" method="post">
  <div class="form-row">
  <div class="form-group user-details">
    <label for="inputUsername">Full Name</label>
    <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Enter Full Name">
  </div>
    <div class="form-group user-details">
      <label for="inputEmail">Email address</label>
      <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Enter email">
    </div>
  </div>
  
<div class="form-row">
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="subRadio" id="bothRadio" checked="" value="both">
    <label class="form-check-label" for="bothRadio">Both</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="subRadio" id="monthlyRadio" value="monthly">
    <label class="form-check-label" for="monthlyRadio">Monthly</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="subRadio" id="hotRadio" value="hot">
    <label class="form-check-label" for="hotRadio">New Releases</label>
  </div>
<!-- <small id="emailHelp" class="form-text text-muted"></small> -->
  <button type="submit" id="btnSubmit" class="btn btn-outline-dark pull-right">Sign Up!</button>
  <br>

</div>
 

<div class="container mt-2">
  <?php 
  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $_POST['inputName'];
        $email = $_POST['inputEmail'];
        $sub = $_POST['subRadio'];

        $msg = "";

        if (empty($name)) {
            $msg .= "Name can not be empty!<br>";
        }
        if (empty($email)) {
            $msg .= "Email can not be empty!<br>";
        }
        if (empty($sub)) {
            $msg .= "Please select a subscription!<br>";
        }

        if (!empty($msg)) {
            echo sprintf('<div class="alert alert-danger" role="alert">%s</div>', $msg);
        } else {
             subscribe($name, $email, $sub);
        }

        // Main Search function returns echo for each item
    }
  
    ?>

</div>

<hr/>

<small> Had enough? <u><a id="unsub" href="unsubscribe.php">Unsubscribe</a></u></small>

</form>    

</div>

<div class="container">

    

</div>

<!-- </body> -->

</html>