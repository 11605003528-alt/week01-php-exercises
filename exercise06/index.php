<?php
// Exercise 6 - Profile Validation Engine

// every check adds to $errors instead of returning early, so the user sees all problems at once
function validateProfile($p)
{
    $errors = [];

    $name = isset($p["name"]) ? trim($p["name"]) : "";
    if ($name === "") {
        $errors[] = "Name is required.";
    } elseif (strlen($name) < 3) {
        $errors[] = "Name must have at least 3 characters.";
    }

    if (!isset($p["age"]) || !is_int($p["age"]) || $p["age"] < 0 || $p["age"] > 120) {
        $errors[] = "Age must be between 0 and 120.";
    }

    if (!isset($p["dzongkhag"]) || trim($p["dzongkhag"]) === "") {
        $errors[] = "Dzongkhag is required.";
    }

    if (!isset($p["cid"]) || strlen($p["cid"]) !== 11) {
        $errors[] = "CID must have exactly 11 characters.";
    }

    if (!isset($p["status"]) || ($p["status"] !== "Active" && $p["status"] !== "Inactive")) {
        $errors[] = "Status must be Active or Inactive.";
    }

    return ["isValid" => count($errors) === 0, "errors" => $errors];
}

$testProfiles = [
    "Valid profile"       => ["name" => "Pema Dorji", "age" => 24, "dzongkhag" => "Thimphu", "cid" => "10901000456", "status" => "Active"],
    "Missing details"     => ["name" => "Al", "age" => 24, "dzongkhag" => "", "cid" => "10901000456", "status" => "Active"],
    "Everything is wrong" => ["name" => "", "age" => 150, "dzongkhag" => "", "cid" => "123", "status" => "Pending"]
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 6 - Validation</title>
</head>
<body>
    <h1>Profile Validation Engine</h1>
    <?php foreach ($testProfiles as $title => $profile) {
        $result = validateProfile($profile);
        echo "<h2>" . htmlspecialchars($title) . "</h2>";
        if ($result["isValid"]) {
            echo "<p style='color:green'>Profile is valid.</p>";
        } else {
            echo "<ul style='color:red'>";
            foreach ($result["errors"] as $e) {
                echo "<li>$e</li>";
            }
            echo "</ul>";
        }
    } ?>
</body>
</html>
