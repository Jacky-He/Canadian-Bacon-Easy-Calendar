



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

let params = {
    funcName: "getCourseByCourseCode",
    course_code: "15-122"
}

function handler(responseText)
{
    alert(responseText);
    let json = JSON.parse(responseText);
    let course_id = json["id"];
    let params2 = {
        funcName: "getAllEvents"
    }
    function handler2(responseText)
    {
        alert(responseText);
        let json2 = JSON.parse(responseText);
        for(let i = 0; i < json2.length; i++)
        {
            let event_id = json2[i]["id"];
            let params3 = {
                funcName: "addEventToCourse",
                course_id: course_id,
                event_id: event_id
            }
            function handler3(responseText)
            {
                alert(responseText);
            }
            callFunc(params3, handler3);
        }
    }
    callFunc(params2, handler2);
}

callFunc(params, handler);