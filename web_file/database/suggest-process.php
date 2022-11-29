<?php
    if(isset($_POST["submit_button"])){
        include "./connection.php";

        //Mendapatkan informasi dari inputan user
        $name = $_POST["contact_suggest_name"];
        $email = $_POST["contact_suggest_email"];
        $message = $_POST["contact_suggest_message"];

        //Menyimpan data pesan atau saran dari user
        $sql = "INSERT INTO suggest VALUE ('', '$name', '$email', '$message')";
        $result = $connect->query($sql);

        if($result) header("location: ../contact-us.php?message=success");
    }
?>