<?php
include '../connect.php';
if (isset($_COOKIE["user"])) {
    $user = $_COOKIE["user"];
    foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
        $permission = $row['phanquyen'];
    }
    if ($permission == 1 || $permission == 0) {
        if (isset($_GET["id"])) {
            foreach (selectAll("SELECT * FROM ctdonhang WHERE id_donhang={$_GET['id']}") as $item) {
                $id_donhang = $item['id_donhang'];
                $id_sanpham = $item['id_sanpham'];
                $soluong = $item['soluong'];
                $gia = $item['gia'];
            }
            foreach (selectAll("SELECT * FROM donhang WHERE id={$_GET['id']}") as $items) {
                $id_taikhoan = $items['id_taikhoan'];
                $tongtien = $items['tongtien'];
                $diachi = $items['diachi'];
                $status = $items['status'];
            }
            foreach (selectAll("SELECT * FROM taikhoan WHERE id='$id_taikhoan'") as $item3) {
                $hoten = $item3['hoten'];
                $taikhoan = $item3['taikhoan'];
            }
        }
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Hóa đơn</title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- Bootstrap 4 -->

            <!-- Font Awesome -->
            <link rel="stylesheet" href="assets/vendors/fontawesome-free/css/all.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="assets/css/adminlte.css">

            <!-- Google Font: Source Sans Pro -->
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        </head>

        <body>
            <div class="container">
                <div class="wrapper">
                    <!-- Main content -->
                    <section class="invoice">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h2 class="page-header" style="font-size: 40px;margin: 15px;text-align: center;">HÓA ĐƠN</h2>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Thông tin đơn hàng
                                <address>
                                    <strong>ID Đơn Hàng: <?= $id_donhang ?></strong><br>
                                    Tổng Tiền: <?= number_format($tongtien) ?>đ<br>
                                    Trạng Thái:
                                    <?php
                                    if ($status == 1) {
                                        echo "Chờ Xác Nhận";
                                    } else if ($status == 2) {
                                        echo "Đang Giao";
                                    } else if ($status == 3) {
                                        echo "Đã Giao";
                                    } else if ($status == 4) {

                                        echo "Đã Hủy";
                                    }
                                    ?>

                                    <br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col"></div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>Tên Khách Hàng : </b> <?= $hoten ?><br>
                                <b>Tài Khoản Khách Hàng: </b> <?= $taikhoan ?><br>
                                <b>Địa Chỉ Nhận Hàng:</b> <?= $diachi ?><br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Danh Mục</th>
                                            <th>Giá</th>
                                            <th>Số Lượng</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stt = 1;
                                        $totalAll = 0;
                                        $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 4;
                                        $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;
                                        $offset = ($current_page - 1) * $item_per_page;
                                        $numrow = rowCount("SELECT * FROM ctdonhang WHERE id_donhang = {$_GET['id']}");
                                        $totalpage = ceil($numrow / $item_per_page);
                                        foreach (selectAll("SELECT * FROM ctdonhang WHERE id_donhang={$_GET['id']} LIMIT $item_per_page OFFSET $offset") as $item4) {
                                            $id_sanpham = $item4['id_sanpham'];
                                            $soluong = $item4['soluong'];
                                            $gia = $item4['gia'];
                                            foreach (selectAll("SELECT * FROM sanpham INNER JOIN danhmuc ON sanpham.id_danhmuc = danhmuc.id_dm WHERE id = '$id_sanpham'") as $row) {
                                        ?>
                                                <tr class="addfont">
                                                    <?php
                                                    $totalPro = $gia * $soluong;
                                                    $totalAll = $totalAll +  $totalPro;
                                                    ?>
                                                    <td><?= $stt++ ?></td>
                                                    <td>
                                                        <span><?= $row['ten'] ?></span>
                                                    </td>
                                                    <td>
                                                        <?= ($row['danhmuc']) ?>
                                                    </td>
                                                    <td><?= number_format($gia) ?>đ</td>

                                                    <td><?= $soluong ?></td>

                                                    <td><?= number_format($totalPro) ?>đ</td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->

                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Tổng tiền : </p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Tổng :</th>
                                            <td><?= number_format($totalAll) ?>đ</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </section>
                    <!-- /.content -->
                </div>
            </div>
            <!-- ./wrapper -->

            <script type="text/javascript">
                window.addEventListener("load", window.print());
            </script>
        </body>

        </html>
<?php
    }
}
?>