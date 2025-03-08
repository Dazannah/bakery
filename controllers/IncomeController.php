<?php
require_once "./singletons/db.php";
require_once "./services/incomeService.php";
require_once "./interfaces/IIncomeService.php";

class IncomeController {
  private IIncomeService $incomeService;

  public function __construct() {
    $this->incomeService = new IncomeService(Database::getInstance());
  }

  public function lastWeekIncome(): void {
    $lastWeekIncome = $this->incomeService->getLastWeekIncome();
    echo json_encode($lastWeekIncome);

    exit;
  }
}
