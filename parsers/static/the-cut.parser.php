<?php
require_once('vendor/autoload.php');
use JonnyW\PhantomJs\Client;
$client = Client::getInstance();
// $client->getEngine()->setPath('/path/to/phantomjs');
$request = $client->getMessageFactory()->createRequest('https://inffuse-calendar2.appspot.com/widget.html?cacheKiller=1498441000625&compId=comp-ixt9q2cr&deviceType=desktop&height=537&instance=zjyeIuPB8EDoxyW77K3efLabqZnJmIOftIfoH0kGLF4.eyJpbnN0YW5jZUlkIjoiOTAxZDc5YTYtZjQyNi00OTI5LWIwNGItMDY3M2NmMDRiNjQzIiwic2lnbkRhdGUiOiIyMDE3LTA2LTI2VDAxOjMxOjUzLjkxNloiLCJ1aWQiOm51bGwsImlwQW5kUG9ydCI6IjY4LjQuMjU0LjIwNC8yMzcwMSIsInZlbmRvclByb2R1Y3RJZCI6InByZW1pdW0iLCJkZW1vTW9kZSI6ZmFsc2UsImFpZCI6ImRjNGY4ODk5LWQ1YjYtNDJiNi05YjcxLTZhNTE1YTUwMzZlOCIsInNpdGVPd25lcklkIjoiNWYyZmE4NTItMjRmYy00YTZkLWIzZDAtOGEyYTM5NzJmN2VjIn0&locale=en&pageId=f3zum&viewMode=site&vsi=3f8f9788-4f58-4794-af10-d085cd054f40&width=520', 'GET');
$request->setDelay(5);
$response = $client->getMessageFactory()->createResponse();
$client->send($request, $response);

if($response->getStatus() === 200 || $response->getStatus() === 301) {
    // Dump the requested page content
    $html = $response->getContent();
    $dom = new DomDocument();
    $dom->loadHTML($html);
    $finder = new DomXPath($dom);
    $classname="day ng-scope";
    $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
    echo $html;
    print_r($nodes);
}
else {

}
?>
