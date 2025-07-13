<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .dashboard-header {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .welcome-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .admin-avatar-large {
            background: #dc35451a;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #dc3545;
        }
        .welcome-text h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .welcome-text p {
            color: #6c757d;
            margin-bottom: 0;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 1.5rem;
            text-align: center;
        }
        .stat-icon {
            background: #dc35451a;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #dc3545;
            margin: 0 auto 1rem auto;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .quick-actions {
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
        }
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        .action-card {
            background: #f8f9fa;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .action-card:hover {
            background: #dc35451a;
            border-color: #dc3545;
            color: #dc3545;
            transform: translateY(-2px);
        }
        .action-icon {
            font-size: 2rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
        .action-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .action-desc {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .charts-section {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .chart-container {
            height: 300px;
            margin-top: 1rem;
        }
        .recent-applications {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
        }
        .application-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f1f1;
        }
        .application-item:last-child {
            border-bottom: none;
        }
        .application-info h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .application-info p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
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
        .status-approved {
            background: #d1edff;
            color: #0c5460;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        .status-processing {
            background: #e2e3e5;
            color: #383d41;
        }
        .btn-primary {
            background: #dc3545;
            border-color: #dc3545;
            font-weight: 500;
            border-radius: 0.6rem;
        }
        .btn-primary:hover {
            background: #c82333;
            border-color: #c82333;
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

    <div class="dashboard-container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="welcome-section">
                <div class="admin-avatar-large">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div class="welcome-text">
                    <h1 id="welcomeText">Selamat Datang, Admin</h1>
                    <p>Panel pentadbir sistem eLesen</p>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid" id="statsGrid">
            <div class="loading">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuatkan statistik...</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2 class="section-title">
                <i class="bi bi-lightning"></i>
                Tindakan Pantas
            </h2>
            <div class="action-grid">
                <a href="#" class="action-card" id="viewApplicationsBtn">
                    <div class="action-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="action-title">Lihat Permohonan</div>
                    <div class="action-desc">Semak dan uruskan permohonan lesen</div>
                </a>
                <a href="#" class="action-card" id="manageUsersBtn">
                    <div class="action-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="action-title">Urus Pengguna</div>
                    <div class="action-desc">Kelola akaun pengguna sistem</div>
                </a>
                <a href="#" class="action-card" id="reportsBtn">
                    <div class="action-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="action-title">Laporan</div>
                    <div class="action-desc">Jana laporan dan statistik</div>
                </a>
                <a href="#" class="action-card" id="settingsBtn">
                    <div class="action-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="action-title">Tetapan</div>
                    <div class="action-desc">Konfigurasi sistem</div>
                </a>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <h2 class="section-title">
                <i class="bi bi-bar-chart"></i>
                Statistik Permohonan
            </h2>
            <div class="row">
                <div class="col-md-6">
                    <h5>Status Permohonan</h5>
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Permohonan Bulanan</h5>
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="recent-applications">
            <h2 class="section-title">
                <i class="bi bi-clock-history"></i>
                Permohonan Terkini
            </h2>
            <div id="recentApplications">
                <div class="loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuatkan permohonan terkini...</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let adminData = null;
        let sessionToken = null;

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
                loadDashboardData();
            } catch (error) {
                console.error('Session validation error:', error);
                window.location.href = 'admin_login.php';
            }
        }

        function updateAdminInfo() {
            document.getElementById('adminName').textContent = adminData.full_name;
            document.getElementById('adminRole').textContent = getRoleDisplayName(adminData.role);
            document.getElementById('welcomeText').textContent = `Selamat Datang, ${adminData.full_name}`;
        }

        function getRoleDisplayName(role) {
            const roleNames = {
                'super_admin': 'Super Admin',
                'admin': 'Admin',
                'officer': 'Pegawai'
            };
            return roleNames[role] || role;
        }

        async function loadDashboardData() {
            try {
                const response = await fetch('../api/admin/dashboard_stats.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        session_token: sessionToken
                    })
                });

                const data = await response.json();

                if (data.status === 200) {
                    updateStats(data.data);
                    updateRecentApplications(data.data.recent_applications);
                    createCharts(data.data);
                } else {
                    console.error('Failed to load dashboard data:', data.message);
                }
            } catch (error) {
                console.error('Error loading dashboard data:', error);
            }
        }

        function updateStats(stats) {
            const statsGrid = document.getElementById('statsGrid');
            statsGrid.innerHTML = `
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="stat-number">${stats.total_applications}</div>
                    <div class="stat-label">Jumlah Permohonan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="stat-number">${stats.pending_applications}</div>
                    <div class="stat-label">Menunggu</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="stat-number">${stats.processing_applications}</div>
                    <div class="stat-label">Dalam Proses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-number">${stats.approved_applications}</div>
                    <div class="stat-label">Diluluskan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div class="stat-number">${stats.rejected_applications}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-number">${stats.total_users}</div>
                    <div class="stat-label">Jumlah Pengguna</div>
                </div>
            `;
        }

        function updateRecentApplications(applications) {
            const container = document.getElementById('recentApplications');
            
            if (applications.length === 0) {
                container.innerHTML = '<p class="text-muted text-center">Tiada permohonan terkini</p>';
                return;
            }

            container.innerHTML = applications.map(app => `
                <div class="application-item">
                    <div class="application-info">
                        <h5>${app.application_number}</h5>
                        <p>${app.business_name} - ${app.license_type}</p>
                        <small>Pemohon: ${app.applicant_name}</small>
                    </div>
                    <div>
                        <span class="status-badge status-${app.status}">${getStatusDisplayName(app.status)}</span>
                    </div>
                </div>
            `).join('');
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

        function createCharts(data) {
            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: data.applications_by_status.map(item => getStatusDisplayName(item.status)),
                    datasets: [{
                        data: data.applications_by_status.map(item => item.count),
                        backgroundColor: ['#ffc107', '#6c757d', '#28a745', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Monthly Chart
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: data.applications_by_month.map(item => formatMonth(item.month)),
                    datasets: [{
                        label: 'Jumlah Permohonan',
                        data: data.applications_by_month.map(item => item.count),
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function formatMonth(monthStr) {
            const [year, month] = monthStr.split('-');
            const date = new Date(year, month - 1);
            return date.toLocaleDateString('ms-MY', { month: 'short', year: 'numeric' });
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

        // Quick action buttons
        document.getElementById('viewApplicationsBtn').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'admin_applications.php';
        });

        document.getElementById('manageUsersBtn').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'admin_users.php';
        });

        document.getElementById('reportsBtn').addEventListener('click', function(e) {
            e.preventDefault();
            // TODO: Navigate to reports page
            alert('Halaman laporan akan dibuka');
        });

        document.getElementById('settingsBtn').addEventListener('click', function(e) {
            e.preventDefault();
            // TODO: Navigate to settings page
            alert('Halaman tetapan akan dibuka');
        });
    </script>
</body>
</html> 