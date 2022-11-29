<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication - Nawaa Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/media.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <?php include_once('./components/navbar.php') ?>

    <div class="auth_background">
        <div class="auth_container">

            <!-- Menampilka logo -->
            <div class="auth_container_left">
                <img src="./assets/images/logo.png" alt="Nawaa Project">
            </div>

            <!-- Menampilkan form login dan register -->
            <div class="auth_container_right">
                <div class="auth_form_card">

                <?php 
                    //Cek parameter :
                    //Jika parameter auth == login -> cetak komponen form login
                    //Jika parameter auth == register -> cetak komponen form register
                    //Jika tidak keduanya -> cetak komponen form register
                    if(isset($_GET["auth"])){
                        if($_GET["auth"] == "login") include "./components/login-form.php";
                        else include "./components/register-form.php";
                    }else{
                        include "./components/register-form.php";
                    }
                ?>

                </div>
            </div>

        </div>
    </div>


    <?php include_once('./components/footer.php') ?>

    <script src="./assets/js/script.js"></script>
</body>
</html>