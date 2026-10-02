<?php
// Exercise 2 - Age and Service Eligibility

function checkAge($age)
{
    // invalid ages are handled first so the other checks can trust the number
    if ($age < 0 || $age > 120) {
        return [
            "group"       => "Invalid",
            "eligible"    => false,
            "explanation" => "$age is not a valid age. It must be between 0 and 120."
        ];
    }

    if ($age < 13) {
        $group = "Child";
    } elseif ($age < 18) {
        $group = "Teenager";
    } elseif ($age < 60) {
        $group = "Adult";
    } else {
        $group = "Senior Citizen";
    }

    $eligible = ($age >= 18);

    if ($eligible) {
        $explanation = "Aged $age, so this person is old enough for the adult-only service.";
    } else {
        $explanation = "Aged $age, so this person is under 18 and cannot use the adult-only service.";
    }

    return ["group" => $group, "eligible" => $eligible, "explanation" => $explanation];
}

$name = "Sonam Choden";
$testAges = [8, 15, 18, 59, 60, 130];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 2 - Age and Eligibility</title>
</head>
<body>
    <h1>Age and Service Eligibility</h1>
    <p>Citizen: <?php echo htmlspecialchars($name); ?></p>
    <table border="1" cellpadding="6">
        <tr><th>Age</th><th>Age group</th><th>Eligible</th><th>Explanation</th></tr>
        <?php foreach ($testAges as $age) {
            $result = checkAge($age); ?>
            <tr>
                <td><?php echo $age; ?></td>
                <td><?php echo $result["group"]; ?></td>
                <td><?php echo $result["eligible"] ? "Yes" : "No"; ?></td>
                <td><?php echo $result["explanation"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
