/**
 * Handle tags in the sidebar
 */
const tagInput = document.getElementById("tag-choices");
const addTagForm = document.getElementById("add-tag-form");



if(tagInput !== null){
    tagInput.addEventListener("keydown", function (event) {
        if (event.key === "Enter" && tagInput.value.trim() !== "") {
            event.preventDefault();
            addTagForm.submit();
        }
    });
    tagInput.addEventListener("blur", function () {
        if (tagInput.value === "") {
            tagInput.style.display = "none";
        }
    });
}
