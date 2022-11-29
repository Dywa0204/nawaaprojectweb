<?php
    require "./database/connection.php";

    //Cek jika bukan admin maka akan diarahkan ke halaman auth
    session_start();
    $id_user = $_SESSION['stored_id'];
    $sql = "SELECT status FROM user WHERE id='$id_user'";
    $result = $connect->query($sql);
    $data = $result->fetch_assoc();
    if($data != "admin") header("./auth.php");

    //Cek jika tombol yang diklik adalah tombol "Update"
    if(isset($_POST["submit_button"])){
        $id_order = $_GET["order_id"];
        $order_status = $_POST["detail_order_status"];
        $order_person = $_POST["detail_order_person"];
        $order_price = $_POST["detail_order_price"];
        $order_message = $_POST["detail_order_message"];

        //Upload file hasil editing
        if($_FILES["detail_order_result"]["name"] != ""){
            $file = basename($_FILES["detail_order_result"]["name"]);
            $file_tmp = $_FILES["detail_order_result"]["tmp_name"];
            $extention = strtolower(pathinfo($file,PATHINFO_EXTENSION));
            $saved_file_name = $id_user . "-" . $id_order . "." . $extention; 
            $file_path = "./downloads/" . $saved_file_name;
            if(move_uploaded_file($file_tmp, $file_path)){
                $sql = "UPDATE order_detail SET file_result = '$saved_file_name' WHERE id = '" . $_GET["order_id"] . "'";
                $connect->query($sql);
            }
        }

        //Update data sesaui inputan admin
        $sql = "UPDATE order_detail SET status = '$order_status', person = '$order_person', price = '$order_price', message = '$order_message' WHERE id = '" . $_GET["order_id"] . "'";
        $record = $connect->query($sql);

        if($record) echo "<script>alert(\"Data berhasil diperbaharui\")</script>";
    }

    //Cek jika tombol yang diklik adalah tombol "Batalkan Pesanan"
    else if(isset($_POST["cancel_button"])){
        $id_order = $_GET["order_id"];

        //Update data status "Dibatalkan" untuk pesanan sesuai id yang dipilih
        $sql = "UPDATE order_detail SET order_detail.status = 'Dibatalkan' WHERE order_detail.id = '$id_order'";
        $result = $connect->query($sql);

        if($result) echo "<script>alert(\"Pesanan berhasil dibatalkan\")</script>";
    }
    
    //Cek jika tombol yang diklik adalah tombol "Hapus Data Pesanan"
    else if(isset($_POST["delete_button"])){
        //Menghapus data pesanan sesuai id yang dipilih
        $sql = "DELETE FROM order_detail WHERE id = '" . $_GET["order_id"] . "'";
        $record = $connect->query($sql);

        if($record){
            echo "<script>alert(\"Data berhasil dihapus\")</script>";
            header("location:./admin.php");
        } 
    }

    $sql1 = "SELECT user.username, product.name, order_detail.id, order_detail.status, order_detail.date_start FROM order_detail JOIN user on user.id = order_detail.id_user JOIN product ON product.id = order_detail.id_product ORDER BY order_detail.date_start DESC";

    $record = $connect->query($sql1);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/admin.css">
</head>
<body>
    <div class="header">
        <h1>DATABASE ADMIN NAWAA PROJECT</h1>
        <a href="./database/auth-process.php?auth=logout">Logout</a>
    </div>


    <div class="order">

        <!-- Menampilkan daftar pesanan (kiri) -->
        <div class="order_list">
            <h2>Daftar Pesanan</h2>
            <?php
                foreach($record as $row){
                    ?>
                    <a href="./admin.php?order_id=<?= $row["id"] ?>">
                        <div class="order_list_content">
                            <p><?= $row["username"]; ?></p>
                            <p><?= $row["name"]; ?></p>
                            <p>Status : <?= $row["status"]; ?></p>
                        </div>
                    </a>
                    <?php
                }
            ?>
        </div>

        <!-- Menampilkan detail pesanan -->
        <div class="detail_order">
            <?php
                if(isset($_GET["order_id"])){
                    $order_id = $_GET["order_id"];
                    $sql2 = "SELECT user.firstname, user.lastname, user.username, product.name, order_detail.* FROM order_detail JOIN user ON user.id = order_detail.id_user JOIN product ON product.id = order_detail.id_product WHERE order_detail.id = '$order_id'";

                    $status = array("Persetujuan", "Pembayaran", "Diproses", "Selesai", "Dibatalkan");

                    $record = $connect->query($sql2);
                    $row = $record->fetch_assoc();
                    ?>
                        <div class="detail_order_info">
                            <div class="detail_order_info_left">
                                <h2>Detail Pesanan</h2>
                                <p>Username : <?= $row["username"]; ?></p>
                                <p>Nama lengkap  : <?= $row["firstname"] . " " . $row["lastname"]; ?></p>
                                <p>Jenis desain : <?= $row["name"]; ?></p>
                                <p>Nomor telephon : <?= $row["phone"]; ?></p>
                                <p>Tanggal pesan : <?= $row["date_start"]; ?></p>
                            </div>
                            <div class="detail_order_info_right">
                                <img src="./uploads/<?= $row["file_path"] ?>">
                            </div>
                        </div>
                        <form action="" method="post" class="detail_order_update" enctype="multipart/form-data">
                            <h2>Update Pesanan</h2>
                            <label for="detail_order_status">Status</label>
                            <select name="detail_order_status" id="detail_order_status">
                                <?php
                                    foreach($status as $data){
                                        if($data == $row["status"]){
                                            echo "<option value=\"$data\" selected>$data</option>";
                                        }else{
                                            echo "<option value=\"$data\">$data</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <div class="detail_order_field">
                                <div>
                                    <label for="detail_order_person">Jumlah Orang</label>
                                    <input type="number" name="detail_order_person" id="detail_order_person" value="<?= $row["person"] ?>">
                                </div>
                                <div>
                                    <label for="detail_order_price">Harga Akhir</label>
                                    <input type="number" name="detail_order_price" id="detail_order_price" value="<?= $row["price"] ?>">
                                </div>
                            </div>
                            <label for="detail_order_message">Pesan Tambahan</label>
                            <textarea name="detail_order_message" id="detail_order_message" rows="10"><?= $row["message"] ?></textarea>
                            <label for="detail_order_result">File Hasil</label>
                            <input type="file" name="detail_order_result" id="detail_order_result">
                            <p>Nama File : <?= $row["file_result"] ?></p>
                            <div class="buttons">
                                <button type="submit" name="submit_button">Update</button>
                                <button type="submit" class="button_cancel" name="cancel_button">Batalkan Pesanan</button>
                                <button type="submit" name="delete_button" style="background-color: #F51D1D">Hapus Data Pesanan</button>
                            </div>
                        </form>
                    <?php
                } else {
                    ?>
                        <div class="detail_order_info"></div>
                    <?php
                }
            ?>
        </div>

        <!-- Menampilkan daftar pesan dan saran -->
        <div class="suggest_list">
            <h2>Daftar Pesan dan Saran</h2>
            <?php
                $sql = "SELECT * FROM suggest";
                $record = $connect->query($sql);
                foreach($record as $row){
                    ?>
                        <div class="suggest_list_content">
                            <p><?= $row["name"] ?></p>
                            <p><?= $row["email"] ?></p>
                            <p><?= $row["message"] ?></p>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</body>
</html>