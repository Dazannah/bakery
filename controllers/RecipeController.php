<?php
require_once "./singletons/db.php";
require_once "./services/recipeService.php";
require_once "./interfaces/IRecipeService.php";

class RecipeController {
  private IRecipeService $recipeService;

  public function __construct() {
    $this->recipeService = new RecipeService(Database::getInstance());
  }

  public function threeColumn() {
    $threeColumn = $this->recipeService->getFreeColumn();
    echo json_encode($threeColumn);

    exit;
  }
}
