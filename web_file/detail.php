<?php 
    //Cek apakah user sudah login atau belum
    session_start();
    if(!isset($_SESSION['stored_id'])) header("location: auth.php?auth=register");

    include "./database/connection.php";

    //Mendapatkan informasi id product dan id user
    $id_user = $_SESSION['stored_id'];
    $id_product = "";
    if(isset($_GET["product"])) $id_product = $_GET["product"];

    //Mengambil data detail product sesuai product yang dipilih
    $sql = "SELECT * FROM product WHERE id='$id_product'";
    $result = $connect->query($sql);
    $data = $result->fetch_assoc();
    
    //Cek jika ada parameter message (Jika ada error saat upload dan simpan data ke database);
    $message = "";
    if(isset($_GET["message"])){
        if($_GET["message"] == "error_upload") $message = "<b>File gagal diunggah, silakan coba lagi</b>";
        else if($_GET["message"] == "error_saving") $message = "<b>Data gagal disimpan, silakan coba lagi</b>";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data["name"] ?> - Nawaa Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/media.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <?php include_once('./components/navbar-logged.php') ?>

    <!-- Menampilkan detail product -->
    <section class="product_detailed">
        <?php
            //Cek apakah data produk ada
            //Jika ada -> cetak detail produk
            if($data){
                ?>
                <div class="product_detailed_image">
                    <img src="./assets/images/<?= $data["image"] ?>">
                </div>
                <div class="product_detailed_info">
                    <h1><?= $data["name"] ?></h1>
                    <p><?= $data["description"] ?></p>
                    <b>Mulai Rp <?= $data["price"] ?>,00</b>
                    <p>Harga dihitung perorangan</p>
                    <b>Pengerjaan <?= $data["time"] ?> hari</b>
                    <a href="#order_column">Pesan Sekarang</a>
                </div>
                <?php
            }
            else echo "<h1>Product Tidak Tersedia</h1>";
        ?>
    </section>

    <?php
        //Cek apakah data produk ada
        //Jika ada -> cetak review produk dan kolom pesanan
        if($data){ 
            ?>

            <!-- Menampilkan review product -->
            <section class="product_reviews">
                <div class="product_reviews_card">
                    <h1>Review Pelanggan</h1>
                    <?php 

                        //Ambil data review product sesuai product yang dipilih
                        //Cek jika parameter review == all maka query sql tidak dilimit
                        //Jika tidak maka query sql dilimit hanya mengambil 3 data saja
                        $limit = "LIMIT 3";
                        if(isset($_GET["review"]) && $_GET["review"] == "all") $limit = "";

                        $sql = "SELECT user.username, review.rating, review.comment, review.date FROM review JOIN user ON user.id=review.id_user WHERE review.id_product = '$id_product' " . $limit . "";
                        $records = $connect->query($sql);
                        
                        $count_review = 0; //Untuk cek apakah product yang dipilih ada review atau tidak

                        //Mencetak data review
                        foreach($records as $data){
                            $count_review++;
                            ?>

                            <div class="review_info">
                                <hr>
                                <div class="review_user">
                                    <h3><?= $data["username"] ?></h3>
                                    <p><?= $data["date"] ?></p>
                                </div>
                                <div class="review_rating">
                                    <?php
                                        //Mencetak icon bintang (rating)
                                        //bintang akan berwarna kuning jika kurang dari nilai rating
                                        for($i = 1; $i <= 5; $i++){
                                            if($i <= $data["rating"]) echo "<i class=\"fas fa-star star_active\"></i>";
                                            else echo "<i class=\"fas fa-star\"></i>";
                                        }
                                    ?>
                                    <p><?= $data["rating"] ?>.0</p>
                                </div>
                                <div class="review_message">
                                    <p><?= $data["comment"] ?></p>
                                </div>
                            </div>

                            <?php
                        }
                        
                        //Mencetak "Belum ada review" jika tidak ada review
                        if($count_review == 0) echo "<h3>Belum ada review</h3>";
                        
                        if((!isset($_GET["review"])) || $_GET["review"] != "all"){
                            echo "<a id=\"detail\" href=\"?product=$id_product&review=all\">Tampilkan semua review..</a>";
                        }else{
                            echo "<a id=\"detail\" href=\"?product=$id_product\">Tampilkan sedikit review..</a>";
                        }
                    ?>
                </div>
            </section>

            <!-- Menampilkan kolom pesanan -->
            <section class="order_column" id="order_column">
                <form action="./database/order-process.php" method="post" class="order_column_card" enctype="multipart/form-data">
                    <?= $message //menampilkan pesan error jika terjadi terjadi kesalahan upload file dan simpan data ?>
                    <h1>Kolom Pesanan</h1>
                    <p>Silakan isi data berikut</p>
                    <div class="order_column_files">
                        <label class="order_column_label">Silakan unggah foto Anda yang akan diproses</label>
                        <div class="order_column_button">
                            <input type="file" name="order_file" id="order_file" accept="image/*" required>
                            <span type="" id="order_file_button">Unggah Foto</span>
                            <span id="order_column_file_info"></span>
                        </div>
                    </div>
                    <label class="order_column_label" for="order_phone">Silakan isi nomor WhatsApp Anda, pastikan nomor tersebut masih aktif</label>
                    <input type="text" name="order_phone" id="order_phone" placeholder="Nomor WhatsApp Aktif" required>
                    <span class="order_column_warning"></span>
                    <input type="hidden" name="order_id_user" value="<?= $id_user ?>">
                    <input type="hidden" name="order_id_product" value="<?= $id_product ?>">
                    <button type="submit" id="order_column_submit" name="order_process">Kirimkan</button>
                </form>
            </section>

    <?php } ?>

    <?php include_once('./components/footer.php') ?>

    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/order.js"></script>
</body>
</html>