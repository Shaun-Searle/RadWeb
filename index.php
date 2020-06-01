<!DOCTYPE html>

<?php

     /**
      * Index Page
      *
      * PHP Version 7.4.3
      *
      * @category Page
      * @package  MovieDB
      * @author   Shaun Searle <M204225@tafe.wa.edu.au>
      * @license  MIT https://opensource.org/licenses/MIT
      * @link     No Link
      */

      $currentPage = "Home";

    require 'template/header.php';
    require 'scripts/function.php';
?>



<div id="popCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#popCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#popCarousel" data-slide-to="1"></li>
      <li data-target="#popCarousel" data-slide-to="2"></li>
      <li data-target="#popCarousel" data-slide-to="3"></li>
      <li data-target="#popCarousel" data-slide-to="4"></li>
      <li data-target="#popCarousel" data-slide-to="5"></li>
      <li data-target="#popCarousel" data-slide-to="6"></li>
      <li data-target="#popCarousel" data-slide-to="7"></li>
      <li data-target="#popCarousel" data-slide-to="8"></li>
      <li data-target="#popCarousel" data-slide-to="9"></li>
    </ol>
    <div class="carousel-inner">

    <?php @createCarousel(); ?>

</div>
    <a class="carousel-control-prev" href="#popCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#popCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

<body class="col-sm-10">

      <div class="row">
        <div class="center">
        <div class="card-container align-self-center">
        <h1 class="m-2">Comedy</h1>
            <?php @listGenre(20, "Comedy"); ?>
        </div>

        <div class="card-container">
        <h1 class="m-2">Action/Adventure</h1>
            <?php @listGenre(20, "Action/Adventure"); ?>
        </div>

        <div class="card-container">
        <h1 class="m-2">Drama</h1>
            <?php @listGenre(20, "Drama"); ?>
        </div>

        <div class="card-container">
        <h1 class="m-2">SciFi</h1>
            <?php @listGenre(20, "SciFi"); ?>
        </div>

        <div class="card-container">
        <h1 class="m-2">Family</h1>
            <?php @listGenre(20, "Family"); ?>
        </div>
        </div>
    </div>
</body>

</html>