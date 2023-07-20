$(document).ready((e) => {

    itemsPerPage = 4;

    $("#register").on("submit", (e) => {
        e.preventDefault()
        $.ajax({
            url: "server.php",
            method: "POST",
            caches: false,
            data: {
                login: e.target.login.value,
                email: e.target.email.value,
                password: e.target.password.value,
                password2: e.target.password2.value,
                type: "REGISTER"
            },
            success: (res) => {
                if(res == "Move") {
                    window.location.href = "http://localhost/shopingCart/login.php"
                }
            },
            error: (res) => {
                console.log(res);
            }
        })
    })

    function udpateHeightCart() {
        document.querySelector(".cart").style.height = `${Math.max( document.querySelector("body").scrollHeight, document.querySelector("body").offsetHeight, 
        document.querySelector("html").clientHeight, document.querySelector("html").scrollHeight, document.querySelector("html").offsetHeight )}px`;
    }


    $("#login").on("submit", (e) => {
        e.preventDefault()
        $.ajax({
            url: "server.php",
            method: "POST",
            caches: false,
            data: {
                login: e.target.login.value,
                password: e.target.password.value,
                type: "LOGIN"
            },
            success: (res) => {
                if(res == "Move") {
                    window.location.href = "http://localhost/shopingCart/"
                }
            },
            error: (res) => {
                console.log(res);
            }
        })
    })
    function quantity() {

        $(".plus-btn").on("click", (e) => {
            e.preventDefault();
            let id = e.target.parentElement.parentElement.parentElement.parentElement.classList[1];
            $.ajax({
                url: "server.php",
                method: "POST",
                caches: false,
                data: {
                    productId:  id,
                    userId: document.querySelector("#userId").value,
                    type: "PLUS-Q"
                },
                success: (res) => {
                    $(".products-cart").html(res);
                    removeFromCart();
                    clearCart();
                    quantity()
                },
                error: (res) => {
                    console.log(res);
                }
            }) 
        })

        $(".minus-btn").on("click", (e) => {
            e.preventDefault();
            let id = e.target.parentElement.parentElement.parentElement.parentElement.classList[1];
                $.ajax({
                    url: "server.php",
                    method: "POST",
                    caches: false,
                    data: {
                        productId:  id,
                        userId: document.querySelector("#userId").value,
                        type: "MINUS-Q"
                    },
                    success: (res) => {
                        $(".products-cart").html(res);
                        removeFromCart();
                        clearCart();
                        quantity()
                    },
                    error: (res) => {
                        console.log(res);
                    }
                }) 
            
        })
    }

    function addToCart() {
        $(".btn-add").on("click", (e) => {
            e.preventDefault();
            let id = e.target.parentElement.classList[1];
            $.ajax({
                url: "server.php",
                method: "POST",
                caches: false,
                data: {
                    productId: id,
                    type: "ADD-TO-CART"
                },
                success: (res) => {
                    updateProducts();
                    updateCart();
                },
                error: (res) => {
                    console.log(res);
                }
            })
        })
    }
    
    $("#add-product").on("click", (e) => {
        window.location.href = "http://localhost/shopingCart/add.php";
    })
    
    $("#add-pr").on("submit", (e) => {
        e.preventDefault();
        $.ajax({
            url: "server.php",
            method: "POST",
            caches: false,
            data: {
                name: e.target.name.value,
                description: e.target.description.value,
                price: e.target.price.value,
                image: e.target.image.value,
                type: "ADD-PRODUCT"
            },
            success: (res) => {
                console.log(res);
                window.location.href = "http://localhost/shopingCart/index.php";
                udpateHeightCart();
            },
            error: (res) => {
                console.log(res);
            }
        })
    })

    function removeFromCart() {
        $(".btn-remove").on("click", (e) => {
            e.preventDefault();
            $.ajax({
                url: "server.php",
                method: "POST",
                caches: false,
                data: {
                    productId: e.target.parentElement.classList[1],
                    userId: document.querySelector("#userId").value,
                    type: "REMOVE-FROM-CART"
                },
                success: (res) => {
                    console.log(res);
                    $(".products-cart").html(res);
                    removeFromCart();
                    quantity();
                    clearCart();
                    updateProducts();
                },
                error: (res) => {
                    console.log(res);
                }
            })
        })
    }


    function updateCart() {
        $.ajax({
            url: "server.php",
            method: "POST",
            caches: false,
            data: {
                userId: document.querySelector("#userId").value,
                type: "UPDATE-CART"
            },
            success: (res) => {
                $(".products-cart").html(res);
                removeFromCart();
                quantity();
                clearCart();
            },
            error: (res) => {
                console.log(res);
            }
        })
    }

    function updateProducts(search = "",priceSort = "") {
        $.ajax({
            url: "server.php",
            caches: false,
            method: "POST",
            data: {
                offset: document.querySelector("#page").value,
                itemsPerPage: itemsPerPage,
                search: search,
                priceSort: priceSort,
                id:  document.querySelector("#userId").value,
                type: "REFRESH-PRODUCTS"
            },
            success: (res) => {
                $(".products").html(res);
                addToCart();
                
            },
            error: (res) => {
                console.log(res);
            }
        })
    }

    function clearCart() {
        $("#clear-btn").on("click", (e) => {
            e.preventDefault();
            $.ajax({
                url: "server.php",
                method: "POST",
                caches: false,
                data: {
                    userId:  document.querySelector("#userId").value,
                    type: "CLEAR-CART"
                },
                success: (res) => {
                    console.log(res);
                    removeFromCart();
                    quantity();
                    clearCart();
                    updateCart();
                    updateProducts();
                },
                error: (res) => {
                    console.log(res);
                }
            })
        })
    }

    function makePagination() {
        $.ajax({
            url: "server.php",
            method: "POST",
            caches: false,
            data: {
                itemsPerPage: itemsPerPage,
                type: "PAGINATION"
            },
            success: (res) => {
                $(".pages").html(res)
            },
            error: (res) => {
                console.log(res);
            }
        })
    }
    makePagination();

    document.querySelector("#search").addEventListener("change", (e) => {
        updateProducts(e.target.value,document.querySelector("#price-sort").value);
    })

    document.querySelector("#price-sort").addEventListener("change", (e) => {
        updateProducts(document.querySelector("#search").value,e.target.value);
    })

    updateCart()
    updateProducts();
})

