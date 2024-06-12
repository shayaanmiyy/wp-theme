<?php
// Load Timber library
if (!class_exists('Timber')) {
    add_action('admin_notices', function () {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber-library')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
    });
    return;
}

Timber::$dirname = array('templates', 'views');

class MySite extends Timber\Site
{
    public function __construct()
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
        $context['SayHello'] = 'Hello World';
        $context['items'] = ['Apple', 'Banana', 'Cherry'];
        $context['score'] = 75;
        $context['description'] = '  This is a description with some extra spaces.  ';
        return $context;
    }

    public function add_to_twig($twig)
    {
        $twig->addExtension(new Twig\Extension\StringLoaderExtension());
        return $twig;
    }
}

new MySite();

