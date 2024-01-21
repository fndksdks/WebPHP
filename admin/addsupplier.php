<?php
include 'header.php';

// Check if the user has permission to add permissions
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];

    // Retrieve user's permission level from the database
    foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
        $permission = $row['phanquyen'];
    }
    // Check if the user has permission level 1 (or the appropriate level for adding permissions)
    if ($permission == 1 || $permission == 0) {
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Process the form data and add the new permission to the database
            if (isset($_POST['them'])) {
                $ten = $_POST["ten"];
                $dienthoai = $_POST["dienthoai"];
                $email = $_POST["email"];
                $diachi = $_POST["diachi"];

                if (isset($_POST['dienthoai']) && !preg_match('/^0[0-9]{9}$/', trim($_POST['dienthoai']))) {
                    $errorMessage = "Định dạng số điện thoại không chuẩn xác";
                }
                
                if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errorMessage = "Định dạng email không chuẩn xác";
                }
                

                // Validate and sanitize the input data (you should add more validation)
                // Example validation: Check if the permission name is not empty
                if (empty($ten)) {
                    $errorMessage = "Bạn phải nhập tên nhà cung cấp.";
                } else {
                    // Insert the new permission into the 'quyen' table
                    // You should replace 'YOUR_INSERT_QUERY' with the actual SQL query
                    // Make sure to properly sanitize and validate the input


                    if (rowCount("SELECT * FROM nhacungcap WHERE ten='$ten'") > 0) {
                        $errorMessage =  "Nhà cung cấp đã tồn tại!";
                    } else {
                        if (!isset($errorMessage)) {
                            $insertQuery = "INSERT INTO nhacungcap(ten,dienthoai,email,diachi) VALUES ('$ten','$dienthoai','$email','$diachi')";
                            // Check if the insertion was successful
                            if (exSQL($insertQuery)) {
                                $successMessage = "Thêm nhà cung cấp thành công.";
                                header('location:suppliers.php');
                            } else {
                                $errorMessage = "Thêm nhà cung cấp không thành công. Vui lòng thử lại.";
                            }
                        }
                        
                    }

                    // Execute the query (you should use prepared statements for security)
                    // Example: mysqli_query($conn, $insertQuery);


                }
            }
        }
?>

        <!-- HTML form for adding a new permission -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title addfont">Thêm Nhà cung cấp mới</h4>
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="ten">Tên nhà cung cấp</label>
                                        <input type="text" class="form-control text-light" id="ten" name="ten" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dienthoai">Số điện thoai</label>
                                        <input type="text" class="form-control text-light" id="dienthoai" name="dienthoai" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control text-light" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="diachi">Địa chỉ</label>
                                        <input type="text" class="form-control text-light" id="diachi" name="diachi" required>
                                    </div>
                                    <button type="submit" name="them" class="btn btn-primary">Thêm nhà cung cấp</button>
                                    <a class="btn btn-dark" href="suppliers.php">Hủy</a>
                                </form>
                                <?php
                                // Display success or error messages here if needed
                                if (isset($successMessage)) {
                                    echo '<div class="alert alert-success mt-3">' . $successMessage . '</div>';
                                }
                                if (isset($errorMessage)) {
                                    echo '<div class="alert alert-danger mt-3">' . $errorMessage . '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
    }
}

include 'footer.php';
?>