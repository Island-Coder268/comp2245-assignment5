<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Get the country from the query string
$country = isset($_GET['country']) ? $_GET['country'] : '';

$select = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
$select->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
$select->execute();
$results = $select->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Country Lookup Results</title>
    <!-- Additional head elements as needed -->
</head>

<body>

<?php if (!empty($results)): ?>
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
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['continent']; ?></td>
                    <td><?= $row['independence_year']; ?></td>
                    <td><?= $row['head_of_state']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No results found for the specified country.</p>
<?php endif; ?>

</body>

</html>
