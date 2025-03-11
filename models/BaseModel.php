<?php
require_once "./singletons/db.php";

abstract class BaseModel {
  public int|null $id;

  public abstract function getCreateSql(): string;

  public function create(): void {
    $db = Database::getInstance();
    $queryString = $this->getCreateSql();

    $db->query($queryString);

    $this->id = $db->insert_id;
  }
}
