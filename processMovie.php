<?php
// Start a new session
session_start();

$page_title = "Add Movie";

require_once 'includes/header.php';
require_once 'includes/database.php';

// Retrieve data from GET request
$title = $_GET['movie_name'];
$year = $_GET['movie_year'];
$bio = $_GET['bio'];
$rating = $_GET['rating'];
$image = $_GET['image'];
$trailer = $_GET['trailer'];

// Debugging: print the values
echo "Title: $title<br>";
echo "Year: $year<br>";
echo "Bio: $bio<br>";
echo "Rating: $rating<br>";
echo "Image: $image<br>";
echo "Trailer: $trailer<br>";

// Validate the inputs (optional but recommended)
if (empty($title) || empty($year) || empty($bio) || empty($rating) || empty($image) || empty($trailer)) {
    echo "All fields are required.";
    exit;
}

// Prepare the SQL statement
$query_str = "INSERT INTO movies (movie_name, movie_year, movie_rating, movie_bio, movie_img, movie_trailer) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query_str);
$stmt->bind_param("ssssss", $title, $year, $rating, $bio, $image, $trailer);

// Execute the query
if ($stmt->execute()) {
    // Redirect to movies page
    header("Location: movies.php");
} else {
    // Handle error
    $errno = $stmt->errno;
    $errmsg = $stmt->error;
    echo "Insertion failed with: ($errno) $errmsg<br/>\n";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
