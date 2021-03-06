<?php
namespace App\Controller;
use App\Controller\Extension\PhpMvcExtension;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
/**
 * Class MainController
 * Manages the Main Features
 */
abstract class MainController
{
    /**
     * Environment
     */
    protected $twig = null;
    /**
     * MainController constructor
     * Creates the Template Engine & adds its Extensions (Debug and custom extension).
     */
    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader('../src/View'), array(
            'cache' => false,
            'debug' => true
        ));
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new PhpMvcExtension());
    }
    /**
     * Returns the Page URL
     */
    public function url(string $page, array $params = [])
    {
        $params['access'] = $page;
        return 'index.php?' . http_build_query($params);
    }
    /**
     * Redirects to another URL
     */
    public function redirect(string $page, array $params = [])
    {
        header('Location: ' . $this->url($page, $params));
        exit;
    }
    /**
     * Renders the Views
     */
    public function render(string $view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }
}