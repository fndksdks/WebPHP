<?php
include 'header.php';

if (isset($_COOKIE["user"])) {
  $user = $_COOKIE["user"];
  foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
    $permission = $row['phanquyen'];
  }
  if ($permission == 1 || $permission == 0) {
    if (isset($_GET["id"])) {
      foreach (selectAll("SELECT * FROM nhacungcap WHERE id={$_GET['id']}") as $item) {
        $ten = $item['ten'];
        $dienthoai = $item['dienthoai'];
        $email = $item['email'];
        $diachi = $item['diachi'];
      }
    }
    if (isset($_POST['sua'])) {
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
    //     if (rowCount("SELECT * FROM nhacungcap WHERE ten='$ten'") > 0) {
    //       $errorMessage =  "Nhà cung cấp đã tồn tại!";
    //   }else{
        if (!isset($errorMessage)) {
          $updateQuery = "UPDATE nhacungcap SET ten='$ten',dienthoai='$dienthoai',email='$email',diachi='$diachi' WHERE id={$_GET['id']}";

          if (exSQL($updateQuery)) {
            $successMessage = "Cập nhật nhà cung cấp thành công.";
            header('location:suppliers.php');
          } else {
              $errorMessage = "Cập nhật nhà cung cấp không thành công. Vui lòng thử lại.";
          }
        }
       //}
        
        
    }
?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row ">
          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body addfont">
                <h4 class="card-title addfont">Sửa nhà cung cấp</h4>
                <form class="forms-sample" action="" method="post" enctype="multipart/form-data">

                  <div class="form-group addfont">
                    <label for="exampleInputName1">Tên nhà cung cấp</label>
                    <input type="text" value="<?= $ten ?>" name="ten" required class="form-control text-light" placeholder="Nhập nhà cung cấp">
                  </div>

                  <div class="form-group addfont">
                    <label for="exampleInputName1">Số điện thoại</label>
                    <input type="number" value="<?= $dienthoai ?>" name="dienthoai" required class="form-control text-light" placeholder="Nhập số điện thoại">
                  </div>

                  <div class="form-group addfont">
                    <label for="exampleInputName1">Email</label>
                    <input type="text" value="<?= $email ?>" name="email" required class="form-control text-light" placeholder="Nhập email">
                  </div>

                  <div class="form-group addfont">
                    <label for="exampleInputName1">Địa chỉ</label>
                    <input type="text" value="<?= $diachi ?>" name="diachi" required class="form-control text-light" placeholder="Nhập địa chỉ">
                  </div>

                  <button type="submit" name="sua" class="btn btn-primary mr-2">Sửa nhà cung cấp</button>
                  <a class="btn btn-dark" href="suppliers.php">Hủy</a>
                </form>
                <?php
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
  <?php
  }
}
include 'footer.php';
  ?>