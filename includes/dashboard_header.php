<?php
// Dashboard Sidebar Header for eLesen
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
            min-height: 100vh;
            background: #f8f9fa;
        }
        .app-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            z-index: 1100;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }
        .app-header .header-logo {
            width: 38px;
            margin-right: 0.75rem;
        }
        .app-header .header-title {
            font-weight: 600;
            color: #8659cf;
            font-size: 1.25rem;
            margin-right: auto;
        }
        .sidebar-toggle {
            background: none;
            border: none;
            color: #8659cf;
            font-size: 2rem;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            z-index: 1150;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #fff;
            box-shadow: 2px 0 8px rgba(0,0,0,0.04);
            z-index: 1040;
            transition: transform 0.3s ease;
            transform: translateX(-100%);
        }
        .sidebar.show {
            transform: translateX(0);
        }
        .sidebar .sidebar-header {
            padding: 1.5rem 1rem 1rem 1rem;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .sidebar .sidebar-header img {
            width: 40px;
        }
        .sidebar .sidebar-title {
            font-weight: 600;
            color: #8659cf;
            font-size: 1.25rem;
        }
        .sidebar .nav-link {
            color: #333;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:focus, .sidebar .nav-link:hover {
            background: #f3eaff;
            color: #8659cf;
        }
        .sidebar .nav-link.text-danger {
            color: #dc3545 !important;
        }
        @media (min-width: 992px) {
            body {
                padding-left: 0 !important;
            }
        }
        @media (max-width: 991.98px) {
            .sidebar {
                width: 80vw;
                max-width: 320px;
            }
        }
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.2);
            z-index: 1039;
        }
        .sidebar.show ~ .sidebar-backdrop {
            display: block;
        }
        .main-content {
            margin-top: 60px;
        }
    </style>
</head>
<body>
<header class="app-header">
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list"></i>
    </button>
    <img src="../image/Logo-Majlis-Daerah-Pasir-Mas.png" alt="Logo" class="header-logo">
    <span class="header-title">MyLesen</span>
</header>
<aside class="sidebar" id="sidebarNav">
    <nav class="nav flex-column">
        <a class="nav-link" href="../index.php"><i class="bi bi-house-door me-2"></i> Laman Utama</a>
        <a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a class="nav-link" href="editprofile.php"><i class="bi bi-person-gear me-2"></i> Edit Profil</a>
        <a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Log Keluar</a>
    </nav>
</aside>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const sidebar = document.getElementById('sidebarNav');
const toggleBtn = document.getElementById('sidebarToggle');
const backdrop = document.getElementById('sidebarBackdrop');

function openSidebar() {
    sidebar.classList.add('show');
    backdrop.style.display = 'block';
    document.body.classList.add('sidebar-open');
}
function closeSidebar() {
    sidebar.classList.remove('show');
    backdrop.style.display = 'none';
    document.body.classList.remove('sidebar-open');
}

toggleBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    if (sidebar.classList.contains('show')) {
        closeSidebar();
    } else {
        openSidebar();
    }
});
backdrop.addEventListener('click', function() {
    closeSidebar();
});
// Close sidebar when clicking outside (on mobile)
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && sidebar.classList.contains('show')) {
        closeSidebar();
    }
});
// Always start with sidebar hidden
sidebar.classList.remove('show');
backdrop.style.display = 'none';
</script>
<div class="main-content">
<!-- Your main dashboard content starts here -->

</div>
</body>
</html> 