<!DOCTYPE html>

<html>

    <?php
    
    /**
     * Admin Login/Display Page
     *
     * PHP Version 7.4.3
     *
     * @category Page
     * @package  MovieDB
     * @author   Shaun Searle <M204225@tafe.wa.edu.au>
     * @license  MIT https://opensource.org/licenses/MIT
     * @link     No Link
     */
   
    $currentPage = "Admin";

    require 'template/header.php';
    require 'scripts/function.php';

    if (isset($_POST['btnLogout'])) {

        $_SESSION["loggedIn"] = false;
    }

    // Only do this if user is "logged in"
    if (@$_SESSION["loggedIn"] === true) {

        // Performs user deletion from posted variable
        if (isset($_POST['delID'])) {

            removeSub($_POST['delID']);
        }

        subscriberTable();

        echo "<script>
            $( document ).ready(function() {
            $('#subTable tr > *:nth-child('+1+')').toggle();
        
            $('#login').hide();
            });</script>";
    }

    ?>

    <body>
    <div id="login" <?php $hideLogin ?>>
        <div class="container bg-primary">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <form id="login-form" action="admin.php" method="post">
                        <h3 class="text-center pt-2">Admin Login</h3>
                            <div class="form-group">
                                <label for="adminUsername" class="">Username:</label><br>
                                <input type="text" name="adminUsername" id="adminUsername" class="form-control" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="password" class="">Password:</label><br>
                                <input type="password" name="adminPassword" id="adminPassword" class="form-control" placeholder="Enter password">
                                <input type="checkbox" onclick="showPass()" id="checkPass" class="mt-3">
                                <label for="checkPass">Show Password</label>
                                
                                <div class="form-group text-right">
                                <input type="submit" name="btnLogin" class="btn btn-dark btn-md" value="Login">
                            </div>
                            </div>

                            <?php checkAdmin(); ?>
                         
                        </form>
                    </div>
                </div>
            </div>
        </div>



  
</div>

<script>

function showPass() {
  var x = document.getElementById("adminPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

</script>


</body>

</html>