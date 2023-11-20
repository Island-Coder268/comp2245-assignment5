// world.js

document.addEventListener("DOMContentLoaded", function() {
    // Listen for clicks on the "Lookup" button
    var lookupButton = document.getElementById("lookup");
    lookupButton.addEventListener("click", function() {
        // Get the value entered by the user in the country input
        var countryInput = document.getElementById("country");
        var countryValue = countryInput.value;

        // Make an AJAX request to world.php with the entered country value
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "world.php?country=" + encodeURIComponent(countryValue), true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response and update the "result" div
                var resultDiv = document.getElementById("result");
                resultDiv.innerHTML = xhr.responseText;
            }
        };

        // Send the AJAX request
        xhr.send();
    });
});
