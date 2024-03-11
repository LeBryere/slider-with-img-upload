<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elemek áthúzása konténerek között</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
   <div class="wrapper">
      <div class="wrapper-box uploaded-img">
         <h2>Feltöltött képek</h2>
         <div id="container1" class="container" draggable="true" ondrop="drop(event)" ondragover="allowDrop(event)">
            <?php
               include 'fetch_img.php';
               echo fetchItems(1);
            ?>
         </div>
      </div>
      <div class="wrapper-box">
         <h2>Slider képek</h2>
         <div id="container2" class="container" draggable="true" ondrop="drop(event)" ondragover="allowDrop(event)">
            <?php
               echo fetchItems(2);
            ?>
         </div>
      </div>
      <div class="wrapper-box">
         <h2>My works</h2>
         <div id="container3" class="container" draggable="true" ondrop="drop(event)" ondragover="allowDrop(event)">
            <?php
               echo fetchItems(3);
            ?>
         </div>
      </div>
   </div>

   <div id="deleteModal" class="modal">
      <div class="modal-content">
         <p>Biztosan törölni szeretnéd ezt az képet?</p>
         <button id="confirmDeleteBtn" class="deleteBtn">Igen</button>
         <button id="cancelDeleteBtn" class="deleteBtn">Mégse</button>
      </div>
   </div>
   <script>
   function deleteItem(itemId) {
      // Modal ablak megjelenítése a törlés megerősítéséhez
      var modal = document.getElementById("deleteModal");
      var confirmBtn = document.getElementById("confirmDeleteBtn");

      // A törlés megerősítésére várunk a felhasználótól
      modal.style.display = "block";

      // Amikor a felhasználó megerősíti a törlést
      confirmBtn.onclick = function() {
         modal.style.display = "none"; // Modal ablak elrejtése
         var xhr = new XMLHttpRequest();
         xhr.open("POST", "delete_image.php", true);
         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
         xhr.onreadystatechange = function () {
               if (xhr.readyState == 4 && xhr.status == 200) {
                  console.log(xhr.responseText);
                  if (xhr.responseText === "success") {
                     var itemToDelete = document.getElementById(itemId);
                     itemToDelete.remove();
                  } else {
                     alert("Hiba történt az elem törlése közben.");
                  }
               }
         };
         xhr.send("item_id=" + itemId);
      }
   }

   // Ha a felhasználó megszakítja a törlési műveletet
   var cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
   cancelDeleteBtn.onclick = function() {
      document.getElementById("deleteModal").style.display = "none"; // Modal ablak elrejtése
   }

   </script>
   <script src="assets/js/script.js"></script>
</body>
</html>
