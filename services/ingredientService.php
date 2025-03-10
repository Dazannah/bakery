<?php

require_once "./interfaces/IIngredientService.php";

class IngredientService implements IIngredientService {
  private mysqli $db;

  public function __construct(mysqli $db) {
    $this->db = $db;
  }

  public function getIngredientsByRecipeId(int $recipeId): array {
    $query = "SELECT Ingredients.id as id, Ingredients.name as name, Ingredients.inventory as inventory, RecipesIngredients.amount as amount, Units.name as unitName FROM RecipesIngredients
    INNER JOIN Ingredients ON RecipesIngredients.ingredientId = Ingredients.id
    INNER JOIN Units ON RecipesIngredients.unitId = Units.id
    WHERE RecipesIngredients.recipeId = '$recipeId'";
    $rawIngredientsResult = $this->db->query($query);

    $ingredients = [];

    while ($row = $rawIngredientsResult->fetch_assoc()) {
      array_push($ingredients, new IngredientDTO($row["id"], $row["name"], $row["amount"], $row["unitName"], $row["inventory"]));
    }

    return $ingredients;
  }
}
