<?php

require_once "./dtos/IngredientDTO.php";

class InventoryService implements IInventoryService {
  private IRecipeService $recipeService;

  public function __construct(IRecipeService $recipeService) {
    $this->recipeService = $recipeService;
  }

  public function getMaxProducableFromInventory(): array {
    $allRecipes = $this->recipeService->getAllRecipes();

    $result = [];

    foreach ($allRecipes as $recipe) {
      $smallest = PHP_INT_MAX;
      foreach ($recipe->ingredients as $ingredient) {
        $num = floor($ingredient->inventory / $ingredient->amount);

        if ($num < $smallest)
          $smallest = $num;
      }

      array_push($result, array($recipe->name, $smallest));
    }


    return $result;
  }
}
