<?php
// Exercise 3 - Household Member Summary

$members = ["Tashi Dorji", "Pema", "Dechen Lhamo", "Karma Tenzin", "Yeshey", "Sangay Wangmo"];

// the function loops once and keeps track of the shortest and longest as it goes
function summariseNames($names)
{
    $shortest = $names[0];
    $longest = $names[0];
    $totalLength = 0;

    foreach ($names as $n) {
        if (strlen($n) < strlen($shortest)) {
            $shortest = $n;
        }
        if (strlen($n) > strlen($longest)) {
            $longest = $n;
        }
        $totalLength += strlen($n);
    }

    return [
        "count"    => count($names),
        "shortest" => $shortest,
        "longest"  => $longest,
        "average"  => $totalLength / count($names)
    ];
}

$summary = summariseNames($members);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 3 - Household</title>
</head>
<body>
    <h1>Household Member Summary</h1>

    <h2>Members</h2>
    <ol>
        <?php foreach ($members as $m) { echo "<li>" . htmlspecialchars($m) . "</li>"; } ?>
    </ol>

    <p>Total members: <?php echo $summary["count"]; ?></p>
    <p>First: <?php echo htmlspecialchars($members[0]); ?></p>
    <p>Last: <?php echo htmlspecialchars($members[count($members) - 1]); ?></p>
    <p>Shortest name: <?php echo htmlspecialchars($summary["shortest"]); ?></p>
    <p>Longest name: <?php echo htmlspecialchars($summary["longest"]); ?></p>
    <p>Average name length: <?php echo number_format($summary["average"], 1); ?></p>

    <h2>Character counts</h2>
    <ul>
        <?php foreach ($members as $m) {
            echo "<li>" . htmlspecialchars($m) . " - " . strlen($m) . " characters</li>";
        } ?>
    </ul>
</body>
</html>
