/**
 * This code checks if the main elements have wrapped, and if they have, it adds justify-content: center
 */
const todoPageLayout = document.querySelector(".todo-page-layout");

const checkWrapAndJustify = () => {
    let hasWrap = false;
    let lastItem = null;

    for (const item of todoPageLayout.children) {
        if (lastItem && item.offsetTop > lastItem.offsetTop) {
            hasWrap = true;
            break;
        }
        lastItem = item;
    }

    if (hasWrap) {
        todoPageLayout.style.justifyContent = "center";
    } else {
        todoPageLayout.style.justifyContent = "space-between";
    }
};

window.addEventListener("resize", checkWrapAndJustify);
checkWrapAndJustify(); // Initial check

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

/**
 * Handle tags in the sidebar
 */
const toggleButton = document.getElementById("toggle-tag-input");
const tagInput = document.getElementById("tag-choices");
const addTagForm = document.getElementById("add-tag-form");

tagInput.addEventListener("keydown", function (event) {
    if (event.key === "Enter" && tagInput.value.trim() !== "") {
        event.preventDefault();
        addTagForm.submit();
    }
});


tagInput.addEventListener("blur", function () {
    if (tagInput.value === "") {
        toggleButton.style.display = "block";
        tagInput.style.display = "none";
    }
});

/*
* Change tag edit icon to input field
*/
let prevTagIds = [];
function enableEditField(tagId) {
    if(prevTagIds.length > 0){
        prevTagIds.forEach(tagId => {
            disableEditField(tagId);
        });
    }
    console.log(1);
    prevTagIds = [];
    prevTagIds.push(tagId);
    let tagLabel = document.getElementById('tagLabel-' + tagId);
    tagLabel.style.display = 'none';
    document.getElementById('editField-' + tagId).style.display = 'inline';
    tagLabel.addEventListener("keydown", function (event) {
        if (event.key === "Enter" && tagInput.value.trim() !== "") {
            event.preventDefault();
            disableEditField(tagId);
            addTagForm.submit();
        }
    });
}
function disableEditField(tagId) {
    document.getElementById('editField-' + tagId).style.display = 'none';
    document.getElementById('tagLabel-' + tagId).style.display = 'inline';
}

