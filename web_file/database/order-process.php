<?php
    include "connection.php";

    //Fungsi untuk mencetak random string untuk id pesanan
    function generateRandomString() {
        $length = 12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, 61)];
        }
        return $randomString;
    }

    if(isset($_POST["order_process"])){
        //Mendapatkan informasi data yang di inputkan user
        $phone = $_POST["order_phone"];
        $id_user = $_POST["order_id_user"];
        $id_product = $_POST["order_id_product"];

        $id_order = generateRandomString();
        $id_rating = generateRandomString();
        date_default_timezone_set("Asia/Jakarta");
        $current_date = date('Y-m-d H:i:s'); //Mendapatkan current time

        //Informasi file foto user
        $file = basename($_FILES["order_file"]["name"]); //nama file + ekstensi --> nama_file.jpg
        $file_tmp = $_FILES["order_file"]["tmp_name"]; //file tmp --> file sementara yang disimpan di lokal
        $extention = strtolower(pathinfo($file,PATHINFO_EXTENSION)); //ekstensi file --> .jpg
        $saved_file_name = $id_user . "-" . $id_order . "." . $extention; //Nama file baru --> id_user-id_order.ekstensi --> n12uh12i2hb3-nqhGW22b2e1v.jpg
        $file_path = "../uploads/" . $saved_file_name; //Lokasi menyimpan file --> /uploads/nama_file_baru
        
        //Cek jika file berhasil disimpan
        if (move_uploaded_file($file_tmp, $file_path)) {
            //Jika file berhasil disimpan -> simpan data ke database
            $sql = "INSERT INTO order_detail VALUE ('$id_order', 1, '$saved_file_name', '$phone', 0, 0, 'Tidak Ada Pesan', '$current_date', '', '', 0, '$id_user', '$id_product', '$id_rating')";
            $result = $connect->query($sql);

            //Cek simpan data ke database
            //Jika data berhasil disimpan maka menuju ke halaman detail pesanan
            if($result) header("location: ../order-detail.php?order_id=$id_order");
            //Jika data gagal disimpan maka menampilkan pesan "Kesalahan dalam menyimpan data"
            else header("location: ../detail.php?product=$id_product&message=error_saving#order_column");
        }
        
        //Jika file gagal disimpan
        else {
            header("location: ../detail.php?product=$id_product&message=error_upload#order_column");
        }
    }
?>