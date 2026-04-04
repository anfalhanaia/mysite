<?php
$result = "";
$tableHtml = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courses = $_POST['course'] ?? [];
    $credits = $_POST['credits'] ?? [];
    $grades = $_POST['grade'] ?? [];
    
    $totalPoints = 0;
    $totalCredits = 0;
    
    $tableHtml = "<table border='1'>";
    $tableHtml .= "<tr><th>Course</th><th>Credits</th><th>Grade</th><th>Points</th></tr>";
    
    for ($i = 0; $i < count($courses); $i++) {
        $course = htmlspecialchars($courses[$i]);
        $cr = floatval($credits[$i]);
        $g = floatval($grades[$i]);
        
        if ($cr <= 0) continue;
        
        $pts = $cr * $g;
        $totalPoints += $pts;
        $totalCredits += $cr;
        
        $tableHtml .= "<tr><td>$course</td><td>$cr</td><td>$g</td><td>$pts</td></tr>";
    }
    $tableHtml .= "</table>";
    
    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;
        
        if ($gpa >= 3.7) $interpretation = "Distinction";
        elseif ($gpa >= 3.0) $interpretation = "Merit";
        elseif ($gpa >= 2.0) $interpretation = "Pass";
        else $interpretation = "Fail";
        
        $result = "GPA: " . number_format($gpa, 2) . " ($interpretation)";
    } else {
        $result = "No valid courses";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GPA Calculator</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>GPA Calculator</h1>
    
    <?php if ($result != ""): ?>
        <div class="result">
            <?php echo $tableHtml; ?>
            <p><?php echo $result; ?></p>
        </div>
        <hr>
    <?php endif; ?>
    
    <form action="" method="post" onsubmit="return validateForm();">
        <div id="courses">
            <div class="course-row">
                <input type="text" name="course[]" placeholder="Course Name" required>
                <input type="number" name="credits[]" placeholder="Credits" min="1" required>
                <select name="grade[]">
                    <option value="4.0">A</option>
                    <option value="3.0">B</option>
                    <option value="2.0">C</option>
                    <option value="1.0">D</option>
                    <option value="0.0">F</option>
                </select>
            </div>
        </div>
        
        <button type="button" onclick="addCourse()">+ Add Course</button>
        <button type="submit">Calculate GPA</button>
    </form>
</body>
</html>
