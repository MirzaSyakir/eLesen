<?php 
session_start();
include '../includes/dashboard_header.php'; 
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #f8f9fa;
        }
        .dashboard-container {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
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
        .user-avatar {
            background: #8659cf1a;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #8659cf;
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
            background: #8659cf1a;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #8659cf;
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
            background: #8659cf1a;
            border-color: #8659cf;
            color: #8659cf;
            transform: translateY(-2px);
        }
        .action-icon {
            font-size: 2rem;
            color: #8659cf;
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
            background: #8659cf;
            border-color: #8659cf;
            font-weight: 500;
            border-radius: 0.6rem;
        }
        .btn-primary:hover {
            background: #7a4fc7;
            border-color: #7a4fc7;
        }
        .btn-outline-primary {
            color: #8659cf;
            border-color: #8659cf;
            border-radius: 0.6rem;
        }
        .btn-outline-primary:hover {
            background: #8659cf;
            border-color: #8659cf;
        }
        .profile-section {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .profile-info h6 {
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        .profile-info p {
            color: #333;
            font-weight: 500;
            margin-bottom: 1rem;
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
        @media (max-width: 768px) {
            .welcome-section {
                flex-direction: column;
                text-align: center;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .action-grid {
                grid-template-columns: 1fr;
            }
            .profile-grid {
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
            <p class="mt-3">Memuatkan dashboard...</p>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div id="dashboardContent" style="display: none;">
        <div class="dashboard-container">
            <div class="container">
                <!-- Dashboard Header -->
                <div class="dashboard-header">
                    <div class="welcome-section">
                        <div class="user-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="welcome-text">
                            <h1 id="welcomeName">Selamat Datang!</h1>
                            <p id="welcomeIC">Memuatkan maklumat pengguna...</p>
                        </div>
                        <div class="ms-auto">
                            <a href="logout.php" class="btn btn-outline-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Log Keluar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="stat-number">3</div>
                        <div class="stat-label">Permohonan Aktif</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stat-number">2</div>
                        <div class="stat-label">Lesen Diluluskan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="stat-number">1</div>
                        <div class="stat-label">Dalam Proses</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="stat-number">0</div>
                        <div class="stat-label">Tamat Tempoh</div>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="profile-section">
                    <div class="section-title">
                        <i class="bi bi-person-circle"></i>
                        Maklumat Peribadi
                    </div>
                    <div class="profile-grid">
                        <div>
                            <div class="profile-info">
                                <h6>Nama Penuh</h6>
                                <p id="userFullName">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Nombor IC</h6>
                                <p id="userIC">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Warna Kad Pengenalan</h6>
                                <p id="userWarnaKad">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Tarikh Lahir</h6>
                                <p id="userTarikhLahir">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Umur</h6>
                                <p id="userUmur">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Nombor Telefon</h6>
                                <p id="userPhone">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Alamat E-mel</h6>
                                <p id="userEmail">-</p>
                            </div>
                        </div>
                        <div>
                            <div class="profile-info">
                                <h6>Alamat</h6>
                                <p id="userAddress">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Bandar & Negeri</h6>
                                <p id="userCityState">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Poskod</h6>
                                <p id="userPostcode">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Agama</h6>
                                <p id="userAgama">-</p>
                            </div>
                            <div class="profile-info">
                                <h6>Tarikh Daftar</h6>
                                <p id="userCreatedAt">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="editprofile.php" class="btn btn-outline-primary">
                            <i class="bi bi-pencil me-2"></i>
                            Kemas Kini Profil
                        </a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="section-title">
                        <i class="bi bi-lightning"></i>
                        Tindakan Pantas
                    </div>
                    <div class="action-grid">
                        <a href="permohonan.php" class="action-card">
                            <div class="action-icon">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="action-title">Mohon Lesen Baru</div>
                            <div class="action-desc">Buat permohonan lesen perniagaan baharu</div>
                        </a>
                        <a href="applications.php" class="action-card">
                            <div class="action-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="action-title">Permohonan Saya</div>
                            <div class="action-desc">Lihat status semua permohonan</div>
                        </a>
                        <a href="my-licenses.php" class="action-card">
                            <div class="action-icon">
                                <i class="bi bi-card-checklist"></i>
                            </div>
                            <div class="action-title">Lesen Saya</div>
                            <div class="action-desc">Senarai lesen yang telah diluluskan</div>
                        </a>
                        <a href="payments.php" class="action-card">
                            <div class="action-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="action-title">Bayaran</div>
                            <div class="action-desc">Sejarah dan status bayaran</div>
                        </a>
                        <a href="documents.php" class="action-card">
                            <div class="action-icon">
                                <i class="bi bi-folder"></i>
                            </div>
                            <div class="action-title">Dokumen</div>
                            <div class="action-desc">Muat naik dan urus dokumen</div>
                        </a>
                        <a href="support.php" class="action-card">
                            <div class="action-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div class="action-title">Bantuan</div>
                            <div class="action-desc">Hubungi sokongan teknikal</div>
                        </a>
                    </div>
                </div>

                <!-- Recent Applications -->
                <div class="recent-applications">
                    <div class="section-title">
                        <i class="bi bi-clock-history"></i>
                        Permohonan Terkini
                    </div>
                    <div class="application-item">
                        <div class="application-info">
                            <h5>Lesen Perniagaan Premis Tetap</h5>
                            <p>No. Permohonan: LPT-2024-001 | Tarikh: 15/01/2024</p>
                        </div>
                        <span class="status-badge status-processing">Dalam Proses</span>
                    </div>
                    <div class="application-item">
                        <div class="application-info">
                            <h5>Lesen Penjaja</h5>
                            <p>No. Permohonan: LPJ-2024-002 | Tarikh: 10/01/2024</p>
                        </div>
                        <span class="status-badge status-approved">Diluluskan</span>
                    </div>
                    <div class="application-item">
                        <div class="application-info">
                            <h5>Permit Sementara</h5>
                            <p>No. Permohonan: PS-2024-003 | Tarikh: 05/01/2024</p>
                        </div>
                        <span class="status-badge status-pending">Menunggu Semakan</span>
                    </div>
                    <div class="text-center mt-3">
                        <a href="applications.php" class="btn btn-primary">
                            Lihat Semua Permohonan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in
            const sessionToken = localStorage.getItem('sessionToken');
            const userData = localStorage.getItem('userData');
            const sessionExpires = localStorage.getItem('sessionExpires');
            
            if (!sessionToken || !userData || !sessionExpires) {
                // No session data, redirect to login
                window.location.href = 'login.php';
                return;
            }
            
            // Check if session has expired
            if (new Date(sessionExpires) < new Date()) {
                // Session expired, clear data and redirect to login
                localStorage.removeItem('sessionToken');
                localStorage.removeItem('userData');
                localStorage.removeItem('sessionExpires');
                window.location.href = 'login.php';
                return;
            }
            
            // Validate session with API
            validateSession(sessionToken);
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
                    // Session is valid, update user data and show dashboard
                    const user = data.data.user;
                    updateDashboard(user);
                    showDashboard();
                } else {
                    // Session invalid, redirect to login
                    localStorage.removeItem('sessionToken');
                    localStorage.removeItem('userData');
                    localStorage.removeItem('sessionExpires');
                    window.location.href = 'login.php';
                }
                
            } catch (error) {
                console.error('Session validation error:', error);
                // Network error, try to use cached data
                const userData = localStorage.getItem('userData');
                if (userData) {
                    try {
                        const user = JSON.parse(userData);
                        updateDashboard(user);
                        showDashboard();
                    } catch (e) {
                        window.location.href = 'login.php';
                    }
                } else {
                    window.location.href = 'login.php';
                }
            }
        }
        
        function updateDashboard(user) {
            // Update welcome section
            document.getElementById('welcomeName').textContent = `Selamat Datang, ${user.full_name}!`;
            document.getElementById('welcomeIC').textContent = `IC: ${user.ic_number} | Akaun Aktif`;
            
            // Update profile information
            document.getElementById('userFullName').textContent = user.full_name;
            document.getElementById('userIC').textContent = user.ic_number;
            document.getElementById('userWarnaKad').textContent = user.warna_kad_pengenalan || '-';
            document.getElementById('userTarikhLahir').textContent = user.tarikh_lahir || '-';
            document.getElementById('userUmur').textContent = user.umur || '-';
            document.getElementById('userPhone').textContent = user.phone;
            document.getElementById('userEmail').textContent = user.email || 'Tiada e-mel';
            document.getElementById('userAddress').textContent = user.address;
            document.getElementById('userCityState').textContent = `${user.city}, ${user.state}`;
            document.getElementById('userPostcode').textContent = user.postcode;
            document.getElementById('userAgama').textContent = user.agama || '-';
            document.getElementById('userCreatedAt').textContent = formatDate(user.created_at);
        }
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('ms-MY');
        }
        
        function showDashboard() {
            document.getElementById('loadingScreen').style.display = 'none';
            document.getElementById('dashboardContent').style.display = 'block';
        }
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?> 