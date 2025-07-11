@extends('frontEnd.layouts.master')
@section('title', 'Home Page')
@section('content')
<style>
    /* Custom Styles */
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
        animation: fadeIn 2s ease-out; /* Cool animation */
    }

    .hero-section h1 {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .hero-section p {
        font-size: 1.2rem;
        line-height: 1.8;
    }

    .container {
        max-width: 960px;
        margin: 0 auto;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .card input, .card textarea {
        transition: all 0.3s ease;
    }

    .card input:focus, .card textarea:focus {
        border-color: #f5a623;
        box-shadow: 0 0 8px rgba(245, 166, 35, 0.7);
    }

    .btn-primary {
        background-color: #f5a623;
        border: none;
    }

    .btn-primary:hover {
        background-color: #e4a019;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 5px;
    }

    .footer {
        text-align: center;
        padding: 20px;
        background-color: #343a40;
        color: white;
        margin-top: 40px;
    }

    table th, table td {
        text-align: center;
        padding: 12px;
    }

    table th {
        background-color: #343a40;
        color: white;
    }

    table tr:nth-child(even) {
        background-color: #f3f3f3;
    }

    table tr:hover {
        background-color: #f5a623;
        color: white;
    }

    /* Hover effects */
    input:focus, textarea:focus {
        border-color: #f5a623;
        box-shadow: 0 0 8px rgba(245, 166, 35, 0.7);
    }

    /* Success message styling */
    .alert-success {
        background-color: #28a745;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        display: none; /* Hidden initially */
    }

    /* Animation for the hero section */
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(-50px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* Custom Animation for Alert Box */
    .alert-message {
        background-color: #28a745;
        color: white;
        padding: 15px;
        border-radius: 5px;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        max-width: 400px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: none; /* Hidden by default */
        z-index: 9999;
    }

    .alert-message button {
        background: none;
        border: none;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-left: 10px;
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <h1>Contact Us</h1>
    <p>We would love to hear from you. Please fill in the form below to get in touch with us.</p>
</section>

<!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Contact Form Section -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h2 class="text-center mb-4">Send Us a Message</h2>
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Message Alert -->
<div class="alert-message" id="successAlert">
    Your message has been successfully sent. Our admin will contact you in 2 hours.
    <button onclick="dismissAlert()">OK</button>
</div>

<script>
    // Show success message when the form is submitted successfully
    @if(session('success'))
        document.getElementById('successAlert').style.display = 'block';
    @endif

    // Dismiss the alert box
    function dismissAlert() {
        document.getElementById('successAlert').style.display = 'none';
    }
</script>

@endsection
