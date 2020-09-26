<?php 
session_start();
if (isset($_GET["session_email"]) && $_GET["session_email"] != "")
{
    $email = $_GET["session_email"];
    $_SESSION["session_email"] = $email;
    $_SESSION["loggedin"] = true;
}

$course_id = $_GET["id"];

if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["session_email"]) || $_SESSION["loggedin"] == false)
{
    header("location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Course Page </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <meta name="description" content="">
        <script src="/vendors/ics.deps.min.js"></script>
        <script src="/vendors/ics.min.js"></script>
        <script src="/vendors/ics.js"></script>
        <script src="/js/functions.js"></script>
        <link rel="stylesheet" href="/includes/styles/css/styles.css">
        <link rel="stylesheet" href="/prof/course/course.css">
        <link rel="stylesheet" href="/includes/vendors/bootstrap/bootstrap.min.css">
        <script src="/includes/vendors/bootstrap/bootstrap.min.js"></script>
    </head>
    <body>
        <div id="session-email" hidden="true"><?php echo $_SESSION["session_email"]?></div>
        <div id="course-id" hidden="true"><?php echo $course_id?></div>
        <div class="content">
            <div class="topsec">
                <div id="course-code" class="course-code"></div>
                <div id="course-name" class="course-name"></div>
                <div id="lecturenumber" class="lecturenumber"></div>
                <div id="labnumber" class="labnumber"></div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="controlpanel">
                            <div class="event-title">All Events</div>
                            <div id="addbutton" class="addbutton"><img src="/includes/images/add.png" class="add-img"></div>
                        </div>
                        <div id="noevent" class="noevent" hidden="true">There are currently no events</div>
                        <div id="drop-down" class="drop-down">
                            <div class="borderline"></div>
                            <div class="event-container">
                                <span class="type">Office Hours</span><span class="date">Monday</span><span class="time">From 8:00 pm to 9:00 pm </span>
                                <div class="repeat">Repeat Every Week on Monday</div>
                                <span class="zoomlink">Zoom Link: </span><a href="https://us02web.zoom.us/j/87270086552?pwd=dGpwUTdyRi84elBPckdsVXVJSktoUT09" class="link">https://us02web.zoom.us/j/87270086552?pwd=dGpwUTdyRi84elBPckdsVXVJSktoUT09</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="grayout-container" class="grayout-container">
        <div class="form-supercontainer">
            <div class="form-container">
                <div id="cancel" class="cancel"><img src="/includes/images/cancel.png" alt="cancel button" class="cancel-img"/></div>
                <div id="form-title" class="title">Edit Event</div>
                <span class="subtitle">Type</span>
                <div> 
                    <select name="type" id="edit-type">
                        <option value="oh">Office Hours</option>
                        <option value="assess">Assessment</option>
                    </select>
                </div>
                <div class="subtitle">Date</div>
                <div>
                    <span class="subheading">Year</span>
                    <select name="type" id="edit-year">
                        <?php for ($i = 2020; $i <= 2100; $i++)  echo '<option value="'.$i.'">'.$i.'</option>';?>
                    </select>
                    <span class="subheading">Month</span>
                    <select name="type" id="edit-month">
                        <?php for ($i = 1; $i <= 12; $i++)  echo '<option value="'.$i.'">'.$i.'</option>';?>
                    </select>
                    <span class="subheading">Day</span>
                    <select name="type" id="edit-day">
                        <?php for ($i = 1; $i <= 31; $i++)  echo '<option value="'.$i.'">'.$i.'</option>';?>
                    </select>
                </div>
                <div class="subtitle">Start Time</div>
                <div>
                    <span class="subheading">Hour</span>
                    <select name="type" id="edit-start-hour">
                        <?php for ($i = 0; $i <= 23; $i++)  echo '<option value="'.$i.'">'.$i.'</option>';?>
                    </select>
                    <span class="subheading">Minutes</span>
                    <select name="type" id="edit-start-minute">
                        <?php for ($i = 0; $i <= 59; $i++)  echo '<option value="'.$i.'">'.$i.'</option>';?>
                    </select>
                </div>
                <div class="subtitle">End Time</div>
                <div>
                    <span class="subheading">Hour</span>
                    <select name="type" id="edit-end-hour">
                        <?php for ($i = 0; $i <= 23; $i++)  echo '<option value="'.$i.'">'.$i.'</option>';?>
                    </select>
                    <span class="subheading">Minutes</span>
                    <select name="type" id="edit-end-minute">
                        <?php for ($i = 0; $i <= 59; $i++)  echo '<option value="'.$i.'">'.$i.'</option>';?>
                    </select>
                </div>
                <div class="subtitle">Repeat?</div>
                <div>
                    <select name="type" id="edit-repeat">
                       <option value="no">No</option>
                       <option value="yes">Yes</option>
                    </select>
                </div>
                <div class="subtitle" id="repeatfreq" hidden="true">Repeat Frequency</div>
                <div id="repeatfreqop" hidden="true">
                    <select name="type" id="edit-repeatinterval">
                       <option value="1">Once a week</option>
                       <option value="2">Every two weeks</option>
                       <option value="4">Every four weeks</option>
                    </select>
                </div>
                <div class="subtitle">Zoom Link</div>
                <input id="edit-zoomlink" type="text" name="zoomlink" class="input">
                <div id="submit" class="submit">Save</div>
                <div id="delete" class="submit">Delete Event</div>
            </div>
            </div>
        </div>
        <script src="/prof/course/course.js"></script>
    </body>
    <!-- footer ends -->
</html>

<!-- class Event
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
        $this->end = $end;
        $this->repeat = $repeat;
        $this->repeatday = $repeatday;
        $this->repeatinterval = $repeatinterval;
        $this->zoomlink = $zoomlink;
    }
} -->