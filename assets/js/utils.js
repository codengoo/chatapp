var IS_FIRST_LOAD = true;

export function render(el, msgList, userID) {
    console.log(msgList);

    if (IS_FIRST_LOAD) {
        msgList.forEach(msg => buildContent(el, msg, userID));
        IS_FIRST_LOAD = false;
    } else if (msgList.length > 0) {
        buildContent(el, msgList[msgList.length - 1], userID);
    }
}

export function buildContent(el, msg, userID) {
    const content = document.createElement('div');
    const message = msg.data.message;
    const messageUser = msg.data.user;

    content.innerHTML = userID === messageUser
        ? renderMyMessage(1, message)
        : renderYourMessage(1, message);

    el.appendChild(content)
}

export function renderMyMessage(time, message) {
    return (
        `<div class="d-flex justify-content-end">
            <div class="bg-primary d-flex justify-content-between w-75 text-white text-right gap-2 ">
                <p class="m-0 text-small bg-dark p-2">10:33 2/9/24</p>
                <p class="m-0 p-2">${message}</p>
            </div>
        </div>`
    )
}

export function renderYourMessage(time, message) {
    return (
        `<div class="d-flex justify-content-start">
            <div class="bg-dark d-flex justify-content-between w-75 text-white text-right gap-2 ">
                <p class="m-0 text-small bg-primary p-2">10:33 2/9/24</p>
                <p class="m-0 p-2">${message}</p>
            </div>
        </div>`
    )
}

export function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\\[\\]]/g, '\\\\$&');
    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
    const results = regex.exec(url);
    if (!results) return null;
    return results[2] || '';
}