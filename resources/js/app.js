require('./bootstrap');

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('dataForm');
    const dataBody = document.getElementById('dataBody');

    let db;
    const dbName = 'myDatabase';
    const storeName = 'formData';

    // Open or create the IndexedDB database
    const request = window.indexedDB.open(dbName, 1);

    request.onerror = (event) => {
        console.error('Database error: ' + event.target.errorCode);
    };

    request.onsuccess = (event) => {
        db = event.target.result;
        console.log('Database opened successfully');
        displayData(); // Call displayData after successful database open
    };

    request.onupgradeneeded = (event) => {
        db = event.target.result;
        // Create an object store (table) in the database
        const objectStore = db.createObjectStore(storeName, { keyPath: 'id', autoIncrement: true });

        // Define the structure of the data (fields)
        objectStore.createIndex('name', 'name', { unique: false });
        objectStore.createIndex('email', 'email', { unique: false });
        objectStore.createIndex('message', 'message', { unique: false });

        console.log('Object store created');
    };

    // Function to add data to IndexedDB
    const addData = (data) => {
        const transaction = db.transaction([storeName], 'readwrite');
        const objectStore = transaction.objectStore(storeName);
        const request = objectStore.add(data);

        request.onsuccess = () => {
            console.log('Data added to IndexedDB');
            displayData(); // Refresh data display after adding
        };

        request.onerror = (event) => {
            console.error('Error adding data: ' + event.target.errorCode);
        };
    };

    // Function to display data in the table
    const displayData = () => {
        // Clear existing table rows
        while (dataBody.firstChild) {
            dataBody.removeChild(dataBody.firstChild);
        }

        // Check if db is defined before accessing
        if (!db) {
            console.error('IndexedDB is not initialized');
            return;
        }

        // Open a cursor to iterate through the stored data
        const objectStore = db.transaction(storeName).objectStore(storeName);
        objectStore.openCursor().onsuccess = (event) => {
            const cursor = event.target.result;
            if (cursor) {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${cursor.value.name}</td><td>${cursor.value.email}</td><td>${cursor.value.message}</td>`;
                dataBody.appendChild(row);
                cursor.continue();
            }
        };
    };

    // Form submission handling
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const formData = {
            name: form.name.value,
            email: form.email.value,
            message: form.message.value
        };

        // Save data to IndexedDB
        addData(formData);

        // Reset form fields
        form.reset();
    });

    // Initial display of stored data when page loads
    displayData();
});
