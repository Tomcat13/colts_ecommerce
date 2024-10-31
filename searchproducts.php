<?php
/**
 * Author: Kyle Wicker
 * Date: 11/16/2023
 * File: searchproducts.php
 * Description: This script displays a search form.
 */
$page_title = "Search Product";

include('includes/header.php');
?>
    <style>
        body {
            background-image: url("www/img/stadium.jpg");
            background-size: cover;
            background-position: center;
            position:relative;
        }
    </style>
    <div class="bodyBorder">

        <h2>Search Products</h2>

        <form action="searchproductresults.php" method="get" class="product-search-form">
            <label for="search-query">Product Name:</label>
            <input type="text" id="search-query" name="q" size="40" required/>&nbsp;&nbsp;
            <input type="submit" name="Submit" id="Submit" value="Browse"/>
        </form>
    </div>

    </br>
    </br>
<?php
include('includes/footer.php');