import firebaseConfig from "../../firebase.json" with { type: 'json' };
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js'
import {
    getFirestore, collection, getDocs, addDoc, onSnapshot, Timestamp, query, orderBy
} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-firestore.js";

export class Chat {
    Calling = '<calling>';

    constructor(roomID) {
        this.app = initializeApp(firebaseConfig);
        this.db = getFirestore(this.app);
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

    async addMessage(message, userID) {
        if (message.trim() === '') {
            alert("Phải có nội dung trước khi gửi")
        } else {
            await addDoc(this.roomRef, {
                message,
                type: "message",
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
}