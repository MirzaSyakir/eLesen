<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urus Permohonan - Admin eLesen</title>
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
        .filters-section {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .filter-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }
        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border-radius: 0.6rem;
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
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
        .applications-section {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
        }
        .application-card {
            border: 1px solid #f1f1f1;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        .application-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .application-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        .application-number {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }
        .application-date {
            color: #6c757d;
            font-size: 0.9rem;
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
        .application-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        .detail-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        .detail-value {
            font-weight: 500;
            color: #333;
        }
        .application-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 0.5rem;
        }
        .btn-success {
            background: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background: #218838;
            border-color: #218838;
        }
        .btn-danger {
            background: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
            border-color: #c82333;
        }
        .btn-info {
            background: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-info:hover {
            background: #138496;
            border-color: #138496;
        }
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        .page-link {
            padding: 0.5rem 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            color: #dc3545;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .page-link:hover {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }
        .page-link.active {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }
        .page-link.disabled {
            color: #6c757d;
            pointer-events: none;
        }
        .loading {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        .modal-header {
            border-bottom: 1px solid #f1f1f1;
        }
        .modal-footer {
            border-top: 1px solid #f1f1f1;
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
            <h1 class="page-title">Urus Permohonan</h1>
            <p class="page-subtitle">Semak dan uruskan permohonan lesen pengguna</p>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <form id="filterForm">
                <div class="filter-row">
                    <div>
                        <label for="statusFilter" class="form-label">Status</label>
                        <select class="form-select" id="statusFilter" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="processing">Dalam Proses</option>
                            <option value="approved">Diluluskan</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label for="searchFilter" class="form-label">Cari</label>
                        <input type="text" class="form-control" id="searchFilter" name="search" placeholder="Nombor permohonan, nama perniagaan, atau pemohon">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>
                            Cari
                        </button>
                        <button type="button" class="btn btn-secondary ms-2" id="resetFilter">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Applications Section -->
        <div class="applications-section">
            <div id="applicationsContainer">
                <div class="loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuatkan permohonan...</p>
                </div>
            </div>
            
            <!-- Pagination -->
            <div id="paginationContainer" class="pagination" style="display: none;"></div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kemas Kini Status Permohonan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="modalAlert"></div>
                    <form id="statusForm">
                        <input type="hidden" id="modalApplicationId">
                        <div class="mb-3">
                            <label for="modalStatus" class="form-label">Status Baru</label>
                            <select class="form-select" id="modalStatus" name="status" required>
                                <option value="">Pilih status</option>
                                <option value="approved">Diluluskan</option>
                                <option value="rejected">Ditolak</option>
                                <option value="processing">Dalam Proses</option>
                                <option value="pending">Menunggu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalRemarks" class="form-label">Catatan (Pilihan)</label>
                            <textarea class="form-control" id="modalRemarks" name="remarks" rows="3" placeholder="Masukkan catatan tentang keputusan ini..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="updateStatusBtn">
                        <span id="updateBtnText">Kemas Kini</span>
                        <span id="updateBtnSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let adminData = null;
        let sessionToken = null;
        let currentPage = 1;
        let currentFilters = {};

        // Check authentication on page load
        document.addEventListener('DOMContentLoaded', function() {
            sessionToken = localStorage.getItem('adminSessionToken');
            adminData = JSON.parse(localStorage.getItem('adminData') || '{}');

            if (!sessionToken || !adminData.id) {
                window.location.href = 'admin_login.php';
                return;
            }

            // Validate session
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
                loadApplications();
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

        async function loadApplications(page = 1) {
            try {
                const filters = {
                    session_token: sessionToken,
                    page: page,
                    limit: 10,
                    ...currentFilters
                };

                const response = await fetch('../api/admin/applications.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(filters)
                });

                const data = await response.json();

                if (data.status === 200) {
                    displayApplications(data.data);
                    currentPage = page;
                } else {
                    console.error('Failed to load applications:', data.message);
                    showAlert('Ralat memuatkan permohonan', 'danger');
                }
            } catch (error) {
                console.error('Error loading applications:', error);
                showAlert('Ralat rangkaian', 'danger');
            }
        }

        function displayApplications(data) {
            const container = document.getElementById('applicationsContainer');
            const paginationContainer = document.getElementById('paginationContainer');

            if (data.applications.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                        <h5 class="mt-3">Tiada Permohonan</h5>
                        <p class="text-muted">Tiada permohonan dijumpai dengan kriteria semasa.</p>
                    </div>
                `;
                paginationContainer.style.display = 'none';
                return;
            }

            container.innerHTML = data.applications.map(app => `
                <div class="application-card">
                    <div class="application-header">
                        <div>
                            <div class="application-number">${app.application_number}</div>
                            <div class="application-date">Dihantar pada: ${formatDate(app.created_at)}</div>
                        </div>
                        <span class="status-badge status-${app.status}">${getStatusDisplayName(app.status)}</span>
                    </div>
                    <div class="application-details">
                        <div class="detail-item">
                            <div class="detail-label">Jenis Lesen</div>
                            <div class="detail-value">${app.license_type}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Nama Perniagaan</div>
                            <div class="detail-value">${app.business_name || 'Tidak dinyatakan'}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Nama Pemohon</div>
                            <div class="detail-value">${app.applicant_name}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">No. IC</div>
                            <div class="detail-value">${app.ic_number}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Telefon</div>
                            <div class="detail-value">${app.phone}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status Borang</div>
                            <div class="detail-value">${app.status_borang === 'submit' ? 'Dihantar' : 'Draf'}</div>
                        </div>
                    </div>
                    <div class="application-actions">
                        <button class="btn btn-info btn-sm" onclick="viewApplication(${app.id})">
                            <i class="bi bi-eye me-1"></i>
                            Lihat
                        </button>
                        <button class="btn btn-success btn-sm" onclick="updateStatus(${app.id}, 'approved')">
                            <i class="bi bi-check-circle me-1"></i>
                            Luluskan
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="updateStatus(${app.id}, 'rejected')">
                            <i class="bi bi-x-circle me-1"></i>
                            Tolak
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="openStatusModal(${app.id})">
                            <i class="bi bi-pencil me-1"></i>
                            Ubah Status
                        </button>
                    </div>
                </div>
            `).join('');

            // Update pagination
            updatePagination(data.pagination);
        }

        function updatePagination(pagination) {
            const container = document.getElementById('paginationContainer');
            
            if (pagination.total_pages <= 1) {
                container.style.display = 'none';
                return;
            }

            let paginationHtml = '';

            // Previous button
            if (pagination.has_prev) {
                paginationHtml += `<a href="#" class="page-link" onclick="loadApplications(${pagination.current_page - 1})">Sebelum</a>`;
            } else {
                paginationHtml += `<span class="page-link disabled">Sebelum</span>`;
            }

            // Page numbers
            for (let i = 1; i <= pagination.total_pages; i++) {
                if (i === pagination.current_page) {
                    paginationHtml += `<span class="page-link active">${i}</span>`;
                } else {
                    paginationHtml += `<a href="#" class="page-link" onclick="loadApplications(${i})">${i}</a>`;
                }
            }

            // Next button
            if (pagination.has_next) {
                paginationHtml += `<a href="#" class="page-link" onclick="loadApplications(${pagination.current_page + 1})">Seterus</a>`;
            } else {
                paginationHtml += `<span class="page-link disabled">Seterus</span>`;
            }

            container.innerHTML = paginationHtml;
            container.style.display = 'flex';
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

        // Filter form handling
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            currentFilters = {
                status: document.getElementById('statusFilter').value,
                search: document.getElementById('searchFilter').value
            };
            loadApplications(1);
        });

        document.getElementById('resetFilter').addEventListener('click', function() {
            document.getElementById('statusFilter').value = '';
            document.getElementById('searchFilter').value = '';
            currentFilters = {};
            loadApplications(1);
        });

        // Quick status update functions
        async function updateStatus(applicationId, newStatus) {
            if (!confirm(`Adakah anda pasti mahu mengubah status permohonan ini kepada "${getStatusDisplayName(newStatus)}"?`)) {
                return;
            }

            try {
                const response = await fetch('../api/admin/update_application_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        session_token: sessionToken,
                        application_id: applicationId,
                        new_status: newStatus,
                        remarks: ''
                    })
                });

                const data = await response.json();

                if (data.status === 200) {
                    showAlert(`Status permohonan berjaya dikemas kini kepada "${getStatusDisplayName(newStatus)}"`, 'success');
                    loadApplications(currentPage);
                } else {
                    showAlert(data.message || 'Ralat mengemas kini status', 'danger');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                showAlert('Ralat rangkaian', 'danger');
            }
        }

        // Status modal functions
        function openStatusModal(applicationId) {
            document.getElementById('modalApplicationId').value = applicationId;
            document.getElementById('modalStatus').value = '';
            document.getElementById('modalRemarks').value = '';
            document.getElementById('modalAlert').innerHTML = '';
            
            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        document.getElementById('updateStatusBtn').addEventListener('click', async function() {
            const applicationId = document.getElementById('modalApplicationId').value;
            const newStatus = document.getElementById('modalStatus').value;
            const remarks = document.getElementById('modalRemarks').value;

            if (!newStatus) {
                showModalAlert('Sila pilih status baru', 'danger');
                return;
            }

            setUpdateButtonLoading(true);

            try {
                const response = await fetch('../api/admin/update_application_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        session_token: sessionToken,
                        application_id: applicationId,
                        new_status: newStatus,
                        remarks: remarks
                    })
                });

                const data = await response.json();

                if (data.status === 200) {
                    showModalAlert(`Status permohonan berjaya dikemas kini kepada "${getStatusDisplayName(newStatus)}"`, 'success');
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
                        loadApplications(currentPage);
                    }, 1500);
                } else {
                    showModalAlert(data.message || 'Ralat mengemas kini status', 'danger');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                showModalAlert('Ralat rangkaian', 'danger');
            } finally {
                setUpdateButtonLoading(false);
            }
        });

        function setUpdateButtonLoading(loading) {
            const btn = document.getElementById('updateStatusBtn');
            const text = document.getElementById('updateBtnText');
            const spinner = document.getElementById('updateBtnSpinner');

            if (loading) {
                btn.disabled = true;
                text.style.display = 'none';
                spinner.style.display = 'inline-block';
            } else {
                btn.disabled = false;
                text.style.display = 'inline-block';
                spinner.style.display = 'none';
            }
        }

        function showModalAlert(message, type) {
            const alertContainer = document.getElementById('modalAlert');
            alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }

        function showAlert(message, type) {
            // Create a temporary alert at the top of the page
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 80px; left: 50%; transform: translateX(-50%); z-index: 1050; min-width: 300px;';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        function viewApplication(applicationId) {
            // TODO: Navigate to detailed view page
            alert(`Lihat permohonan ID: ${applicationId}`);
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