<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modernize Free</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./frompelanggan" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-description"></i>
                                </span>
                                <span class="hide-menu">From Pelanggan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./index.html" aria-expanded="false">
                                <span>
                                    <i class="ti ti-article"></i>
                                </span>
                                <span class="hide-menu">sales</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./index.html" aria-expanded="false">
                                <span>
                                    <i class="ti ti-alert-circle"></i>
                                </span>
                                <span class="hide-menu">Verifikasi Data</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./index.html" aria-expanded="false">
                                <span>
                                    <i class="ti ti-cards"></i>
                                </span>
                                <span class="hide-menu">Cek Nota</span>
                            </a>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">AUTH</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./authentication-login.html" aria-expanded="false">
                                <span>
                                    <i class="ti ti-login"></i>
                                </span>
                                <span class="hide-menu">Login</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user-plus"></i>
                                </span>
                                <span class="hide-menu">Register</span>
                            </a>
                        </li>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Users</a>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>
                                        <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class=" container-fluid d-flex justify-content-center align-items-center">
                <div class="card shadow p-5 w-40">
                    <form class="row g-4">
                        <!-- Dropdown -->
                        <div class="col-12">
                            <label for="firstName" class="form-label">Sales</label>
                            <div class="dropdown">
                                <button class=" col-3  btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih
                                </button>
                                <ul class="dropdown-menu col-3" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" href="#">Option 1</a></li>
                                    <li><a class="dropdown-item" href="#">Option 2</a></li>
                                    <li><a class="dropdown-item" href="#">Option 3</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- First Name and Last Name -->
                        <div class="col-md-12">
                            <label for="firstName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="firstName" placeholder="Nama Lengkap">
                        </div>

                        <!-- Date -->
                        <div class="col-md-12">
                            <label for="Date" class="form-label">Tanggal Lahir</label>
                            <input type="Date" class="form-control" id="Tanggal Lahir" placeholder="">
                        </div>

                        <!-- Email -->
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="firstName" placeholder="">
                        </div>

                        <!-- Email -->
                        <div class="col-md-12 mb-4">
                            <label for="Nomer" class="form-label">Nomer Whatsapp</label>
                            <input type="number" class="form-control" id="Nomer Whatsapp" placeholder="">
                        </div>

                        <div class="container">
                            <div class="row">
                                <!-- Antivirus McAfee -->
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <!-- Judul -->
                                    <label class="form-label d-block">Antivirus McAfee</label>

                                    <!-- Checkbox Yes -->
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="mcAfeeYes">
                                        <label class="form-check-label" for="mcAfeeYes">Yes</label>
                                    </div>

                                    <!-- Checkbox No -->
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="mcAfeeNo">
                                        <label class="form-check-label" for="mcAfeeNo">No</label>
                                    </div>
                                </div>

                                <!-- Microsoft Office -->
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <!-- Judul -->
                                    <label class="form-label d-block">Microsoft Office</label>

                                    <!-- Checkbox Yes -->
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="officeYes">
                                        <label class="form-check-label" for="officeYes">Yes</label>
                                    </div>

                                    <!-- Checkbox No -->
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="officeNo">
                                        <label class="form-check-label" for="officeNo">No</label>
                                    </div>
                                </div>

                                <!-- Pelindung Layar -->
                                <div class="col-12 col-md-6 col-lg-4">
                                    <!-- Judul -->
                                    <label class="form-label d-block">Pelindung Layar</label>

                                    <!-- Checkbox Yes -->
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="screenProtectorYesDoff">
                                        <label class="form-check-label" for="screenProtectorYesDoff">Yes, Doff</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="screenProtectorYesGlossy">
                                        <label class="form-check-label" for="screenProtectorYesGlossy">Yes, Glossy</label>
                                    </div>
                                    <!-- Checkbox No -->
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="screenProtectorNo">
                                        <label class="form-check-label" for="screenProtectorNo">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>