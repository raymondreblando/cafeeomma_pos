// showLoader();

// window.addEventListener('load', () => {
//   hideLoader();
// })

addEvent(".show-password", "click", (e) => {
  const parent = e.target.parentElement;
  const input = parent.querySelector("input");

  if(input.type === "password"){
    input.type = "text";
    e.target.classList.remove("ri-eye-line");
    e.target.classList.add("ri-eye-off-line");
  } else{
    input.type = "password";
    e.target.classList.remove("ri-eye-off-line");
    e.target.classList.add("ri-eye-line");
  }
}, "all")

addEvent("body", "click", () => {
  if(!isNull(".notification")) {
    animated(".notification", {
      opacity: "0%",
      visibility: "hidden"
    }, {
      duration: 100,
      easing: "ease-in",
      fill: "forwards"
    })
  }
})

addEvent(".show-sidebar", "click", () => {
  animated(".sidebar", {
    left: "0",
    opacity: "100%",
    visibility: "visible"
  }, {
    duration: 200,
    easing: "ease-in",
    fill: "forwards"
  })
})

addEvent(".close-sidebar", "click", () => {
  animated(".sidebar", {
    left: "-50%",
    opacity: "0%",
    visibility: "hidden"
  }, {
    duration: 200,
    easing: "ease-in",
    fill: "forwards"
  })
})

addEvent(".filter-box", "click", ({ target }) => {
  dynamicStyling(".filter-box", "active", "remove");
  target.classList.add("active");
  search(target.dataset.id, "table");
}, "all")

addEvent(".show-notification", "click", (e) => {
  e.stopPropagation();
  animated(".notification", {
    opacity: "100%",
    visibility: "visible"
  }, {
    duration: 100,
    easing: "ease-in",
    fill: "forwards"
  })

  request(SYSTEM_URL + "app/Jobs/process_notification_status_update.php", () => {}, 
  null, "fetch");
})

addEvent(".notification", "click", (e) => {
  e.stopPropagation();
})

addEvent(".notification", "click", (e) => {
  e.stopPropagation();
})

addEvent(".minus-btn", "click", (e) => {
  const parent = e.target.parentElement;
  const count = parent.querySelector(".count");
  let quantity = parseInt(count.textContent.trim()) <= 1 ? 1 : parseInt(count.textContent.trim()) - 1;
  count.textContent = quantity;
}, "all")

addEvent(".add-btn", "click", (e) => {
  const parent = e.target.parentElement;
  const count = parent.querySelector(".count");
  let quantity = parseInt(count.textContent.trim()) + 1;
  count.textContent = quantity;
}, "all")

addEvent(".show-order", "click", () => {
  animated(".orders-wrapper", {
    opacity: "100%",
    visibility: "visible"
  }, {
    duration: 100,
    easing: "ease-in",
    fill: "forwards"
  })
})

addEvent(".close-order", "click", () => {
  animated(".orders-wrapper", {
    opacity: "0%",
    visibility: "hidden"
  }, {
    duration: 100,
    easing: "ease-in",
    fill: "forwards"
  })
})

addEvent(".upload-container", "click", ({ target }) => {
  const upload = target.querySelector("input");
  upload.click();
}, "all")

addEvent(".upload-input", "change", (e) => {
  previewUpload(e);
}, "all")

addEvent(".add-size-btn", "click", () => {
  const sizeWrapper = document.querySelector(".size-wrapper");
  sizeWrapper.insertAdjacentHTML("beforeend", `
    <div class="flex items-center gap-3 mb-3">
      <div class="w-full flex items-center h-10 bg-light-gray rounded-full px-6">
        <input type="text" name="size[]" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter size">
      </div>
      <div class="w-full flex items-center h-10 bg-light-gray rounded-full px-6">
        <input type="text" name="size_price[]" class="w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent" placeholder="Enter size price">
      </div>
      <button type="button" class="delete-btn shrink-0 grid place-items-center bg-light-gray w-10 h-10 rounded-full" title="Remove">
        <img src="${SYSTEM_URL}public/icons/minus-cirlce-linear.svg" alt="remove" class="w-4 h-4 pointer-events-none">
      </button>
    </div>
  `);

  addEvent(".delete-btn", "click", (e) => {
    const parent = e.target.parentElement;
    parent.remove();
  }, "all")
})

addEvent("#search-input", "keyup", ({ target }) => {
  search(target.value, "table");
})

addEvent(".filter-select", "change", ({ target }) => {
  search(target.value, "table");
})

