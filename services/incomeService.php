<?php
require_once "./interfaces/IIncomeService.php";

class IncomeService implements IIncomeService {
  public function getLastWeekIncome(): int {
    return 500;
  }
}
