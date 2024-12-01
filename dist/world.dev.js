"use strict";

document.addEventListener("DOMContentLoaded", function () {
  function fetchData(endpoint) {
    var country = document.getElementById("country").value.trim();

    if (country === "") {
      document.getElementById("result").innerHTML = "<p>Please enter a country name.</p>"; // Message incase the user eenters a a blank text.

      return;
    } // Sets up the sending of HTTP requests to the server.


    var xhr = new XMLHttpRequest();
    xhr.open("GET", "".concat(endpoint).concat(encodeURIComponent(country)), true);

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        var response = xhr.responseText;
        document.getElementById("result").innerHTML = response;
      } else {
        document.getElementById("result").innerHTML = "<p>Error fetching data.</p>";
      }
    };

    xhr.onerror = function () {
      document.getElementById("result").innerHTML = "<p>Network error. Please try again later.</p>";
    };

    xhr.send();
  } // Adds an event to the lookup button, shows result based on the endpoint.


  document.getElementById("lookup").addEventListener("click", function () {
    fetchData("world.php?country=");
  }); // Adds an event to the lookupCities button

  document.getElementById("lookupCities").addEventListener("click", function () {
    fetchData("world.php?lookup=cities&country=");
  });
});
//# sourceMappingURL=world.dev.js.map
