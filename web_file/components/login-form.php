<form class="auth_form" action="./database/auth-process.php?auth=login" method="post">
    <h2>Masuk</h2>
    <?php
        if(isset($_GET["message"])){
            if($_GET["message"] == "success") echo "<p class=\"success\">Akun berhasil didaftarkan. Silakan Masuk</p>";
            else if($_GET["message"] == "wrongpass") echo "<p class=\"fail\">Password salah!</p>";
            else if($_GET["message"] == "notregistered") echo "<p class=\"fail\">Username belum terdaftar</p>";
        }
    ?>
    <label for="login_username">Username</label>
    <input type="text" name="login_username" id="login_username" placeholder="Username" required>
    <label for="login_password">Password</label>
    <input type="password" name="login_password" id="login_password" placeholder="Password" required>
    <button type="submit">Masuk Sekarang</button>
    <div class="auth_form_ask">
        Belum punya akun?<a href="./auth.php?auth=register">Daftar sekarang</a>
    </div>
</form>