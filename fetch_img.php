<?php
include 'db_connection.php'; // Adatbázis kapcsolat fájljának importálása

// fetchItems függvény definiálása
function fetchItems($containerId) {
    $conn = OpenCon(); // Nyisson meg kapcsolatot az adatbázissal

    if (!$conn) {  // Ellenőrizze a kapcsolatot
        return "Hiba: Nem sikerült kapcsolódni az adatbázishoz!";
    }
    // SQL lekérdezés az elemek lekéréséhez
    $sql = "SELECT id, thumbnail_path, position FROM images_data WHERE container = $containerId ORDER BY position";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { // Ellenőrizzük az eredményt
        $output = ""; // Létrehozunk egy üres stringet az elemek tárolásához

        // Hozzáadjuk az elemeket a kimenethez
        while ($row = $result->fetch_assoc()) {
            $output .= '<div class="item" draggable="true" ondragstart="drag(event)" id="' . $row['id'] . '">';
            $output .= '<img src="' . $row['thumbnail_path'] . '" alt="' . '">';
            // Pozíció hozzáadása
            $output .= '<span class="item-position">' . $row['position'] . '</span>';
            // Törlés gomb csak az első konténerben jelenjen meg
            if ($containerId == 1) {
                $output .= '<button class="deleteBtn" onclick="deleteItem(' . $row['id'] . ')">Törlés</button>';
            }
            $output .= '</div>';
        }
        CloseCon($conn); // Bezárjuk az adatbázis kapcsolatot
        return $output; // Visszaadjuk az elemek kimenetét
    } else {
        // Ha nincsenek elemek, visszatérünk egy üres stringgel
        return "Ebben a boxban nincs képek";
    }
}
?>
