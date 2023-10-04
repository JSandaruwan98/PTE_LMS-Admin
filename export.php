<?php
// Get data from the POST request
$data = $_POST['data'];

// Generate a unique filename (e.g., using a timestamp)
$filename = 'export_' . time() . '.csv';

// Set the response headers for CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Output the data as CSV (you may need to format this data as per your needs)
echo $data;
?>
