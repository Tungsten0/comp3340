<?php include '../components/head.php'; ?>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/profile_edit.css">
</head>
<body>
<header>
    <h1>Edit Profile</h1>
</header>
<div class="container">
    <form id="editProfileForm">
        <div class="form-group">
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name" value="John" readonly>
        </div>
        <div class="form-group">
            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name" value="Doe" readonly>
        </div>
        <div class="form-group">
            <label for="employee-number">Employee Number:</label>
            <input type="text" id="employee-number" name="employee-number" value="12345" readonly>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="john.doe@example.com" readonly>
        </div>
        <!-- Hidden fields initially -->
        <div class="form-group hidden" id="old-password-group">
            <label for="old-password">Old Password:</label>
            <input type="password" id="old-password" name="old-password" placeholder="Enter old password">
        </div>
        <div class="form-group hidden" id="new-password-group">
            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new-password" placeholder="Enter new password">
        </div>
        <div class="form-group hidden" id="confirm-password-group">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password">
        </div>
        <div class="error-message hidden" id="password-error"></div>
        <div class="button-group">
            <button type="submit">Update Profile</button>
            <button type="button" id="change-password-btn" class="change-password-button">Change Password</button>
        </div>
    </form>
</div>

<!-- Return Button at the Bottom -->
<footer>
    <div class="button-container">
        <a href="dashboard.html" class="return-button">Return to Profile</a>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const changePasswordBtn = document.getElementById('change-password-btn');
        const oldPasswordGroup = document.getElementById('old-password-group');
        const newPasswordGroup = document.getElementById('new-password-group');
        const confirmPasswordGroup = document.getElementById('confirm-password-group');
        const container = document.querySelector('.container');
        const passwordError = document.getElementById('password-error');

        changePasswordBtn.addEventListener('click', function() {
            if (oldPasswordGroup.classList.contains('hidden')) {
                oldPasswordGroup.classList.remove('hidden');
                newPasswordGroup.classList.remove('hidden');
                confirmPasswordGroup.classList.remove('hidden');
                container.classList.add('expanded');
                changePasswordBtn.textContent = 'Hide Password Fields';
            } else {
                oldPasswordGroup.classList.add('hidden');
                newPasswordGroup.classList.add('hidden');
                confirmPasswordGroup.classList.add('hidden');
                container.classList.remove('expanded');
                changePasswordBtn.textContent = 'Change Password';
                passwordError.classList.add('hidden');
            }
        });

        document.getElementById('editProfileForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Password fields
            const oldPassword = document.getElementById('old-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            // Regular expression for password complexity
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (newPassword !== confirmPassword) {
                passwordError.textContent = 'New Password and Confirm Password do not match.';
                passwordError.classList.remove('hidden');
                return;
            }

            if (!passwordRegex.test(newPassword)) {
                passwordError.textContent = 'Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character.';
                passwordError.classList.remove('hidden');
                return;
            } else {
                passwordError.classList.add('hidden');
            }

            // Handle form submission logic here
            // You can use JavaScript to validate and send the form data to the server

            alert('Profile updated successfully!');
        });
    });
</script>
</body>
</html>
