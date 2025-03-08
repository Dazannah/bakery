<?php

class Router {
  private static $instance;
  private $routes = [];
  private static $catchAllRoute = "/";

  private function __construct() {
  }

  protected function __clone() {
  }

  public static function getInstance() {
    if (!isset(self::$instance))
      self::$instance = new static();

    return self::$instance;
  }

  public function addRoute($route, $classAndFuncName) {
    if (isset($route) && isset($classAndFuncName)) {
      $this->routes[$route] = $classAndFuncName;
    } else {
      throw new Exception("Provide route and callback funcion");
    }
  }

  public function use() {
    if (isset($_SERVER["PATH_INFO"])) {
      if (isset($this->routes[$_SERVER["PATH_INFO"]])) {
        $object = new $this->routes[$_SERVER["PATH_INFO"]][0];
        $object->{$this->routes[$_SERVER["PATH_INFO"]][1]}();

        exit();
      }

      header('Location: ' . self::$catchAllRoute);
      exit();
    }

    $indexHtml = fopen("index.html", "r") or die("Unable to open file!");
    echo fread($indexHtml, filesize("index.html"));
    fclose($indexHtml);

    exit();
  }

  public static function setCatchAllRoute(string $route) {
    self::$catchAllRoute = $route;
  }
}
