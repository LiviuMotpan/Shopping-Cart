const products = document.querySelector("#products");
const cartEl = document.querySelector("#cart");
const cartContainer = document.querySelector(".cart-container");
const buy = document.querySelector("#buy");
const open = document.querySelector("#open");
const close = document.querySelector("#close");
const clearBtn = document.querySelector("#clear-btn");
const body = document.querySelector("body");
const html = document.querySelector("html");
const data = [
    {
        id: 1,
        name: "IPhone 14 Pro Max",
        img: "imgs/p1.jpg",
        price: 20000
    },
    {
        id: 2,
        name: "Samsung S21",
        img: "imgs/p2.jpg",
        price: 14000
    },
    {
        id: 3,
        name: "Asus rog phone 7",
        img: "imgs/p3.png",
        price: 20000
    },
    {
        id: 4,
        name: "Xiaomi Redmi 9",
        img: "imgs/p4.jpg",
        price: 5000
    },
    {
        id: 5,
        name: "Redmagic 5G",
        img: "imgs/p5.jpg",
        price: 15000
    },
];

let cart = [];

window.addEventListener("load",(e) => {
    showProducts();
    totalCart();
    
})

open.addEventListener("click", () => cartContainer.classList.add("show"));
close.addEventListener("click", () => cartContainer.classList.remove("show"));

function showProducts() {
    data.forEach(p => {
        products.innerHTML +=
        `
            <div class="product">
                <img src=${p.img}>
                <h1>${p.name}</h1>
                <p>Price: ${p.price} MDL</p>
                <button onClick="addToCart(${p.id})">Add To Cart</button>
            </div>
        `
    })
}

clearBtn.addEventListener("click",(e) => {
    cart = [];
    total.innerHTML = "";
    updateCart();
})

function addToCart(id) {
    const prod = data.filter(p => p.id == id)[0];
    if(cart.filter(p => p.id == id).length > 0) {
        prod.qnt++;
    }else {
        prod.qnt = 1;
        cart.push(prod);
    }
    updateCart();
}

function updateCart() {
    cartEl.innerHTML = "";
    cart.forEach(p => {
        cartEl.innerHTML +=
        `
            <div class="product">
                <img src=${p.img}>
                <h1>${p.name}</h1>
                <p>Price: ${p.price} MDL</p>
                <p>Quantity: ${p.qnt} pieces</p>
                <div class="btn-container">
                <button onClick="changeQnt(${p.id},-1)">-</button>
                <button onClick="changeQnt(${p.id},1)">+</button>
                </div>
            </div>
        `
    })
    totalCart();
    cartEl.style.minHeight = `${Math.max(body.offsetHeight, 
    html.clientHeight, html.offsetHeight)}px`;
}

function changeQnt(id,val) {
    const prod = data.filter(p => p.id == id)[0];
    prod.qnt+=val;
    if(prod.qnt < 1) cart.splice(cart.indexOf(prod),1);
    updateCart();
}

function totalCart() {
    const total = cart.reduce((acc, p) => acc + (p.price * p.qnt), 0);
    buy.innerHTML = `
    <h2>Total: ${total} MDL</h2>
    <button id="buy-btn">Buy</button>
    `;
}