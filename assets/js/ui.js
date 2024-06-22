const box_msg2 = document.getElementById("box_msg");
const box_call = document.getElementById("box_call");
const btn_expand = document.getElementById("btn_expand");
const btn_collapse = document.getElementById("btn_collapse");

function scrollToBottom() {
    box_msg2.scrollTop = box_msg2.scrollHeight;
}

function inverseOrder() {
    if (box_call.classList.contains("order-1")) {
        box_call.classList.add("order-2");
        box_call.classList.remove("order-1");
    } else {
        box_call.classList.add("order-1");
        box_call.classList.remove("order-2");
    }
}

scrollToBottom();
box_msg2.addEventListener('DOMNodeInserted', scrollToBottom);
btn_expand.addEventListener('click', inverseOrder);
btn_collapse.addEventListener('click', inverseOrder);