<?php
require_once "./interfaces/IProfitService.php";

class ProfitService implements IProfitService {
  private mysqli $db;
  private IIncomeService $incomeService;

  public function __construct(mysqli $db, IIncomeService $incomeService) {
    $this->db = $db;
    $this->incomeService = $incomeService;
  }

  public function getLastWeekProfit(): int {
    $lastweekIncome = $this->incomeService->getLastWeekIncome();

    $query = "SELECT sum(amount) as lastWeekIncome FROM SalesOfLastWeek;";
    $result = $this->db->query($query);

    //recepteket lekérni, és össze számolni az alapanyagokat

    // bevétel-alapanyag_költség

    return $lastweekIncome;
  }
}
