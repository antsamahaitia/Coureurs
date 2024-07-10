<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('css/sb-admin-2.min.css'); ?>" rel="stylesheet">
    <!-- Font Icon -->
    <link rel="stylesheet" href="<?php echo base_url('public/login/fonts/material-icon/css/material-design-iconic-font.min.css'); ?>">
    <!-- Main css -->
    <link rel="stylesheet" href="<?php echo base_url('public/login/css/style.css'); ?>">
</head>
<body class="bg-gradient-primary">
   
        <!-- Outer Row -->
        <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post" action="<?php echo base_url('Login/process'); ?>">
                                        <div class="form-group mb-4">
                                            
                                            <select name="profil" id="profil" class="form-control form-control-user">
                                                <option value="admin">Admin</option>
                                                <option value="proprietaire">Propriétaire</option>
                                                <option value="client">Client</option>
                                            </select>
                                        </div>
                                        
                                        <div id="admin-fields" style="display: none;">
                                            <div class="form-group mb-3">
                                                <input type="text" name="username" class="form-control form-control-user" id="admin-username" placeholder="Nom d'utilisateur">
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="password" name="password" class="form-control form-control-user" id="admin-password" placeholder="Mot de passe">
                                            </div>
                                        </div>
                                        
                                        <div id="proprietaire-fields" style="display: none;">
                                            <div class="form-group mb-3">
                                                <input type="text" name="tel" class="form-control form-control-user" id="proprietaire-tel" placeholder="Numéro de téléphone">
                                            </div>
                                        </div>
                                        
                                        <div id="client-fields" style="display: none;">
                                            <div class="form-group mb-3">
                                                <input type="email" name="email" class="form-control form-control-user" id="client-email" placeholder="Email">
                                            </div>
                                        </div>
                                        
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo base_url('login/forget'); ?>">Forgot Password?</a>
                                    </div>
                                    <div class="text-center mt-2">
                                        <a class="small" href="<?php echo base_url('login/signup'); ?>">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>

<script>
    document.getElementById('profil').addEventListener('change', function() {
        document.getElementById('admin-fields').style.display = 'none';
        document.getElementById('proprietaire-fields').style.display = 'none';
        document.getElementById('client-fields').style.display = 'none';

        if (this.value === 'admin') {
            document.getElementById('admin-fields').style.display = 'block';
        } else if (this.value === 'proprietaire') {
            document.getElementById('proprietaire-fields').style.display = 'block';
        } else if (this.value === 'client') {
            document.getElementById('client-fields').style.display = 'block';
        }
    });
</script>

    
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('js/sb-admin-2.min.js'); ?>"></script>
    <!-- JS -->
    <script src="<?php echo base_url('public/login/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/login/js/main.js'); ?>"></script>
</body>
</html>