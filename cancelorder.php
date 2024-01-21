<?php
include 'connect.php'; // Include your database connection script

if (isset($_GET["id"])) {
    $orderId = $_GET["id"];

    // Check if the product exists and is not already deleted
    $orderExists = rowCount("SELECT * FROM donhang WHERE id = $orderId");

    if ($orderExists) {


        foreach (selectAll("SELECT ctdonhang.*, sanpham.soluong	as soluong_pro FROM ctdonhang INNER JOIN sanpham ON ctdonhang.id_sanpham = sanpham.id WHERE id_donhang = $orderId") as $product) {
            $qty = $product['soluong_pro'] + $product['soluong'];
            selectAll("UPDATE sanpham set soluong= $qty WHERE id = {$product['id_sanpham']}");
        }

        // Perform the delete operation
        selectAll("UPDATE donhang set status=4 WHERE id = $orderId");
        header('Location: history.php'); // Redirect back to the product list page
    } else {
        // Product not found or already deleted, handle the error as needed
        echo "Đơn hàng không tìm thấy hoặc đã bị hủy";
    }
} else {
    // No product ID provided, handle the error as needed
    echo "Không tìm thấy ID đơn hàng";
}
