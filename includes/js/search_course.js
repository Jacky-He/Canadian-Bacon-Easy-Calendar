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
    let allCourses = ["15-122 principles", "15-151 foundations", "21-295", "15-295", "73-102", "21-122"];
    function setAllCourses(responseText){
        console.log(responseText);
        let json = JSON.parse(responseText);
        allCourses = json;
    }
    callFunc(params, setAllCourses);

    var target = new String("15-122 Principles");
    var i,j;

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
        let formattedCourse = new String();
        for (j = 0;j < allCourses[i].length;j++) {
            if ((allCourses[i].charAt(j) >= 'a' && allCourses[i].charAt(j) <= 'z') || 
            (allCourses[i].charAt(j) >= '0' && allCourses[i].charAt(j) <= '9')) {
                formattedCourse += allCourses[i].charAt(j);
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

    console.log(wordMatches);
    console.log(prefixMatches);

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

    console.log(bestMatches);
}

function processKeyDown() {
    courseMatch();
}

function processClick() {
    courseMatch();
}