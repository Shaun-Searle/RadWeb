<?php 

/**
 * Functions File
 *
 * PHP Version 7.4.3
 *
 * @category Script
 * @package  MovieDB
 * @author   Shaun Searle <M204225@tafe.wa.edu.au>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     No Link
 */


session_start();

// Load mail 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

/**
 * Retrieves amount of movies of genre both provided
 *
 * @param [Integer] $amount Amount of movies to return
 * @param [String]  $genre  Genre of movies to return
 * 
 * @return void
 */
function listGenre($amount, $genre)
{
    include 'connect.php';

    if ($conn->ping()) {
        $sql = sprintf("SELECT Title, ID FROM movies WHERE Genre = '$genre' ORDER BY Popularity DESC LIMIT $amount");
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $title = $row['Title'];

                $ID = $row['ID'];

                // Fetch response
                $response = @queryAPI($title);

                if (isset($response)) {

                    // Sets image to poster path to append to image url
                    @$image = $response['results'][0]['poster_path'];
                    

                    echo '<div class="ml-item"><a href="./info.php?m=' . $ID . '"><img src="http://image.tmdb.org/t/p/w185/' . $image . '" alt="' . $title . ' "/>
                            <div class="text-centre-card">
                                <p class="card-text">'. $title .'</p>
                             </div></a>
                    </div>';
                }
            }
        } else {
            echo '<p>No results<p>';
        }

    } else {
        echo '<h1>CONNECTION FAILED TO DATABASE<h1>';
    }

}

/**
 * Handles all Search
 *
 * @param [type] $search Search Term
 * @param [type] $genre  Search Genre
 * @param [type] $rating Search Rating
 * @param [type] $year   Search Year
 * 
 * @return void Return breaks out of empty search
 */
function searchDB($search, $genre, $rating, $year) 
{

    if ($search == "" && $genre == "" && $rating == "" && $year == "") {
        echo '<h3 class="alert alert-danger m-2">No Results!</h3>';
        return;
    }

    include 'connect.php';

    // Terniary for building Where string allowing missing search terms
    $search = "WHERE Title LIKE '%%$search%%'";

    $genre  = ($genre  == "") ? "" : "AND Genre  = '$genre'";
    $rating = ($rating == "") ? "" : "AND Rating = '$rating'";
    $year   = ($year   == "") ? "" : "AND `Year` = '$year'";

    $where = sprintf("$search $genre $rating $year");

    if ($conn->ping()) {

        $sql = sprintf("SELECT ID, Title FROM movies %s LIMIT 100", $where);

        $result = $conn->query($sql);


        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $title = $row['Title'];
                $ID = $row['ID'];
                addPopularity($ID, 0.1);
                
                $response = queryAPI($title);

                if (isset($response)) {

                    @$image = $response['results'][0]['poster_path'];
            
                    echo '<div class="ml-item"><a href="./info.php?m=' . $ID . '"><img src="http://image.tmdb.org/t/p/w185/' . $image . '" alt="' . $title . ' "/>
                            <div class="text-centre-card">
                                <p class="card-text">'. $title .'</p>
                             </div></a>
                    </div>';
                }
            }
        } else {
            echo '<p>No results<p>';
        }

    } else {
        echo '<h1>CONNECTION FAILED TO DATABASE<h1>';
    }
}

/**
 * Adds popularity to database record
 *
 * @param [int]    $ID     ID of movie to add popularity
 * @param [String] $amount Amount of popularity to add
 * 
 * @return void
 */
function addPopularity($ID, $amount) 
{
    // Check for ID not empty
    if ($ID > 0) {

        include 'connect.php';

        // Update to set popularity of ID
        $sql = sprintf("UPDATE movies SET Popularity = Popularity + $amount WHERE ID = $ID");
        $conn->query($sql);
    }
    
}

/**
 * Function for creating carousel from top 10 popular movies
 *
 * @return void
 */
