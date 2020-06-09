<?php

/**
 * PHP Template for building header and nav
 *
 * PHP Version 7.4.3
 *
 * @category Template
 * @package  MovieDB
 * @author   Shaun Searle <M204225@tafe.wa.edu.au>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     No Link
 */

//Array of pages with path assosiated
$pages = array(
    'Home' => '/moviedb',
    'Search' => '/moviedb/search.php',
    'Statistics' => '/moviedb/statistics.php',
    'Newsletter' => '/moviedb/newsletter.php',
    'Admin' => '/moviedb/admin.php'
    
);

?>
<head>
    <!-- Header style and bootstrap import -->
    <title><?php echo $currentPage ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME'] . "/moviedb/css/bspink.css" ?>">
    <link rel="stylesheet" href="css/style.css?<?php echo time()?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>

<!-- Navbar and menu -->
<header>
    <div class="row">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <a class="navbar-brand" href="http://<?php echo $_SERVER['SERVER_NAME'] . "/moviedb" ?>">MovieDB</a>
    <button 
        class="navbar-toggler" 
        type="button" 
        data-toggle="collapse" 
        data-target="#navbarNav"
        aria-controls="navbarNav" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="nav navbar-nav ml-auto">
        <li><form class="form-inline" action="search.php" Method="GET">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" id="navSearch" name="searchBar">
    </form></li>
            <?php

            
            // Echo the array above and add them as navbar list items
            foreach ($pages as $name => $url) {
                echo '<li><a class="nav-item nav-link' . (($currentPage === $name) ? ' active" ' : '"') .
                ' href="' . $url . '">' . $name . '</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>
        </div>
</header>
