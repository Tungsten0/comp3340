<?php include '../../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'admin') {
} else {
    header('Location: ../../index.php');
    exit();
}?>

    <!--run every page to check stuff-->
    <?php #include '../php/check.php'; ?>
    <title>Warehouse Management</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/warehouse.css">
    <script src="../../scripts/script.js"></script>
</head>
<body>
<header>
    <h1>Warehouse Management</h1>
</header>
<div class="container">
    <div class="button-container">
        <button class="main-button" onclick="showForm('create')">Create Bin</button>
<!--        <button class="main-button" onclick="showForm('edit')">Edit Bin</button>-->
        <button class="main-button" onclick="showForm('remove')">Remove Bin</button>
        <button class="main-button" onclick="displayCurrentWarehouse()">Display Current Warehouse</button>
    </div>

    <div id="create-warehouse-form" class="form-container">
        <form action="../../php/add_bin.php" method="POST">
            <button class="close-btn" onclick="closeForm()">x</button>
            <legend><h2>Create Bin:</h2></legend>
            <label for="create-zone">Zone:</label>
            <select id="create-zone" name="zone" required>
                <option value="">Select Zone</option>
                <option value="Z01">Z01</option>
                <option value="Z02">Z02</option>
                <option value="Z03">Z03</option>
                <option value="Z04">Z04</option>
                <option value="Z05">Z05</option>
                <option value="Z06">Z06</option>
                <option value="Z07">Z07</option>
                <option value="Z08">Z08</option>
                <option value="Z09">Z09</option>
                <option value="Z10">Z10</option>
            </select>
            <label for="create-storage-number">Storage Number:</label>
            <input type="text" id="create-storage-number" name="storage_number" required>
            <label for="create-level">Storage Level:</label>
            <select id="create-level" name="storage_level" required>
                <option value="">Select Level</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
            <button type="submit">Create Bin</button>
        </form>
    </div>

    <div id="edit-warehouse-form" class="form-container">
        <button class="close-btn" onclick="closeForm()">x</button>
        <legend><h2>Edit Bin:</h2></legend>
        <form id="edit-bin-form" action="../../php/edit_bin.php" method="POST">
            <label for="edit-zone">Zone:</label>
            <select id="edit-zone" name="zone" required>
                <option value="">Select Zone</option>
                <option value="Z01">Z01</option>
                <option value="Z02">Z02</option>
                <option value="Z03">Z03</option>
                <option value="Z04">Z04</option>
                <option value="Z05">Z05</option>
                <option value="Z06">Z06</option>
                <option value="Z07">Z07</option>
                <option value="Z08">Z08</option>
                <option value="Z09">Z09</option>
                <option value="Z10">Z10</option>
            </select>
            <label for="edit-storage-number">Storage Number:</label>
            <input type="text" id="edit-storage-number" name="storage_number" required>
            <label for="edit-level">Storage Level:</label>
            <select id="edit-level" name="level" required>
                <option value="">Select Level</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
            <button type="button" onclick="fetchWarehouseDetails()">Fetch Details</button>
            <input type="hidden" id="old-storage-location" name="old_storage_location"> <!-- Hidden field to store original storage location -->
            <div id="edit-details" style="display: none;">
                <label for="edit-new-level">New Storage Level:</label>
                <select id="edit-new-level" name="new_level">
                    <option value="">Select Level</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                </select>
                <label for="edit-new-indicator">New Storage Indicator:</label>
                <select id="edit-new-indicator" name="new_indicator">
                    <option value="">Select Indicator</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                    <option value="G">G</option>
                </select>
                <button type="submit">Update Warehouse</button>
            </div>
            <div id="edit-loading" style="display: none;">Loading...</div>
        </form>
    </div>


    <div id="remove-warehouse-form" class="form-container">
        <button class="close-btn" onclick="closeForm()">x</button>
        <legend><h2>Remove Bin:</h2></legend>
        <form id="remove-bin-form" action="../../php/delete_bin.php" method="POST">
            <label for="remove-zone">Zone:</label>
            <select id="remove-zone" name="zone" required>
                <option value="">Select Zone</option>
                <option value="Z01">Z01</option>
                <option value="Z02">Z02</option>
                <option value="Z03">Z03</option>
                <option value="Z04">Z04</option>
                <option value="Z05">Z05</option>
                <option value="Z06">Z06</option>
                <option value="Z07">Z07</option>
                <option value="Z08">Z08</option>
                <option value="Z09">Z09</option>
                <option value="Z10">Z10</option>
            </select>
            <label for="remove-storage-number">Storage Number:</label>
            <input type="text" id="remove-storage-number" name="storage_number" required>
            <label for="remove-level">Storage Level:</label>
            <select id="remove-level" name="level" required>
                <option value="">Select Level</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
            <button type="button" onclick="fetchWarehouseToRemove()">Fetch Bin</button>
            <input type="hidden" id="remove-storage-location" name="storage_location"> <!-- Hidden field for storage location -->
            <div id="remove-details" style="display: none;">
                <p id="remove-warehouse-info"></p>
                <button type="submit">Remove Bin</button>
            </div>
            <div id="remove-loading" style="display: none;">Loading...</div>
        </form>
    </div>

    <!-- Display Warehouse-->
    <div id="display-warehouse" class="warehouse-display">
        <button class="close-btn" onclick="closeWarehouseDisplay()">x</button>
        <legend><h2>Current Warehouse Inventory:</h2></legend>
        <table>
            <thead>
            <tr>
                <th>Zone</th>
                <th>Storage Number</th>
                <th>Level</th>
                <th>Availability</th>
            </tr>
            </thead>
            <tbody id="warehouse-info">
            </tbody>
        </table>
    </div>
