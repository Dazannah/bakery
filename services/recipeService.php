<?php
require_once "./interfaces/IIngredientService.php";

class RecipeService implements IRecipeService {
  private mysqli $db;
  private IIngredientService $ingredientService;
  private IWholesalePriceService $wholesalePriceService;

  public function __construct(mysqli $db, IIngredientService $ingredientService, IWholesalePriceService $wholesalePriceService) {
    $this->db = $db;
    $this->ingredientService = $ingredientService;
    $this->wholesalePriceService = $wholesalePriceService;
  }

  public function getFreeColumn(): array {
    $lactoseFreeQuery = "SELECT name, price FROM Recipes WHERE lactoseFree = 1;";
    $glutenFreeQuery = "SELECT name, price FROM Recipes WHERE glutenFree = 1;";
    $lactoseAndGlutenFreeQuery = "SELECT name, price FROM Recipes WHERE glutenFree = 1 AND lactoseFree = 1;";

    $lactoseFreeResult = $this->db->query($lactoseFreeQuery);
    $glutenFreeResult = $this->db->query($glutenFreeQuery);
    $lactoseAndGlutenFreeResult = $this->db->query($lactoseAndGlutenFreeQuery);

    return ["lactoseFree" => $lactoseFreeResult->fetch_all(), "glutenFree" => $glutenFreeResult->fetch_all(), "glutenAndLactoseFree" => $lactoseAndGlutenFreeResult->fetch_all()];
  }

  /** @return  RecipeDTO[] */
  public function getRecipesByField(string $field, array $ids): array {
    $idsString = "";
    foreach ($ids as $key => $id) {
      $idsString .= "'$id'";
      if ($key < count($ids) - 1)
        $idsString .= ",";
    }
    $where = "WHERE $field in ($idsString)";

    return $this->getRecipesBase($where);
  }

  /** @return  RecipeDTO[] */
  public function getAllRecipes(): array {
    return $this->getRecipesBase();
  }

  /** @return  RecipeDTO[] */
  private function getRecipesBase(string $where = ""): array {
    $query = "SELECT * FROM Recipes $where;";
    $rawRecipes = $this->db->query($query)->fetch_all();

    $recipes = [];
    foreach ($rawRecipes as $rawRecipe) {
      $ingredients = $this->ingredientService->getIngredientsByRecipeId($rawRecipe[0]);

      $recipes[$rawRecipe[0]] = new RecipeDTO($rawRecipe[1], $rawRecipe[2], $rawRecipe[3], $rawRecipe[4], $rawRecipe[0], $ingredients);
    }

    return $recipes;
  }

  public function getPrepareCost(RecipeDTO $recipe): int {
    $basePrices = $this->wholesalePriceService->getBasePrices();

    $cost = 0;
    foreach ($recipe->ingredients as $ingredient) {
      $cost += $basePrices[$ingredient->name] * $ingredient->amount;
    }

    return $cost;
  }
}
