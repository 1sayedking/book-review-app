<!doctype html>
<html lang="en">
    {{-- VS Code

    Shortcut:for add indent to code
    Windows/Linux: Shift + Alt + F --}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">
    <div class="container-fluid shadow-lg header">
        <div class="container">
            
            <div class="d-flex justify-content-between">
                <h1 class="text-center"><a href="{{ route('home') }}" class="h3 text-white text-decoration-none"><i class="fa-solid fa-house fa-1x"></i> Islamic Library</a> </h1>
                        

                <div class="d-flex align-items-center navigation">
                    @if (Auth::check())
                    
                        <a href="{{ route('account.profile') }}" class="text-white"><i class="fa-solid fa-user"></i> My Account</a>
                    @else
                    

                        <a href="{{ route('account.login') }}" class="text-white">Login</a>
                        <a href="{{ route('account.register') }}" class="text-white ps-2">Register</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @yield('main')
    <footer>
        <div class="container">
            <div class="row">
                <!-- About Us Column -->
                <div class="col-md-6 mb-3">
                    <h5 class="text-white">About Us</h5>
                    <p style="text-align: justify">
                     Hi! I’m a web developer skilled in creating responsive, dynamic websites using HTML, CSS, Bootstrap, JavaScript, PHP, MySQL, and Laravel. I can build any type of website, from custom landing pages to full-scale web applications and eCommerce platforms.
                     I'm committed to delivering quality work, meeting deadlines, and clear communication throughout. Let’s collaborate on your next web project!</br>
                     I'm Sayed afzal Ibrahimkhil I'm a Full-Stack Web Developer,if you want any type of website Contact me,  We are dedicated to providing the best services and resources to our users. Stay connected with us for updates.

                    </p>
                </div>

                <!-- Quick Links Column -->
                <div class="col-md-3 mb-3">
                    <h5 class="text-white">Quick Links</h5></br>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}"><i class="fa-solid fa-house fa-2x"></i> Home</a></li></br>
                        
                        <li><a href="https://wa.me/+93772646661" target="_blank"><i class="fa-brands fa-whatsapp fa-2x"></i> Contact Us</a></li>
                        
                    </ul>
                </div>

                <!-- Follow Us Column -->
                <div class="col-md-3 mb-3">
                    <h5 class="text-white">Follow Us</h5></br>
                    <ul class="list-unstyled">
                        <li><a href="https://www.facebook.com/profile.php/?id=100060799428349" target="_blank"> <i class="fa-brands fa-facebook fa-2x"></i> Facebook</a></li></br>
                        
                    
                        <li><a href="https://www.instagram.com/sayed_afzal_ibrahimkhil/?__pwa=1" target="_blank"> <i class="fa-brands fa-instagram fa-2x"></i> Instagram</a></li>
                        
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom Section -->
            <div class="footer-bottom mt-3">
                &copy; 2024 Your Website | <a href="#">Terms of Service</a> | <a href="#">page up</a>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
