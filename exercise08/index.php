<?php
// Exercise 8 - Role Permission Checker

$permissions = [
    "administrator" => ["create", "read", "update", "delete", "export"],
    "data officer"  => ["create", "read", "update"],
    "viewer"        => ["read"]
];

// permissions live in the array above so adding a role never means touching this function
function canPerformAction($permissions, $role, $action)
{
    $role = strtolower(trim($role));
    $action = strtolower(trim($action));

    if (!isset($permissions[$role])) {
        return false;
    }
    return in_array($action, $permissions[$role], true);
}

$tests = [
    ["Administrator", "delete"],
    ["Administrator", "EXPORT"],
    ["Data Officer", "update"],
    ["Data Officer", "delete"],
    ["Data Officer", "export"],
    ["Viewer", "read"],
    ["viewer", "create"],
    ["Guest", "read"],
    ["", "read"]
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercise 8 - Permissions</title>
</head>
<body>
    <h1>Role Permission Checker</h1>
    <?php foreach ($tests as $t) {
        $role = $t[0];
        $action = $t[1];
        $allowed = canPerformAction($permissions, $role, $action);
        $roleShown = ($role === "") ? "(empty role)" : $role;

        if ($allowed) {
            echo "<p style='color:green'>" . htmlspecialchars($roleShown) . " is allowed to " . htmlspecialchars($action) . ".</p>";
        } elseif (!isset($permissions[strtolower(trim($role))])) {
            echo "<p style='color:red'>" . htmlspecialchars($roleShown) . " is not a known role, so it has no permissions. Cannot " . htmlspecialchars($action) . ".</p>";
        } else {
            echo "<p style='color:red'>" . htmlspecialchars($roleShown) . " is not allowed to " . htmlspecialchars($action) . ".</p>";
        }
    } ?>
</body>
</html>
