<?php

interface IInventoryService {
  /** @return IngredientDTO[] */
  public function getMaxProducableFromInventory(): array;
}
