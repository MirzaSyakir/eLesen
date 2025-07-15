<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Permohonan - Admin eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #f8f9fa;
        }
        .admin-header {
            background: #dc3545;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .admin-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .admin-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .admin-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .admin-avatar {
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .admin-info h6 {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .admin-info small {
            opacity: 0.7;
            font-size: 0.8rem;
        }
        .nav-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.2);
        }
        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
        }
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .page-header {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .page-subtitle {
            color: #6c757d;
            margin-bottom: 0;
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
            border-bottom: 2px solid #dc3545;
        }
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        .detail-label {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .detail-value {
            font-weight: 500;
            color: #333;
            font-size: 1rem;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-block;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-processing {
            background: #e2e3e5;
            color: #383d41;
        }
        .status-approved {
            background: #d1edff;
            color: #0c5460;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        .file-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .file-icon {
            font-size: 1.5rem;
            color: #6c757d;
        }
        .file-info {
            flex: 1;
        }
        .file-name {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
        }
        .file-status {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .file-uploaded {
            color: #28a745;
        }
        .file-missing {
            color: #dc3545;
        }
        .history-item {
            padding: 1rem;
            border-left: 3px solid #dc3545;
            margin-bottom: 1rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
        }
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .history-status {
            font-weight: 500;
            color: #333;
        }
        .history-date {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .history-admin {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        .history-remarks {
            font-size: 0.9rem;
            color: #333;
            font-style: italic;
        }
        .btn-primary {
            background: #dc3545;
            border-color: #dc3545;
            font-weight: 500;
            border-radius: 0.6rem;
            padding: 0.75rem 2rem;
        }
        .btn-primary:hover {
            background: #c82333;
            border-color: #c82333;
        }
        .btn-secondary {
            background: #6c757d;
            border-color: #6c757d;
            font-weight: 500;
            border-radius: 0.6rem;
            padding: 0.75rem 2rem;
        }
        .btn-secondary:hover {
            background: #5a6268;
            border-color: #5a6268;
        }
        .loading {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }
        .alert {
            border-radius: 0.6rem;
            border: none;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Admin Header -->
    <div class="admin-header">
        <div class="admin-navbar">
            <div class="admin-logo">
                <i class="bi bi-shield-check"></i>
                <span>eLesen Admin</span>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="admin_dashboard.php" class="nav-link">
                    <i class="bi bi-house me-1"></i>
                    Dashboard
                </a>
                <a href="admin_applications.php" class="nav-link active">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    Permohonan
                </a>
                <div class="admin-user">
                    <div class="admin-info">
                        <h6 id="adminName">Loading...</h6>
                        <small id="adminRole">Loading...</small>
                    </div>
                    <div class="admin-avatar">
                        <i class="bi bi-person"></i>
                    </div>
                    <a href="#" class="logout-btn" id="logoutBtn">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Log Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">Lihat Permohonan</h1>
                    <p class="page-subtitle" id="applicationNumber">Memuatkan...</p>
                </div>
                <div>
                    <a href="admin_applications.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuatkan butiran permohonan...</p>
        </div>

        <!-- Application Content -->
        <div id="applicationContent" style="display: none;">
            <!-- Application Overview -->
            <div class="section-card">
                <div class="section-title">
                    <i class="bi bi-info-circle"></i>
                    Maklumat Permohonan
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Nombor Permohonan</div>
                        <div class="detail-value" id="appNumber">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            <span id="appStatus" class="status-badge">-</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tarikh Permohonan</div>
                        <div class="detail-value" id="appDate">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jenis Lesen</div>
                        <div class="detail-value" id="appLicenseType">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jenis Pemprosesan</div>
                        <div class="detail-value" id="appProcessingType">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status Borang</div>
                        <div class="detail-value" id="appFormStatus">-</div>
                    </div>
                </div>
            </div>

            <!-- Applicant Information -->
            <div class="section-card">
                <div class="section-title">
                    <i class="bi bi-person-circle"></i>
                    Maklumat Pemohon
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Nama Penuh</div>
                        <div class="detail-value" id="applicantName">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nombor IC</div>
                        <div class="detail-value" id="applicantIC">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Telefon</div>
                        <div class="detail-value" id="applicantPhone">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Emel</div>
                        <div class="detail-value" id="applicantEmail">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Alamat</div>
                        <div class="detail-value" id="applicantAddress">-</div>
                    </div>
                </div>
            </div>

            <!-- Business Information -->
            <div class="section-card">
                <div class="section-title">
                    <i class="bi bi-building"></i>
                    Maklumat Perniagaan
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Nama Perniagaan</div>
                        <div class="detail-value" id="businessName">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Alamat Perniagaan</div>
                        <div class="detail-value" id="businessAddress">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jenis Bangunan</div>
                        <div class="detail-value" id="buildingType">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tahun Operasi</div>
                        <div class="detail-value" id="operationYear">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Saiz Premis</div>
                        <div class="detail-value" id="premiseSize">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Kedudukan</div>
                        <div class="detail-value" id="position">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Pendaftaran SSM</div>
                        <div class="detail-value" id="ssmRegistration">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Bilangan Pekerja Lelaki</div>
                        <div class="detail-value" id="maleWorkers">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Bilangan Pekerja Perempuan</div>
                        <div class="detail-value" id="femaleWorkers">-</div>
                    </div>
                </div>
            </div>

            <!-- Signboard Information -->
            <div class="section-card" id="signboardSection" style="display: none;">
                <div class="section-title">
                    <i class="bi bi-sign-intersection"></i>
                    Maklumat Papan Tanda
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Ada Papan Tanda</div>
                        <div class="detail-value" id="hasSignboard">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jenis Papan Tanda</div>
                        <div class="detail-value" id="signboardType">-</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Saiz Papan Tanda</div>
                        <div class="detail-value" id="signboardSize">-</div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="section-card">
                <div class="section-title">
                    <i class="bi bi-file-earmark-text"></i>
                    Dokumen Sokongan
                </div>
                <div id="documentsList">
                    <!-- Documents will be loaded here -->
                </div>
            </div>

            <!-- Status History -->
            <div class="section-card">
                <div class="section-title">
                    <i class="bi bi-clock-history"></i>
                    Sejarah Status
                </div>
                <div id="statusHistory">
                    <!-- Status history will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let adminData = null;
        let sessionToken = null;
        let applicationId = null;

        // Check authentication on page load
        document.addEventListener('DOMContentLoaded', function() {
            sessionToken = localStorage.getItem('adminSessionToken');
            adminData = JSON.parse(localStorage.getItem('adminData') || '{}');

            if (!sessionToken || !adminData.id) {
                window.location.href = 'admin_login.php';
                return;
            }

            // Get application ID from URL
            const urlParams = new URLSearchParams(window.location.search);
            applicationId = urlParams.get('id');

            if (!applicationId) {
                alert('ID permohonan tidak sah');
                window.location.href = 'admin_applications.php';
                return;
            }

            // Validate session and load application
            validateSession();
        });

        async function validateSession() {
            try {
                const response = await fetch('../api/auth/admin_validate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        session_token: sessionToken
                    })
                });

                const data = await response.json();

                if (data.status !== 200) {
                    localStorage.removeItem('adminSessionToken');
                    localStorage.removeItem('adminData');
                    window.location.href = 'admin_login.php';
                    return;
                }

                // Update admin info
                adminData = data.data.admin;
                updateAdminInfo();
                loadApplicationDetails();
            } catch (error) {
                console.error('Session validation error:', error);
                window.location.href = 'admin_login.php';
            }
        }

        function updateAdminInfo() {
            document.getElementById('adminName').textContent = adminData.full_name;
            document.getElementById('adminRole').textContent = getRoleDisplayName(adminData.role);
        }

        function getRoleDisplayName(role) {
            const roleNames = {
                'super_admin': 'Super Admin',
                'admin': 'Admin',
                'officer': 'Pegawai'
            };
            return roleNames[role] || role;
        }

        async function loadApplicationDetails() {
            try {
                const response = await fetch('../api/admin/application_detail.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        session_token: sessionToken,
                        application_id: applicationId
                    })
                });

                const data = await response.json();

                if (data.status === 200) {
                    displayApplicationDetails(data.data);
                    hideLoading();
                } else {
                    console.error('Failed to load application details:', data.message);
                    alert('Ralat memuatkan butiran permohonan: ' + data.message);
                    window.location.href = 'admin_applications.php';
                }
            } catch (error) {
                console.error('Error loading application details:', error);
                alert('Ralat rangkaian');
                window.location.href = 'admin_applications.php';
            }
        }

        function displayApplicationDetails(data) {
            const app = data.application;
            const applicant = data.applicant;

            // Update page header
            document.getElementById('applicationNumber').textContent = app.application_number;

            // Application overview
            document.getElementById('appNumber').textContent = app.application_number;
            document.getElementById('appStatus').textContent = getStatusDisplayName(app.status);
            document.getElementById('appStatus').className = `status-badge status-${app.status}`;
            document.getElementById('appDate').textContent = formatDate(app.created_at);
            document.getElementById('appLicenseType').textContent = app.license_type || '-';
            document.getElementById('appProcessingType').textContent = app.processing_type || '-';
            document.getElementById('appFormStatus').textContent = app.status_borang === 'submit' ? 'Dihantar' : 'Draf';

            // Applicant information
            document.getElementById('applicantName').textContent = applicant.full_name;
            document.getElementById('applicantIC').textContent = applicant.ic_number;
            document.getElementById('applicantPhone').textContent = applicant.phone;
            document.getElementById('applicantEmail').textContent = applicant.email || '-';
            document.getElementById('applicantAddress').textContent = `${applicant.address}, ${applicant.postcode} ${applicant.city}, ${applicant.state}`;

            // Business information
            document.getElementById('businessName').textContent = app.business_name || '-';
            document.getElementById('businessAddress').textContent = app.business_address || '-';
            document.getElementById('buildingType').textContent = app.building_type || '-';
            document.getElementById('operationYear').textContent = app.operation_year || '-';
            document.getElementById('premiseSize').textContent = app.premise_size || '-';
            document.getElementById('position').textContent = app.position || '-';
            document.getElementById('ssmRegistration').textContent = app.ssm_registration || '-';
            document.getElementById('maleWorkers').textContent = app.male_workers || '0';
            document.getElementById('femaleWorkers').textContent = app.female_workers || '0';

            // Signboard information
            if (app.has_signboard === 'Ya') {
                document.getElementById('signboardSection').style.display = 'block';
                document.getElementById('hasSignboard').textContent = 'Ya';
                document.getElementById('signboardType').textContent = app.signboard_type || '-';
                document.getElementById('signboardSize').textContent = app.signboard_size || '-';
            }

            // Display documents
            displayDocuments(data.files);

            // Display status history
            displayStatusHistory(data.status_history);
        }

        function displayDocuments(files) {
            const documentsList = document.getElementById('documentsList');
            const documentTypes = {
                'ssm_file': 'Dokumen SSM',
                'plan_file': 'Pelan Lokasi',
                'ic_file': 'Salinan IC',
                'receipt_file': 'Resit Bayaran',
                'tax_file': 'Dokumen Cukai',
                'signboard_file': 'Dokumen Papan Tanda',
                'health_file': 'Dokumen Kesihatan',
                'land_file': 'Dokumen Tanah',
                'owner_file': 'Dokumen Pemilik',
                'halal_file': 'Dokumen Halal'
            };

            let documentsHtml = '';
            Object.keys(documentTypes).forEach(fileKey => {
                const fileName = files[fileKey];
                const isUploaded = fileName && fileName !== '';
                
                documentsHtml += `
                    <div class="file-item">
                        <div class="file-icon">
                            <i class="bi ${isUploaded ? 'bi-file-earmark-check' : 'bi-file-earmark-x'}"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name">${documentTypes[fileKey]}</div>
                            <div class="file-status ${isUploaded ? 'file-uploaded' : 'file-missing'}">
                                ${isUploaded ? 'Dihantar' : 'Tidak dihantar'}
                            </div>
                        </div>
                        ${isUploaded ? `
                            <a href="../${fileName}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>
                                Lihat
                            </a>
                        ` : ''}
                    </div>
                `;
            });

            documentsList.innerHTML = documentsHtml;
        }

        function displayStatusHistory(history) {
            const historyContainer = document.getElementById('statusHistory');
            
            if (history.length === 0) {
                historyContainer.innerHTML = '<p class="text-muted">Tiada sejarah status dijumpai.</p>';
                return;
            }

            let historyHtml = '';
            history.forEach(item => {
                historyHtml += `
                    <div class="history-item">
                        <div class="history-header">
                            <span class="history-status">${getStatusDisplayName(item.new_status)}</span>
                            <span class="history-date">${formatDate(item.created_at)}</span>
                        </div>
                        ${item.admin_name ? `<div class="history-admin">Oleh: ${item.admin_name}</div>` : ''}
                        ${item.remarks ? `<div class="history-remarks">"${item.remarks}"</div>` : ''}
                    </div>
                `;
            });

            historyContainer.innerHTML = historyHtml;
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('ms-MY', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function getStatusDisplayName(status) {
            const statusNames = {
                'pending': 'Menunggu',
                'processing': 'Dalam Proses',
                'approved': 'Diluluskan',
                'rejected': 'Ditolak'
            };
            return statusNames[status] || status;
        }

        function hideLoading() {
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('applicationContent').style.display = 'block';
        }

        // Logout functionality
        document.getElementById('logoutBtn').addEventListener('click', async function(e) {
            e.preventDefault();
            
            try {
                await fetch('../api/auth/admin_logout.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        session_token: sessionToken
                    })
                });

                localStorage.removeItem('adminSessionToken');
                localStorage.removeItem('adminData');
                window.location.href = 'admin_login.php';
            } catch (error) {
                console.error('Logout error:', error);
                // Still redirect even if logout API fails
                localStorage.removeItem('adminSessionToken');
                localStorage.removeItem('adminData');
                window.location.href = 'admin_login.php';
            }
        });
    </script>
</body>
</html> 