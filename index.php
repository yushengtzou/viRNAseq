<?php
        session_start();
?>

<!DOCTYPE html>
<html>
<head>
        <title>viRNAseq</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS: -->
        <link href="css/bs/bootstrap.min.css" rel="stylesheet">
        <!-- My own styles -->
        <link href="css/custom.css" rel="stylesheet">
</head>

<body>

    <!--    NAVIGATION BAR    -->

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 60px;">
            <div class="container-fluid justify-content-between">
                <a class="navbar-brand ms-3" href="index.php">&nbsp;viRNAseq</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav" style="display: flex; align-items: center;">
                                <li class="nav-item mx-2"><a class="nav-link" href="./php/info.php">Info</a></li>
                                <li class="nav-item mx-2"><a class="nav-link" href="share.html">Examples</a></li>

                                <?php
                                if(isset($_SESSION["username"])) {
                                    echo '
                                    <li class="nav-item dropdown mx-2">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarAccountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Account
                                        </a>
                                        <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarAccountDropdown">
                                                    <li><a class="dropdown-item" href="./php/history.php">History</a></li>
                                                    <li><a class="dropdown-item" href="../php/logout.php">Logout</a></li>
                                        </ul>
                                    </li>';
                                } else {
                                    echo '<li class="nav-item mx-2"><a class="nav-link" href="./html/login.html">Log in / Sign up</a></li>';
                                }
                                ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--            End of Navigation Bar        -->

    <div id="left_panel">

            <main class="container-fluid mt-3 px-4 py-2">
                <!-- 用來作為介紹工具的卡片 -->
                    <div class="card card-custom" id = "intro_card">
                        <div class="card-header">Getting Started</div>
                        <div class="card-body">
                            <h5 class="card-title">Examples</h5>
                            <p class="card-text">PBMCs from 10x Genomics examples shown in the Examples tab above.</p>
                            <h5 class="card-title">Visualize your own scRNA-seq data</h5>
                            <p class="card-text">viRNAseq can visualize enormous types of scRNA seq data.</p>

                        </div>
                    </div>
                    <div id = "svg" style = "display: flex; justify-content: flex-start;">
                        <div id="menus">
                              <span id="y-menu"></span>
                              <!-- vs. -->
                              <span id="x-menu"></span>
                        </div>
                        <svg id="scatterplot" style="padding-left: 60px; padding-top: 12px;"></svg>
                    </div>

    </div>

   <div id="right_panel"> 
                
                <!-- 用來上傳檔案的卡片 -->
                <div class="col-lg-11">
                    <div class="card card-custom">
                        <div class="card-header">Input Data</div>
                        <div class="card-body">
                            <p class="card-text">Please upload the data</p>
                                <input type="file" id="csvFile" name="files"/>
                                <input type="submit" id="submit" value="Upload File" name="submit" style="margin-top: 27px;">
                        </div>
                    </div>
                </div>
                <br>

                <!-- Setting Card -->
                <div class="col-lg-11">
                    <div class="card card-custom" id = "set_card">
                        <div class="card-header">Settings</div>
                        <div class="card-body">
                            <p>
                                <label>Color Schemes&nbsp;
                                    <select id = 'colorSchemeSelect'>
                                    <option>Category10</option>
                                    <option>Paired</option>
                                    <option>Set3</option>
                                    <option>Tableau10</option>
                                    <option>Sinebow</option>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
    </div>

<!-- Libraries (d3, bootstrap) -->
<script src="js/bundle.js"></script>
<script src="js/bs/bootstrap.min.js"></script>
<script src="https://d3js.org/d3.v7.min.js"></script>

<!-- Main -->
<script src="js/vis.js"></script>

</body>
</html>
