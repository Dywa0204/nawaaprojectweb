<form class="auth_form" action="./database/auth-process.php?auth=register" method="post">
    <h2>Daftar</h2>
    <?php
        if(isset($_GET["message"])){
            if($_GET["message"] == "error_duplicate_username"){
                echo "<p style=\"color: red\" class=\"success\">Username telah dipakai, gunakan yang lain</p>";
            }else if($_GET["message"] == "error"){
                echo "<p style=\"color: red\" class=\"success\">Terjadi kesalahan, silakan coba lagi</p>";
            } 
        }
    ?>
    <div class="auth_form_name">
        <div class="auth_form_firstname">
            <label for="first_name">Nama Depan</label>
            <input type="text" name="first_name" id="first_name" placeholder="Nama Depan" required>
        </div>
        <div class="auth_form_lastname">
            <label for="last_name">Nama Belakang</label>
            <input type="text" name="last_name" id="last_name" placeholder="Nama Belakang" required>
        </div>
    </div>
    <label for="reg_username">Username</label>
    <input type="text" name="reg_username" id="reg_username" placeholder="Username" required>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <label for="reg_password">Password</label>
    <input type="password" name="reg_password" id="reg_password" placeholder="Password" required>
    <button type="submit">Daftar Sekarang</button>
    <div class="auth_form_ask">
        Sudah punya akun?<a href="./auth.php?auth=login">Masuk sekarang</a>
    </div>
</form>