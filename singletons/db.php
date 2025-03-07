<?php

class Database {
  private static $instance;
  private $connection;

  private function __construct() {
    $config_location = "./config.json";
    $config_raw = fopen($config_location, "r") or die("Unable to open config file!");
    $config = json_decode(fread($config_raw, filesize($config_location)));

    $servername = $config->database->servername;
    $username = $config->database->username;
    $password = $config->database->password;
    $database = $config->database->database;
    $port = $config->database->port;

    $this->connection = new mysqli($servername, $username, $password, $database, $port);

    if ($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
  }

  private function __destruct() {
    $this->connection->close();
  }

  protected function __clone() {
  }

  public static function getInstance() {
    if (!isset(self::$instance))
      self::$instance = new static();

    return self::$instance;
  }
}
