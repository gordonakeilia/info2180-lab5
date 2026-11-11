<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$country = $_GET['country'] ?? '';
$lookup  = $_GET['lookup'] ?? '';
$like    = '%' . $country . '%';

if ($lookup === 'cities') {
    $stmt = $conn->prepare(
        "SELECT c.name, c.district, c.population
         FROM cities c
         JOIN countries cs ON c.country_code = cs.code
         WHERE cs.name LIKE :country"
    );
    $stmt->execute([':country' => $like]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <thead>
            <tr><th>Name</th><th>District</th><th>Population</th></tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['district']) ?></td>
                <td><?= htmlspecialchars($row['population']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
} else {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute([':country' => $like]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <thead>
            <tr><th>Name</th><th>Continent</th><th>Independence</th><th>Head of State</th></tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['continent']) ?></td>
                <td><?= htmlspecialchars($row['independence_year'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['head_of_state'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}