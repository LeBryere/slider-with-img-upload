<?php
function OpenCon(){
   $dbhost = "localhost";
   $dbuser = "admin";
   $dbpass = "";
   $db = "slider_database";

   // Kapcsolódás az adatbázishoz
   $conn = new mysqli($dbhost, $dbuser, $dbpass, $db);

   if ($conn->connect_error) { // Kapcsolat ellenőrzése
      die("Kapcsolódási hiba: " . $conn->connect_error);
   }

   return $conn;
}

function CloseCon($conn){
   $conn->close();
}
?>