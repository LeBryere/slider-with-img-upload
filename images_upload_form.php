<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nail Szaln képfeltöltés</title>
   <link rel="stylesheet" href="./assets/css/style_upload.css">
</head>
<body>
   <div class="carousel">
      <div id="error-message" style="display: none;"></div> <!-- Hibaüzenet kijelző elem -->
      <h2 id="imgUpload">Képfeltöltés</h2>

      <form id="upload-form" action="upload_image.php" method="post" enctype="multipart/form-data">
         <label name="image" for="image" id="fileInputLabel" class="label">Válassz egy képet</label>
         <input type="file" name="image" id="image" style="display: none;" onchange="updateFileName(this)">

         <div style="display: none;" id="content" class="content">
            <!-- Rejtett mező a konténer azonosítójának tárolásához -->
            <input type="hidden" name="container_id" value="1">
            <div class="author">ÉNIDŐ <span>S<span>zalon</span></span>
               <div class="byname">by Ángyán Móni</div>
            </div>

            <!-- Felhasználó által megadott cím és leírás -->
            <input style="display: none;" type="text" id="title" class="inputData" placeholder="Brand név">
            <input style="display: none;" type="text" id="title2" class="inputData" placeholder="Stílus neve">
            <textarea style="display: none;" id="description" class="inputData" placeholder="Leírás"></textarea>
         </div>
         <button type="submit" name="submit" id="submit-btn" class="uploadBtn" style="display: none;">Kép feltöltése</button>
         <button style="display: none;" type="button" id="cancelBtn" class="uploadBtn" onclick="cancelUpload()">Mégse</button>
      </form>
   </div>
 <div id="success-message" style="display: none;"></div>

   <script>
      // Eseményfigyelő hozzáadása a képválasztó elemhez
      var imageInput = document.getElementById("image");
      imageInput.addEventListener("change", function() {
         updateBackground(this); // Háttérkép frissítése a kiválasztott képpel
      });

      // Háttérkép frissítése a kiválasztott képpel
      function updateBackground(input) {
         if (input.files && input.files[0]) {
            var aaa = document.getElementById("aaa")
            var reader = new FileReader();
            reader.onload = function(e) {
               document.body.style.backgroundImage = "url(" + e.target.result + ")";
            };
            reader.readAsDataURL(input.files[0]);
         }
      }

      // Eseményfigyelő hozzáadása a "Mégse" gombhoz
      var cancelButton = document.getElementById("cancelBtn");
      cancelButton.addEventListener("click", function() {
         document.body.style.backgroundImage = "none"; // Háttérkép eltávolítása
      });
      // Háttérkép eltávolítása
      var submitButton = document.getElementById("submit-btn");
      submitButton.addEventListener("click", function() {
         document.body.style.backgroundImage = "none";
      });
      // Kurzor mozgatása az "id="title"" elembe
      document.getElementById("image").addEventListener("change", function() {
         document.getElementById("title").focus();
      });
      // Magasság beállítása
      var textarea = document.querySelector('textarea');
      textarea.addEventListener('input', function() {
         this.style.height = 'auto';
         this.style.height = (this.scrollHeight) + 'px';
      });
      textarea.addEventListener('focus', function() {
         this.value = ''; // A tartalom törlése
         this.style.height = 'auto'; // A magasság visszaállítása az alapértelmezett értékre
      });

      // Fájlnév frissítése a mező címkéjében
      function updateFileName(input) {
         var submitButton = document.querySelector('button[name="submit"]');
         var errorMessage = document.getElementById("error-message");
         var fileInputLabel = document.getElementById("fileInputLabel");
         var userTitle = document.getElementById("title");
         var usertitle2 = document.getElementById("title2");
         var userDescription = document.getElementById("description");
         var cancelBtn = document.getElementById("cancelBtn");
         var content = document.getElementById("content");

         if (input.files.length > 0) {
            var file = input.files[0];
            var fileName = file.name;
            var label = document.getElementById("fileInputLabel");
            label.innerText = fileName;
            label.classList.remove("label");
            label.classList.add("label_2");

            // Fájlkiterjesztés ellenőrzése
            var allowedExtensions = ['jpg', 'jpeg']; // Engedélyezett kiterjesztések
            var extension = fileName.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(extension)) {
                  errorMessage.innerHTML = 'Csak .jpg kép tölthető fel. <br> Ennek a fájlnak a kiterjesztése: <strong style="text-transform: uppercase;">.' + extension + '<strong>'; // Hibaüzenet beállítása
                  errorMessage.style.display = "block";
                  imgUpload.style.display = "none";
                  content.style.display = "none";
                  submitButton.style.display = "none";
                  userTitle.style.display = "none";
                  usertitle2.style.display = "none";
                  userDescription.style.display = "none";
                  cancelBtn.style.display = "none";

                  // "Fájl választása" label megjelenítése
                  fileInputLabel.innerText = 'Válassz másik képet';
                  label.classList.remove("label_2");
                  label.classList.add("label");
            } else {
                  // Ha a fájl megfelelő, megjelenítjük a címet és leírást
                  errorMessage.style.display = "none";
                  content.style.display = "block";
                  fileInputLabel.style.display = "none";
                  imgUpload.style.display = "none";
                  submitButton.style.display = "block";
                  userTitle.style.display = "block";
                  usertitle2.style.display = "block";
                  userDescription.style.display = "block";
                  cancelBtn.style.display = "block";
            }
         } else {
            // Ha nincs fájl kiválasztva, alaphelyzetbe állítjuk a felületet
            var label = document.getElementById("fileInputLabel");
            label.innerText = 'Válassz egy képet';
            label.classList.remove("label_2");
            label.classList.add("label");
            errorMessage.style.display = "none";
            content.style.display = "none";
            fileInputLabel.style.display = "block";
            imgUpload.style.display = "block";
            submitButton.style.display = "none";
            userTitle.style.display = "none";
            usertitle2.style.display = "none";
            userDescription.style.display = "none";
            cancelBtn.style.display = "none";
         }
      }

      // A sikeres üzenet megjelenítése és eltávolítása időzítve
      document.addEventListener("DOMContentLoaded", function() {
         var form = document.getElementById("upload-form");
         var successMessage = document.getElementById("success-message");
         var userTitle = document.getElementById("title");
         var usertitle2 = document.getElementById("title2");
         var userDescription = document.getElementById("description");

         form.addEventListener("submit", function(event) {
               event.preventDefault(); // Az alapértelmezett formaküldés megakadályozása

               var formData = new FormData(form); // Űrlapadatok begyűjtése
               // Felhasználó által megadott cím és leírás hozzáadása a formData-hoz
               formData.append("title", userTitle.value);
               formData.append("title2", usertitle2.value);
               formData.append("description", userDescription.value);

               var xhr = new XMLHttpRequest(); // Ajax kérés inicializálása
               xhr.open("POST", form.action, true); // Kérés beállítása
               xhr.onload = function() {
                  if (xhr.status === 200) {
                     successMessage.textContent = "A fájl sikeresen feltöltve. Az adatok sikeresen hozzá lettek adva az adatbázishoz.";
                     successMessage.style.display = "block";
                     userTitle.style.display = "block";
                     usertitle2.style.display = "block";
                     userDescription.style.display = "block";

                     setTimeout(function() {
                           successMessage.style.display = "none";
                           userTitle.style.display = "none";
                           usertitle2.style.display = "none";
                           userDescription.style.display = "none";
                     }, 3000);

                     // Fájlnév visszaállítása a mező címkéjére
                     var fileInput = document.getElementById("image");
                     var titleInput = document.getElementById("title");
                     var title2Input = document.getElementById("title2");
                     var descriptionInput = document.getElementById("description");
                     fileInput.value = '';
                     titleInput.value = '';
                     title2Input.value = '';
                     descriptionInput.value = '';
                     updateFileName(fileInput, titleInput, descriptionInput); // Fájlnév frissítése
                  } else {
                     console.error('Hiba történt a kérés során: ', xhr.status);
                  }
               };
               xhr.onerror = function() {
                  console.error('Hiba történt a kérés során.');
               };
               xhr.send(formData); // Kérés elküldése
         });
      });

      function cancelUpload() {
         var fileInput = document.getElementById('image');
         var titleInput = document.getElementById('title');
         var title2Input = document.getElementById('title2');
         var descriptionInput = document.getElementById('description');

         fileInput.value = '';
         titleInput.value = '';
         title2Input.value = '';
         descriptionInput.value = '';

         updateFileName(fileInput);
         }
   </script>
</body>
</html>