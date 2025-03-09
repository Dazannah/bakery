<?php
require_once "./interfaces/IIncomeService.php";

class IncomeService implements IIncomeService {
  private mysqli $db;

  public function __construct(mysqli $db) {
    $this->db = $db;
  }

  public function getLastWeekIncome(): int {
    $query = "SELECT sum(SalesOfLastWeek.amount * Recipes.price) as lastWeekIncome FROM SalesOfLastWeek
    INNER JOIN Recipes on Recipes.id = SalesOfLastWeek.recipeId;";
    $queryResult = $this->db->query($query);

    return $queryResult->fetch_assoc()["lastWeekIncome"];
  }
}
