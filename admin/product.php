<?php
include 'header.php';
if (isset($_COOKIE["user"])) {
  $user = $_COOKIE["user"];
  foreach (selectAll("SELECT * FROM taikhoan WHERE taikhoan='$user'") as $row) {
    $permission = $row['phanquyen'];
  }

  if ($permission == 1 || $permission == 0) {
    $selectedCategory = isset($_GET["category"]) ? $_GET["category"] : null; // Get the selected category filter


    // Define the base SQL query
    $baseQuery = "SELECT sanpham.id, sanpham.ten, sanpham.soluong, danhmuc.danhmuc, nhacungcap.ten as nhacungcap, sanpham.gia, sanpham.anh1, sanpham.anh2, sanpham.anh3, sanpham.status  FROM sanpham INNER JOIN danhmuc ON sanpham.id_danhmuc = danhmuc.id_dm INNER JOIN nhacungcap ON sanpham.id_nhacungcap = nhacungcap.id";


    // if (!empty($_GET['searchBox'])) {
    //   $searchTerm = $_GET['searchBox'];
    //   $baseQuery .= " WHERE sanpham.ten LIKE '%$searchTerm%'";
    // }

    // Add a category filter to the SQL query if a category is selected
    if (!empty($selectedCategory)) {
      $baseQuery .= " WHERE danhmuc.id_dm = $selectedCategory";
    }


    if (isset($_GET["id"])) {
      if (rowCount("SELECT * FROM sanpham WHERE id={$_GET['id']} && status=1 ") > 0) {
        selectall("UPDATE sanpham SET status=0 WHERE id={$_GET["id"]} && status=1");
        header('location:product.php');
      } else {
        selectall("UPDATE sanpham SET status=1 WHERE id={$_GET["id"]} && status=0");
        header('location:product.php');
      }
    } elseif (isset($_GET['searchBox']) && !empty($_GET['searchBox'])) {

      
      // Handle the search functionality here
      $selectedCategory = isset($_GET["category"]) ? $_GET["category"] : null; // Get the selected category filter

      // Define the base SQL query
      $baseQuery = "SELECT sanpham.id, sanpham.ten, sanpham.soluong, danhmuc.danhmuc, nhacungcap.ten as nhacungcap, sanpham.gia, sanpham.anh1, sanpham.anh2, sanpham.anh3, sanpham.status  FROM sanpham INNER JOIN danhmuc ON sanpham.id_danhmuc = danhmuc.id_dm INNER JOIN nhacungcap ON sanpham.id_nhacungcap = nhacungcap.id";

      // Add a category filter to the SQL query if a category is selected
      if (!empty($selectedCategory)) {
        $baseQuery .= " WHERE danhmuc.id_dm = $selectedCategory";
      }

      // Check if the search box is not empty
      if (!empty($_GET['searchBox'])) {
        $searchTerm = $_GET['searchBox'];
        if (!empty($selectedCategory)) {
          $baseQuery .= " AND sanpham.ten LIKE '%$searchTerm%'";
        } else {
          $baseQuery .= " WHERE sanpham.ten LIKE '%$searchTerm%'";
        }
        
      }
      // var_dump($baseQuery);
      // die;
    }
?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row ">
          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title addfont">Sản Phẩm </h4>
                <form method="get" action="" id="filter-form">
                  <div class="form-group">
                    <label for="searchBox">Tìm kiếm theo tên sản phẩm:</label>
                    <input type="text" class="form-control text-light" id="searchBox" name="searchBox" placeholder="Nhập tên sản phẩm">
                  </div>

                  <div class="form-group">
                    <label for="categorySelect">Chọn Danh Mục:</label>
                    <select class="form-control text-light" id="categorySelect" name="category" onchange="onCategoryChange()">
                      <option value="">Tất Cả</option> <!-- Option to show all products -->
                      <?php
                      // Fetch and display category options from the database
                      foreach (selectAll("SELECT * FROM danhmuc") as $category) {
                        $categoryId = $category['id_dm'];
                        $categoryName = $category['danhmuc'];
                        $selected = ($selectedCategory == $categoryId) ? 'selected' : '';
                      ?>
                        <option value="<?= $categoryId ?>" <?= $selected ?>><?= $categoryName ?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </form>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="addfont" style="width: 20px">STT</th>
                        <th class="addfont" style="width: 400px">Tên Sản Phẩm</th>
                        <th class="addfont">Danh Mục</th>
                        <th class="addfont">Nhà cung cấp</th>
                        <th class="addfont"> Giá </th>
                        <th class="addfont"> Số lượng </th>
                        <th class="addfont">Ảnh Sản Phẩm</th>
                        <th class="addfont">Trạng Thái</th>
                        <th></th>
                        <th><a type="button" class="btn btn-success btn-fw" style="width: 204px" href="addproduct.php">Thêm Sản Phẩm</a></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $stt = 1;
                      $item_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 8;
                      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                      $numrow = rowCount($baseQuery);
                      $totalpage = ceil($numrow / $item_per_page);
                      $offset = ($current_page - 1) * $item_per_page;
                      foreach (selectAll("$baseQuery LIMIT $item_per_page OFFSET $offset") as $row) {
                      ?>
                        <tr class="addfont">
                          <td><?= $stt++ ?></td>
                          <td>
                            <span><?= $row['ten'] ?></span>
                          </td>
                          <td>
                            <?= ($row['danhmuc']) ?>
                          </td>
                          <td>
                            <?= ($row['nhacungcap']) ?>
                          </td>
                          <td><?= number_format($row['gia']) ?>đ</td>
                          <td>
                            <?= $row['soluong'] ?>
                          </td>
                          <td>
                            <img src="../img/product/<?= $row['anh1'] ?>" width="100" alt="">
                            <img src="../img/product/<?= $row['anh2'] ?>" width="100" alt="">
                            <img src="../img/product/<?= $row['anh3'] ?>" width="100" alt="">
                          </td>
                          <td>
                            <?php
                            $status = $row['status'];
                            if ($status == 0) {
                            ?>
                              <span>Đang Bán</span>
                            <?php
                            } else {
                            ?>
                              <span>Không Kinh Doanh</span>
                            <?php
                            }
                            ?>
                          </td>
                          <td></td>
                          <td>
                            <a type="button" class="btn btn-primary btn-icon-text" href="editproduct.php?id=<?= $row['id'] ?>">
                              <i class="mdi mdi-file-check btn-icon-prepend"></i> Sửa </a>
                            <a type="button" class="btn btn-danger btn-icon-text" style="width: 120px" href="deleteproduct.php?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có muốn xóa sản phẩm này không?')">
                              <i class="mdi mdi-delete btn-icon-prepend"></i> Xóa
                            </a>
                            <?php
                            $status = $row['status'];
                            if ($status == 0) {
                            ?>
                              <!--<a type="button" class="btn btn-danger btn-icon-text" style="width: 120px" href="?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có muốn thay đổi?')">-->
                              <!--  <i class="mdi mdi-cart-off btn-icon-prepend"></i>THƯỜNG </a>-->
                            <?php
                            } else {
                            ?>
                              <!--<a type="button" class="btn btn-success btn-icon-text" style="width: 120px" href="?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có muốn thay đổi?')">-->
                              <!--  <i class="mdi mdi-cart-outline btn-icon-prepend"></i> HOT </a>-->
                            <?php
                            }
                            ?>
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
                                <li class="page-item"><a class="btn btn-outline-secondary" href="?per_page=<?= $item_per_page ?>&page=<?= intval($num) ?><?= isset($_GET['searchBox']) ? '&searchBox=' . trim($_GET['searchBox']) : '' ?><?= isset($_GET['category']) ? '&category=' . trim($_GET['category']) : '' ?>"><?= $num ?></a></li>
                              <?php } ?>
                            <?php
                            } else {
                            ?>
                              <strong class="page-item"><a class="btn btn-outline-secondary"><?= intval($num) ?></a></strong>
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
      <script>
        function onCategoryChange() {
          document.getElementById("filter-form").submit();
        }
      </script>
  <?php
  }
}
include 'footer.php';
  ?>