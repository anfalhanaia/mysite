<?php
header('Content-Type: application/json');

$courses = $_POST['course'] ?? [];
$credits = $_POST['credits'] ?? [];
$grades = $_POST['grade'] ?? [];

$totalPoints = 0;
$totalCredits = 0;

$table = "<table class='table table-bordered mt-3'>";
$table .= "<tr><th>Course</th><th>Credits</th><th>Grade</th><th>Points</th></tr>";

for ($i = 0; $i < count($courses); $i++) {
    $cr = floatval($credits[$i]);
    $g = floatval($grades[$i]);
    
    if ($cr > 0) {
        $pts = $cr * $g;
        $totalPoints += $pts;
        $totalCredits += $cr;
        
        $table .= "<tr>";
        $table .= "<td>" . htmlspecialchars($courses[$i]) . "</td>";
        $table .= "<td>$cr</td>";
        $table .= "<td>$g</td>";
        $table .= "<td>$pts</td>";
        $table .= "</tr>";
    }
}
$table .= "</table>";

if ($totalCredits > 0) {
    $gpa = round($totalPoints / $totalCredits, 2);
    
    if ($gpa >= 3.7) $interp = "Distinction";
    elseif ($gpa >= 3.0) $interp = "Merit";
    elseif ($gpa >= 2.0) $interp = "Pass";
    else $interp = "Fail";
} else {
    $gpa = 0;
    $interp = "No data";
    $table = "<p>No valid courses</p>";
}

echo json_encode([
    'gpa' => $gpa,
    'interpretation' => $interp,
    'table' => $table
]);
?>
