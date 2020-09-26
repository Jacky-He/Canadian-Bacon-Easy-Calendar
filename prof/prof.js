let search = document.getElementById("search-bar");
let dropdown = document.getElementById("drop-down");

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
            if (course["name"].includes(searcharr[k])) courses[i]["matchval"]++;
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
                <div class="course-name">${courses[i]["name"]}</div>
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
        addbuttons[i].addEventListener("click", function(e)
        {
            addCourse(i);
        })
    }
}

function addCourse(idx)
{
    
}