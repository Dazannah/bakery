<?php
require_once "./interfaces/IOrderService.php";
require_once "./services/orderService.php";
require_once "./services/recipeService.php";
require_once "./services/ingredientService.php";

class OrderController {
  private IOrderService $orderService;

  public function __construct() {
    $this->orderService = new OrderService(
      Database::getInstance(),
      new RecipeService(
        Database::getInstance(),
        new IngredientService(Database::getInstance()),
        new WholesalepriceService(Database::getInstance())
      )
    );
  }

  public function calculateOrderPriceAndProfit() {
    $json = file_get_contents('php://input');
    $order = json_decode($json, true);

    $result = $this->orderService->calculateOrderPriceAndProfit($order);

    echo json_encode($result);

    exit;
  }
}
