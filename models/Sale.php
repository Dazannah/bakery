<?php
require_once "./interfaces/IModel.php";
require_once "./models/BaseModel.php";

class Sale extends BaseModel implements IModel {
  public int|null $id;
  public int $recipeID;
  public int $amount;

  public function __construct(int $recipeID, int $amount, int|null $id = null) {
    $this->id = $id;
    $this->recipeID = $recipeID;
    $this->amount = $amount;
  }

  public function getCreateSql(): string {
    return "INSERT INTO SalesOfLastWeek(recipeId, amount) VALUES ('$this->recipeID', '$this->amount')";
  }
}
