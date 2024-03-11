<?php
include 'db_connection.php'; // Adatbázis kapcsolat fájljának importálása

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["item_id"]) && isset($_POST["new_container"])) { // HTTP POST kérés kezelése és az adatok meglétének ellenőrzése
    $itemId = $_POST["item_id"]; // Az elem azonosítója
    $newContainer = $_POST["new_container"]; // Az új konténer azonosítója
    $position = $_POST["position"]; // Az elem új pozíciója
    $title = $_POST["title"]; // Az elem új pozíciója
    $description = $_POST["description"]; // Az elem új pozíciója

    $conn = OpenCon(); // Adatbázis kapcsolat megnyitása

    if (!$conn) {
        die("Nem sikerült létrehozni a kapcsolatot az adatbázishoz!"); // Hibaüzenet, ha nem sikerült kapcsolódni az adatbázishoz
    }

    // SQL injection elleni védelem
    $itemId = mysqli_real_escape_string($conn, $itemId);
    $newContainer = mysqli_real_escape_string($conn, $newContainer);
    $position = mysqli_real_escape_string($conn, $position);
    $title = mysqli_real_escape_string($conn, $title);
    $description = mysqli_real_escape_string($conn, $description);

    $sql = "UPDATE images_data SET container = '$newContainer', position = '$position' WHERE id = '$itemId'"; // SQL parancs az adatbázis frissítéséhez
    if ($conn->query($sql) === TRUE) {
        echo "Az elem pozíciója sikeresen frissítve az adatbázisban!"; // Sikeres üzenet
    } else {
        echo "Hiba történt az adatbázis frissítése során: " . $conn->error; // Hibás üzenet
    }

    CloseCon($conn); // Adatbázis kapcsolat bezárása
} else {
    echo "Érvénytelen kérés!"; // Hibaüzenet, ha érvénytelen kérés érkezik
}
?>
<!--
    // Hibakeresés bekapcsolása
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
 -->