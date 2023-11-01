/*
* Change tag edit icon to input field
*/
function enableEditField(tagId) {
    let prevTagIds = [];
    if(prevTagIds.length > 0){
        prevTagIds.forEach(tagId => {
            disableEditField(tagId);
        });
    }
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

