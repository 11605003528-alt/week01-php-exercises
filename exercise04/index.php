<?php
// Exercise 4 - Dzongkhag Service Counter

$requests = ["Thimphu", "Paro", "Thimphu", "Punakha", "Paro", "Thimphu"];

// one associative array holds all counters, so a new dzongkhag needs no new variable
$counts = [];
foreach ($requests as $place) {
    if (!isset($counts[$place])) {
        $counts[$place] = 0;
    }
    $counts[$place]++;
}

$total = count($requests);

$topPlace = "";
$topCount = 0;
foreach ($counts as $place => $c) {
    if ($c > $topCount) {
        $topCount = $c;
        $topPlace = $place;
    }
}

$thimphuCount = isset($counts["Thimphu"]) ? $counts["Thimphu"] : 0;
$thimphuPercent = ($thimphuCount / $total) * 100;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 4 - Service Counter</title>
</head>
<body>
    <h1>Dzongkhag Service Counter</h1>

    <h2>All requests</h2>
    <?php
    foreach ($requests as $i => $place) {
        echo "<p>Request " . ($i + 1) . ": " . htmlspecialchars($place) . "</p>";
    }
    ?>

    <h2>Requests per dzongkhag</h2>
    <ul>
        <?php foreach ($counts as $place => $c) {
            echo "<li>" . htmlspecialchars($place) . ": $c</li>";
        } ?>
    </ul>

    <p>Total requests: <?php echo $total; ?></p>
    <p>Most requests: <?php echo $topPlace; ?> (<?php echo $topCount; ?>)</p>
    <p>Thimphu share: <?php echo number_format($thimphuPercent, 1); ?>%</p>
</body>
</html>
