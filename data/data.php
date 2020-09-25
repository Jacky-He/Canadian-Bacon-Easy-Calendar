<?php

class DB extends SQLite3 
{
    function __construct()
    {
        $this -> open("test.db");
    }
}
// $db = new DB();

// $sql =<<<EOF
// CREATE TABLE COMPANY
// (
//     ID INT PRIMARY KEY NOT NULL,
//     NAME TEXT NOT NULL,
//     AGE INT NOT NULL,
//     ADDRESS CHAR(50),
//     SALARY REAL
// );
// EOF;

// $ret = $db -> exec($sql);

class Event
{
    public $id;
    public $type; //"oh" | "assess"
    public $start;
    public $end;
    public $repeat;
    public $repeatday;
    public $repeatinterval;
    public $zoomlink;

    function __construct(int $id, string $type, DateTime $start, DateTime $end, Boolean $repeat, int $repeatday, int $repeatinterval, string $zoomlink)
    {
        $this->id = $id;
        $this->type = $type;
        $this->start = $start;
        $this->$end = $end;
        $this->$repeat = $repeat;
        $this->$repeatday = $repeatday;
        $this->$zoomlink = $zoomlink;
    }
}

class Course
{
    public $id;
    public $name;
    public $code;
    public $lectureNumber;
    public $labNumber;
    public $events;

    function __construct(int $id, string $name, string $code, string $lectureNumber, string $labNumber, array $events)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->lectureNumber = $lectureNumber;
        $this->labNumber = $labNumber;
        $this->events = $events;
    }
}

class User
{
    public $id;
    public $role;
    public $email;
    public $courses;

    function __construct(int $id, string $role, string $email, array $courses)
    {
        $this->id = $id;
        $this->role = $role;
        $this->email = $email;
        $this->courses = $courses;
    }
}

class ErrorMsg 
{
    public $error;
    function __construct(string $message)
    {
        $this->error = $message;
    }
}

function throwError(string $message)
{
    echo json_encode(new ErrorMsg($message));
    exit;
}

function createDatabases()
{
    $db = new DB();
    $sql =<<<EOF
    CREATE TABLE users
    (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        role TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT NOT NULL
    );
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $sql =<<<EOF
    CREATE TABLE courses
    (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        course_name TEXT NOT NULL,
        course_code TEXT NOT NULL,
        lecture_num TEXT NOT NULL,
        lab_num TEXT NOT NULL
    );
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $sql =<<<EOF
    CREATE TABLE users_courses_link
    (
        user_id INTEGER NOT NULL,
        course_id INTEGER NOT NULL,
        PRIMARY KEY (user_id, course_id)
    );
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $sql =<<<EOF
    CREATE TABLE events
    (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        type TEXT NOT NULL,
        start TEXT NOT NULL,
        end TEXT NOT NULL,
        repeat INTEGER NOT NULL,
        repeatDay INTEGER NOT NULL,
        repeatInterval INTEGER NOT NULL,
        zoomlink TEXT NOT NULL
    );
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $sql =<<<EOF
    CREATE TABLE courses_events_link
    (
        event_id INTEGER NOT NULL,
        course_id INTEGER NOT NULL,
        PRIMARY KEY (event_id, course_id)
    );
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
}

function userEmailExists() : Boolean
{

}

function addUser (string $role, string $email, string $password) : ?User
{
    $db = new DB();
    $sql =<<<EOF
    INSERT INTO users (role, email, password)
    VALUES ('$role', '$email', '$password');
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function removeUser(string $id)
{
    $db = new DB();
    $sql =<<<EOF
    DELETE FROM users WHERE id = $id;
    EOF;
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function courseCodeExists(string $course_code) : Boolean
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM courses WHERE course_code = '$course_code';
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC)) return true;
    return false;
}

function courseNameExists(string $course_name) : Boolean
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM courses WHERE course_name = '$course_name';
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC)) return true;
    return false;
}

function addCourse (string $course_code, string $lecture_num, ?string $recitation_num, string $course_name) : ?Course
{
    $db = new DB();
    $sql =<<<EOF
    EOF;
}

function removeCourse(int $id)
{

}

function addCourseToUser(int $user_id, int $course_id)
{

}

function removeCourseFromUser(int $user_id, int $course_id)
{

}

function addEvent (string $type, DateTime $start, DateTime $end, bool $repeat, int $repeat_day, int $repeat_interval, ?string $zoom_link) : ?Event
{

}

function removeEvent (int $id)
{

}

function addEventToCourse(int $course_id, int $event_id)
{

}

function removeEventFromCourse(int $course_id, int $event_id)
{

}

function getUserById (int $user_id) : ?User
{

}

function getUserByEmail (string $email) : ?User
{

}

function getCourseById (int $course_id) : ?Course
{

}

function getCourseByCourseName (string $course_name) : ?Course
{

}

function getCourseByCourseCode (string $course_code) : ?Course
{

}

function getEventById (int $event_id) : ?Event
{

}

function getAllCourse() : array
{

}

function getAllEvents() : array
{

}

function getAllUsers() : array
{

}
?>