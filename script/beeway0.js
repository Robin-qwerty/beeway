$(document).ready(function(){
  const checkbox = document.getElementById("my-checkbox");

  checkbox.addEventListener("click", function(event) {
    if (checkbox.checked) {
      if (!window.confirm("Weet je zekker dat je deze beeway als afgerond wilt markeren!? Je kan deze dan niet meer bewerken")) {
        event.preventDefault();
      }
    } else {
      if (!window.confirm("Weet je zekker dat je deze beeway niet langer wilt markeren als afgerond!?")) {
        event.preventDefault();
      }
    }
  });

}); // end document ready
