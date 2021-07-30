<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cửa hàng Mạnh Bảo</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="" />
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('product.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                GIỎ HÀNG
                            </a>
                        </li>
                        @auth
                            @if (Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link text-danger" href="{{ route('product.create') }}">
                                        <i class="fas fa-plus-square"></i> THÊM SẢN PHẨM
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-danger" href="{{ route('order') }}">
                                        <i class="fas fa-truck"></i> ĐƠN HÀNG
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" 
                                    class="nav-link dropdown-toggle" 
                                    href="#" 
                                    role="button" 
                                    data-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="false" 
                                    v-pre
                                >
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('bought') }}">
                                        <i class="far fa-heart"></i> ĐƠN HÀNG
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> ĐĂNG XUẤT
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">ĐĂNG NHẬP</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">ĐĂNG KÝ</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="mt-5 text-lg-start bg-dark text-muted">
            <section class="p-2">
                <div class="container text-md-start mt-5">
                    <div class="row mt-3">
                        <div class="col-md-6 col-lg-4 col-xl-4 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">
                                <i class="fas fa-gem me-3"></i> MANHBAO SHOP
                            </h6>
                            <p>
                                Chuyên cung cấp nông sản, hàng khô uy tín, chât lượng, giá tốt nhât thị trường.
                            </p>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-4 mx-auto mb-4">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d465.49730397060057!2d105.83157785521203!3d21.033548983937347!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135aba035f3205d%3A0xc7885470f2f3e475!2zTmjDoCBNw6F5IENo4bq_IFThuqFvIFRoaeG6v3QgQuG7iyBT4bqleSBLaMO0IEppYW5nc3UgRmFucXVu!5e0!3m2!1svi!2s!4v1627524957160!5m2!1svi!2s"
                                width="auto"
                                height="auto" 
                                style="border:0;"
                                allowfullscreen="" 
                                loading="lazy"
                            ></iframe>
                        </div>
                        <div class="col-md-12 col-lg-4 col-xl-4 mx-auto mb-md-0 mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">
                                LIÊN HỆ
                            </h6>
                            <p>
                                <i class="fas fa-home me-3"></i> Chợ Ngọc Hà, Ngọc Hà, Ba Đình, Hà Nội
                            </p>
                            
                            <p>
                                <i class="fas fa-envelope me-3"></i>
                                thangdotpro@gmail.com
                            </p>
        
                            <p>
                                <i class="fas fa-phone me-3"></i> + 84 983 516 539
                            </p>
        
                            <p>
                                <i class="fas fa-print me-3"></i> + 84 375 200 180
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
              © 2021 COPYRIGHT
              <a class="text-reset fw-bold" href="">AAAMARKET</a>
            </div>
        </footer>
    </div>
</body>
</html>
