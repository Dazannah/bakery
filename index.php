<?php
require_once "./singletons/router.php";
require_once "./services/startingDataService.php";

require_once "./controllers/IncomeController.php";
require_once "./controllers/ProfitController.php";
require_once "./controllers/RecipeController.php";
require_once "./controllers/InventoryController.php";
require_once "./controllers/OrderController.php";

const CONFIG_FILE_LOCATION = "./data.json";

StartingDataService::addProvidedData(CONFIG_FILE_LOCATION);

$router = Router::getInstance();

$router->addRoute("/last-week-income", [IncomeController::class, "lastWeekIncome"]);
$router->addRoute("/last-week-profit", [ProfitController::class, "lastWeekProfit"]);
$router->addRoute("/three-column", [RecipeController::class, "threeColumn"]);
$router->addRoute("/max-producable", [InventoryController::class, "getMaxProducableFromInventory"]);
$router->addRoute("/calculate-order-price", [OrderController::class, "calculateOrderPriceAndProfit"]);

Router::setCatchAllRoute("/404");
$router->addRoute("/404", function () {
  echo "Url not found";
});

$router->use();
