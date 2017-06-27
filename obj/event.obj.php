<?php


// require_once("db/config.db.php");
class Event {
    private $dateStart;
    private $dateEnd;
    private $name;
    private $location;

    function Event($name, $dateStart, $dateEnd, $location) {
      $this->dateStart = $dateStart;
      $this->dateEnd = $dateEnd;
      $this->name = $name;
      $this->location = $location;
    }

    function getDateStart() {
      return $this->dateStart;
    }
    function getDateEnd() {
      return $this->dateEnd;
    }
    function getName() {
      return $this->name;
    }
    function getLocation() {
      return $this->location;
    }
    function setDateStart($dateStart) {
      $this->dateStart = $dateStart;
    }
    function setDateEnd($dateEnd) {
      $this->dateEnd = $dateEnd;
    }
    function setName($name) {
      $this->name = $name;
    }
    function setLocation($location) {
      $this->location = $location;
    }
}



?>
