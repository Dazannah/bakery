<?php

class IngredientDTO {
  public int $id;
  public string $name;
  public int $amount;
  public string $unitName;

  public function __construct(int $id, string $name, int $amount, string $unitName) {
    $this->id = $id;
    $this->name = $name;
    $this->amount = $amount;
    $this->unitName = $unitName;
  }
}
