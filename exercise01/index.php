<?php
// Exercise 1 - Fictional Citizen Profile

$profile = [
    "name"       => "Karma Wangchuk",
    "cid"        => "10901000123",
    "dob"        => "1998-04-12",
    "dzongkhag"  => "Thimphu",
    "gewog"      => "Chang",
    "occupation" => "Teacher",
    "active"     => true
];

// I keep the status as true/false in the array and only change it to words when printing
if ($profile["active"]) {
    $statusText = "Active";
} else {
    $statusText = "Inactive";
}

function displayProfileField($label, $value)
{
    echo "<p><strong>" . htmlspecialchars($label) . ":</strong> " . htmlspecialchars($value) . "</p>\n";
}

$cidLength = strlen($profile["cid"]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 1 - Citizen Profile</title>
</head>
<body>
    <h1>Fictional Citizen Profile</h1>
    <?php
    displayProfileField("Full name", strtoupper($profile["name"]));
    displayProfileField("CID", $profile["cid"]);
    displayProfileField("CID length", $cidLength . " characters");
    displayProfileField("Date of birth", $profile["dob"]);
    displayProfileField("Dzongkhag", $profile["dzongkhag"]);
    displayProfileField("Gewog", $profile["gewog"]);
    displayProfileField("Occupation", $profile["occupation"]);
    displayProfileField("Status", $statusText);

    if ($cidLength !== 11) {
        echo "<p style='color:red'>Warning: the CID should have exactly 11 characters.</p>";
    }
    ?>
</body>
</html>
