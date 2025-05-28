<?php
$title = "EID Store";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/cep-nav.css">
    <link rel="stylesheet" href="css/banner.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/categories.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
   

    <?php include 'header.php'; ?>
    <?php include 'banner.php'; ?>
    <?php include 'products.php'; ?>
    <?php include 'categoria.php'; ?>
    <?php include 'footer.php'; ?>

    <!-- Script JS -->
    <script src="js/banner.js"></script>
</body>

</html>