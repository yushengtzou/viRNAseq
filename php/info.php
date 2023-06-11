<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>viRNAseq</title>

    <!-- Bootstrap CSS -->
    <link href="../css/bs/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <!-- D3.js -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="../js/vis.js"></script>
    <style>
    .custom-dropdown-menu {
        top: 120% !important;
    }
    </style>

</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 60px;">
            <div class="container-fluid justify-content-between">
                <a class="navbar-brand ms-3" href="../index.php">viRNAseq</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav" style="display: flex; align-items: center;">
                        <li class="nav-item mx-2"><a class="nav-link" href="#">Info</a></li>
                        <li class="nav-item mx-2"><a class="nav-link" href="share.html">Examples</a></li>
                        <?php
                        if(isset($_SESSION["username"])) {
                            echo '
                            <li class="nav-item dropdown mx-2">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarAccountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Account
                                </a>
                                <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarAccountDropdown">
                                    <li><a class="dropdown-item" href="../php/history.php">History</a></li>
                                    <li><a class="dropdown-item" href="../php/logout.php">Logout</a></li>
                                </ul>
                            </li>';
                        } else {
                            echo '<li class="nav-item mx-2"><a class="nav-link" href="../html/login.html">Log in / Sign up</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main Content -->
    <main class="container-fluid mt-3 px-4 py-2">
        <section>
            <!-- Row for the cards -->
            <div class="row">
                <!-- "Getting Started" card (2/3 of the page) -->
                <div class="col-lg-8">
                    <div class="card card-custom">
                        <div class="card-header">Information about viRNAseq</div>
                        <div class="card-body">
                            <p class="card-text">viRNAseq is made by Yu Sheng Tzou</p>
                            <p>The code is open-source at</p>
                            <p>viRNAseq stands on the shoulders of giants:</p>
                            <ul>
                                <li>Visualizations created using D3 from Mike Bostock</li>
                                <li>Panel and navigation bar created using styles from Bootstrap</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- 用來上傳檔案的卡片 -->
                <div class="col-lg-4">
                    <div class="card card-custom">
                        <div class="card-header">Input Data</div>
                        <div class="card-body">
                            <p class="card-text">Please upload the data</p>
                            <!-- 用來上傳檔案的form -->
                            <form action="upload_file.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <input type="submit" value="Upload File" name="submit" style="margin-top: 27px;">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br> 
        <br> 
    
        <div style = "display: flex; justify-content: center; margin-top: 30px;"><svg id="scatterplot"></svg></div>
        <div style = "display: flex; justify-content: center; margin-top: 30px;"><svg id="scatterplot2"></svg></div>

    <script src="https://d3js.org/d3.v7.min.js"></script>
     <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/bs/bootstrap.min.js"></script>
</body>
</html>
