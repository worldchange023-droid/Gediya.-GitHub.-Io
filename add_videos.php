<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
include 'functions.php';

if(!isset($_GET['course_id'])){
    echo "Course ID missing";
    exit();
}

$course_id = (int)$_GET['course_id'];
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

if(isset($_POST['add_video'])){
    $videos = $courses[$course_index]['videos'];
    $new_id = count($videos) > 0 ? end($videos)['id'] + 1 : 1;

    $courses[$course_index]['videos'][] = [
        "id" => $new_id,
        "title" => $_POST['title'],
        "url" => $_POST['url']
    ];

    saveCourses($courses);
    header("Location: manage_videos.php?course_id=".$course_id);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Video</title>
</head>
<body>
<h2>Add Video</h2>

<form method="post">
    <label>Video Title</label><br>
    <input type="text" name="title" required><br><br>

    <label>YouTube Embed URL</label><br>
    <input type="text" name="url" placeholder="https://www.youtube.com/embed/xxxx" required><br><br>

    <button type="submit" name="add_video">Add Video</button>
</form>

<p><a href="manage_videos.php?course_id=<?php echo $course_id; ?>">⬅ Back</a></p>
</body>
</html>