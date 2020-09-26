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

    function __construct(int $id, string $type, string $start, string $end, bool $repeat, int $repeatday, int $repeatinterval, string $zoomlink)
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

function userEmailExists($email) : bool
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM users WHERE email = '$email';
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC)) return true;
}

function addUser (string $role, string $email, string $password) : ?User
{
    if (userEmailExists($email)) 
    {
        echo "User already exists";
        return null;
    }
    $db = new DB();
    $sql =<<<EOF
    INSERT INTO users (role, email, password)
    VALUES ('$role', '$email', '$password');
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
    return getUserByEmail($email);
}

function removeUser(string $id)
{
    $db = new DB();
    $sql =<<<EOF
    DELETE FROM users WHERE id=$id;
    EOF;
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function courseCodeExists(string $course_code) : bool
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM courses WHERE course_code='$course_code';
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC)) return true;
    return false;
}

function courseNameExists(string $course_name) : bool
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM courses WHERE course_name='$course_name';
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC)) return true;
    return false;
}

function addCourse (string $course_code, string $lecture_num, string $recitation_num, string $course_name) : ?Course
{
    if (courseCodeExists($course_code) || courseNameExists($course_name)) 
    {
        echo "course already exists";
        return null;
    }
    echo "hello";
    $db = new DB();
    $sql =<<<EOF
    INSERT INTO courses (course_name, course_code, lecture_num, lab_num)
    VALUES ('$course_name', '$course_code', '$lecture_num', '$recitation_num');
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    return getCourseByCourseCode($course_code);
}

function removeCourse(string $id)
{
    $db = new DB();
    $sql =<<<EOF
    DELETE FROM courses WHERE id = $id;
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function addCourseToUser(string $user_id, string $course_id)
{
    $db = new DB();
    $sql =<<<EOF
    INSERT INTO users_courses_link (user_id, course_id)
    VALUES ($user_id, $course_id);
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function removeCourseFromUser(string $user_id, string $course_id)
{
    $db = new DB();
    $sql =<<<EOF
    DELTE FROM users_courses_link WHERE user_id=$user_id AND course_id=$course_id;
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function addEvent (string $type, string $start, string $end, bool $repeat, int $repeat_day, int $repeat_interval, string $zoom_link)
{
    $db = new DB();
    $repeated = 0;
    if ($repeat) $repeated = 1;
    $sql =<<<EOF
    INSERT INTO events (type, start, end, repeat, repeatDay, repeatInterval, zoomlink)
    VALUES ('$type', '$start', '$end', '$repeated', $repeat_day, $repeat_interval, '$zoom_link');
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function removeEvent (string $id)
{
    $db = new DB();
    $sql =<<<EOF
    DELETE FROM events WHERE id=$id;
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function addEventToCourse(string $course_id, string $event_id)
{
    $db = new DB();
    $sql =<<<EOF
    INSERT INTO courses_events_link (course_id, event_id) 
    VALUES ($course_id, $event_id);
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function removeEventFromCourse(string $course_id, string $event_id)
{
    $db = new DB();
    $sql =<<<EOF
    DELETE FROM courses_events_link WHERE course_id=$course_id AND event_id=$event_id;
    EOF;
    $ret = $db -> exec($sql);
    if (!$ret) echo $db -> lastErrorMsg();
    $db -> close();
}

function getUserById (string $user_id) : ?User
{
    $db = new DB();
    $courses = array();
    $sql =<<<EOF
    SELECT * FROM users_courses_link WHERE user_id=$user_id;
    EOF;
    $ret = $db -> query($sql);
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) 
    {
        array_push($courses, getCourseById($row["course_id"]));
    }
    $sql =<<<EOF
    SELECT * FROM users WHERE id=$user_id;
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC))
    {
        return new User($row['id'], $row['role'], $row['email'], $courses);
    }
    return null;
}

function getUserByEmail (string $email) : ?User
{
    $db = new DB();
    $courses = array();
    $sql =<<<EOF
    SELECT * FROM users WHERE email='$email';
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC))
    {
        $id = $row['id'];
        $sql =<<<EOF
        SELECT * FROM users_courses_link WHERE user_id=$id;
        EOF;
        $ret2 = $db -> query($sql);
        while ($row2 = $ret2->fetchArray(SQLITE3_ASSOC)) 
        {
            array_push($courses, getCourseById($row2["course_id"]));
        }
        return new User($row['id'], $row['role'], $row['email'], $courses);
    }
    return null;
}

function getCourseById (string $course_id) : ?Course
{
    $db = new DB();
    $events = array();
    $sql =<<<EOF
    SELECT * FROM courses WHERE id=$course_id;
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC))
    {
        $id = $row['id'];
        $sql =<<<EOF
        SELECT * FROM courses_events_link WHERE course_id=$id;
        EOF;
        $ret2= $db -> query($sql);
        while ($row2 = $ret2 -> fetchArray(SQLITE3_ASSOC))
        {
            array_push($events, getEventById($row2['event_id']));
        }
        return new Course($row['id'], $row['course_name'], $row['course_code'], $row['lecture_num'], $row['lab_num'], $events);
    }
    return null;
}

