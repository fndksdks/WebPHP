<?php
include 'header.php';

function selectAll1($query)
{
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Check if a user is logged in and has permission
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];
    foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
        $permission = $row['phanquyen'];
    }

    if ($permission == 1 || $permission == 0) {
        // Check if the user ID to be edited is provided via GET parameter
        if (isset($_GET['id'])) {
            $editUserId = $_GET['id'];

            // Retrieve the user's information and current permissions
            $userQuery = selectAll1("SELECT * FROM taikhoan WHERE id='$editUserId'");
            $userPermissionsQuery = selectAll1("SELECT id_quyen FROM taikhoan_quyen WHERE id_taikhoan='$editUserId'");

            if (rowCount("SELECT * FROM taikhoan WHERE id='$editUserId'") === 1) {
                $userData = $userQuery[0];
                $userPermissions = array_column($userPermissionsQuery, 'id_quyen');

                // Handle form submission to update user permissions
                if (isset($_POST['update'])) {
                    $userId = $userData['id']; // Get the user ID from the form
                    $selectedPermissions = $_POST['permissions']; // Get the selected permissions from the checkboxes

                    // Delete existing user permissions
                    $deleteQuery = "DELETE FROM taikhoan_quyen WHERE id_taikhoan = '$userId'";
                    // $deleteParams = [':user_id' => $userId];
                    // Execute the delete query
                    exSQL($deleteQuery);

                    // Insert new user permissions
                    if (!empty($selectedPermissions)) {
                        // Prepare and execute the insert query for each selected permission
                        foreach ($selectedPermissions as $permissionId) {
                            $insertQuery = "INSERT INTO taikhoan_quyen (id_taikhoan, id_quyen) VALUES ('$userId', '$permissionId')";
                            // Execute the insert query with parameters
                            if (exSQL($insertQuery)) {
                                $successMessage = "Sửa quyền cho tài khoản thành công.";
                            } else {
                                $errorMessage = "Sửa quyền cho tài khoản không thành công. Vui lòng thử lại.";
                            }
                        }
                    }

                    header('location:userpermission.php');
                }

                // Display the form for editing user permissions
?>

                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title addfont">Chỉnh sửa phân quyền</h4>
                                        <form method="POST" action="">
                                            <div class="form-group">
                                                <label for="username" class="addfont">Tên tài khoản: <?= $userData['taikhoan'] ?></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="permissions" class="addfont">Quyền:</label>
                                                <div>
                                                    <?php
                                                    $allPermissionsQuery = selectAll("SELECT * FROM quyen");
                                                    foreach ($allPermissionsQuery as $permissionRow) { ?>
                                                        <label>
                                                            <input type="checkbox" name="permissions[]" value="<?= $permissionRow['id'] ?>" <?= in_array($permissionRow['id'], $userPermissions) ? 'checked' : '' ?>>
                                                            <?= $permissionRow['ten'] ?>
                                                        </label><br>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <button type="submit" name="update" class="btn btn-primary">Lưu thay đổi</button>
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
            } else {
                echo 'User not found.';
            }
        } else {
            echo 'User ID not provided for editing.';
        }
    }
}

include 'footer.php';
?>