function createCarousel() 
{
    include 'connect.php';

    $sql = sprintf("SELECT * FROM movies ORDER BY Popularity DESC LIMIT 10");
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $i = 0;

        while ($row = $result->fetch_assoc()) {

            $ID = $row['ID'];
            $response = queryAPI($row['Title']);

            if (empty($response['results'][0]['backdrop_path'])) {
                $image = $_SERVER['SERVER_NAME'] . '/moviedb/image/noBack.png';
            } else {
                $image = 'http://image.tmdb.org/t/p/original' . $response['results'][0]['backdrop_path'];
            }
            
            @$desc = $response['results'][0]['overview'];

            echo '<div class="carousel-item ' . ($i == 0 ? 'active' : '') . '">
            <a href="./info.php?m=' . $ID . '"><img class="w-100 h-100" src=' . $image . ' alt="No Image">
            <div class="carousel-caption">
                <h5>'. $row['Title'] . '</h5>
                <p>' . $desc . '</p>
            </div>
            </a>
          </div>';

            $i++;

        }
    }

}

/**
 * Creates a PHPGD graph outputs to file and echos image element
 *
 * @param [String] $genre Genre to query database for top 10. Empty will search overall
 * 
 * @return void Return is used to break out of a no connection state
 */
function createGraph($genre) 
{

    //Get Data Set

    @include 'connect.php';

    if (!@$conn->ping()) {
        echo '<h2 class="m-2">No Connection to database!</h2>';
        return;
    }
    $where = "";

    // Terniary for manipulating $sql and setting $genre if needed
    ($genre == "") ? $genre = "All" : $where = "WHERE Genre = '$genre'";

    // sql for top ten by popularity matching genre
    $sql = sprintf("SELECT * FROM movies $where ORDER BY Popularity DESC LIMIT 10");
    
    // Perform query retrieve results
    $result = $conn->query($sql);

    // Messed with moving results into an array to hold them properly declared here
    // Faster and simpler to rearrange chart building like I did.
    // Should be changed back to array here for flexibility

    /*
    * Chart properties
    */

    // Image dimensions
    $imageWidth = 700;
    $imageHeight = 400;

    // Grid dimensions and placement within image
    $gridTop = 40;
    $gridLeft = 50;
    $gridBottom = 340;
    $gridRight = 650;
    $gridHeight = $gridBottom - $gridTop;
    $gridWidth = $gridRight - $gridLeft;

    // Text Rotation
    $rot = 270;


    // Bar and line width
    $lineWidth = 1;
    $barWidth = 25;

    // Font settings
    $font = __DIR__ . '/../Roboto-Regular.ttf';
    $fontSize = 10;

    // Margin between label and axis
    $labelMargin = 8;

    // Max value on y-axis changed later default 5
    $yMaxValue = 5;

    // Distance between grid lines on y-axis
    $yLabelSpan = 0;

    // Init image
    $chart = imagecreate($imageWidth, $imageHeight);

    // Setup colors
    $backgroundColor = imagecolorallocate($chart, 255, 255, 255);
    $axisColor = imagecolorallocate($chart, 246, 100, 140);
    $labelColor = imagecolorallocate($chart, 85, 85, 85);
    $gridColor = imagecolorallocatealpha($chart, 246, 100, 140, 20); // Alpha is 0 - 127
    $barColor = imagecolorallocate($chart, 246, 100, 140);

    imagefill($chart, 0, 0, $backgroundColor);

    imagesetthickness($chart, $lineWidth);

    

    //Draw x and y lines

    imageline($chart, $gridLeft, $gridTop, $gridLeft, $gridBottom, $axisColor);
    imageline($chart, $gridLeft, $gridBottom, $gridRight, $gridBottom, $axisColor);

    //Draw bars and labels in relation to each

    $barSpacing = $gridWidth / 10;
    $itemX = $gridLeft + $barSpacing / 2;

    while ($row = $result->fetch_assoc()) {
        $key = $row['Title'];
        $value = $row['Popularity'];

        if (strlen($key) >= 30) {
            $key = substr($key, 0, 30) . "...";

        }
        // Not sure how to get max of the resultset we already have easily so it's checked each row
        $yMaxValue = ($yMaxValue < $value) ? $value : $yMaxValue;

        $x1 = $itemX - $barWidth / 2;
        $y1 = $gridBottom - $value / $yMaxValue * $gridHeight;
        $x2 = $itemX + $barWidth / 2;
        $y2 = $gridBottom - 1;

        imagefilledrectangle($chart, $x1, $y1, $x2, $y2, $barColor);

        // Draw the label for title part way up chart
        $labelBox = imagettfbbox($fontSize, $rot, $font, $key);
        $labelWidth = $labelBox[4] - $labelBox[0];

        $labelX = $itemX - $labelWidth / 2;
        $labelY = $gridHeight * 0.25;

        imagettftext(
            $chart, 
            $fontSize, $rot,
            $labelX, $labelY, $labelColor, $font, $key
        );
            // Value at bottom label
            $labelBox = imagettfbbox($fontSize, $rot, $font, $value);
            $labelWidth = $labelBox[4] - $labelBox[0];
    
            $labelX = $itemX - $labelWidth / 2;
            $labelY = $gridBottom + $labelMargin + $fontSize;
    
            imagettftext(
                $chart, 
                $fontSize, $rot,
                $labelX, $labelY, $labelColor, $font, $value
            );
        

        $itemX += $barSpacing;
    }

    // Printing grid lines
    $yLabelSpan = $yMaxValue / 2;

    for ($i = 0; $i <= $yMaxValue; $i += $yLabelSpan) {
        $y = $gridBottom - $i * $gridHeight / $yMaxValue;

        // Line draw
        imageline($chart, $gridLeft, $y, $gridRight, $y, $gridColor);

        // Label draw while lined up
        $labelBox = imagettfbbox($fontSize, 0, $font, strval($i));
        $labelWidth = $labelBox[4] - $labelBox[0];

        $labelX = $gridLeft - $labelWidth - $labelMargin;
        $labelY = $y + $fontSize / 2;

        imagettftext($chart, $fontSize, 0, $labelX, $labelY, $labelColor, $font, strval($i));
    }
    //Draw Genre label
    imagettftext($chart, $fontSize, 90, $labelX, $gridHeight, $axisColor, $font, ("Genre: " . $genre));
    /*
    * Output image file.
    */

    $genre = ($genre != "") ? str_replace("/", "-", $genre) : "All";

    imagepng($chart, './image/' . $genre . '-graph.png');

    echo sprintf('<img class=stat-image src="./image/%s-graph.png" alt="No Image"></img>', $genre);

    imagedestroy($chart);
}

