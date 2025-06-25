<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <title>wesleyadvent</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets2/css/fontawesome.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets2/css/templatemo-574-mexant.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets2/css/owl.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets2/css/animate.css') }}" />
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

  
</head>

<body>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="{{ url('/') }}" class="logo">
              <img src="{{ asset('assets/images/logo.png') }}" alt="" />
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li class="scroll-to-section"><a href="{{ route('login') }}">Login</a></li>
              <li class="scroll-to-section"><a href="{{ route('register') }}">Register</a></li>
              <li class="scroll-to-section"><a href="{{ url('/contact') }}">Contact Us</a></li>
            </ul>
            <a class="menu-trigger">
              <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="header-text">
            <h2>Login to register our events</h2>
            <div class="div-dec"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ***** Main Banner Area End ***** -->

@foreach($events as $event)
<section class="map mb-5">
  <div class="container">
    <div class="row">
      <!-- Gambar Poster -->
      <div class="col-lg-12">
        <div id="map">
          <img src="{{ asset('storage/' . $event->poster) }}" width="100%" height="100%" style="border-radius: 5px; position: relative; z-index: 2;" alt="Poster {{ $event->nama }}">
        </div>
      </div>

      <!-- Info Acara -->
      <div class="col-lg-10 offset-lg-1">
        <div class="row">
          <!-- Nama & Penanggung Jawab -->
          <div class="col-lg-4">
            <div class="info-item">
<i class="fas fa-check-circle"></i>
              <h4>Acara</h4>
              <a href="#">{{ $event->nama ?? 'Tidak diketahui' }}</a>
            </div>
          </div>

          <!-- Jumlah Peserta -->
          <div class="col-lg-4">
            <div class="info-item">
              <i class="fa fa-users"></i>
              <h4>Jumlah Maks Peserta</h4>
              <a href="#">{{ $event->jumlah_peserta }}</a>
            </div>
          </div>

          <!-- Tanggal dan Waktu -->
          <div class="col-lg-4">
            <div class="info-item">
              <i class="fa fa-calendar-alt"></i>
              <h4>Tanggal & Waktu</h4>
              <a href="#">
                {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}<br>
                {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }}
              </a>
            </div>
          </div>

          <!-- Lokasi -->
          <div class="col-lg-4">
            <div class="info-item">
              <i class="fa fa-map-marker-alt"></i>
              <h4>Lokasi</h4>
              <a href="#">{{ $event->lokasi }}</a>
            </div>
          </div>

          <!-- Narasumber -->
          <div class="col-lg-4">
            <div class="info-item">
              <i class="fa fa-user-tie"></i>
              <h4>Narasumber</h4>
              <a href="#">{{ $event->narasumber }}</a>
            </div>
          </div>

          <!-- Biaya -->
          <div class="col-lg-4">
            <div class="info-item">
              <i class="fa fa-money-bill-wave"></i>
              <h4>Biaya</h4>
              <a href="#">Rp {{ number_format($event->biaya, 0, ',', '.') }}</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endforeach


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <script src="{{ asset('assets2/js/isotope.min.js') }}"></script>
  <script src="{{ asset('assets2/js/owl-carousel.js') }}"></script>

  <script src="{{ asset('assets2/js/tabs.js') }}"></script>
  <script src="{{ asset('assets2/js/swiper.js') }}"></script>
  <script src="{{ asset('assets2/js/custom.js') }}"></script>
  <script>
    var interleaveOffset = 0.5;

    var swiperOptions = {
      loop: true,
      speed: 1000,
      grabCursor: true,
      watchSlidesProgress: true,
      mousewheelControl: true,
      keyboardControl: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      on: {
        progress: function () {
          var swiper = this;
          for (var i = 0; i < swiper.slides.length; i++) {
            var slideProgress = swiper.slides[i].progress;
            var innerOffset = swiper.width * interleaveOffset;
            var innerTranslate = slideProgress * innerOffset;
            swiper.slides[i].querySelector(".slide-inner").style.transform =
              "translate3d(" + innerTranslate + "px, 0, 0)";
          }
        },
        touchStart: function () {
          var swiper = this;
          for (var i = 0; i < swiper.slides.length; i++) {
            swiper.slides[i].style.transition = "";
          }
        },
        setTransition: function (speed) {
          var swiper = this;
          for (var i = 0; i < swiper.slides.length; i++) {
            swiper.slides[i].style.transition = speed + "ms";
            swiper.slides[i].querySelector(".slide-inner").style.transition =
              speed + "ms";
          }
        },
      },
    };

    var swiper = new Swiper(".swiper-container", swiperOptions);
  </script>
</body>

</html>
