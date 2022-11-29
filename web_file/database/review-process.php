<?php
    if(isset($_POST["review_submit"])){
        //Mendapatkan informasi dari inputan user
        $message = $_POST["review_message"];
        $rating = $_POST["review_rating"];
        $id = $_POST["review_id"];
        $id_product = $_POST["review_id_product"];
        $id_user = $_POST["review_id_user"];
        $id_order = $_POST["review_id_order"];
        date_default_timezone_set("Asia/Jakarta");
        $current_date = date('Y-m-d H:i:s'); //Mendapatkan current time

        require "./connection.php";

        //Menyimpan data review user
        $sql = "INSERT INTO review VALUE ('$id', '$rating', '$message', '$current_date', '$id_user', '$id_product')";
        $result = $connect->query($sql);

        //Mengupdate data pesanan bahwa pesanan telah di review oleh user
        $sql = "UPDATE order_detail SET is_review = '1' WHERE order_detail.id = '$id_order'";
        $result = $connect->query($sql);

        if($result) header("location: ../order-detail.php?order_id=$id_order");
    }
    
?>