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


/**
 * Enable tags edit field and delete tag icon
 */


const editIcons = document.querySelectorAll('#enable-edit-field-icon');
const deleteIcons = document.querySelectorAll('#delete-tag-icon');

editIcons.forEach(icon => {
    icon.addEventListener('click', function() {
        enableEditField(this.getAttribute('data-tag-id'));
    });
});

deleteIcons.forEach(icon => {
    icon.addEventListener('click', function() {
        const tagId = this.getAttribute('data-tag-id');
        document.getElementById(`removeTag-${tagId}`).submit();
    });
});

/**
 * Listen for checkbox change and submit form
 */

const tagCheckboxes = document.querySelectorAll('#tag-checkbox');
tagCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        this.form.submit();
    });
});
