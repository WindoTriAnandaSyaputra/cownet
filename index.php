<?php
error_reporting(0);
session_start();

$koneksi = new mysqli("localhost", "u252328825_root", "e4E!lp3Scn$", "u252328825_dbcownet");

include "function.php";

if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
    $page_title = 'COWNET';
    $page = isset($_GET['page']) ? $_GET['page'] : '';

    switch ($page) {
        case 'keluar':
            $page_title = 'Data Monitoring Sapi';
            break;
        case 'masuk':
            $page_title = 'Data Device Sapi';
            break;
        case 'data':
            $page_title = 'COWSHED';
            break;
        case 'pengguna':
            $page_title = 'Admin';
            break;
        default:
            $page_title = 'COWNET';
            break;
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="icon" href="gambar/2.png">
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <style>
        .navbar-cls-top {
            background-color: #202020;
        }
        .welcome-text {
            background-color: #202020;
            color: white;
            padding: 15px 50px 5px 50px;
            float: right;
            font-size: 16px;
        }
        .profile-img {
            text-align: center;
            margin: 20px 0;
        }
        .sidebar-collapse {
            overflow-y: auto;
            max-height: 100vh;
        }
        @media (max-width: 768px) {
            .navbar-cls-top, .welcome-text {
                padding: 10px;
                font-size: 14px;
            }
            .sidebar-collapse {
                max-height: 100vh;
                overflow-x: hidden;
            }
            .profile-img img {
                width: 100px;
                height: auto;
            }
        }
    </style>
</head>

<body>
<div id="wrapper">
    <font size="+3" face="arial" color="white"><center><b>MONITORING SAPI</b></center></font>

    <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="welcome-text">
            <?php echo date('d-M-Y'); ?> &nbsp; <a href="logout.php" class="btn btn-success square-btn-adjust">Keluar</a>
        </div>
    </nav>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse collapse">
            <ul class="nav" id="main-menu">
                <li class="profile-img">
                    <img src="gambar/5.png" style="width: 150px; height: auto;">
                </li>
                <li>
                    <a href="index.php"><i class="fa fa-home fa-2x"></i> HOME</a>
                </li>
                <li>
                    <a href="?page=keluar"><i class="fa fa-bar-chart fa-2x"></i> DATA MONITORING SAPI</a>
                </li>
                <li>
                    <a href="?page=masuk"><i class="fa fa-cogs fa-2x"></i> DATA DEVICE SAPI</a>
                </li>
                <li>
                    <a href="?page=data"><i class="fa fa-tachometer fa-2x"></i> COWSHED</a>
                </li>
                <li>
                    <a href="?page=pengguna"><i class="fa fa-user fa-2x"></i> ADMIN</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : '';
                        $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

                        if ($page == "stok") {
                            if ($aksi == "") {
                                include "page/stok/stok.php";
                            } elseif ($aksi == "tambah") {
                                include "page/stok/tambah.php";
                            } elseif ($aksi == "ubah") {
                                include "page/stok/ubah.php";
                            } elseif ($aksi == "hapus") {
                                include "page/stok/hapus.php";
                            }
                        } elseif ($page == "masuk") {
                            if ($aksi == "") {
                                include "page/masuk/masuk.php";
                            } elseif ($aksi == "tambah") {
                                include "page/masuk/tambah.php";
                            } elseif ($aksi == "kembali") {
                                include "page/masuk/kembali.php";
                            } elseif ($aksi == "hapus") {
                                include "page/masuk/hapus.php";
                            } elseif ($aksi == "aksi1") {
                                include "page/masuk/aksi1.php";
                            } elseif ($aksi == "aksi2") {
                                include "page/masuk/aksi2.php";
                            } elseif ($aksi == "aksi3") {
                                include "page/masuk/aksi3.php";
                            } elseif ($aksi == "aksi4") {
                                include "page/masuk/aksi4.php";
                            } elseif ($aksi == "aksi5") {
                                include "page/masuk/aksi5.php";
                            }
                        } elseif ($page == "keluar") {
                            if ($aksi == "") {
                                include "page/keluar/keluar.php";
                            } elseif ($aksi == "kembali") {
                                include "page/keluar/kembali.php";
                            } elseif ($aksi == "hapus") {
                                include "page/keluar/hapus.php";
                            } elseif ($aksi == "aktivitas1") {
                                include "page/keluar/aktivitas1.php";
                            } elseif ($aksi == "aktivitas2") {
                                include "page/keluar/aktivitas2.php";
                            } elseif ($aksi == "aktivitas3") {
                                include "page/keluar/aktivitas3.php";
                            }
                        } elseif ($page == "data") {
                            if ($aksi == "") {
                                include "page/data/data.php";
                            } elseif ($aksi == "aktivitas") {
                                include "page/data/aktivitas.php";
                            }
                        } elseif ($page == "pengguna") {
                            if ($aksi == "") {
                                include "page/pengguna/pengguna.php";
                            } elseif ($aksi == "tambah") {
                                include "page/pengguna/tambah.php";
                            } elseif ($aksi == "ubah") {
                                include "page/pengguna/ubah.php";
                            } elseif ($aksi == "hapus") {
                                include "page/pengguna/hapus.php";
                            }
                        } elseif ($page == "") {
                            include "home.php";
                        }
                    ?>
                </div>
            </div>
            <!-- /. ROW  -->
            <hr />
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>

</body>
</html>

<?php
} else {
    echo "<script>window.location.href='login.php';</script>";
}
?>
