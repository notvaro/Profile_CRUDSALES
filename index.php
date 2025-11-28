<?php
include 'koneksi.php';

// Ambil NIM dari parameter URL atau ambil yang pertama
$nim_dipilih = '';
if(isset($_GET['nim'])) {
    $nim_dipilih = mysqli_real_escape_string($conn, $_GET['nim']);
} else {
    // Jika tidak ada NIM di URL, ambil NIM pertama
    $query_first = "SELECT nim FROM biodata LIMIT 1";
    $result_first = mysqli_query($conn, $query_first);
    if($result_first && mysqli_num_rows($result_first) > 0) {
        $row_first = mysqli_fetch_assoc($result_first);
        $nim_dipilih = $row_first['nim'];
    }
}

// Jika masih tidak ada NIM, redirect ke home
if(empty($nim_dipilih)) {
    header("Location: home.php");
    exit();
}

// Query untuk mengambil data biodata berdasarkan NIM
$query_biodata = "SELECT * FROM biodata WHERE nim='$nim_dipilih' LIMIT 1";
$result_biodata = mysqli_query($conn, $query_biodata);
$biodata = mysqli_fetch_assoc($result_biodata);

// Cek jika biodata tidak ditemukan
if (!$biodata) {
    die("<h2 style='color:red; text-align:center; margin-top:50px;'>
         ERROR: Data untuk NIM '$nim_dipilih' tidak ditemukan!<br>
         <a href='home.php' style='color: #0d47a1;'>← Kembali ke Halaman Utama</a>
         </h2>");
}

$nim = $biodata['nim'];

// Query untuk mengambil data lainnya berdasarkan NIM
$query_pendidikan = "SELECT * FROM pendidikan WHERE nim='$nim' ORDER BY tahun_mulai DESC";
$result_pendidikan = mysqli_query($conn, $query_pendidikan);

$query_pengalaman = "SELECT * FROM pengalaman WHERE nim='$nim' ORDER BY tahun_mulai DESC";
$result_pengalaman = mysqli_query($conn, $query_pengalaman);

$query_keahlian = "SELECT * FROM keahlian WHERE nim='$nim'";
$result_keahlian = mysqli_query($conn, $query_keahlian);

$query_publikasi = "SELECT * FROM publikasi WHERE nim='$nim' ORDER BY tahun DESC";
$result_publikasi = mysqli_query($conn, $query_publikasi);

$query_hobi = "SELECT * FROM hobi WHERE nim='$nim'";
$result_hobi = mysqli_query($conn, $query_hobi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa - <?php echo htmlspecialchars($biodata['nama']); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .back-button {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .back-button:hover {
            background: #0b7dda;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <a href="home.php" class="back-button">← Kembali ke Daftar Profil</a>
    
    <div class="content-wrap">
        <header>
            <div class="header-content">
                <div class="header-photo">
                    <img src="<?php echo htmlspecialchars($biodata['foto']); ?>" alt="Foto Profil">
                </div>
                <div class="header-text">
                    <h1>Profil Mahasiswa</h1>
                    <p class="tagline"><?php echo htmlspecialchars($biodata['nama']); ?></p>
                </div>
            </div>
        </header>

        <nav>
            <ul>
                <li><a href="#biodata" class="nav-link active">Biodata</a></li>
                <li><a href="#pendidikan" class="nav-link">Pendidikan</a></li>
                <li><a href="#pengalaman" class="nav-link">Pengalaman</a></li>
                <li><a href="#keahlian" class="nav-link">Keahlian</a></li>
                <li><a href="#publikasi" class="nav-link">Publikasi</a></li>
            </ul>
        </nav>

        <div class="main-container">
            <main>
                <!-- Biodata Section -->
                <section id="biodata" class="content-section active">
                    <h2>Biodata</h2>
                    <ul>
                        <li><strong>NIM:</strong> <?php echo htmlspecialchars($biodata['nim']); ?></li>
                        <li><strong>Nama:</strong> <?php echo htmlspecialchars($biodata['nama']); ?></li>
                        <li><strong>Agama:</strong> <?php echo htmlspecialchars($biodata['agama']); ?></li>
                        <li><strong>Tanggal Lahir:</strong> <?php echo date('d F Y', strtotime($biodata['tanggal_lahir'])); ?></li>
                        <li><strong>Tempat Lahir:</strong> <?php echo htmlspecialchars($biodata['tempat_lahir']); ?></li>
                        <li><strong>Email:</strong> <?php echo htmlspecialchars($biodata['email']); ?></li>
                        <li><strong>Telepon:</strong> <?php echo htmlspecialchars($biodata['telepon']); ?></li>
                        <li><strong>Alamat:</strong> <?php echo htmlspecialchars($biodata['alamat']); ?></li>
                    </ul>
                </section>

                <!-- Pendidikan Section -->
                <section id="pendidikan" class="content-section">
                    <h2>Pendidikan</h2>
                    <ul>
                        <?php 
                        if(mysqli_num_rows($result_pendidikan) > 0) {
                            while($pendidikan = mysqli_fetch_assoc($result_pendidikan)): 
                        ?>
                        <li>
                            <strong><?php echo htmlspecialchars($pendidikan['jenjang']); ?></strong> - 
                            <?php echo htmlspecialchars($pendidikan['nama_institusi']); ?> 
                            (<?php echo $pendidikan['tahun_mulai']; ?> - 
                            <?php echo $pendidikan['tahun_selesai'] ? $pendidikan['tahun_selesai'] : 'Sekarang'; ?>)
                        </li>
                        <?php 
                            endwhile;
                        } else {
                            echo "<li>Belum ada data pendidikan</li>";
                        }
                        ?>
                    </ul>
                </section>

                <!-- Pengalaman Section -->
                <section id="pengalaman" class="content-section">
                    <h2>Pengalaman</h2>
                    <ul>
                        <?php 
                        if(mysqli_num_rows($result_pengalaman) > 0) {
                            while($pengalaman = mysqli_fetch_assoc($result_pengalaman)): 
                        ?>
                        <li>
                            <strong><?php echo htmlspecialchars($pengalaman['posisi']); ?></strong> - 
                            <?php echo htmlspecialchars($pengalaman['perusahaan']); ?> 
                            (<?php echo $pengalaman['tahun_mulai']; ?> - 
                            <?php echo $pengalaman['tahun_selesai'] ? $pengalaman['tahun_selesai'] : 'Sekarang'; ?>)
                            <br><?php echo htmlspecialchars($pengalaman['deskripsi']); ?>
                        </li>
                        <?php 
                            endwhile;
                        } else {
                            echo "<li>Belum ada data pengalaman</li>";
                        }
                        ?>
                    </ul>
                </section>

                <!-- Keahlian Section -->
                <section id="keahlian" class="content-section">
                    <h2>Keahlian</h2>
                    <ul>
                        <?php 
                        if(mysqli_num_rows($result_keahlian) > 0) {
                            while($keahlian = mysqli_fetch_assoc($result_keahlian)): 
                        ?>
                        <li><?php echo htmlspecialchars($keahlian['nama_keahlian']); ?> - Level: <?php echo htmlspecialchars($keahlian['level']); ?></li>
                        <?php 
                            endwhile;
                        } else {
                            echo "<li>Belum ada data keahlian</li>";
                        }
                        ?>
                    </ul>
                </section>

                <!-- Publikasi Section -->
                <section id="publikasi" class="content-section">
                    <h2>Publikasi</h2>
                    <ul>
                        <?php 
                        if(mysqli_num_rows($result_publikasi) > 0) {
                            while($publikasi = mysqli_fetch_assoc($result_publikasi)): 
                        ?>
                        <li>
                            <strong><?php echo htmlspecialchars($publikasi['judul']); ?></strong> 
                            (<?php echo $publikasi['tahun']; ?>)
                            <br><?php echo htmlspecialchars($publikasi['penerbit']); ?>
                        </li>
                        <?php 
                            endwhile;
                        } else {
                            echo "<li>Belum ada data publikasi</li>";
                        }
                        ?>
                    </ul>
                </section>
            </main>

            <aside>
                <h3>Hobi</h3>
                <ul>
                    <?php 
                    if(mysqli_num_rows($result_hobi) > 0) {
                        while($hobi = mysqli_fetch_assoc($result_hobi)): 
                    ?>
                    <li><?php echo htmlspecialchars($hobi['nama_hobi']); ?></li>
                    <?php 
                        endwhile;
                    } else {
                        echo "<li>Belum ada data hobi</li>";
                    }
                    ?>
                </ul>
            </aside>
        </div>

        <footer>
            <div class="footer-container">
                <div class="footer-left">
                    <p>Copyright 2025. All Rights Reserved</p>
                </div>
                <div class="footer-right">
                    <?php if(!empty($biodata['twitter'])): ?>
                    <a href="<?php echo htmlspecialchars($biodata['twitter']); ?>" target="_blank">Twitter: @<?php echo basename($biodata['twitter']); ?></a>
                    <span class="separator">|</span>
                    <?php endif; ?>
                    <?php if(!empty($biodata['facebook'])): ?>
                    <a href="<?php echo htmlspecialchars($biodata['facebook']); ?>" target="_blank">FB: @<?php echo basename($biodata['facebook']); ?></a>
                    <span class="separator">|</span>
                    <?php endif; ?>
                    <?php if(!empty($biodata['instagram'])): ?>
                    <a href="<?php echo htmlspecialchars($biodata['instagram']); ?>" target="_blank">Instagram: @<?php echo basename($biodata['instagram']); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                const targetId = this.getAttribute('href').substring(1);
                document.getElementById(targetId).classList.add('active');
            });
        });
    </script>
</body>
</html>
