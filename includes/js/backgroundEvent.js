function bgClick(e) {
    if (e.target.id != "search-bar" && e.target.id != "dropdown" &&
    e.target.id.substring(0,e.target.id.length - 1) != "suggest") {
        document.getElementById("dropdown").style.display = "none";
    }
}