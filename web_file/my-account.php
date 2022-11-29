<?php 
    //Cek apakah user sudah login atau belum
    session_start();
    if(!isset($_SESSION['stored_id'])) header("location:auth.php?auth=register");

    //Mendapatkan informasi id user
    $id_user = $_SESSION['stored_id'];

    require "./database/connection.php";

    //Ambil data user sesuai user yang login
    $sql = "SELECT firstname, lastname, username, email FROM user WHERE id = '$id_user'";
    $result = $connect->query($sql);
    $data = $result->fetch_assoc();

    //Cek parameter show. 
    //Jika show == history maka query sql = ambil data pesanan yang sudah direview atau pesanan yang dibatalkan
    //Jika show != history maka query sql = ambil data pesanan yang belum direview dan pesanan yang tidak dibatalkan
    if(isset($_GET["show"]) && $_GET["show"] == "history"){
        $sql = "SELECT product.name, order_detail.id, order_detail.message, order_detail.date_start, order_detail.status, order_detail.is_review FROM order_detail JOIN product ON product.id = order_detail.id_product WHERE order_detail.id_user = '$id_user' AND ( order_detail.is_review = 1 OR order_detail.status = 'Dibatalkan' ) ORDER BY order_detail.date_start DESC";
        $style = ".order_head_all{opacity: 0.7;}";
    }else{
        $sql = "SELECT product.name, order_detail.id, order_detail.message, order_detail.date_start, order_detail.status, order_detail.is_review FROM order_detail JOIN product ON product.id = order_detail.id_product WHERE order_detail.id_user = '$id_user' AND ( order_detail.is_review = 0 AND order_detail.status != 'Dibatalkan' ) ORDER BY order_detail.date_start DESC";
        $style = ".order_head_history{opacity: 0.7;}";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Nawaa Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/media.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <style><?= $style ?></style>
</head>
<body>
    <?php include_once('./components/navbar-logged.php') ?>

    <!-- Menampilkan info akun -->
    <section class="account_info">
        <h1>Info Akun <a href="./edit-account.php"><i class="material-icons">edit</i></a></h1>
        <div class="account_info_data">
            <span>Nama Lengkap</span>
            <span>:&nbsp;<?= $data["firstname"] . " " . $data["lastname"]; ?></span>
            <span>Username</span>
            <span>:&nbsp;<?= $data["username"]; ?></span>
            <span>Email</span>
            <span>:&nbsp;<?= $data["email"]; ?></span>
        </div>
    </section>

    <!-- Menampilkan daftar pesanan dari akun -->
    <section class="account_order">
        <div class="account_order_card">
            <div class="account_order_head">
                <div class="order_head_all">
                    <a href="./my-account.php">
                        <h2>Daftar Pesanan</h2>
                    </a>
                </div>
                <div class="order_head_history">
                    <a href="./my-account.php?show=history">
                        <h2>Riwayat Pesanan</h2>
                    </a>
                </div>
            </div>
            <div class="account_order_list_background">
                <div class="account_order_list">
                    <?php
                        $records = $connect->query($sql);
                        $count = 0;

                        //Cetak data pesanan dan jika diklik akan menuju ke halaman detail pesanan
                        foreach($records as $data){
                            $count++;
                            ?>
                            <a href="./order-detail.php?order_id=<?= $data["id"] ?>" class="account_order_list_content">
                                <h3><?= $data["name"]; ?></h3>
                                <p><?= $data["message"]; ?></p>
                                <p>Waktu pesan : <?= $data["date_start"]; ?></p>
                                <b>Status  : <?php echo $data["status"];
                                    if($data["status"] == "Selesai" && $data["is_review"]) echo " (Sudah review)";
                                    else if($data["status"] == "Selesai" && !$data["is_review"]) echo " (Belum Review)";
                                ?></b>
                            </a>
                            <?php
                        }
                        //Jika tidak ada pesanan maka menampilkan "Belum Ada Pesanan"
                        if($count == 0) echo "<h3>Belum Ada Pesanan</h3>";
                    ?>
                </div>
            </div>
        </div>

        <!-- Tombol logout -->
        <a href="./database/auth-process.php?auth=logout" class="account_logout_button">Logout</a>
    </section>

    <?php include_once('./components/footer.php') ?>

    <script src="./assets/js/script.js"></script>
</body>
</html>