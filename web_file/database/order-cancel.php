<?php
    $id_order = $_GET["order_id"];
    require "./connection.php";

    //Mengupdate data status pesanan menjadi "Dibatalkan" (Sesuai id pesanan yang dipilih)
    $sql = "UPDATE order_detail SET order_detail.status = 'Dibatalkan' WHERE order_detail.id = '$id_order'";
    $result = $connect->query($sql);

    if($result) header("location: ../order-detail.php?order_id=$id_order");
?>