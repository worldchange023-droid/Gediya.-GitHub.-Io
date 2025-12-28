<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit(); }
include 'functions.php';
if(!isset($_GET['id'])){ echo "Course ID missing"; exit(); }

$course_id = $_GET['id'];
$courses = getCourses();
$course_index = null;
foreach($courses as $i=>$c) if($c['id']==$course_id){ $course_index=$i; break; }
if($course_index===null){ echo "Course not found"; exit(); }

if(isset($_POST['edit_course'])){
    $courses[$course_index]['exam'] = $_POST['exam'];
    $courses[$course_index]['description'] = $_POST['description'];
    saveCourses($courses);
    header("Location: dashboard.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Course</title>
</head>
<body>
<h2>Edit Course</h2>
<form method="post">
<label>Exam Name:</label><br>
<input type="text" name="exam" value="<?php echo htmlspecialchars($courses[$course_index]['exam']); ?>" required><br>
<label>Description:</label><br>
<textarea name="description" required><?php echo htmlspecialchars($courses[$course_index]['description']); ?></textarea><br>
<button type="submit" name="edit_course">Update Course</button>
</form>
<p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>