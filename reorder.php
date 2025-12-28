<?php
session_start();
if(!isset($_SESSION['admin'])){
    echo json_encode(["status"=>"unauthorized"]);
    exit();
}
include 'functions.php';

$data = json_decode(file_get_contents("php://input"), true);
if(!$data){
    echo json_encode(["status"=>"invalid"]);
    exit();
}

$courses = getCourses();

/* COURSE REORDER */
if($data['type'] === 'course'){
    $new = [];
    foreach($data['order'] as $id){
        foreach($courses as $c){
            if($c['id'] == $id){
                $new[] = $c;
                break;
            }
        }
    }
    saveCourses($new);
    echo json_encode(["status"=>"course_sorted"]);
    exit();
}

/* VIDEO REORDER */
if($data['type'] === 'video'){
    $course_id = $data['course_id'];

    foreach($courses as $ci => $course){
        if($course['id'] == $course_id){
            $newVideos = [];
            foreach($data['order'] as $vid){
                foreach($course['videos'] as $v){
                    if($v['id'] == $vid){
                        $newVideos[] = $v;
                        break;
                    }
                }
            }
            $courses[$ci]['videos'] = $newVideos;
            break;
        }
    }
    saveCourses($courses);
    echo json_encode(["status"=>"video_sorted"]);
    exit();
}

echo json_encode(["status"=>"failed"]);