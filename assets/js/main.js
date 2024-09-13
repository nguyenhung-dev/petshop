// CHANGE HEADER AND BACKTOTOP
$(document).ready(function() {
  $(window).scroll(function() {
    if($(this).scrollTop() > 0){
      $('header').addClass('scroll'); 
      document.querySelector(".backtotop").style.opacity = "1";
    } else {
      $('header').removeClass('scroll');
      document.querySelector(".backtotop").style.opacity = "0";
    }
  });

  $(".backtotop").click(function () {
    $("html, body").animate(
      {
        scrollTop: 0,
      },
      2000
    );
  });
});

// DROPDOWN
  const accountBtn = document.getElementById('account-btn');
  const dropdown = document.getElementById('account-dropdown');

  // Toggle dropdown visibility
  accountBtn.addEventListener('click', function(event) {
      event.preventDefault();
      dropdown.classList.add('show');
  });

  // Hide dropdown when clicking outside
  document.addEventListener('click', function(event) {
      if (!accountBtn.contains(event.target) && !dropdown.contains(event.target)) {
          dropdown.classList.remove('show');
      }
  });


// SLIDESHOW
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("slide-item");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 4000); 
}