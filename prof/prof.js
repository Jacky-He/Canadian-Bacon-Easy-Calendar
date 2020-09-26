let search = document.getElementById("search-bar");
let dropdown = document.getElementById("drop-down");
let email = document.getElementById("session-email").innerHTML;
let user = {};

search.onchange = handleSearch;
setup();
let courses = [];

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

function setup()
{
    let params = {
        funcName: "getAllCourses"
    };
    function handler(responseText) 
    {
        let json = JSON.parse(responseText);
        courses = json;
    }
    callFunc(params, handler);
    let params2 = {
        funcName: "getUserByEmail",
        email: email,
    };
    function handler2(responseText)
    {
        let json = JSON.parse(responseText);
        if (json) user = json;
        setCourses();
    }
    callFunc(params2, handler2);
}

function handleSearch()
{
    let stack = [];
    let searchstring = search.value.trim();
    let searcharr = searchstring.split(" ");
    for (let i = 0; i < courses.length; i++)
    {
        courses[i]["matchval"] = 0;
    }
    for (let i = 0; i < courses.length; i++)
    {
        let course = courses[i];
        for (let k = 0; k < searcharr.length; k++)
        {
            if (course["code"].includes(searcharr[k])) courses[i]["matchval"]++;
            if (course["title"].includes(searcharr[k])) courses[i]["matchval"]++;
            if (course["lectureNumber"].includes(searcharr[k])) courses[i]["matchval"]++;
            if (course["labNumber"].includes(searcharr[k])) courses[i]["matchval"]++;
        }
    }
    courses.sort(function (a, b)
    {
        return b["matchval"] - a["matchval"];
    });
    for (let i = 0; i < courses.length; i++)
    {
        if (courses[i]["matchval"] != 0)
        {
            let newhtml = `
            <div class="drop-course-item">
                <div class="add-course"><img src="/includes/images/add.png" alt="add icon" class="add-img"/></div>
                <div class="course-code">${courses[i]["code"]}</div>
                <div class="course-name">${courses[i]["title"]}</div>
                <div class="lecture">lecture: ${courses[i]["lectureNumber"]}</div>
                <div class="section">section: ${courses[i]["labNumber"]}</div>
            </div>
            `;
            stack.push(newhtml);
        }
    }
    dropdown.innerHTML = stack.join("");
    let addbuttons = document.getElementsByClassName("add-course");
    for (let i = 0; i < addbuttons.length; i++)
    {
        addbuttons[i].addEventListener("click", function(e) {
            addCourse(i);
        });
    }
}

function addCourse(idx)
{
    // alert ("d");
    let userid = user["id"];
    let usercourses = user["courses"];
    for (let i = 0; i < usercourses.length; i++)
    {
        if (usercourses[i]["id"] == courses[idx]["id"])
        {
            alert ("already added");
            return;
        }
    }
    let params = {
        funcName: "addCourseToUser",
        user_id: userid,
        course_id: courses[idx]["id"]
    }
    function handler (responseText)
    {
        alert (responseText);
        alert ("added");
        location.reload();
    }
    callFunc(params, handler);
}



///courses
let nocourse = document.getElementById("no-course");
let coursecontainer = document.getElementById("courses-container");

function setCourses()
{
    let courses = user["courses"];
    if (courses.length == 0) nocourse.className = "no-course active";
    else nocourse.className = "no-course";
    let stack = [];
    for (let i = 0; i < courses.length; i++)
    {
        let course = courses[i];
        let newhtml = `
        <a href="/prof/course/course.php?id=${course["id"]}" style="text-decoration: none; color: black">
            <div class="underline"></div>
            <span class="course-code">${course["code"]}</span>
            <span class="course-name" style="margin-left: 10px;">${course["title"]}</span>
            <span class="lecture" style="margin-left: 10px;"><span style="font-family:'montserratbold'">lecture: </span>${course["lectureNumber"]}</span>
            <span class="section" style="margin-left: 10px;"><span style="font-family:'montserratbold'">section: </span>${course["labNumber"]}</span>
        </a>
        `
        stack.push(newhtml);
    }
    coursecontainer.innerHTML = stack.join("");
}