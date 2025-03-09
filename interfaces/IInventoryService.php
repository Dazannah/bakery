<?php

interface IInventoryService {
  /** @return IngredientDTO[] */
  public function getInventory(): array;
  public function getMaxProducableFromInventory();
}
