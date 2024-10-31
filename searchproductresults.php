<?php
/**
 * Author: Kyle Wicker
 * Date: 12/05/2023
 * Name: searchbookresults.php
 * Description: This script searches for books that match book titles in the database.
 * @var object $conn
 * @var string $tblProducts
 */
$page_title = "Product Search Results";

require_once('includes/header.php');
require_once('includes/database.php');

//retrieve search term
if (!filter_has_var(INPUT_GET, "q")) {
    $error = "There was no search terms found.";
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}
$term = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);

//explode the search terms into an array
$terms = explode(" ", $term);

//select statement using pattern search
$sql = "SELECT * FROM $tblProducts, $tblTypes WHERE ";
foreach ($terms as $t) {
    $sql .= "product LIKE '%$t%' AND ";
}
$sql = rtrim($sql, "AND "); //remove the extra "AND " at the end of the string

//execute the query
$query = $conn->query($sql);
//Handle selection errors
if (!$query) {
    $error = "Selection failed: " . $conn->error;
    $conn->close();
    header("Location: error.php?m=$error");
    die();
}

?>
    <h2>Product search results for: '<?= $term ?>'</h2>
<?php
if ($query->num_rows == 0) {
    echo "Your search '$term' did not match any Products in our inventory";
    include('includes/footer.php');
    exit;
}
?>
    <div class="productlist">
        <div class="row header">
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
        <!-- insert a row into the table for each book -->
        <?php while ($row = $query->fetch_assoc()) { ?>
            <div class="row">
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
        <?php } ?>
    </div>
<?php
include('includes/footer.php');