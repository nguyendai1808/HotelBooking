$(document).ready(function () {
  selectMenuItem();

  function selectMenuItem() {
    var currentUrl = window.location.href.toLowerCase();
    $('#sidebar a').each(function () {
      var itemUrl = this.href.toLowerCase();
      var admin = 'http://localhost/HotelBooking/admin';

      if (currentUrl === itemUrl) {
        $(this).addClass('active');
        return false;
      } else {
        if (currentUrl.indexOf(itemUrl) !== -1 && itemUrl != admin.toLowerCase()) {
          $(this).addClass('active');
          return false;
        }
      }
    });
  }
});

function previewImage(input) {
  var file = input.files[0];
  var reader = new FileReader();

  reader.onload = function (e) {
    var imgElement = input.parentNode.querySelector('img');
    imgElement.src = e.target.result;
  }
  reader.readAsDataURL(file);
}
