import { getConstants } from "./constants.js";
import "./libs/record.js"

const btnRecord = document.getElementById("btn_record");
const btnStop = document.getElementById("btn_stop");
const btnDelete = document.getElementById("btn_delete");
const btnCall = document.getElementById("btn_call");
const btnSend = document.getElementById("btn_send");
const btnSendAudio = document.getElementById("btn_send_audio");
const countTime = document.getElementById("count_time_record");

const inp_msg = document.getElementById("inp_msg");
const audio_preview = document.getElementById("audio_preview");

audio_preview.style.display = "none";
btnStop.style.display = "none";
btnDelete.style.display = "none";
btnSendAudio.style.display = "none";
countTime.style.display = "none";

var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext;

var blob;
var recordControl;
var input;
var gumStream;
var count = 0;
var timer;

const { chat, userID } = getConstants();

function timeCounter() {
    count++;
    countTime.innerText = secondsToHHMMSS(count);
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

btnRecord.addEventListener("click", function () {
    startRecording();
    this.style.display = "none";
    btnSend.style.display = "none";
    inp_msg.style.display = "none";
    audio_preview.style.display = "none";
    btnDelete.style.display = "none";
    btnCall.style.display = "none";

    btnStop.style.display = "block";
    btnSendAudio.style.display = "block";
    countTime.style.display = "block";
    count = 0;
    timer = setInterval(timeCounter, 1000)
    countTime.innerText = "00:00:00";
});

btnStop.addEventListener("click", function () {
    stopRecording();
    inp_msg.style.display = "none";
    btnCall.style.display = "none";
    this.style.display = "none";
    countTime.style.display = "none";

    audio_preview.style.display = "block";
    btnRecord.style.display = "block";
    btnDelete.style.display = "block";
    count = 0;
    clearInterval(timer);
});

btnDelete.addEventListener("click", function () {
    audio_preview.style.display = "none";
    this.style.display = "none";
    btnSendAudio.style.display = "none";

    inp_msg.style.display = "block";
    btnCall.style.display = "block";
    btnSend.style.display = "block";
});

btnSendAudio.addEventListener("click", function () {
    sendAudio();
    this.style.display = "none";
    audio_preview.style.display = "none";
    btnDelete.style.display = "none";

    inp_msg.style.display = "block";
    btnSend.style.display = "block";
    btnCall.style.display = "block";
});

function startRecording() {
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            audioContext = new AudioContext();
            gumStream = stream;
            input = audioContext.createMediaStreamSource(stream);
            recordControl = new Recorder(input, { numChannels: 2 })
            recordControl.record()
            console.log("Recording started");
        })
        .catch(err => {
            console.error("Error accessing microphone:", err);
        });
}

function stopRecording() {
    recordControl.stop()
    gumStream.getAudioTracks()[0].stop();
    recordControl.exportWAV(function (_blob) {
        blob = _blob;
        console.log(blob);
        audio_preview.src = URL.createObjectURL(blob);
    });

    console.log("Recording started");
}

async function sendAudio() {
    const url = await chat.uploadAudio(blob);
    chat.addMessage(url, userID, "audio")
}
