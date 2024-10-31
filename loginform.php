<?php
/**
 * Author: Group Project
 * Date: 15/05/2023
 * Description: This script checks login status first. Based on the login status, it then displays a proper message.
 * If the login status is not 1 or 3, the script also displays the login form.
 * check login status:
 * 1 -- last login attempt success
 * 2 -- last login attempt failed.
 * 3 -- user just registered. Logged in automatically.
 * other -- new login attempt
 *
 */
$page_title = "Colts Login";
require_once('includes/header.php');
?>
    <h2>Login or Register</h2>

<?php
$message = "Please enter your username and password to login.";
$login_status = '';
if (isset($_SESSION['login_status']))
    $login_status = $_SESSION['login_status'];

//the user's last login attempt succeeded
if ($login_status == 1) {
    echo "<p> You are logged in as " . $_SESSION['login'] . ".</p>";
    echo "<a href='logout.php'> Log out</a>";
    include('includes/footer.php');
    exit();
}
// the user's last login attempt failed
if ($login_status == 2) {
    if (filter_has_var(INPUT_GET, 'm')) {
        $message = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_STRING);
    } else {
        $message = "Username or password invalid. Please try again.";
    }
}
//the user has just registered
if ($login_status == 3) {
    echo "<p> Thank you for registering with us. Your account has been created.</p>";
    echo "<a href='logout.php'> Log out</a>";
    include('includes/footer.php');
    exit();
}


?>
    <div class="login-container">
        <!-- display the login form -->
        <div class="login">
            <form method='post' action='login.php'>
                <table>
                    <tr>
                        <td colspan="2"><?php echo $message; ?></br><br></td>
                    </tr>
                    <tr>
                        <td style="width: 80px">User name:</td>
                        <td><input type='text' name='username' required></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type='password' name='password' required></td>
                    </tr>
                    <tr>
                        <td colspan='2' class="bookstore-button">
                            <input type='submit' value='  Login  '>
                            <input type="submit" name="Cancel" value="Cancel"
                                   onclick="window.location.href = 'index.php.php'"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- display the registration form -->
        <div class="registration">
            <form action="register.php" method="post">
                <table>
                    <tr>
                        <td colspan="2" align="left">If you are new to our site, please create an account.<br><br></td>
                    </tr>
                    <tr>
                        <td style="width: 85px">First Name:</td>
                        <td><input name="firstname" type="text" required></td>
                    </tr>
                    <tr>
                        <td>Last Name:</td>
                        <td><input name="lastname" type="text" required></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input name="email" type="email" required></td>
                    </tr>
                    <tr>
                        <td>User Name:</td>
                        <td><input name="username" type="text" required></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input name="password" type="password" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="bookstore-button">
                            <input type="submit" value="Register"/>
                            <input type="button" value="Cancel" onclick="window.location.href = 'index.php.php'"/>
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </div>

<?php
include('includes/footer.php');
