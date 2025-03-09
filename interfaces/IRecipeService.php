<?php

interface IRecipeService {
  public function getFreeColumn(): array;
  /** @return RecipeDTO[] */
  public function getRecipesByIds(array $id): array;
  /** @return  RecipeDTO[] */
  public function getAllRecipes(): array;
}
