<?php
/**
 * Author: Thomas Reedy
 * Date: 11/29/2023
 * File: error.php
 * Description: shows error messages in a separate page
 */

$page_title = "Colts PHP Online Shop Error";
require_once 'includes/header.php';

$error='Default error.';
if (filter_has_var(INPUT_GET, "m")) {
    $error = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_STRING);
}
?>
    <h2>Error</h2>

    <table style="width: 100%; border: none">
        <tr>
            <!--<td style="vertical-align: middle; text-align: center; width:100px">
                <img src='www/img/error.png' style="width: 80px; border: none"/>
            </td>-->
            <td style="text-align: left; vertical-align: top;">
                <h3>Sorry, but an error has occurred.</h3>
                <div style="color: red">
                    <?= $error ?>
                </div>
                <br>
            </td>
        </tr>
    </table>
    <br><br><br><br><br>
<?php
require_once 'includes/footer.php';