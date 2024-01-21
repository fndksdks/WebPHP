<?php
// Include necessary files and initialize the database connection here if needed
include 'header.php';

// Check user's permissions and authorization here if needed
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];
    foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
        $permission = $row['phanquyen'];
    }

    if ($permission == 1 || $permission == 0) {
        // Check if the permission ID is provided in the URL
        if (isset($_GET['id'])) {
            $permissionId = $_GET['id'];

            // Query the database to retrieve the permission details based on $permissionId
            foreach (selectAll("SELECT * FROM quyen WHERE id=$permissionId") as $item) {
                $tenquyen = $item['ten'];
            };

            $permissionDetails = rowCount("SELECT * FROM quyen WHERE id='$permissionId'");

            // Check if the permission was found in the database
            if ($permissionDetails > 0) {
                // Handle form submission for updating the permission details
                if (isset($_POST['update'])) {
                    // Retrieve and sanitize updated permission data from the form
                    $newPermissionName = $_POST['new_permission_name'];

                    // Perform an update query to update the permission details
                    $updateQuery = "UPDATE quyen SET ten='$newPermissionName' WHERE id='$permissionId'";

                    // Check if the update query was successful
                    if (exSQL($updateQuery)) {
                        $successMessage = "Cập nhật quyền thành công.";
                        header('location:permission.php');
                    } else {
                        $errorMessage = "Cập nhật quyền không thành công. Hãy thử lại sau";
                    }
                }
?>
                <!-- HTML form for editing permission details -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Sửa quyền</h4>
                                        <form class="forms-sample" action="" method="post">
                                            <div class="form-group">
                                                <label for="new_permission_name">Tên quyền mới</label>
                                                <input type="text" class="form-control text-light" id="new_permission_name" name="new_permission_name" value="<?= $tenquyen ?>" required>
                                            </div>
                                            <button type="submit" name="update" class="btn btn-primary mr-2">Cập nhật quyền</button>
                                            <a class="btn btn-dark" href="permission.php">Hủy</a>
                                            <?php
                                            // Display success or error messages here if needed
                                            if (isset($successMessage)) {
                                                echo '<div class="alert alert-success mt-3">' . $successMessage . '</div>';
                                            }
                                            if (isset($errorMessage)) {
                                                echo '<div class="alert alert-danger mt-3">' . $errorMessage . '</div>';
                                            }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
            } else {
                echo "Permission not found.";
            }
        } else {
            echo "Permission ID is not provided.";
        }
    }
}

// Include the footer file
include 'footer.php';
?>