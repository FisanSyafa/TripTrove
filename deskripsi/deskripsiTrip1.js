$(document).ready(function(){
  $(window).scroll(function(){
      // sticky navbar on scroll script
      if(this.scrollY > 20){
          $('.navbar').addClass("sticky");
      }else{
          $('.navbar').removeClass("sticky");
      }
      
      // scroll-up button show/hide script
      if(this.scrollY > 500){
          $('.scroll-up-btn').addClass("show");
      }else{
          $('.scroll-up-btn').removeClass("show");
      }
  });
  

  document.addEventListener("DOMContentLoaded", function() {
      const dropdownBtn = document.querySelector('.dropdown-btn');
      const dropdownContent = document.querySelector('.dropdown-content');

      dropdownBtn.addEventListener('click', function() {
          dropdownContent.classList.toggle('show');
      });

      // Tutup dropdown jika klik di luar dropdown
      window.addEventListener('click', function(event) {
          if (!event.target.matches('.dropdown-btn')) {
              if (dropdownContent.classList.contains('show')) {
                  dropdownContent.classList.remove('show');
              }
          }
      });
  });
  


  // slide-up script
  $('.scroll-up-btn').click(function(){
      $('html').animate({scrollTop: 0});
      // removing smooth scroll on slide-up button click
      $('html').css("scrollBehavior", "auto");
  });

  $('.navbar .menu li a').click(function(){
      // applying again smooth scroll on menu items click
      $('html').css("scrollBehavior", "smooth");
  });

  // toggle menu/navbar script
  $('.menu-btn').click(function(){
      $('.navbar .menu').toggleClass("active");
      $('.menu-btn i').toggleClass("active");
  });

  // typing text animation script
  var typed = new Typed(".typing", {
      strings: [" Yogyakarta"," Central Java", " East Java"],
      typeSpeed: 100,
      backSpeed: 60,
      loop: true
  });

  var typed = new Typed(".typing-2", {
      strings: ["Cleanliness", "Professional Driver", "safety", "Fun", "Memorable Trip"],
      typeSpeed: 100,
      backSpeed: 60,
      loop: true
  });

  

  // owl carousel script
  $(".owl-carousel").owlCarousel({
      loop: true,              // Loop agar carousel terus berputar
      margin: 10,              // Jarak antar item
      nav: true,               // Menampilkan tombol prev/next
      dots: false,             // Sembunyikan navigasi titik
      autoplay: true,          // Aktifkan autoplay
      autoplayTimeout: 3000,   // Delay per slide (3 detik)
      autoplayHoverPause: true,// Pause saat hover
      smartSpeed: 1000,        // Transisi lebih halus
      slideTransition: 'linear', // Efek pergeseran lebih smooth
      navText: ["&#10094;", "&#10095;"], // Menggunakan simbol panah kiri/kanan
      responsive: {
          0: { items: 1 },
          600: { items: 2 },
          1000: { items: 4 }
      }
  });
});



document.addEventListener("DOMContentLoaded", function () {
  let slideIndex = 1;
  tampilanSlide(slideIndex);

  // Next/previous controls
  document.querySelectorAll(".prev, .next").forEach(button => {
      button.addEventListener("click", function () {
          let n = this.classList.contains("prev") ? -1 : 1;
          ubahSlide(n);
      });
  });

  // Thumbnail image controls
  document.querySelectorAll(".dot").forEach((dot, index) => {
      dot.addEventListener("click", function () {
          posisiSlide(index + 1);
      });
  });

  function ubahSlide(n) {
      tampilanSlide(slideIndex += n);
  }

  function posisiSlide(n) {
      tampilanSlide(slideIndex = n);
  }

  function tampilanSlide(n) {
      let slides = document.getElementsByClassName("slide");
      let dots = document.getElementsByClassName("dot");
      if (slides.length === 0) return;

      if (n > slides.length) { slideIndex = 1; }
      if (n < 1) { slideIndex = slides.length; }

      Array.from(slides).forEach(slide => slide.style.display = "none");
      Array.from(dots).forEach(dot => dot.classList.remove("active"));

      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].classList.add("active");
  }

  // === Navbar Functionality ===
  window.addEventListener("scroll", function () {
      let navbar = document.querySelector(".navbar");
      if (window.scrollY > 20) {
          navbar.classList.add("sticky");
      } else {
          navbar.classList.remove("sticky");
      }
  });

  // Toggle menu untuk mobile
  document.querySelector(".menu-btn").addEventListener("click", function () {
      document.querySelector(".menu").classList.toggle("active");
      this.classList.toggle("active");
  });
});


