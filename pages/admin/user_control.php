<?php
if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'admin') {
} else {
    header('Location: ../../index.php');
    exit();
}
include '../../config/db_connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
#get all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
    //error_log("Debug: " . count($users) . " users found");
} else {
    $users = [];
    //error_log("Debug: No users found");
}

#get all pending users
$sql = "SELECT * FROM registration WHERE status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $pendingUsers = $result->fetch_all(MYSQLI_ASSOC);
    //error_log("Debug: " . count($pendingUsers) . " pending users found");
} else {
    $pendingUsers = [];
    //error_log("Debug: No pending users found");
}
$conn->close();

?>

<?php include '../../components/head.php'; ?>
<title>Pending Users</title>
<link rel="stylesheet" href="../../css/add_user.css">
<link rel="stylesheet" href="../../css/style.css">
</head>

<body>

    <header>
        <h1>Pending Users</h1>
    </header>
    <div class="container">
        <div class="button-container">
            <button class="main-button" id="addUserBtn">Add User</button>
            <button class="main-button" id="approveUserBtn">Approve User</button>
            <button class="main-button" id="editUserBtn">Edit User</button>
            <button class="main-button" id="removeUserBtn">Remove User</button>
            <button class="main-button" id="displayUsersBtn">Display All Users</button>
        </div>
        <!-- Add User Form -->
        <form action="../../php/add_user.php" method="POST">
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
            <?php #display users
            if (count($users) > 0) { ?>
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
                    <!-- display pending users -->
                        <?php foreach ($pendingUsers as $puser) {
                            echo "<tr>";
                            echo "<td>" . $puser['username'] . "</td>";
                            echo "<td>" . $puser['email'] . "</td>";
                            echo "<td>" . $puser['timestamp'] . "</td>";
                            echo "<td> <select class='permissions-dropdown'>
                                                <option value='staff'>Staff</option>
                                                <option value='inventory'>Inventory</option>
                                                <option value='admin'>Admin</option>
                                               </select> </td>";
                            // Approve Form
                            echo "<td>";
                            echo "<form action='../../php/approve_user.php' method='POST'>";
                            echo "<input type='hidden' name='action' value='approve'>";
                            echo "<input type='hidden' name='username' value='" . $puser['username'] . "'>";
                            echo "<button type='submit'>Approve</button>";
                            echo "</form>";
                            // Reject Form
                            echo "<form action='../../php/approve_user.php' method='POST'>";
                            echo "<input type='hidden' name='action' value='reject'>";
                            echo "<input type='hidden' name='username' value='" . $puser['username'] . "'>";
                            echo "<button type='submit'>Reject</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>

                    </tbody>
                </table>
            <?php } ?>
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
                    <option value="staff">Staff</option>
                    <option value="inventory">Inventory</option>
                    <option value="admin">Admin</option>
                </select>
                <label for="edit-first-name">First Name:</label>
                <input type="text" id="edit-first-name">
                <label for="edit-last-name">Last Name:</label>
                <input type="text" id="edit-last-name">
                <label for="edit-password">New Password:</label>
                <input type="password" id="edit-password">
                <button type="button" onclick="editUser()">Edit User</button>
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
            <input id="remove-username" required>
            <button type="button" onclick="fetchUserToRemove()">Fetch User</button>
            <div id="remove-details" style="display: none;">
                <p id="remove-user-info"></p>
                <button type="button" onclick="removeUser()">Remove User</button>
            </div>
            <div id="remove-loading" style="display: none;">Loading...</div>
        </div>


        <!-- Display All Users Form -->
        <div id="display-user-form" class="form-container">
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
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
    <footer>
        <button class="return-button" onclick="window.location.href='../admin_dashboard.php'">Return to Admin
            Dashboard</button>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addUserBtn').addEventListener('click', function() {
                showForm('add');
            });
            document.getElementById('approveUserBtn').addEventListener('click', function() {
                showForm('approve');
            });
            document.getElementById('editUserBtn').addEventListener('click', function() {
                showForm('edit');
            });
            document.getElementById('removeUserBtn').addEventListener('click', function() {
                showForm('remove');
            });
            document.getElementById('displayUsersBtn').addEventListener('click', showUsers);
            document.querySelectorAll('.close-btn').forEach(button => {
                button.addEventListener('click', closeForm);
            });
        });

        function closeForm() {
            document.querySelectorAll('.form-container').forEach(form => form.classList.remove('active'));
        }

        function showForm(formType) {
            document.querySelectorAll('.form-container').forEach(form => form.classList.remove('active'));
            document.getElementById(`${formType}-user-form`).classList.add('active');
        }

        function showUsers() {
            const displayUserForm = document.getElementById('display-user-form');
            if (displayUserForm) {
                displayUserForm.classList.add('active');
            }
        }

        function fetchUserDetails() {
            const username = document.getElementById('edit-username').value;
            const editDetailsDiv = document.getElementById('edit-details');
            const editLoadingDiv = document.getElementById('edit-loading');

            editDetailsDiv.style.display = 'none';
            editLoadingDiv.style.display = 'block';

            const xhr = new XMLHttpRequest();
            xhr.open('GET', `../../php/fetch_user.php?username=${encodeURIComponent(username)}`, true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const data = JSON.parse(xhr.responseText);
                    if (!data.error) {
                        document.getElementById('edit-email').value = data.email;
                        document.getElementById('edit-permissions').value = data.role;
                        document.getElementById('edit-first-name').value = data.first_name;
                        document.getElementById('edit-last-name').value = data.last_name;
                        editDetailsDiv.style.display = 'block';
                    } else {
                        alert(data.error);
                    }
                } else {
                    console.error('Error fetching user details:', xhr.statusText);
                }
                editLoadingDiv.style.display = 'none';
            };
            xhr.onerror = function() {
                console.error('Request failed');
                editLoadingDiv.style.display = 'none';
            };
            xhr.send();
        }

        function editUser() {
            const username = document.getElementById('edit-username').value;
            const email = document.getElementById('edit-email').value;
            const role = document.getElementById('edit-permissions').value;
            const firstName = document.getElementById('edit-first-name').value;
            const lastName = document.getElementById('edit-last-name').value;
            const password = document.getElementById('edit-password').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/edit_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('User edited successfully');
                        closeForm();
                    } else {
                        alert(response.error);
                    }
                } else {
                    console.error('Error editing user:', xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send(JSON.stringify({
                username: username,
                email: email,
                role: role,
                first_name: firstName,
                last_name: lastName,
                password: password // Include password if provided
            }));
        }

        function fetchUserToRemove() {
            const username = document.getElementById('remove-username').value;
            const removeDetailsDiv = document.getElementById('remove-details');
            const removeLoadingDiv = document.getElementById('remove-loading');

            removeDetailsDiv.style.display = 'none';
            removeLoadingDiv.style.display = 'block';

            const xhr = new XMLHttpRequest();
            xhr.open('GET', `../../php/fetch_user.php?username=${encodeURIComponent(username)}`, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const data = JSON.parse(xhr.responseText);
                    if (!data.error) {
                        document.getElementById('remove-user-info').textContent =
                            `Username: ${username}, Email: ${data.email}, Role: ${data.role}, First Name: ${data.first_name}, Last Name: ${data.last_name}`;
                        removeDetailsDiv.style.display = 'block';
                    } else {
                        alert(data.error);
                    }
                } else {
                    console.error('Error fetching user details:', xhr.statusText);
                }
                removeLoadingDiv.style.display = 'none';
            };
            xhr.onerror = function() {
                console.error('Request failed');
                removeLoadingDiv.style.display = 'none';
            };
            xhr.send();
        }

        function removeUser() {
            const username = document.getElementById('remove-username').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/remove_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('User removed successfully');
                        closeForm();
                    } else {
                        alert(response.error);
                    }
                } else {
                    console.error('Error removing user:', xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send(JSON.stringify({
                username: username
            }));
        }
    </script>
</body>

</html>