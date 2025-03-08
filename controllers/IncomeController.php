<?php
require_once "./services/incomeService.php";
require_once "./interfaces/IIncomeService.php";

class IncomeController {
  private IIncomeService $incomeService;

  public function __construct() {
    $this->incomeService = new IncomeService();
  }

  public function lastWeekIncome(): string {
    $lastWeekIncome = $this->incomeService->getLastWeekIncome();

    return json_encode($lastWeekIncome);
  }
}
