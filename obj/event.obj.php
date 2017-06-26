<?php


// require_once("db/config.db.php");
class Event {
    private $date;
    private $name;
    private $location;

    function Event($name, $date, $location) {
      $this->date = $date;
      $this->name = $name;
      $this->location = $location;
    }

    function getDate() {
      return $this->date;
    }
    function getName() {
      return $this->name;
    }
    function getLocation() {
      return $this->location;
    }
    function setDate($date) {
      $this->date = $date;
    }
    function setName($name) {
      $this->name = $name;
    }
    function setLocation($location) {
      $this->location = $location;
    }
}



?>
