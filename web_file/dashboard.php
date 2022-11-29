<?php 
    //Cek apakah user sudah login atau belum
    session_start();
    if(!isset($_SESSION['stored_id'])) header("location:auth.php?auth=register");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Nawaa Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/media.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <?php include_once('./components/navbar-logged.php') ?>

    <div class="dashboard_container">

        <!-- Menampilkan slider -->
        <section class="dashboard_slider_background">
            <div class="dashboard_slider">
                <span class="slider_prev" id="slider_prev"></span>
                <div class="slider_content">
                    <img src="./assets/images/slide-01.png" alt="" id="slider_image">
                </div>
                <span class="slider_next" id="slider_next"></span>
            </div>
            <div class="slider_bullets">
                <span class="bullets bullets_active" id="bullet_1"></span>
                <span class="bullets" id="bullet_2"></span>
                <span class="bullets" id="bullet_3"></span>
            </div>
        </section>

        <!-- Menampilkan list product -->
        <section class="dashboard_content">
            <h1>Daftar Layanan Jasa Edit Foto Kami</h1>
            <div class="dashboard_content_list">
                <?php
                    include "./database/connection.php";

                    //Ambil data semua product
                    $sql = "SELECT id, name, price, image FROM product";
                    $records = $connect->query($sql);

                    //Mencetak data product yang didapat
                    foreach($records as $row){
                        ?>
                            <a href="./detail.php?product=<?= $row["id"] ?>" class="content_list">
                                <div class="content_list_left" style="background-image: url('./assets/images/<?= $row["image"] ?>')"></div>
                                <div class="content_list_right">
                                    <h2><?= $row["name"] ?></h2>
                                    <b>Mulai Rp <?= $row["price"] ?>,00</b>
                                    <p>Klik untuk lihat detail</p>
                                </div>
                            </a>
                        <?php
                    }
                ?>
            </div>
        </section>
    </div>

    <?php include_once('./components/footer.php') ?>

    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/slider.js"></script>
</body>
</html>