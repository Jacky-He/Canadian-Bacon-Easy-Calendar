let inputbutton = document.getElementById("test-input");

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