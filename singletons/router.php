<?php

class Router {
  private static $instance;
  private $routes = [];

  private function __construct() {
  }

  protected function __clone() {
  }

  public static function getInstance() {
    if (!isset(self::$instance))
      self::$instance = new static();

    return self::$instance;
  }

  public function addRoute($route, $callback) {
    if (isset($route) && isset($callback)) {
      $this->routes[$route] = $callback;
    } else {
      throw new Exception("Provide route and callback funcion");
    }
  }

  public function use() {
    if (isset($_SERVER["PATH_INFO"])) {
      if (isset($this->routes[$_SERVER["PATH_INFO"]])) {
        $this->routes[$_SERVER["PATH_INFO"]]();
        exit();
      }

      header('Location: /');
      exit();
    }

    $indexHtml = fopen("index.html", "r") or die("Unable to open file!");
    echo fread($indexHtml, filesize("index.html"));
    fclose($indexHtml);

    exit();
  }
}
