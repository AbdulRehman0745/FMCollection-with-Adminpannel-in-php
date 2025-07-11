@extends('frontEnd.layouts.master')
@section('title','Home Page')
@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .hero-section {
        background-color: #343a40;
        color: white;
        text-align: center;
        padding: 60px 20px;
        position: relative;
    }

    .hero-section h1 {
        font-size: 3.5rem;
        margin-bottom: 20px;
        transition: color 0.3s ease, transform 0.3s ease; /* Smooth transition for color and scale */
    }

    .hero-section p {
        font-size: 1.2rem;
        line-height: 1.8;
    }

    /* Improved Hover effect with scale and color change */
    .hero-section h1:hover {
        color: #f5a623; /* A rich yellow-gold color */
        transform: scale(1.1); /* Slight scaling effect for emphasis */
    }

    .motive-section {
        padding: 40px 20px;
    }

    .founder-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 40px;
        background-color: #f3f3f3;
    }

    .founder-section img {
        width: 50%;
        height: auto;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .founder-text {
        width: 50%;
        padding-left: 20px; /* Reduced padding */
    }

    .founder-text h3 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 15px; /* Reduced space below the heading */
        color: #333;
    }

    .founder-text p {
        font-size: 1.2rem;
        line-height: 1.8;
        color: #666;
    }

    .founder-text a {
        background-color: #343a40;
        color: white;
        border: none;
        padding: 10px 20px;
        text-transform: uppercase;
        font-weight: bold;
        border-radius: 5px;
        display: inline-block;
        margin-top: 20px;
    }

    .founder-text a:hover {
        background-color: #495057;
        color: white;
    }

    .btn-learn-more {
        background-color: #343a40;
        color: white;
        border: none;
    }

    .btn-learn-more:hover {
        background-color: #495057;
        color: white;
    }

    /* Responsive Design for Smaller Screens */
    @media (max-width: 767px) {
        .founder-section {
            flex-direction: column;
            text-align: center;
        }

        .founder-section img,
        .founder-text {
            width: 100%;
        }

        .founder-text {
            padding-left: 0;
        }

        .hero-section h1 {
            font-size: 2.5rem;
        }

        .hero-section p {
            font-size: 1rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <h1>Welcome to ShoesZone</h1>
    <p>Your ultimate destination for comfortable, stylish, and high-quality footwear. We are dedicated to providing you with the best shoe-shopping experience.</p>
</section>

<!-- Our Motive Section -->
<section class="motive-section">
    <div class="container">
        <h2 class="text-center mb-4">Our Motive</h2>
        <p class="text-center">
            At ShoesZone, we believe that every step you take should be filled with comfort and confidence. Our motive is to combine innovation with style to bring you the best footwear for every occasion. Whether it's casual wear, sports, or formal events, we have it all covered for you.
        </p>
        <div class="text-center mt-4">
            <a href="#" class="btn btn-learn-more">Learn More</a>
        </div>
    </div>
</section>

<!-- Founder Section -->
<section class="founder-section">
    <!-- Founder Image -->
    <div class="founder-img">
        <img src="{{ asset('img/profile.jpg') }}" alt="Founder of ShoesZone">
    </div>

    <!-- Founder Text -->
    <div class="founder-text">
        <h3>Meet Our Founder</h3>
        <p>
            Abdul Rehman, the visionary behind ShoesZone, has always been passionate about creating footwear that combines style and comfort. With over 15 years of experience in the fashion industry, Rehman has led ShoesZone to become a trusted name in the footwear market.
        </p>
        <p>
            His dedication and commitment to quality have made ShoesZone a favorite among customers worldwide. Rehman's mission is to keep innovating and ensuring that everyone can walk in style without compromising on comfort.
        </p>
        <div class="text-center">
            <a href="#" class="btn btn-learn-more">Read More About Abdul Rehman</a>
        </div>
    </div>
</section>
@endsection
