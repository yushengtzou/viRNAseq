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
    <!--            End of Navigation Bar        -->

    <div id="left_panel">

            <main class="container-fluid mt-3 px-4 py-2">
                <!-- 用來作為介紹工具的卡片 -->
                    <div class="card card-custom" id = "intro_card">
                        <div class="card-header">Information about viRNAseq</div>
                        <div class="card-body">
                            <p class="card-text">viRNAseq is made by <a href='https://www.yushengtzou.com/'>Yu Sheng Tzou</a></p>
                            <p>The code is open-source at <a href= 'https://github.com/yushengtzou/viRNAseq'>https://github.com/yushengtzou/viRNAseq</a></p>
                            <p>viRNAseq stands on the shoulders of giants:</p>
                            <ul>
                                <li>Visualizations created using <a href='https://d3js.org/'>D3</a> from Mike Bostock</li>
                                <li>Panel and navigation bar created using styles from <a href='https://getbootstrap.com/'>Bootstrap</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id = "svg" style = "display: flex; justify-content: center;">
                        <div id="menus">
                              <span id="y-menu"></span>
                              <!-- vs. -->
                              <span id="x-menu"></span>
                        </div>
                        <svg id="scatterplot" style="padding-left: 80px; padding-top: 12px;"></svg>
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
                                <label>Color Schemes&nbsp;</label>
                                <select id = 'colorSchemeSelect'>
                                    <option>Category10</option>
                                    <option>Paired</option>
                                    <option>Set1</option>
                                    <option>Set2</option>
                                    <option>Set3</option>
                                    <option>Tableau10</option>
                                    <option>Sinebow</option>
                                </select>
                            </p>
                            <button onclick="saveAsPng()" id="saveButton">Save as png</button>
                        </div>
                    </div>
                </div>
    </div>

<!-- Libraries (d3, bootstrap) -->
<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="../js/bundle.js"></script>
<script src="../js/bs/bootstrap.min.js"></script>

<!-- Main -->
<script src="../js/vis.js"></script>

</body>
</html>
