<?php
include 'header.php';
// include '../connect.php';
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];
    foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
        $permission = $row['phanquyen'];
    }
    if ($permission == 1 || $permission == 0) {
        if (isset($_POST['them'])) {
            $id_taikhoan = $_POST["taikhoan"];
            $selected_permissions = $_POST["quyen"];

            // Loop through the selected permissions and insert them into the database
            foreach ($selected_permissions as $permission_id) {
                if (rowCount("SELECT * FROM taikhoan_quyen WHERE id_taikhoan='$id_taikhoan' and id_quyen='$permission_id'") == 0) {
                    $insertQuery = "INSERT INTO taikhoan_quyen(id_taikhoan, id_quyen) VALUES('$id_taikhoan', '$permission_id')";
                    // Check if the insertion was successful
                    if (exSQL($insertQuery)) {
                        $successMessage = "Thêm quyền cho tài khoản thành công.";
                    } else {
                        $errorMessage = "Thêm quyền cho tài khoản không thành công. Vui lòng thử lại.";
                    }
                }
            }
            header('location:userpermission.php');
        }
?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Thêm quyền</h4>
                                <form class="forms-sample" action="" method="post">

                                    <div class="form-group">
                                        <label for="taikhoan">Tài khoản</label>
                                        <select required name="taikhoan" id="input" class="form-control text-light">
                                            <?php
                                            foreach (selectAll("SELECT * FROM taikhoan where phanquyen=1") as $item) {
                                            ?>
                                                <option value="<?= $item['id'] ?>"><?= $item['taikhoan'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="quyen">Quyền</label>
                                        <!-- <select required name="quyen" id="input" class="form-control text-light"> -->
                                        <?php
                                        foreach (selectAll("SELECT * FROM quyen") as $item) {
                                        ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="quyen[]" value="<?= $item['id'] ?>" id="quyen_<?= $item['id'] ?>">
                                                <label class="form-check-label" for="quyen_<?= $item['id'] ?>">
                                                    <?= $item['ten'] ?>
                                                </label>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <!-- </select> -->
                                    </div>

                                    <button type="submit" name="them" class="btn btn-primary mr-2">Thêm quyền cho tài khoản</button>
                                    <a class="btn btn-dark" href="userpermission.php">Hủy</a>

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
    <?php

    }
}
include 'footer.php';
    ?>