<?php
require_once "./interfaces/IIncomeService.php";

class IncomeService implements IIncomeService {
  private mysqli $db;

  public function __construct(mysqli $db) {
    $this->db = $db;
  }

  public function getLastWeekIncome(): int {
    $query = "SELECT sum(amount) as lastWeekIncome FROM SalesOfLastWeek;";
    $result = $this->db->query($query);

    return $result->fetch_assoc()['lastWeekIncome'];
  }
}
