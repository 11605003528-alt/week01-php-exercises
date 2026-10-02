<?php
// Exercise 10 - B-PIS Command Dashboard
// Use ?data=messy to load the dataset with problems, and ?dzongkhag=...&status=...&role=...&action=... for the filters

$validData = [
    ["name" => "Pema Dorji",      "cid" => "10901000111", "age" => 24, "dzongkhag" => "Thimphu",  "status" => "Active"],
    ["name" => "Karma Wangchuk",  "cid" => "10902000222", "age" => 41, "dzongkhag" => "Paro",     "status" => "Active"],
    ["name" => "Sonam Choden",    "cid" => "10903000333", "age" => 67, "dzongkhag" => "Thimphu",  "status" => "Inactive"],
    ["name" => "Tashi Dorji",     "cid" => "10904000444", "age" => 18, "dzongkhag" => "Punakha",  "status" => "Active"],
    ["name" => "Dechen Lhamo",    "cid" => "10905000555", "age" => 33, "dzongkhag" => "Paro",     "status" => "Inactive"],
    ["name" => "Yeshey Gyeltshen","cid" => "10906000666", "age" => 72, "dzongkhag" => "Haa",      "status" => "Active"],
    ["name" => "Sangay Wangmo",   "cid" => "10907000777", "age" => 12, "dzongkhag" => "Thimphu",  "status" => "Active"],
    ["name" => "Ugyen Namgay",    "cid" => "10908000888", "age" => 55, "dzongkhag" => "Bumthang", "status" => "Inactive"]
];

$messyData = [
    ["name" => "Pema Dorji",     "cid" => "10901000111", "age" => 24,  "dzongkhag" => "Thimphu", "status" => "Active"],
    ["name" => "",               "cid" => "10902000222", "age" => 41,  "dzongkhag" => "Paro",    "status" => "Active"],
    ["name" => "Sonam Choden",   "cid" => "109",         "age" => 150, "dzongkhag" => "Thimphu", "status" => "Inactive"],
    ["name" => "Tashi Dorji",    "cid" => "10904000444", "age" => 18,  "dzongkhag" => "",        "status" => "Pending"],
    ["name" => "Dechen Lhamo",   "cid" => "10905000555", "age" => 33,  "dzongkhag" => "Paro",    "status" => "Inactive"],
    ["name" => "Yeshey Gyeltshen","cid" => "10906000666","age" => -3,  "dzongkhag" => "Haa",     "status" => "Active"],
    ["name" => "Sangay Wangmo",  "cid" => "10907000777", "age" => 12,  "dzongkhag" => "Thimphu", "status" => "Active"],
    ["name" => "Ugyen Namgay",   "cid" => "10908000888", "age" => 55,  "dzongkhag" => "Bumthang","status" => "Inactive"]
];

$permissions = [
    "administrator" => ["create", "read", "update", "delete", "export"],
    "data officer"  => ["create", "read", "update"],
    "viewer"        => ["read"]
];

// ---------- functions ----------

// returns a list of problems; each one is also worth 25 points off the quality score
function findProblems($p)
{
    $problems = [];
    if (trim($p["name"]) === "") {
        $problems[] = "Missing name";
    }
    if (!is_int($p["age"]) || $p["age"] < 0 || $p["age"] > 120) {
        $problems[] = "Invalid age";
    }
    if (trim($p["dzongkhag"]) === "") {
        $problems[] = "Missing dzongkhag";
    }
    if ($p["status"] !== "Active" && $p["status"] !== "Inactive") {
        $problems[] = "Invalid status";
    }
    return $problems;
}

function filterProfiles($list, $dzongkhag, $status)
{
    $out = [];
    foreach ($list as $p) {
        if ($dzongkhag !== "All" && $p["dzongkhag"] !== $dzongkhag) {
            continue;
        }
        if ($status !== "All" && $p["status"] !== $status) {
            continue;
        }
        $out[] = $p;
    }
    return $out;
}

function canPerformAction($permissions, $role, $action)
{
    $role = strtolower(trim($role));
    $action = strtolower(trim($action));
    if (!isset($permissions[$role])) {
        return false;
    }
    return in_array($action, $permissions[$role], true);
}

// ---------- read the page settings ----------

$dataset = (isset($_GET["data"]) && $_GET["data"] === "messy") ? "messy" : "valid";
$profiles = ($dataset === "messy") ? $messyData : $validData;

$selDzongkhag = isset($_GET["dzongkhag"]) ? $_GET["dzongkhag"] : "All";
$selStatus = isset($_GET["status"]) ? $_GET["status"] : "All";
$selRole = isset($_GET["role"]) ? $_GET["role"] : "Viewer";
$selAction = isset($_GET["action"]) ? $_GET["action"] : "delete";

// ---------- calculations ----------

$total = count($profiles);
$activeCount = 0;
$inactiveCount = 0;
$ageSum = 0;
$ageCount = 0;
$youngest = null;
$oldest = null;
$scores = [];
$scoreSum = 0;
$imperfect = 0;
$worstIndex = -1;
$worstScore = 100;

