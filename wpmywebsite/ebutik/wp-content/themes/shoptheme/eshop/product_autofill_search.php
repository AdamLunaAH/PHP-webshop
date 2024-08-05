<?php

require "eshopfunctions.php";

// AJAX autocomplete PHP code
// Read the JSON file into an array
$data = json_decode(file_get_contents('produkter.json'), true);

// Get the search term from the AJAX request
$term = htmlspecialchars($_GET['term']);

// Filter the data based on the search term
$results = array_filter($data, function($item) use ($term) {
  return strpos(strtolower($item['Produktnamn']), strtolower($term)) !== false;
});

// Return the filtered data as JSON
echo json_encode($results);
?>
  