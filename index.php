<?php
// Load Timber library
$context = Timber::context();
// echo '<pre>';
// print_r($context);
// echo '</pre>';
$context['items'] = ['Apple', 'Banana', 'Cherry'];

Timber::render('child.twig', $context);
?>