/**
 * Queries TheMovieDatabase API for img and description data
 *
 * @param [String] $title Accepts title to be split for search 
 * 
 * @return $json Json object from api response after decode
 */
function queryAPI($title) 
{

    $base_request = "https://api.themoviedb.org/3/search/movie?api_key=6a7eee2d24ccc68afdec3e0d6307cbc6&query=";

    // Consider replacing , as well

    $searchTitle = str_replace(" ", "+", $title);

    $searchTitle = preg_replace("/\([^)]+\)/", "", $searchTitle);

    $searchTitle = preg_replace("/\:.*(Edition)[^:]*/", "", $searchTitle);

    $response = file_get_contents($base_request . $searchTitle);

    $json = json_decode($response, true);
    return $json;
}

/**
 * Generates contents of rating combobox (Could be made generic so genre can be generated here too)
 *
 * @return void
 */
function ratingCombo() 
{
    
    include 'connect.php';

    if ($conn->ping()) {
        $sql = sprintf("SELECT DISTINCT Rating FROM movies");
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            echo '<label for="searchRating"></label>
                <select class="form-control-sm ml-0 mr-1" name="searchRating">
                <option></option>
                ';

            while ($row = $result->fetch_assoc()) {

                $rating = $row['Rating'];

                echo "<option>$rating</option>";
            }
        }

    } else {
        echo '<div class="alert alert-danger" role="alert">
        No Database Connection!
        </div>';
    }
}

