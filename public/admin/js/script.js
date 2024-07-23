// -----------------------------------------------sidebar---------------------------------------------//
document.addEventListener('DOMContentLoaded', function () {

  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".sidebarBtn");
  sidebarBtn.onclick = function () {
    sidebar.classList.toggle("active");
  }

  let links = document.querySelectorAll(".sidebar-item a");
  links.forEach(function (link) {
    link.addEventListener("click", function () {
      links.forEach(function (item) {
        item.classList.remove("active");
      });
      this.classList.add("active");
    });
  });

  selectMenuItem();

  function selectMenuItem() {
    var currentUrl = window.location.href.toLowerCase();
    var sidebarLinks = document.querySelectorAll('#sidebar a');
    var admin = URLROOT + '/admin';

    sidebarLinks.forEach(function (link) {
      var itemUrl = link.href.toLowerCase();

      if (currentUrl === itemUrl) {
        link.classList.add('active');
        return false;
      } else {
        if (currentUrl.indexOf(itemUrl) !== -1 && itemUrl !== admin.toLowerCase()) {
          link.classList.add('active');
          return false;
        }
      }
    });
  }

});

// -----------------------------------------------select img-wrapper---------------------------------------------//
function initializeImageModals() {
  const images = Array.from(document.querySelectorAll('.list-img .img-wrapper img')).map(img => img.src);

  if (images.length === 0) return; 

  let currentImgIndex = 0;

  function showModal(index) {
    currentImgIndex = index;
    const modal = document.getElementById('imgModal');
    const modalImg = document.getElementById('modal-img');

    modalImg.src = images[currentImgIndex];
    modal.style.display = 'block';
  }

  function changeImg(n) {
    currentImgIndex += n;
    if (currentImgIndex >= images.length) currentImgIndex = 0;
    if (currentImgIndex < 0) currentImgIndex = images.length - 1;
    const modalImg = document.getElementById('modal-img');
    modalImg.src = images[currentImgIndex];
  }

  document.querySelectorAll('.img-wrapper img').forEach((img, index) => {
    img.onclick = () => showModal(index);
  });

  document.querySelector('.close').onclick = () => {
    document.getElementById('imgModal').style.display = 'none';
  };

  document.querySelector('.prev').onclick = () => changeImg(-1);
  document.querySelector('.next').onclick = () => changeImg(1);

  window.onclick = (event) => {
    if (event.target === document.getElementById('imgModal')) {
      document.getElementById('imgModal').style.display = 'none';
    }
  };
}

document.addEventListener('DOMContentLoaded', function () {
  initializeImageModals();
});

// -----------------------------------------------select img---------------------------------------------//
function previewImage(input) {
  var file = input.files[0];
  var reader = new FileReader();

  reader.onload = function (e) {
    var imgElement = input.parentNode.querySelector('img');
    imgElement.src = e.target.result;
  }
  reader.readAsDataURL(file);
}

// -----------------------------------------------ngăn chặn việc gửi lại form---------------------------------------------//
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

// -----------------------------------------------Loader---------------------------------------------//
document.addEventListener("DOMContentLoaded", function () {
  window.addEventListener("beforeunload", function (event) {
    document.getElementById("loader").style.display = "block";
  });
});