<?php 
session_start();
include '../includes/dashboard_header.php'; 
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesen Saya - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #f8f9fa;
        }
        .licenses-container {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        .licenses-header {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .license-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .license-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .license-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #28a745;
        }
        .license-number {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        .license-type {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .business-name {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .business-address {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .license-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f1f1f1;
        }
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        .detail-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }
        .detail-value {
            font-weight: 500;
            color: #333;
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            background: #d4edda;
            color: #155724;
        }
        .btn {
            border-radius: 0.6rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            color: #6c757d;
        }
        .empty-state .empty-icon {
            font-size: 4rem;
            color: #d1d1e0;
            margin-bottom: 1rem;
        }
        .empty-state .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .empty-state .empty-desc {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            text-align: center;
            max-width: 400px;
        }
        .empty-state .btn-primary {
            background: #8659cf;
            border-color: #8659cf;
            border-radius: 2.5rem;
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(134,89,207,0.08);
            transition: background 0.2s;
        }
        .empty-state .btn-primary:hover {
            background: #7a4fc7;
            border-color: #7a4fc7;
        }
        .stats-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: 600;
            color: #28a745;
            margin-bottom: 0.5rem;
        }
        .stats-label {
            color: #6c757d;
            font-size: 1rem;
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
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        .page-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #dee2e6;
            background: #fff;
            color: #6c757d;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .page-btn:hover {
            background: #f8f9fa;
            color: #333;
        }
        .page-btn.active {
            background: #8659cf;
            color: #fff;
            border-color: #8659cf;
        }
        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        @media (max-width: 768px) {
            .licenses-container {
                padding: 1rem 0;
            }
            .licenses-header {
                padding: 1.5rem;
            }
            .license-card {
                padding: 1rem;
            }
            .license-details {
                grid-template-columns: 1fr;
            }
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
            <p class="mt-3">Memuatkan lesen anda...</p>
        </div>
    </div>

    <!-- Licenses Content -->
    <div id="licensesContent" style="display: none;">
        <div class="licenses-container">
            <div class="container">
                <!-- Header -->
                <div class="licenses-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-2">
                                <i class="bi bi-card-checklist me-2"></i>
                                Lesen Saya
                            </h1>
                            <p class="text-muted mb-0">Senarai lesen yang telah diluluskan</p>
                        </div>
                        <div>
                            <a href="dashboard.php" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-left me-2"></i>
                                Kembali
                            </a>
                            <a href="permohonan.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>
                                Mohon Lesen Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number" id="totalLicenses">0</div>
                            <div class="stats-label">Jumlah Lesen</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number" id="activeLicenses">0</div>
                            <div class="stats-label">Lesen Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number" id="expiredLicenses">0</div>
                            <div class="stats-label">Lesen Tamat</div>
                        </div>
                    </div>
                </div>

                <!-- Licenses List -->
                <div id="licensesList">
                    <!-- Licenses will be loaded here -->
                </div>

                <!-- Pagination -->
                <div id="paginationContainer" class="pagination-container" style="display: none;">
                    <!-- Pagination will be loaded here -->
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="empty-state" style="display: none;">
                    <div class="empty-icon">
                        <i class="bi bi-card-checklist"></i>
                    </div>
                    <div class="empty-title">Tiada Lesen Diluluskan</div>
                    <div class="empty-desc">
                        Anda belum mempunyai sebarang lesen yang diluluskan. 
                        Buat permohonan lesen baharu untuk memulakan perniagaan anda.
                    </div>
                    <a href="permohonan.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Mohon Lesen Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPage = 1;
        let totalPages = 1;

        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in
            const sessionToken = localStorage.getItem('sessionToken');
            const userData = localStorage.getItem('userData');
            const sessionExpires = localStorage.getItem('sessionExpires');
            
            if (!sessionToken || !userData || !sessionExpires) {
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
            
            loadLicenses();
        });
        
        async function loadLicenses(page = 1) {
            try {
                const sessionToken = localStorage.getItem('sessionToken');
                const response = await fetch(`../api/permohonan/approved_licenses.php?page=${page}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${sessionToken}`
                    }
                });
                
                const data = await response.json();
                
                if (response.ok && data.status === 200) {
                    displayLicenses(data.data.licenses, data.data.pagination);
                    updateStats(data.data.licenses);
                } else {
                    showError('Gagal memuatkan data lesen');
                }
                
            } catch (error) {
                console.error('Error loading licenses:', error);
                showError('Ralat rangkaian. Sila cuba lagi.');
            }
        }
        
        function displayLicenses(licenses, pagination) {
            const licensesList = document.getElementById('licensesList');
            const emptyState = document.getElementById('emptyState');
            const paginationContainer = document.getElementById('paginationContainer');
            
            if (licenses.length === 0) {
                licensesList.style.display = 'none';
                paginationContainer.style.display = 'none';
                emptyState.style.display = 'flex';
                return;
            }
            
            emptyState.style.display = 'none';
            licensesList.style.display = 'block';
            
            let html = '';
            licenses.forEach(license => {
                const approvedDate = formatDate(license.approved_at || license.updated_at);
                const expiryDate = license.expiry_date ? formatDate(license.expiry_date) : 'Tidak ditetapkan';
                const isExpired = license.expiry_date && new Date(license.expiry_date) < new Date();
                
                html += `
                    <div class="license-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <div class="license-number">${license.license_number || license.application_number}</div>
                                <div class="license-type">${license.license_type}</div>
                                <div class="business-name">${license.business_name || 'Nama Perniagaan Tidak Ditetapkan'}</div>
                                <div class="business-address">${license.business_address || 'Alamat Tidak Ditetapkan'}</div>
                            </div>
                            <div class="text-end">
                                <span class="status-badge ${isExpired ? 'bg-warning text-dark' : ''}">
                                    ${isExpired ? 'Tamat Tempoh' : 'Aktif'}
                                </span>
                            </div>
                        </div>
                        
                        <div class="license-details">
                            <div class="detail-item">
                                <div class="detail-label">Tarikh Diluluskan</div>
                                <div class="detail-value">${approvedDate}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Tarikh Tamat</div>
                                <div class="detail-value">${expiryDate}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Jenis Pemprosesan</div>
                                <div class="detail-value">${license.processing_type || 'Standard'}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Jenis Bangunan</div>
                                <div class="detail-value">${license.building_type || 'Tidak Ditetapkan'}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Saiz Premis</div>
                                <div class="detail-value">${license.premise_size ? license.premise_size + ' kaki persegi' : 'Tidak Ditetapkan'}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Pekerja</div>
                                <div class="detail-value">${license.male_workers + license.female_workers} orang</div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button class="btn btn-outline-primary btn-sm me-2" onclick="viewLicenseDetails(${license.id})">
                                <i class="bi bi-eye me-1"></i>
                                Lihat Butiran
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="downloadLicense(${license.id})">
                                <i class="bi bi-download me-1"></i>
                                Muat Turun
                            </button>
                        </div>
                    </div>
                `;
            });
            
            licensesList.innerHTML = html;
            
            // Update pagination
            currentPage = pagination.current_page;
            totalPages = pagination.total_pages;
            displayPagination(pagination);
        }
        
        function displayPagination(pagination) {
            const container = document.getElementById('paginationContainer');
            
            if (pagination.total_pages <= 1) {
                container.style.display = 'none';
                return;
            }
            
            container.style.display = 'flex';
            
            let html = '';
            
            // Previous button
            html += `
                <a href="#" class="page-btn ${!pagination.has_prev ? 'disabled' : ''}" 
                   onclick="${pagination.has_prev ? `loadLicenses(${pagination.current_page - 1})` : 'return false'}">
                    <i class="bi bi-chevron-left"></i>
                </a>
            `;
            
            // Page numbers
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.total_pages, pagination.current_page + 2);
            
            for (let i = startPage; i <= endPage; i++) {
                html += `
                    <a href="#" class="page-btn ${i === pagination.current_page ? 'active' : ''}" 
                       onclick="loadLicenses(${i})">
                        ${i}
                    </a>
                `;
            }
            
            // Next button
            html += `
                <a href="#" class="page-btn ${!pagination.has_next ? 'disabled' : ''}" 
                   onclick="${pagination.has_next ? `loadLicenses(${pagination.current_page + 1})` : 'return false'}">
                    <i class="bi bi-chevron-right"></i>
                </a>
            `;
            
            container.innerHTML = html;
        }
        
        function updateStats(licenses) {
            const totalLicenses = licenses.length;
            const activeLicenses = licenses.filter(license => {
                if (!license.expiry_date) return true;
                return new Date(license.expiry_date) >= new Date();
            }).length;
            const expiredLicenses = totalLicenses - activeLicenses;
            
            document.getElementById('totalLicenses').textContent = totalLicenses;
            document.getElementById('activeLicenses').textContent = activeLicenses;
            document.getElementById('expiredLicenses').textContent = expiredLicenses;
        }
        
        function formatDate(dateString) {
            if (!dateString) return 'Tidak Ditetapkan';
            const date = new Date(dateString);
            return date.toLocaleDateString('ms-MY');
        }
        
        function viewLicenseDetails(licenseId) {
            // TODO: Implement license details view
            alert('Fungsi ini akan diimplementasikan tidak lama lagi.');
        }
        
        function downloadLicense(licenseId) {
            // TODO: Implement license download
            alert('Fungsi muat turun akan diimplementasikan tidak lama lagi.');
        }
        
        function showError(message) {
            const licensesList = document.getElementById('licensesList');
            licensesList.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${message}
                </div>
            `;
        }
        
        function showLicenses() {
            document.getElementById('loadingScreen').style.display = 'none';
            document.getElementById('licensesContent').style.display = 'block';
        }
        
        // Show content after initial load
        setTimeout(() => {
            showLicenses();
        }, 500);
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?> 