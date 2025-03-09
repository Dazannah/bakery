<?php
require_once "./singletons/router.php";
require_once "./services/startingDataService.php";

require_once "./controllers/IncomeController.php";
require_once "./controllers/ProfitController.php";
require_once "./controllers/RecipeController.php";
require_once "./controllers/InventoryController.php";

StartingDataService::addProvidedData();

$router = Router::getInstance();

$router->addRoute("/last-week-income", [IncomeController::class, "lastWeekIncome"]);
$router->addRoute("/last-week-profit", [ProfitController::class, "lastWeekProfit"]);
$router->addRoute("/three-column", [RecipeController::class, "threeColumn"]);
$router->addRoute("/max-producable", [InventoryController::class, "getMaxProducableFromInventory"]);

Router::setCatchAllRoute("/404");
$router->addRoute("/404", function () {
  echo "Url not found";
});

$router->use();
