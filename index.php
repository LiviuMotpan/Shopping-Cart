<?php
$adminUserName = "admin";
require_once("./config.php");

if (empty($_SESSION["user_id"])) {
    header("Location: ./login.php");
} else {
    $admin = false;
    $id = $_SESSION["user_id"];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    if ($user["login"] == $adminUserName) {
        $admin = true;
    }
    $pageNr = (!empty($_GET["p"]) ? $_GET["p"] : 0);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="ajax.js" defer></script>
    <script src="app.js" defer></script>
    <title>Home</title>
</head>

<body>
    <input type="hidden" id="userId" value=<?= $id ?>>
    <input type="hidden" id="page" value=<?= $pageNr ?>>

    <header>
        <div class="logo">
            <a href="index.php" class="logo-title">L4ptop</a>
        </div>
        <div class="menu">
            <a href="./logout.php">Log out</a>
            <i class="fa-solid fa-cart-shopping" id="open-cart"></i>
        </div>
    </header>

    <main>
        <div class="sort-options">
            <input type="text" name="search" id="search" placeholder="Search">
            <select id="price-sort">
                <option value="price-up">Price Up</option>
                <option value="price-low">Price Low</option>
            </select>
        </div>
        <?php if ($admin) : ?>
            <div class="btns-container">
                <button id="add-product">Add A Product</button>
            </div>
        <?php endif ?>
        <div class="products">

        </div>
        <div class="pages">

        </div>
        <div class="cart">
            <div class="header">
                <h2>Your Cart</h2>
                <i class="fa-solid fa-x" id="close-cart"></i>
            </div>
            <div class="products-cart"></div>
        </div>
    </main>
</body>

</html>