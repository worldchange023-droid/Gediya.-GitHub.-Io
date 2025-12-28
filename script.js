// ===============================
// CONFIRM DELETE
// ===============================
document.querySelectorAll(".delete-btn").forEach(btn => {
    btn.addEventListener("click", function(e){
        if(!confirm("Are you sure you want to delete?")){
            e.preventDefault();
        }
    });
});


// ===============================
// DRAG & DROP SORTING
// ===============================
let dragItem = null;

document.querySelectorAll(".sortable li").forEach(item => {

    item.draggable = true;

    item.addEventListener("dragstart", () => {
        dragItem = item;
        item.classList.add("dragging");
    });

    item.addEventListener("dragend", () => {
        dragItem = null;
        item.classList.remove("dragging");
        saveOrder();
    });

    item.addEventListener("dragover", e => {
        e.preventDefault();
        const after = getDragAfterElement(item.parentElement, e.clientY);
        if(after == null){
            item.parentElement.appendChild(dragItem);
        }else{
            item.parentElement.insertBefore(dragItem, after);
        }
    });
});

function getDragAfterElement(container, y){
    const items = [...container.querySelectorAll("li:not(.dragging)")];
    return items.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        if(offset < 0 && offset > closest.offset){
            return { offset, element: child };
        }else{
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}


// ===============================
// SAVE ORDER USING FETCH (AJAX)
// ===============================
function saveOrder(){
    const list = document.querySelector(".sortable");
    if(!list) return;

    const type = list.dataset.type;
    const courseId = list.dataset.course || null;

    let order = [];
    list.querySelectorAll("li").forEach(li => {
        order.push(parseInt(li.dataset.id));
    });

    fetch("reorder.php", {
        method: "POST",
        headers: {"Content-Type":"application/json"},
        body: JSON.stringify({
            type: type,
            course_id: courseId,
            order: order
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Saved:", data.status);
    });
}