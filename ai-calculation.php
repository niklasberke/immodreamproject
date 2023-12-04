<?php

// Verbindung zur Datenbank herstellen (ersetzen Sie dies durch Ihre Daten)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "immodream";

$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen der Verbindung
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Daten aus dem Formular abrufen
$name = $_POST['name'];
$email = $_POST['email'];
$region = $_POST['region'];
$livingspace = $_POST['living-space'];
$propertysize = $_POST['property-size'];
$bedrooms = $_POST['bedrooms'];
$bathrooms = $_POST['bathrooms'];

// AI logik
$query = "SELECT region, livingspace, price FROM pricecalculation WHERE region LIKE '$region' AND livingspace LIKE $livingspace 
          AND propertysize = $propertysize AND bedrooms = $bedrooms AND bathrooms = $bathrooms";

$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $dbregion = $row['region'];
    $regionquery = "SELECT category from regions WHERE region LIKE '$dbregion'";
    $price = $row['price'];
    $dblivingspace = $row['livingspace'];
    $regioncategoryresult = mysqli_query($conn, $regionquery);
    if ($regioncategoryresult){
        $row = mysqli_fetch_assoc($regioncategoryresult);
        $regioncategory = $row['category'];
        switch ($regioncategory) {
            case 1: //high value region
                if ($dblivingspace > 150) {
                    $price = $price * 1.25;
                }
                if ($dblivingspace < 150) {
                    $price = $price * 0.75;
                }
                $price = raisePrice($price, true);
                break;
            case 2: // low value region
            if ($dblivingspace > 150) {
                $price = $price * 1.25;
            }
            if ($dblivingspace < 150) {
                $price = $price * 0.75;
            }
                $price = raisePrice($price, false);
                break;
        }
    }
    echo json_encode(['success' => true, 'price' => $price]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error executing the query']);
}
mysqli_close($conn);

function raisePrice($price, $ishigh) {
    $min = 1.0;
    $max = 2.0;
    $highrandomFloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
    $lowrandomFloat = mt_rand() / mt_getrandmax();

    if ($ishigh) {
        $newprice = $price * $highrandomFloat;
    } else {
        $newprice = $price * $lowrandomFloat;
    }
    $newprice = round($newprice,2);
    return $newprice;
}

?>

