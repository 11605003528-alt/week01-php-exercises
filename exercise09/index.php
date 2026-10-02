<?php
// Exercise 9 - B-PIS Records Report

$records = [
    ["name" => "Pema Dorji",     "dzongkhag" => "Thimphu",  "age" => 24, "status" => "Active",   "type" => "Citizenship"],
    ["name" => "Karma Wangchuk", "dzongkhag" => "Thimphu",  "age" => 41, "status" => "Active",   "type" => "Address Change"],
    ["name" => "Sonam Choden",   "dzongkhag" => "Paro",     "age" => 67, "status" => "Inactive", "type" => "Citizenship"],
    ["name" => "Tashi Dorji",    "dzongkhag" => "Punakha",  "age" => 18, "status" => "Active",   "type" => "Birth Certificate"],
    ["name" => "Dechen Lhamo",   "dzongkhag" => "Paro",     "age" => 33, "status" => "Active",   "type" => "Citizenship"],
    ["name" => "Yeshey Gyeltshen","dzongkhag" => "Haa",     "age" => 72, "status" => "Inactive", "type" => "Address Change"],
    ["name" => "Sangay Wangmo",  "dzongkhag" => "Thimphu",  "age" => 12, "status" => "Active",   "type" => "Birth Certificate"],
    ["name" => "Ugyen Namgay",   "dzongkhag" => "Bumthang", "age" => 55, "status" => "Active",   "type" => "Citizenship"],
    ["name" => "Tshering Pem",   "dzongkhag" => "Thimphu",  "age" => 61, "status" => "Inactive", "type" => "Address Change"],
    ["name" => "Jigme Tenzin",   "dzongkhag" => "Mongar",   "age" => 29, "status" => "Active",   "type" => "Citizenship"]
];

function countByStatus($list)
{
    $c = ["Active" => 0, "Inactive" => 0];
    foreach ($list as $r) {
        $c[$r["status"]]++;
    }
    return $c;
}

function countByDzongkhag($list)
{
    $c = [];
    foreach ($list as $r) {
        if (!isset($c[$r["dzongkhag"]])) { $c[$r["dzongkhag"]] = 0; }
        $c[$r["dzongkhag"]]++;
    }
    return $c;
}

function countByType($list)
{
    $c = [];
    foreach ($list as $r) {
        if (!isset($c[$r["type"]])) { $c[$r["type"]] = 0; }
        $c[$r["type"]]++;
    }
    return $c;
}

function percentage($part, $whole)
{
    if ($whole === 0) {
        return 0; // avoids dividing by zero on an empty list
    }
    return ($part / $whole) * 100;
}

$total = count($records);
$status = countByStatus($records);
$dzongkhags = countByDzongkhag($records);
$types = countByType($records);

$adults = 0;
$seniors = 0;
foreach ($records as $r) {
    if ($r["age"] >= 60) {
        $seniors++;
    } elseif ($r["age"] >= 18) {
        $adults++;
    }
}

arsort($dzongkhags);
arsort($types);
$topDzongkhag = array_key_first($dzongkhags);
$topType = array_key_first($types);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 9 - Records Report</title>
</head>
<body>
    <h1>B-PIS Records Report</h1>

    <table border="1" cellpadding="6">
        <tr><th colspan="2">Summary</th></tr>
        <tr><td>Total records</td><td><?php echo $total; ?></td></tr>
        <tr><td>Active</td><td><?php echo $status["Active"]; ?></td></tr>
        <tr><td>Inactive</td><td><?php echo $status["Inactive"]; ?></td></tr>
        <tr><td>Active percentage</td><td><?php echo number_format(percentage($status["Active"], $total), 1); ?>%</td></tr>
        <tr><td>Adults (18-59)</td><td><?php echo $adults; ?></td></tr>
        <tr><td>Senior citizens (60+)</td><td><?php echo $seniors; ?></td></tr>
    </table>

    <h2>Records by dzongkhag</h2>
    <table border="1" cellpadding="6">
        <tr><th>Dzongkhag</th><th>Records</th></tr>
        <?php foreach ($dzongkhags as $d => $n) { echo "<tr><td>$d</td><td>$n</td></tr>"; } ?>
    </table>

    <h2>Records by type</h2>
    <table border="1" cellpadding="6">
        <tr><th>Record type</th><th>Records</th></tr>
        <?php foreach ($types as $t => $n) { echo "<tr><td>$t</td><td>$n</td></tr>"; } ?>
    </table>

    <h2>Interpretation</h2>
    <p>
        <?php echo $topDzongkhag; ?> has the most records (<?php echo $dzongkhags[$topDzongkhag]; ?> of <?php echo $total; ?>),
        and <?php echo $topType; ?> is the most common record type (<?php echo $types[$topType]; ?>).
        About <?php echo number_format(percentage($status["Active"], $total), 0); ?>% of the records are active.
    </p>
</body>
</html>
