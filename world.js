document.addEventListener("DOMContentLoaded", function() {
    // Listen for clicks on the "Lookup" button
    var lookupButton = document.getElementById("lookup");
    lookupButton.addEventListener("click", function() {
        // Get the value entered by the user in the country input
        var countryInput = document.getElementById("country");
        var countryValue = countryInput.value;

        // Make an AJAX request to world.php with the entered country value
        makeAjaxRequest("world.php?country=" + encodeURIComponent(countryValue));
    });

    // Add a new event listener for the "LookupCities" button 
    var lookupCitiesButton = document.getElementById("lookupCities");
    if (lookupCitiesButton) {
        lookupCitiesButton.addEventListener("click", function() {
            // Get the value entered by the user in the country input
            var countryInput = document.getElementById("country");
            var countryValue = countryInput.value;

            // Make an AJAX request to world.php with the entered country value and lookup=cities
            makeAjaxRequest("world.php?country=" + encodeURIComponent(countryValue) + "&lookup=cities");
        });
    }
});

function makeAjaxRequest(url) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Handle the response and update the "result" div
            var resultDiv = document.getElementById("result");
            resultDiv.innerHTML = xhr.responseText;
        }
    };

    // Send the AJAX request
    xhr.send();
}

