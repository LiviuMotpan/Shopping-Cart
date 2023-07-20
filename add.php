<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L4ptop</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="ajax.js" defer></script>
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
        <form id="add-pr" method="POST">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="description" placeholder="Description">
            <input type="text" name="image" placeholder="Image Link">
            <input type="number" name="price" step="0.01"  placeholder="Price ($)">
            <button class="add-product-btn">Create</button>
        </form>
    </main>
</body>

</html>