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
            $newPermissionName = $_POST["permission_name"];

            // Validate and sanitize the input data (you should add more validation)
            // Example validation: Check if the permission name is not empty
            if (empty($newPermissionName)) {
                $error = "Bạn phải nhập tên quyền.";
            } else {
                // Insert the new permission into the 'quyen' table
                // You should replace 'YOUR_INSERT_QUERY' with the actual SQL query
                // Make sure to properly sanitize and validate the input


                if (rowCount("SELECT * FROM quyen WHERE ten='$newPermissionName'") > 0) {
                    $errorMessage =  "Quyền đã tồn tại!";
                } else {
                    $insertQuery = "INSERT INTO quyen(ten) VALUES ('$newPermissionName')";
                    // Check if the insertion was successful
                    if (exSQL($insertQuery)) {
                        $successMessage = "Thêm quyền thành công.";
                        header('location:permission.php');
                    } else {
                        $errorMessage = "Thêm quyền không thành công. Vui lòng thử lại.";
                    }
                }

                // Execute the query (you should use prepared statements for security)
                // Example: mysqli_query($conn, $insertQuery);


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
                                <h4 class="card-title addfont">Thêm Quyền Mới</h4>
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="permission_name">Tên Quyền</label>
                                        <input type="text" class="form-control text-light" id="permission_name" name="permission_name" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Thêm Quyền</button>
                                    <a class="btn btn-dark" href="permission.php">Hủy</a>
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