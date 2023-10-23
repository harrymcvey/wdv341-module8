<?php

// Database credentials
$host = 'localhost';
$dbname = 'wdv341';
$username = 'root'; // Replace with your actual username
$password = ''; // Replace with your actual password

try {
    // Create a new PDO instance
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define the query
    $stmt = $db->prepare("SELECT * FROM wdv341_products ORDER BY product_name DESC");

    // Execute the query
    $stmt->execute();

    // Fetch all the products
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are products
    if ($products) {
        // Loop through the products and display them
        foreach ($products as $product) {
            echo '<div class="productBlock">';
            echo '<div class="productImage">';
            echo '<img src="productImages/' . htmlspecialchars($product['product_image']) . '">';
            echo '</div>';
            echo '<p class="productName">' . htmlspecialchars($product['product_name']) . '</p>';
            echo '<p class="productDesc">' . htmlspecialchars($product['product_description']) . '</p>';
            echo '<p class="productPrice">$' . htmlspecialchars($product['product_price']) . '</p>';

            // If there is content in the product_status field, display it
            if (!empty($product['product_status'])) {
                echo '<p class="productStatus">' . htmlspecialchars($product['product_status']) . '</p>';
            }

            // If the product inventory is less than 10, display a warning
            if ($product['product_inStock'] < 10) {
                echo '<p class="productInventory productLowInventory"># In Stock: ' . htmlspecialchars($product['product_inStock']) . '</p>';
            } else {
                echo '<p class="productInventory"># In Stock: ' . htmlspecialchars($product['product_inStock']) . '</p>';
            }

            echo '</div>';  // Close the productBlock div
        }
    } else {
        echo "<p>No products found.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
