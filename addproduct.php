<?php
/**
 * Author: Kyle Wicker
 * Date: 11/30/2023
 * File: addproduct.php
 * Description: Add Products to the database from the website
 */
$page_title = "Colts Online merch shop Add Product";
require_once 'includes/header.php';
require_once ('includes/library.php');

if(!is_admin()) {
    $error = "This feature is permitted to admin";
    header("Location: error.php?m=$error");
    exit();
}

?>

    <h2>Add New Product</h2>
    <form action="insertproduct.php" method="post">
        <table cellspacing="0" cellpadding="3" style="border: 1px solid silver; padding:5px; margin-bottom: 10px;">
            <tr>
                <td style="text-align: right; width: 100px">Product: </td>
                <td><input name="product" type="text" size="50" required /></td>
            </tr>
            <tr>
                <td style="text-align: right; vertical-align: top">Brand:</td>
                <td><textarea name="brand" rows="6" cols="65"></textarea></td>
            </tr>
            <tr>
                <td style="text-align: right">Price: </td>
                <td><input name="price" type="number" step="0.01" required /></td>
            </tr>
            <tr>
                <td style="text-align: right">Type: </td>
                <td> <select name= "choice">
                        <option value="1">Food</option>
                        <option value="2">Drink</option>
                        <option value="3">Merchandise</option>
                        <option value="4">Tickets</option>

                    </select></td>
            </tr>
            <tr>
                <td style="text-align: right"> Purchase Price: </td>
                <td><input name="purchase_price" type="number" step = "0.01" size="50" required /></td>
            </tr>


        </table>
        <div class="product-button">
            <input type="submit" value="Add Product" />
            <input type="button" value="Cancel" onclick="window.location.href='products.php'" />
        </div>
    </form>

<?php
require_once 'includes/footer.php';