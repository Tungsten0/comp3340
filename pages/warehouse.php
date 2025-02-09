<?php include '../components/head.php'; ?>
    <title>Warehouse Management</title>
    <link rel="stylesheet" href="../css/warehouse.css">
</head>
<body>
<header>
    <h1>Warehouse Management</h1>
</header>
<div class="container">
    <div class="button-container">
        <button class="main-button" onclick="showForm('create')">Create Bin</button>
        <button class="main-button" onclick="showForm('edit')">Edit Bin</button>
        <button class="main-button" onclick="showForm('remove')">Remove Bin</button>
        <button class="main-button" onclick="displayCurrentWarehouse()">Display Current Warehouse</button>
    </div>

    <div id="create-warehouse-form" class="form-container">
        <button class="close-btn" onclick="closeForm()">x</button>
        <legend><h2>Create Bin:</h2></legend>
        <label for="create-zone">Zone:</label>
        <select id="create-zone" required>
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
        <input type="text" id="create-storage-number" required>
        <label for="create-level">Storage Level:</label>
        <select id="create-level" required>
            <option value="">Select Level</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
        </select>
        <label for="create-indicator">Storage Indicator:</label>
        <select id="create-indicator" required>
            <option value="">Select Indicator</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
        </select>
        <button type="submit">Create Bin</button>
    </div>

    <div id="edit-warehouse-form" class="form-container">
        <button class="close-btn" onclick="closeForm()">x</button>
        <legend><h2>Edit Bin:</h2></legend>
        <label for="edit-zone">Zone:</label>
        <select id="edit-zone" required>
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
        <input type="text" id="edit-storage-number" required>
        <label for="edit-level">Storage Level:</label>
        <select id="edit-level" required>
            <option value="">Select Level</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
        </select>
        <button type="button" onclick="fetchWarehouseDetails()">Fetch Details</button>
        <div id="edit-details" style="display: none;">
            <label for="edit-new-level">New Storage Level:</label>
            <select id="edit-new-level">
                <option value="">Select Level</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
            <label for="edit-new-indicator">New Storage Indicator:</label>
            <select id="edit-new-indicator">
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
    </div>

    <div id="remove-warehouse-form" class="form-container">
        <button class="close-btn" onclick="closeForm()">x</button>
        <legend><h2>Remove Bin:</h2></legend>
        <label for="remove-zone">Zone:</label>
        <select id="remove-zone" required>
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
        <input type="text" id="remove-storage-number" required>
        <label for="remove-level">Storage Level:</label>
        <select id="remove-level" required>
            <option value="">Select Level</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
        </select>
        <button type="button" onclick="fetchWarehouseToRemove()">Fetch Bin</button>
        <div id="remove-details" style="display: none;">
            <p id="remove-warehouse-info"></p>
            <button type="submit" onclick="removeWarehouse()">Remove Bin</button>
        </div>
        <div id="remove-loading" style="display: none;">Loading...</div>
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
                <th>Indicator</th>
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
    const mockWarehouses = {
        'Z01_001_A': { storageNumber: '001', level: 'A', indicator: 'A' },
        'Z02_002_B': { storageNumber: '002', level: 'B', indicator: 'B' },
        // Add more mock warehouses as needed
    };

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

            setTimeout(() => {
                const warehouseKey = `${zone}_${storageNumber}_${level}`;
                const warehouse = mockWarehouses[warehouseKey];
                if (warehouse && warehouse.storageNumber === storageNumber) {
                    document.getElementById('edit-new-level').value = warehouse.level;
                    document.getElementById('edit-new-indicator').value = warehouse.indicator;
                    document.getElementById('edit-details').style.display = 'block';
                } else {
                    alert('Warehouse not found');
                    document.getElementById('edit-details').style.display = 'none';
                }
                document.getElementById('edit-loading').style.display = 'none';
            }, 1000);
        } else {
            document.getElementById('edit-details').style.display = 'none';
        }
    }

    function fetchWarehouseToRemove() {
        const zone = document.getElementById('remove-zone').value;
        const storageNumber = document.getElementById('remove-storage-number').value;
        const level = document.getElementById('remove-level').value;
        if (zone && storageNumber && level) {
            document.getElementById('remove-details').style.display = 'none';
            document.getElementById('remove-loading').style.display = 'block';

            setTimeout(() => {
                const warehouseKey = `${zone}_${storageNumber}_${level}`;
                const warehouse = mockWarehouses[warehouseKey];
                if (warehouse && warehouse.storageNumber === storageNumber) {
                    document.getElementById('remove-warehouse-info').innerText = `
                        Storage Number: ${warehouse.storageNumber}
                        Zone: ${zone}
                        Level: ${warehouse.level}
                        Indicator: ${warehouse.indicator}
                    `;
                    document.getElementById('remove-details').style.display = 'block';
                } else {
                    alert('Warehouse not found');
                    document.getElementById('remove-details').style.display = 'none';
                }
                document.getElementById('remove-loading').style.display = 'none';
            }, 1000);
        } else {
            document.getElementById('remove-details').style.display = 'none';
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
        for (const key in mockWarehouses) {
            if (mockWarehouses.hasOwnProperty(key)) {
                const warehouse = mockWarehouses[key];
                const [zone, storageNumber, level] = key.split('_');
                warehouseInfo.innerHTML += `
                    <tr>
                        <td>${zone}</td>
                        <td>${storageNumber}</td>
                        <td>${level}</td>
                        <td>${warehouse.indicator}</td>
                    </tr>
                `;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const returnBtn = document.getElementById('returnBtn');
        returnBtn.addEventListener('click', function() {
            window.location.href = 'admin_dashboard.html';
        });
    });
</script>
</body>
</html>
