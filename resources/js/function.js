const SYSTEM_URL = "http://localhost/projects/cafe_eomma_pos/";

function isNull(elem){
  const element = document.querySelectorAll(elem);
  return element.length === 0 ? true : false;
}

function addEvent(element, type, callback, selector = "single"){
  const target = 
  selector === "all" ? 
  document.querySelectorAll(element) : 
  document.querySelector(element);

  if(target === null || target.length == 0) return

  if(selector === "single"){
    target.addEventListener(type, callback);
    return
  }
  
  target.forEach(el => {
    el.addEventListener(type, callback);
  })
}

function showLoader(){
  const loader = document.querySelector('.loader');
  loader.classList.add('show');
}

function hideLoader(){
  const loader = document.querySelector('.loader');
  loader.classList.remove('show');
}

function toast(message, type){
  const toast = document.querySelector('.toast');
  const icon = document.querySelector('.toast-icon');
  const content = document.querySelector('.toast-message');

  toast.classList.add('transition-all');
  toast.classList.add(type);

  icon.src = type === "success"
    ? SYSTEM_URL + "/public/icons/tick-white.svg"
    : SYSTEM_URL + "/public/icons/info-circle-bold.svg";
  icon.alt = type;

  content.textContent = message;

  setTimeout(() => {
    toast.classList.remove(type);
  }, 2500);
}

function dynamicStyling(elem, style, type = "add"){
  const element = document.querySelectorAll(elem);

  element.forEach(el => {
    type === "remove" ? el.classList.remove(style) : el.classList.add(style);
  })
}

function setValue(element, value, type = "set"){
  const parent = element.parentElement.parentElement;
  const target = parent.querySelector("input");
  const selected = parent.querySelector(".current-selected");

  if(type === "remove"){
    selected.textContent = value;
    target.value = "";
  }

  selected.textContent = value;
  target.value = element.dataset.id;
}

function togglePassword(event, element){
  element.forEach(el => {
    const icon = event.querySelector("img");

    if(el.type === "password"){
      el.type = "text";
      icon.src = SYSTEM_URL + 'public/icons/hide.svg';
    } else{
      el.type = "password";
      icon.src = SYSTEM_URL + 'public/icons/show.svg';
    }
  })
}

function modal(target, isVisible){
  const element = document.querySelector(target);

  const keyframes = { visibility: "visible", opacity: "100%" } 

  if(!isVisible){
    location.reload();
    return
  }
  
  animated(element, keyframes, {
    duration: 300,
    easing: "ease-in-out",
    fill: "forwards"
  });
}

function previewUpload(e){
  const accepted = ["image/jpeg", "image/png"];
  
  if(!accepted.includes(e.target.files[0].type)){
    toast("Invalid image extension", "error");
    return
  }

  const parent = e.target.parentElement;
  const image = parent.querySelector(".upload-overview");
  const icon = parent.querySelector(".icon");

  const fileReader = new FileReader();

  fileReader.onload = (e) => {
    icon.classList.add("hidden");
    image.removeAttribute("hidden");
    image.src = e.target.result;
  }

  fileReader.readAsDataURL(e.target.files[0]);
}

function resetUpload(form){
  const image = form.querySelector(".upload-overview");
  const icon = form.querySelector(".icon");

  icon.classList.remove("hidden");
  image.setAttribute("hidden", "");
  image.src = "";
}

function animated(element, keyframes, options){
  const el = document.querySelector(element);
  el.animate(keyframes, options);
}

function disabled(elem, type){
  const btn = document.querySelector(elem);
  if(btn === null) return;
  type === "enabled" ? btn.removeAttribute('disabled')  : btn.setAttribute('disabled', '');
}

function resetSelect(form, values){
  const titles = form.querySelectorAll(".current-selected");
  const options = form.querySelectorAll(".custom-select__options");

  titles.forEach((title, index) => title.textContent = values[index]);
  dynamicStyling(options, "selected", "remove");
}

function search(value, type){
  const searchAreas = document.querySelectorAll('.search-area');
  const matcher = new RegExp(value, 'i');

  searchAreas.forEach(searchArea => {
    const finders = searchArea.querySelectorAll('.finder1, .finder2, .finder3, .finder4, .finder5, .finder6');
    let shouldHide = true;

    finders.forEach(finder => {
      if (matcher.test(finder.textContent)) {
        searchArea.classList.add("search-match");
        shouldHide = false;
      }
    });

    if (shouldHide) {
      searchArea.classList.remove("search-match");
      searchArea.style.display = 'none';
    } else {
      type === "table" ?
       searchArea.style.display = 'table-row' 
       : searchArea.style.display = 'block';
    }
  });
}

