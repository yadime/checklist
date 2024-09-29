<!DOCTYPE html>
<html lang="en">
<head>
    <h2>Republic of the Philippines</h2>
    <h1>CAVITE STATE UNIVERSITY</h1>
    <h3>Bacoor City Campus</h3>
    <h2>Bachelor of Science in Computer Science</h2>
    <h6 style="text-align: center;">(Program)</h6>
    <h3>UPDATE OF CHECKLISTS</h3>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student and Course Information</title>
    <link rel="stylesheet" href="design.css">
</head>
<body style="font-family: Verdana, Geneva, Tahoma, sans-serif;">
<div style="position: absolute; top: 30px; right: 50px; margin: 10px; padding: 2px; border: 2px solid black;">
    <img style="width: 120px; height: auto;" src="sarap.jpeg" alt="Gwapo">
</div>

<div style="position: absolute; top: 15px; left: 280px; margin: 10px; padding: 2px;">
    <img style="width: 180px; height: auto;" src="cvsuY.png" alt="Logo">
</div>


<?php
include("connection.php");

$sql_students = "SELECT * FROM students";
$result_students = $conn->query($sql_students);

if ($result_students->num_rows > 0) {
    while ($row = $result_students->fetch_assoc()) {
        echo "<table class='student_Css'>";
        echo "<tr><td>Name of Student:</td><td>" . $row["name"] . "</td></tr>";
        echo "<tr><td>Student Number:</td><td>" . $row["student_id"] . "</td></tr>";
        echo "<tr><td>Address:</td><td>" . $row["address"] . "</td></tr>";
        echo "<tr><td>Date of Admission:</td><td>" . $row["date_of_admission"] . "</td></tr>";
        echo "<tr><td>Contact Number:</td><td>" . $row["contact_number"] . "</td></tr>";
        echo "<tr><td>Adviser:</td><td>" . $row["adviser"] . "</td></tr>";
        echo "<tr><td>Age:</td><td>" . $row["student_age"] . "</td></tr>";
        echo "</table>";

    }
} else {
    echo "<div class='student-table'>";
    echo "<h2>Student Information</h2>";
    echo "0 results";
    echo "</div>";
}

$course_ranges = array(
    array("1st Year 1st Semester", 1, 9),
    array("1st Year 2nd Semester", 10, 17),
    array("2nd Year 1st Semester", 18, 25),
    array("2nd Year 2nd Semester", 26, 33),
    array("3rd Year 1st Semester", 34, 40),
    array("3rd Year 2nd Semester", 41, 47),
    array("Mid Year Courses", 48, 48),
    array("4th Year 1st Semester", 49, 53),
    array("4th Year 2nd Semester", 54, 57)
);
echo "<div class='course-table'>";
echo "<div class='search-box' style='text-align: center;'>";
echo "<label for='course-search'>Enter:  </label>";
echo "<input type='text' id='course-search' placeholder='Search?' style='border-radius: 20px; padding: 5px 10px;'>";
echo "</div>";

foreach ($course_ranges as $range) {
    list($semester_title, $start, $end) = $range;
    $courses = fetch_courses_by_semester($conn, $start, $end);
    echo "<div class='table-container'>";
    echo "<h2>$semester_title</h2>";
    echo "<table style='border: 2px solid black;'>";
    echo "<tr><th style='background-color: lightgreen;'>Course ID</th><th style='background-color: lightgreen;'>Course Title</th><th style='background-color: lightgreen;'>Credit Units (Lecture)</th>
        <th style='background-color: lightgreen;'>Credit Units (Lab)</th><th style='background-color: lightgreen;'>Contact Hours (Lecture)</th><th style='background-color: lightgreen;'>Contact Hours (Lab)</th>
        <th style='background-color: lightgreen;'>Prerequisite</th><th style='background-color: lightgreen;'>Grade Year</th><th style='background-color: lightgreen;'>Academic Year</th><th style='background-color: lightgreen;'>Semester</th>
        <th style='background-color: lightgreen;'>Final Grade</th><th style='background-color: lightgreen;'>Professor</th></tr>";

    foreach ($courses as $row) {
        echo "<tr>";
        
        echo "<td>" . ($row["course_code"] ?: "") . "</td>";
        echo "<td>" . $row["course_title"] . "</td>";
        echo "<td>" . $row["credit_unit_lec"] . "</td>";
        echo "<td>" . ($row["credit_unit_lab"] ?: "") . "</td>";
        echo "<td>" . $row["contact_hours_lec"] . "</td>";
        echo "<td>" . ($row["contact_hours_lab"] ?: "") . "</td>";
        echo "<td>" . ($row["pre_requisite"] ?: "") . "</td>";
        echo "<td>" . $row["grade_year"] . "</td>";
        echo "<td>" . $row["academic_year"] . "</td>";
        echo "<td>" . $row["semester"] . "</td>";
        echo "<td>" . (isset($row["grade"]) ? $row["grade"] : "") . "</td>";
        echo "<td>" . (isset($row["professor"]) ? $row["professor"] : "") . "</td>";
        echo "</tr>";
    }
    echo "</table></div>";
}

echo "</div>";

$conn->close();

function fetch_courses_by_semester($conn, $start_id, $end_id) {
    $sql = "SELECT courses.course_code, courses.course_title, courses.credit_unit_lec, 
            courses.credit_unit_lab, courses.contact_hours_lec, courses.contact_hours_lab, 
            courses.pre_requisite, courses.grade_year, courses.academic_year, courses.semester, 
            grades.grade, instructor.professor
            FROM courses
            LEFT JOIN grades ON courses.course_code = grades.course_id AND grades.student_id = 202211709
            LEFT JOIN instructor ON courses.course_code = instructor.course_id AND instructor.student_id = 202211709
            WHERE courses.course_id BETWEEN $start_id AND $end_id";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query Failed: " . $conn->error);
    }

    $courses = array();
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    return $courses;
}

?>

<script src = js.js>
</script>


</body>
</html>
