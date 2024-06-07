import firebaseConfig from "../../firebase.json" with { type: 'json' };
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js'
import { getFirestore, collection, getDocs, addDoc, onSnapshot, Timestamp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-firestore.js";

export class Chat {
    Calling = '<calling>';

    constructor(roomID) {
        this.app = initializeApp(firebaseConfig);
        this.db = getFirestore(this.app);
        this.roomID = roomID;
        this.roomRef = collection(this.db, 'data', 'message', this.roomID);
    }

    transform(data) {
        let tmp = [];
        data.forEach(doc => {
            tmp.push({
                id: doc.id,
                data: doc.data()
            })
        })

        tmp = tmp.sort((a, b) => {
            const a_sec = a.data.created.seconds
            const b_sec = b.data.created.seconds

            if (a_sec != b_sec) {
                if (a_sec < b_sec) return -1;
                else return 1;
            } else {
                const a_m = a.data.created.nanoseconds
                const b_m = a.data.created.nanoseconds

                if (a_m < b_m) return -1;
                else if (a_m > b_m) return 1;
                else return 0;
            }
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

    async addMessage(message, userID) {
        if (message.trim() === '') {
            alert("Phải có nội dung trước khi gửi")
        } else {
            await addDoc(this.roomRef, {
                message,
                user: userID,
                created: Timestamp.now(),
                link: message === this.Calling
                    ? window.location.origin + '/call.php?room=' + this.roomID
                    : ""
            });
        }
    }

    onChange(callback) {
        onSnapshot(this.roomRef, (data) => {
            callback(this.transform(data));
        });
    }
}