<?php
$pageTitle = 'Privacy Policy';
include 'includes/header.php';
?>

<div class="container">

    <div class="page-header">
        <h1 class="page-title">Privacy Policy</h1>
        <p class="page-subtitle">Last updated: <?= date('F d, Y') ?></p>
    </div>

    <div class="policy-wrap">

        <div class="policy-section">
            <h2 class="policy-heading">1. Introduction</h2>
            <p>CineBook ("we", "our", or "us") is committed to protecting your personal information. This Privacy Policy explains what data we collect, how we use it, and your rights regarding that data when you use our Online Movie Booking System at Tribhuvan University, Ratna Rajyalaxmi Campus.</p>
        </div>

        <div class="policy-section">
            <h2 class="policy-heading">2. Information We Collect</h2>
            <p>We collect the following information when you register or use our platform:</p>
            <ul class="policy-list">
                <li><strong>Account information</strong> — your full name, email address, and optional phone number provided during registration.</li>
                <li><strong>Booking information</strong> — movies booked, seats selected, showtimes, and payment method used.</li>
                <li><strong>Payment information</strong> — transaction IDs returned by eSewa or Khalti. We do not store your card or wallet credentials.</li>
                <li><strong>Usage data</strong> — pages visited and actions taken within the platform for debugging and improvement purposes.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2 class="policy-heading">3. How We Use Your Information</h2>
            <p>Your information is used solely for the following purposes:</p>
            <ul class="policy-list">
                <li>Processing and confirming your ticket bookings.</li>
                <li>Sending booking confirmation reference codes to your registered email.</li>
                <li>Managing your booking history and cancellations.</li>
                <li>Allowing cinema administrators to generate reports and manage operations.</li>
                <li>Improving the platform based on usage patterns.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2 class="policy-heading">4. Data Storage and Security</h2>
            <p>Your data is stored in a secured MySQL database hosted on our local server infrastructure. Passwords are hashed using bcrypt and are never stored in plain text. Payment credentials are never stored on our servers — all payment processing is handled directly by eSewa and Khalti.</p>
        </div>

        <div class="policy-section">
            <h2 class="policy-heading">5. Data Sharing</h2>
            <p>We do not sell, trade, or share your personal data with third parties. The only external systems that receive any of your data are the payment gateways (eSewa and Khalti) for the sole purpose of processing your ticket payments.</p>
        </div>

        <div class="policy-section">
            <h2 class="policy-heading">6. Cookies</h2>
            <p>We use PHP session cookies to keep you logged in during your visit. These cookies are temporary and are deleted when you close your browser or log out. We do not use tracking or advertising cookies.</p>
        </div>

        <div class="policy-section">
            <h2 class="policy-heading">7. Your Rights</h2>
            <p>You have the right to:</p>
            <ul class="policy-list">
                <li>Access the personal data we hold about you.</li>
                <li>Request correction of inaccurate data.</li>
                <li>Request deletion of your account and associated data.</li>
            </ul>
            <p class="mt-2">To exercise any of these rights, please contact us using the details on our <a href="<?= $base ?>/contact.php">Contact page</a>.</p>
        </div>

        <div class="policy-section">
            <h2 class="policy-heading">8. Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. Any changes will be reflected on this page with an updated date at the top. Continued use of the platform after changes constitutes acceptance of the updated policy.</p>
        </div>

        <div class="policy-section">
            <h2 class="policy-heading">9. Contact</h2>
            <p>If you have any questions about this Privacy Policy, please reach out through our <a href="<?= $base ?>/contact.php">Contact page</a>.</p>
        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>