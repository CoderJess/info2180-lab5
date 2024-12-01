"use strict";

document.addEventListener("DOMContentLoaded", function () {
  function fetchData(endpoint) {
    var country = document.getElementById("country").value.trim();

    if (country === "") {
      document.getElementById("result").innerHTML = "<p>Please enter a country name.</p>";
      return;
    }

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
  }

  document.getElementById("lookup").addEventListener("click", function () {
    fetchData("world.php?country=");
  });
  document.getElementById("lookupCities").addEventListener("click", function () {
    fetchData("world.php?lookup=cities&country=");
  });
});
//# sourceMappingURL=world.dev.js.map
