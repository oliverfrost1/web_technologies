/**
 * This hides the due date until "Add due date" is clicked
 */
const dueDate = document.getElementById("duedate");
const dueDateButton = document.getElementById("dueDateButton");

// This makes the due date selector visible
function showDueDate() {
    dueDate.type = "date";
    dueDateButton.style.display = "none";
}

dueDateButton.addEventListener("click", showDueDate);
