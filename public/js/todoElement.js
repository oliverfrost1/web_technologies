/**
 * Submits the form on checkbox click
 */

const todoCheckboxes = document.querySelectorAll('#todoCheckbox');
todoCheckboxesInForm.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        this.form.submit();
    });
});


/**
 * Open edit todo modal and delete todo icon handler
 */

const editIconsTodo = document.querySelectorAll('#edit-todo-icon');
const deleteIconsTodo = document.querySelectorAll('#delete-todo-icon');

editIconsTodo.forEach(icon => {
    icon.addEventListener('click', function() {
        const todoId = this.getAttribute('data-todo-id');
        document.getElementById(`openSelectedWindow-${ todoId}`).submit();
    });
});

deleteIconsTodo.forEach(icon => {
    icon.addEventListener('click', function() {
        const todoId = this.getAttribute('data-todo-id');
        document.getElementById(`deleteTodoElement-${ todoId}`).submit();
    });
});
