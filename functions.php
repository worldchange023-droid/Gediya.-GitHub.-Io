<?php
function getCourses(){
    return json_decode(file_get_contents("../data/courses.json"), true);
}
function saveCourses($courses){
    file_put_contents("../data/courses.json", json_encode($courses, JSON_PRETTY_PRINT));
}
function getCourseById($id){
    $courses = getCourses();
    foreach($courses as $c) if($c['id']==$id) return $c;
    return null;
}
function getVideoById($course,$vid){
    foreach($course['videos'] as $v) if($v['id']==$vid) return $v;
    return null;
}
?>