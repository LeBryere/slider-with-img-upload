<?php
// HTTP POST kérés kezelése és az adatok meglétének ellenőrzése
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["item_id"])) {

    include 'db_connection.php'; // Adatbázis kapcsolat fájljának importálása
    $conn = OpenCon(); // Adatbázis kapcsolat megnyitása

    if (!$conn) {
        die("Nem sikerült kapcsolódni az adatbázishoz: " . mysqli_connect_error()); // Hibaüzenet, ha nem sikerült kapcsolódni az adatbázishoz
    }

    $itemId = $_POST["item_id"]; // Az elem azonosítója
    // SQL lekérdezés az elem adatainak lekéréséhez
    $sql_select = "SELECT * FROM images_data WHERE id = '$itemId'";
    $result_select = mysqli_query($conn, $sql_select);

    if ($result_select) {
        $row = mysqli_fetch_assoc($result_select);
        $image_path = $row['uploaded_image_path']; // A kép elérési útja
        $thumbnail_path = $row['thumbnail_path']; // A thumbnail elérési útja

        if (file_exists($thumbnail_path)) { // Kép törlése a thumbnail könyvtárból
            unlink($thumbnail_path); // Kép törlése
        }

        if (file_exists($image_path)) { // Kép törlése az uploads könyvtárból
            unlink($image_path); // Kép törlése
        }
    }

    // SQL parancs az elem törléséhez az adatbázisból
    $sql = "DELETE FROM images_data WHERE id = '$itemId'";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
    CloseCon($conn);
} else {
    echo "Érvénytelen kérés!";
}
?>
