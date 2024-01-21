<?php
include 'header.php';
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];
    foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
        $permission = $row['phanquyen'];
    }

    if ($permission == 1 || $permission == 0) {
?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title addfont">Quản lí phân quyền</h4>
                                <div class="mb-3">
                                    <a type="button" class="btn btn-success btn-fw" href="adduserpermission.php">Thêm phân quyền</a>
                                    <a type="button" class="btn btn-success btn-fw" href="permission.php">Quay lại</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="addfont" style="width: 20px">STT</th>
                                                <th class="addfont" style="width: 400px">Tài khoản</th>
                                                <th class="addfont">Quyền</th>
                                                <th class="addfont">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stt = 1;
                                            $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 8;
                                            $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;

                                            $baseQuery = "SELECT taikhoan.id AS id_taikhoan, taikhoan.taikhoan, GROUP_CONCAT(quyen.ten ORDER BY quyen.id SEPARATOR ', ') AS quyen_names
                                        FROM taikhoan
                                        inner JOIN taikhoan_quyen ON taikhoan.id = taikhoan_quyen.id_taikhoan
                                        inner JOIN quyen ON taikhoan_quyen.id_quyen = quyen.id
                                        where taikhoan.phanquyen = 1
                                        GROUP BY taikhoan.id, taikhoan.taikhoan";
                                            $numrow = rowCount($baseQuery);
                                            $totalpage = ceil($numrow / $item_per_page);
                                            $offset = ($current_page - 1) * $item_per_page;
                                            foreach (selectAll("$baseQuery LIMIT $item_per_page OFFSET $offset") as $row) {
                                            ?>
                                                <tr class="addfont">
                                                    <td><?= $stt++ ?></td>
                                                    <td><?= $row['taikhoan'] ?></td>
                                                    <td><?= $row['quyen_names'] ?></td>
                                                    <td>
                                                        <a type="button" class="btn btn-primary btn-icon-text" href="edituserpermission.php?id=<?= $row['id_taikhoan'] ?>">
                                                            <i class="mdi mdi-file-check btn-icon-prepend"></i> Sửa </a>
                                                        <a type="button" class="btn btn-danger btn-icon-text" style="width: 120px" href="deleteuserpermission.php?id=<?= $row['id_taikhoan'] ?>" onclick="return confirm('Bạn có muốn xóa quyền này không?')">
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
                                                                <li class="page-item"><a class="btn btn-outline-secondary" href="?per_page=<?= $item_per_page ?>&page=<?= $num ?>"><?= $num ?></a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <strong class="page-item"><a class="btn btn-outline-secondary"><?= $num ?></a>
                                                            </strong>
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
        <?php
    }
}
include 'footer.php';
        ?>