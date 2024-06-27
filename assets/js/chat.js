import firebaseConfig from "../../firebase.json" with { type: 'json' };
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js'
import {
    getFirestore, collection, getDocs, addDoc, onSnapshot, Timestamp, query, orderBy
} from "https://cdnjs.cloudflare.com/ajax/libs/firebase/10.12.2/firebase-firestore.min.js";

import {
    getStorage, ref, uploadBytes, getDownloadURL, uploadBytesResumable
} from "https://cdnjs.cloudflare.com/ajax/libs/firebase/10.12.2/firebase-storage.min.js";

export class Chat {
    Calling = '<calling>';

    constructor(roomID) {
        this.app = initializeApp(firebaseConfig);
        this.db = getFirestore(this.app);
        this.storage = getStorage(this.app);

        // Setup text chat
        this.roomID = roomID;
        this.roomRef = collection(this.db, 'data', 'room', this.roomID)
        this.query = query(this.roomRef, orderBy("created", "asc"));
    }

    transform(data) {
        let tmp = [];
        data.forEach(doc => {
            tmp.push({
                id: doc.id,
                data: doc.data()
            })
        })

        return tmp;
    }

    getRoomRef() {
        return this.roomRef
    }

    async getMessage() {
        const data = await getDocs(this.roomRef);

        return this.transform(data);
    }

    async addMessage(message, userID, type = "message") {
        if (message.trim() === '') {
            alert("Phải có nội dung trước khi gửi")
        } else {
            await addDoc(this.roomRef, {
                message,
                type: type,
                user: userID,
                created: Timestamp.now(),
            });
        }
    }

    onChange(callback) {
        onSnapshot(this.query, (data) => {
            callback(this.transform(data));
        });
    }

    uploadAudio(blob) {
        return new Promise((resolve, reject) => {
            const storageRef = ref(this.storage, `audio/${Date.now()}.wav`);
            const uploadTask = uploadBytesResumable(storageRef, blob, {
                contentType: 'audio/wav',
            });

            uploadTask.on('state_changed',
                (snapshot) => {
                    // Observe state change events such as progress, pause, and completion
                },
                (error) => {
                    console.error("Error uploading audio:", error);
                    reject(error);
                },
                () => {
                    getDownloadURL(uploadTask.snapshot.ref)
                        .then(downloadURL => {
                            console.log("Audio uploaded successfully:", downloadURL);
                            resolve(downloadURL);
                        });
                });
        });
    }
}