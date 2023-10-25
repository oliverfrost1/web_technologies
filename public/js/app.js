
/**
 * This code checks if the main elements have wrapped, and if they have, it adds justify-content: center
 */
const todoPageLayout = document.querySelector('.todo-page-layout');

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

window.addEventListener('resize', checkWrapAndJustify);
checkWrapAndJustify(); // Initial check


/**
 * This hides the due date until "Add due date" is clicked
 */
const dueDate = document.getElementById('duedate');
const dueDateButton = document.getElementById('dueDateButton');

// This add makes the due date selector visible
function showDueDate() {
    // Change the input type to "date"
    dueDate.type = "date";
    dueDateButton.style.display = "none";
    console.log("called")
}

dueDateButton.addEventListener('click', showDueDate);

/**
 * Handle tags in the sidebar
 */
const toggleButton = document.getElementById('toggle-tag-input');
const tagInput = document.getElementById('tag-choices');
const addTagForm = document.getElementById('add-tag-form');

tagInput.addEventListener('keydown', function(event) {
    if (event.key === 'Enter' && tagInput.value.trim() !== '') {
        // Prevent the default Enter key behavior (e.g., new line in textarea)
        event.preventDefault();
        addTagForm.submit();
    }
});

toggleButton.addEventListener('click', function() {
    toggleButton.style.display = 'none';
    tagInput.style.display = 'block';
    tagInput.focus();
});

tagInput.addEventListener('blur', function() {
    if (tagInput.value === '') {
        toggleButton.style.display = 'block';
        tagInput.style.display = 'none';
    }
});
