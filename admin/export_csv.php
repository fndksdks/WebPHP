<?php
include '../connect.php';
// Calculate the values of tongtiengiam, tongtienhientai, and tongtiendutinh
$tongtiengiam = 0;
$tongtienhientai = 0;
$tongtiendutinh = 0;

// You can replace these calculations with your actual logic to compute these values
foreach (selectAll("SELECT * FROM donhang WHERE status = 4") as $item) {
    $tongtiengiam += $item['tongtien'];
}

foreach (selectAll("SELECT * FROM donhang WHERE status = 3") as $item) {
    $tongtienhientai += $item['tongtien'];
}

foreach (selectAll("SELECT * FROM donhang WHERE status = 3 or status = 2 or status = 1") as $item2) {
    $tongtiendutinh += $item2['tongtien'];
}

// Create an array with the calculated values
$data = [
    ['Tổng Tiền Giảm', 'Tổng Tiền Hiện Tại', 'Tổng Tiền Dự Tính'],
    [$tongtiengiam, $tongtienhientai, $tongtiendutinh],
];

// Set the HTTP headers to force the browser to download the file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="tongtien_data.csv"');

// Create a file handle for output
$output = fopen('php://output', 'w');

// Write the data to the CSV file
foreach ($data as $row) {
    fputcsv($output, $row);
}

// Close the file handle
fclose($output);

// Exit to prevent any further output
exit;
