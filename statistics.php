<!DOCTYPE html>

<html>

    <?php 

    /**
     * Statistics page
     *
     * PHP Version 7.4.3
     *
     * @category Page
     * @package  MovieDB
     * @author   Shaun Searle <M204225@tafe.wa.edu.au>
     * @license  MIT https://opensource.org/licenses/MIT
     * @link     No Link
     */
   
    $currentPage = "Statistics";

    require 'template/header.php';
    require 'scripts/function.php';

    ?>
    
    </body>
    <div class="row main-content">

    <div class="d-flex flex-wrap">

    <?php 
    
    // Creates Generic Graph
    createGraph("");

    // Checks database and creates graph with each Genre
    createAllGraphs(); 
    
    ?>
  

    </div>

    </div>
</html>