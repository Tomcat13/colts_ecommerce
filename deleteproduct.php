<?php
/**
 * Author: Thomas Reedy
 * Date: 11/29/2023
 * File: deleteproduct.php
 * Description:
 */

require_once ('includes/library.php');

if(!is_admin()) {
    $error = "This feature is permitted to admin";
    header("Location: error.php?m=$error");
    exit();
}

$page_title = "Confirm Product Deletion";
require_once('includes/header.php');
require_once('includes/database.php');

//if product id cannot retrieved, terminate the script.
if (!filter_has_var(INPUT_GET, 'id')) {
    $error = "There was a problem retrieving product id.";
    header("Location: error.php?m=$error");
    die();
}

//retrieve product id from a query string variable.
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

//select statement
$sql = "SELECT *
                FROM $tblProducts, $tblTypes
                WHERE $tblProducts.type = $tblTypes.type_id";
//echo "$sql";
//die();
//connect to query
$query = $conn->query($sql);

//Handle errors
if (!$query) {
    $error = "Selection failed: " . $conn->error;
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

$row = $query->fetch_assoc();
if (!$row) {
    $error = "Product not found";
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

?>

    <h2>Item Details</h2>
    <div class="productlist">
        <div class="row header">
            <!-- display product attributes  -->
            <div class="col1">Name:</div>
            <div class="col2">Brand:</div>
            <div class="col3">Price:</div>
            <div class="col4">Type:</div>
            <div class="col5">
                <?php //special feature*******************************************************************************************************************
                // Check if the user is logged in
                if (isset($_SESSION['login']) AND isset($_SESSION['name']) AND
                    isset($_SESSION['role'])) {
                    // Retrieve the user role. This could come from a session variable, a database query, etc.
                    $userRole = $_SESSION['role']; //find users role
                    // Check if the user has the desired role
                    if ($userRole == '1') {
                        // Content for admin users
                        echo "<div>Purchase Price:</div>";
                    } else {
                        // Content for other roles or a message
                        echo "<div>This content is only for admin users.</div>";
                    }
                } else {
                    // User is not logged in
                    echo "<div>Please log in to view this content.</div>";
                }
                //special feature*******************************************************************************************************************
                ?>

            </div>
        </div>
        <div class="row">
            <!-- display product details -->
            <div class="col1"><a href="productdetails.php?id=<?= $row['product_id'] ?>"><?= $row['product'] ?></a></div>
            <div class="col2"><?= $row['brand'] ?></div>
            <div class="col3">$<?= $row['price'] ?></div>
            <div class="col4"><?= $row['category'] ?></div>
            <?php //special feature*******************************************************************************************************************
            // Check if the user is logged in
            if (isset($_SESSION['login']) AND isset($_SESSION['name']) AND
                isset($_SESSION['role'])) {
                // Retrieve the user role. This could come from a session variable, a database query, etc.
                $userRole = $_SESSION['role']; //find users role
                // Check if the user has the desired role
                if ($userRole == '1') {
                    // Content for admin users
                    // Check if 'purchase_price' is set in $row
                    if (isset($row['purchase_price'])) {
                        // Echo the HTML code with the purchase price
                        echo "<div class=\"col5\">$" . htmlspecialchars($row['purchase_price']) . "</div>";
                    } else {
                        echo "<div>Price not available.</div>";
                    }
                } else {
                    // Content for other roles or a message
                    echo "<div>This content is for admin users.</div>";
                }
            } else {
                // User is not logged in
                echo "<div>Please log in to view this content.</div>";
            }
            //special feature*******************************************************************************************************************
            ?>
        </div>
        </div>
    </div>

    <!-- Make sure to change the class here -->
    <br><br>
    <hr><br>
    <div class="productlist-button" style="text-align: center;">
        <input style="width: 75px;" type="button" value="Delete"
               onclick="window.location.href = 'removeproduct.php?id=<?= $id ?>'">
        <input style="width: 75px;" type="button" value="Cancel"
               onclick="window.location.href = 'productdetails.php?id=<?= $id ?>'">
        <div style="color: red; display: inline-block;">Are you sure you want to delete the product?</div>
    </div>
    <br>

<?php
require_once('includes/footer.php');