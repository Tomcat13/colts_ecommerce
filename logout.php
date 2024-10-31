<?php
/**
 * Author: Evan Deal
 * Date: ${Date}
 * File: logout.php
 * Description:
 */

//start session if it has not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION = [];

setcookie(session_name(), "", time() - 100);
session_destroy();

$pagetitle = 'Colts Logout';
require_once 'includes/header.php';

?>

<h2>Logout</h2>
<p>Thank you for your visit. You're now logged out.</p>

<?php
require_once 'includes/footer.php';
?>
