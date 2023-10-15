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