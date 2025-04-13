function showPassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
    x.type = "text";
    } else {
    x.type = "password";
    }
}
function showPassword2() {
    var x = document.getElementById("password");
    if (x.type === "password") {
    x.type = "text";
    } else {
    x.type = "password";
    }
}
function showPassword3() {
    var x = document.getElementById("confirm_password");
    if (x.type === "password") {
    x.type = "text";
    } else {
    x.type = "password";
    }
}

function addToCart(productId) {
    // will be completed in part 2 of project
    XMLHttpRequest = new XMLHttpRequest();
    XMLHttpRequest.open("POST", "add_to_cart.php", true);
    XMLHttpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    XMLHttpRequest.onreadystatechange = function() {
        if (XMLHttpRequest.readyState == 4 && XMLHttpRequest.status == 200) {
            alert("Product " + productId + " added to cart!");
        }
    };
    window.location.href = "cart.html";
}
function removeFromCart(productId) {
    // will be completed in part 2 of project
}