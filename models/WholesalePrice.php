<?php
require_once "./interfaces/IModel.php";
require_once "./models/BaseModel.php";

class WholesalePrice extends BaseModel implements IModel {
  public int|null $id;
  public int $ingredientId;
  public int $amount;
  public int $unitId;
  public int $price;

  public function __construct(int $ingredientId, int $amount, int $unitID, int $price, int|null $id = null) {
    $this->id = $id;
    $this->ingredientId = $ingredientId;
    $this->amount = $amount;
    $this->unitId = $unitID;
    $this->price = $price;
  }

  public function getCreateSql(): string {
    return "INSERT INTO WholesalePrice(ingredientId, amount, unitId, price) VALUES('$this->ingredientId','$this->amount','$this->unitId','$this->price')";
  }
}
