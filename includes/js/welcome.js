
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

let studbutton = document.getElementById("studbutton");
let profbutton = document.getElementById("profbutton");
let signupbutton = document.getElementById("signup");
let loginbutton = document.getElementById("login");
let formtitle = document.getElementById("form-title");
let submit = document.getElementById("submit");
let username = document.getElementById("username");
let password = document.getElementById("password");
let grayout = document.getElementById("grayout-container");
let cancel = document.getElementById("cancel");

submit.addEventListener("click", function(e){
    if (formtitle.innerHTML == "Sign Up")
    {
        submitSignUp();
    }
    else if (formtitle.innerHTML == "Log In")
    {
        submitLogIn();
    }
})

cancel.addEventListener("click", function (e) {
    hideGrayout();
});

studbutton.addEventListener("click", function (e) {
    studbutton.className = "rolebutton active";
    profbutton.className = "rolebutton";
});

profbutton.addEventListener("click", function (e) {
    studbutton.className = "rolebutton";
    profbutton.className = "rolebutton active";
})

signupbutton.addEventListener("click", function(e) {
    displaySignup();
});

loginbutton.addEventListener("click", function(e) {
    displayLogin();
});

function displaySignup()
{
    formtitle.innerHTML = "Sign Up";
    grayout.className = "grayout-container active";
}

function displayLogin()
{
    formtitle.innerHTML = "Log In";
    grayout.className = "grayout-container active";
}

function hideGrayout()
{
    grayout.className = "grayout-container";
}

function submitSignUp()
{
    let role = (studbutton.className == "rolebutton active" ? "stud" : "prof");
    let email = username.value.trim();
    let pass = password.value;
    let params = {
        funcName: "addUser",
        role: role,
        email: email,
        password: pass
    };
    function handler (responseText)
    {
        let json = JSON.parse(responseText);
        if (json && json["id"]) 
        {
            hideGrayout();
        }
        else alert(responseText);
    }
    callFunc(params, handler);
}

function submitLogIn()
{
    let email = username.value.trim();
    let pass = password.value;
    let params = {
        funcName: "getAllUsers"
    };
    function handler(responseText)
    {
        // alert (responseText);
        let json = JSON.parse(responseText);
        for (let i = 0; i < json.length; i++)
        {
            if (json[i]["email"] == email && json[i]["password"] == pass)
            {
                hideGrayout();
                if (json[i]["role"] == "stud") window.location.replace("/dashboard.php?session_email=" + email);
                else if (json[i]["role"] == "prof") window.location.replace("/prof/index.php?session_email=" + email);
                break;
            }
        }
    }
    callFunc(params, handler);
}