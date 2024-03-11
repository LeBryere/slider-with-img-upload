// Érintőképernyő események figyelése
document.addEventListener('touchstart', handleTouchStart, false);
document.addEventListener('touchmove', handleTouchMove, false);

var xDown = null;

function handleTouchStart(evt) {
   const firstTouch = evt.touches[0];
   xDown = firstTouch.clientX;
};

function handleTouchMove(evt) {
   if (!xDown) {
      return;
   }

   var xUp = evt.touches[0].clientX;
   var xDiff = xDown - xUp;

   if (xDiff > 0) {
      /* balra húzás */
   } else {
      /* jobbra húzás */
   }
};

function allowDrop(event) {
   event.preventDefault();
}

function drag(event) {
   var containerId = event.target.closest(".container").id;
   var containerNumber = containerId.split("container")[1];
   var draggedItem = event.target.closest(".item");

   event.dataTransfer.setData("text", draggedItem.id);
   event.dataTransfer.setData("containerId", containerNumber);

   console.log("konténer id:", containerId);
   console.log("konténer száma:", containerNumber);
}

function drop(event) {
   event.preventDefault();
   var data = event.dataTransfer.getData("text");
   var newContainerId = event.target.id;
   var newContainerNumber = newContainerId.split("container")[1];

   if (event.target.classList.contains("container")) {
      var draggedItem = document.getElementById(data);
      var draggedItemContainer = draggedItem.getAttribute("data-container");

      if (draggedItemContainer !== newContainerNumber) {
         event.target.appendChild(draggedItem);
         var itemId = data;


         var positionForm = document.createElement('form');
         positionForm.innerHTML = '<label for="position">Add meg az elem új pozícióját:</label>';
         positionForm.innerHTML += '<input type="number" id="position" name="position">';
         positionForm.innerHTML += '<button type="submit" class="positionBtn">Mentés</button>';
         positionForm.innerHTML += '<button type="button" class="positionBtn" id="cancelBtn">Mégse</button>';
         positionForm.addEventListener('submit',
            function (e) {
               e.preventDefault();

               var positionInput = document.getElementById('position');
               var position = positionInput.value;
               if (position.trim() !== "") {

                  var xhr = new XMLHttpRequest();
                  xhr.open("POST", "update_database.php", true);
                  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                  xhr.onreadystatechange = function () {
                     if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);
                        location.reload();
                     }
                  };
                  xhr.send("item_id=" + itemId + "&new_container=" + newContainerNumber + "&position=" + position);

                  draggedItem.setAttribute("data-container", newContainerNumber);
               }
            });

         event.target.appendChild(positionForm);


         var cancelBtn = positionForm.querySelector("#cancelBtn");
         cancelBtn.addEventListener('click', function () {
            positionForm.remove();
            location.reload();
         });
      } else {
         alert("Nem jó helyre húztad a képet. Próbáld megint, pontosabban!");
      }
   } else {
      alert("Nem jó helyre húztad a képet. Próbáld megint, pontosabban!");
   }
}
