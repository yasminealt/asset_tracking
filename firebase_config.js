// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
import { getDatabase, ref, set, onValue } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyDBcuqeTViZfvcigpCEKpd7v_CmJ9JNZ14",
    authDomain: "asset-tracking-c2efa.firebaseapp.com",
    databaseURL: "https://asset-tracking-c2efa-default-rtdb.firebaseio.com",
    projectId: "asset-tracking-c2efa",
    storageBucket: "asset-tracking-c2efa.appspot.com",
    messagingSenderId: "591374035409",
    appId: "1:591374035409:web:fc3a0ab030e23a964998f0",
    measurementId: "G-CYYRFCV7MK"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const database = getDatabase(app);

// Function to add asset to Firebase
export function addAsset(id, name, latitude, longitude) {
    set(ref(database, 'assets/' + id), {
        name: name,
        latitude: latitude,
        longitude: longitude
    });
}

// Function to get assets from Firebase
export function getAssets(callback) {
    const assetsRef = ref(database, 'assets/');
    onValue(assetsRef, (snapshot) => {
        const data = snapshot.val();
        callback(data);
    });
}