<?php 
session_start();
include '../includes/dashboard_header.php'; 
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Lesen - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #f8f9fa;
        }
        .application-container {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        .application-header {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .section-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #8659cf;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border-radius: 0.6rem;
            border: 1px solid #e1e5e9;
            padding: 0.75rem;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #8659cf;
            box-shadow: 0 0 0 0.2rem rgba(134, 89, 207, 0.25);
        }
        .btn-primary {
            background: #8659cf;
            border-color: #8659cf;
            font-weight: 500;
            border-radius: 0.6rem;
            padding: 0.75rem 1.5rem;
        }
        .btn-primary:hover {
            background: #7a4fc7;
            border-color: #7a4fc7;
        }
        .btn-outline-primary {
            color: #8659cf;
            border-color: #8659cf;
            border-radius: 0.6rem;
            padding: 0.75rem 1.5rem;
        }
        .btn-outline-primary:hover {
            background: #8659cf;
            border-color: #8659cf;
        }
        .btn-outline-danger {
            border-radius: 0.6rem;
            padding: 0.75rem 1.5rem;
        }
        .btn-outline-success {
            border-radius: 0.6rem;
            padding: 0.75rem 1.5rem;
        }
        .user-info-display {
            background: #f8f9fa;
            border-radius: 0.6rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .user-info-display p {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .user-info-display .label {
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .file-upload-area {
            border: 2px dashed #e1e5e9;
            border-radius: 0.6rem;
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        .file-upload-area:hover {
            border-color: #8659cf;
            background: #f3eaff;
        }
        .file-upload-area.dragover {
            border-color: #8659cf;
            background: #f3eaff;
        }
        .document-list {
            background: #f8f9fa;
            border-radius: 0.6rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .document-list h6 {
            color: #333;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .document-list ul {
            margin-bottom: 0;
            padding-left: 1.5rem;
        }
        .document-list li {
            margin-bottom: 0.5rem;
            color: #6c757d;
        }
        .fee-info {
            background: #e8f5e8;
            border: 1px solid #28a745;
            border-radius: 0.6rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .fee-info h6 {
            color: #155724;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .fee-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .fee-item:last-child {
            margin-bottom: 0;
            padding-top: 0.5rem;
            border-top: 1px solid #28a745;
            font-weight: 600;
        }
        .action-buttons {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 1px solid #e1e5e9;
            padding: 1rem 0;
            margin-top: 2rem;
        }
        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }
        .spinner-border {
            color: #8659cf;
        }
        .alert {
            border-radius: 0.6rem;
        }
        @media (max-width: 768px) {
            .application-container {
                padding: 1rem 0;
            }
            .section-card {
                padding: 1.5rem;
            }
            .action-buttons {
                position: static;
                margin-top: 1rem;
            }
        }
        .fee-info .fee-item:last-child {
            margin-bottom: 0;
            padding-top: 0.5rem;
            border-top: 1px solid #28a745;
            font-weight: 600;
        }
        .document-checklist {
            background: #f8f9fa;
            border-radius: 0.6rem;
            padding: 1.5rem;
        }
        .document-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            margin-bottom: 0.75rem;
            background: #fff;
            border-radius: 0.5rem;
            border: 1px solid #e1e5e9;
            transition: all 0.3s ease;
        }
        .document-item:last-child {
            margin-bottom: 0;
        }
        .document-item:hover {
            border-color: #8659cf;
            box-shadow: 0 2px 8px rgba(134, 89, 207, 0.1);
        }
        .document-info {
            flex: 1;
            margin-right: 1rem;
        }
        .document-title {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
        }
        .document-title i {
            color: #8659cf;
            margin-right: 0.5rem;
        }
        .document-status {
            font-size: 0.85rem;
        }
        .document-action {
            flex-shrink: 0;
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-uploaded {
            background: #d1edff;
            color: #0c5460;
        }
        .status-optional {
            background: #e2e3e5;
            color: #383d41;
        }
        .status-error {
            background: #f8d7da;
            color: #721c24;
        }
        .action-buttons {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 1px solid #e1e5e9;
            padding: 1rem 0;
            margin-top: 2rem;
        }
        
        /* Passport Photo Styles */
        .passport-photo-container {
            text-align: center;
        }
        
        .passport-photo-display {
            position: relative;
            width: 150px;
            height: 200px;
            margin: 0 auto;
            border: 2px dashed #e1e5e9;
            border-radius: 0.6rem;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .passport-photo-display.has-photo {
            border: 2px solid #8659cf;
            background: #fff;
        }
        
        .passport-photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        
        .passport-photo-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        
        .passport-photo-placeholder i {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        
        .passport-photo-placeholder p {
            margin: 0;
            font-size: 0.85rem;
        }
        
        .passport-photo-display.has-photo .passport-photo-img {
            display: block;
        }
        
        .passport-photo-display.has-photo .passport-photo-placeholder {
            display: none;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Loading Screen -->
    <div id="loadingScreen" class="loading-container">
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Memuatkan borang permohonan...</p>
        </div>
    </div>

    <!-- Application Content -->
    <div id="applicationContent" style="display: none;">
        <div class="application-container">
            <div class="container">
                <!-- Application Header -->
                <div class="application-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-2">Borang Permohonan Lesen</h1>
                            <p class="text-muted mb-0">Sistem eLesen - Majlis Daerah Pasir Mas</p>
                        </div>
                        <div>
                            <a href="dashboard.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <form id="applicationForm" enctype="multipart/form-data">
                    <!-- 1. Maklumat Pemohon -->
                    <div class="section-card">
                        <div class="section-title">
                            <i class="bi bi-person-circle"></i>
                            1. Maklumat Pemohon
                        </div>
                        
                        <!-- Passport Photo Section -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Foto Passport</label>
                                <div class="passport-photo-container">
                                    <div id="passportPhotoDisplay" class="passport-photo-display">
                                        <img id="passportPhotoImg" src="../image/default-avatar.png" alt="Foto Passport" class="passport-photo-img">
                                        <div id="passportPhotoPlaceholder" class="passport-photo-placeholder">
                                            <i class="bi bi-person-circle"></i>
                                            <p>Tiada foto</p>
                                        </div>
                                    </div>
                                    <div class="passport-photo-actions mt-2">
                                        <input type="file" id="passportPhotoInput" name="passport_photo" accept="image/jpeg,image/jpg,image/png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('passportPhotoInput').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik Foto
                                        </button>
                                        <button type="button" id="removePassportPhotoBtn" class="btn btn-sm btn-outline-danger ms-2" style="display: none;" onclick="removePassportPhoto()">
                                            <i class="bi bi-trash me-1"></i>Padam
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="user-info-display">
                                    <p><span class="label">Nama Penuh:</span> <span id="userFullName">-</span></p>
                                    <p><span class="label">No. Kad Pengenalan:</span> <span id="userIC">-</span></p>
                                    <p><span class="label">Warna Kad:</span> <span id="userWarnaKad">-</span></p>
                                    <p><span class="label">Tarikh Lahir:</span> <span id="userTarikhLahir">-</span></p>
                                    <p><span class="label">Umur:</span> <span id="userUmur">-</span></p>
                                    <p><span class="label">Agama:</span> <span id="userAgama">-</span></p>
                                    <p><span class="label">Alamat Rumah:</span> <span id="userAddress">-</span></p>
                                    <p><span class="label">No. Telefon:</span> <span id="userPhone">-</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Maklumat Perniagaan -->
                    <div class="section-card">
                        <div class="section-title">
                            <i class="bi bi-building"></i>
                            2. Maklumat Perniagaan
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="licenseType" class="form-label">Jenis Lesen Yang Dipohon *</label>
                                <input type="text" class="form-control" id="licenseType" name="licenseType" placeholder="Contoh: Lesen Perniagaan Premis Tetap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="processingType" class="form-label">Jenis Pemprosesan Lesen *</label>
                                <select class="form-select" id="processingType" name="processingType" required>
                                    <option value="">Pilih jenis pemprosesan</option>
                                    <option value="perniagaan">Lesen Perniagaan</option>
                                    <option value="perindustrian">Lesen Perindustrian</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="businessName" class="form-label">Nama Syarikat *</label>
                                <input type="text" class="form-control" id="businessName" name="businessName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="businessAddress" class="form-label">Alamat Premis Perniagaan *</label>
                                <textarea class="form-control" id="businessAddress" name="businessAddress" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="buildingType" class="form-label">Jenis Bangunan *</label>
                                <select class="form-select" id="buildingType" name="buildingType" required>
                                    <option value="">Pilih jenis bangunan</option>
                                    <option value="Batu">Batu</option>
                                    <option value="Kayu">Kayu</option>
                                    <option value="Kekal">Kekal</option>
                                    <option value="Separuh Kekal">Separuh Kekal</option>
                                    <option value="Sementara">Sementara</option>
                                    <option value="Gerai">Gerai</option>
                                    <option value="Payung">Payung</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="operationYear" class="form-label">Tahun Mula Beroperasi *</label>
                                <input type="number" class="form-control" id="operationYear" name="operationYear" min="1900" max="2030" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="premiseSize" class="form-label">Keluasan Premis (meter persegi) *</label>
                                <input type="number" class="form-control" id="premiseSize" name="premiseSize" step="0.01" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="position" class="form-label">Jawatan Dalam Syarikat *</label>
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ssmRegistration" class="form-label">Daftar Perniagaan (SSM) *</label>
                                <select class="form-select" id="ssmRegistration" name="ssmRegistration" required>
                                    <option value="">Pilih status</option>
                                    <option value="Ada">Ada</option>
                                    <option value="Tiada">Tiada</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="maleWorkers" class="form-label">Bilangan Pekerja Lelaki</label>
                                <input type="number" class="form-control" id="maleWorkers" name="maleWorkers" min="0" value="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="femaleWorkers" class="form-label">Bilangan Pekerja Perempuan</label>
                            <input type="number" class="form-control" id="femaleWorkers" name="femaleWorkers" min="0" value="0">
                        </div>
                    </div>

                    <!-- 3. Maklumat Iklan Papan Tanda -->
                    <div class="section-card">
                        <div class="section-title">
                            <i class="bi bi-sign-intersection"></i>
                            3. Maklumat Iklan Papan Tanda (jika ada)
                        </div>
                        
                        <div class="mb-3">
                            <label for="hasSignboard" class="form-label">Adakah terdapat papan tanda?</label>
                            <select class="form-select" id="hasSignboard" name="hasSignboard">
                                <option value="">Pilih</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>

                        <div id="signboardDetails" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signboardType" class="form-label">Jenis Papan Tanda</label>
                                    <select class="form-select" id="signboardType" name="signboardType">
                                        <option value="">Pilih jenis</option>
                                        <option value="Berlampu">Berlampu</option>
                                        <option value="Tidak Berlampu">Tidak Berlampu</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="signboardSize" class="form-label">Saiz Papan Tanda</label>
                                    <input type="text" class="form-control" id="signboardSize" name="signboardSize" placeholder="Contoh: 2m x 1m atau 6 kaki x 3 kaki">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Pengakuan Pemohon -->
                    <div class="section-card">
                        <div class="section-title">
                            <i class="bi bi-check-circle"></i>
                            4. Pengakuan Pemohon
                        </div>
                        
                        <div class="mb-3">
                            <label for="applicantName" class="form-label">Nama Penuh Pemohon *</label>
                            <input type="text" class="form-control" id="applicantName" name="applicantName" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="applicantIC" class="form-label">Nombor Kad Pengenalan Pemohon *</label>
                            <input type="text" class="form-control" id="applicantIC" name="applicantIC" required>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="applicantDeclaration" name="applicantDeclaration" required>
                                <label class="form-check-label" for="applicantDeclaration">
                                    <strong>Saya mengakui bahawa:</strong>
                                </label>
                            </div>
                            <div class="ms-4 mt-2">
                                <ul class="mb-0">
                                    <li>Semua maklumat yang diberikan adalah benar dan tepat</li>
                                    <li>Saya akan mematuhi semua syarat dan peraturan yang ditetapkan</li>
                                    <li>Saya bersetuju untuk membayar yuran pemprosesan yang dikenakan</li>
                                    <li>Saya faham bahawa permohonan palsu boleh mengakibatkan tindakan undang-undang</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Dokumen Yang Diperlukan -->
                    <div class="section-card">
                        <div class="section-title">
                            <i class="bi bi-file-earmark-text"></i>
                            5. Dokumen Yang Diperlukan
                        </div>
                        
                        <div class="fee-info">
                            <h6>Bayaran Pemprosesan Lesen:</h6>
                            <div class="fee-item">
                                <span>Yuran Fail:</span>
                                <span>RM10.00</span>
                            </div>
                            <div class="fee-item">
                                <span>Yuran Lesen (<span id="licenseTypeLabel">-</span>):</span>
                                <span id="licenseFee">RM0.00</span>
                            </div>
                            <div class="fee-item">
                                <span>Jumlah Bayaran:</span>
                                <span id="totalFee">RM10.00</span>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div class="mb-3">
                            <label class="form-label">Muat Naik Dokumen</label>
                            <div class="document-checklist">
                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Salinan SSM (pendaftaran syarikat/perniagaan & borang 49)
                                        </div>
                                        <div class="document-status" id="ssmStatus">
                                            <span class="status-badge status-pending">Belum dimuat naik</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="ssmFile" name="documents[ssm]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('ssmFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>

                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Lakaran pelan lokasi premis
                                        </div>
                                        <div class="document-status" id="planStatus">
                                            <span class="status-badge status-pending">Belum dimuat naik</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="planFile" name="documents[plan]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('planFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>

                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Salinan kad pengenalan pemohon
                                        </div>
                                        <div class="document-status" id="icStatus">
                                            <span class="status-badge status-pending">Belum dimuat naik</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="icFile" name="documents[ic]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('icFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>

                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-receipt"></i>
                                            Resit bayaran pemprosesan lesen
                                        </div>
                                        <div class="document-status" id="receiptStatus">
                                            <span class="status-badge status-pending">Belum dimuat naik</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="receiptFile" name="documents[receipt]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('receiptFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>

                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Salinan bil cukai taksiran/pintu (jika ada)
                                        </div>
                                        <div class="document-status" id="taxStatus">
                                            <span class="status-badge status-optional">Opsional</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="taxFile" name="documents[tax]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('taxFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>

                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Salinan visual papan tanda (jika ada)
                                        </div>
                                        <div class="document-status" id="signboardStatus">
                                            <span class="status-badge status-optional">Opsional</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="signboardFile" name="documents[signboard]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('signboardFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dokumen Tambahan Section -->
                        <div class="mb-3">
                            <label class="form-label">Dokumen Tambahan (jika berkenaan)</label>
                            <div class="document-checklist">
                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Sijil kesihatan (untuk premis makanan & minuman sahaja)
                                        </div>
                                        <div class="document-status" id="healthStatus">
                                            <span class="status-badge status-optional">Opsional</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="healthFile" name="documents[health]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('healthFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>

                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Salinan geran tanah (jika mohon tempat parkir)
                                        </div>
                                        <div class="document-status" id="landStatus">
                                            <span class="status-badge status-optional">Opsional</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="landFile" name="documents[land]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('landFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>

                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Surat pengesahan tuan milik tanah (jika tapak sewaan)
                                        </div>
                                        <div class="document-status" id="ownerStatus">
                                            <span class="status-badge status-optional">Opsional</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="ownerFile" name="documents[owner]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('ownerFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>

                                <div class="document-item">
                                    <div class="document-info">
                                        <div class="document-title">
                                            <i class="bi bi-file-earmark-text"></i>
                                            Sijil Halal (jika premis proses ayam/daging)
                                        </div>
                                        <div class="document-status" id="halalStatus">
                                            <span class="status-badge status-optional">Opsional</span>
                                        </div>
                                    </div>
                                    <div class="document-action">
                                        <input type="file" id="halalFile" name="documents[halal]" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('halalFile').click()">
                                            <i class="bi bi-upload me-1"></i>Muat Naik
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Syarat dan Peraturan -->
                    <div class="section-card">
                        <div class="section-title">
                            <i class="bi bi-exclamation-triangle"></i>
                            6. Syarat dan Peraturan
                        </div>
                        
                        <div class="alert alert-info">
                            <h6>Syarat Wajib:</h6>
                            <ul class="mb-0">
                                <li>Pemohon mestilah warganegara Malaysia</li>
                                <li>Berumur 18 tahun ke atas</li>
                                <li>Dilarang letak pekerja asing sebagai juruwang</li>
                                <li>Tidak boleh sublet lesen kepada warga asing/Ali Baba</li>
                            </ul>
                        </div>

                        <div class="alert alert-warning">
                            <h6>Pemasangan CCTV Diwajibkan untuk Premis:</h6>
                            <ul class="mb-0">
                                <li>Bank, ATM, Kedai Emas, Pajak Gadai</li>
                                <li>Pasar Borong, Pengurup Wang</li>
                                <li>Kompleks Beli-belah, Hotel</li>
                                <li>Stesen Minyak, Premis 24 jam</li>
                            </ul>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" name="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">
                                Saya mengakui bahawa saya telah membaca dan bersetuju dengan semua syarat dan peraturan yang ditetapkan *
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteDraft()">
                                        <i class="bi bi-trash me-2"></i>
                                        Padam
                                    </button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-outline-primary" onclick="saveDraft()">
                                        <i class="bi bi-save me-2"></i>
                                        Simpan (Draft)
                                    </button>
                                    <button type="submit" class="btn btn-success ms-2">
                                        <i class="bi bi-send me-2"></i>
                                        Serah Permohonan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let userData = null;
        let uploadedFiles = {};
        
        document.addEventListener('DOMContentLoaded', function() {
            const sessionToken = localStorage.getItem('sessionToken');
            const userDataStr = localStorage.getItem('userData');
            const sessionExpires = localStorage.getItem('sessionExpires');
            
            if (!sessionToken || !userDataStr || !sessionExpires) {
                window.location.href = 'login.php';
                return;
            }
            
            if (new Date(sessionExpires) < new Date()) {
                localStorage.removeItem('sessionToken');
                localStorage.removeItem('userData');
                localStorage.removeItem('sessionExpires');
                window.location.href = 'login.php';
                return;
            }
            
            validateSession(sessionToken);
            initializeDocumentUploads();
            initializeFormHandlers();
        });
        
        async function validateSession(token) {
            try {
                const response = await fetch('../api/auth/validate.php', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                
                const data = await response.json();
                
                if (response.ok && data.status === 200) {
                    userData = data.data.user;
                    updateUserInfo();
                    showApplication();
                } else {
                    localStorage.removeItem('sessionToken');
                    localStorage.removeItem('userData');
                    localStorage.removeItem('sessionExpires');
                    window.location.href = 'login.php';
                }
                
            } catch (error) {
                console.error('Session validation error:', error);
                const userDataStr = localStorage.getItem('userData');
                if (userDataStr) {
                    try {
                        userData = JSON.parse(userDataStr);
                        updateUserInfo();
                        showApplication();
                    } catch (e) {
                        window.location.href = 'login.php';
                    }
                } else {
                    window.location.href = 'login.php';
                }
            }
        }
        
        function updateUserInfo() {
            document.getElementById('userFullName').textContent = userData.full_name.toUpperCase();
            document.getElementById('userIC').textContent = userData.ic_number;
            document.getElementById('userWarnaKad').textContent = userData.warna_kad_pengenalan || '-';
            document.getElementById('userTarikhLahir').textContent = userData.tarikh_lahir ? formatDate(userData.tarikh_lahir) : '-';
            document.getElementById('userUmur').textContent = userData.umur || '-';
            document.getElementById('userAgama').textContent = userData.agama || '-';
            document.getElementById('userAddress').textContent = `${userData.address}, ${userData.postcode} ${userData.city}, ${userData.state}`;
            document.getElementById('userPhone').textContent = userData.phone;
            
            // Auto-fill applicant details
            document.getElementById('applicantName').value = userData.full_name;
            document.getElementById('applicantIC').value = userData.ic_number;
            
            // Update passport photo display
            updatePassportPhotoDisplay();
        }
        
        function showApplication() {
            document.getElementById('loadingScreen').style.display = 'none';
            document.getElementById('applicationContent').style.display = 'block';
        }
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('ms-MY');
        }
        
        function initializeDocumentUploads() {
            // Initialize file input listeners for each document type
            const documentTypes = ['ssm', 'plan', 'ic', 'tax', 'signboard', 'health', 'land', 'owner', 'halal', 'receipt'];
            
            documentTypes.forEach(type => {
                const fileInput = document.getElementById(type + 'File');
                if (fileInput) {
                    fileInput.addEventListener('change', function(e) {
                        handleDocumentUpload(type, e.target.files);
                    });
                }
            });
        }
        
        function handleDocumentUpload(documentType, files) {
            if (files.length === 0) return;
            
            const file = files[0]; // Take the first file for single uploads
            const statusElement = document.getElementById(documentType + 'Status');
            
            // Validate file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                updateDocumentStatus(documentType, 'error', `Fail terlalu besar (${(file.size / 1024 / 1024).toFixed(2)} MB)`);
                return;
            }
            
            // Validate file type
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                updateDocumentStatus(documentType, 'error', 'Format fail tidak diterima');
                return;
            }
            
            // Store the file
            uploadedFiles[documentType] = file;
            
            // Update status
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            updateDocumentStatus(documentType, 'uploaded', `${file.name} (${fileSize} MB)`);
        }
        
        function updateDocumentStatus(documentType, status, message) {
            const statusElement = document.getElementById(documentType + 'Status');
            const statusBadge = statusElement.querySelector('.status-badge');
            
            // Remove existing classes
            statusBadge.className = 'status-badge';
            
            // Add new status class
            switch(status) {
                case 'uploaded':
                    statusBadge.classList.add('status-uploaded');
                    break;
                case 'error':
                    statusBadge.classList.add('status-error');
                    break;
                case 'pending':
                    statusBadge.classList.add('status-pending');
                    break;
                case 'optional':
                    statusBadge.classList.add('status-optional');
                    break;
            }
            
            statusBadge.textContent = message;
        }
        
        function removeDocument(documentType) {
            delete uploadedFiles[documentType];
            updateDocumentStatus(documentType, 'pending', 'Belum dimuat naik');
            
            // Clear the file input
            const fileInput = document.getElementById(documentType + 'File');
            if (fileInput) {
                fileInput.value = '';
            }
        }
        
        function initializeFormHandlers() {
            // Handle processing type change for fee calculation
            document.getElementById('processingType').addEventListener('change', calculateFees);
            
            // Handle signboard visibility
            document.getElementById('hasSignboard').addEventListener('change', function() {
                const signboardDetails = document.getElementById('signboardDetails');
                signboardDetails.style.display = this.value === 'Ya' ? 'block' : 'none';
            });
            
            // Handle passport photo upload
            document.getElementById('passportPhotoInput').addEventListener('change', function(e) {
                handlePassportPhotoUpload(e.target.files);
            });
            
            // Handle form submission
            document.getElementById('applicationForm').addEventListener('submit', function(e) {
                e.preventDefault();
                submitApplication();
            });
        }
        
        function calculateFees() {
            const processingType = document.getElementById('processingType').value;
            const licenseTypeLabel = document.getElementById('licenseTypeLabel');
            const licenseFee = document.getElementById('licenseFee');
            const totalFee = document.getElementById('totalFee');
            
            let fee = 0;
            let label = '-';
            
            switch(processingType) {
                case 'perniagaan':
                    fee = 70;
                    label = 'Perniagaan';
                    break;
                case 'perindustrian':
                    fee = 100;
                    label = 'Perindustrian';
                    break;
                default:
                    fee = 0;
                    label = '-';
            }
            
            const fileFee = 10; // Yuran fail tetap
            const total = fee + fileFee;
            
            licenseTypeLabel.textContent = label;
            licenseFee.textContent = `RM${fee.toFixed(2)}`;
            totalFee.textContent = `RM${total.toFixed(2)}`;
        }
        
        async function saveDraft() {
            const formData = new FormData(document.getElementById('applicationForm'));
            
            // Add uploaded files
            Object.keys(uploadedFiles).forEach(documentType => {
                formData.append(`documents[${documentType}]`, uploadedFiles[documentType]);
            });
            
            formData.append('action', 'save_draft');
            formData.append('status_borang', 'draft');
            
            try {
                const response = await fetch('../api/permohonan/simpan.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('sessionToken')}`
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert('Draft berjaya disimpan!');
                } else {
                    alert('Ralat: ' + (data.message || 'Gagal menyimpan draft'));
                }
            } catch (error) {
                console.error('Save draft error:', error);
                alert('Ralat rangkaian: Gagal menyimpan draft');
            }
        }
        
        async function submitApplication() {
            if (!validateForm()) {
                return;
            }
            
            if (!confirm('Adakah anda pasti untuk menyerah permohonan ini? Permohonan tidak boleh diubah selepas diserahkan.')) {
                return;
            }
            
            const formData = new FormData(document.getElementById('applicationForm'));
            
            // Add uploaded files
            Object.keys(uploadedFiles).forEach(documentType => {
                formData.append(`documents[${documentType}]`, uploadedFiles[documentType]);
            });
            
            formData.append('action', 'submit_application');
            formData.append('status_borang', 'submit');
            
            try {
                const response = await fetch('../api/permohonan/submit.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('sessionToken')}`
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert('Permohonan berjaya diserahkan! Nombor permohonan: ' + data.application_number);
                    window.location.href = 'dashboard.php';
                } else {
                    alert('Ralat: ' + (data.message || 'Gagal menyerah permohonan'));
                }
            } catch (error) {
                console.error('Submit application error:', error);
                alert('Ralat rangkaian: Gagal menyerah permohonan');
            }
        }
        
        async function deleteDraft() {
            if (!confirm('Adakah anda pasti untuk memadamkan draft ini? Tindakan ini tidak boleh dibatalkan.')) {
                return;
            }
            
            try {
                const response = await fetch('../api/permohonan/delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('sessionToken')}`
                    },
                    body: JSON.stringify({
                        action: 'delete_draft'
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert('Draft berjaya dipadamkan!');
                    window.location.href = 'dashboard.php';
                } else {
                    alert('Ralat: ' + (data.message || 'Gagal memadamkan draft'));
                }
            } catch (error) {
                console.error('Delete draft error:', error);
                alert('Ralat rangkaian: Gagal memadamkan draft');
            }
        }
        
        function validateForm() {
            const requiredFields = [
                'licenseType', 'processingType', 'businessName', 'businessAddress', 'buildingType',
                'operationYear', 'premiseSize', 'position', 'ssmRegistration',
                'applicantName', 'applicantIC', 'applicantDeclaration', 'agreeTerms'
            ];
            
            for (const fieldId of requiredFields) {
                const field = document.getElementById(fieldId);
                if (field.type === 'checkbox') {
                    if (!field.checked) {
                        alert(`Sila tandakan pengakuan pemohon.`);
                        field.focus();
                        return false;
                    }
                } else if (!field.value.trim()) {
                    alert(`Sila isi semua medan yang diperlukan.`);
                    field.focus();
                    return false;
                }
            }
            
            // Validate required documents
            const requiredDocuments = ['ssm', 'plan', 'ic', 'receipt'];
            const missingDocuments = [];
            
            requiredDocuments.forEach(docType => {
                if (!uploadedFiles[docType]) {
                    const docNames = {
                        'ssm': 'Salinan SSM',
                        'plan': 'Lakaran pelan lokasi premis',
                        'ic': 'Salinan kad pengenalan pemohon',
                        'receipt': 'Resit bayaran pemprosesan lesen'
                    };
                    missingDocuments.push(docNames[docType]);
                }
            });
            
            if (missingDocuments.length > 0) {
                alert(`Sila muat naik dokumen yang diperlukan:\n${missingDocuments.join('\n')}`);
                return false;
            }
            
            // Validate age
            const age = parseInt(userData.umur);
            if (age < 18) {
                alert('Pemohon mestilah berumur 18 tahun ke atas.');
                return false;
            }
            
            // Validate operation year
            const operationYear = parseInt(document.getElementById('operationYear').value);
            const currentYear = new Date().getFullYear();
            if (operationYear > currentYear) {
                alert('Tahun mula beroperasi tidak boleh melebihi tahun semasa.');
                return false;
            }
            
            return true;
        }
        
        // Passport Photo Functions
        function handlePassportPhotoUpload(files) {
            if (files.length === 0) return;
            
            const file = files[0];
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format fail tidak diterima. Sila pilih fail JPG, JPEG, atau PNG sahaja.');
                return;
            }
            
            // Validate file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                alert(`Fail terlalu besar (${(file.size / 1024 / 1024).toFixed(2)} MB). Saiz maksimum adalah 5MB.`);
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('passportPhotoImg').src = e.target.result;
                document.getElementById('passportPhotoDisplay').classList.add('has-photo');
                document.getElementById('removePassportPhotoBtn').style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
            
            // Upload to server
            uploadPassportPhoto(file);
        }
        
        async function uploadPassportPhoto(file) {
            const formData = new FormData();
            formData.append('passport_photo', file);
            
            try {
                const response = await fetch('../api/profile/upload_passport_photo.php', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('sessionToken')}`
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    console.log('Passport photo uploaded successfully');
                    // Update user data with new photo path
                    if (userData) {
                        userData.passport_photo = data.data.photo_path;
                    }
                } else {
                    alert('Ralat: ' + (data.message || 'Gagal memuat naik foto passport'));
                    // Revert preview
                    document.getElementById('passportPhotoDisplay').classList.remove('has-photo');
                    document.getElementById('removePassportPhotoBtn').style.display = 'none';
                }
            } catch (error) {
                console.error('Upload passport photo error:', error);
                alert('Ralat rangkaian: Gagal memuat naik foto passport');
                // Revert preview
                document.getElementById('passportPhotoDisplay').classList.remove('has-photo');
                document.getElementById('removePassportPhotoBtn').style.display = 'none';
            }
        }
        
        function removePassportPhoto() {
            if (!confirm('Adakah anda pasti untuk memadamkan foto passport ini?')) {
                return;
            }
            
            // Clear preview
            document.getElementById('passportPhotoImg').src = '../image/default-avatar.png';
            document.getElementById('passportPhotoDisplay').classList.remove('has-photo');
            document.getElementById('removePassportPhotoBtn').style.display = 'none';
            document.getElementById('passportPhotoInput').value = '';
            
            // Clear from user data
            if (userData) {
                userData.passport_photo = null;
            }
        }
        
        function updatePassportPhotoDisplay() {
            if (userData && userData.passport_photo) {
                document.getElementById('passportPhotoImg').src = '../' + userData.passport_photo;
                document.getElementById('passportPhotoDisplay').classList.add('has-photo');
                document.getElementById('removePassportPhotoBtn').style.display = 'inline-block';
            } else {
                document.getElementById('passportPhotoImg').src = '../image/default-avatar.png';
                document.getElementById('passportPhotoDisplay').classList.remove('has-photo');
                document.getElementById('removePassportPhotoBtn').style.display = 'none';
            }
        }
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?>
                