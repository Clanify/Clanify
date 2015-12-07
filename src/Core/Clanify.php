<?php
/**
 * Namespace for all core functions of Clanify.
 * @since 0.0.1-dev
 */
namespace Clanify\Core;

/**
 * Class Clanify
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Core
 * @version 0.0.1-dev
 */
class Clanify
{
    /**
     * The controller which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    protected $controller = 'Index';

    /**
     * The method of the controller which will be used.
     * @since 0.0.1-dev
     * @var string
     */
    protected $method = 'index';

    /**
     * The parameters which will be passed to the method of the controller.
     * @since 0.0.1-dev
     * @var array
     */
    protected $params = [];

    /**
     * Clanify constructor to initialize Clanify.
     * @since 0.0.1-dev
     */
    public function __construct()
    {
        //parse the url to get the controller, method and parameters.
        $url = $this->parseUrl();

        //check if a controller exists.
        if (isset($url[0]) && file_exists('../src/Controller/'.$this->normalize($url[0]).'Controller.php')) {
            $this->controller = $this->normalize($url[0]);
            unset($url[0]);
        }

        //get the full controller class name and initialize the controller.
        $controller = 'Clanify\\Controller\\'.$this->controller.'Controller';
        $this->controller = new $controller;

        //check if a method was set to the url.
        if (isset($url[1]) && method_exists($this->controller, $this->normalize($url[1], true))) {
            $this->method = $this->normalize($url[1], true);
            unset($url[1]);
        }

        //get the parameters from the url and call the controller method.
        $this->params = (count($url) > 0) ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Method to normalize a value to use with controller and method.
     * @param string $value The value which will be normalized.
     * @param bool|false $isMethod The state if the value is a method.
     * @return string The normalized value.
     * @since 0.0.1-dev
     */
    private function normalize($value, $isMethod = false)
    {
        //reset the normalized value.
        $normalized = '';

        //run through all parts of the value.
        foreach (explode('_', strtolower($value)) as $item) {
            $normalized .= ucfirst($item);
        }

        //return the normalized value.
        return ($isMethod) ? lcfirst($normalized) : $normalized;
    }

    /**
     * Method to parse the url to get the parts (controller, method and parameters).
     * @return array
     * @since 0.0.1-dev
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function parseUrl()
    {
        return (isset($_GET['url'])) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : [];
    }
}