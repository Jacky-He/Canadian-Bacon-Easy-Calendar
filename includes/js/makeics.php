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

            function updateList(){
                var list = document.getElementById("course-list");
                while (list.firstChild) {
                    list.firstChild.remove()
                }
                let email = document.getElementById("session-email").innerHTML;

                let params = {
                    funcName: "getUserByEmail",
                    email: email
                }
                var user;
                var courseArr;

                function setUser(responseText){
                    let json = JSON.parse(responseText);
                    user = json;

                    courseArr = user["courses"];

                    for(var i = 0; i < courseArr.length; i++){

                        var course = courseArr[i];
                        var node = document.createElement("LI");
                        node.setAttribute("id", "courseInList" + i);
                        var textnode = document.createTextNode(course["name"]);
                        node.appendChild(textnode); 

                        list.appendChild(node);
                        
                    }
                }

                callFunc(params, setUser);
            }

            function addToICS(){
                var input = document.getElementById("search-bar").value;

                var hasLetters = false;

                var course;

                let email = document.getElementById("session-email").innerHTML;

                let params = {
                    funcName: "getUserByEmail",
                    email: email
                }
                var user;

                function setUser(responseText){
                    let json = JSON.parse(responseText);
                    user = json;

                                    
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
                            let json = JSON.parse(responseText);
                            course = json;

                            params = {
                                funcName: "addCourseToUser",
                                user_id: user["id"],
                                course_id: course["id"]
                            }

                            function addCourse(responseText){
                                updateList();
                            }

                            callFunc(params, addCourse);
                        }

                        callFunc(params, setCourse);



                    }
                    else{
                        //Course Number
                        params = {
                            funcName: "getCourseByCourseCode",
                            course_code: input
                        }

                        function setCourse(responseText){
                            let json = JSON.parse(responseText);
                            course = json;

                            params = {
                                funcName: "addCourseToUser",
                                user_id: user["id"],
                                course_id: course["id"]
                            }

                            function addCourse(responseText){
                                updateList();
                            }

                            callFunc(params, addCourse);
                            
                        }

                        callFunc(params, setCourse);


                    }
                }

                callFunc(params, setUser);


            }

            function removeFromICS(){
                var input = document.getElementById("search-bar").value;

                var hasLetters = false;

                var course;

                let email = document.getElementById("session-email").innerHTML;

                let params = {
                    funcName: "getUserByEmail",
                    email: email
                }
                var user;

                function setUser(responseText){
                    let json = JSON.parse(responseText);
                    user = json;

                                    
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
                            let json = JSON.parse(responseText);
                            course = json;

                            params = {
                                funcName: "removeCourseFromUser",
                                user_id: user["id"],
                                course_id: course["id"]
                            }

                            function removeCourse(responseText){
                                updateList();
                            }

                            callFunc(params, removeCourse);
                        }

                        callFunc(params, setCourse);



                    }
                    else{
                        //Course Number
                        params = {
                            funcName: "getCourseByCourseCode",
                            course_code: input
                        }

                        function setCourse(responseText){
                            let json = JSON.parse(responseText);
                            course = json;

                            params = {
                                funcName: "removeCourseFromUser",
                                user_id: user["id"],
                                course_id: course["id"]
                            }

                            function removeCourse(responseText){
                                updateList();
                            }

                            callFunc(params, removeCourse);
                        }

                        callFunc(params, setCourse);


                    }
                }

                callFunc(params, setUser);


            }

            function downloadCal(){
                
                
                let email = document.getElementById("session-email").innerHTML;

                let params = {
                    funcName: "getUserByEmail",
                    email: email
                }
                var user;
                var courseArr;

                function setUser(responseText){
                    cal = ics();
                    let json = JSON.parse(responseText);
                    user = json;

                    courseArr = user["courses"];
                    for(var i = 0; i < courseArr.length; i++){

                        
                        var course = courseArr[i];
                        for(var j = 0; j < course["events"].length; j++){
                            var curr = course["events"][j];
                            
                            if(!curr["repeat"]){
                                cal.addEvent(course["code"].concat(" ", curr["type"], " (", course["name"], ")"), 
                                curr["zoomlink"], "Carnegie Mellon University", parseInt(curr["start"]), parseInt(curr["end"]));
                            }
                            else{
                                var rrule = {
                                    freq: "WEEKLY",
                                    until: "12/31/2020",
                                    interval: curr["repeatinterval"],
                                    byday: [weekdays[curr["repeatday"]]]
                                }
                                cal.addEvent(course["code"].concat(" ", curr["type"], " (", course["name"], ")"), 
                                curr["zoomlink"], "Carnegie Mellon University", parseInt(curr["start"]), parseInt(curr["end"]), rrule);
                            }
                        }
                    }

                    
                    if(!cal.download()){
                        alert("Calendar is Empty");
                    }
                }

                callFunc(params, setUser);


            }

        </script>