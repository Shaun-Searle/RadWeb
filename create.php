<!DOCTYPE html>

<html>

    <?php
    
    /**
     * Create Admin Page
     *
     * PHP Version 7.4.3
     *
     * @category Page
     * @package  MovieDB
     * @author   Shaun Searle <M204225@tafe.wa.edu.au>
     * @license  MIT https://opensource.org/licenses/MIT
     * @link     No Link
     */
   
    $currentPage = "Create Admin";

    require 'template/header.php';
    require 'scripts/function.php';

    // Ensure user is logged in
    if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) {

        header('Location: admin.php');

    }

    if (!$_SESSION['perm_level'] >= 100) {

        header('Location: admin.php');
    }

    ?>

    <body>

    <div id="login">
        <div class="container bg-primary">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <form id="login-form" action="create.php" method="post">
                        <h3 class="text-center pt-2">Admin Creation</h3>
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
                                <input type="submit" name="btnCreateAdmin" class="btn btn-dark btn-md" value="Login">
                            </div>
                            </div>

                            <?php createAdmin() ?>
                            
                        </form>
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