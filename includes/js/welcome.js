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

// let postparams = {
//     funcName: "addCourse",
//     course_code: "15-122",
//     lecture_num: "2",
//     recitation_num: "P",
//     course_name: "Principles of Imperative "
//     //role: "student",
//     email: "junchenh@andrew.cmu.edu",
//     password: "123"
// }


$course_code = $_POST["course_code"];
$lecture_num = $_POST["lecture_num"];
$recitation_num = $_POST["recitation_num"];
$course_name = $_POST["course_name"];
if ($course_code == "") throwError("no parameter course_code");
if ($lecture_num == "") throwError("no parameter lecture_num");
if ($recitation_num == "") throwError("no parameter recitation_num");
if ($course_name == "") throwError("no parameter course_name");

function handleAddUser(responseText)
{
    alert (responseText);
    let json = JSON.parse(reponseText);
}

callFunc(postparams, handleAddUser);