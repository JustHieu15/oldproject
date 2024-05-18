// Activate dropdown on hover
document
    .querySelectorAll(".nav-item.dropdown")
    .forEach(function (everydropdown) {
        everydropdown.addEventListener("mouseover", function (e) {
            let el_link = this.querySelector(".nav-link.dropdown-toggle");
            if (el_link != null) {
                let nextEl = el_link.nextElementSibling;
                el_link.classList.add("show");
                nextEl.classList.add("show");
            }
        });
        everydropdown.addEventListener("mouseout", function (e) {
            let el_link = this.querySelector(".nav-link.dropdown-toggle");
            if (el_link != null) {
                let nextEl = el_link.nextElementSibling;
                el_link.classList.remove("show");
                nextEl.classList.remove("show");
            }
        });
    });
