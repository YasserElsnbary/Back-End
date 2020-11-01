<?php 

    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';
    if (isset($_SESSION['Username'])) {
        header('Location: dashboard.php'); // Redirect io Dashboard Page
    }
    include "init.php";
   

    // check if user coming from POST Method
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        // check if user exist in db

        $stmt = $con->prepare(" SELECT
                                    UserID, Username,Password 
                                FROM 
                                    users 
                                WHERE 
                                    Username = ? 
                                AND 
                                    Password = ? 
                                AND 
                                    GroupID = 1
                                LIMIT 1");
        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        // if count > 0  -> contain record;

        // echo $count;

        if ($count > 0) {
            print_r($row);
            $_SESSION['Username'] = $username; // Register User Session Name
            $_SESSION['ID'] = $row['UserID']; // Register Session ID
            header('Location: dashboard.php'); // Redirect io Dashboard Page
            exit();
        }
    }

?>




 <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
     <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
    <input class="btn btn-primary btn-block" type="submit" value="Login">
 </form>
 

<?php 

    include $tpl . "footer.php";

?>