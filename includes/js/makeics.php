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

            var cal = ics();

            

            function addToICS(){
                var input = document.getElementById("search-bar").value;

                var hasLetters = false;

                var course;

                let email = document.getElementById("session-email").innerHTML;
                console.log(email);

                let params = {
                    funcName: "getUserByEmail",
                    email: email
                }
                var user;

                function setUser(responseText){
                    console.log(responseText);
                    let json = JSON.parse(responseText);
                    user = json;
                }

                callFunc(params, setUser);

                console.log(user);
                
                for(var i=0; i<letters.length && !hasLetters; i++){
                    if(input.includes(letters[i])) hasLetters=true;
                }
                if(hasLetters){
                        //Course name
                        params = {
                            funcName: "getCourseByCourseName",
                            course_name: input
                        }

                        function setCourse(responseText){
                            console.log(responseText);
                            let json = JSON.parse(responseText);
                            course = json;
                        }

                        callFunc(params, setCourse);

                        params = {
                            funcName: "addCourseToUser",
                            user_id: user["id"],
                            course_id: course["id"]
                        }

                        function addCourse(responseText){
                            alert(responseText);
                            console.log(responseText);
                        }

                        callFunc(params, addCourse);

                    }
                    else{
                        //Course Number
                        params = {
                            funcName: "getCourseByCourseCode",
                            course_code: input
                        }

                        function setCourse(responseText){
                            console.log(responseText);
                            let json = JSON.parse(responseText);
                            course = json;
                        }

                        callFunc(params, setCourse);

                        params = {
                            funcName: "addCourseToUser",
                            user_id: user["id"],
                            course_id: course["id"]
                        }

                        function addCourse(responseText){
                            alert(responseText);
                            console.log(responseText);
                        }

                        callFunc(params, addCourse);
                    }
            }

            function downloadCal(){
                cal = ics();
                
                let email = document.getElementById("session-email").innerHTML;
                console.log(email);

                let params = {
                    funcName: "getUserByEmail",
                    email: email
                }
                var user;
                var courseArr;

                function setUser(responseText){
                    console.log(responseText);
                    let json = JSON.parse(responseText);
                    user = json;
                }

                callFunc(params, setUser);

                courseArr = user["courses"];

                for(var i = 0; i < courseArr.length; i++){

                    var course = courseArr[i];

                    for(var i = 0; i < course["events"].length; i++){
                        var curr = course["events"][i];
                        if(!curr["repeat"]){
                            cal.addEvent(course["code"].concat(" ", course["labNumber"], course["lectureNumber"], curr["type"], " (", course["name"], ")"), curr["zoomlink"], "Carnegie Mellon University", curr["start"], curr["end"]);
                        }
                        else{
                            var rrule = {
                                freq: "WEEKLY",
                                until: "12/31/2020",
                                interval: curr["repeatinterval"],
                                byday: [weekdays[curr["repeatday"]]]
                            }
                            cal.addEvent(course["code"].concat(" ", course["labNumber"], course["lectureNumber"], curr["type"], " (", course["name"], ")"), curr["zoomlink"], "Carnegie Mellon University", curr["start"], curr["end"], rrule);
                        }
                    }
                }

                    
                
                cal.download();
            }

        </script>