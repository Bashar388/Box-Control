<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Marketplace</title>
  <style>
      /* Reset */
      * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
      }
      body {
          background-image: url('{{asset('templet/assets/images/خدمات.jfif')}}');
          background-size: cover;
          background-position: center;
          background-attachment: fixed;
          background-repeat: no-repeat;
          font-family: Arial, sans-serif;
          color: #333;
      }
      /* Navbar */
      .navbar {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 20px;
          background-color: #2d3e50;
          color: white;
      }

      .navbar .logo {
          font-size: 24px;
          font-weight: bold;
      }

      .navbar nav ul {
          display: flex;
          list-style: none;
      }

      .navbar nav ul li {
          margin-left: 20px;
      }

      .navbar nav ul li a {
          color: white;
          text-decoration: none;
      }

      /* Search Bar */
      .search-bar {
          display: flex;
          justify-content: center;
          padding: 20px;
      }

      .search-bar input {
          padding: 10px;
          width: 50%;
          border: 1px solid #ccc;
          border-radius: 4px 0 0 4px;
      }

      .search-bar button {
          padding: 10px;
          background-color: #2d3e50;
          color: white;
          border: none;
          border-radius: 0 4px 4px 0;
          cursor: pointer;
      }

      /* Hero Banner */
      .hero-banner {
          text-align: center;
          padding: 40px;
          background-color: #f4f4f9;
      }

      .hero-banner h2 {
          font-size: 32px;
          margin-bottom: 10px;
      }

      .hero-banner p {
          font-size: 18px;
          color: #555;
      }

      /* Service Categories */
      .categories {
          padding: 20px;
          text-align: center;
      }

      .categories h2 {
          margin-bottom: 20px;
      }

      .category-list {
          display: flex;
          justify-content: center;
          gap: 20px;
      }

      .category {
          padding: 20px;
          background-color: #e0e5ec;
          border-radius: 8px;
          width: 150px;
          text-align: center;
          font-size: 18px;
          cursor: pointer;
      }

      /* Featured Services */
      .featured-services {
          padding: 20px;
      }

      .featured-services h2 {
          text-align: center;
          margin-bottom: 20px;
      }

      .service-card {
          display: inline-block;
          width: 30%;
          margin: 10px;
          padding: 20px;
          border: 1px solid #ddd;
          border-radius: 8px;
          text-align: center;
          background-color: #fff;
      }

      .service-card img {
          width: 100%;
          height: auto;
          border-radius: 4px;
      }

      .service-card h3 {
          font-size: 20px;
          margin: 10px 0;
      }

      .service-card span {
          font-size: 16px;
          color: #ffcc00;
      }

      /* Testimonials */
      .testimonials {
          padding: 20px;
          background-color: #f4f4f9;
          text-align: center;
      }

      .testimonials h2 {
          margin-bottom: 20px;
      }

      .testimonials p {
          font-style: italic;
          color: #555;
          margin: 10px 0;
      }
      .favorite-btn {
          margin-top: 10px;
          padding: 8px;
          background-color: #ff9800;
          color: white;
          border: none;
          border-radius: 4px;
          cursor: pointer;
      }

      .favorite-btn.added {
          background-color: #ff5722;
      }
  </style>
    <script>

        function welcomeUser() {
            const userName = "";
            if (userName) {
                alert(`Welcome، ! We are happy to have you back`);
            }
        }


        window.onload = welcomeUser;


        document.addEventListener("DOMContentLoaded", function() {
            const favoriteButtons = document.querySelectorAll(".favorite-btn");

            favoriteButtons.forEach(button => {
                button.addEventListener("click", function() {
                    button.classList.toggle("added");
                    if (button.classList.contains("added")) {
                        button.innerText = "إزالة من المفضلة";
                        alert("تمت إضافة الخدمة إلى المفضلة.");
                    } else {
                        button.innerText = "إضافة إلى المفضلة";
                        alert("تمت إزالة الخدمة من المفضلة.");
                    }
                });
            });
        });


        const buttons = document.querySelectorAll("button");

        buttons.forEach(button => {
            button.addEventListener("mouseover", () => {
                button.style.backgroundColor = "#3e4b61";
                button.style.color = "#fff";
            });

            button.addEventListener("mouseout", () => {
                button.style.backgroundColor = "#2d3e50";
                button.style.color = "#fff";
            });
        });

    </script>
</head>
<body>
<!-- Navbar -->
<header class="navbar">
    <h1 class="logo">ServiceMarket</h1>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="{{route('services.index')}}">Services</a></li>
            <li><a href="{{route('blogs.index')}}">Blog</a></li>
            @if (Route::has('login'))

                    @auth
                      <li> <a
                            href="{{ route('account.index') }}"
                        >
                            Dashboard
                        </a>
        </li>
                        <li>
                            <a href="{{route('logout')}}">Logout</a>
                        </li>
                    @else
                    <li> <a
                            href="{{ route('login') }}">
                            Log in  /
                        </a>
                    </li>
                        @if (Route::has('register'))
                        <li> <a
                                href="{{ route('register') }}"
                            >
                                Register   /
                            </a>
                        </li>
                        @endif
                    @endauth

            @endif
            <li><a href="#" class="cart-icon">🛒</a></li>
        </ul>
    </nav>
</header>

<!-- Search Bar -->
<section class="search-bar">
    <input type="text" placeholder="Search for services...">
    <button>Search</button>
</section>

<!-- Hero Banner -->
<section class="hero-banner">
    <h2>Professional Services at Affordable Prices</h2>
    <p>Find the right professionals to get your job done</p>
</section>

<!-- Service Categories -->
<section class="categories">
    <h2>Explore Categories</h2>
    <div class="category-list">

    </div>
</section>

<!-- Featured Services -->



</body>
</html>
