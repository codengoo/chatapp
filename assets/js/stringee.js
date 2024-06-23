var localVideo = document.getElementById('vid_local');
var remoteVideo = document.getElementById('vid_remote');

var voiceCallButton = $('#btn_call');
var videoCallButton = $('#btn_video');
var switchCameraButton = $('#btn_switch');

var coming_msg = $('#coming_msg');
var answerCallButton = $('#btn_answer');
var rejectCallButton = $('#btn_reject');
var endCallButton = $('#btn_end');

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
        if (state.code === 6 || state.code === 5) {
            voiceCallButton.show();

            videoCallButton.hide();
            switchCameraButton.hide();
            endCallButton.hide();
            coming_msg.hide();

            remoteVideo.srcObject = null;
            localVideo.srcObject = null;
        }
    });
}

jQuery(function () {
    var currentCall = null;

    endCallButton.hide();
    videoCallButton.hide();
    coming_msg.hide();
    switchCameraButton.hide();

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
        coming_msg.hide();
        voiceCallButton.hide();

        endCallButton.show();
        videoCallButton.show();
        switchCameraButton.show();

        currentCall && currentCall.answer();
    });

    rejectCallButton.on('click', function () {
        coming_msg.hide();
        videoCallButton.hide();
        switchCameraButton.hide();

        endCallButton.hide();
        voiceCallButton.show();

        currentCall && currentCall.reject();
    });

    endCallButton.on('click', function () {
        endCallButton.hide();
        videoCallButton.hide();
        switchCameraButton.hide();

        voiceCallButton.show();

        currentCall && currentCall.hangup();
    });

    videoCallButton.on('click', function () {
        currentCall && currentCall.upgradeToVideoCall();
    })

    switchCameraButton.on('click', function () {
        currentCall && currentCall.switchCamera();
    });

    document.addEventListener('connect_ok', function () {
        voiceCallButton.hide();

        endCallButton.show();
        videoCallButton.show();
        switchCameraButton.show();
    });
});