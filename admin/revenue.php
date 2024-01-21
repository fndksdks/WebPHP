<?php

include('Classes/PHPExcel.php');

$tongtienhientai = 0;
$tongtiendutinh = 0;
$tongtiengiam = 0;
if (isset($_COOKIE["user"])) {
  $user = $_COOKIE["user"];
  foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
    $permission = $row['phanquyen'];
  }
  if ($permission == 1 || $permission == 0) {
    $data = $_GET;

    $sqltongtiengiam = "SELECT * FROM donhang WHERE status =4";
    $sqltongtienhientai = "SELECT * FROM donhang WHERE status =3";
    $sqltongtiendutinh = "SELECT * FROM donhang WHERE status In (4,3,2,1)";

    if (!empty($data['form_date']) && !empty($data['to_date'])) {
      $form_date = date('Y-m-d H:i:s', strtotime($data['form_date'] . " 00:00:00"));
      $to_date = date('Y-m-d H:i:s', strtotime($data['to_date'] . " 23:59:59"));
      $sqltongtiengiam = "SELECT * FROM donhang WHERE status = 4 AND thoigian >= '" . $form_date . "' AND thoigian <= '" . $to_date . "'";
      $sqltongtienhientai = "SELECT * FROM donhang WHERE status = 3 AND thoigian >= '" . $form_date . "' AND thoigian <= '" . $to_date . "'";
      $sqltongtiendutinh = "SELECT * FROM donhang WHERE status In (4,3,2,1) AND thoigian >= '" . $form_date . "' AND thoigian <= '" . $to_date . "'";
    }

    if (!empty($data['month']) && empty($data['year'])) {
      $month = $data['month'];
      $sqltongtiengiam = "SELECT * FROM donhang WHERE status =4 AND MONTH(thoigian) = " . $month;
      $sqltongtienhientai = "SELECT * FROM donhang WHERE status =3 AND MONTH(thoigian) = " . $month;
      $sqltongtiendutinh = "SELECT * FROM donhang WHERE status In (4,3,2,1) AND MONTH(thoigian) = " . $month;
    }

    if (!empty($data['month']) && !empty($data['year'])) {
      $month = $data['month'];
      $year = $data['year'];
      $sqltongtiengiam = "SELECT * FROM donhang WHERE status =4 AND MONTH(thoigian) = " . $month . " AND YEAR(thoigian) = " . $year;
      $sqltongtienhientai = "SELECT * FROM donhang WHERE status =3 AND MONTH(thoigian) = " . $month . " AND YEAR(thoigian) = " . $year;
      $sqltongtiendutinh = "SELECT * FROM donhang WHERE status In (4,3,2,1) AND MONTH(thoigian) = " . $month . " AND YEAR(thoigian) = " . $year;
    }

    if (empty($data['month']) && !empty($data['year'])) {
      $year = $data['year'];

      $sqltongtiengiam = "SELECT * FROM donhang WHERE status =4 AND YEAR(thoigian) = " . $year;
      $sqltongtienhientai = "SELECT * FROM donhang WHERE status =3 AND YEAR(thoigian) = " . $year;
      $sqltongtiendutinh = "SELECT * FROM donhang WHERE status In (4,3,2,1)  AND YEAR(thoigian) = " . $year;
    }

    foreach (selectAll($sqltongtiengiam) as $item) {
      $tongtiengiam += $item['tongtien'];
    }
    foreach (selectAll($sqltongtienhientai) as $item) {
      $tongtienhientai += $item['tongtien'];
    }
    foreach (selectAll($sqltongtiendutinh) as $item2) {
      $tongtiendutinh += $item2['tongtien'];
    }
    if (isset($_GET['csv'])) {

      $data_statistical = [
        ['Tổng Tiền Giảm', 'Tổng Tiền Hiện Tại', 'Tổng Tiền Dự Tính'],
        [$tongtiengiam, $tongtienhientai, $tongtiendutinh],
      ];

      // export file excel
      ob_end_clean();
      $objExcel = new PHPExcel;
      $objExcel->setActiveSheetIndex(0);
      $sheet = $objExcel->getActiveSheet()->setTitle('Báo cáo thống kê dữ liệu');

      // - dinh dang cho du kich thuoc noi dung
      $sheet->getColumnDimension("A")->setAutoSize(true);
      $sheet->getColumnDimension("B")->setAutoSize(true);
      $sheet->getColumnDimension("C")->setAutoSize(true);

      $sheet->setCellValue('A1', 'Tổng Tiền Giảm');
      $sheet->setCellValue('B1', 'Tổng Tiền Hiện Tại');
      $sheet->setCellValue('C1', 'Tổng Tiền Dự Tính');

      $sheet->setCellValue('A2', number_format($tongtiengiam) . 'đ');
      $sheet->setCellValue('B2', number_format($tongtienhientai) . 'đ');
      $sheet->setCellValue('C2', number_format($tongtiendutinh) . 'đ');

      $sheet->setCellValue('A4', 'STT');
      $sheet->setCellValue('B4', 'Họ Tên');
      $sheet->setCellValue('C4', 'Tài Khoản (Email)');
      $sheet->setCellValue('D4', 'Loại Tài Khoản');
      $sheet->setCellValue('E4', 'Số Đơn Đã Mua');
      $sheet->setCellValue('F4', 'Tổng Tiền');

      foreach (selectAll("SELECT * FROM taikhoan") as $key => $rows) {

        $sqlnumrowData = "SELECT * FROM donhang WHERE status= 3 AND id_taikhoan = {$rows['id']}";
        if (!empty($data['form_date']) && !empty($data['to_date'])) {
          $form_date = date('Y-m-d H:i:s', strtotime($data['form_date'] . " 00:00:00"));
          $to_date = date('Y-m-d H:i:s', strtotime($data['to_date'] . " 23:59:59"));
          $sqlnumrowData = "SELECT * FROM donhang WHERE status=3 AND id_taikhoan = {$rows['id']} AND  thoigian >= '" . $form_date . "' AND thoigian <= '" . $to_date . "'";
        }

        if (!empty($data['month']) && empty($data['year'])) {
          $month = $data['month'];
          $sqlnumrowData = "SELECT * FROM donhang WHERE status= 3 AND id_taikhoan = {$rows['id']} AND MONTH(thoigian) = " . $month;
        }

        if (!empty($data['month']) && !empty($data['year'])) {
          $month = $data['month'];
          $year = $data['year'];
          $sqlnumrowData = "SELECT * FROM donhang WHERE status = 3 AND MONTH(thoigian) = " . $month . " AND YEAR(thoigian) = " . $year;
        }

        if (empty($data['month']) && !empty($data['year'])) {
          $year = $data['year'];
          $sqlnumrowData = "SELECT * FROM donhang WHERE status = 3 AND YEAR(thoigian) = " . $year;
        }

        $numrowData = rowCount($sqlnumrowData);

        if ($numrowData) {
          $numRow = $key + 5;
          $sheet->setCellValue('A' . $numRow, $key + 1);
          $sheet->setCellValue('B' . $numRow, $rows['hoten']);
          $sheet->setCellValue('C' . $numRow, $rows['taikhoan']);
          $sheet->setCellValue('D' . $numRow, $rows['phanquyen'] == 0 ? 'Admin' : 'Khách hàng');

          $tong = 0;
          $i = 0;
          foreach (selectAll("SELECT * FROM donhang WHERE status=3 && id_taikhoan = {$rows['id']}") as $item) {
            $tong = $tong + $item['tongtien'];
            $i++;
          }
          $sheet->setCellValue('E' . $numRow, $i);
          $sheet->setCellValue('F' . $numRow, number_format($tong) . 'đ');
        }
      }

      // tao border
      $styleArray = array(
        'borders' => array(
          'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
          )
        )
      );
      $sheet->getStyle('A1:' . 'F1')->applyFromArray($styleArray);

      // tao tac xuat file
      $objWriter = new PHPExcel_Writer_Excel2007($objExcel);
      $filename = date('Y-m-d') . 'thong-ke-du-leu.xlsx';
      $objWriter->save($filename);

      // cau hinh khi xuat file
      header('Content-Disposition: attachment; filename="' . $filename . '"'); // tra ve file kieu attachment
      header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
      header('Content-Legth: ' . filesize($filename));
      header('Content-Transfer-Encoding: binary');
      header('Cache-Control: must-revalidate');
      header('Pragma: no-cache');
      readfile($filename);
      return;
    }
