$(document).ready((e) => {
    let productId;
    function showProduct() {
        if(document.querySelector("#show-prodct") != null){
            productId = document.querySelector("#productId").value;
            $.ajax({
                url: "server.php",
                method: "POST",
                caches: false,
                data: {
                    productId: productId,
                    type: "SHOW-PRODUCT"
                },
                success: (res) => {
                    $(".product-show").html(res);
                },
                error: (res) => {
                    console.log(res);
                }
            }) 
        }
    }

    showProduct();

    $("#update").on("click", (e) => {
        window.location.href = `http://localhost/shopingCart/edit.php?p=${productId}`;
    })  

    $("#delete-form").on("submit", (e) => {
        e.preventDefault();
        $.ajax({
            url: "server.php",
            method: "POST",
            caches: false,
            data: {
                productId: e.target.product.value,
                type: "DELETE-PRODUCT"
            },
            success: (res) => {
                console.log(res);
                window.location.href = `http://localhost/shopingCart/index.php`;
            },
            error: (res) => {
                console.log("error");
            }
        })  
    })     

    $("#edit-form").on("submit", (e) => {
        e.preventDefault();
        $.ajax({
            url: "server.php",
            method: "POST",
            caches: false,
            data: {
                name: e.target.name.value,
                description: e.target.description.value,
                image: e.target.image.value,
                price: e.target.price.value,
                productId: e.target.product.value,
                type: "UPDATE-PRODUCT"
            },
            success: (res) => {
                console.log(res);
                window.location.href = `http://localhost/shopingCart/product.php?p=${e.target.product.value}`;
                showProduct();
            },
            error: (res) => {
                console.log("error");
            }
        })  
    })
})