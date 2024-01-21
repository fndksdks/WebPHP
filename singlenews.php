<?php
include './connect.php';

if (isset($_GET['id'])) {
    $newsId = $_GET['id'];
    foreach (selectAll("SELECT * FROM tintuc WHERE id=$newsId") as $row) {
        $tintuc_anh = $row['anh'];
        $tintuc_ten = $row['ten'];
        $tintuc_noidung = $row['noidung'];
        $tintuc_mota = $row['mota'];
        $tintuc_ngaydang = $row['created_at'];
    }
}
?>

<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pet Shop</title> <!-- Use $ten for the title -->
    <link rel="icon" href="img/logos1.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- nice select CSS -->
    <link rel="stylesheet" href="css/nice-select.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/price_rangs.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!--================Blog Area =================-->
    <section class="blog_area padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">
                        <!-- <div class="news-item">
                            <img src="admin/<?= $tintuc_anh ?>" alt="News Image">
                            <h2><?= $tintuc_ten ?></h2>
                            <p><?= $tintuc_noidung ?></p>
                            <div class="news-info">
                                <span><i class="far fa-calendar"></i> <?= date('d M Y', strtotime($tintuc_ngaydang)) ?></span>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="single-post" style="width: 100%;">
                    <div class="feature-img" style="text-align: center;">
                        <img class="img-fluid" src="admin/<?= $tintuc_anh ?>" alt="" style="width: 70%;height: 440px;margin: auto;">
                    </div>
                    <div class="blog_details">
                        <h2><?= $tintuc_ten ?></h2>
                        <!-- <ul class="blog-info-link mt-3 mb-4">
                            <li><a href="#"><i class="far fa-user"></i> Travel, Lifestyle</a></li>
                            <li><a href="#"><i class="far fa-comments"></i> 03 Comments</a></li>
                        </ul> -->
                        <p class="excert">
                            <?= $tintuc_noidung ?>
                        </p>
                        <div class="news-info">
                            <span><i class="far fa-calendar"></i> <?= date('d M Y', strtotime($tintuc_ngaydang)) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->
    <?php include 'footer.php'; ?>

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
    <!-- custom js -->
    <script src="js/custom.js"></script>
</body>

</html>