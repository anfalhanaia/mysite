function addCourse() {
    var div = document.getElementById('courses');
    var newRow = document.createElement('div');
    newRow.className = 'course-row';
    newRow.innerHTML = `
        <input type="text" name="course[]" placeholder="Course Name" required>
        <input type="number" name="credits[]" placeholder="Credits" min="1" required>
        <select name="grade[]">
            <option value="4.0">A</option>
            <option value="3.0">B</option>
            <option value="2.0">C</option>
            <option value="1.0">D</option>
            <option value="0.0">F</option>
        </select>
        <button type="button" onclick="this.parentNode.remove()">Remove</button>
    `;
    div.appendChild(newRow);
}

function validateForm() {
    var courses = document.querySelectorAll('[name="course[]"]');
    var credits = document.querySelectorAll('[name="credits[]"]');
    
    for (var i = 0; i < courses.length; i++) {
        if (courses[i].value.trim() == "") {
            alert("Course name required");
            return false;
        }
    }
    
    for (var j = 0; j < credits.length; j++) {
        if (credits[j].value <= 0 || isNaN(credits[j].value)) {
            alert("Credits must be positive number");
            return false;
        }
    }
    return true;
}
