addEvent("#login-form", "submit", (e) => {
  e.preventDefault();
  disabled("#login-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_login.php", () => {}, 
  new FormData(e.target), "auth", "#login-btn");
})

addEvent("#save-category-form", "submit", (e) => {
  e.preventDefault();
  disabled("#save-category-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_category_save.php", () => {
    e.target.reset();
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, new FormData(e.target), "create", "#save-category-btn");
})

addEvent(".update-category", "click", (e) => {
  e.preventDefault();
  disabled(".update-category", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_category_fetch.php", (data) => {
    const updateCategoryForm = document.querySelector("#update-category-form");
    const updateCategoryBtn = document.querySelector("#update-category-btn");
    const saveCategoryForm = document.querySelector("#save-category-form");
    const categoryInput = document.querySelector("#category-input");

    updateCategoryForm.classList.remove("hidden");
    saveCategoryForm.classList.add("hidden");
    updateCategoryBtn.setAttribute("data-id", e.target.dataset.id);
    categoryInput.value = data;
  }, "category_id=" + e.target.dataset.id, "fetch", ".update-category", 
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

addEvent("#update-category-form", "submit", (e) => {
  const updateBtn = document.querySelector("#update-category-btn");
  e.preventDefault();
  disabled("#update-category-btn", "disabled");
  let formData = new FormData(e.target);
  formData.append("category_id", updateBtn.dataset.id);

  request(SYSTEM_URL + "app/Jobs/process_category_update.php", () => {
    e.target.reset();
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, formData, "update", "#update-category-btn");
})

addEvent("#save-menu-form", "submit", (e) => {
  e.preventDefault();
  disabled("#save-menu-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_menu_save.php", () => {
    e.target.reset();
    resetUpload(e.target);
  }, new FormData(e.target), "create", "#save-menu-btn");
})

addEvent("#update-menu-form", "submit", (e) => {
  e.preventDefault();
  disabled("#update-menu-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_menu_update.php", () => {
  }, new FormData(e.target), "update", "#update-menu-btn");
})

addEvent("#save-inventory-form", "submit", (e) => {
  e.preventDefault();
  disabled("#save-inventory-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_inventory_save.php", () => {
    e.target.reset();
  }, new FormData(e.target), "create", "#save-inventory-btn");
})

addEvent("#update-inventory-form", "submit", (e) => {
  e.preventDefault();
  disabled("#update-inventory-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_inventory_update.php", () => {}, 
  new FormData(e.target), "create", "#update-inventory-btn");
})

addEvent("#create-account-form", "submit", (e) => {
  e.preventDefault();
  disabled("#create-account-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_create.php", () => {
    e.target.reset();
    resetUpload(e.target);
  }, new FormData(e.target), "create", "#create-account-btn");
})

addEvent("#update-account-form", "submit", (e) => {
  e.preventDefault();
  disabled("#update-account-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_update.php", () => {}, 
  new FormData(e.target), "create", "#update-account-btn");
})

addEvent(".deactivate-btn", "click", (e) => {
  e.preventDefault();
  disabled(".deactivate-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_status_update.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "account_id=" + e.target.dataset.id, "update", ".deactivate-btn", 
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

addEvent(".activate-btn", "click", (e) => {
  e.preventDefault();
  disabled(".activate-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_status_update.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "account_id=" + e.target.dataset.id, "update", ".activate-btn", 
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

addEvent("#account-security-form", "submit", (e) => {
  e.preventDefault();
  disabled("#account-security-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_password_change.php", () => {
    e.target.reset();
  }, 
  new FormData(e.target), "update", "#account-security-btn");
})

const menuCards = document.querySelectorAll(".menu-card");

if(menuCards.length){
  menuCards.forEach(menuCard => {
    let size = "";
    const sizeOptions = menuCard.querySelectorAll(".size-option");
    const buyBtns = menuCard.querySelectorAll(".buy-btn");
    
    sizeOptions.forEach(sizeOption => {
      sizeOption.addEventListener("click", ({ target }) => {
        sizeOptions.forEach(option => option.classList.remove("active"));
        target.classList.add("active");
        size = target.dataset.id;
      })
    })

    buyBtns.forEach(buyBtn => {
      buyBtn.addEventListener("click", ({ target }) => {
        const data = sizeOptions.length ? "menu_id=" + target.dataset.id + "&size_id=" + size : "menu_id=" + target.dataset.id

        request(SYSTEM_URL + "app/Jobs/process_cart_item_add.php", () => {
          setTimeout(() => {
            location.reload();
          }, 1300);
        }, data, "create", null, 
        { "Content-Type": "application/x-www-form-urlencoded" });
      })
    })
  })
}

addEvent(".minus-btn", "click", (e) => {
  disabled(".minus-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_cart_item_quantity_update.php", () => {
    location.reload();
  }, "cart_id=" + e.target.dataset.id + "&type=minus", "fetch", ".minus-btn", 
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

addEvent(".add-btn", "click", (e) => {
  disabled(".add-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_cart_item_quantity_update.php", () => {
    location.reload();
  }, "cart_id=" + e.target.dataset.id + "&type=add", "fetch", ".add-btn", 
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

addEvent("#checkout-btn", "click", () => {
  const discountSelect = document.querySelector("#discount-select");
  const cashInput = document.querySelector("#cash-input");
  disabled("#checkout-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_order_create.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "discount=" + discountSelect.value + "&cash=" + cashInput.value.trim(), "create", "#checkout-btn", 
  { "Content-Type": "application/x-www-form-urlencoded" });
})

const summary = document.querySelector(".summary-container");

if(summary !== null){
  setInterval(() => {
    fetch(SYSTEM_URL + "app/Jobs/process_realtime_order_fetch.php")
    .then(res => res.text())
    .then(data => {
      summary.innerHTML = data;
    })
  }, 100);
}