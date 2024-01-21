<?php
include '../connect.php'; // Include your database connection script

if (isset($_GET["id"])) {
    $productId = $_GET["id"];

    // Check if the product exists and is not already deleted
    $productExists = rowCount("SELECT * FROM taikhoan_quyen WHERE id_taikhoan = $productId");

    if ($productExists > 0) {
        // Perform the delete operation
        selectAll("DELETE FROM taikhoan_quyen WHERE id_taikhoan = $productId");
        header('Location: userpermission.php'); // Redirect back to the product list page
    } else {
        // Product not found or already deleted, handle the error as needed
        echo "Quyền không tìm thấy hoặc đã bị xóa";
    }
} else {
    // No product ID provided, handle the error as needed
    echo "Không tìm thấy ID tài khoản";
}
