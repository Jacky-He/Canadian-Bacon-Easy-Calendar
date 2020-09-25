<?php include("data.php") ?>
<?php 
$funcName = $_POST["funcName"];
if ($funcName == "createDatabases")
{
    createDatabases();
}
else if ($funcName == "userEmailExists")
{
    $email = $_POST["email"];
    if ($email == "") throwError("no parameter email");
    echo json_encode(userEmailExists($email));
}
else if ($funcName == "addUser")
{
    $role = $_POST["role"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    if ($role == "") throwError("no parameter role");
    if ($email == "") throwError("no parameter email");
    if ($password == "") throwError("no parameter password");
    echo json_encode(addUser($role, $email, $password));
}
else if ($funcName == "removeUser")
{
    $id = $_POST["id"];
    if ($id == "") throwError("no parameter id");
    removeUser($id);
}
else if ($funcName == "courseCodeExists")
{
    $course_code = $_POST["course_code"];
    if ($course_code == "") throwError("no parameter course_code");
    courseCodeExists($course_code);
}
else if ($funcName == "courseNameExists")
{
    $course_name = $_POST["course_name"];
    if ($course_name == "") throwError("no parameter course_name");
    courseNameExists($course_name);
}
else if ($funcName == "addCourse")
{
    $course_code = $_POST["course_code"];
    $lecture_num = $_POST["lecture_num"];
    $recitation_num = $_POST["recitation_num"];
    $course_name = $_POST["course_name"];
    if ($course_code == "") throwError("no parameter course_code");
    if ($lecture_num == "") throwError("no parameter lecture_num");
    if ($recitation_num == "") throwError("no parameter recitation_num");
    if ($course_name == "") throwError("no parameter course_name");
    echo json_encode(addCourse($course_code, $lecture_num, $recitation_num, $course_name));
}
else if ($funcName == "removeCourse")
{
    $id = $_POST["id"];
    if ($id == "") throwError("no parameter id");
    removeCourse($id);
}
else if ($funcName == "addCourseToUser")
{
    $user_id = $_POST["user_id"];
    $course_id = $_POST["course_id"];
    if ($user_id == "") throwError("no parameter user_id");
    if ($course_id == "") throwError("no parameter course_id");
    addCourseToUser($user_id, $course_id);
}
else if ($funcName == "removeCourseFromUser")
{
    $user_id = $_POST["user_id"];
    $course_id = $_POST["course_id"];
    if ($user_id == "") throwError("no parameter user_id");
    if ($course_id == "") throwError("no parameter course_id");
    removeCourseFromUser($user_id, $course_id);
}
else if ($funcName == "addEvent")
{
    $type = $_POST["type"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $repeat = $_POST["repeat"];
    $repeat_day = $_POST["repeat_day"];
    $repeat_interval = $_POST["repeat_interval"];
    $zoom_link = $_POST["zoom_link"];
    if ($type == "") throwError("no parameter type");
    if ($start == "") throwError("no parameter start");
    if ($end == "") throwError("no parameter end");
    if ($repeat == "") throwError("no parameter repeat");
    if ($repeat_day == "") throwError("no parameter repeat_day");
    if ($repeat_interval == "") throwError("no parameter repeat_interval");
    if ($zoom_link == "") throwError("no parameter zoom_link");
    echo json_encode(addEvent ($type, $start, $end, intval($repeat), intval($repeat_day), intval($repeat_interval), $zoom_link));
}
else if ($funcName == "removeEvent")
{
    $id = $_POST["id"];
    if ($id == "") throwError("no parameter id");
    removeEvent($id);
}
else if ($funcName == "addEventToCourse")
{
    $course_id = $_POST["course_id"];
    $event_id = $_POST["event_id"];
    if ($course_id == "") throwError("no parameter course_id");
    if ($event_id == "") throwError("no parameter event_id");
    addEventToCourse($course_id, $event_id);
}
else if ($funcName == "removeEventFromCourse")
{
    $course_id = $_POST["course_id"];
    $event_id = $_POST["event_id"];
    if ($course_id == "") throwError("no parameter course_id");
    if ($event_id == "") throwError("no parameter event_id");
    removeEventFromCourse($course_id, $event_id);
}
else if ($funcName == "getUserById")
{
    $user_id = $_POST["user_id"];
    if ($user_id == "") throwError("no parameter user_id");
    echo json_encode(getUserById($user_id));
}
else if ($funcName == "getUserByEmail")
{
    $email = $_POST["email"];
    if ($email == "") throwError("no parameter email");
    echo json_encode(getUserByEmail($email));
}
else if ($funcName == "getCourseById")
{
    $course_id = $_POST["course_id"];
    if ($course_id == "") throwError("no parameter course_id");
    echo json_encode(getCourseById($course_id));
}
else if ($funcName == "getCourseByCourseName")
{
    $course_name = $_POST["course_name"];
    if ($course_name == "") throwError("no parameter course_name");
    echo json_encode(getCourseByCourseName($course_name));
}
else if ($funcName == "getCourseByCourseCode")
{
    $course_code = $_POST["course_code"];
    if ($course_code == "") throwError("no parameter course_code");
    echo json_encode(getCourseByCourseCode($course_code));
}
else if ($funcName == "getEventById")
{
    $event_id = $_POST["event_id"];
    if ($event_id == "") throwError("no parameter event_id");
    echo json_encode(getEventById($event_id));
}
else if ($funcName == "getAllCourses")
{
    echo json_encode(getAllCourses());
}
else if ($funcName == "getAllEvents")
{
    echo json_encode(getAllEvents());
}
else if ($funcName == "getAllUsers")
{
    echo json_encode(getAllUsers());
}
else 
{
    throwError("not a valid function name");
}
?>