?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <!-- Add the Export button here -->
          <form action="" style="width: 100%;">
            <div class="row">
              <div class="col-sm-2 grid-margin">
                <input type="date" name="form_date" class="form-control" style="">
              </div>
              <div class="col-sm-2 grid-margin">
                <input type="date" name="to_date" class="form-control">
              </div>
              <div class="col-sm-2 grid-margin">
                <select class="form-control" name="month">
                  <option value="">Chọn tháng</option>
                  <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?= $i ?>" <?= isset($_GET['month']) && !empty($_GET['month']) && $_GET['month'] == $i ? 'selected="selected"' : '' ?>><?= $i ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="col-sm-2 grid-margin">
                <select class="form-control" name="year">
                  <option value="">Chọn năm</option>
                  <?php $currentYear = date('Y'); ?>
                  <?php for ($j = ($currentYear - 5); $j <= ($currentYear + 10); $j++) : ?>
                    <option value="<?= $j ?>" <?= isset($_GET['year']) && !empty($_GET['year']) && $_GET['year'] == $j ? 'selected="selected"' : '' ?>><?= $j ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="col-sm-4 grid-margin">
                <button type="submit" name="filter" class="btn btn-primary mr-2">Lọc dữ liệu</button>
                <button type="submit" name="csv" value="csv" class="btn btn-success mr-2">Xuất CSV</button>
              </div>
              <!-- <div class="col-sm-2 grid-margin">
                <a class="btn btn-primary" href="export_csv.php">Xuất CSV</a>
              </div> -->
            </div>
          </form>
        </div>
        <div class="row">
          <div class="col-sm-4 grid-margin">
            <div class="card">
              <div class="card-body">
                <h5 class="addfont">Tổng Doanh Thu Thực Tế</h5>
                <div class="row">
                  <div class="col-8 col-sm-12 col-xl-8 my-auto">
                    <div class="d-flex d-sm-block d-md-flex align-items-center">
                      <h2 class="mb-0"><?= number_format($tongtienhientai) ?>đ</h2>
                      <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> -->
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal">11.38% Since last month</h6> -->
                  </div>
                  <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                    <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4 grid-margin">
            <div class="card">
              <div class="card-body">
                <h5 class="addfont">Tổng Doanh Thu Dự Tính</h5>
                <div class="row">
                  <div class="col-8 col-sm-12 col-xl-8 my-auto">
                    <div class="d-flex d-sm-block d-md-flex align-items-center">
                      <h2 class="mb-0"><?= number_format($tongtiendutinh) ?>đ</h2>
                      <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+8.3%</p> -->
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6> -->
                  </div>
                  <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                    <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-4 grid-margin">
            <div class="card">
              <div class="card-body">
                <h5 class="addfont">Tổng Các Khoản Giảm Trừ Doanh Thu</h5>
                <div class="row">
                  <div class="col-8 col-sm-12 col-xl-8 my-auto">
                    <div class="d-flex d-sm-block d-md-flex align-items-center">
                      <h2 class="mb-0"><?= number_format($tongtiengiam) ?>đ</h2>
                      <!-- <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p> -->
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6> -->
                  </div>
                  <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                    <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title addfont">Thống Kê</h4>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="addfont" style="width: 100px">STT</th>
                        <th class="addfont" style="width: 500px">Họ Tên</th>
                        <th class="addfont" style="width: 400px">Tài Khoản (Email)</th>
                        <th class="addfont" style="width: 300px">Loại Tài Khoản</th>
                        <th class="addfont" style="width: 300px">Số Đơn Đã Mua</th>
                        <th class="addfont" style="width: 300px">Tổng Tiền</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $stt = 1;
                      $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 8;
                      $current_page = !empty($_GET['page']) ? $_GET['page'] : 1;
                      $offset = ($current_page - 1) * $item_per_page;
                      $numrow = rowCount("SELECT * FROM taikhoan");
                      $totalpage = ceil($numrow / $item_per_page);
                      foreach (selectAll("SELECT * FROM taikhoan") as $rows) {
                        $sqlnumrowData = "SELECT * FROM donhang WHERE status=3 AND id_taikhoan = {$rows['id']}";
                        if (!empty($data['form_date']) && !empty($data['to_date'])) {
                          $form_date = date('Y-m-d H:i:s', strtotime($data['form_date'] . " 00:00:00"));
                          $to_date = date('Y-m-d H:i:s', strtotime($data['to_date'] . " 23:59:59"));
                          $sqlnumrowData = "SELECT * FROM donhang WHERE status=3 AND id_taikhoan = {$rows['id']} AND  thoigian >= '" . $form_date . "' AND thoigian <= '" . $to_date . "'";
                        }

                        if (!empty($data['month']) && empty($data['year'])) {
                          $month = $data['month'];
                          $sqlnumrowData = "SELECT * FROM donhang WHERE status=3 AND id_taikhoan = {$rows['id']} AND MONTH(thoigian) = " . $month;
                        }

                        if (!empty($data['month']) && !empty($data['year'])) {
                          $month = $data['month'];
                          $year = $data['year'];
                          $sqlnumrowData = "SELECT * FROM donhang WHERE status =3 AND id_taikhoan = {$rows['id']} AND MONTH(thoigian) = " . $month . " AND YEAR(thoigian) = " . $year;
                        }

                        if (empty($data['month']) && !empty($data['year'])) {
                          $year = $data['year'];
                          $sqlnumrowData = "SELECT * FROM donhang WHERE status = 3 AND id_taikhoan = {$rows['id']} AND YEAR(thoigian) = " . $year;
                        }

                        $numrowData = rowCount($sqlnumrowData);

                      ?>
                        <?php if ($numrowData > 0) : ?>
                          <tr class="addfont">
                            <td>
                              <?= $stt++ ?></td>
                            <td>
                              <img src="<?= empty($rows['anh']) ? '../img/account/user.png' : '../img/account/' . $rows['anh'] . '' ?>" alt="image">
                              <span><?= $rows['hoten'] ?></span>
                            </td>
                            <td>
                              <?= $rows['taikhoan'] ?>
                            </td>
                            <td>
                              <?= $rows['phanquyen'] == 0 ? 'Admin' : 'Khách hàng' ?>
                            </td>
                            <?php
                            $tong = 0;
                            $i = 0;
                            foreach (selectAll("SELECT * FROM donhang WHERE status=3 && id_taikhoan = {$rows['id']}") as $item) {
                              $tong = $tong + $item['tongtien'];
                              $i++;
                            }

                            ?>
                            <td>
                              <?= $i ?>
                            </td>
                            <td>

                              <?= number_format($tong) ?>đ
                            </td>
                          </tr>
                        <?php endif; ?>
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