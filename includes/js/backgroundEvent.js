function bgClick(e) {
    if (e.target.id != "search-bar" && e.target.id != "dropdown") {
        if (e.target.id.length > 0 && e.target.id.substring(0,e.target.id.length - 1) != "suggest" &&
        e.target.id.substring(0,e.target.id.length - 1) != "courseInList") {
            document.getElementById("dropdown").style.display = "none";
        }
    }

    if (e.target.id.length > 0 && e.target.id.substring(0,e.target.id.length - 1) == "courseInList") {
        document.getElementById("search-bar").value = document.getElementById(e.target.id).innerHTML;
        document.getElementById("dropdown").style.display = "inline-block";
        courseMatch();
    }
}