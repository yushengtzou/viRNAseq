<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to the login page
    exit();
}

$userId = $_SESSION['user_id'];

include('../php/db_config.php');

$query = "SELECT * FROM UploadHistory WHERE user_id = ?";

$stmt = $db->prepare($query);

if($stmt === false) {
    die('prepare() failed: ' . htmlspecialchars($db->error));
}

$stmt->bind_param("i", $userId);

if($stmt->execute()) {
    $result = $stmt->get_result();
    $records = $result->fetch_all(MYSQLI_ASSOC);
} else {
    die('execute() failed: ' . htmlspecialchars($stmt->error));
}
?>

<!DOCTYPE html>
<html>
<head>
        <title>viRNAseq</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS: -->
        <link href="../css/bs/bootstrap.min.css" rel="stylesheet">
        <!-- My own styles -->
        <link href="../css/custom.css" rel="stylesheet">
</head>

<body>

    <!--    NAVIGATION BAR    -->

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 60px;">
            <div class="container-fluid justify-content-between">
                <a class="navbar-brand ms-3" href="../index.php">&nbsp;viRNAseq</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav" style="display: flex; align-items: center;">
                        <li class="nav-item mx-2"><a class="nav-link" href="../php/info.php">Info</a></li>
                        <li class="nav-item mx-2"><a class="nav-link" href="share.html">Examples</a></li>
                        
                        <li class="nav-item dropdown mx-2">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarAccountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarAccountDropdown">
                                <?php
                                if(isset($_SESSION["username"])) {
                                    echo "<li><a class='dropdown-item' href='#'>History</a></li>";
                                    echo "<li><a class='dropdown-item' href='logout.php'>Logout</a></li>";
                                } else {
                                    echo "<li><a class='dropdown-item' href='./html/login.html'>Sign up / Log in</a></li>";
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    <!--            End of Navigation Bar        -->

    <main class="container mt-3">
        <section>
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <p>Your history of upload records and results:</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Filename</th>
                        <th>Upload Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record) : ?>
                        <tr>
                            <td><?php echo $_SESSION['username']; ?></td>
                            <td><?php echo $record['filename']; ?></td>
                            <td><?php echo $record['upload_time']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        
        <div style = "display: flex; justify-content: center; margin-top: 30px;"><svg id="scatterplot"></svg></div>
        <div style = "display: flex; justify-content: center; margin-top: 30px;"><svg id="scatterplot2"></svg></div>
    </main>
    
<!-- Libraries (d3, bootstrap) -->
<script src="../js/bundle.js"></script>
<script src="../js/bs/bootstrap.min.js"></script>
<script src="https://d3js.org/d3.v7.min.js"></script>

<!-- Main -->
<script src="../js/vis.js"></script>

</body>
</html>

