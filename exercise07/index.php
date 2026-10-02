<?php
// Exercise 7 - Service Fee Calculator

$serviceFees = [
    "Certificate"  => 100,
    "Verification" => 50,
    "Replacement"  => 200,
    "Correction"   => 75
];

function calculateFee($fees, $service, $qty)
{
    if (!isset($fees[$service])) {
        return ["error" => "Unknown service: $service"];
    }
    if ($qty < 1) {
        return ["error" => "Quantity must be at least 1."];
    }

    $unit = $fees[$service];
    $cost = $unit * $qty;

    // discount is only worked out when the quantity is 5 or more
    $discount = 0;
    if ($qty >= 5) {
        $discount = $cost * 0.10;
    }

    $processing = 20;
    $final = $cost - $discount + $processing;

    return [
        "service"    => $service,
        "unit"       => $unit,
        "qty"        => $qty,
        "cost"       => $cost,
        "discount"   => $discount,
        "processing" => $processing,
        "final"      => $final
    ];
}

$orders = [
    ["Certificate", 2],
    ["Verification", 6],
    ["Passport", 1],
    ["Correction", 0]
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 7 - Service Fees</title>
</head>
<body>
    <h1>Service Fee Calculator</h1>
    <?php foreach ($orders as $o) {
        $r = calculateFee($serviceFees, $o[0], $o[1]);
        echo "<h3>" . htmlspecialchars($o[0]) . " x " . $o[1] . "</h3>";
        if (isset($r["error"])) {
            echo "<p style='color:red'>Error: " . htmlspecialchars($r["error"]) . "</p>";
        } else { ?>
            <ul>
                <li>Service: <?php echo $r["service"]; ?></li>
                <li>Unit fee: Nu. <?php echo number_format($r["unit"], 2); ?></li>
                <li>Quantity: <?php echo $r["qty"]; ?></li>
                <li>Cost: Nu. <?php echo number_format($r["cost"], 2); ?></li>
                <li>Discount: Nu. <?php echo number_format($r["discount"], 2); ?></li>
                <li>Processing charge: Nu. <?php echo number_format($r["processing"], 2); ?></li>
                <li><strong>Final amount: Nu. <?php echo number_format($r["final"], 2); ?></strong></li>
            </ul>
        <?php }
    } ?>
</body>
</html>
