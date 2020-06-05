<!DOCTYPE html>

<html>

    <?php 

    /**
     * Search Page
     *
     * PHP Version 7.4.3
     *
     * @category Page
     * @package  MovieDB
     * @author   Shaun Searle <M204225@tafe.wa.edu.au>
     * @license  MIT https://opensource.org/licenses/MIT
     * @link     No Link
     */
   
    $currentPage = "Search";

    require 'template/header.php';
    require 'scripts/function.php';

    ?>
    
    <body>
    <div class="adv-search">
    <article>
    <?php 
        // Advanced Search Form
        echo '<form action="./search.php" method="post" class="">
        <h2 class="w-100">Advanced Search</h2>
        <div class="form-group w-100">
        <label for="searchTerm"></label>
        <input type="text" class="form-control" name="searchTerm" placeholder="Search">
        </div>

        <div class="form-group">
        <label for="searchGenre"></label>
        <input type="text" class="form-control-sm" name="searchGenre" placeholder="Genre">
        ';
        @ratingCombo(); //Populates combobox for rating
        
        echo '</div>

        <div class="form-group">
        <label for="searchYear"></label>
        <input type="text" class="form-control-sm space-size" name="searchYear" placeholder="Year">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>';
    

    ?>
    </article>
    </div>
    <div class="card-container"><?php 

    // Search bar is handled on same page
    if (isset($_GET['searchBar'])) {

        // Main Search function returns echo for each item
        searchDB($_GET['searchBar'], "", "", "");
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $term = $_POST['searchTerm'];
        $genre = $_POST['searchGenre'];
        $rating = $_POST['searchRating'];
        $year = $_POST['searchYear'];

        // Main Search function returns echo for each item
        searchDB($term, $genre, $rating, $year);
    }

    ?></div>
    </div>

    </body>
</html>