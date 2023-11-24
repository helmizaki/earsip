<!--**********************************
            Sidebar start
        ***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="<?php echo base_url() ?>assets/plugins/dashboard/images/profile/pic1.png" width="20" alt="">
                    <div class="header-info ms-3">
                        <span class="font-w600 ">Hi!! Selamat datang,<b>
                                <?php echo $this->session->userdata('fullname');
                                ?></b></span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="app-profile.html" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ms-2">Profile </span>
                    </a>
                    <a href="email-inbox.html" class="dropdown-item ai-icon">
                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span class="ms-2">Inbox </span>
                    </a>
                    <a href=" <?php echo site_url('Main/logout/') ?>" class="dropdown-item ai-icon">
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span class="ms-2">Logout </span>
                    </a>
                </div>
            </li>
            <?php
            $allowedStatus = ['Panmud Hukum', 'Panmud Gugatan', 'Panmud Permohonan'];

            if (in_array($this->session->userdata('status'), $allowedStatus)) { ?>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">ARSIP</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo site_url('Dashboard') ?>">Dashboard </a></li>
                        <li><a href="<?php echo site_url('Pinjam') ?>">Peminjaman Berkas </a></li>
                        <li><a href="<?php echo site_url('BukuNikah') ?>">Upload Buku Nikah</a></li>
                        <li><a href="<?php echo site_url('DaftarMinutasi') ?>">Daftar Validasi Minutasi</a></li>
                        <li><a href="<?php echo site_url('LapArsip') ?>">Laporan Penataan Arsip</a></li>
                        <li><a href="<?php echo site_url('LapBOX') ?>">Rekap Perkara BOX</a></li>
                    </ul>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-050-info"></i>
                        <span class="nav-text">Monitoring Berkas</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo site_url('Minutasi') ?>">Minutasi</a></li>
                        <!-- <li><a href="<?php //echo site_url('SerahMinutasi') 
                                            ?>">Penyerahan Berkas PP ke PANMUD G/P</a></li>-->
                        <li><a href="<?php echo site_url('Berkas') ?>">Lacak Berkas</a></li>
                        <li><a href="<?php echo site_url('LapMinutasi') ?>">Rekap Minutasi</a></li>


                    </ul>
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-settings"></i>

                        <span class="nav-text">Setting</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="<?php echo site_url('User') ?>">User</a></li>


                    </ul>
                <?php } ?>

        </ul>
        <div class="copyright">
            <p><strong>PENGADILAN AGAMA NGAWI</strong> © 2023 All Rights Reserved</p>
            <p class="fs-12">Made with <span class="heart"></span> by IT PA NGAWI</p>
        </div>
    </div>
</div>
<!--**********************************
            Sidebar end
        ***********************************-->