<?php

interface IRecipeService {
  public function getFreeColumn(): array;
  /** @return RecipeDTO[] */
  public function getRecipesByField(string $field, array $ids): array;
  /** @return  RecipeDTO[] */
  public function getAllRecipes(): array;
  public function getPrepareCost(RecipeDTO $recipe): int;
}
