<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('vendor/fontawesome-free/css/all.min.css'); ?>"rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('Admin_home/index'); ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('Admin_home/filter_revenue'); ?>" >
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Gains et Chiffres d'affaires </span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo base_url('#'); ?>" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="<?php echo base_url('Admin_home/listeEtapes'); ?>">Liste 1</a>
                        <a class="collapse-item" href="<?php echo base_url('Admin_home/formulaire_temps'); ?>">Liste 2</a>

                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
           

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('Admin_home/manage_properties'); ?>">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Propriétés</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('Import/index'); ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Import </span></a>
            </li>

            

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('Admin_home/location'); ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Location </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('Admin_home/details'); ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Details location</span></a>
            </li>

            <a href="<?php echo site_url('ResetDatabase/reset_database'); ?>" class="btn btn-danger">Réinitialiser la base de données</a>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="<?php echo base_url('#'); ?>" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="<?php echo base_url('#'); ?>" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Profil</span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo base_url('img/undraw_profile.svg'); ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?php echo base_url('#'); ?>">>
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('#'); ?>">>
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('#'); ?>">>
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('Login/logout'); ?>"data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <h1>Gestion des locations</h1>

                <script>
        function updateAvailabilityDate() {
            var bien_id = document.getElementById('bien_id').value;
            if (bien_id) {
                fetch('<?= base_url('admin/get_availability_date/') ?>' + bien_id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('availability_date').innerText = 'Disponible à partir du ' + data.date_disponibilite;
                    });
            } else {
                document.getElementById('availability_date').innerText = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('bien_id').addEventListener('change', updateAvailabilityDate);
        });
    </script>
</head>
<body>
    <h1>Gestion des locations</h1>

    <form action="<?php echo base_url('Admin_home/ajouter_location'); ?>" method="post">
        <label for="bien_id">Bien:</label>
        <select id="bien_id" name="bien_id" required onchange="updateAvailabilityDate()">
            <option value="">Sélectionnez un bien</option>
            <?php foreach ($biens as $bien): ?>
                <option value="<?php echo $bien['idBien']; ?>"><?php echo $bien['nom'] . ' (' . $bien['type_nom'] . ')'; ?></option>
            <?php endforeach; ?>
        </select>
        <p id="availability_date"></p>

        <label for="client_id">Client:</label>
        <select id="client_id" name="client_id" required>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo $client['id']; ?>"><?php echo $client['username']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="duree_mois">Durée (en mois):</label>
        <input type="number" id="duree_mois" name="duree_mois" required>

        <label for="date_debut">Date de début:</label>
        <input type="date" id="date_debut" name="date_debut" required>

        <button type="submit">Ajouter la location</button>
    </form>

    <h2>Liste des locations</h2>
    <table>
        <thead>
            <tr>
                <th>Bien</th>
                <th>Client</th>
                <th>Durée (mois)</th>
                <th>Date de début</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locations as $location): ?>
                <tr>
                    <td><?php echo $location['bien_nom']; ?></td>
                    <td><?php echo $location['client_nom']; ?></td>
                    <td><?php echo $location['duree_mois']; ?></td>
                    <td><?php echo $location['date_debut']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= form_open('Admin_home/ajouter_details') ?>
    <button type="submit">Générer les détails des locations</button>
    <?= form_close() ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="<?php echo base_url('#page-top'); ?>">>
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo base_url('Login/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadPage(url) {
            // Hide the chart
            // document.querySelector('.cnv').style.display = 'none';

            // Load the page content dynamically
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('dynamicContent').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('js/sb-admin-2.min.js'); ?>"></script>

</body>

</html>



    
