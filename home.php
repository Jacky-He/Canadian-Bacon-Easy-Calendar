<?php 
// session_start();
// if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["user_id"]) || $_SESSION["loggedin"] == false)
// {
//     header("location: index.php");
// }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Home Page </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <meta name="description" content="">
        <!-- header start -->
        <?php include("includes/templates/header.php") ?>
        
        <script>
            function callFunc (postparams, completion)
            {
                let xhttp = new XMLHttpRequest();
                let formData = new FormData();
                for (each in postparams) formData.append (each, postparams[each]);
                xhttp.onreadystatechange = function()
                {
                    if (this.readyState == 4 && this.status == 200)
                    {
                        completion (this.responseText);
                    }
                }
                xhttp.open("POST", "/data/datafunc.php")
                xhttp.send(formData);
            }

            var letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
                           'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            var weekdays = ["SU", "MO", "TU", "WE", "TH", "FR", "SA"];
            function createICS(){
                var input = document.getElementById("text-input").value;
                
                var hasLetters = false;
                
                for(var i=0; i<letters.length && !hasLetters; i++){
                    if(input.includes(letters[i])) hasLetters=true;
                }

                //Hard coded course for now
                var course = {events: [
                    {
                        id: "1",
                        type: "OH",
                        start: "9/26/2020 5:30 pm",
                        end: "9/26/2020 6:30 pm",
                        repeat: true,
                        repeatday: 6,
                        repeatinterval: 1,
                        zoomlink: "LINK1"
                    },
                    {
                        id: "2",
                        type: "OH",
                        start: "9/26/2020 6:30 pm",
                        end: "9/26/2020 7:30 pm",
                        repeat: true,
                        repeatday: 6,
                        repeatinterval: 2,
                        zoomlink: "LINK2"
                    },
                    {
                        id: "3",
                        type: "OH",
                        start: "9/26/2020 7:30 pm",
                        end: "9/26/2020 8:30 pm",
                        repeat: true,
                        repeatday: 6,
                        repeatinterval: 4,
                        zoomlink: "LINK3"
                    },
                    {
                        id: "4",
                        type: "OH",
                        start: "9/26/2020 8:30 pm",
                        end: "9/26/2020 9:30 pm",
                        repeat: false,
                        repeatday: 6,
                        repeatinterval: 1,
                        zoomlink: "LINK4"
                    }
                ]};
                if(hasLetters){
                    //Course name
                    let params = {
                        funcName: "getCourseByCourseName",
                        course_name: input
                    }

                    function setCourse(responseText){
                        console.log(responseText);
                        let json = JSON.parse(responseText);
                        course = json;
                    }

                    callFunc(params, setCourse);
                }
                else{
                    //Course Number
                    let params = {
                        funcName: "getCourseByCourseCode",
                        course_code: input
                    }

                    function setCourse(responseText){
                        console.log(responseText);
                        let json = JSON.parse(responseText);
                        course = json;
                    }

                    callFunc(params, setCourse);
                }

                var cal = ics();

                for(var i = 0; i < course["events"].length; i++){
                    var curr = course["events"][i];
                    if(!curr["repeat"]){
                        cal.addEvent(curr["type"], curr["zoomlink"], "Carnegie Mellon University", curr["start"], curr["end"]);
                    }
                    else{
                        var rrule = {
                            freq: "WEEKLY",
                            count: 10,
                            interval: curr["repeatinterval"],
                            byday: [weekdays[curr["repeatday"]]]
                        }
                        cal.addEvent(curr["type"], curr["zoomlink"], "Carnegie Mellon University", curr["start"], curr["end"], rrule);
                    }
                }

                cal.download();
            }

        </script>
        <a href="#" onclick="javascript:cal.download()">Demo</a>
        <button onclick="createICS()">Click me</button>
        <input id="text-input" type="text" placeholder="stuff"/>
        <script src="/js/test.js"></script>
    </body>
    <!-- footer ends -->
</html>