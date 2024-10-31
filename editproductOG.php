<?php
/**
 * Author: group project
 * Date: 12/05/2023
 * File:
 *  Description: This script displays details of a particular book in a form.
 */
$page_title = "Edit Product Details";
require_once ('includes/header.php');
require_once('includes/database.php');
require_once ('includes/library.php');

if(!is_admin()) {
    $error = "This feature is permitted to admin";
    header("Location: error.php?m=$error");
    exit();
}

//if book id cannot retrieved, terminate the script.
if (!filter_has_var(INPUT_GET, "id")) {
    $error = "Your request cannot be processed since there was a problem retrieving product id.";
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

//retrieve book id from a query string variable.
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

//MySQL SELECT statement
$sql = "SELECT * FROM $tblProducts WHERE product_id=$id";


//execute the query
$query = @$conn->query($sql);

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
    <h2>Product Details</h2>
    <form action="editproduct.php" method="post">
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

            <div class="row" style="justify-content: space-evenly">
                <!-- display book details -->
                <div><input name="product" value="<?php echo $row['product'] ?>" required></div>
                <div><input name="brand" value="<?php echo $row['brand'] ?>" required></div>
                <div><input name="price" type="number" step="0.01" value="<?php echo $row['price'] ?>" required></div>
                <select name= "choice" id="choice">
                    <option value="1">Food</option>
                    <option value="2">Drink</option>
                    <option value="3">Merchandise</option>
                    <option value="4">Tickets</option>

                </select>
                <div><input name="purchase_price" type="number" value="<?php echo $row['purchase_price'] ?>" required></div>
            </div>
        </div>
        <div class="productlist-button" style="text-align: center;">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <input type="submit" value=" Update " />
            <input type="button" value="Cancel" onclick="window.location.href = 'productdetails.php?id=<?= $id ?>'" />
        </div>
    </form>
<?php
// close the connection.
$conn->close();
require_once 'includes/footer.php';