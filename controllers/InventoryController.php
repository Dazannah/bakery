<?php
require_once "./interfaces/IInventoryService.php";
require_once "./services/inventoryService.php";

class InventoryController {
  private IInventoryService $inventoryService;

  public function __construct() {
    $this->inventoryService = new InventoryService(new RecipeService(Database::getInstance(), new IngredientService(Database::getInstance())));
  }

  public function getMaxProducableFromInventory() {
    $maxProducable = $this->inventoryService->getMaxProducableFromInventory();
    echo json_encode($maxProducable);

    exit;
  }
}
