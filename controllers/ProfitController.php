<?php
require_once "./singletons/db.php";
require_once "./services/profitService.php";
require_once "./services/profitService.php";
require_once "./services/wholesalePriceService.php";

class ProfitController {
  private IProfitService $profitService;

  public function __construct() {
    $this->profitService = new ProfitService(
      Database::getInstance(),
      new IncomeService(Database::getInstance()),
      new WholesalePriceService(Database::getInstance()),
      new RecipeService(Database::getInstance())
    );
  }

  public function lastWeekProfit(): void {
    $lastWeekProfit = $this->profitService->getLastWeekProfit();
    echo json_encode($lastWeekProfit);

    exit;
  }
}
