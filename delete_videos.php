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

foreach($courses as $ci => $course){
    if($course['id'] == $course_id){
        foreach($course['videos'] as $vi => $video){
            if($video['id'] == $video_id){
                array_splice($courses[$ci]['videos'], $vi, 1);
                break;
            }
        }
        break;
    }
}

saveCourses($courses);
header("Location: manage_videos.php?course_id=".$course_id);
exit();