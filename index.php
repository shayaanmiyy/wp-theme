<?php

// Load Timber library
$context = Timber::context();

// The Code Below Will Get all the Context Data from WP, and Print on HTML in Between pre tags
// echo '<pre>';
// print_r($context);
// echo '</pre>';

// Check if the user is on the homepage or page-1
if (is_front_page()) {
    // Goto Home Page
    Timber::render('child.twig', $context);
} elseif ($_SERVER['REQUEST_URI'] === '/page-1') {
    // Go To the page-1 template
    Timber::render('page-1.twig', $context);
} else {
    error_log('Base template rendered.');
    // Render a generic page template or 404
    Timber::render('404.twig', $context);
}