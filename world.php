<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Get the country from the query string
$country = isset($_GET['country']) ? $_GET['country'] : '';

// Get the city from the query string
$lookup = isset($_GET['city']) ? $_GET['city'] : '';

if ($lookup == 'cities') {
    $select = $conn->prepare("SELECT cities.name, cities.district, cities.population
                             FROM countries
                             INNER JOIN cities ON countries.code = cities.country_code
                             WHERE countries.name LIKE :country");
    $select->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
    $select->execute();
    $results = $select->fetchAll(PDO::FETCH_ASSOC);
} else {
    $select = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $select->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
    $select->execute();
    $results = $select->fetchAll(PDO::FETCH_ASSOC);
}

?>

<?php if ($lookup == 'cities'): ?>
    <!-- Render the table for cities -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Population</th>
                <th>District</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['population']; ?></td>
                    <td><?= $row['district']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <!-- Render the list for countries -->
    <ul>
        <?php foreach ($results as $row): ?>
            <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

