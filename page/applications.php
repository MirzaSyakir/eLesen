<?php 
session_start();
include '../includes/dashboard_header.php'; 
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Permohonan - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            background: #f8f9fa;
        }
        .applications-container {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        .applications-header {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .application-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        .application-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-draft {
            background: #fff3cd;
            color: #856404;
        }
        .status-submit {
            background: #d1edff;
            color: #0c5460;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-processing {
            background: #cce5ff;
            color: #004085;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
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
        .application-info {
            margin-bottom: 1rem;
        }
        .application-number {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }
        .application-type {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .application-date {
            color: #6c757d;
            font-size: 0.85rem;
        }
        .application-business {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .application-address {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            color: #6c757d;
        }
        .empty-state .empty-icon {
            font-size: 3rem;
            color: #d1d1e0;
            margin-bottom: 1rem;
        }
        .empty-state .empty-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        .empty-state .empty-desc {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        .empty-state .btn-purple {
            background: #8659cf;
            color: #fff;
            border: none;
            border-radius: 2.5rem;
            padding: 0.5rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(134,89,207,0.08);
            transition: background 0.2s;
        }
        .empty-state .btn-purple:hover {
            background: #7a4fc7;
            color: #fff;
        }
        .empty-state .empty-btn-icon {
            font-size: 1.5rem;
        }
        .filter-tabs {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #f1f1f1;
            padding: 1rem;
            margin-bottom: 2rem;
        }
        .nav-tabs {
            border-bottom: none;
        }
        .nav-tabs .nav-link {
            border: none;
            border-radius: 0.6rem;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
        }
        .nav-tabs .nav-link.active {
            background: #8659cf;
            color: #fff;
        }
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            background: #f8f9fa;
        }
        .nav-tabs .nav-link.active:hover {
            background: #7a4fc7;
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
            .applications-container {
                padding: 1rem 0;
            }
            .applications-header {
                padding: 1.5rem;
            }
            .application-card {
                padding: 1rem;
            }
        }
        .btn-purple {
            background: #8659cf !important;
            color: #fff !important;
            border: none !important;
            border-radius: 2.5rem !important;
            padding: 0.5rem 1.5rem !important;
            font-size: 1.1rem !important;
            font-weight: 500 !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(134,89,207,0.08);
            transition: background 0.2s;
        }
        .btn-purple:hover, .btn-purple:focus {
            background: #7a4fc7 !important;
            color: #fff !important;
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
            <p class="mt-3">Memuatkan senarai permohonan...</p>
        </div>
    </div>

    <!-- Applications Content -->
    <div id="applicationsContent" style="display: none;">
        <div class="applications-container">
            <div class="container">
                <!-- Applications Header -->
                <div class="applications-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-2">Senarai Permohonan</h1>
                            <p class="text-muted mb-0">Uruskan permohonan lesen anda</p>
                        </div>
                        <div>
                            <a href="permohonan.php" class="btn btn-purple">
                                <i class="bi bi-plus"></i> Permohonan Baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="filter-tabs">
                    <ul class="nav nav-tabs" id="filterTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                                <i class="bi bi-list-ul me-2"></i>Semua
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft" type="button" role="tab">
                                <i class="bi bi-file-earmark me-2"></i>Draft
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="submitted-tab" data-bs-toggle="tab" data-bs-target="#submitted" type="button" role="tab">
                                <i class="bi bi-send me-2"></i>Diserahkan
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="filterTabContent">
                    <!-- All Applications -->
                    <div class="tab-pane fade show active" id="all" role="tabpanel">
                        <div id="allApplications">
                            <!-- Applications will be loaded here -->
                        </div>
                    </div>

                    <!-- Draft Applications -->
                    <div class="tab-pane fade" id="draft" role="tabpanel">
                        <div id="draftApplications">
                            <!-- Draft applications will be loaded here -->
                        </div>
                    </div>

                    <!-- Submitted Applications -->
                    <div class="tab-pane fade" id="submitted" role="tabpanel">
                        <div id="submittedApplications">
                            <!-- Submitted applications will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let applications = [];
        
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
            
            loadApplications();
        });
        
        async function loadApplications() {
            try {
                const response = await fetch('../api/permohonan/list.php', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('sessionToken')}`
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    applications = (data.data && data.data.applications) ? data.data.applications : [];
                    displayApplications();
                    showApplications();
                } else {
                    alert('Ralat: ' + (data.message || 'Gagal memuatkan senarai permohonan'));
                }
                
            } catch (error) {
                console.error('Load applications error:', error);
                alert('Ralat rangkaian: Gagal memuatkan senarai permohonan');
            }
        }
        
        function displayApplications() {
            const allContainer = document.getElementById('allApplications');
            const draftContainer = document.getElementById('draftApplications');
            const submittedContainer = document.getElementById('submittedApplications');
            
            // Clear containers
            allContainer.innerHTML = '';
            draftContainer.innerHTML = '';
            submittedContainer.innerHTML = '';
            
            if (applications.length === 0) {
                allContainer.innerHTML = createEmptyState();
                draftContainer.innerHTML = createEmptyState();
                submittedContainer.innerHTML = createEmptyState();
                return;
            }
            
            applications.forEach(application => {
                const applicationCard = createApplicationCard(application);
                allContainer.appendChild(applicationCard);
                
                if (application.status_borang === 'draft') {
                    draftContainer.appendChild(applicationCard.cloneNode(true));
                } else {
                    submittedContainer.appendChild(applicationCard.cloneNode(true));
                }
            });
        }
        
        function createApplicationCard(application) {
            const card = document.createElement('div');
            card.className = 'application-card';
            
            const statusClass = getStatusClass(application.status_borang, application.status);
            const statusText = getStatusText(application.status_borang, application.status);
            const actionButtons = getActionButtons(application);
            
            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="application-info">
                        <div class="application-number">${application.application_number}</div>
                        <div class="application-type">${application.license_type}</div>
                        <div class="application-date">Dicipta pada: ${formatDate(application.created_at)}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </div>
                </div>
                
                <div class="application-business">${application.business_name || 'Nama Perniagaan tidak dinyatakan'}</div>
                <div class="application-address">${application.business_address || 'Alamat tidak dinyatakan'}</div>
                
                <div class="d-flex justify-content-end gap-2 mt-3">
                    ${actionButtons}
                </div>
            `;
            
            // Add event listeners to buttons
            const buttons = card.querySelectorAll('button');
            buttons.forEach(button => {
                if (button.onclick) {
                    const onclick = button.onclick;
                    button.onclick = null;
                    button.addEventListener('click', onclick);
                }
            });
            
            return card;
        }
        
        function getStatusClass(statusBorang, status) {
            if (statusBorang === 'draft') return 'status-draft';
            if (status === 'pending') return 'status-pending';
            if (status === 'processing') return 'status-processing';
            if (status === 'approved') return 'status-approved';
            if (status === 'rejected') return 'status-rejected';
            return 'status-submit';
        }
        
        function getStatusText(statusBorang, status) {
            if (statusBorang === 'draft') return 'Draft';
            if (status === 'pending') return 'Menunggu';
            if (status === 'processing') return 'Diproses';
            if (status === 'approved') return 'Diluluskan';
            if (status === 'rejected') return 'Ditolak';
            return 'Diserahkan';
        }
        
        function getActionButtons(application) {
            let buttons = '';
            
            if (application.status_borang === 'draft') {
                buttons += `
                    <button class="btn btn-sm btn-outline-primary" onclick="editApplication('${application.application_number}')">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteApplication('${application.application_number}')">
                        <i class="bi bi-trash me-1"></i>Padam
                    </button>
                `;
            } else {
                buttons += `
                    <button class="btn btn-sm btn-outline-primary" onclick="viewApplication('${application.application_number}')">
                        <i class="bi bi-eye me-1"></i>Lihat
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteApplication('${application.application_number}')">
                        <i class="bi bi-trash me-1"></i>Padam
                    </button>
                `;
            }
            
            return buttons;
        }
        
        function createEmptyState() {
            return `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="empty-title">Tiada permohonan dijumpai</div>
                    <div class="empty-desc">Tiada permohonan untuk ditunjukkan pada masa ini.</div>
                    <a href="permohonan.php" class="btn btn-purple">
                        <span class="empty-btn-icon"><i class="bi bi-plus"></i></span>
                        Buat Permohonan Baru
                    </a>
                </div>
            `;
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
        
        function showApplications() {
            document.getElementById('loadingScreen').style.display = 'none';
            document.getElementById('applicationsContent').style.display = 'block';
        }
        
        function editApplication(applicationNumber) {
            window.location.href = `permohonan.php?edit=${applicationNumber}`;
        }
        
        function viewApplication(applicationNumber) {
            window.location.href = `view_application.php?number=${applicationNumber}`;
        }
        
        async function deleteApplication(applicationNumber) {
            if (!confirm('Adakah anda pasti untuk memadamkan permohonan ini? Tindakan ini tidak boleh dibatalkan.')) {
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
                        application_number: applicationNumber
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert('Permohonan berjaya dipadamkan!');
                    loadApplications(); // Reload the list
                } else {
                    alert('Ralat: ' + (data.message || 'Gagal memadamkan permohonan'));
                }
            } catch (error) {
                console.error('Delete application error:', error);
                alert('Ralat rangkaian: Gagal memadamkan permohonan');
            }
        }
    </script>
</body>
</html>
<?php include '../includes/footer.php'; ?> 