/**
 * Runs CreateGraph() for each genre in database
 *
 * @return void
 */
function createAllGraphs() 
{

    @include 'connect.php';

    if (!@$conn->ping()) {
        echo '<h2 class="m-2">No Connection to database!</h2>';
        return;
    }

    $sql = sprintf("SELECT DISTINCT Genre FROM movies");
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $genre = $row['Genre'];

        createGraph(addslashes($genre));

    }
}

/**
 * Function for subscribing user to newsletter
 *
 * @param [type] $name  Full name of user
 * @param [type] $email Email of user
 * @param [type] $sub   Chosen subscription type
 * 
 * @return void
 */
function subscribe($name, $email, $sub) 
{

    @include 'connect.php';

    if (!@$conn->ping()) {
        echo '<h2 class="m-2">No Connection to database try again later!</h2>';
        return;
    }

    $email = strtolower($email);

    if(!preg_match('/^[a-zA-Z0-9\s]{3,50}$/', $name)) { 

        echo '<div class="alert alert-danger" role="alert">Please enter valid username!</div>';
        return;
    }


    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo '<div class="alert alert-danger" role="alert">Please enter valid email!</div>';
        return;
   }


    $sql = sprintf("SELECT DISTINCT email FROM subscribers WHERE email = '$email'");

    $result = $conn->query($sql);

    $sql = "";

    if ($result->num_rows === 0) {
        $sql = sprintf("INSERT INTO subscribers (full_name, email, subscriptions) VALUES ('$name', '$email', '$sub')");
        echo '<div class="alert alert-success" role="alert">Successfully subscribed</div>';
    } else {
        $sql = sprintf("UPDATE subscribers SET full_name = '$name', subscriptions = '$sub', is_deleted = '0' WHERE email = '$email'");
        echo '<div class="alert alert-success" role="alert">Updated existing subscription</div>';
    }

    $conn->query($sql);

    if ($sub === "both") {
        $cat = "Monthy and New Releases Newsletters.";
    } else {
        $cat = ($sub === "monthly") ? "Monthly": "New Releases";
        $cat .= " Newsletter.";
    }

    $message = sprintf("Hello %s,\n\nYou have successfully subscribed to the %s\n\nUnsubscribe any time on the subscribe page of the website!", $name, $cat, $email);


    sendMail($email, "MovieDB - Subscription", $message);

}

/**
 * Checks if admin login is valid and logs user in
 *
 * @return void
 */
function checkAdmin() 
{

    if (isset($_POST['btnLogin'])) {

        $admin = $_POST['adminUsername'];
        $password = $_POST['adminPassword'];

        if (!preg_match('/^[a-zA-Z0-9\s]{3,50}$/', $admin)) { 

            echo '<div class="alert alert-danger" role="alert">Please enter valid username!</div>';
            return;
        }

        // Hardcoded login
        $harcodedAdmin = "admin";
        $hardcodedPassword = "password";

        if ($admin === $harcodedAdmin && $password === $hardcodedPassword) {
            $_SESSION["loggedIn"] = true;
            header('Location: admin.php');
        } else {
            echo '<div class="alert alert-success" role="alert">Invalid Login</div>';
        }

        

    }

}

/**
 * Displays all subscriber in database
 *
 * @return void
 */
