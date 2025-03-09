<?php

require_once "./dtos/IngredientDTO.php";

class InventoryService implements IInventoryService {
  private IRecipeService $recipeService;
  private mysqli $db;

  public function __construct(mysqli $db, IRecipeService $recipeService) {
    $this->db = $db;
    $this->recipeService = $recipeService;
  }

  public function getInventory(): array {
    $query = "SELECT * FROM ";
  }

  public function getMaxProducableFromInventory() {
    $allRecipes = $this->recipeService->getAllRecipes();

    return $allRecipes;
  }
}
