<!DOCTYPE html>

<?php

     /**
      * Unsubscribe Page
      *
      * PHP Version 7.4.3
      *
      * @category Page
      * @package  MovieDB
      * @author   Shaun Searle <M204225@tafe.wa.edu.au>
      * @license  MIT https://opensource.org/licenses/MIT
      * @link     No Link
      */

      $currentPage = "Unsubscribe";

    require 'template/header.php';
    require 'scripts/function.php';
?>

<body>
<div class="container">
  <?php 
  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['inputEmail'];

        $msg = "";

        if (empty($email)) {
            $msg .= "Email can not be empty!<br>";
        }

        if (!empty($msg)) {
            echo sprintf('<div class="alert alert-danger" role="alert">%s</div>', $msg);
        } else {
             unsubscribe($email);
        }
        
    }
    ?>

</div>

<div class="container subscribe-container d-flex justify-content-center ">
<form class="bg-primary subscribe-form" id="subscribeForm" action="unsubscribe.php" method="post">
  <div class="form-row">
    <div class="form-group w-100">
      <label for="inputEmail">Email address</label>
      <input type="email" class="form-control" name="inputEmail" id="inputEmail1" placeholder="Enter email">
    </div>
  </div>
  
  <button type="submit" id="btnSubmit" class="btn btn-outline-dark pull-right">Unsubscribe!</button>
  <br>
  <!-- </div> -->
</div>

</form>    

</body>

</html>