function pagination(elem, elemType, $max){
  const itemsPerPage = $max;
  let currentPage = 1;
  let numPages = 0;
  
  const listItems = document.querySelectorAll(elem);
  const container = document.querySelector(".pagination-container");

  if(listItems.length > itemsPerPage){
    container.classList.remove("hidden");
    container.classList.add("flex");
  }
  
  function showPage(page) {
    currentPage = page;
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
  
    listItems.forEach((item, index) => {
      if (index >= startIndex && index < endIndex) {
        item.style.display = elemType === "table" ? 'table-row' : 'block';
      } else {
        item.style.display = 'none';
      }
    });
  
    updatePagination();
  }
  
  function updatePagination() {
    numPages = Math.ceil(listItems.length / itemsPerPage);
    const paginationList = document.querySelector('.pagination');
    paginationList.innerHTML = '';
  
    const recordCount = document.querySelector(".record-label");
    recordCount.textContent = `Showing ${currentPage} / ${numPages}`;
  
    let startPage = 1;
    let endPage = numPages;
  
    if (numPages > 2) {
      if (currentPage === 1) {
        endPage = 2;
      } else if (currentPage === numPages) {
        startPage = numPages - 1;
      } else {
        startPage = currentPage - 1;
        endPage = currentPage + 1;
      }
    }
    
    if (startPage > 1) {
      const pageLink = createPageLink(1);
      paginationList.appendChild(pageLink);
      if(startPage > 2){
        paginationList.appendChild(createEllipsis());
      }
    }
  
    for (let i = startPage; i <= endPage; i++) {
      const pageLink = createPageLink(i);
      paginationList.appendChild(pageLink);
    }
  
    if (endPage < numPages) {
      paginationList.appendChild(createEllipsis());
    }
  
    const prevButton = document.querySelector('.prev-btn');
    const nextButton = document.querySelector('.next-btn');
  
    prevButton.disabled = currentPage === 1;
    nextButton.disabled = currentPage === numPages;
  }
  
  function createPageLink(pageNumber) {
    const pageLink = document.createElement('a');
    pageLink.className = "text-xs text-grey font-medium py-[7px] px-4 bg-white rounded-full transition-all";
    pageLink.textContent = pageNumber;
    pageLink.href = '#';
    pageLink.addEventListener('click', function (event) {
      event.preventDefault();
      showPage(pageNumber);
    });
  
    if (pageNumber === currentPage) {
      pageLink.classList.add('active');
    }
  
    const listItem = document.createElement('li');
    listItem.appendChild(pageLink);
  
    return listItem;
  }
  
  function createEllipsis() {
    const ellipsis = document.createElement('span');
    ellipsis.className = "list-none text-xs text-grey font-medium py-[7px] px-4 bg-white rounded-full cursor-default";
    ellipsis.textContent = '...';
  
    const listItem = document.createElement('li');
    listItem.appendChild(ellipsis);
  
    return listItem;
  }
  
  const prevButton = document.querySelector('.prev-btn');
  const nextButton = document.querySelector('.next-btn');
  
  prevButton.addEventListener('click', function () {
    if (currentPage > 1) {
      showPage(currentPage - 1);
    }
  });
  
  nextButton.addEventListener('click', function () {
    if (currentPage < numPages) {
      showPage(currentPage + 1);
    }
  });
  
  showPage(currentPage);
}

function dateSearch(startDate, endDate,  type){
  const searchAreas = document.querySelectorAll('.search-area');

  searchAreas.forEach(searchArea => {
    const finder = searchArea.querySelector('.dateFinder');
    const saleDate = new Date(finder.textContent.trim());

    if(saleDate >= startDate && saleDate <= endDate){
      searchArea.classList.add('search-match');
      searchArea.style.display = 'table-row';
    } else {
      searchArea.classList.remove('search-match');
      searchArea.style.display = 'none';
    }
  });
}

function appendSizes(parentContainer, size){
  const parentEl = document.querySelector(parentContainer);
  const ingredientSelects = document.querySelectorAll(".ingredient-select");
  const sizeWrapper = document.createElement("div");
  const p = document.createElement("p");
  p.className = "text-[10px] text-black/60 font-semibold pl-2 mb-3";
  p.textContent = `${size} Ingredient Amount`;
  sizeWrapper.appendChild(p);
  
  const sizeGrid = document.createElement("div");
  sizeGrid.className = "grid grid-cols-2 gap-3 mb-3";

  ingredientSelects.forEach((ingredient, index) => {
    const inputWrapper = document.createElement("div");
    inputWrapper.className = "flex items-center h-10 bg-light-gray rounded-full px-6 mb-3";
    const input = document.createElement("input");
    input.setAttribute("type", "text");
    input.setAttribute("name", `${size}[]`);
    input.setAttribute("placeholder", `Ingredient ${index + 1} amount (eg. 10 ml)`);
    input.className = "w-full h-full text-[10px] font-medium text-black placeholder:text-black/60 bg-transparent";
    inputWrapper.appendChild(input);
    sizeGrid.appendChild(inputWrapper);
  })

  sizeWrapper.appendChild(sizeGrid);
  parentEl.appendChild(sizeWrapper);
}

