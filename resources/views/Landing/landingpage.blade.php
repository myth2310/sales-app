<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with Dropdown</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 w-50">
            <form class="row g-3">
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

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>