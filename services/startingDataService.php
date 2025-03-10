<?php
require_once "./singletons/db.php";
require_once "./models/Ingredient.php";
require_once "./models/Unit.php";
require_once "./models/Recipe.php";
require_once "./models/RecipeIngredient.php";
require_once "./models/Sale.php";
require_once "./models/WholesalePrice.php";

class StartingDataService {
  public static function addProvidedData() {
    $db = Database::getInstance();

    $duplicateRegexp = "/duplicate/i";

    $unitsLocation = "units.json";
    $unitsFile = fopen($unitsLocation, "r") or die("Unable to open units file!");
    $unitsJson = json_decode(fread($unitsFile, filesize($unitsLocation)));

    $units = [];
    //save units into database
    foreach ($unitsJson as $unit) {
      $unit = new Unit($unit);
      $sql = $unit->getCreateSql();

      try {
        $db->query($sql);

        $unit->id = $db->insert_id;
        $units[$unit->name] = $unit;
      } catch (Exception $ex) {
        if (!preg_match($duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }

    $dataLocation = "data.json";
    $dataFile = fopen($dataLocation, "r") or die("Unable to open config file!");
    $data = json_decode(fread($dataFile, filesize($dataLocation)));

    $ingredients = [];
    //save ingredients into database
    foreach ($data->inventory as $inventory) {
      $explodedAmount = explode(" ", $inventory->amount);

      if (!isset($units[$explodedAmount[1]]))
        continue;
      if ($explodedAmount[1] == "kg" || $explodedAmount[1] == "l") {
        $explodedAmount[0] *= 1000;
        $explodedAmount[1] = $explodedAmount[1] == "kg" ? "g" : "ml";
      }

      $ingredient = new Ingredient($inventory->name, $explodedAmount[0], $units[$explodedAmount[1]]->id);
      $sql = $ingredient->getCreateSql();

      try {
        $db->query($sql);
        $ingredient->id = $db->insert_id;

        $ingredients[$ingredient->name] = $ingredient;
      } catch (Exception $ex) {
        if (!preg_match($duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }



    $recipes = [];
    //save recipes into database
    foreach ($data->recipes as $recipe) {
      $newRecipe = new Recipe($recipe->name, explode(" ", $recipe->price)[0], $recipe->lactoseFree, $recipe->glutenFree);
      $sql = $newRecipe->getCreateSql();


      try {
        $db->query($sql);
        $newRecipe->id = $db->insert_id;
        $recipes[$newRecipe->name] = $newRecipe;

        //save recipeIngredients into database
        foreach ($recipe->ingredients as $ingredient) {
          $explodedUnit = explode(" ", $ingredient->amount);
          $newRecipeIngredient = new RecipeIngredient($newRecipe->id, $ingredients[$ingredient->name]->id, $explodedUnit[0], $units[$explodedUnit[1]]->id);
          $sql = $newRecipeIngredient->getCreateSql();

          try {
            $db->query($sql);
          } catch (Exception $ex) {
            if (!preg_match($duplicateRegexp, $ex->getMessage()))
              echo $ex->getMessage() . "<br/>";
          }
        }

        $db->insert_id;
      } catch (Exception $ex) {
        if (!preg_match($duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }

    //save salesOfLastWeek into database
    foreach ($data->salesOfLastWeek as $sale) {
      if (!isset($recipes[$sale->name]))
        continue;

      $recipeId = $recipes[$sale->name]->id;
      $newSale = new Sale($recipeId, $sale->amount);
      $sql = $newSale->getCreateSql();

      try {
        $db->query($sql);
      } catch (Exception $ex) {
        if (!preg_match($duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }

    //save wholesalePrices into database
    foreach ($data->wholesalePrices as $wholesalePrice) {
      $explodedUnit = explode(" ", $wholesalePrice->amount);
      if (!isset($ingredients[$wholesalePrice->name]) || !isset($units[$explodedUnit[1]]))
        continue;

      $newWholesalePrice = new WholesalePrice($ingredients[$wholesalePrice->name]->id, $explodedUnit[0], $units[$explodedUnit[1]]->id, $wholesalePrice->price);
      $sql = $newWholesalePrice->getCreateSql();

      try {
        $db->query($sql);
      } catch (Exception $ex) {
        if (!preg_match($duplicateRegexp, $ex->getMessage()))
          echo $ex->getMessage() . "<br/>";
      }
    }
  }
}