function subscriberTable() 
{

    @include 'connect.php';

    if (!@$conn->ping()) {
        echo '<h2 class="m-2">No Connection to database try again later!</h2>';
        return;
    }

    $sql = sprintf("SELECT * FROM subscribers WHERE is_deleted = '0'");

    $result = $conn->query($sql);

    echo '  <div class="subTable table-responsive">
            <h2>Subscriber List<div class="btn-logout ml-3">
            <form action="admin.php" method="post" class="btn-logout">
                <input type="submit" name="btnLogout" value="Logout" class="btn btn-sm btn-danger btn-logout">
                  </form>
            </div></h2>
            <table class="table table-striped subTable" id="subTable">
            <thead class="thead thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Subscriptions</th>
                <th scope="col">Remove?</th>
                </tr>
            </thead>
        <tbody>';


    if (mysqli_num_rows($result)==0) {

        echo '<tr>
                <th scope=row></th>
                <td>No Subscribers!</td>
                <td></td>
                <td></td>
                <td></td>
                </tr>';
                    
    } else {

        while ($row = $result->fetch_assoc()) {

            $id = $row['subscriber_id'];
            $username = $row['full_name'];
            $email = $row['email'];
            $subscriptions = $row['subscriptions'];

            echo "<tr>";
            echo "<th scope=row>$id</th>";
            echo "<td>$username</td>";
            echo "<td>$email</td>";
            echo "<td>$subscriptions</td>";
            echo '<td><form action="admin.php" method="post">
                <input type="hidden" name="delID" value="'. $id .'">
                <input type="submit" name="submit" value="Remove" class="btn btn-sm btn-danger">
              </form></td>';
            echo "</tr>";


        }

        echo '</tbody></table></div>';

    }
}


/**
 * Marks and requests User removal in database
 *
 * @param [type] $id User Id to be removed
 * 
 * @return void
 */
function removeSub($id) 
{

    @include 'connect.php';

    if (!@$conn->ping()) {
        echo '<h2 class="m-2">No Connection to database try again later!</h2>';
        return;
    }

    $sql = sprintf("UPDATE subscribers SET is_deleted = '1' WHERE subscriber_id = $id");

    $conn->query($sql);

    sendMail(ADMIN_EMAIL, "Removal Request - Automated", "Please remove User ID: $id From the database. \n\n Automated Alert - MovieDB\n Do not reply.");

}

function unsubscribe($email) {

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo '<div class="alert alert-danger" role="alert">Please enter valid email!</div>';
        return;
   }

    @include 'connect.php';

    if (!@$conn->ping()) {
        echo '<h2 class="m-2">No Connection to database try again later!</h2>';
        return;
    }

    $sql = sprintf("SELECT subscriber_id FROM subscribers WHERE email = '$email' AND is_deleted = 0");

    $result = $conn->query($sql);

    if ($result->num_rows === 0) { 

        echo '<div class="alert alert-danger" role="alert">Email was not subscribed!.</div>';
    } else {
        $row = $result->fetch_assoc();

        removeSub($row['subscriber_id']);
    }

}

/**
 * SendMail Function
 *
 * @param [type] $target  Target email address
 * @param [type] $subject Subject of email
 * @param [type] $body    Body of email
 * 
 * @return void
 */
function sendMail($target, $subject, $body) 
{

    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // SMTP::DEBUG_OFF = off (for production use)
    // SMTP::DEBUG_CLIENT = client messages
    // SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    //Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = 'moviedbmailer@gmail.com';

    //Password to use for SMTP authentication
    $mail->Password = 'easypassword5';
    
    //Set who the message is to be sent from
    $mail->setFrom('moviedbmailer@gmail.com', 'MovieDB Admin');

    //Set an alternative reply-to address
    $mail->addReplyTo('moviedbmailer@gmail.com', 'MovieDB Admin');

    //Set who the message is to be sent to
    $mail->addAddress($target);

    //Set the subject line
    $mail->Subject = $subject;

    //Set Body
    $mail->Body = $body;

    //send the message, check for errors
    if (!$mail->send()) {
        // Will need to enable server debug as well if using
        // echo 'Mailer Error: '. $mail->ErrorInfo;

        echo '<div class="alert alert-danger" role="alert">Unable to Mail admin.</div>';
    } else {
        echo '<div class="alert alert-success" role="alert">Sent Email Alert</div>';

    }
}

?>