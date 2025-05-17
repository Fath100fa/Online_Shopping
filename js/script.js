function showPassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
    x.type = "text";
    } else {
    x.type = "password";
    }
    const slash= document.querySelector("#togglePassword");
    slash.classList.toggle("fa-eye-slash");
    slash.classList.toggle("fa-eye");
    
}

function showPassword1() {
    var y = document.getElementById("confirm_password");
    if (y.type === "password") {
    y.type = "text";
    } else {
    y.type = "password";
    }
    const slash= document.querySelector("#toggleConfirmPassword");
   
    slash.classList.toggle("fa-eye-slash");
    slash.classList.toggle("fa-eye");
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