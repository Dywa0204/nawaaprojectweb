<?php 

    include "connection.php";

    //Check parameter auth
    //Jika ada maka meneruskan proses autentikasi
    //Jika tidak maka akan menuju ke halaman auth.php
    if(isset($_GET["auth"])){

        //Jika parameter auth == register
        //Daftar akun baru
        if($_GET["auth"] == "register"){

            //Fungsi untuk mencetak random string untuk id user
            function generateRandomString() {
                $length = 12;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, 61)];
                }
                return $randomString;
            }
    
            //Mendapatkan informasi dari inputan user
            $id = generateRandomString();
            $firstname = $_POST["first_name"];
            $lastname = $_POST["last_name"];
            $username = $_POST["reg_username"];
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST["reg_password"];
            //Membuat hash dari password (password dienkripsi)
            $hash = password_hash($password, PASSWORD_DEFAULT);
    
            //Menyimpan data user
            $sql = "INSERT INTO user (id, firstname, lastname, username, email, password, status) VALUES ('$id', '$firstname', '$lastname', '$username', '$email', '$hash', 'user')";
    
            //Cek jika ada error atau tidak saat menyimpan data baru
            //Jika tidak error maka user dimintai untuk login
            if($query = $connect->query($sql)){
                header("location: ../auth.php?auth=login&message=success");
            }
            //Jika terjadi error
            else{
                $check = $connect->error;
                //Username bersifat unik jadi tidak boleh ada yang sama
                if($check == "Duplicate entry '$username' for key 'username'") {
                    header("location: ../auth.php?auth=register&message=error_duplicate_username");
                }else{
                    header("location: ../auth.php?auth=register&message=error");
                }
            }
        } 
        
        //Jika parameter auth == login
        //Login ke user -> set session "stored_id" diisi dengan id user
        else if ($_GET["auth"] == "login"){
            session_start();
            $username = $_POST["login_username"];
            $password = $_POST["login_password"];
    
            //Ambil data user
            $sql = "SELECT id, username, password, status FROM user WHERE username = '$username'";
            $result = $connect->query($sql);
            $data = $result->fetch_assoc();
    
            //Jika data ada maka meneruskan proses autentikasi
            if($data){
                //Cek apakah password benar (password didekripsi)
                if(password_verify($password, $data["password"])){
                    $_SESSION["stored_id"] = $data["id"];
    
                    //Cek status user
                    //Jika status == user maka diarahkan ke halaman dashboard
                    if($data["status"] == "user") header("location: ../dashboard.php");
                    //Jika status == admin maka diarahkan ke web khusus admin
                    else if($data["status"] == "admin") header("location: ../admin.php");
                }
                //Jika password salah maka akan muncul pesan Password salah
                else header("location: ../auth.php?auth=login&message=wrongpass");
            }
            
            //Jika data tidak ada maka akan muncul pesan username belum terdaftar
            else{
                header("location: ../auth.php?auth=login&message=notregistered");
            }
        } 
        
        //Jika parameter auth == logout
        //Membersihkan session
        else if ($_GET["auth"] == "logout"){
            session_start();
            session_destroy();
            header("location: ../dashboard.php");
        }    
    }else{
        header("location: ../auth.php");
    }
?>