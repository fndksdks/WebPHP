<?php
include './connect.php';
?>
<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pet Shop</title>
    <link rel="icon" href="img/logos1.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
    .header_bg {
        background-color: #ecfdff;
        height: 230px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .padding_top1 {
        padding-top: 20px;
    }

    .a1 {
        padding-top: 130px;
    }

    .a2 {
        height: 230px;

    }
</style>

<body>

    <?php include 'header.php'; ?>

    <!--================Home Banner Area =================-->
    <!-- breadcrumb start-->
    <section class="breadcrumb header_bg">
        <div class="container">
            <div class="row justify-content-center a2">
                <div class="col-lg-8 a2">
                    <div class="a1">
                        <h2>Đăng Nhập</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end-->

    <!--================login_part Area =================-->
    <section class="login_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_text text-center">
                        <div class="login_part_text_iner">
                            <h2>Mới đến cửa hàng của chúng tôi?</h2>
                            <p>Vui lòng đăng ký tài khoản để có trải nghiệm tốt nhất</p>
                            <a href="register.php" class="btn_3">Đăng ký</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <h3>Chào Mừng Trở Lại ! <br> Đăng Nhập Ngay</h3>
                            <?php
                            if (isset($_POST["dangnhap"])) {
                                $email = ($_POST["email"]);
                                $matkhau = ($_POST["matkhau"]);

                                if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                                    $errorEmail = "Định dạng email không chuẩn xác";
                                }
                                if (!isset($errorEmail)) {
                                    if (rowCount("SELECT * FROM taikhoan WHERE taikhoan='$email' && matkhau='$matkhau' && status =0") == 1) {
                                        setcookie('user', $email, time() + (86400 * 30), "/");
                                        header('location:index.php');
                                    } else if (rowCount("SELECT * FROM taikhoan WHERE taikhoan='$email' && matkhau='$matkhau' && status =1") == 1) {
                                        $error = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ admin';
                                    } else {
                                        $error = 'Tài khoản hoặc mật khẩu không chính xác. Vui lòng kiểm tra lại';
                                    }
                                } else {
                                    $error = "Định dạng email không chuẩn xác";
                                }
                            }
                            ?>
                            <form class="row contact_form" action="" method="post" novalidate="novalidate">
                                <?php
                                if (isset($error)) {
                                ?>
                                    <p class="text-danger ml-3 mb-3"><?= $error ?></p>
                                <?php
                                }
                                ?>
                                <div class="col-md-12 form-group p_star exampleInputName1">
                                    <input type="email" class="form-control" name="email" value="" required placeholder="Tài khoản (Email)">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" name="matkhau" value="" required placeholder="Mật khẩu">
                                </div>
                                <div class="col-md-12 form-group">
                                    <!-- <div class="creat_account d-flex align-items-center">
                                        <input type="checkbox" id="f-option" name="selector">
                                        <label for="f-option">Remember me</label>
                                    </div> -->
                                    <button type="submit" name="dangnhap" class="btn_3">
                                        đăng nhập
                                    </button>
                                    <!-- <a class="lost_pass" href="#">quên mật khẩu?</a> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================login_part end =================-->

    <!--::footer_part start::-->
    <footer class="footer_part" style=" margin-top: 10px; padding: 20px; background-color: #F8F8F8; background-clip: padding;">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Thông Tin Cửa Hàng</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Cửa Hàng </a></li>
                            <li><a href="">Số 34 Trưng Nhị, Hà Đông, Tp. Hà Nội</a></li>
                            <li><a href="">Hotline: 024 6259 3434</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Chính Sách</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Quy chế hoạt động</a></li>
                            <li><a href="">Chính sách Bảo hành</a></li>
                            <li><a href="">Liên hệ hợp tác kinh doanh</a></li>
                            <li><a href="">Đơn Doanh nghiệp</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div class="copyright_part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <!--  -->
                    </div>
                    <div class="col-lg-4">
                        <div class="footer_icon social_icon">
                            <ul class="list-unstyled">
                                <li><a href="" class="single_social_icon"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="" class="single_social_icon"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--::footer_part end::-->

    <!-- jquery plugins here-->
    <!-- jquery -->
    <script src="js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src="js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <!-- slick js -->
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>
    <script src="js/stellar.js"></script>
    <script src="js/price_rangs.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
</body>

</html>