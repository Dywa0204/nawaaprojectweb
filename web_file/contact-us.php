<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Nawaa Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/media.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <?php include_once('./components/navbar.php') ?>

    <div class="contact_container">

        <!-- Menampilkan info kontak -->
        <div class="contact_info">
            <h1>Apakah ada yang bisa kami bantu?</h1>
            <div class="contact_info_media_social">
                <div class="contact_info_media_social_left">
                    <h3>Hubungi kami</h3>
                    <i class="far fa-envelope"></i>
                    <span>nawaa.projectofficial@gmail.com</span><br>
                    <i class="fab fa-whatsapp"></i>
                    <span>+62 8773-6948-328</span>
                </div>
                <div class="contact_info_media_social_right">
                    <h3>Ikuti kami</h3>
                    <i class="fab fa-facebook"></i>
                    <span>Nawaa Project</span><br>
                    <i class="fab fa-instagram"></i>
                    <span>nawaa.project</span>
                </div>
            </div>
            <div class="contact_info_address">
                <h3>Lokasi Kantor Kami</h3>
                <p>Jalan Karangrejo No.150A, RT.8/RW.2, Karangrejo, Kec. Gajah Mungkur, Kab. Semarang, Prov. Jawa Tengah</p>
            </div>
        </div>

        <!-- Menampilkan kolom pesan dan saran -->
        <div class="contact_suggest">
            <form action="./database/suggest-process.php" method="post" class="contact_suggest_card">
                <?php
                    if(isset($_GET["message"]) && $_GET["message"] == "success"){
                        echo "<h3 style=\"color: #27b11b\">Terimakasih atas pesan dan saran yang Anda berikan</h3>";
                    }
                ?>
                <h1>Tinggalkan pesan atau saran untuk kami</h1>
                <label for="contact_suggest_name">Nama</label>
                <input type="text" name="contact_suggest_name" id="contact_suggest_name" placeholder="Nama">
                <label for="contact_suggest_email">Email</label>
                <input type="text" name="contact_suggest_email" id="contact_suggest_email" placeholder="Email">
                <label for="contact_suggest_message">Pesan atau Saran</label>
                <textarea name="contact_suggest_message" id="contact_suggest_message" rows="10" placeholder="Pesan atau Saran"></textarea>
                <button type="submit" name="submit_button">Kirimkan</button>
            </form>
        </div>
    </div>

    <?php include_once('./components/footer.php') ?>

    <script src="./assets/js/script.js"></script>
</body>
</html>