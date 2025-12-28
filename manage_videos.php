<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit(); }
include 'functions.php';
if(!isset($_GET['course_id'])){ echo "Course ID missing"; exit(); }

$course_id = $_GET['course_id'];
$course = getCourseById($course_id);
if(!$course){ echo "Course not found"; exit(); }
$videos = $course['videos'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Videos - <?php echo htmlspecialchars($course['exam']); ?></title>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<style>
body{font-family:Arial;padding:20px;}
table{width:100%;border-collapse:collapse;margin-top:20px;}
th,td{border:1px solid #ccc;padding:10px;text-align:left;}
th{background:#28a745;color:#fff;}
tr.ui-state-highlight{height:40px;background:#fffa90;}
a{margin-right:10px;}
</style>
</head>
<body>
<h2>Manage Videos - <?php echo htmlspecialchars($course['exam']); ?></h2>
<p><a href="add_video.php?course_id=<?php echo $course_id; ?>">Add New Video</a> | <a href="dashboard.php">Back to Dashboard</a></p>

<table id="videos-table">
<thead>
<tr><th>ID</th><th>Title</th><th>URL</th><th>Actions</th></tr>
</thead>
<tbody>
<?php foreach($videos as $v): ?>
<tr data-id="<?php echo $v['id']; ?>">
<td><?php echo $v['id']; ?></td>
<td><?php echo htmlspecialchars($v['title']); ?></td>
<td><?php echo htmlspecialchars($v['url']); ?></td>
<td>
<a href="edit_video.php?course_id=<?php echo $course_id; ?>&video_id=<?php echo $v['id']; ?>">Edit</a>
<a href="delete_video.php?course_id=<?php echo $course_id; ?>&video_id=<?php echo $v['id']; ?>" onclick="return confirm('Delete video?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<script>
$(function(){
$("#videos-table tbody").sortable({
    placeholder:"ui-state-highlight",
    update:function(){
        var order=[];
        $(this).children("tr").each(function(){ order.push($(this).data("id")); });
        $.ajax({
            url:"reorder.php",
            method:"POST",
            contentType:"application/json",
            data:JSON.stringify({order:order,type:'video',course_id:<?php echo $course_id; ?>}),
            success:function(res){ console.log("Reorder saved",res); }
        });
    }
}).disableSelection();
});
</script>
</body>
</html>