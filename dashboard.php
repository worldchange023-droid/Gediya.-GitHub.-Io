<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit(); }
include 'functions.php';
$courses = getCourses();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - Admin</title>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<style>
body{font-family:Arial;padding:20px;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{border:1px solid #ccc;padding:10px;text-align:left;}
th{background:#007BFF;color:#fff;}
tr.ui-state-highlight{height:40px;background:#fffa90;}
a{margin-right:10px;}
</style>
</head>
<body>
<h2>Dashboard - Courses</h2>
<p><a href="add_course.php">Add New Course</a> | <a href="logout.php">Logout</a></p>

<table id="courses-table">
<thead>
<tr><th>ID</th><th>Exam</th><th>Description</th><th>Actions</th></tr>
</thead>
<tbody>
<?php foreach($courses as $c): ?>
<tr data-id="<?php echo $c['id']; ?>">
<td><?php echo $c['id']; ?></td>
<td><?php echo htmlspecialchars($c['exam']); ?></td>
<td><?php echo htmlspecialchars($c['description']); ?></td>
<td>
<a href="edit_course.php?id=<?php echo $c['id']; ?>">Edit</a>
<a href="delete_course.php?id=<?php echo $c['id']; ?>" onclick="return confirm('Delete course?')">Delete</a>
<a href="manage_videos.php?course_id=<?php echo $c['id']; ?>">Videos</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<script>
$(function(){
$("#courses-table tbody").sortable({
    placeholder:"ui-state-highlight",
    update:function(){
        var order=[];
        $(this).children("tr").each(function(){ order.push($(this).data("id")); });
        $.ajax({
            url:"reorder.php",
            method:"POST",
            contentType:"application/json",
            data:JSON.stringify({order:order,type:'course'}),
            success:function(res){ console.log("Reorder saved",res); }
        });
    }
}).disableSelection();
});
</script>
</body>
</html>