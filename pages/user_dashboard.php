<?php include '../components/head.php';
if (isset($_COOKIE['role']) && $_COOKIE['role'] === 'staff') {
} else {
    header('Location: ../index.php');
    exit();
}?>
<title>User Dashboard</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../components/user_header.php'; ?>

<?php include '../components/footer.php'; ?>

</body>
</html>
