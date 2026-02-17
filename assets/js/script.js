

// Image Slideshow


 let slideIndex = 1;
 let autoTimer;
 
 let slides = document.getElementsByClassName("mySlides");
 let dots = document.getElementsByClassName("dot");
 
 // ✅ STOP if slider does not exist on page
 if (slides.length > 0) {
   showSlides(slideIndex);
   startAutoSlide();
 }
 
 function plusSlides(n) {
   if (slides.length === 0) return;
   showSlides(slideIndex += n);
   restartAuto();
 }
 
 function showSlides(n) {
   if (slides.length === 0) return;
 
   let i;
 
   if (n > slides.length) slideIndex = 1;
   if (n < 1) slideIndex = slides.length;
 
   for (i = 0; i < slides.length; i++) {
     slides[i].style.display = "none";
   }
 
   for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" active", "");
   }
 
   slides[slideIndex - 1].style.display = "block";
 
   if (dots[slideIndex - 1]) {
     dots[slideIndex - 1].className += " active";
   }
 }
 
 function startAutoSlide() {
   autoTimer = setInterval(() => {
     plusSlides(1);
   }, 1600);
 }
 
 function restartAuto() {
   clearInterval(autoTimer);
   startAutoSlide();
 }

// Registration Form Validation

const registerForm = document.querySelector(".register-form");

if (registerForm) {
  registerForm.addEventListener("submit", function (e) {
    const password = this.querySelector('input[name="password"]').value;
    const confirm = this.querySelector('input[name="confirm_password"]').value;
    const email = this.querySelector('input[name="email"]').value;

    let errorBox = this.querySelector(".error-box");

    if (!errorBox) {
      errorBox = document.createElement("div");
      errorBox.className = "alert alert-danger error-box";
      this.prepend(errorBox);
    }

    if (password !== confirm) {
      e.preventDefault();
      errorBox.innerText = "Passwords do not match";
      errorBox.style.display = "block";
      return;
    }

    if (!email.includes("@")) {
      e.preventDefault();
      errorBox.innerText = "Invalid email address";
      errorBox.style.display = "block";
    }
  });
}




// Home-Cateories js

document.addEventListener("DOMContentLoaded", () => {



  const dropdowns = document.querySelectorAll(".has-dropdown");

  dropdowns.forEach(dropdown => {
    const trigger = dropdown.querySelector(".category-open");
    const arrow = dropdown.querySelector(".arrow");
    const menuItems = dropdown.querySelectorAll(".menu-item");


    // CLICK → PIN MENU
    [trigger, arrow].forEach(el => {
      el.addEventListener("click", (e) => {
        e.stopPropagation();

        // close others
        dropdowns.forEach(d => {
          if (d !== dropdown) {
            d.classList.remove("active", "pinned");
          }
        });

        dropdown.classList.toggle("active");
        dropdown.classList.toggle("pinned");
      });
    });

    // HOVER OUT → CLOSE ONLY IF NOT PINNED
    dropdown.addEventListener("mouseleave", () => {
      if (!dropdown.classList.contains("pinned")) {
        dropdown.classList.remove("active");
      }
    });

    dropdown.addEventListener("mouseenter", () => {
      dropdown.classList.add("active");
    });

    // LEFT MENU → RIGHT SUBMENU
    menuItems.forEach(item => {
      item.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();

        const target = item.dataset.target;

        dropdown.querySelectorAll(".menu-item")
          .forEach(i => i.classList.remove("active"));
        dropdown.querySelectorAll(".submenu")
          .forEach(s => s.classList.remove("active"));

        item.classList.add("active");
        dropdown.querySelector("#" + target)?.classList.add("active");
      });
    });
  });

  // CLICK OUTSIDE → CLOSE PINNED
  document.addEventListener("click", () => {
    dropdowns.forEach(d => d.classList.remove("active", "pinned"));
  });

});


// Deals Row Scroll JS

const row = document.querySelector('.deals-row');
const arrowRight = document.querySelector('.arrow.right');
const arrowLeft = document.querySelector('.arrow.left');

if (row && arrowRight && arrowLeft) {
  arrowRight.onclick = () => {
    row.scrollLeft += 300;
  };

  arrowLeft.onclick = () => {
    row.scrollLeft -= 300;
  };
}


// Quantity button Cart JS
    document.querySelectorAll('.qty-btn') .forEach (btn => {
        btn.addEventListener("click", () =>{
            // const productId = btn.dataset.id;
            // const action = btn.dataset.action;
            fetch('update-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    product_id: btn.dataset.id,
                    action: btn.dataset.action
                })
            })
            .then(res => res.json())
            .then(data => {
              
                if (!data.success) return;

                if (data.removed) {
                    document.getElementById("cart-item-" + btn.dataset.id)?.remove();
                } else{
                    document.getElementById("qty-" + btn.dataset.id).innerText = "Qty: " + data.quantity;
                }          
                 document.getElementById("cart-subtotal").innerText = "₹" + data.subtotal;  
                document.getElementById("cart-shipping").innerText = "₹" + data.shipping;       
                 document.getElementById("cart-total").innerText = "₹" + data.grandTotal;
                 
            });
        });
    });

  // Wishlist JS
        document.querySelectorAll('.wishlist-btn').forEach(btn=> {
        btn.addEventListener('click', () => {
            const productId = btn.dataset.productId;

            fetch('wishlist-toggle.php', {
                method : 'POST',
                headers: {'Content-Type': 'application/json'},
                body : JSON.stringify({product_id : productId})
            })

            .then(res => res.json())
            .then(data =>{
                if(data.login_required){
                    document.getElementById("loginSection").style.display = "block";
                    window.scrollTo({ top: 0, behavior: "smooth" });
                    return;
                }
                const icon = btn.querySelector('i');
                
                
                if(data.added) {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid', 'text-danger');
                } else {
                    icon.classList.remove('fa-solid', 'text-danger');
                    icon.classList.add('fa-regular');
                }
            })
              .catch(err => console.error(err));
        })
    })



