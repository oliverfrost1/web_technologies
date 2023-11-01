/**
 * This code checks if the main elements have wrapped, and if they have, it adds justify-content: center
 */
const todoPageLayout = document.querySelector(".todo-page-layout");

const checkWrapAndJustify = () => {
    let hasWrapped = false;
    let lastItem = null;

    for (const item of todoPageLayout.children) {
        if (lastItem && item.offsetTop > lastItem.offsetTop) {
            hasWrapped = true;
            break;
        }
        lastItem = item;
    }

    if (hasWrapped) {
        todoPageLayout.style.justifyContent = "center";
    } else {
        todoPageLayout.style.justifyContent = "space-between";
    }
};

window.addEventListener("resize", checkWrapAndJustify);
checkWrapAndJustify(); // Initial check
