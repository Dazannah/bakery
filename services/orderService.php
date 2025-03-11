<?php
require_once "./interfaces/IRecipeService.php";

class OrderService implements IOrderService {
  private mysqli $db;
  private IRecipeService $recipeService;

  public function __construct(mysqli $db, IRecipeService $recipeService) {
    $this->db = $db;
    $this->recipeService = $recipeService;
  }

  public function calculateOrderPriceAndProfit(array $order): array {
    $recipesToGet = [];
    foreach ($order as $key => $recipeName)
      array_push($recipesToGet, $key);

    $recipes = $this->recipeService->getRecipesByField("name", $recipesToGet);

    $orderPrice = 0;
    $income = 0;
    foreach ($recipes as $recipe) {
      $orderPrice += $order[$recipe->name] * $this->recipeService->getPrepareCost($recipe);
      $income += $order[$recipe->name] * $recipe->price;
    }

    $result["orderPrice"] = $orderPrice;
    $result["orderProfit"] = $income - $orderPrice;

    return $result;
  }
}
