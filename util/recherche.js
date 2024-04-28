var inputText = document.getElementById("recherche");
var messages = document.querySelectorAll(".message");

inputText.addEventListener("input", function() {
    var texteSaisi = inputText.value.toLowerCase();
    
    messages.forEach(function(message) {
        var contenuMessage = message.querySelector(".contentMessage").textContent.toLowerCase();
        if (contenuMessage.includes(texteSaisi)) {
            message.style.display = "block";
        } else {
            message.style.display = "none";
        }
    });
});
