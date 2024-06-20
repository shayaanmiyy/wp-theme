<?php
// get twig Extension From Composer
require_once 'vendor/autoload.php';


// Load Timber library
if (!class_exists('Timber')) {
    // If Not Exists Show Alert On Wordpress
    add_action('admin_notices', function () {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber-library')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
    });
    return;
}

// Specify Timber to use templates directory
Timber::$dirname = array('templates', 'views');

// My Custom filter to capitalize the Text
function capitalize_first($string)
{
    return ucwords($string);
}

add_filter('timber/twig', function ($twig) {
    //  Register My Custom Filter with Twig | <filtername>
    $twig->addFilter(new Twig\TwigFilter('capitalize_first', 'capitalize_first'));
    return $twig;
});

function square($number)
{
    return $number * $number;
}

add_filter('timber/twig', function ($twig) {
    // Registering Function with Twig
    $twig->addFunction(new Twig\TwigFunction('square', 'square'));
    return $twig;
});

add_filter('timber/twig', function ($twig) {
    // Purpose For USing this, to let Twig Works on Given Array, w/o this Array in the teig will not work
    $twig->addExtension(new Twig_Extensions_Extension_Array());
    return $twig; // Returning the aaded changes on Twig
});

// Now by timber/Site inherit that into myClass
class MySite extends Timber\Site
{
    public function __construct() // Initiated Here
    {
        add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_filter('timber/context', array($this, 'add_to_context'));
        add_filter('timber/twig', array($this, 'add_to_twig'));
        parent::__construct();
    }


    public function add_to_context($context)
    {
        // Passing Context or Content to Twig
        $context['SayHello'] = 'Hello World';
        $context['myname'] = 'Shayaan';
        $context['items'] = ['Apple', 'Banana', 'Cherry'];
        $context['score'] = 75;
        $context['description'] = '  This is a description with some extra spaces.  ';
        return $context;
    }

    public function add_to_twig($twig)
    {
        // Similar to what we done above, let twig take string on work on it
        // For Dynamic Content, we can deifne this on top as well
        $twig->addExtension(new Twig\Extension\StringLoaderExtension());
        return $twig;
    }
}

new MySite();