function sortTableByColumn(table, column, asc = true) {
  const dirModifier = asc ? 1 : -1;
  const tBody = table.tBodies[0];
  const rows = Array.from(tBody.querySelectorAll("tr"));

  const sortedRows = rows.sort((a, b) => {
    const aColText = a.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();
    const bColText = b.querySelector(`td:nth-child(${ column + 1 })`).textContent.trim();

    return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
  });

  while (tBody.firstChild) {
      tBody.removeChild(tBody.firstChild);
  }

  tBody.append(...sortedRows);

  table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
  table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-asc", asc);
  table.querySelector(`th:nth-child(${ column + 1})`).classList.toggle("th-sort-desc", !asc);
}

function orderItemTemplate(datas) {
  const ordersWrapper = document.querySelector(".order-item-wrapper");
  const fragment = document.createDocumentFragment();

  for (const key in datas) {
    const itemWrapper = document.createElement("div");
    const imageWrapper = document.createElement("div");
    const menuImage = document.createElement("img");
    const itemDetailsWrapper = document.createElement("div");
    const itemName = document.createElement("p");
    const itemCategory = document.createElement("p");
    const itemSize = document.createElement("p");
    const itemPriceQuantityWrapper = document.createElement("div");
    const itemPriceWrapper = document.createElement("div");
    const itemPriceLabel = document.createElement("p");
    const itemPriceValue = document.createElement("p");
    const itemQuantityWrapper = document.createElement("div");
    const itemQuantityLabel = document.createElement("p");
    const itemQuantityValue = document.createElement("p");
  
    itemWrapper.setAttribute('class', 'flex items-center gap-6 py-1');

    imageWrapper.setAttribute('class', 'w-24 h-24 grid place-items-center bg-light-gray rounded-xl px-6');
    menuImage.setAttribute('class', 'w-23 h-23');
    menuImage.setAttribute('src', SYSTEM_URL + 'uploads/menus/' + datas[key].menu_id + ".png");
    menuImage.setAttribute('alt', 'menu');
    imageWrapper.appendChild(menuImage);
    
    itemName.setAttribute('class', 'text-[10px] font-semibold text-black leading-none');
    itemName.textContent = datas[key].menu_name;
    itemCategory.setAttribute('class', 'text-[8px] font-semibold text-black/60 mb-1');
    itemCategory.textContent = datas[key].category_name;
    itemSize.setAttribute('class', 'text-[10px] font-semibold text-black/60 mb-3');
    itemSize.textContent = datas[key].size_name;

    itemPriceQuantityWrapper.setAttribute('class', 'flex items-center justify-between gap-3');
    itemPriceLabel.setAttribute('class', 'text-[8px] font-semibold text-black/60');
    itemPriceLabel.textContent = 'Price';
    itemPriceValue.setAttribute('class', 'text-[10px] font-bold text-black');
    itemPriceValue.textContent = "P" + datas[key].menu_price;
    itemPriceWrapper.appendChild(itemPriceLabel);
    itemPriceWrapper.appendChild(itemPriceValue);

    itemQuantityLabel.setAttribute('class', 'text-[8px] font-semibold text-black/60');
    itemQuantityLabel.textContent = 'Qty';
    itemQuantityValue.setAttribute('class', 'text-[10px] font-bold text-black');
    itemQuantityValue.textContent = datas[key].quantity;
    itemQuantityWrapper.appendChild(itemQuantityLabel);
    itemQuantityWrapper.appendChild(itemQuantityValue);
    itemPriceQuantityWrapper.appendChild(itemPriceWrapper);
    itemPriceQuantityWrapper.appendChild(itemQuantityWrapper);

    itemDetailsWrapper.appendChild(itemName);
    itemDetailsWrapper.appendChild(itemCategory);
    itemDetailsWrapper.appendChild(itemSize);
    itemDetailsWrapper.appendChild(itemPriceQuantityWrapper);

    itemWrapper.appendChild(imageWrapper);
    itemWrapper.appendChild(itemDetailsWrapper);

    fragment.appendChild(itemWrapper);
  }

  ordersWrapper.appendChild(fragment);
}