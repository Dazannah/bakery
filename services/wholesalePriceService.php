<?php
require_once "./interfaces/IWholesalePriceService.php";
require_once "./dtos/WholesalPriceDTO.php";

class WholesalePriceService implements IWholesalePriceService {
  private mysqli $db;

  public function __construct(mysqli $db) {
    $this->db = $db;
  }

  public function getSelectAllQuery(): string {
    return "SELECT WholesalePrice.id as id, Ingredients.name as name, WholesalePrice.amount as amount, Units.name as unitName, WholesalePrice.price as price FROM WholesalePrice
    INNER JOIN Ingredients ON Ingredients.id = WholesalePrice.ingredientId
    INNER JOIN Units on Units.id = WholesalePrice.unitId;";
  }

  public function getAll(): array {
    $query = $this->getSelectAllQuery();
    $queryResult = $this->db->query($query);

    /** @var WholesalePriceDTO[] */
    $wholesalePrices = [];
    while ($row = $queryResult->fetch_assoc())
      array_push($wholesalePrices, new WholesalePriceDTO($row["id"], $row["name"], $row["amount"], $row["unitName"], $row["price"]));

    return $wholesalePrices;
  }

  public function getBasePrices(): array {
    $wholesalePrices = $this->getAll();

    $basePrices = [];
    foreach ($wholesalePrices as $wholesalePrice) {
      if ($wholesalePrice->unitName == "l" || $wholesalePrice->unitName == "kg")
        $wholesalePrice->amount *= 1000;

      $basePrices[$wholesalePrice->name] = $wholesalePrice->price / $wholesalePrice->amount;
    }

    return $basePrices;
  }
}