foreach ($profiles as $i => $p) {
    if ($p["status"] === "Active") {
        $activeCount++;
    } elseif ($p["status"] === "Inactive") {
        $inactiveCount++;
    }

    // only ages that pass validation go into the age statistics
    if (is_int($p["age"]) && $p["age"] >= 0 && $p["age"] <= 120) {
        $ageSum += $p["age"];
        $ageCount++;
        if ($youngest === null || $p["age"] < $youngest["age"]) {
            $youngest = $p;
        }
        if ($oldest === null || $p["age"] > $oldest["age"]) {
            $oldest = $p;
        }
    }

    $problems = findProblems($p);
    $score = 100 - (25 * count($problems));
    $scores[$i] = $score;
    $scoreSum += $score;

    if ($score < 100) {
        $imperfect++;
    }
    if ($score < $worstScore) {
        $worstScore = $score;
        $worstIndex = $i;
    }
}

$averageAge = ($ageCount > 0) ? $ageSum / $ageCount : 0;
$averageScore = ($total > 0) ? $scoreSum / $total : 0;
$filtered = filterProfiles($profiles, $selDzongkhag, $selStatus);
$allowed = canPerformAction($permissions, $selRole, $selAction);

function show($text)
{
    return htmlspecialchars((string) $text);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 10 - B-PIS Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; margin-bottom: 15px; }
        td, th { border: 1px solid #999; padding: 6px 10px; }
        .warn { color: #b00020; }
    </style>
</head>
<body>
    <h1>B-PIS Command Dashboard</h1>
    <p>Dataset: <strong><?php echo $dataset; ?></strong> -
        <a href="?data=valid">valid</a> | <a href="?data=messy">messy</a></p>

    <h2>Overview</h2>
    <ul>
        <li>Total profiles: <?php echo $total; ?></li>
        <li>Active: <?php echo $activeCount; ?></li>
        <li>Inactive: <?php echo $inactiveCount; ?></li>
        <li>Average age: <?php echo number_format($averageAge, 1); ?></li>
        <li>Youngest: <?php echo $youngest ? show($youngest["name"] . " (" . $youngest["age"] . ")") : "none"; ?></li>
        <li>Oldest: <?php echo $oldest ? show($oldest["name"] . " (" . $oldest["age"] . ")") : "none"; ?></li>
    </ul>

    <h2>All profiles and data quality</h2>
    <table>
        <tr><th>#</th><th>Name</th><th>CID</th><th>Age</th><th>Dzongkhag</th><th>Status</th><th>Score</th><th>Warnings</th></tr>
        <?php foreach ($profiles as $i => $p) {
            $problems = findProblems($p);
            if (strlen($p["cid"]) !== 11) {
                $problems[] = "CID is not 11 characters";
            } ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo show($p["name"]); ?></td>
                <td><?php echo show($p["cid"]); ?></td>
                <td><?php echo show($p["age"]); ?></td>
                <td><?php echo show($p["dzongkhag"]); ?></td>
                <td><?php echo show($p["status"]); ?></td>
                <td><?php echo $scores[$i]; ?></td>
                <td class="warn"><?php echo show(implode(", ", $problems)); ?></td>
            </tr>
        <?php } ?>
    </table>
    <p>Average quality score: <?php echo number_format($averageScore, 1); ?></p>
    <p>Imperfect profiles: <?php echo $imperfect; ?></p>
    <p>Needs the most correction:
        <?php echo ($worstScore < 100) ? show($profiles[$worstIndex]["name"] === "" ? "(no name) record #" . ($worstIndex + 1) : $profiles[$worstIndex]["name"] . " (score " . $worstScore . ")") : "none, all records are clean"; ?>
    </p>

    <h2>Filter</h2>
    <form method="get">
        <input type="hidden" name="data" value="<?php echo $dataset; ?>">
        Dzongkhag:
        <select name="dzongkhag">
            <?php foreach (["All", "Thimphu", "Paro", "Punakha", "Haa", "Bumthang"] as $d) {
                echo "<option" . ($d === $selDzongkhag ? " selected" : "") . ">$d</option>";
            } ?>
        </select>
        Status:
        <select name="status">
            <?php foreach (["All", "Active", "Inactive"] as $s) {
                echo "<option" . ($s === $selStatus ? " selected" : "") . ">$s</option>";
            } ?>
        </select>
        Role:
        <select name="role">
            <?php foreach (["Administrator", "Data Officer", "Viewer", "Guest"] as $r) {
                echo "<option" . ($r === $selRole ? " selected" : "") . ">$r</option>";
            } ?>
        </select>
        Action:
        <select name="action">
            <?php foreach (["create", "read", "update", "delete", "export"] as $a) {
                echo "<option" . ($a === $selAction ? " selected" : "") . ">$a</option>";
            } ?>
        </select>
        <button type="submit">Apply</button>
    </form>

    <h3>Filtered profiles (<?php echo count($filtered); ?>)</h3>
    <?php if (count($filtered) === 0) { ?>
        <p>No matching records found.</p>
    <?php } else { ?>
        <ul>
            <?php foreach ($filtered as $p) {
                echo "<li>" . show($p["name"]) . " - " . show($p["dzongkhag"]) . " - " . show($p["status"]) . "</li>";
            } ?>
        </ul>
    <?php } ?>

    <h3>Permission check</h3>
    <p>
        <?php
        if ($allowed) {
            echo show($selRole) . " <strong>can</strong> " . show($selAction) . " records.";
        } else {
            echo show($selRole) . " <strong>cannot</strong> " . show($selAction) . " records.";
        }
        ?>
    </p>
</body>
</html>
