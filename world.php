<?php

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    // Establishing a connection to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if 'country' parameter is set in the URL
    if (isset($_GET['country'])) {
        $country = $_GET['country'];

        if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
            // SQL query to join countries and cities tables
            $stmt = $conn->prepare("
                SELECT cities.name AS city_name, cities.district, cities.population 
                FROM cities 
                JOIN countries ON cities.country_code = countries.code 
                WHERE countries.name LIKE :country
            ");
            
            // Adding wildcards for the LIKE query
            $likeCountry = "%" . $country . "%";
            $stmt->bindParam(':country', $likeCountry);
            $stmt->execute();

            // Fetch the results
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if any cities were found
            if ($results) {
                // Start the cities table
                echo "<h1>Cities in '" . htmlspecialchars($country) . "':</h1>";
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<tr>
                        <th>City Name</th>
                        <th>District</th>
                        <th>Population</th>
                      </tr>";

                // Loop through results and create table rows
                foreach ($results as $result) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($result['city_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['district']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['population']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No cities found for the country: " . htmlspecialchars($country) . "</p>";
            }
        } else {
            // Existing country info retrieval code
            $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
            $likeCountry = "%" . $country . "%";
            $stmt->bindParam(':country', $likeCountry);
            $stmt->execute();

            // Fetch the results
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if any countries were found
            if ($results) {
                // Start the countries table
                echo "<h1>Countries matching '" . htmlspecialchars($country) . "':</h1>";
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<tr>
                        <th>Country Name</th>
                        <th>Continent</th>
                        <th>Independence Year</th>
                        <th>Head of State</th>
                      </tr>";

                // Loop through results and create table rows
                foreach ($results as $result) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($result['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['continent']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['independence_year']) . "</td>";
                    echo "<td>" . htmlspecialchars($result['head_of_state']) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No information found for the country: " . htmlspecialchars($country) . "</p>";
            }
        }
    } else {
        echo "<p>Please provide a country name in the query parameter.</p>";
    }
} catch (PDOException $e) {
    // Handle connection errors
    echo 'Connection failed: ' . $e->getMessage();
}

?>


