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


let course_code = document.getElementById("course-code");
let course_name = document.getElementById("course-name");
let lecturenumber = document.getElementById("lecturenumber");
let labnumber = document.getElementById("labnumber");
let course_id = document.getElementById("course-id").innerHTML;
let dropdown = document.getElementById("drop-down");
let events = [];
let grayout = document.getElementById("grayout-container");
let cancel = document.getElementById("cancel");
let noevent = document.getElementById("noevent");

cancel.addEventListener("click", function(e){
    hideGrayout();
});

setup();

function setup()
{
    let params = {
        funcName: "getCourseById",
        course_id: course_id
    };

    function handler(responseText)
    {
        let json = JSON.parse(responseText);
        course_code.innerHTML = json["code"];
        course_name.innerHTML = json["title"];
        lecturenumber.innerHTML = "Lecture: " + json["lectureNumber"];
        labnumber.innerHTML = "Section: " + json["labNumber"];
        events = json["events"];
        setupEvents();
    }
    callFunc(params, handler);
}


let dayofweek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

function formatDate(date)
{
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let pa = (hours >= 12) ? "pm" : "am";
    hours = (hours > 12) ? hours - 12 : hours;
    let minutetext = (minutes < 10) ? "0" + minutes : minutes;
    return hours + ":" + minutetext + " " + pa;
}

function setupEvents()
{
    let stack = [];
    if (events.length == 0) noevent.hidden = false;
    else noevent.hidden = true;
    for (let i = 0; i < events.length; i++)
    {
        let type = events[i]["type"] == "oh" ? "Office Hours" : "Assessment";
        let date= dayofweek[new Date(parseInt(events[i]["start"], 10)).getDay()];
        let repeattext = "No Repeats";
        let repeat = events[i]["repeat"];
        let zoomlink = events[i]["zoomlink"];
        if (repeat)
        {
            let repeatday = dayofweek[events[i]["repeatday"]];
            let repeatinterval = events[i]["repeatinterval"];
            repeattext = `Repeat Every ${repeatinterval} Week on ${repeatday}`
        }
        let fromtime = new Date(parseInt(events[i]["start"], 10));
        let endtime = new Date(parseInt(events[i]["end"], 10));
        let fromtext = formatDate(fromtime);
        let totext = formatDate(endtime);
        let newhtml = `
        <div class="borderline"></div>
            <div class="event-container">
            <span class="type">${type}</span><span class="date">${date}</span><span class="time">From ${fromtext} to ${totext} </span>
            <div class="repeat">${repeattext}</div>
            <span class="zoomlink">Zoom Link: </span><a href="${zoomlink}" class="link">${zoomlink}</a>
        </div>
        `
        stack.push(newhtml);
    }
    dropdown.innerHTML = stack.join("");
    let eventcontainers = document.getElementsByClassName("event-container");
    for (let i = 0; i < eventcontainers.length; i++)
    {
        eventcontainers[i].addEventListener("click", function(e)
        {
            editEvent(i);
        });
    }
}

function displayGrayout()
{
    grayout.className = "grayout-container active";
}

function hideGrayout()
{
    grayout.className = "grayout-container";
}

let edittype = document.getElementById("edit-type");
let edityear = document.getElementById("edit-year");
let editmonth = document.getElementById("edit-month");
let editday= document.getElementById("edit-day");
let editstarthour = document.getElementById("edit-start-hour");
let editstartminute = document.getElementById("edit-start-minute");
let editendhour = document.getElementById("edit-end-hour");
let editendminute = document.getElementById("edit-end-minute");
let editrepeat = document.getElementById("edit-repeat");
let editrepeatinterval = document.getElementById("edit-repeatinterval");
let editzoomlink = document.getElementById("edit-zoomlink");
let repeatfreq = document.getElementById("repeatfreq");
let repeatfreqop = document.getElementById("repeatfreqop");
let submit = document.getElementById("submit");
let addbutton = document.getElementById("addbutton");
let formtitle = document.getElementById("form-title");
let deletebutton = document.getElementById("delete");

addbutton.addEventListener("click", function(e) {
    addEvent();
})

editrepeat.addEventListener("change", function(e) {
    if (editrepeat.value == "yes")
    {
        repeatfreq.hidden = false;
        repeatfreqop.hidden = false;
    }
    else 
    {
        repeatfreq.hidden = true;
        repeatfreqop.hidden = true;
    }
});

