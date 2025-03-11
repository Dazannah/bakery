<?php
require_once "./interfaces/IProfitService.php";
require_once "./interfaces/IWholesalePriceService.php";
require_once "./interfaces/IRecipeService.php";
require_once "./dtos/RecipeDTO.php";
require_once "./dtos/IngredientDTO.php";

class ProfitService implements IProfitService {
  private mysqli $db;
  private IIncomeService $incomeService;
  private IWholesalePriceService $wholesalePriceService;
  private IRecipeService $recipeService;

  public function __construct(mysqli $db, IIncomeService $incomeService, IWholesalePriceService $wholesalePriceService, RecipeService $recipeService) {
    $this->db = $db;
    $this->incomeService = $incomeService;
    $this->wholesalePriceService = $wholesalePriceService;
    $this->recipeService = $recipeService;
  }

  public function getLastWeekProfit(): int|float {
    $lastweekIncome = $this->incomeService->getLastWeekIncome();

    $query = "SELECT * FROM SalesOfLastWeek;";

    /** @var array<int, int> */
    $salesOfLastWeek = $this->db->query($query)->fetch_all();

    $recipeIds = [];
    foreach ($salesOfLastWeek as $sale) {
      array_push($recipeIds, $sale[0]);
    }

    $recipes = $this->recipeService->getRecipesByField("id", $recipeIds);

    return $this->calculateProfit($recipes, $salesOfLastWeek, $lastweekIncome);
  }

  public function calculateProfit(array $recipes, array $sales, int $income): int {
    $basePrices = $this->wholesalePriceService->getBasePrices();

    $lastWeekIngredientsCost = 0;
    foreach ($sales as $sale) {

      $ingredientCost = 0;
      foreach ($recipes[$sale[0]]->ingredients as $ingredient) {
        $ingredientCost += $basePrices[$ingredient->name] * $ingredient->amount;
      }

      $lastWeekIngredientsCost += $ingredientCost * $sale[1];
    }

    $result = $income - $lastWeekIngredientsCost;

    return $result; // minusz a végeredmény ellenőrizni
  }
}
