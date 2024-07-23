<?php
include '../config/db_connection.php';

#get all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $users = [];
}

#get all pending users
$sql = "SELECT * FROM registration WHERE role = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $pendingUsers = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $pendingUsers = [];
}

$conn->close();

?>

<?php include '../components/head.php'; ?>
    <title>Pending Users</title>
    <link rel="stylesheet" href="../css/add_user.css">
</head>

<body>
    <header>
        <h1>Pending Users</h1>
    </header>
    <div class="container">
        <div class="button-container">
            <button class="main-button" onclick="showForm('add')">Add User</button>
            <button class="main-button" onclick="showForm('approve')">Approve User</button>
            <button class="main-button" onclick="showForm('edit')">Edit User</button>
            <button class="main-button" onclick="showForm('remove')">Remove User</button>
            <button class="main-button" onclick="showUsers()">Display All Users</button>
        </div>

        <!-- Add User Form -->
        <form action="../php/add_user.php" method="POST">
            <div id="add-user-form" class="form-container">
                <button class="close-btn" onclick="closeForm()">x</button>
                    <legend>
                        <h2>Add User:</h2>
                    </legend>
                    <label for="add-fname">First Name:</label>
                    <input type="text" name="fname" id="fname" required>
                    <label for="add-lname">Last Name:</label>
                    <input type="text" name="lname" id="lname" required>
                    <label for="add-username">Username:</label>
                    <input type="text" name="username" id="username" required>
                    <label for="add-email">Email:</label>
                    <input type="email" name="email" id="email" required>
                    <label for="add-password">Password:</label>
                    <input type="password" name="password" id="password" required>
                    <label for="add-permissions">Permissions:</label>
                    <select name="permissions" id="permissions">
                        <option value="staff">Staff</option>
                        <option value="inventory">Inventory</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit">Add User</button>
            </div>
        </form>
        
        <!-- Approve User Form -->
        <div id="approve-user-form" class="form-container">
            <button class="close-btn" onclick="closeForm()">x</button>
            <legend>
                <h2>Approve User:</h2>
            </legend>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="pendingUserTableBody">
                    <!-- Example User Data -->
                    <tr>
                        <td>john_doe</td>
                        <td>john@example.com</td>
                        <td>2024-07-21</td>
                        <td>
                            <select class="permissions-dropdown">
                                <option value="user">User</option>
                                <option value="inventory">Inventory</option>
                                <option value="admin">Admin</option>
                            </select>
                        </td>
                        <td>
                            <button onclick="approveUser('john_doe')">Approve</button>
                            <button onclick="rejectUser('john_doe')">Reject</button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>

        <!-- Edit User Form -->
        <div id="edit-user-form" class="form-container">
            <button class="close-btn" onclick="closeForm()">x</button>
            <legend>
                <h2>Edit User:</h2>
            </legend>
            <label for="edit-username">Username:</label>
            <input type="text" id="edit-username" required>
            <button type="button" onclick="fetchUserDetails()">Fetch Details</button>
            <div id="edit-details" style="display: none;">
                <label for="edit-email">Email:</label>
                <input type="email" id="edit-email">
                <label for="edit-permissions">Permissions:</label>
                <select id="edit-permissions">
                    <option value="user">User</option>
                    <option value="inventory">Inventory</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" onclick="editUser()">Edit User</button>
            </div>
            <div id="edit-loading" style="display: none;">Loading...</div>
        </div>

        <!-- Remove User Form -->
        <div id="remove-user-form" class="form-container">
            <button class="close-btn" onclick="closeForm()">x</button>
            <legend>
                <h2>Remove User:</h2>
            </legend>
            <label for="remove-username">Username:</label>
            <input type="text" id="remove-username" required>
            <button type="button" onclick="fetchUserToRemove()">Fetch User</button>
            <div id="remove-details" style="display: none;">
                <p id="remove-user-info"></p>
                <button type="submit" id="removeUserButton" onclick="removeUser()">Remove User</button>
            </div>
            <div id="remove-loading" style="display: none;">Loading...</div>
        </div>

        <!-- Display All Users Form -->
        <div id="display-users" class="form-container">
            <button class="close-btn" onclick="closeForm()">x</button>
            <legend>
                <h2>All Users:</h2>
            </legend>
            <?php #display users
            if (count($users) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody id="allUsersTableBody">
                        <tr>
                        <?php foreach ($users as $user) { 
                                echo "<td>" . $user['username'] . "</td>";
                                echo "<td>" . $user['email'] . "</td>";
                                echo "<td>" . $user['role'] . "</td>";
                             ?> </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
        </div>
    </div>
    <footer>
        <button class="return-button" onclick="window.location.href='admin_dashboard.html'">Return to Admin
            Dashboard</button>
    </footer>

    <script>
        function showForm(formType) {
            // Hide all forms
            document.querySelectorAll('.form-container').forEach(form => form.classList.remove('active'));

            // Show the selected form
            document.getElementById(`${formType}-user-form`).classList.add('active');
        }

        function closeForm() {
            // Hide all forms
            document.querySelectorAll('.form-container').forEach(form => form.classList.remove('active'));
        }

        /*
        function addUser() {
            const username = document.getElementById('add-username').value;
            const email = document.getElementById('add-email').value;
            const password = document.getElementById('add-password').value;
            // Add user logic here
            console.log(`Adding user: ${username}, ${email}`);
        }
        */

        function approveUser(username) {
            // Approve user logic here
            console.log(`Approving user: ${username}`);
        }

        function rejectUser(username) {
            // Reject user logic here
            console.log(`Rejecting user: ${username}`);
        }

        
        function fetchUserDetails() {
            const username = document.getElementById('edit-username').value;
            // Fetch user details logic here
            console.log(`Fetching details for user: ${username}`);
            document.getElementById('edit-details').style.display = 'block'; // Show edit details form
            document.getElementById('edit-loading').style.display = 'none'; // Hide loading indicator
        }
        

        
        function editUser() {
            const username = document.getElementById('edit-username').value;
            const email = document.getElementById('edit-email').value;
            const permissions = document.getElementById('edit-permissions').value;
            // Edit user logic here
            console.log(`Editing user: ${username}, ${email}, ${permissions}`);
        }

        function fetchUserToRemove() {
            const username = document.getElementById('remove-username').value;
            // Fetch user details logic here
            console.log(`Fetching user to remove: ${username}`);
            document.getElementById('remove-details').style.display = 'block'; // Show remove details form
            document.getElementById('remove-loading').style.display = 'none'; // Hide loading indicator
        }

        function removeUser() {
            const username = document.getElementById('remove-username').value;
            // Remove user logic here
            console.log(`Removing user: ${username}`);
        }

        function showUsers() {
            // Display all users logic here
            document.getElementById('display-users').classList.add('active');
        }

        
    </script>
</body>

</html>