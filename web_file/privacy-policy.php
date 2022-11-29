<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Nawaa Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/media.css">
    <link href="https://fonts.googleapis.com/css2?family=Mulish" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <?php include_once('./components/navbar.php') ?>

    <div class="privacy_policy_container">
        <div class="privacy_policy_container_card">
            <h1>Kebijakan Privasi Nawaa Project</h1>
            <?php
                $fh = fopen("./assets/privacy-policy.txt", 'r');
                $pageText = fread($fh, 25000);
                echo nl2br($pageText);
            ?>
        </div>
    </div>

    <?php include_once('./components/footer.php') ?>

    <script src="./assets/js/script.js"></script>
</body>
</html>