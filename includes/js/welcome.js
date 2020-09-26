
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
    
}

function displayLogin()
{

}