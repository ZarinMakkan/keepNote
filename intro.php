<?php
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$bulk = new MongoDB\Driver\BulkWrite;
// $bulk->insert(['name' => 122, 'family' => 3546457568]);
// $manager->executeBulkWrite('todoo.pass', $bulk);
$query = new MongoDB\Driver\Query([]);
$rows = $manager->executeQuery('keepNote.users', $query);
echo "<pre>";

foreach ($rows as $row) {
    print_r($row);
}
// $bulk->delete([]);
// $manager->executeBulkWrite('keepNote.users', $bulk);



?>