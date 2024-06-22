const box_msg2 = document.getElementById("box_msg");
const box_call = document.getElementById("box_call");
const btn_expand = document.getElementById("btn_expand");
const btn_collapse = document.getElementById("btn_collapse");

function scrollToBottom() {
    box_msg2.scrollTop = box_msg2.scrollHeight;
}

function showVideoCall() {
    btn_expand.classList.remove("d-none");
    btn_collapse.classList.add("d-none");
    box_call.classList.remove("d-none");
}

function hideVideoCall() {
    btn_expand.classList.add("d-none");
    btn_collapse.classList.remove("d-none");
    box_call.classList.add("d-none");
}

scrollToBottom();
box_msg2.addEventListener('DOMNodeInserted', scrollToBottom);
btn_expand.addEventListener('click', hideVideoCall);
btn_collapse.addEventListener('click', showVideoCall);