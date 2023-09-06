<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/book.png">
    <title>
        <?= $title; ?>
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
</head>

<body class="white-content">
    <div class="wrapper">
        <!-- Side Bar-->
        <?= $this->include('template/sidebarhome'); ?>
        <!-- End Side Bar-->
        <div class="main-panel">
            <!-- Topbar -->
            <?= $this->include('template/topbarhome'); ?>
            <!-- End Topbar -->
            <!-- Content Wrapper -->
            <div class="content">
                <!-- Begin Page Content -->
                <?= $this->renderSection('page-content'); ?>
                <!-- /.container-fluid -->
            </div>
            <!-- Footer-->
            <?= $this->include('template/footerhome'); ?>
            <!-- End Footer -->
        </div>
        <!-- End of Main Pannel -->
    </div>
    <!-- End of Content Wrapper -->
    <!-- Setting -->
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Background</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <div class="badge-colors text-center">
                            <span class="badge filter badge-primary" data-color="primary"></span>
                            <span class="badge filter badge-info active" data-color="blue"></span>
                            <span class="badge filter badge-success" data-color="green"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line text-center color-change">
                    <span class="color-label">LIGHT MODE</span>
                    <span class="badge light-badge mr-2"></span>
                    <span class="badge dark-badge ml-2"></span>
                    <span class="color-label">DARK MODE</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- End Setting -->
    <!--   Core JS Files   -->
    <script src="/js/core/jquery.min.js"></script>
    <script src="/js/core/popper.min.js"></script>
    <script src="/js/core/bootstrap.min.js"></script>
    <script src="/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <!--  Notifications Plugin    -->
    <script src="/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
    <script src="/demo/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('.info-button').click(function() {
                var transaksi = $(this).data('status');
                $('#tgl_pinjam').text('Tanggal Pinjam: ' + transaksi.tgl_pinjam);
                $('#tgl_kembali').text('Tanggal Kembali: ' + transaksi.tgl_kembali);

                // Menghitung selisih hari antara tanggal kembali dengan tanggal sekarang
                var tglKembali = new Date(transaksi.tgl_kembali);
                var tglSekarang = new Date();
                var selisih = Math.max(0, Math.floor((tglSekarang - tglKembali) / (1000 * 60 * 60 * 24))); // mengubah ke bilangan bulat

                $('#jumlah_hari_telat').text('Jumlah Hari Telat: ' + selisih + ' hari');

                var dendaPerHari = 500;
                var totalDenda = dendaPerHari * selisih;
                $('#total_denda').text('Total Denda: Rp ' + totalDenda.toLocaleString());
            });
        });
    </script>
    <div class="modal fade" id="infoDendaModal" tabindex="-1" aria-labelledby="infoDendaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoDendaModalLabel">Informasi Denda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Denda dihitung berdasarkan telat mengembalikan buku, selama perhari denda yang berlaku adalah Rp. 500.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="infoModalLabel">Informasi Denda</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="tgl_pinjam"></p>
                    <p id="tgl_kembali"></p>
                    <p id="jumlah_hari_telat"></p>
                    <p>Denda Perhari: Rp 500</p>
                    <p id="total_denda"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $().ready(function() {
                $sidebar = $('.sidebar');
                $navbar = $('.navbar');
                $main_panel = $('.main-panel');

                $full_page = $('.full-page');

                $sidebar_responsive = $('body > .navbar-collapse');
                sidebar_mini_active = true;
                white_color = false;

                window_width = $(window).width();

                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



                $('.fixed-plugin a').click(function(event) {
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .background-color span').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data', new_color);
                    }

                    if ($main_panel.length != 0) {
                        $main_panel.attr('data', new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data', new_color);
                    }
                });

                $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
                    var $btn = $(this);

                    if (sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        sidebar_mini_active = false;
                        blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
                    } else {
                        $('body').addClass('sidebar-mini');
                        sidebar_mini_active = true;
                        blackDashboard.showSidebarMessage('Sidebar mini activated...');
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);
                });

                $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
                    var $btn = $(this);

                    if (white_color == true) {

                        $('body').addClass('change-background');
                        setTimeout(function() {
                            $('body').removeClass('change-background');
                            $('body').removeClass('white-content');
                        }, 900);
                        white_color = false;
                    } else {

                        $('body').addClass('change-background');
                        setTimeout(function() {
                            $('body').removeClass('change-background');
                            $('body').addClass('white-content');
                        }, 900);

                        white_color = true;
                    }


                });

                $('.light-badge').click(function() {
                    $('body').addClass('white-content');
                });

                $('.dark-badge').click(function() {
                    $('body').removeClass('white-content');
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            demo.initDashboardPageCharts();

        });
    </script>
    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
    <script>
        window.TrackJS &&
            TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "black-dashboard-free"
            });
    </script>

    <!-- java script fitur import excel,autofill transaksi dan preview gambar -->
    <script>
        const form = document.getElementById('import-form');
        const input = document.getElementById('import_file');
        input.addEventListener('change', () => {
            form.submit();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#isbn').change(function() {
                $.ajax({
                    url: '<?php echo base_url("pinjamkembali/getBukuByIsbn"); ?>/' + $(this).val(),
                    dataType: 'json',
                    success: function(data) {
                        $('#judul').val(data.judul);
                        $('#jumlah').val(data.jumlah);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#nomor').change(function() {
                $.ajax({
                    url: '<?php echo base_url("pinjamkembali/getAnggotaByNomor"); ?>/' + $(this).val(),
                    dataType: 'json',
                    success: function(data) {
                        $('#nama').val(data.nama);
                        $('#kelas').val(data.kelas);
                    }
                });
            });
        });
    </script>

    <!--Mengatur Preview IMG -->
    <script>
        function previewGambar() {
            const gambar = document.querySelector('#gambar');
            const gambarLabel = document.querySelector('.input-group-text');
            const imgPreview = document.querySelector('.img-preview');

            gambarLabel.textContent = gambar.files[0].name;

            const fileGambar = new FileReader();
            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>
    <script>
        function previewFoto() {

            const foto = document.querySelector('#foto');
            const fotoLabel = document.querySelector('.input-group-text');
            const imgPreview = document.querySelector('.img-preview');

            fotoLabel.textContent = foto.files[0].name;

            const fileFoto = new FileReader();
            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>
    <script>
        function showDetails() {
            var judulBuku = document.getElementById('judulBuku');
            judulBuku.classList.remove('hidden');
        }
    </script>
    <script>
        function toggleDetails() {
            //definisikan tiap tiap variabel
            var qrCode = document.getElementById('qrCode');
            var toggleButton = document.getElementById('toggleButton');
            var bookInfo = document.getElementById('bookInfo');
            var jumlahPeminjaman = document.getElementById('jumlahPeminjaman');
            var jumlahStok = document.getElementById('jumlahStok');
            var lokasi = document.getElementById('lokasi');
            var daftarPeminjam = document.getElementById('daftarPeminjam');
            var peminjamList = document.getElementById('peminjamList');
            var noPeminjam = document.getElementById('noPeminjam');

            //buat if else 
            if (qrCode.classList.contains('hidden')) {
                qrCode.classList.remove('hidden');
                toggleButton.innerText = 'Tampilkan Informasi Buku';
                bookInfo.classList.add('hidden');
                jumlahPeminjaman.classList.add('hidden');
                jumlahStok.classList.add('hidden');
                lokasi.classList.add('hidden');
                daftarPeminjam.classList.add('hidden');
                peminjamList.classList.add('hidden');
                noPeminjam.classList.add('hidden');
            } else {
                qrCode.classList.add('hidden');
                toggleButton.innerText = 'Tampilkan QR Code';
                bookInfo.classList.remove('hidden');
                jumlahPeminjaman.classList.remove('hidden');
                jumlahStok.classList.remove('hidden');
                lokasi.classList.remove('hidden');
                daftarPeminjam.classList.remove('hidden');
                peminjamList.classList.remove('hidden');
                noPeminjam.classList.remove('hidden');
            }
        }
    </script>
</body>

</html>