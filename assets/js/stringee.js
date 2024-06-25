var localVideo = document.getElementById('vid_local');
var remoteVideo = document.getElementById('vid_remote');

var voiceCallButton = $('#btn_call');
var videoCallButton = $('#btn_video');
var switchCameraButton = $('#btn_switch');

var expandBtn = $('#btn_expand');
var collapseBtn = $('#btn_collapse');

var coming_msg = $('#coming_msg');
var answerCallButton = $('#btn_answer');
var rejectCallButton = $('#btn_reject');
var endCallButton = $('#btn_end');
var countTime = $('#count_time');
var count = 0;
var timer;

function timeCounter() {
    count++;
    countTime[0].innerText = secondsToHHMMSS(count);
}

function secondsToHHMMSS(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secondsLeft = seconds % 60;

    const formattedHours = hours.toString().padStart(2, '0');
    const formattedMinutes = minutes.toString().padStart(2, '0');
    const formattedSeconds = secondsLeft.toString().padStart(2, '0');

    return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
}

function showCallBoxFirst() {
    const box_call = document.getElementById("box_call");
    const chat_call = document.getElementById("chat_call");

    box_call.classList.add("order-1");
    box_call.classList.remove("order-2");
    chat_call.classList.add("order-2");
    chat_call.classList.remove("order-1");
}

function showChatBoxFirst() {
    const box_call = document.getElementById("box_call");
    const chat_call = document.getElementById("chat_call");

    console.log("hello");

    box_call.classList.add("order-2");
    box_call.classList.remove("order-1");
    chat_call.classList.add("order-1");
    chat_call.classList.remove("order-2");
}

function setupCall(callInstance) {
    callInstance.on('addremotestream', function (stream) {
        remoteVideo.srcObject = null;
        remoteVideo.srcObject = stream;
    });

    callInstance.on('addlocalstream', function (stream) {
        localVideo.srcObject = null;
        localVideo.srcObject = stream;
    });

    callInstance.on('signalingstate', function (state) {
        console.log(state);
        if (state.code === 6 || state.code === 5) {
            count = 0;
            clearInterval(timer);
            countTime[0].innerText = "00:00:00";
            voiceCallButton.show();

            videoCallButton.hide();
            switchCameraButton.hide();
            countTime.hide();
            endCallButton.hide();
            coming_msg.hide();
            expandBtn.hide();

            remoteVideo.srcObject = null;
            localVideo.srcObject = null;
            showChatBoxFirst();
        } else if (state.code === 3) {
            timer = setInterval(timeCounter, 1000)
        }
    });
}

jQuery(function () {
    var currentCall = null;

    count = 0;
    endCallButton.hide();
    videoCallButton.hide();
    coming_msg.hide();
    switchCameraButton.hide();
    countTime.hide();
    expandBtn.hide();

    var client = new StringeeClient();
    client.connect(token);

    client.on('connect', function () {
        console.log('stringee connected!');
    });

    client.on('authen', function (res) {
        console.log('stringee authenticated: ', res);
    });

    client.on('disconnect', function (res) {
        console.log('stringee disconnected');
    });

    //MAKE CALL
    voiceCallButton.on('click', function () {
        showCallBoxFirst();
        currentCall = new StringeeCall(client, callerId, calleeId, false);
        setupCall(currentCall);

        currentCall.makeCall(function (res) {
            console.log('stringee call callback: ', res);
            if (res.message === 'SUCCESS') {
                document.dispatchEvent(new Event('connect_ok'));
            }
        });

    });

    //RECEIVE CALL
    client.on('incomingcall', function (incomingcall) {
        coming_msg.show();
        currentCall = incomingcall;
        setupCall(currentCall);

        voiceCallButton.hide();
        answerCallButton.show();
        rejectCallButton.show();
    });

    answerCallButton.on('click', function () {
        showCallBoxFirst();
        coming_msg.hide();
        voiceCallButton.hide();
        timer = setInterval(timeCounter, 1000)

        endCallButton.show();
        videoCallButton.show();
        switchCameraButton.show();
        countTime.show();
        expandBtn.show();

        currentCall && currentCall.answer();
    });

    rejectCallButton.on('click', function () {
        showChatBoxFirst();
        coming_msg.hide();
        videoCallButton.hide();
        switchCameraButton.hide();
        countTime.hide();
        expandBtn.hide();

        count = 0;
        clearInterval(timer);
        countTime[0].innerText = "00:00:00";

        endCallButton.hide();
        voiceCallButton.show();

        currentCall && currentCall.reject();
    });

    endCallButton.on('click', function () {
        showChatBoxFirst();
        endCallButton.hide();
        videoCallButton.hide();
        switchCameraButton.hide();
        countTime.hide();
        expandBtn.hide();

        count = 0;
        clearInterval(timer);
        countTime[0].innerText = "00:00:00";

        voiceCallButton.show();

        currentCall && currentCall.hangup();
    });

    videoCallButton.on('click', function () {
        currentCall && currentCall.upgradeToVideoCall();
    })

    switchCameraButton.on('click', function () {
        currentCall && currentCall.switchCamera();
    });

    expandBtn.on('click', showCallBoxFirst);
    collapseBtn.on('click', showChatBoxFirst);

    document.addEventListener('connect_ok', function () {
        voiceCallButton.hide();
        
        expandBtn.show();
        endCallButton.show();
        videoCallButton.show();
        switchCameraButton.show();
        countTime.show();
    });
});