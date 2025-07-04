<?php
session_start();
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eLesen - Sistem Pengurusan Lesen Majlis Daerah Pasir Mas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(135deg, #8659cf 0%, #7a4fc7 100%);
            color: white;
            padding: 4rem 0 2rem 0;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        .btn-hero {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.6rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-hero:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-2px);
        }
        .btn-hero-primary {
            background: white;
            color: #8659cf;
            border-color: white;
        }
        .btn-hero-primary:hover {
            background: #f8f9fa;
            color: #8659cf;
        }
        .feature-section {
            padding: 4rem 0;
            background: white;
        }
        .feature-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .feature-icon {
            background: #8659cf1a;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #8659cf;
            margin: 0 auto 1.5rem auto;
        }
        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        .feature-desc {
            color: #6c757d;
            line-height: 1.6;
        }
        .info-section {
            padding: 4rem 0;
            background: #f8f9fa;
        }
        .info-card {
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .info-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .info-list li {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .info-list li:last-child {
            border-bottom: none;
        }
        .info-list li i {
            color: #8659cf;
            font-size: 1.1rem;
        }
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            .hero-subtitle {
                font-size: 1rem;
            }
            .feature-section, .info-section {
                padding: 2rem 0;
            }
        }
        .hover-lift:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 8px 25px rgba(134,89,207,0.13) !important; }
        .step-line {
            width: 40px;
            height: 3px;
            background: #8659cf;
            margin: 0 10px;
            border-radius: 2px;
            display: inline-block;
            vertical-align: middle;
        }
        .step-icon { transition: color 0.2s; }
        .step-icon:hover { color: #7a4fc7 !important; }
        .btn-purple {
            background: #8659cf;
            border-color: #8659cf;
            color: #fff;
            font-weight: 500;
            border-radius: 0.6rem;
            transition: all 0.2s;
        }
        .btn-purple:hover, .btn-purple:focus {
            background: #7a4fc7;
            border-color: #7a4fc7;
            color: #fff;
        }
        .btn-outline-purple {
            color: #8659cf;
            border-color: #8659cf;
            background: #fff;
            font-weight: 500;
            border-radius: 0.6rem;
            transition: all 0.2s;
        }
        .btn-outline-purple:hover, .btn-outline-purple:focus {
            background: #8659cf;
            color: #fff;
            border-color: #8659cf;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Hero Section -->
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <h1 class="fw-bold mb-3" style="font-size:2.5rem;">Mohon Lesen Perniagaan Anda<br>Dengan Mudah</h1>
                <p class="mb-4" style="font-size:1.1rem;">Permohonan lesen perniagaan kini boleh dilakukan secara atas talian. Mudah, pantas dan mesra pengguna!</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="page/signup.php" class="btn btn-purple px-4 py-2">Mohon Sekarang</a>
                    <a href="#syarat" class="btn btn-outline-purple px-4 py-2">Lihat Syarat</a>
                </div>
            </div>
            <div class="col-lg-5 text-center">
                <img src="image/Logo-Majlis-Daerah-Pasir-Mas.png" alt="Majlis Daerah Pasir Mas" style="max-height:120px;">
            </div>
        </div>

        <!-- Langkah Permohonan -->
        <h5 class="fw-bold mb-4">Langkah Permohonan</h5>
        <div class="row g-3 mb-5">
            <div class="col-6 col-md-3">
                <div class="rounded-4 bg-white shadow-sm py-4 text-center h-100">
                    <div class="mb-2"><i class="bi bi-person fs-2" style="color:#8659cf;"></i></div>
                    <div class="fw-semibold">Daftar Akaun Pengguna</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="rounded-4 bg-white shadow-sm py-4 text-center h-100">
                    <div class="mb-2"><i class="bi bi-file-earmark-text fs-2" style="color:#8659cf;"></i></div>
                    <div class="fw-semibold">Lengkapkan Borang Permohonan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="rounded-4 bg-white shadow-sm py-4 text-center h-100">
                    <div class="mb-2"><i class="bi bi-upload fs-2" style="color:#8659cf;"></i></div>
                    <div class="fw-semibold">Muat Naik Dokumen Diperlukan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="rounded-4 bg-white shadow-sm py-4 text-center h-100">
                    <div class="mb-2"><i class="bi bi-credit-card fs-2" style="color:#8659cf;"></i></div>
                    <div class="fw-semibold">Buat Bayaran Dalam Talian</div>
                </div>
            </div>
        </div>

        <!-- Senarai Lesen Ditawarkan -->
        <h5 class="fw-bold mb-4">Senarai Lesen Ditawarkan</h5>
        <div class="row g-3 mb-5">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="rounded-4 border shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                    <div class="fw-semibold mb-3">Lesen Perniagaan Premis Tetap</div>
                    <a href="page/permohonan.php" class="btn btn-purple w-100">Mohon</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="rounded-4 border shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                    <div class="fw-semibold mb-3">Lesen Perniagaan Bergerak</div>
                    <a href="page/permohonan.php" class="btn btn-purple w-100">Mohon</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="rounded-4 border shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                    <div class="fw-semibold mb-3">Lesen Penjaja</div>
                    <a href="page/permohonan.php" class="btn btn-purple w-100">Mohon</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="rounded-4 border shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                    <div class="fw-semibold mb-3">Permit Sementara</div>
                    <a href="page/permohonan.php" class="btn btn-purple w-100">Mohon</a>
                </div>
            </div>
        </div>

        <!-- Syarat Permohonan & Dokumen Diperlukan -->
        <h5 class="fw-bold mb-4" id="syarat">Syarat Permohonan & Dokumen Diperlukan</h5>
        <div class="row g-3">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="rounded-4 border shadow-sm p-4 h-100">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-file-earmark-text fs-3 me-2" style="color:#3b82f6;"></i>
                        <span class="fw-semibold">Dokumen Sokongan</span>
                    </div>
                    <ul class="mb-0 ps-4 small">
                        <li>Salinan Kad Pengenalan</li>
                        <li>Salinan SSM</li>
                        <li>Gambar Premis</li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="rounded-4 border shadow-sm p-4 h-100">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-receipt fs-3 me-2" style="color:#3b82f6;"></i>
                        <span class="fw-semibold">Resit Pembayaran</span>
                    </div>
                    <ul class="mb-0 ps-4 small">
                        <li>Resit Pembayaran Yuran Permohonan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'includes/footer.php'; ?>

