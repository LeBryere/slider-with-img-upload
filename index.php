<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nail Szalon</title>
   <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
<header>
   <nav>
      <a href="">Home</a>
      <a href="">My works</a>
      <a href="">Contact</a>
   </nav>
</header>

<div class='carousel'>
   <div class='list'>
   <?php
   include 'db_connection.php';
      // Hibakeresés bekapcsolása
   error_reporting(E_ALL);
   ini_set('display_errors', 1);

   $conn = OpenCon(); // Kapcsolódás az adatbázishoz

   if(!$conn){
      die("Nem sikerült kapcsolódni az adatbázishoz: " . mysqli_connect_error());
   }

   //SQL lekérdezés
   $sql = "SELECT uploaded_image_path, title, title2, description FROM images_data WHERE container = 2 ORDER BY position ASC";
   $result = mysqli_query($conn, $sql);

   // Ellenőrizzük, hogy van-e eredmény a lekérdezésben
   if(mysqli_num_rows($result) > 0){

      while($row = mysqli_fetch_assoc($result)){
         $uploadedImagePath = $row["uploaded_image_path"];
         $title = $row["title"];
         $title2 = $row["title2"];
         $description = $row["description"];

      echo "<div class='item'>";
      echo "<img src='$uploadedImagePath' alt='" . basename($uploadedImagePath) . "'>";
      echo "<div class='content'>";
         echo "<div class='author'><strong>ÉNIDŐ</strong> <span>S<span>zalon</span></span>";
            echo "<div class='byname'>by Ángyán Móni</div>";
         echo "</div>";
         echo "<div class='title'>$title</div>";
         echo "<div class='title2'>$title2</div>";
         echo "<div class='des'>";
            echo "'$description'";
         echo "</div>";
         echo "<div class='buttons'>";
            echo "<button>SEE MORE</button>";
            echo "<button>SUBSCRIBE</button>";
         echo "</div>";
      echo "</div>";
      echo "</div>";
      }
   } else {
      echo "Nincsenek uploaded image képek a kettes konténerben.";
   }
   ?>
   </div>
   <div class="thumbnail">
   <?php
   //SQL lekérdezés
   $sql = "SELECT uploaded_image_path, title, title2 FROM images_data WHERE container = 2 ORDER BY position ASC";
   $result = mysqli_query($conn, $sql);
   // Ellenőrizzük, hogy van-e eredmény a lekérdezésben
   if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
         $thumbnailPath = $row["uploaded_image_path"];
         $title = $row["title"];
         $title2 = $row["title2"];

      echo "<div class='item'>";
         echo "<img src='$thumbnailPath' alt='" . basename($thumbnailPath) . "'>";
         echo "<div class='content'>";
            echo "<div class='title'>$title</div>";
            echo "<div class='description'>$title2</div>";
         echo "</div>";
      echo "</div>";
      }
   } else {
      echo "Nincsenek thumbnail képek a kettes konténerben.";
   }
   CloseCon($conn); // Bezárjuk az adatbázis kapcsolatot
   ?>
   </div>
   </div>
   <!-- next prev -->
   <div class="arrows">
      <button id="next"><span> < </span></button>
      <button id="prev"><span> > </span></button>
   </div>
   <!-- time running -->
   <div class="time"></div>
</div>

<script src="./assets/js/app.js"></script>
</body>
</html>

<!--
   CREATE DATABASE IF NOT EXISTS slider_database;
   USE slider_database;
   CREATE TABLE IF NOT EXISTS images_data (
      id INT AUTO_INCREMENT PRIMARY KEY,
      container INT NOT NULL,
      position INT NOT NULL,
      uploaded_image_path VARCHAR(255) NOT NULL,
      thumbnail_path VARCHAR(255) NOT NULL,
      title VARCHAR(255) NOT NULL,
      title2 VARCHAR(255) NOT NULL,
      description TEXT NOT NULL
   );
 -->