<?php

class DB extends SQLite3 
{
    function __construct()
    {
        $this -> open("test.db");
    }
}
$db = new DB();
if (!$db)
{
    echo $db -> lastErrorMsg();
}
else 
{
    echo "Opened database successfully\n";
}

$sql =<<<EOF
CREATE TABLE COMPANY
(
    ID INT PRIMARY KEY NOT NULL,
    NAME TEXT NOT NULL,
    AGE INT NOT NULL,
    ADDRESS CHAR(50),
    SALARY REAL
);
EOF;

$ret = $db -> exec($sql);
if ($ret)
{
    echo $db -> lastErrorMsg();
}
else 
{
    echo "Table created successfully\n";
}

class Event
{
    public $id;
    public $type; //"oh" | "assess"
    public $start;
    public $end;

    function __construct(int $id, string $type, DateTime $start, DateTime $end)
    {
        $this->id = $id;
        $this->type = $type;
        $this->start = $start;
        $this->$end = $end;
    }
}

class Course
{
    function __construct()
    {

    }
}

class User
{
    function __construct()
    {

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

}

function userEmailExists() : Boolean
{

}

function addUser (string $role, string $email, string $password) : ?User
{

}

function removeUser(int $id)
{

}

function courseCodeExists(string $course_code) : Boolean
{

}

function courseNameExists(string $course_name) : Boolean
{

}

function addCourse (string $course_code, string $lecture_num, ?string $recitation_num, string $course_name) : ?Course
{

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