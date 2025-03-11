 <?php
  require_once "./interfaces/IModel.php";
  require_once "./models/BaseModel.php";

  class RecipeIngredient extends BaseModel implements IModel {
    public int $recipeId;
    public int $ingredientId;
    public int $amount;
    public int $unitId;

    public function __construct(int $recipeId, int $ingredientId, int $amount, int $unitId) {
      $this->recipeId = $recipeId;
      $this->ingredientId = $ingredientId;
      $this->amount = $amount;
      $this->unitId = $unitId;
    }

    public function getCreateSql(): string {
      return "INSERT INTO RecipesIngredients(recipeId,ingredientId,amount,unitId) VALUES('$this->recipeId', '$this->ingredientId', '$this->amount', '$this->unitId')";
    }
  }
