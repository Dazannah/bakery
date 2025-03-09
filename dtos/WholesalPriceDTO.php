<?php
class WholesalePriceDTO {
  public int $id;
  public string $name;
  public int $amount;
  public string $unitName;
  public int $price;

  public function __construct(int $id, string $name, int $amount, string $unitName, int $price) {
    $this->id = $id;
    $this->name = $name;
    $this->amount = $amount;
    $this->unitName = $unitName;
    $this->price = $price;
  }
}
