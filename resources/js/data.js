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

addEvent("#confirm-delete-category", "click", (e) => {
  disabled("#confirm-delete-category", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_category_status_update.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "category_id=" + e.target.dataset.id, "update", null,
  { "Content-Type": "application/x-www-form-urlencoded" });
})

addEvent(".undo-category", "click", (e) => {
  disabled(".undo-category", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_category_status_update.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "category_id=" + e.target.dataset.id, "update", null,
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

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

addEvent("#confirm-delete-menu", "click", (e) => {
  disabled("#confirm-delete-menu", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_menu_status_update.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "menu_id=" + e.target.dataset.id, "update", null,
  { "Content-Type": "application/x-www-form-urlencoded" });
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

addEvent("#save-inventorywing-form", "submit", (e) => {
  e.preventDefault();
  disabled("#save-inventorywing-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_inventory_wingredients_save.php", () => {
    e.target.reset();
  }, new FormData(e.target), "create", "#save-inventorywing-btn");
})

addEvent("#update-inventorywing-form", "submit", (e) => {
  e.preventDefault();
  disabled("#update-inventorywing-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_inventory_wingredients_update.php", () => {}, 
  new FormData(e.target), "create", "#update-inventorywing-btn");
})

addEvent("#save-ingredient-form", "submit", (e) => {
  e.preventDefault();
  disabled("#save-ingredient-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_ingredient_save.php", () => {
    e.target.reset();
  }, new FormData(e.target), "create", "#save-ingredient-btn");
})

addEvent("#update-ingredient-form", "submit", (e) => {
  e.preventDefault();
  disabled("#update-ingredient-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_ingredient_update.php", () => {}, 
  new FormData(e.target), "create", "#update-ingredient-btn");
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

addEvent("#confirm-deactivate-account", "click", (e) => {
  e.preventDefault();
  disabled("#confirm-activate-account", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_status_update.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "account_id=" + e.target.dataset.id, "update", "#confirm-activate-account", 
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

addEvent("#confirm-activate-account", "click", (e) => {
  e.preventDefault();
  disabled("#confirm-activate-account", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_status_update.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "account_id=" + e.target.dataset.id, "update", "#confirm-activate-account", 
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

addEvent("#confirm-delete-account", "click", (e) => {
  e.preventDefault();
  disabled("#confirm-delete-account", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_account_delete.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "account_id=" + e.target.dataset.id, "update", "#confirm-delete-account", 
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

// addEvent(".minus-btn", "click", (e) => {
//   disabled(".minus-btn", "disabled");

//   request(SYSTEM_URL + "app/Jobs/process_cart_item_quantity_update.php", () => {
//     location.reload();
//   }, "cart_id=" + e.target.dataset.id + "&type=minus", "fetch", ".minus-btn", 
//   { "Content-Type": "application/x-www-form-urlencoded" });
// }, "all")

// addEvent(".add-btn", "click", (e) => {
//   disabled(".add-btn", "disabled");

//   request(SYSTEM_URL + "app/Jobs/process_cart_item_quantity_update.php", () => {
//     location.reload();
//   }, "cart_id=" + e.target.dataset.id + "&type=add", "fetch", ".add-btn", 
//   { "Content-Type": "application/x-www-form-urlencoded" });
// }, "all")

addEvent(".quantity-input", "change", (e) => {
  quantity = e.target.value === "" ? 0 : e.target.value;
  request(SYSTEM_URL + "app/Jobs/process_cart_item_quantity_update.php", () => {
    location.reload();
  }, "cart_id=" + e.target.dataset.id + "&quantity=" + quantity, "fetch", null, 
  { "Content-Type": "application/x-www-form-urlencoded" });
}, "all")

addEvent("#confirm-checkout-btn", "click", () => {
  const discountSelect = document.querySelector("#discount-select");
  const cashInput = document.querySelector("#cash-input");
  disabled("#confirm-checkout-btn", "disabled");

  request(SYSTEM_URL + "app/Jobs/process_order_create.php", () => {
    setTimeout(() => {
      location.reload();
    }, 1300);
  }, "discount=" + discountSelect.value + "&cash=" + cashInput.value.trim(), "create", "#confirm-checkout-btn", 
  { "Content-Type": "application/x-www-form-urlencoded" });
})

addEvent("#menu-select", "change", ({ target }) => {
  request(SYSTEM_URL + "app/Jobs/process_fetching_menu_sizes.php", (data) => {
    const sizeWrapper = document.querySelector(".menu-sizes-wrapper");
    sizeWrapper.innerHTML = "";

    const parseData = JSON.parse(data);

    for (const content of parseData) {
      appendSizes('.menu-sizes-wrapper', content.size);
    }
  }, "menu_id=" + target.value, "fetch", null, 
  { "Content-Type": "application/x-www-form-urlencoded" });
})

addEvent(".sales-row", "click", ({ currentTarget }) => {
  const ordersWrapper = document.querySelector(".order-item-wrapper");

  fetch(SYSTEM_URL + "app/Jobs/process_order_item_fetch.php", {
    method: "POST",
    body: "order_id=" + currentTarget.dataset.id,
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    }
  })
  .then(res => res.json())
  .then(data => {
    ordersWrapper.innerHTML = "";
    orderItemTemplate(data);
    dynamicStyling(".dialog", "hidden", "remove");
  });
}, 'all')

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