addEvent("#discount-select", "change", ({ target }) => {
  const cashTxt = document.querySelector("#cash");
  const changeTxt = document.querySelector("#change");
  const discountTxt = document.querySelector("#discount");
  const totalAmount = document.querySelector("#total-amount");
  const totalAmountValue = parseFloat(totalAmount.dataset.id);
  const highPriceOrderAmount = document.querySelector("#highest-amount");
  const highPriceOrderValue = parseFloat(highPriceOrderAmount.dataset.id);

  let discount = (highPriceOrderValue * parseFloat(target.value)).toFixed(2);
  let finalValue = (totalAmountValue - discount).toFixed(2);

  totalAmount.textContent = `P${finalValue}`;
  totalAmount.dataset.value = finalValue;
  discountTxt.textContent = `P${discount}`;

  if(parseInt(cashTxt.dataset.id) > 0){
    let cashValue = parseInt(cashTxt.dataset.id);
    let changeValue = (cashValue - finalValue).toFixed(2);
    changeTxt.textContent = `P${changeValue}`;
  }

  let formData = new FormData();
  formData.append("amount", finalValue);
  formData.append("discount", target.value);
  formData.append("cash", parseInt(cashTxt.dataset.id) > 0 ? parseInt(cashTxt.dataset.id) : 0);

  request(SYSTEM_URL + "app/Jobs/process_cart_summary.php", () => { }, 
  formData, "fetch");
})

addEvent("#cash-input", "keyup", ({ target }) => {
  const discountSelect = document.querySelector("#discount-select");
  const cashTxt = document.querySelector("#cash");
  const changeTxt = document.querySelector("#change");
  const totalAmount = document.querySelector("#total-amount");
  const totalAmountValue = totalAmount.dataset.value === undefined ? parseFloat(totalAmount.dataset.id) : parseFloat(totalAmount.dataset.value);

  let changeValue = (parseInt(target.value) - totalAmountValue).toFixed(2);

  cashTxt.textContent = target.value === "" ? `P0` : `P${target.value}`;
  cashTxt.dataset.id = target.value;
  changeTxt.textContent = target.value === "" ? `P0` : `P${changeValue}`;

  let formData = new FormData();
  formData.append("amount", totalAmountValue);
  formData.append("discount", discountSelect.value);
  formData.append("cash", parseInt(cashTxt.dataset.id) > 0 ? parseInt(cashTxt.dataset.id) : 0);

  request(SYSTEM_URL + "app/Jobs/process_cart_summary.php", () => { }, 
  formData, "fetch");
})

addEvent("#checkout-btn", "click", () => {
  dynamicStyling(".dialog", "hidden", "remove");
})

addEvent(".close-dialog-btn", "click", () => {
  dynamicStyling(".dialog", "hidden", "add");
})

addEvent("#start-date-filter", "change", ({ target }) => {
  const endDateInput = document.querySelector("#end-date-filter");

  if(endDateInput.value !== null && endDateInput.value !== ''){
    const startDate = new Date(target.value);
    const endDate = new Date(endDateInput.value);
    dateSearch(startDate, endDate, 'table');
    return
  } 
    
  search(target.value, 'table');
})

addEvent("#end-date-filter", "change", ({ target }) => {
  const startDateInput = document.querySelector("#start-date-filter");

  if(startDateInput.value === null || startDateInput.value === ''){
    startDateInput.value = null;
    toast('Select a start date', 'error');
    return;
  }

  const startDate = new Date(startDateInput.value);
  const endDate = new Date(target.value);
  dateSearch(startDate, endDate, 'table');
})

addEvent(".inv_tabs", "click", ({ target }) => {
  dynamicStyling(".inv_tabs", "active", "remove");
  target.classList.add("active");
  const txtContent = target.textContent.trim();
  const noIngredientForm = document.querySelector("#save-inventory-form");
  const withIngredientForm = document.querySelector("#save-inventorywing-form");

  if(txtContent === "No Ingredients"){
    noIngredientForm.classList.remove('hidden');
    withIngredientForm.classList.add('hidden');
  } else {
    withIngredientForm.classList.remove('hidden');
    noIngredientForm.classList.add('hidden');
  }
}, 'all')

addEvent(".add-ingredient", "click", () => {
  const ingredientWrapper = document.querySelector(".ingredient-wrapper");
  const ingredientSelect = document.querySelector(".ingredient-select");
  ingredientWrapper.appendChild(ingredientSelect.cloneNode(true));
})