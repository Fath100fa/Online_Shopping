function showPassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
    x.type = "text";
    } else {
    x.type = "password";
    }
    const slash= document.querySelector("#togglePassword");
    // console.log(slash);
    slash.classList.toggle("fa-eye-slash");
    slash.classList.toggle("fa-eye");
    
}

function showPassword1() {
    var x = document.getElementById("confirm_password");
    if (x.type === "password") {
    x.type = "text";
    } else {
    x.type = "password";
    }
    const slash= document.querySelector("#toggleConfirmPassword");
    // console.log(slash);
    slash.classList.toggle("fa-eye-slash");
    slash.classList.toggle("fa-eye");
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
    window.location.href = "cart.php";
}
function removeFromCart(productId) {
    // will be completed in part 2 of project
}

const stars = document.querySelectorAll("#rating span");
    stars.forEach((star) => {
      star.addEventListener("click", () => {
        stars.forEach(s => s.classList.remove("selected"));
        for (let i = 0; i < star.dataset.value; i++) {
          stars[i].classList.add("selected");
        }
        alert("You rated this laptop: " + star.dataset.value + " stars");
      });
    });


    //Added by nassar
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search');
        const products = document.querySelectorAll('.product');
    
        searchInput.addEventListener('input', (e) => {
            const value = e.target.value.toLowerCase();
    
            products.forEach(product => {
                const productName = product.querySelector('h3').textContent.toLowerCase();
                if (productName.includes(value)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });
    //ends here