function editEvent(idx)
{
    deletebutton.hidden = false;
    formtitle.innerHTML = "Edit Event";
    editing = true;
    displayGrayout();
    let event = events[idx];

    edittype.value = event["type"];
    edityear.value = new Date(parseInt(event["start"], 10)).getFullYear() + "";
    editmonth.value = new Date(parseInt(event["start"], 10)).getMonth() + 1 + "";
    editday.value = new Date(parseInt(event["start"])).getDate() + "";
    editstarthour.value = new Date(parseInt(event["start"], 10)).getHours() + "";
    editstartminute.value = new Date(parseInt(event["start"], 10)).getMinutes()+ "";
    editendhour.value = new Date(parseInt(event["end"], 10)).getHours() + "";
    editendminute.value = new Date(parseInt(event["end"], 10)).getMinutes() + "";
    editrepeat.value = (event["repeat"] ? "yes" : "no");

    if (editrepeat.value == "yes")
    {
        repeatfreq.hidden = false;
        repeatfreqop.hidden = false;
        editrepeatinterval.value = event["repeatinterval"];
    }
    else 
    {
        repeatfreq.hidden = true;
        repeatfreqop.hidden = true;
    }
    editzoomlink.value = event["zoomlink"];
    submit.onclick = function()
    {
        submitEditedEvent(idx);
    };
    deletebutton.onclick = function()
    {
        deleteEvent(idx);
    }
}

function addEvent()
{
    deletebutton.hidden = true;
    formtitle.innerHTML = "Add Event";
    adding = true;
    displayGrayout();

    edittype.value = "oh";
    edityear.value = "2020";
    editmonth.value = "1";
    editday.value = "1";
    editstarthour.value = "0";
    editstartminute.value = "0";
    editendhour.value = "1";
    editendminute.value = "0";
    editrepeat.value = "no";
    editzoomlink.value = "";
    repeatfreq.hidden = true;
    repeatfreqop.hidden = true;

    submit.onclick = function ()
    {
        submitNewEvent();
    } 
}

function submitNewEvent()
{
    hideGrayout();
    let type = edittype.value;
    let startdate = new Date(parseInt(edityear.value, 10), parseInt(editmonth.value, 10) - 1, parseInt(editday.value, 10), parseInt(editstarthour.value, 10), parseInt(editstartminute.value, 10), 0);
    let enddate = new Date(parseInt(edityear.value, 10), parseInt(editmonth.value, 10) - 1, parseInt(editday.value, 10), parseInt(editendhour.value, 10), parseInt(editendminute.value, 10), 0);
    let repeat = (editrepeat.value == "yes");
    let repeatday = startdate.getDay();
    let repeatInterval = -1;
    if (repeat) repeatInterval = parseInt(editrepeatinterval.value, 10);
    let zoomlink = editzoomlink.value;
    let start = startdate.getTime() + "";
    let end = enddate.getTime() + "";

    let params = {
        funcName: "addEvent",
        type: type,
        start: start,
        end: end,
        repeat: repeat,
        repeat_day: repeatday,
        repeat_interval: repeatInterval,
        zoom_link: zoomlink
    };

    function handler(response)
    {
        let json = JSON.parse(response);
        if (json && json["id"])
        {
            addEventToCourse(json["id"]);
        }
        else 
        {
            alert (response);
        }
    }
    callFunc(params, handler);
}

function addEventToCourse(event_id)
{
    let params = {
        funcName: "addEventToCourse",
        event_id: event_id,
        course_id: course_id,
    };
    function handler(response)
    {
        location.reload();
    }
    callFunc(params, handler);
}

function submitEditedEvent(idx)
{
    let id = events[idx]["id"];
    let type = edittype.value;
    let startdate = new Date(parseInt(edityear.value, 10), parseInt(editmonth.value, 10) - 1, parseInt(editday.value, 10), parseInt(editstarthour.value, 10), parseInt(editstartminute.value, 10), 0);
    let enddate = new Date(parseInt(edityear.value, 10), parseInt(editmonth.value, 10) - 1, parseInt(editday.value, 10), parseInt(editendhour.value, 10), parseInt(editendminute.value, 10), 0);
    let repeat = (editrepeat.value == "yes");
    let repeatday = startdate.getDay();
    let repeatInterval = -1;
    if (repeat) repeatInterval = parseInt(editrepeatinterval.value, 10);
    let zoomlink = editzoomlink.value;
    let start = startdate.getTime() + "";
    let end = enddate.getTime() + "";

    let params = {
        funcName: "setEvent",
        id: id,
        type: type,
        start: start,
        end: end,
        repeat: repeat,
        repeat_day: repeatday,
        repeat_interval: repeatInterval,
        zoom_link: zoomlink
    };

    function handler(response)
    {
        alert(response);
        location.reload();
    }
    callFunc(params, handler);
}

function deleteEvent(idx)
{
    let event_id = events[idx]["id"];
    let params = {
        funcName: "removeEvent",
        id: event_id
    };

    function handler(response)
    {
        location.reload();
    }

    callFunc(params, handler);
}