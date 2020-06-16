<!DOCTYPE html>

<html>

    <?php
    
    /**
     * Display Movie info page
     *
     * PHP Version 7.4.3
     *
     * @category Page
     * @package  MovieDB
     * @author   Shaun Searle <M204225@tafe.wa.edu.au>
     * @license  MIT https://opensource.org/licenses/MIT
     * @link     No Link
     */
   
    $currentPage = "Info";

    require 'template/header.php';
    require 'scripts/function.php';

    ?>
    <body>
    <div class="main-content">

    <?php 

    require 'scripts/connect.php';

    $ID = $_GET['m'];
    
    if ($conn->ping()) {
        if (isset($ID)) {

            // Handles voting
 
            if (isset($_POST['upvote'])) {
                addPopularity($ID, "", 1);
            }

            if (isset($_POST['downvote'])) {
                addPopularity($ID, "", -1);
            }

            // Gets Movie from database
            $sql = sprintf("SELECT * FROM movies WHERE ID = $ID");
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $title = $row['Title'];

                $response = queryAPI($title);
                $desc = ($response['results'][0]['overview'] != "" ? $response['results'][0]['overview'] : "No Description Found.");
                $genre = $row['Genre'];
                $year = $row['Year'];
                $rating = $row['Rating'];
                $studio = $row['Studio'];
                $status = $row['Status'];
                $retailp = $row['RecRetPrice'];
                $aspect = $row['Aspect'];
                $popularity = $row['Popularity'];

                if (empty($response['results'][0]['backdrop_path'])) {
                    $image = $_SERVER['SERVER_NAME'] . '/moviedb/image/noBack.png';
                } else {
                    $image = 'http://image.tmdb.org/t/p/original' . $response['results'][0]['backdrop_path'];
                }

                // Result Formatting


                echo "<div class=info-cover style=background-image:url($image)>
                        </div>
                        
                        <div class=mv-info>
                            <div class=movieDesc>
                            <h1 class=info-title>$title</h1>";
                            

                            echo "<p class=desc>$desc</p>
                            <div class=mvi-left>
                                <p><strong>Genre: </strong>$genre</p>
                                <p><strong>Year: </strong>$year</p>
                                <p><strong>Rating: </strong>$rating</p>
                                <p><strong>Studio: </strong>$studio</p>
                            </div>
                            <div class=mvi-right>
                                <p><strong>Status: </strong>$status</p>
                                <p><strong>Retail Price: </strong>$retailp</p>
                                <p><strong>Aspect: </strong>$aspect</p>
                                <p><strong>Popularity: </strong>$popularity</p>
                            </div>";

                            echo '<form action="" method="post"><div class="vote">
                            <small><u>Rate Me!</u></small>
                            <input type="submit" name="upvote" value="" class="btn btn-upvote"></input>
                            <input type="submit" name="downvote" value="" class="btn btn-downvote"></input></div>';

                        echo "</div>
                    </div>";
                    
                            
                
            }
        } else {
            echo "<h2>Movie Not Found</h2>";
        }
    } else {
        echo "<h1>No connection to database!</h1>";
    }

    ?>
  
</div>
</body>
</html>