function getCourseByCourseName (string $course_name) : ?Course
{
    $db = new DB();
    $events = array();
    $sql =<<<EOF
    SELECT * FROM courses WHERE course_name='$course_name';
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC))
    {
        $id = $row['id'];
        $sql =<<<EOF
        SELECT * FROM courses_events_link WHERE course_id=$id;
        EOF;
        $ret2= $db -> query($sql);
        while ($row2 = $ret2 -> fetchArray(SQLITE3_ASSOC))
        {
            array_push($events, getEventById($row2['event_id']));
        }
        return new Course($row['id'], $row['course_name'], $row['course_code'], $row['lecture_num'], $row['lab_num'], $events);
    }
    return null;
}

function getCourseByCourseCode (string $course_code) : ?Course
{
    $db = new DB();
    $events = array();
    $sql =<<<EOF
    SELECT * FROM courses WHERE course_code='$course_code';
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret->fetchArray(SQLITE3_ASSOC))
    {
        $id = $row['id'];
        $sql =<<<EOF
        SELECT * FROM courses_events_link WHERE course_id=$id;
        EOF;
        $ret2= $db -> query($sql);
        while ($row2 = $ret2 -> fetchArray(SQLITE3_ASSOC))
        {
            array_push($events, getEventById($row2['event_id']));
        }
        return new Course($row['id'], $row['course_name'], $row['course_code'], $row['lecture_num'], $row['lab_num'], $events);
    }
    return null;
}

function getEventById (string $event_id) : ?Event
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM events WHERE id=$event_id;
    EOF;
    $ret = $db -> query($sql);
    if ($row = $ret -> fetchArray(SQLITE3_ASSOC))
    {
        return new Event ($row['id'], $row['type'], $row['start'], $row['end'], $row['repeat'] == 1, $row['repeatDay'], $row['repeatInterval'], $row['zoomlink']);
    }
    return null;
}

function getAllCourse() : array
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM courses;
    EOF;
    $ret = $db -> query($sql);
    $courses = array();
    while ($row = $ret -> fetchArray(SQLITE3_ASSOC))
    {
        array_push($courses, getCourseById($row['id']));
    }
    return $courses;
}

function getAllEvents() : array
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM events;
    EOF;
    $ret = $db -> query($sql);
    $events = array();
    while($row = $ret -> fetchArray(SQLITE3_ASSOC))
    {
        array_push($events, getEventById($row['id']));
    }
    $db -> close();
    return $events;
}

function getAllUsers() : array
{
    $db = new DB();
    $sql =<<<EOF
    SELECT * FROM users;
    EOF;
    $ret = $db -> query($sql);
    $users = array();
    while ($row = $ret -> fetchArray(SQLITE3_ASSOC))
    {
        array_push($users, getUserById($row['id']));
    }
    $db -> close();
    return $users;
}
?>