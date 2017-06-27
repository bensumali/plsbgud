<?php
require_once('vendor/autoload.php');
require_once('obj/event.obj.php');
use JonnyW\PhantomJs\Client;
$client = Client::getInstance();
// $client->getEngine()->setPath('/path/to/phantomjs');
$request = $client->getMessageFactory()->createRequest('https://inffuse-calendar2.appspot.com/widget.html?cacheKiller=1498441000625&compId=comp-ixt9q2cr&deviceType=desktop&height=537&instance=zjyeIuPB8EDoxyW77K3efLabqZnJmIOftIfoH0kGLF4.eyJpbnN0YW5jZUlkIjoiOTAxZDc5YTYtZjQyNi00OTI5LWIwNGItMDY3M2NmMDRiNjQzIiwic2lnbkRhdGUiOiIyMDE3LTA2LTI2VDAxOjMxOjUzLjkxNloiLCJ1aWQiOm51bGwsImlwQW5kUG9ydCI6IjY4LjQuMjU0LjIwNC8yMzcwMSIsInZlbmRvclByb2R1Y3RJZCI6InByZW1pdW0iLCJkZW1vTW9kZSI6ZmFsc2UsImFpZCI6ImRjNGY4ODk5LWQ1YjYtNDJiNi05YjcxLTZhNTE1YTUwMzZlOCIsInNpdGVPd25lcklkIjoiNWYyZmE4NTItMjRmYy00YTZkLWIzZDAtOGEyYTM5NzJmN2VjIn0&locale=en&pageId=f3zum&viewMode=site&vsi=3f8f9788-4f58-4794-af10-d085cd054f40&width=520', 'GET');
$request->setDelay(5);
$response = $client->getMessageFactory()->createResponse();
$client->send($request, $response);
if($response->getStatus() === 200 || $response->getStatus() === 301) {

    $monthArray = array();
    $monthArray["jan"] = "01";
    $monthArray["feb"] = "02";
    $monthArray["mar"] = "03";
    $monthArray["apr"] = "04";
    $monthArray["may"] = "05";
    $monthArray["jun"] = "06";
    $monthArray["jul"] = "07";
    $monthArray["aug"] = "08";
    $monthArray["sep"] = "09";
    $monthArray["oct"] = "10";
    $monthArray["nov"] = "11";
    $monthArray["dec"] = "12";

    $initialMonth = Date("m");
    $initialYear = Date("Y");
    $nextYear = (string)(intval($initialYear) + 1);

    // Dump the requested page content
    $html = $response->getContent();
    $dom = new DomDocument();
    $dom->loadHTML($html);
    $finder = new DomXPath($dom);
    $classname="day ng-scope";
    $eventHtml = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
    // echo $html;
    foreach($eventHtml as $e) {
      $dateMonth;
      $dateDay;
      $eventName = "N/A";
      $eventLocation = "N/A";
      $eventTime;
      $innerValue = $e->nodeValue;
      $innerValueArray = explode("\n", $innerValue);
      $i = 0;
      foreach($innerValueArray as $d) {
        $d = trim($d);
        if($d !== "" && $d) {
          if($i == 0) { // It means that this is the month
            $dateMonth = $d;
          }
          else if($i == 1) {
            $dateDay = $d;
            if(strlen($dateDay) == 1)
              $dateDay = "0" . $dateDay;
          }
          else if($i == 3) {
            $eventName = $d;
          }
          else if($i == 4) {
            print_r($d);
            $time = explode("-", $d);
            $eventTimes = array();
            for($k = 0; $k < count($time); $k++) {
              $timeStr = substr($time[$k], 0, -2);
              $timeArr = explode(":", $timeStr);
              $hour = $timeArr[0];
              if(strlen($hour) == 1) {
                $hour = "0" . $hour;
              }
              $mins = $timeArr[1];
              $ampm = strtolower(substr($time[$k], -2));
              if($hour === "12" || $ampm === "pm") {
                $eventTimes[$k] = (string)(intval($hour) + 12) . ":$mins:00";
              }
              else {
                $eventTimes[$k] = $hour . ":$mins:00";
              }
            }
          }
          else if($i == 5) {
            $eventLocation = $d;
            // Properly format the date
            if(intval($initialMonth) <= intval($dateMonth)) {
              $dateYear = $nextYear;
            }
            else {
              $dateYear = $initialYear;
            }
            $eventDate = $dateYear . "-" . $monthArray[strtolower($dateMonth)] . "-" . $dateDay . " ";
            $eventDateStart = $eventDate . $eventTimes[0];
            $eventDateEnd = $eventDate . $eventTimes[1];
            $event = new Event($eventName, $eventDateStart, $eventDateEnd, $eventLocation);
            print_r($event);
            break;
          }
          $i++;
        }
      }
      // print_r($innerValueArray);
    }
}
else {

}
?>
