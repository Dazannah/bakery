<?php
require_once "./interfaces/IRecipeService.php";

class RecipeService implements IRecipeService {
  private mysqli $db;

  public function __construct(mysqli $db) {
    $this->db = $db;
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

  public function getRecipesByIds(array $ids): array {
    $idsString = "";
    foreach ($ids as $key => $id) {
      $idsString .= "$id";
      if ($key < count($ids) - 1)
        $idsString .= ",";
    }

    $query = "SELECT * FROM Recipes WHERE id in ($idsString);";
    $rawRecipes = $this->db->query($query)->fetch_all();

    $recipes = [];
    foreach ($rawRecipes as $rawRecipe) {
      $query = "SELECT Ingredients.id as id, Ingredients.name as name, RecipesIngredients.amount as amount, Units.name as unitName FROM RecipesIngredients
      INNER JOIN Ingredients ON RecipesIngredients.ingredientId = Ingredients.id
      INNER JOIN Units ON RecipesIngredients.unitId = Units.id
      WHERE RecipesIngredients.recipeId = '$rawRecipe[0]'";
      $rawIngredientsResult = $this->db->query($query);

      $ingredients = [];

      while ($row = $rawIngredientsResult->fetch_assoc()) {
        array_push($ingredients, new IngredientDTO($row["id"], $row["name"], $row["amount"], $row["unitName"]));
      }

      $recipes[$rawRecipe[0]] = new RecipeDTO($rawRecipe[1], $rawRecipe[2], $rawRecipe[3], $rawRecipe[4], $rawRecipe[0], $ingredients);
    }

    return $recipes;
  }
}
