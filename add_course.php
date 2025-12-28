<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit(); }
include 'functions.php';

if(isset($_POST['add_course'])){
    $courses = getCourses();
    $new_id = count($courses) > 0 ? end($courses)['id'] + 1 : 1;
    $courses[] = [
        "id" => $new_id,
        "exam" => $_POST['exam'],
        "description" => $_POST['description'],
        "videos" => []
    ];
    saveCourses($courses);
    header("Location: dashboard.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Course</title>
</head>
<body>
<h2>Add Course</h2>
<form method="post">
<label>Exam Name:</label><br>
<input type="text" name="exam" required><br>
<label>Description:</label><br>
<textarea name="description" required></textarea><br>
<button type="submit" name="add_course">Add Course</button>
</form>
<p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>