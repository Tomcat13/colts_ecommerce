<?php
/**
 * Author: Kyle Wicker
 * Date: 11/16/2023
 * File: products.php
 * Description:
 * @var string $tblProducts
 * @var object $conn
 */
$page_title = "Colts Products";
require 'includes/header.php';
require_once 'includes/database.php';

/*if (filter_has_var(INPUT_POST, "random")) {
    $random = filter_input(INPUT_POST, "random", FILTER_SANITIZE_STRING);
} else {
    $random = rand(1, 20);
}*/

//creates array to be iterated w/ query
$addFilter = [];
$foodCheck = $drinkCheck = $merchCheck = $ticketCheck = '';

//if statements to add to query based upon what filters were selected
if(filter_has_var(INPUT_POST, "food")) {
    $addFilter[] = $_POST['food'];
    $foodCheck = 'checked';
}
if(filter_has_var(INPUT_POST, "drink")) {
    $addFilter[] = $_POST['drink'];
    $drinkCheck = 'checked';
}
if(filter_has_var(INPUT_POST, "merch")) {
    $addFilter[] = $_POST['merch'];
    $merchCheck = 'checked';
}
if(filter_has_var(INPUT_POST, "tickets")) {
    $addFilter[] = $_POST['tickets'];
    $ticketCheck = 'checked';
}
//var_dump($addFilter);

?>



    <h2 style="text-align: center;" >Products Available to Purchase</h2>

    <!--<h3 style="text-align: center;">Filter by Product Type</h3>-->
    <div style="text-align: center;">
        <hr>
        <h3>Filter by product type:</h3>
        <form action="products.php" method="post">
            <input type="checkbox" name="food" value="food" <?= $foodCheck ?>>Food
            <input type="checkbox" name="drink" value="drink" <?= $drinkCheck ?>>Drink
            <input type="checkbox" name="merch" value="merchandise" <?= $merchCheck ?>>Merchandise
            <input type="checkbox" name="tickets" value="tickets" <?= $ticketCheck ?>>Tickets
            <br>
            <input type="submit" value="submit">
        </form>
        <hr>
    </div>
    <br>
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

            <!--<div class="col4">Product Type:</div>-->
        </div>

        <?php
        //SELECT statement to retrieve product product_description, price, and price_date
        // from $tblproducts
        $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);

        // creating sql statement
        $sql = "SELECT *
                FROM $tblProducts, $tblTypes
                WHERE $tblProducts.type = $tblTypes.type_id"; //AND $product_id = $id;


        if(count($addFilter) > 0) {
            //can go back through and add variables for this but I'm not messing w/ that rn
            //$sql .= ", $tblTypes WHERE products.type = types.type_id AND (";
            $sql .= " AND (";
            foreach ($addFilter as $item) {
                $sql .= " types.category = '$item' OR";
            }
            $sql = substr($sql, 0, -3);
            $sql .= ")";
            //echo $sql;
            //exit();
        }
        // SELECT * FROM products, types WHERE products.type = types.type_id AND types.category = 'food';
        //echo $sql;

        //execute the query
        $query = $conn->query($sql);

        //Handle errors
        if (!$query) {
            $error = "Selection failed: " . $conn->error;
            $conn->close();
            header("Location: error.php?m=$error");
            die();
        }
        while ($row = $query->fetch_assoc()) { ?>
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

require 'includes/footer.php';