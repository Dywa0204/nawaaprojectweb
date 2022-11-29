<?php 
    //Cek apakah user sudah login atau belum
    session_start();
    if(!isset($_SESSION['stored_id'])) header("location:auth.php?auth=register");

    include "./database/connection.php";

    //Array order_steps untuk mencetak gambar step dari peoses pesanan
    $order_steps = array("Persetujuan", "Pembayaran", "Diproses", "Selesai");

    $count = 0; //Untuk cek proses pesanan sampai pada proses apa sesuai status pesanannya

    if(isset($_GET["order_id"])){
        $order_id = $_GET["order_id"];

        //Ambil data detail pesanan sesuai id pesanan yang dipilih
        $sql = "SELECT product.name, product.time, order_detail.* FROM order_detail JOIN product ON product.id = order_detail.id_product WHERE order_detail.id = '$order_id'";
        $result = $connect->query($sql);
        $data = $result->fetch_assoc();

        //Cek proses pesanan sampai pada proses apa sesuai status pesanannya
        if($data){
            foreach($order_steps as $key => $item){
                $count++;
                if($item == $data["status"]) break;
            }
            if($data["status"] == "Dibatalkan") $count = -1;
        }
        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Nawaa Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/media.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <?php include_once('./components/navbar-logged.php') ?>

    <!-- Menampilkan gambar proses pesanan -->
    <section class="order_detail_steps">
        <h1>Detail Pesanan Anda</h1>
        <div class="detail_steps">
            <?php
                foreach($order_steps as $key => $item){
                    ?>
                        <div class="detail_steps_image">
                            <?php 
                                //Cek gambar/ikon proses pesanan
                                //Gambar akan berwarna hitam jika proses pesanan sudah terlewati
                                if($key < $count) echo "<img src=\"./assets/images/$item.png\"><h3>$item</h3>";
                                else echo "<img src=\"./assets/images/$item-light.png\"><h3 class=\"steps_light\">$item</h3>";
                            ?>
                        </div>
                    <?php
                    if($key < 3){
                        ?>
                        <div class="detail_steps_line">
                            <div class="steps_line">
                                <?php
                                    //Cek garis proses pesanan
                                    //Gris akan berwarna hitam jika proses pesanan sudah terlewati
                                    if($key+1 < $count) echo "<div class=\"lines_dashed\"></div>";
                                    else echo "<div class=\"lines_dashed_light\"></div>";
                                ?>
                                
                            </div>
                            <h3>&nbsp;</h3>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
    </section>

    <!-- Menampilkan detail pesanan -->
    <section class="order_detail_info">
        <div class="detail_info_card">
            <?php
                //Cek jika count != 0 maka cetak proses pesanan
                //Jika count == 0 maka cetak pesanan tidak diketahui
                if($count != 0){

                    //Cek proses pesanan sampai pada tahap apa sesuai status pesanannya

                    //Jika status pesanan == "Persetujuan"
                    //Cetak menunggu persetujuan admin
                    //Admin cek ke web khusus admin lalu menghubungi user guna membahas biaya editing
                    if($data["status"] == "Persetujuan"){
                        ?>
                            <h1>Menunggu Persetujuan Admin</h1>
                            <p>
                                Pesanan Anda berhasil dikirimkan. Silakan tunggu beberapa menit Admin kami akan menghubungi Anda melalui nomor WhatsApp yang telah Anda cantumkan guna membahas biaya editing
                            </p>
                            <a href="./database/order-cancel.php?order_id=<?= $order_id ?>" id="order_cancel">Batalkan Pesanan</a>
                            <a href="./dashboard.php" class="order_again">Pesan Lagi</a>
                        <?php
                    }

                    //Jika status pesanan == "Pembayaran"
                    //Cetak harga akhir sesuai yang diinputkan oleh admin
                    else if($data["status"] == "Pembayaran"){
                        ?>
                            <h1>Harga Akhir Pesanan Anda Adalah Rp. <?= $data["price"]; ?></h1>
                            <p>
                                Silakah selesaikan proses pembayaran dengan melakukan transfer pada rekening berikut ini
                            </p>
                            <p>
                                No Rek : 123123123123123<br>
                                Atas Nama  : Kamila Richana Fauziyah
                            </p>
                            <p>Konfirmasikan pembayaran Anda melaui pesan WhatsApp</p>
                            <a href="./database/order-cancel.php?order_id=<?= $order_id ?>" id="order_cancel">Batalkan Pesanan</a>
                            <a href="./dashboard.php" class="order_again">Pesan Lagi</a>
                        <?php
                    }

                    //Jika status pesanan == "Diproses"
                    //Cetak detail pesanan + pesan untuk menunggu editing
                    else if($data["status"] == "Diproses"){
                        ?>
                            <h1>Pesanan Anda Sedang Diproses</h1>
                            <p>
                                Mohon ditunggu, pesanan Anda sedang diproses oleh desainer kami. Perkiraan waktu selesai dalam <?= $data["time"]; ?> hari.
                            </p>
                            <h2>Detail Pesanan</h2>
                            <div class="detail_info">
                                <span>Jenis Desain</span>
                                <span>: <?= $data["name"]; ?></span>
                                <span>Jumlah orang</span>
                                <span>: <?= $data["person"]; ?></span>
                                <span>Total Harga</span>
                                <span>: <?= $data["price"]; ?></span>
                                <span>Pesan tambahan</span>
                                <span>: <?= $data["message"]; ?></span>
                                <span>Waktu pesan</span>
                                <span>: <?= $data["date_start"]; ?></span>
                            </div>
                            <a href="./dashboard.php" class="order_again">Pesan Lagi</a>
                        <?php
                    }

                    //Jika status pesanan == "Selesai"
                    //Mencetak tombol download file hasil editing + detail pesanan + kolom review
                    else if($data["status"] == "Selesai"){
                        ?>
                            <h1>Selamat Pesanan Anda Telah Selesai</h1>
                            <p>Pesanan Anda telah selesai. Anda dapat mengunduh file hasil editan dengan klik tombol di bawah ini.</p>
                            <a href="./downloads/<?= $data["file_result"] ?>" class="download_button" download>Unduh File</a>
                            <h2>Detail Pesanan</h2>
                            <div class="detail_info">
                                <span>Jenis Desain</span>
                                <span>: <?= $data["name"]; ?></span>
                                <span>Jumlah orang</span>
                                <span>: <?= $data["person"]; ?></span>
                                <span>Total Harga</span>
                                <span>: <?= $data["price"]; ?></span>
                                <span>Pesan tambahan</span>
                                <span>: <?= $data["message"]; ?></span>
                                <span>Waktu pesan</span>
                                <span>: <?= $data["date_start"]; ?></span>
                                <span>Waktu selesai</span>
                                <span>: <?= $data["date_finish"]; ?></span>
                            </div>
                        <?php

                            //Cek jika user belum memberikan review maka cetak kolom review
                            //Jika user belum memberikan review maka cetak review dari user
                            if($data["is_review"] == 0){
                                ?>
                                    <p>Silakan berikan review Anda untuk menyelesaikan proses pemesanan</p>
                                    <form action="./database/review-process.php" class="review_process" method="post">
                                        <h2>Berikan rating Anda</h2>
                                        <div class="detail_info_rating">
                                            <i id="detail_info_rating_1" class="fas fa-star"></i>
                                            <i id="detail_info_rating_2" class="fas fa-star"></i>
                                            <i id="detail_info_rating_3" class="fas fa-star"></i>
                                            <i id="detail_info_rating_4" class="fas fa-star"></i>
                                            <i id="detail_info_rating_5" class="fas fa-star"></i>
                                            <span id="detail_info_rating">0.0</span>
                                            <input type="hidden" name="review_rating" id="review_rating" value="0">
                                        </div>
                                        <input type="hidden" name="review_id" value="<?= $data["id_rating"] ?>">
                                        <input type="hidden" name="review_id_user" value="<?= $data["id_user"] ?>">
                                        <input type="hidden" name="review_id_product" value="<?= $data["id_product"] ?>">
                                        <input type="hidden" name="review_id_order" value="<?= $data["id"] ?>">
                                        <h2>Berikan komentar Anda</h2>
                                        <input type="text" name="review_message" id="review_message" placeholder="Komentar Anda">
                                        <button type="submit" name="review_submit">Kirimkan Review Anda</button>
                                    </form>
                                <?php
                            }else{
                                //Ambil data review sesuai pesanan yang dipilih
                                $sql = "SELECT rating, comment FROM review WHERE id = '" . $data["id_rating"] . "'";
                                $result = $connect->query($sql);
                                $data = $result->fetch_assoc();
                                ?>
                                    <h2>Review Anda</h2>
                                    <?php
                                        //Mencetak icon bintang (rating)
                                        //bintang akan berwarna kuning jika kurang dari nilai rating
                                        for($i = 1; $i <= 5; $i++){
                                            if($i <= $data["rating"]) echo "<i class=\"fas fa-star star_active\"></i>";
                                            else echo "<i class=\"fas fa-star\"></i>";
                                        }
                                    ?>
                                    <span><?= $data["rating"] ?></span>
                                    <p><?= $data["comment"] ?></p>
                                    <a href="./dashboard.php" class="order_again">Pesan Lagi</a>
                                <?php
                            }
                    }

                    //Jika status pesanan == "Dibatalkan"
                    //Cetak "Pesanan Dibatalkan" + detail pesanan
                    else{
                        ?>
                            <h1>Pesanan Dibatalkan</h1>
                            <div class="detail_info">
                                <span>Jenis Desain</span>
                                <span>: <?= $data["name"]; ?></span>
                                <span>Waktu pesan</span>
                                <span>: <?= $data["date_start"]; ?></span>
                            </div>
                            <a href="./dashboard.php" class="order_again">Pesan Lagi</a>
                        <?php
                    }
                }

                //Cetak pesanan tidak diketahui jika count == 0
                else{
                    echo "<h1>Pesanan Tidak Diketahui</h1>";
                }
            ?>
            
        </div>
    </section>

    <?php include_once('./components/footer.php') ?>

    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/review.js"></script>
</body>
</html>