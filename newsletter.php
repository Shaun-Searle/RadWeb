<!DOCTYPE html>

<?php

     /**
      * Newsletter page Page
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

<div class="subscribe-container d-flex justify-content-center align-items-center">
<form class="bg-primary subscribe-form">
<div class="form-group">
    <label for="inputUsername">Full Name</label>
    <input type="email" class="form-control form-control-sm" id="inputUsername" aria-describedby="userHelp" placeholder="Enter Full Name">
    <!-- <small id="emailHelp" class="form-text text-muted"></small> -->
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <!-- <small id="emailHelp" class="form-text text-muted"></small> -->
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="checkReleases">
    <label class="form-check-label" for="checkReleases">Hot List</label>
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="checkMonthly">
    <label class="form-check-label" for="checkMonthly">Monthly</label>
  </div>
  <button type="submit" class="btn btn-dark mt-2">Submit</button>
</form>    

</div>

</body>

</html>