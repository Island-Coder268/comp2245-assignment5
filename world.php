<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Get the country from the query string
$country = isset($_GET['country']) ? $_GET['country'] : '';

// Check for the lookup query parameter
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

if ($lookup == 'cities') {
    // SQL query for cities lookup
    $select = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population
                             FROM countries
                             INNER JOIN cities ON countries.code = cities.country_code
                             WHERE countries.name LIKE :country");
    $select->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
    $select->execute();
    $results = $select->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Default SQL query for country lookup
    $select = $conn->prepare("SELECT countries.name AS country_name, countries.continent, countries.independence_year, countries.head_of_state
                             FROM countries
                             WHERE countries.name LIKE :country");
    $select->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
    $select->execute();
    $results = $select->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>World Database Lookup</title>
    <!-- Additional head elements as needed -->
</head>

<body>

<?php if (!empty($results)): ?>
    <?php if ($lookup == 'cities'): ?>
        <!-- Output table for cities -->
        <table border="1">
            <thead>
                <tr>
                    <th>City Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= $row['city_name']; ?></td>
                        <td><?= $row['district']; ?></td>
                        <td><?= $row['population']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <!-- Output table for countries -->
        <table border="1">
            <thead>
                <tr>
                    <th>Country Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= $row['country_name']; ?></td>
                        <td><?= $row['continent']; ?></td>
                        <td><?= $row['independence_year']; ?></td>
                        <td><?= $row['head_of_state']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php else: ?>
    <p>No results found for the specified country.</p>
<?php endif; ?>

</body>

</html>
