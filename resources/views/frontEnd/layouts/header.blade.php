<!-- Header Section -->
<header class="custom-header-section">
    <style>
        /* General Styles for the Header */
        .custom-header-section {
            background-color: #343a40;
            padding: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .custom-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Logo Styles */
        .custom-site-logo img {
            max-height: 50px;
            transition: transform 0.3s ease;
        }

        .custom-site-logo img:hover {
            transform: scale(1.1);
        }

        /* Navbar Styles */
        .custom-main-menu {
            display: flex;
            gap: 30px;
        }

        .custom-main-menu li {
            list-style: none;
        }

        .custom-main-menu li a {
            color: #fff;
            text-transform: uppercase;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .custom-main-menu li a:hover {
            color: #ffcc00;
            transform: translateY(-3px);
        }

        /* Account and Cart Section */
        .custom-user-panel {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .custom-up-item {
            position: relative;
            cursor: pointer;
        }

        .custom-up-item i {
            color: #fff;
            font-size: 20px;
            margin-right: 8px;
            transition: color 0.3s ease;
        }

        .custom-up-item i:hover {
            color: #ffcc00;
        }

        .custom-profile-dropdown {
            position: absolute;
            top: 40px;
            right: 0;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: none; /* Initially hidden */
            z-index: 10;
        }

        .custom-profile-dropdown a {
            display: block;
            padding: 10px 15px;
            color: #333;
            font-size: 14px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .custom-profile-dropdown a:hover {
            background-color: #f7f7f7;
        }

        /* Animation Styles */
        .custom-profile-dropdown {
            animation: custom-fadeIn 0.3s ease;
        }

        @keyframes custom-fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .custom-main-menu {
                display: none; /* Hide menu on mobile */
            }

            .custom-menu-toggle {
                display: block;
                color: #fff;
                font-size: 24px;
                cursor: pointer;
            }

            .custom-main-menu.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 70px;
                left: 0;
                width: 100%;
                background-color: #343a40;
                padding: 20px;
                gap: 20px;
            }

            .custom-main-menu li a {
                font-size: 18px;
                text-align: center;
            }
        }
    </style>


</div>

    <div class="custom-container">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="custom-site-logo">
            <img src="{{ asset('divisima/img/logoo.png') }}" alt="Logo">
        </a>

        <!-- Menu Toggle for Mobile -->
        <span class="custom-menu-toggle" id="customMenuToggle">&#9776;</span>

        <!-- Navigation Menu -->
        <ul class="custom-main-menu" id="customMainMenu">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/list-products') }}">Products</a></li>
            <li><a href="{{ route('about.us') }}">About Us</a></li>
            <li><a href="{{ route('contact.form') }}">Contact Us</a></li>
        </ul>

        <!-- User and Cart Section -->
        <div class="custom-user-panel">
            <div class="custom-up-item">
                <i class="flaticon-bag"></i>
                <a href="{{ url('/viewcart') }}" style="color: #fff;">Cart</a>
            </div>

            <div class="custom-up-item">
                <i class="flaticon-profile" id="customAccountToggle"></i>
                <div class="custom-profile-dropdown" id="customProfileDropdown">
                    @if(Auth::check())
                    <a href="{{ url('/myaccount') }}">Edit Profile</a>
                    <a href="{{ url('/logout') }}">Logout</a>
                    @else
                    <a href="{{ url('/login_page') }}">Sign In</a>
                    <a href="{{ url('/login_page') }}">Create Account</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Section -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const customAccountToggle = document.getElementById('customAccountToggle');
            const customProfileDropdown = document.getElementById('customProfileDropdown');
            const customMenuToggle = document.getElementById('customMenuToggle');
            const customMainMenu = document.getElementById('customMainMenu');

            // Toggle profile dropdown
            customAccountToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                customProfileDropdown.style.display = customProfileDropdown.style.display === 'block' ? 'none' : 'block';
            });

            // Close dropdown if clicking outside
            document.addEventListener('click', function (e) {
                if (!customProfileDropdown.contains(e.target) && e.target !== customAccountToggle) {
                    customProfileDropdown.style.display = 'none';
                }
            });

            // Toggle menu for mobile
            customMenuToggle.addEventListener('click', function () {
                customMainMenu.classList.toggle('active');
            });
        });
    </script>
</header>
