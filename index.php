<?php
require_once "./singletons/router.php";
require_once "./services/startingDataService.php";

require_once "./controllers/IncomeController.php";

StartingDataService::addProvidedData();

$router = Router::getInstance();

$router->addRoute("/last-week-income", [IncomeController::class, "lastWeekIncome"]);

Router::setCatchAllRoute("/404");
$router->addRoute("/404", function () {
  echo "Url not found";
});

$router->use();
