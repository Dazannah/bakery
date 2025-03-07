<?php
require_once "./singletons/db.php";
require_once "./models/Ingredient.php";
require_once "./models/Unit.php";

class StartingDataService {
  public static function addProvidedData() {
    $dataLocation = "data.json";
    $dataFile = fopen($dataLocation, "r") or die("Unable to open config file!");
    $data = json_decode(fread($dataFile, filesize($dataLocation)));

    $db = Database::getInstance();

    $duplicateRegexp = "/duplicate/i";

    foreach ($data->inventory as $inventory) {
      $ingredient = new Ingredient($inventory->name);
      $sql = $ingredient->getCreateSql();

      try {
        $db->query($sql);
      } catch (Exception $ex) {
        if (!preg_match($duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }

    $dataLocation = "units.json";
    $dataFile = fopen($dataLocation, "r") or die("Unable to open units file!");
    $data = json_decode(fread($dataFile, filesize($dataLocation)));

    foreach ($data as $unit) {
      $unit = new Unit($unit);
      $sql = $unit->getCreateSql();

      try {
        $db->query($sql);
      } catch (Exception $ex) {
        if (!preg_match($duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }
  }
}
