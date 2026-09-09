ini_set('display_errors', 1);
error_reporting(E_ALL);

<?php
require_once __DIR__ . '/includes/header.php';
?>

<div class="landing-container">

    <div class="landing-content">
        <h1 class="landing-title">Fox Valley Movie Rentals</h1>
        <p class="landing-subtitle">Your local source for movie nights.</p>

        <p class="landing-description">
            Manage your movie catalog, customer accounts, rentals, and business reports — all in one modern, secure system.
        </p>

        <a href="/login.php" class="landing-button">Login to Continue</a>
    </div>

</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>