</div>

<footer>
    <button class="return-button" id="returnBtn">Return to Main Menu</button>
</footer>

<script>
    function showForm(formType) {
        document.querySelectorAll('.form-container').forEach(div => {
            div.classList.remove('active');
        });
        document.getElementById(`${formType}-warehouse-form`).classList.add('active');
    }

    function closeForm() {
        document.querySelectorAll('.form-container').forEach(div => {
            div.classList.remove('active');
        });
        document.querySelector('.button-container').style.display = 'flex';
    }

    function closeWarehouseDisplay() {
        document.getElementById('display-warehouse').classList.remove('active');
    }

    function fetchWarehouseDetails() {
        const zone = document.getElementById('edit-zone').value;
        const storageNumber = document.getElementById('edit-storage-number').value;
        const level = document.getElementById('edit-level').value;

        if (zone && storageNumber && level) {
            document.getElementById('edit-details').style.display = 'none';
            document.getElementById('edit-loading').style.display = 'block';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/fetch_bin.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('old-storage-location').value = response.storage_location;
                        document.getElementById('edit-new-level').value = response.new_level;
                        document.getElementById('edit-details').style.display = 'block';
                    } else {
                        alert('Warehouse not found');
                    }
                    document.getElementById('edit-loading').style.display = 'none';
                }
            };

            const params = `zone=${zone}&storage_number=${storageNumber}&level=${level}`;
            xhr.send(params);
        } else {
            alert('Please fill in all fields');
        }
    }

    function fetchWarehouseToRemove() {
        const zone = document.getElementById('remove-zone').value;
        const storageNumber = document.getElementById('remove-storage-number').value;
        const level = document.getElementById('remove-level').value;

        if (zone && storageNumber && level) {
            document.getElementById('remove-details').style.display = 'none';
            document.getElementById('remove-loading').style.display = 'block';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/fetch_bin.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    document.getElementById('remove-loading').style.display = 'none';
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                document.getElementById('remove-storage-location').value = response.storage_location;
                                document.getElementById('remove-warehouse-info').innerHTML = `
                                <p>Storage Number: ${response.storage_number}</p>
                                <p>Zone: ${zone}</p>
                                <p>Level: ${response.new_level}</p>
                            `;
                                document.getElementById('remove-details').style.display = 'block';
                            } else {
                                alert('Error: ' + (response.message || 'Unknown error occurred'));
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            alert('Error parsing response: ' + e.message);
                        }
                    } else {
                        console.error('Request failed with status:', xhr.status);
                        alert('Request failed. Please try again.');
                    }
                }
            };

            const params = `zone=${encodeURIComponent(zone)}&storage_number=${encodeURIComponent(storageNumber)}&level=${encodeURIComponent(level)}`;
            xhr.send(params);
        } else {
            alert('Please fill in all fields');
        }
    }

    function removeWarehouse() {
        const zone = document.getElementById('remove-zone').value;
        const level = document.getElementById('remove-level').value;
        const storageNumber = document.getElementById('remove-storage-number').value;
        if (zone && level) {
            const warehouseKey = `${zone}_${storageNumber}_${level}`;
            const warehouse = mockWarehouses[warehouseKey];
            if (warehouse && warehouse.storageNumber === storageNumber) {
                delete mockWarehouses[warehouseKey];
                alert('Warehouse removed successfully');
                closeForm();
            } else {
                alert('Warehouse not found');
            }
        } else {
            alert('Enter all required details');
        }
    }

    function displayCurrentWarehouse() {
        document.getElementById('display-warehouse').classList.add('active');

        const warehouseInfo = document.getElementById('warehouse-info');
        warehouseInfo.innerHTML = '';

        // Fetch the warehouse data from the server
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../../php/fetch_all_bins.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const warehouses = JSON.parse(xhr.responseText);

                // Loop through the warehouses and display them
                warehouses.forEach(warehouse => {
                    const [zone, storageNumber, level] = warehouse.storage_location.split('-');
                    const availability = warehouse.availability; // Retrieve availability

                    warehouseInfo.innerHTML += `
                <tr>
                    <td>${zone}</td>
                    <td>${storageNumber}</td>
                    <td>${level}</td>
                    <td>${availability}</td>
                </tr>
                `;
                });
            }
        };
        xhr.send();
    }



    document.addEventListener('DOMContentLoaded', function() {
        const returnBtn = document.getElementById('returnBtn');
        returnBtn.addEventListener('click', function() {
            window.location.href = '../admin_dashboard.php';
        });
    });
</script>
</body>
</html>
