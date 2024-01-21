<?php
include 'header.php';
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];
    foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
        $permission = $row['phanquyen'];
    }
    if ($permission == 1 || $permission == 0) {
        if (isset($_GET["id"])) {
            // selectAll("UPDATE  FROM taikhoan WHERE id={$_GET['id']}");
            // header('location:account.php');
            if (rowCount("SELECT * FROM taikhoan WHERE id={$_GET['id']} && status=1 ") > 0) {
                selectall("UPDATE taikhoan SET status=0 WHERE id={$_GET["id"]} && status=1");
                header('location:account.php');
            } else {
                selectall("UPDATE taikhoan SET status=1 WHERE id={$_GET["id"]} && status=0");
                header('location:account.php');
            }
        }
?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row ">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title addfont">Nhân viên</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="addfont" style="width: 100px">STT</th>
                                                <th class="addfont" style="width: 500px">Họ Tên</th>
                                                <th class="addfont" style="width: 400px">Tài Khoản (Email)</th>
                                                <!-- <th class="addfont" style="width: 300px">Ảnh</th> -->
                                                <th class="addfont" style="width: 300px">Số điện thoại</th>
                                                <th class="addfont" style="width: 300px">Địa chỉ</th>
                                                <th class="addfont" style="width: 300px">Trạng thái</th>
                                                <th class="addfont"><a type="button" class="btn btn-success btn-fw" style="width: 204px" href="addaccount.php">Thêm Nhân viên</a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stt = 1;
                                            $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 8;
                                            $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;
                                            $offset = ($current_page - 1) * $item_per_page;
                                            $numrow = rowCount("SELECT * FROM taikhoan where phanquyen=1");
                                            $totalpage = ceil($numrow / $item_per_page);
                                            foreach (selectAll("SELECT * FROM taikhoan where phanquyen=1 ORDER BY status ASC LIMIT $item_per_page OFFSET $offset") as $row) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        <?= $stt++ ?></td>
                                                    <td>
                                                        <img src="<?= empty($row['anh']) ? '../img/account/user.png' : '../img/account/' . $row['anh'] . '' ?>" alt="image">
                                                        <span class="addfont"><?= $row['hoten'] ?></span>
                                                    </td>
                                                    <td class="addfont">
                                                        <?= $row['taikhoan'] ?>
                                                    </td>
                                                    <!-- <td class="addfont">
                                                        <?= $row['anh'] ?>
                                                    </td> -->
                                                    <td class="addfont">
                                                        <?= $row['sdt'] ?>
                                                    </td>
                                                    <td class="addfont">
                                                        <?= $row['diachi'] ?>
                                                    </td>
                                                    <td class="addfont">
                                                        <?= $row['status'] == 0 ? 'Đang hoạt động' : 'Khóa' ?>
                                                    </td>
                                                    <td>
                                                        <a type="button" class="btn btn-primary btn-icon-text addfont" href="editaccount.php?id=<?= $row['id'] ?>">
                                                            <i class="mdi mdi-file-check btn-icon-prepend"></i> Sửa </a>
                                                        <a type="button" class="btn btn-danger btn-icon-text" style="width: 120px" href="deleteemployee.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có muốn xóa nhân viên này không?')">
                                                            <i class="mdi mdi-delete btn-icon-prepend"></i> Xóa
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="col-lg-12">
                                        <div class="pageination">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-center">
                                                    <?php for ($num = 1; $num <= $totalpage; $num++) { ?>
                                                        <?php
                                                        if ($num != $current_page) {
                                                        ?>
                                                            <?php if ($num > $current_page - 3 && $num < $current_page + 3) { ?>
                                                                <li class="page-item"><a class="btn btn-outline-secondary" href="?per_page=<?= $item_per_page ?>&page=<?= $num ?>"><?= $num ?></a></li>
                                                            <?php } ?>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <strong class="page-item"><a class="btn btn-outline-secondary"><?= $num ?></a></strong>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="./js/search.js?v=<?php echo time() ?>"></script>
    <?php
    }
}
include 'footer.php';
    ?>