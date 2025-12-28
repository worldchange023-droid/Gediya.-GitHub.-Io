<?php
session_start();
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit(); }
include 'functions.php';
if(!isset($_GET['id'])){ echo "Course ID missing"; exit(); }

$course_id = $_GET['id'];
$courses = getCourses();
foreach($courses as $i=>$c) if($c['id']==$course_id){ array_splice($courses,$i,1); break; }
saveCourses($courses);
header("Location: dashboard.php");
exit();