<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
include 'functions.php';

if(!isset($_GET['course_id'], $_GET['video_id'])){
    echo "Missing parameters";
    exit();
}

$course_id = (int)$_GET['course_id'];
$video_id  = (int)$_GET['video_id'];
$courses = getCourses();

$course_index = null;
foreach($courses as $i => $c){
    if($c['id'] == $course_id){
        $course_index = $i;
        break;
    }
}
if($course_index === null){
    echo "Course not found";
    exit();
}

$video_index = null;
foreach($courses[$course_index]['videos'] as $i => $v){
    if($v['id'] == $video_id){
        $video_index = $i;
        break;
    }
}
if($video_index === null){
    echo "Video not found";
    exit();
}

if(isset($_POST['update_video'])){
    $courses[$course_index]['videos'][$video_index]['title'] = $_POST['title'];
    $courses[$course_index]['videos'][$video_index]['url']   = $_POST['url'];

    saveCourses($courses);
    header("Location: manage_videos.php?course_id=".$course_id);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Video</title>
</head>
<body>
<h2>Edit Video</h2>

<form method="post">
    <label>Video Title</label><br>
    <input type="text" name="title"
           value="<?php echo htmlspecialchars($courses[$course_index]['videos'][$video_index]['title']); ?>"
           required><br><br>

    <label>YouTube Embed URL</label><br>
    <input type="text" name="url"
           value="<?php echo htmlspecialchars($courses[$course_index]['videos'][$video_index]['url']); ?>"
           required><br><br>

    <button type="submit" name="update_video">Update Video</button>
</form>

<p><a href="manage_videos.php?course_id=<?php echo $course_id; ?>">⬅ Back</a></p>
</body>
</html>