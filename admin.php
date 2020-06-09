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

    ?>
    <body>
    <div id="login">
        <div class="container bg-primary">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <form id="login-form" action="newsletter.php" method="post">
                        <h3 class="text-center pt-2">Admin Login</h3>
                            <div class="form-group">
                                <label for="username" class="">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="password" class="">Password:</label><br>
                                <input type="text" name="password" id="password" class="form-control" placeholder="Enter password">
                            </div>
                            <div class="form-group text-right">
                                <input type="submit" name="submit" class="btn btn-dark btn-md" value="Login">
                            </div>
                        
                        </form>
                    </div>
                </div>

            </div>
        </div>



  
</div>
</body>
</html>