<?php
   include 'db_connection.php';
   // Hibakeresés bekapcsolása
   error_reporting(E_ALL);
   ini_set('display_errors', 1);

   $conn = OpenCon(); // Kapcsolódás az adatbázishoz

   if(!$conn){
      die("Nem sikerült kapcsolódni az adatbázishoz: " . mysqli_connect_error());
   }
   // Ellenőrizzük, hogy a form elküldte-e az adatokat és a kép is be van-e töltve
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && isset($_POST["container_id"]) && isset($_POST["title"]) && isset($_POST["title2"]) && isset($_POST["description"])) {
      $containerId = $_POST["container_id"]; // Ellenőrizzük a konténer azonosítóját

      $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
      if ($imageFileType !== "jpg") {
         exit;
      }

      // Felhasználó által megadott cím és leírás mentése változókba
      $title = $_POST["title"];
      $title2 = $_POST["title2"];
      $description = $_POST["description"];

      $targetDir = "assets/img/uploads/"; // Célmappa, ahova a képeket menteni szeretnénk (uploads mappa)

      $originalFileName = $_FILES["image"]["name"]; // A feltöltött fájl neve és a kiterjesztés
      $targetFile = $targetDir . $originalFileName; // A fájl útvonala és neve a célkönyvtárban

      if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {  // Mozgatjuk a feltöltött fájlt a célkönyvtárba
         echo "A fájl sikeresen feltöltve."; // Sikeres feltöltés

         $imagePath = $targetFile;

         resizeImage($targetFile, $targetFile, 1024); // Kép átméretezése 1024 pixel szélességűre
         $thumbnailPath = "assets/img/thumbnails/thumbnail_" . $originalFileName;
         resizeImage($targetFile, $thumbnailPath, 100); // Thumbnail kép létrehozása 100 pixel szélességűre

         // Az aktuális konténerben található legnagyobb pozíció meghatározása
         $query = "SELECT MAX(position) AS max_position FROM images_data WHERE container = ?";
         $stmt = mysqli_prepare($conn, $query);
         mysqli_stmt_bind_param($stmt, "i", $containerId);
         mysqli_stmt_execute($stmt);
         mysqli_stmt_bind_result($stmt, $maxPosition);
         mysqli_stmt_fetch($stmt);
         mysqli_stmt_close($stmt);

         $newPosition = $maxPosition + 1; // Az új pozíció a legnagyobb pozíció + 1

         // Előkészített utasítás létrehozása
         $stmt = mysqli_prepare($conn, "INSERT INTO images_data (uploaded_image_path, thumbnail_path, container, position, title, title2, description) VALUES (?, ?, ?, ?, ?, ?, ?)");

         if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssiisss", $imagePath, $thumbnailPath, $containerId, $newPosition, $title, $title2, $description);

               if (mysqli_stmt_execute($stmt)) { // Futtatjuk az előkészített utasítást
                  echo "Az adatok sikeresen hozzá lettek adva az adatbázishoz.";
               } else {
                  echo "Hiba: Nem sikerült az adatokat hozzáadni az adatbázishoz.";
               }
         } else {
               echo "Hiba: Nem sikerült előkészíteni az SQL utasítást.";
         }

         mysqli_stmt_close($stmt); // Bezárjuk az előkészített utasítást
      } else {
         echo "Hiba történt a fájl feltöltése közben.";
      }
   } else {
      echo "Nem sikerült elküldeni a fájlt vagy hiányzik a konténer adat.";
   }

   // Függvény a kép átméretezéséhez
   function resizeImage($sourceFile, $targetFile, $newWidth) {
      list($width, $height) = getimagesize($sourceFile); // Eredeti kép mérete
      $aspectRatio = $width / $height; // Méretarány meghatározása
      $newHeight = intval($newWidth / $aspectRatio);
      $source = imagecreatefromjpeg($sourceFile); // Eredeti kép betöltése
      $resizedImage = imagecreatetruecolor($newWidth, $newHeight); // Új méretű kép létrehozása
      imagecopyresampled($resizedImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height); // Kép átméretezése
      imagejpeg($resizedImage, $targetFile); // Átméretezett kép mentése
      imagedestroy($source); // Memória felszabadítása
      imagedestroy($resizedImage);
   }

   CloseCon($conn); // Bezárjuk az adatbázis kapcsolatot
?>
