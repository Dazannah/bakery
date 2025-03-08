<?php
require_once "./singletons/router.php";
require_once "./services/startingDataService.php";

StartingDataService::addProvidedData();

$router = Router::getInstance();

// $router->addRoute("/test", function () {
//   echo "this is from the function";
// });

$router->use();
