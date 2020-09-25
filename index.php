<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Home Page </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <meta name="description" content="">
        <!-- header start -->
        <?php include("includes/header.php") ?>
        
        <script>
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
                        repeat: false,
                        repeatday: 1,
                        repeatinterval: 1,
                        zoomlink: "LINK"
                    }
                ]}
                if(hasLetters){
                    //TODO
                }
                else{
                    //TODO
                }

                var cal = ics();

                for(var i = 0; i < course["events"].length; i++){
                    var curr = course["events"][i];
                    if(!curr["repeat"]){
                        cal.addEvent(curr["type"], curr["zoomlink"], "", curr["start"], curr["end"]);
                    }
                    else{
                        var rrule = {
                            freq: "WEEKLY",
                            count: 10,
                            interval: 1,
                            byday: curr["repeatday"]
                        }
                        cal.addEvent(curr["type"], curr["zoomlink"], "", curr["start"], curr["end"], rrule);
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