<?php
include '../connect.php'; // Include your database connection script

if (isset($_GET["id"])) {
    $employeeId = $_GET["id"];

    // Check if the product exists and is not already deleted
    $productExists = rowCount("SELECT * FROM taikhoan WHERE id = $employeeId");

    if ($productExists) {
        // Perform the delete operation
        selectAll("DELETE FROM taikhoan WHERE id = $employeeId");
        header('Location: employee.php'); // Redirect back to the product list page
    } else {
        // Product not found or already deleted, handle the error as needed
        echo "Nhân viên không tìm thấy hoặc đã bị xóa";
    }
} else {
    // No product ID provided, handle the error as needed
    echo "Không tìm thấy ID nhân viên";
}
