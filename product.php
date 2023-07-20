<?php
$adminUserName = "admin";
require_once("./config.php");
if(!empty($_GET["p"])) $productId = $_GET["p"];

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
    <script src="product.js" defer></script>
    <title>Home</title>
</head>

<body>
    <input type="hidden" id="productId" value=<?= $productId ?>>
    <header>
        <div class="logo">
            <a href="index.php" class="logo-title">L4ptop</a>
        </div>
        <div class="menu">
            <a href="./logout.php">Log out</a>
        </div>
    </header>
    <main id="show-prodct">
        <div class="product-show"></div>
        <div class="actions">
            <?php if ($admin) : ?>
                <button id="update">Update</button>
                <form id="delete-form">
                    <input type="hidden" name="product" value=<?= $productId ?>>
                    <button id="delete">Delete</button>
                </form>
            <?php endif ?>
        </div>
    </main>
</body>

</html>