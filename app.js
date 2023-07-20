const openCart = document.querySelector("#open-cart");
const closeCart = document.querySelector("#close-cart");
const cart = document.querySelector(".cart");

openCart.addEventListener("click", (e) => {
    e.preventDefault();
    cart.classList.add("show");
})

closeCart.addEventListener("click", (e) => {
    e.preventDefault();
    cart.classList.remove("show");
})


setTimeout(()=> {
    cart.style.height = `${Math.max( document.querySelector("body").scrollHeight, document.querySelector("body").offsetHeight, 
    document.querySelector("html").clientHeight, document.querySelector("html").scrollHeight, document.querySelector("html").offsetHeight )}px`;
},1000);