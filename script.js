document.addEventListener('DOMContentLoaded', (event) => {
    fetchUserData();

    document.getElementById('searchInput').addEventListener('input', function() {
        filterData(this.value);
    });
});

function fetchUserData() {
    fetch('fetchData.php')
        .then(response => response.json())
        .then(data => populateTable(data))
        .catch(error => console.error('Error:', error));
}

function populateTable(data) {
    const table = document.getElementById('dataTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    tbody.innerHTML = '';

    data.forEach(row => {
        const newRow = tbody.insertRow();
        newRow.insertCell().textContent = row.name;
        newRow.insertCell().textContent = row.email;
        newRow.insertCell().textContent = row.phone_number;
        newRow.insertCell().textContent = row.gender;
        newRow.insertCell().textContent = row.address;
    });
}

function filterData(query) {
    const table = document.getElementById('dataTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const name = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        const email = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
        const phone = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
        const gender = rows[i].getElementsByTagName('td')[3].textContent.toLowerCase();
        const address = rows[i].getElementsByTagName('td')[4].textContent.toLowerCase();

        if (
            name.includes(query.toLowerCase()) ||
            email.includes(query.toLowerCase()) ||
            phone.includes(query.toLowerCase()) ||
            gender.includes(query.toLowerCase()) ||
            address.includes(query.toLowerCase())
        ) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}
