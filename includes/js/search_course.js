function commonPrefix(str, pattern) {
    for (var i = 0;i < Math.min(str.length, pattern.length);i++) {
        if (str.charAt(i) != pattern.charAt(i)) {
            return i;
        }
    }
    return Math.min(str.length, pattern.length);
}

function courseMatch() {
    let params = {funcName: "getAllCourses"}

    function searchAllCourses(responseText) {
        console.log(responseText);
        var json = JSON.parse(responseText);
        var i,j;
        
        var allCourses = [];
        for (i = 0;i < json.length;i++) {
            allCourses.push(json[i]["name"]);
        }
        console.log(allCourses);

        var target = document.getElementById("search-bar").value;

        target = target.toLowerCase();
        var formattedTarget = new String();
        for (i = 0;i < target.length;i++) {
            if ((target.charAt(i) >= 'a' && target.charAt(i) <= 'z') || 
            (target.charAt(i) >= '0' && target.charAt(i) <= '9')) {
                formattedTarget += target.charAt(i);
            }
            else {
                formattedTarget += " ";
            }
        }
        var keywords = formattedTarget.split(" ");

        var courseKeywords = [];
        for (i = 0;i < allCourses.length;i++) {
            let currentCourse = allCourses[i].toLowerCase();
            let formattedCourse = new String();
            for (j = 0;j < currentCourse.length;j++) {
                if ((currentCourse.charAt(j) >= 'a' && currentCourse.charAt(j) <= 'z') || 
                (currentCourse.charAt(j) >= '0' && currentCourse.charAt(j) <= '9')) {
                    formattedCourse += currentCourse.charAt(j);
                }
                else {
                    formattedCourse += " ";
                }
            }
            courseKeywords.push(formattedCourse.split(" "));
        }

        var wordMatches = [];
        var prefixMatches = [];    

        for (i = 0;i < allCourses.length;i++) {
            wordMatches.push(0);
            prefixMatches.push(0);
        }

        for (i = 0;i < keywords.length;i++) {
            for (j = 0;j < courseKeywords.length;j++) {
                for (k = 0;k < courseKeywords[j].length;k++) {
                    let prefix = commonPrefix(courseKeywords[j][k], keywords[i]);
                    if (prefix == keywords[i].length) {
                        wordMatches[j]++;
                        break;
                    }
                    else {
                        prefixMatches[j] = Math.max(prefixMatches[j], prefix);
                    }
                }
            }
        }

        var bestMatches = [];
        var numSuggestions = 3;
        for (i = 0;i < allCourses.length;i++) {
            let inserted = false;
            for (j = 0;j < bestMatches.length;j++) {
                if (wordMatches[i] > wordMatches[bestMatches[j]] ||
                (wordMatches[i] == wordMatches[bestMatches[j]] && prefixMatches[i] > prefixMatches[bestMatches[j]])) {
                    bestMatches.splice(j,0,i);
                    inserted = true;
                    break;
                }
            }
            if (bestMatches.length > numSuggestions) {
                bestMatches.pop();
            }
            if (!inserted && bestMatches.length < numSuggestions) {
                bestMatches.push(i);
            }
        }

        while (bestMatches.length > 0 &&
        wordMatches[bestMatches[bestMatches.length - 1]] == 0 &&
        prefixMatches[bestMatches[bestMatches.length - 1]] == 0) {
            bestMatches.pop();
        }

        for (i = 0;i < numSuggestions;i++) {
            if (i < bestMatches.length) {
                document.getElementById("suggest" + i).innerHTML = allCourses[bestMatches[i]];
                document.getElementById("suggest" + i).style.display = "block";
            }
            else {
                document.getElementById("suggest" + i).style.display = "none";
            }
        }
    }

    callFunc(params, searchAllCourses);
}

function processKeyDown() {
    courseMatch();
}

function processClick() {
    courseMatch();
}