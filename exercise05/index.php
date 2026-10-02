<?php
// Exercise 5 - B-PIS Record Search

$profiles = [
    ["name" => "Pema Dorji",     "dzongkhag" => "Thimphu",  "age" => 24, "status" => "Active"],
    ["name" => "Pema Lhamo",     "dzongkhag" => "Paro",     "age" => 31, "status" => "Active"],
    ["name" => "Tshering Pem",   "dzongkhag" => "Punakha",  "age" => 45, "status" => "Inactive"],
    ["name" => "Karma Dorji",    "dzongkhag" => "Thimphu",  "age" => 19, "status" => "Active"],
    ["name" => "Sonam Tobgay",   "dzongkhag" => "Haa",      "age" => 62, "status" => "Inactive"],
    ["name" => "Dechen Wangmo",  "dzongkhag" => "Bumthang", "age" => 28, "status" => "Active"],
    ["name" => "Ugyen Namgay",   "dzongkhag" => "Wangdue",  "age" => 53, "status" => "Active"],
    ["name" => "Yangchen Dorji", "dzongkhag" => "Mongar",   "age" => 37, "status" => "Inactive"]
];

// stripos does the case-insensitive part, so I don't have to lowercase anything myself
function searchProfiles($list, $term)
{
    $found = [];
    foreach ($list as $p) {
        if (stripos($p["name"], $term) !== false) {
            $found[] = $p;
        }
    }
    return $found;
}

function showTable($list)
{
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Name</th><th>Dzongkhag</th><th>Age</th><th>Status</th></tr>";
    foreach ($list as $p) {
        echo "<tr><td>" . htmlspecialchars($p["name"]) . "</td><td>" . htmlspecialchars($p["dzongkhag"]) .
             "</td><td>" . $p["age"] . "</td><td>" . $p["status"] . "</td></tr>";
    }
    echo "</table>";
}

// try a different term each time: several matches, one match, no match
$searchTerm = "dorji";
$searchTerm = isset($_GET["q"]) ? $_GET["q"] : $searchTerm;
$results = searchProfiles($profiles, $searchTerm);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 5 - Record Search</title>
</head>
<body>
    <h1>B-PIS Record Search</h1>

    <h2>All profiles</h2>
    <?php showTable($profiles); ?>

    <h2>Search for "<?php echo htmlspecialchars($searchTerm); ?>"</h2>
    <p>Try: <a href="?q=dorji">dorji</a> | <a href="?q=yangchen">yangchen</a> | <a href="?q=zzz">zzz</a></p>
    <p>Matches found: <?php echo count($results); ?></p>
    <?php
    if (count($results) === 0) {
        echo "<p>No matching records found.</p>";
    } else {
        showTable($results);
    }
    ?>
</body>
</html>
