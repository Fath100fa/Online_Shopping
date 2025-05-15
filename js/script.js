// Simple direct password toggle function
document.addEventListener('DOMContentLoaded', function() {
    // Set up toggle for login/register page password field
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const password = document.getElementById('password');
            
            // Toggle password visibility
            if (password.type === 'password') {
                password.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                this.classList.add('fa-eye');
                this.classList.remove('fa-eye-slash');
            }
        });
    }
    
    // Set up toggle for confirm password field
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    if (toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener('click', function() {
            const confirmPassword = document.getElementById('confirm_password');
            
            // Toggle password visibility
            if (confirmPassword.type === 'password') {
                confirmPassword.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                confirmPassword.type = 'password';
                this.classList.add('fa-eye');
                this.classList.remove('fa-eye-slash');
            }
        });
    }
});

// Old functions kept for backward compatibility
function showPassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
    x.type = "text";
    } else {
    x.type = "password";
    }
}

function showPassword1() {
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