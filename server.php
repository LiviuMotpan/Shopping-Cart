<?php

try {
    require_once("config.php");

    if ($_POST["type"] == "REGISTER") {
        if ($_POST["password"] == $_POST["password2"]) {
            $sql = "SELECT login FROM users";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $logins = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $check = true;
            foreach ($logins as $login) {
                if ($login["login"] == $_POST["login"]) {
                    $check = false;
                    break;
                }
            }
            if ($check) {
                $sql = "INSERT INTO users(login,email,password) VALUES(?,?,?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_POST["login"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT)]);
                if ($stmt->rowCount() > 0) {
                    echo "Move";
                }
            }
        } else {
            echo "Password doesn't match";
        }
    }

    if ($_POST["type"] == "LOGIN") {
        $sql = "SELECT * FROM users WHERE login = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["login"]]);
        $logins = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($logins) > 0) {
            echo "Move";
            $_SESSION["user_id"] = $logins[0]["id"];
        }
    }

    if ($_POST["type"] == "ADD-TO-CART") {
        $sql = "INSERT INTO cart(userId,productId) VALUES(?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION["user_id"], $_POST["productId"]]);
        if ($stmt->rowCount() > 0) {
            echo "OK";
        }
    }

    if ($_POST["type"] == "ADD-PRODUCT") {
        $sql = "INSERT INTO products(name,description,price,image) VALUES(?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["name"], $_POST["description"], $_POST["price"], $_POST["image"]]);
        if ($stmt->rowCount() > 0) {
            echo "OK";
            
        }
    }

    function update()
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN (SELECT productId FROM cart WHERE userId = ?)");
        $stmt->execute([$_POST["userId"]]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $productStr = '';
        $total = 0;
        if (count($products) > 0) {
            foreach ($products as $product) {

                $stmt2 = $pdo->prepare("SELECT * FROM cart WHERE userId = ? AND productId = ?");
                $stmt2->execute([$_POST["userId"], $product["id"]]);
                $res = $stmt2->fetchAll(PDO::FETCH_ASSOC)[0];

                $productStr .= "
                    <div class='product $product[id]'>
                        <div class='product-content'>
                            <img src=$product[image] alt=''>
                            <h2>$product[name]</h2>
                            <div class='text'>
                                <p>Qantity: <span>$res[quantity]</span></p>
                                <div class='change-quantity'>
                                    <i class='fa-solid fa-plus plus-btn'></i>
                                    <i class='fa-solid fa-minus minus-btn'></i>
                                </div>
                                <span>$<em>$product[price]</em></span>
                            </div>
                        </div>
                        <button class='btn-remove'>Remove From Cart</button>
                    </div>
                    ";
                $total += $product["price"] * $res["quantity"];
            }
            $productStr .= "
                <div class='footer'>
                    <p>Total: <span>$$total</span></p>
                    <button id='clear-btn'>Clear</button> 
                </div>
            ";
        }else {
            $productStr = 'No Products';
        }

        echo $productStr;
    }
    if ($_POST["type"] == "UPDATE-CART") {
        update();
    }

    if ($_POST["type"] == "PLUS-Q") {
        $sql = "UPDATE cart SET quantity = quantity+1 WHERE userId = ? AND productId = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["userId"], $_POST["productId"]]);
        if ($stmt->rowCount() > 0) {
            update();
        }
    }

    if ($_POST["type"] == "MINUS-Q") {
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE userId = ? AND productId = ?");
        $stmt->execute([$_POST["userId"], $_POST["productId"]]);
        $quantity = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["quantity"];
        if ($quantity > 1) {
            $sql = "UPDATE cart SET quantity = quantity-1 WHERE userId = ? AND productId = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST["userId"], $_POST["productId"]]);
        }
        update();
    }

    if ($_POST["type"] == "REMOVE-FROM-CART") {
        $sql = "DELETE FROM cart WHERE userId = ? AND productId = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["userId"], $_POST["productId"]]);
        if ($stmt->rowCount() > 0) {
            update();
        }
    }


    if ($_POST["type"] == "REFRESH-PRODUCTS") {
        $itemsPerPage = $_POST["itemsPerPage"];
        $offset = $_POST["offset"] * $itemsPerPage;
        $sql = "SELECT * FROM products";
        if(!empty($_POST["search"])) $sql.=" WHERE name LIKE '%$_POST[search]%' OR description LIKE '%$_POST[search]%'";
        if(!empty($_POST["priceSort"])){
            if($_POST["priceSort"] == "price-low") {
                $sql .= " ORDER BY price ASC";
            }else {
                $sql .= " ORDER BY price DESC";
            }
        }
        $sql .= " LIMIT $itemsPerPage OFFSET $offset";
        $products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $pr = '';
        if(count($products) > 0) {
            foreach ($products as $product) {
                $sql = "SELECT * FROM cart WHERE userId = ? AND productId = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_POST["id"], $product["id"]]);
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($res) > 0) {
                    $btn = "<button class='btn-add active' disabled>Added To Cart</button>";
                } else {
                    $btn = "<button class='btn-add'>Add To Cart</button>";
                }
                $pr .= "
                    <a id='show-pr' href='./product.php?p=$product[id]' class='product $product[id]'>
                        <div class='product-content'>
                            <img src='$product[image]' alt=''>
                            <h2>$product[name]</h2>
                            <p>$product[description]</p>
                            <span>$<em>$product[price]</em></span>
                        </div>
                        $btn
                    </a>
                ";
            }
        }else {
            $pr = '<p class="msg">No products</p>';
        }
        echo $pr;
    }

    if ($_POST["type"] == "CLEAR-CART") {
        $sql = "DELETE FROM cart WHERE userId = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["userId"]]);
    }

    if ($_POST["type"] == "SHOW-PRODUCT") {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["productId"]]);
        $product = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

        echo "
        <div class='product $product[id]'>
            <div class='product-content'>
                <img src='$product[image]' alt=''>
                <h2>$product[name]</h2>
                <p>$product[description]</p>
                <span>$<em>$product[price]</em></span>
            </div>
        </div>
        ";
    }

    if ($_POST["type"] == "UPDATE-PRODUCT") {
        $sql = "UPDATE products SET name = ?, price = ?, image = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["name"],$_POST["price"],$_POST["image"],$_POST["description"],$_POST["productId"]]);
        if($stmt->rowCount() > 0) {
            echo "OK";
        }
    }

    if ($_POST["type"] == "DELETE-PRODUCT") {
        $sql = "DELETE FROM cart WHERE productId = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["productId"]]);

        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST["productId"]]);

        if($stmt->rowCount() > 0) {
            echo "OK";
        }
    }

    if ($_POST["type"] == "PAGINATION") {
        $itemsPerPage = $_POST["itemsPerPage"];
        $sql = "SELECT COUNT(*) as pages FROM products";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["pages"];
        $res = '';
        $totalPages = ceil($items / $itemsPerPage);
        for($i = 0;$i < $totalPages;$i++) {
            $pNR = $i+1;
            $res .= "
            <a href='./index.php?p=$i'>$pNR</a>
            ";
        }
        echo $res;
       
    }
} catch (Exception $e) {
    die($e->getMessage());
}
