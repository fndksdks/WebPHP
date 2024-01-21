<?php
include '../connect.php'; // Include your database connection script

if (isset($_GET["id"])) {
    $productId = $_GET["id"];

    // Check if the product exists and is not already deleted
    $productExists = rowCount("SELECT * FROM tintuc WHERE id = $productId");

    if ($productExists) {
        // Perform the delete operation
        selectAll("DELETE FROM tintuc WHERE id = $productId");
        header('Location: news.php'); // Redirect back to the product list page
    } else {
        // Product not found or already deleted, handle the error as needed
        echo "Sản phẩm không tìm thấy hoặc đã bị xóa";
    }
} else {
    // No product ID provided, handle the error as needed
    echo "Không tìm thấy ID sản phẩm";
}
