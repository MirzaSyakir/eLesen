<?php /* Sticky Header */ ?>
<header class="shadow-sm bg-white py-3 mb-4 sticky-top" style="z-index:1030;">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="<?php echo (strpos($_SERVER['PHP_SELF'], '/page/') !== false) ? '../image/Logo-Majlis-Daerah-Pasir-Mas.png' : 'image/Logo-Majlis-Daerah-Pasir-Mas.png'; ?>" alt="Majlis Daerah Pasir Mas Logo" style="height:60px; width:auto; margin-right:18px;">
            <span style="font-size:2rem; color:#d1d5db; margin-right:18px; user-select:none;">|</span>
            <div class="fw-bold fs-4" style="letter-spacing:0.5px; color:#8659cf;">eLesen</div>
        </div>
        <nav class="d-none d-md-flex align-items-center gap-4">
            <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/page/') !== false) ? '../index.php' : 'index.php'; ?>" class="d-flex align-items-center text-decoration-none text-dark">
                <i class="bi bi-house-door" style="color:#8659cf; font-size:1.5rem;"></i>
                <span class="ms-2">Laman Utama</span>
            </a>
            <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/page/') !== false) ? 'login.php' : 'page/login.php'; ?>" class="d-flex align-items-center text-decoration-none text-dark">
                <i class="bi bi-person" style="color:#8659cf; font-size:1.5rem;"></i>
                <span class="ms-2">Log Masuk</span>
            </a>
            <a href="<?php echo (strpos($_SERVER['PHP_SELF'], '/page/') !== false) ? 'signup.php' : 'page/signup.php'; ?>" class="d-flex align-items-center text-decoration-none text-dark">
                <i class="bi bi-person-plus" style="color:#8659cf; font-size:1.5rem;"></i>
                <span class="ms-2">Daftar Akaun</span>
            </a>
        </nav>
    </div>
</header>
