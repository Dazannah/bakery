<?php
require_once "./interfaces/IProfitService.php";

class ProfitService implements IProfitService {
  private mysqli $db;
  private IIncomeService $incomeService;

  public function __construct(mysqli $db, IIncomeService $incomeService) {
    $this->db = $db;
    $this->incomeService = $incomeService;
  }

  public function getLastWeekProfit(): array {
    $lastweekIncome = $this->incomeService->getLastWeekIncome();

    $query = "SELECT * FROM SalesOfLastWeek;";
    $salesOfLastWeek = $this->db->query($query)->fetch_all();

    $idsString = "";
    foreach ($salesOfLastWeek as $key => $sale) {
      $idsString .= "$sale[0]";
      if ($key < count($salesOfLastWeek) - 1)
        $idsString .= ",";
    }

    $query = "SELECT * FROM Recipes WHERE id in ($idsString);";
    $rawRecipes = $this->db->query($query)->fetch_all();

    $recipes = [];
    foreach ($rawRecipes as $rawRecipe) {
      $query = "SELECT Ingredients.name as name, RecipesIngredients.amount as amount, Units.name as unitName FROM RecipesIngredients
      INNER JOIN Ingredients ON RecipesIngredients.ingredientId = Ingredients.id
      INNER JOIN Units ON RecipesIngredients.unitId = Units.id
      WHERE RecipesIngredients.recipeId = '$rawRecipe[0]'";
      $rawRecipesResult = $this->db->query($query);

      $ingredients = [];

      while ($row = $rawRecipesResult->fetch_assoc()) {
        array_push($ingredients, $row);
      }

      $recipes[$rawRecipe[0]] = new Recipe($rawRecipe[1], $rawRecipe[2], $rawRecipe[3], $rawRecipe[4], $rawRecipe[0]);
      $recipes[$rawRecipe[0]]->ingredients = $ingredients; // modelel meg csinálni!!
    }
    //recepteket lekérni, és össze számolni az alapanyagokat

    // bevétel-alapanyag_költség

    $result = $salesOfLastWeek;

    return $recipes;
  }
}
