<?php
session_start();
include '../includes/dashboard_header.php'; 
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butiran Permohonan - eLesen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', system-ui, Arial, sans-serif; background: #f8f9fa; }
        .details-container { min-height: calc(100vh - 200px); padding: 2rem 0; }
        .details-card { background: #fff; border-radius: 1.25rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #f1f1f1; padding: 2rem; margin-bottom: 2rem; }
        .section-title { font-size: 1.3rem; font-weight: 600; color: #333; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid #8659cf; }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.9rem; font-weight: 500; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-draft { background: #fff3cd; color: #856404; }
        .details-label { font-weight: 600; color: #333; }
        .details-value { color: #444; margin-bottom: 1rem; }
        .back-btn { margin-bottom: 2rem; }
        @media (max-width: 768px) { .details-container { padding: 1rem 0; } .details-card { padding: 1.2rem; } }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container details-container">
        <a href="applications.php" class="btn btn-outline-secondary back-btn"><i class="bi bi-arrow-left me-2"></i>Kembali ke Senarai Permohonan</a>
        <div id="loadingScreen" class="text-center" style="min-height:200px;">
            <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
            <p class="mt-3">Memuatkan butiran permohonan...</p>
        </div>
        <div id="detailsContent" style="display:none;"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
        const urlParams = new URLSearchParams(window.location.search);
        const applicationNumber = urlParams.get('number');
        if (!applicationNumber) {
            document.getElementById('loadingScreen').innerHTML = '<div class="alert alert-danger">Nombor permohonan tidak sah.</div>';
            return;
        }
        fetchDetails(applicationNumber);
    });
    function getStatusBadge(status) {
        if (status === 'approved') return '<span class="status-badge status-approved">Diluluskan</span>';
        if (status === 'pending') return '<span class="status-badge status-pending">Menunggu</span>';
        if (status === 'rejected') return '<span class="status-badge status-rejected">Ditolak</span>';
        if (status === 'processing') return '<span class="status-badge status-processing">Dalam Proses</span>';
        if (status === 'draft') return '<span class="status-badge status-draft">Draft</span>';
        return '<span class="status-badge">' + (status || '-') + '</span>';
    }
    function fetchDetails(applicationNumber) {
        fetch(`../api/permohonan/view.php?application_number=${encodeURIComponent(applicationNumber)}`, {
            method: 'GET',
            headers: { 'Authorization': `Bearer ${localStorage.getItem('sessionToken')}` }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('loadingScreen').style.display = 'none';
            if (data.status === 200 && data.data && data.data.application) {
                const app = data.data.application;
                let html = `<div class='details-card'>
                    <div class='section-title'><i class='bi bi-file-earmark-text'></i> Butiran Permohonan</div>
                    <div class='mb-3'><span class='details-label'>No. Permohonan:</span> <span class='details-value'>${app.application_number || '-'}</span></div>
                    <div class='mb-3'><span class='details-label'>Jenis Lesen:</span> <span class='details-value'>${app.license_type || '-'}</span></div>
                    <div class='mb-3'><span class='details-label'>Nama Perniagaan:</span> <span class='details-value'>${app.business_name || '-'}</span></div>
                    <div class='mb-3'><span class='details-label'>Alamat Perniagaan:</span> <span class='details-value'>${app.business_address || '-'}</span></div>
                    <div class='mb-3'><span class='details-label'>No. SSM:</span> <span class='details-value'>${app.no_ssm || '-'}</span></div>
                    <div class='mb-3'><span class='details-label'>Status:</span> ${getStatusBadge(app.status)}</div>
                    <div class='mb-3'><span class='details-label'>Tarikh Permohonan:</span> <span class='details-value'>${formatDate(app.created_at)}</span></div>
                    <div class='mb-3'><span class='details-label'>Tarikh Kemaskini:</span> <span class='details-value'>${formatDate(app.updated_at)}</span></div>
                </div>`;
                // Add document section
                const docFields = [
                    { key: 'ssm_file', label: 'Salinan SSM' },
                    { key: 'plan_file', label: 'Pelan Premis' },
                    { key: 'ic_file', label: 'Salinan IC' },
                    { key: 'receipt_file', label: 'Resit Bayaran' },
                    { key: 'tax_file', label: 'Cukai Taksiran' },
                    { key: 'signboard_file', label: 'Gambar Papan Tanda' },
                    { key: 'health_file', label: 'Laporan Kesihatan' },
                    { key: 'land_file', label: 'Dokumen Tanah' },
                    { key: 'owner_file', label: 'Surat Pemilik Premis' },
                    { key: 'halal_file', label: 'Sijil Halal' }
                ];
                let docsHtml = `<div class='details-card'><div class='section-title'><i class='bi bi-paperclip'></i> Dokumen Dimuat Naik</div>`;
                let hasDoc = false;
                docsHtml += `<ul class='list-group mb-0'>`;
                docFields.forEach(doc => {
                    if (app[doc.key]) {
                        hasDoc = true;
                        const fileName = app[doc.key].split('/').pop();
                        docsHtml += `<li class='list-group-item d-flex justify-content-between align-items-center'>
                            <span><i class='bi bi-file-earmark'></i> ${doc.label}</span>
                            <a href='../${app[doc.key]}' target='_blank' class='btn btn-sm btn-outline-primary'><i class='bi bi-eye'></i> Lihat</a>
                        </li>`;
                    }
                });
                docsHtml += `</ul>`;
                if (!hasDoc) {
                    docsHtml += `<div class='text-muted mt-2'>Tiada dokumen dimuat naik.</div>`;
                }
                docsHtml += `</div>`;
                html += docsHtml;
                document.getElementById('detailsContent').innerHTML = html;
                document.getElementById('detailsContent').style.display = 'block';
            } else {
                document.getElementById('detailsContent').innerHTML = `<div class='alert alert-danger'>${data.message || 'Permohonan tidak dijumpai.'}</div>`;
                document.getElementById('detailsContent').style.display = 'block';
            }
        })
        .catch(() => {
            document.getElementById('loadingScreen').style.display = 'none';
            document.getElementById('detailsContent').innerHTML = `<div class='alert alert-danger'>Ralat rangkaian. Sila cuba lagi.</div>`;
            document.getElementById('detailsContent').style.display = 'block';
        });
    }
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleString('ms-MY', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });
    }
    </script>
<?php include '../includes/footer.php'; ?> 