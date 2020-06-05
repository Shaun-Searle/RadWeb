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

    <div class="statistics-container">

    <?php 
    
    // Creates Generic Graph
    createGraph("");

    // Checks database and creates graph with each Genre
    createAllGraphs(); 
    
    ?>

    </div>

</html>