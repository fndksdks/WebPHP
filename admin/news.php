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
                                <h4 class="card-title addfont">Tin Tức</h4>
                                <div class="mb-3">
                                    <a type="button" class="btn btn-success btn-fw" href="addnews.php">Thêm Tin Tức</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="addfont" style="width: 20px">STT</th>
                                                <th class="addfont" style="width: 400px">Tiêu đề</th>
                                                <th class="addfont">Ảnh</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stt = 1;
                                            $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 8;
                                            $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;

                                            $baseQuery = "SELECT * FROM tintuc";
                                            $numrow = rowCount($baseQuery);
                                            $totalpage = ceil($numrow / $item_per_page);
                                            $offset = ($current_page - 1) * $item_per_page;
                                            foreach (selectAll("$baseQuery LIMIT $item_per_page OFFSET $offset") as $row) {
                                            ?>
                                                <tr class="addfont">
                                                    <td><?= $stt++ ?></td>
                                                    <td><?= $row['ten'] ?></td>
                                                    <td><img src="<?= $row['anh'] ?>" width="100" alt=""></td>
                                                    <td>
                                                        <a type="button" class="btn btn-primary btn-icon-text" href="editnews.php?id=<?= $row['id'] ?>">
                                                            <i class="mdi mdi-file-check btn-icon-prepend"></i> Sửa
                                                        </a>
                                                        <a type="button" class="btn btn-danger btn-icon-text" style="width: 120px" href="deletenews.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có muốn xóa tin tức này không?')">
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