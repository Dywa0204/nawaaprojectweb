<?php
    //Cek apakah user sudah login atau belum
    session_start();
    if(!isset($_SESSION['stored_id'])) header("location:auth.php?auth=register");

    include "./database/connection.php";
    $error = null;

    //Cek jika tombol yang diklik oleh user adalah tombol "Perbaharui Akun"
    if(isset($_POST["update_account"])){
        $id = $_POST["user_id"];
        $firstname = $_POST["first_name"];
        $lastname = $_POST["last_name"];
        $username = $_POST["username"];
        $email = $_POST["email"];

        //Update data baru
        $sql = "UPDATE user SET firstname='$firstname', lastname='$lastname', username='$username', email='$email' WHERE id='$id'";
        
        //Cek jika ada error atau tidak saat menyimpan data baru
        if($query = $connect->query($sql)){
            $error = "<b style=\"color: green\">Data akun berhasil diperbaharui</b>";
        }
        //Jika terjadi error
        else{
            $check = $connect->error;
            //Username bersifat unik jadi tidak boleh ada yang sama
            if($check == "Duplicate entry '$username' for key 'username'") {
                $error = "<b>Username sudah terpakai gunakan yang lain</b>";
            }else{
                $error = "<b>Terjadi kesalahan saat memperbaharui data, silakan coba lagi</b>";
            }
        }
    }

    //Cek jika tombol yang diklik oleh user adalah tombol "Perbaharui Password"
    if(isset($_POST["update_password"])){
        $id = $_POST["user_id"];
        $old_password = $_POST["old_password"];
        $new_password = $_POST["new_password"];
        $hash = password_hash($new_password, PASSWORD_DEFAULT);

        //Ambil data password untuk cek password lama
        $sql = "SELECT password FROM user WHERE id = '$id'";
        $result = $connect->query($sql);
        $data = $result->fetch_assoc();

        if($data){
            //Cek apakah password lama benar
            if(password_verify($old_password, $data["password"])){
                //Jika benar update data password baru
                $sql = "UPDATE user SET password='$hash' WHERE id='$id'";
                $result = $connect->query($sql);
                if($result) $error = "<b style=\"color: green\">Data Password berhasil diperbaharui</b>";
                else $error = "<b>Terjadi kesalahan saat memperbaharui data, silakan coba lagi</b>";
            }
            else $error = "<b>Password lama salah</b>";
        }else $error = "<b>Terjadi kesalahan saat memperbaharui data, silakan coba lagi</b>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account - Nawaa Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/media.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <?php include_once('./components/navbar-logged.php') ?>

    <!-- Menampilkan form edit akun -->
    <div class="edit_account_container">
        <div class="edit_account_card">
            <?php if($error) echo $error; ?>
            <h1>Edit Akun Anda</h1>
            <?php
                if(isset($_SESSION["stored_id"])){
                    $user_id = $_SESSION["stored_id"];

                    //Ambil data user
                    $sql = "SELECT * FROM user WHERE id='$user_id'";
                    $result = $connect->query($sql);
                    $data = $result->fetch_assoc();
                    if($data){
                    ?>
                        <form action="" method="post" class="edit_account_info">
                            <input type="hidden" name="user_id" value="<?= $data["id"] ?>">
                            <div class="auth_form_name">
                                <div class="auth_form_firstname">
                                    <label for="first_name">Nama Depan</label>
                                    <input type="text" name="first_name" id="first_name" placeholder="Nama Depan" value="<?= $data["firstname"] ?>" required>
                                </div>
                                <div class="auth_form_lastname">
                                    <label for="last_name">Nama Belakang</label>
                                    <input type="text" name="last_name" id="last_name" placeholder="Nama Belakang" value="<?= $data["lastname"] ?>" required>
                                </div>
                            </div>
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" placeholder="Username" value="<?= $data["username"] ?>" required>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email" value="<?= $data["email"] ?>" required>
                            <button type="submit" name="update_account">Perbaharui Akun</button>
                        </form>
                        <form action="" method="post"  class="edit_account_password">
                            <h2>Perbaharui Password</h2>
                            <input type="hidden" name="user_id" value="<?= $data["id"] ?>">
                            <label for="old_password">Password Lama</label>
                            <input type="password" name="old_password" id="old_password" placeholder="Password Lama" required>
                            <label for="new_password">Password Baru</label>
                            <input type="password" name="new_password" id="new_password" placeholder="Password Baru" required>
                            <button type="submit" name="update_password">Perbaharui Password</button>
                        </form>
                    <?php
                    }else{
                        echo "<h2>Akun Tidak Ditemukan</h2>";
                    }
                }else{
                    echo "<h2>Akun Tidak Ditemukan</h2>";
                }
            ?>
            
        </div>
    </div>
    

    <?php include_once('./components/footer.php') ?>

    <script src="./assets/js/script.js"></script>
</body>
</html>