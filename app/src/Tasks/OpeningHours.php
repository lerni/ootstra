<?php

namespace App\Tasks;

// use SilverStripe\ORM\DB;
// use SilverStripe\Dev\BuildTask;
// use SilverStripe\Core\Environment;

// class OpeningHours extends BuildTask
// {
//     protected $description = 'Shows GoogleMyBusiness OpeningHours';

//     protected $enabled = true;

//     public function run($request)
//     {
//         // Base URL for the Places API text search
//         $baseUrl = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json";

//         $apiKey = Environment::getEnv('APP_GOOGLE_PLACES_APIKEY');
//         // $query = 'Sigrist Anhänger GmbH, Ruswil';
//         $query = 'Piazza Verde Hellbühl';
//         // $query = 'kraftausdruck GmbH, Ruswil';

//         $encodedPlaceName = urlencode($query);

//         // Construct the request URL
//         $requestUrl = "$baseUrl?input=$encodedPlaceName&inputtype=textquery&fields=place_id&key=$apiKey";

//         // Make the API request
//         $response = file_get_contents($requestUrl);
//         $responseData = json_decode($response, true);

//         if (empty($responseData['candidates'])) {
//             echo "Place not found.";
//             return;
//         }

//         // Get the place ID of the first result
//         $placeId = $responseData['candidates'][0]['place_id'];

//         // Base URL for the Place Details API
//         $detailsUrl = "https://maps.googleapis.com/maps/api/place/details/json";

//         // Construct the request URL for place details
//         // $detailsRequestUrl = "$detailsUrl?place_id=$placeId&fields=name,opening_hours,special_days&key=$apiKey";
//         // $detailsRequestUrl = "$detailsUrl?place_id=$placeId&?fields=name%2Copening_hours%2Cspecial_days&key=$apiKey";
//         $detailsRequestUrl = "$detailsUrl?place_id=$placeId&?fields=name,opening_hours,current_opening_hours,special_days,reviews&key=$apiKey";
//         // echo $detailsRequestUrl;

//         // Make the API request
//         $detailsResponse = file_get_contents($detailsRequestUrl);
//         $detailsData = json_decode($detailsResponse, true);

//         // Check if opening hours are available
//         if (!isset($detailsData['result']['opening_hours'])) {
//             echo "Opening hours not available.";
//             return;
//         }

//         // Return the opening hours and special days if available
// //  print_r($detailsData['result']);

// // current_opening_hours vs opening_hours
//         echo "\n\n";
//         echo "open_now\n";
//         print_r($detailsData['result']['current_opening_hours']['open_now']);
//         echo "\n\n";

//         echo "weekday_text\n";
//         print_r($detailsData['result']['opening_hours']['weekday_text']);
//         echo "\n";

//         if (isset($detailsData['result']['current_opening_hours']['special_days'][0])) {
//             echo "special_days\n";
//             print_r($detailsData['result']['current_opening_hours']['special_days'][0]);
//             echo "\n";
//         }

//         echo "rating\n";
//         print_r($detailsData['result']['rating']);
//         echo "\n\n";

// // reviews_no_translations
//         echo "reviews\n";
//         print_r($detailsData['result']['reviews']);
//     }
// }
