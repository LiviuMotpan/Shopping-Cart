<?php
require_once("config.php");
$productId = $_GET["p"];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];


$productId = $_GET["p"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L4ptop</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="product.js" defer></script>
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php" class="logo-title">L4ptop</a>
        </div>
        <div class="menu">
            <a href="./logout.php">Log out</a>
        </div>
    </header>
    <main class="add-product">

        <h1 class="text-margin">
            Create A Product
        </h1>
        <form id="edit-form" method="POST">
            <input type="text" name="name" placeholder="Name" value="<?= $product['name'] ?>">
            <input type="text" name="description" placeholder="Description" value="<?= $product['description'] ?>">
            <input type="text" name="image" placeholder="Image Link" value="<?= $product['image'] ?>">
            <input type="number" name="price" step="0.01" placeholder="Price ($)" value="<?= $product['price'] ?>">
            <input type="hidden" name="product" value=<?= $productId ?>>
            <button class="edit-product-btn">Update</button>
        </form>
    </main>
</body>

</html>