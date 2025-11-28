<?php
include 'koneksi.php';

// Tentukan tabel yang sedang dikelola
$table = isset($_GET['table']) ? $_GET['table'] : 'biodata';
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Ambil NIM yang dipilih dari dropdown atau default
$nim_dipilih = isset($_GET['nim']) ? $_GET['nim'] : '';
if(isset($_POST['nim_pilih'])) {
    $nim_dipilih = $_POST['nim_pilih'];
}

// Jika belum ada NIM dipilih, ambil NIM pertama
if(empty($nim_dipilih) && $table != 'biodata') {
    $query_nim = "SELECT nim FROM biodata LIMIT 1";
    $result_nim = mysqli_query($conn, $query_nim);
    if($result_nim && mysqli_num_rows($result_nim) > 0) {
        $row_nim = mysqli_fetch_assoc($result_nim);
        $nim_dipilih = $row_nim['nim'];
    }
}

// Ambil semua NIM untuk dropdown
$query_all_nim = "SELECT nim, nama FROM biodata ORDER BY nim ASC";
$result_all_nim = mysqli_query($conn, $query_all_nim);

// ==================== PROSES CRUD BIODATA ====================
if($table == 'biodata') {
    if(isset($_POST['simpan'])) {
        $nim = mysqli_real_escape_string($conn, $_POST['nim']);
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $agama = mysqli_real_escape_string($conn, $_POST['agama']);
        $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
        $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
        $foto = mysqli_real_escape_string($conn, $_POST['foto']);
        $twitter = mysqli_real_escape_string($conn, $_POST['twitter']);
        $facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
        $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
        
        $query = "INSERT INTO biodata (nim, nama, agama, tanggal_lahir, tempat_lahir, email, telepon, alamat, foto, twitter, facebook, instagram) 
                  VALUES ('$nim', '$nama', '$agama', '$tanggal_lahir', '$tempat_lahir', '$email', '$telepon', '$alamat', '$foto', '$twitter', '$facebook', '$instagram')";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='admin.php?table=biodata';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data: " . mysqli_error($conn) . "');</script>";
        }
    }
    
    if(isset($_POST['ubah'])) {
        $nim_lama = mysqli_real_escape_string($conn, $_POST['nim_lama']);
        $nim = mysqli_real_escape_string($conn, $_POST['nim']);
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $agama = mysqli_real_escape_string($conn, $_POST['agama']);
        $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
        $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
        $foto = mysqli_real_escape_string($conn, $_POST['foto']);
        $twitter = mysqli_real_escape_string($conn, $_POST['twitter']);
        $facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
        $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
        
        $query = "UPDATE biodata SET 
                  nim='$nim', nama='$nama', agama='$agama', tanggal_lahir='$tanggal_lahir', 
                  tempat_lahir='$tempat_lahir', email='$email', telepon='$telepon', alamat='$alamat',
                  foto='$foto', twitter='$twitter', facebook='$facebook', instagram='$instagram'
                  WHERE nim='$nim_lama'";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil diubah!'); window.location='admin.php?table=biodata';</script>";
        } else {
            echo "<script>alert('Gagal mengubah data: " . mysqli_error($conn) . "');</script>";
        }
    }
    
    if($action == 'hapus' && isset($_GET['nim'])) {
        $nim = mysqli_real_escape_string($conn, $_GET['nim']);
        $query = "DELETE FROM biodata WHERE nim='$nim'";
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='admin.php?table=biodata';</script>";
        }
    }
}

// ==================== PROSES CRUD PENDIDIKAN ====================
if($table == 'pendidikan') {
    if(isset($_POST['simpan'])) {
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $jenjang = mysqli_real_escape_string($conn, $_POST['jenjang']);
        $nama_institusi = mysqli_real_escape_string($conn, $_POST['nama_institusi']);
        $tahun_mulai = mysqli_real_escape_string($conn, $_POST['tahun_mulai']);
        $tahun_selesai = mysqli_real_escape_string($conn, $_POST['tahun_selesai']);
        $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
        
        if(empty($tahun_selesai)) $tahun_selesai = "NULL";
        
        $query = "INSERT INTO pendidikan (nim, jenjang, nama_institusi, tahun_mulai, tahun_selesai, keterangan) 
                  VALUES ('$nim_target', '$jenjang', '$nama_institusi', '$tahun_mulai', " . ($tahun_selesai == "NULL" ? "NULL" : "'$tahun_selesai'") . ", '$keterangan')";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='admin.php?table=pendidikan&nim=$nim_target';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data!');</script>";
        }
    }
    
    if(isset($_POST['ubah'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $jenjang = mysqli_real_escape_string($conn, $_POST['jenjang']);
        $nama_institusi = mysqli_real_escape_string($conn, $_POST['nama_institusi']);
        $tahun_mulai = mysqli_real_escape_string($conn, $_POST['tahun_mulai']);
        $tahun_selesai = mysqli_real_escape_string($conn, $_POST['tahun_selesai']);
        $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
        
        if(empty($tahun_selesai)) $tahun_selesai = "NULL";
        
        $query = "UPDATE pendidikan SET 
                  jenjang='$jenjang', nama_institusi='$nama_institusi', tahun_mulai='$tahun_mulai', 
                  tahun_selesai=" . ($tahun_selesai == "NULL" ? "NULL" : "'$tahun_selesai'") . ", keterangan='$keterangan'
                  WHERE id='$id'";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil diubah!'); window.location='admin.php?table=pendidikan&nim=$nim_target';</script>";
        }
    }
    
    if($action == 'hapus') {
        $id = mysqli_real_escape_string($conn, $id);
        $query = "DELETE FROM pendidikan WHERE id='$id'";
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='admin.php?table=pendidikan&nim=$nim_dipilih';</script>";
        }
    }
}

// ==================== PROSES CRUD PENGALAMAN ====================
if($table == 'pengalaman') {
    if(isset($_POST['simpan'])) {
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $posisi = mysqli_real_escape_string($conn, $_POST['posisi']);
        $perusahaan = mysqli_real_escape_string($conn, $_POST['perusahaan']);
        $tahun_mulai = mysqli_real_escape_string($conn, $_POST['tahun_mulai']);
        $tahun_selesai = mysqli_real_escape_string($conn, $_POST['tahun_selesai']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        
        if(empty($tahun_selesai)) $tahun_selesai = "NULL";
        
        $query = "INSERT INTO pengalaman (nim, posisi, perusahaan, tahun_mulai, tahun_selesai, deskripsi) 
                  VALUES ('$nim_target', '$posisi', '$perusahaan', '$tahun_mulai', " . ($tahun_selesai == "NULL" ? "NULL" : "'$tahun_selesai'") . ", '$deskripsi')";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='admin.php?table=pengalaman&nim=$nim_target';</script>";
        }
    }
    
    if(isset($_POST['ubah'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $posisi = mysqli_real_escape_string($conn, $_POST['posisi']);
        $perusahaan = mysqli_real_escape_string($conn, $_POST['perusahaan']);
        $tahun_mulai = mysqli_real_escape_string($conn, $_POST['tahun_mulai']);
        $tahun_selesai = mysqli_real_escape_string($conn, $_POST['tahun_selesai']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        
        if(empty($tahun_selesai)) $tahun_selesai = "NULL";
        
        $query = "UPDATE pengalaman SET 
                  posisi='$posisi', perusahaan='$perusahaan', tahun_mulai='$tahun_mulai', 
                  tahun_selesai=" . ($tahun_selesai == "NULL" ? "NULL" : "'$tahun_selesai'") . ", deskripsi='$deskripsi'
                  WHERE id='$id'";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil diubah!'); window.location='admin.php?table=pengalaman&nim=$nim_target';</script>";
        }
    }
    
    if($action == 'hapus') {
        $id = mysqli_real_escape_string($conn, $id);
        $query = "DELETE FROM pengalaman WHERE id='$id'";
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='admin.php?table=pengalaman&nim=$nim_dipilih';</script>";
        }
    }
}

// ==================== PROSES CRUD KEAHLIAN ====================
if($table == 'keahlian') {
    if(isset($_POST['simpan'])) {
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $nama_keahlian = mysqli_real_escape_string($conn, $_POST['nama_keahlian']);
        $level = mysqli_real_escape_string($conn, $_POST['level']);
        
        $query = "INSERT INTO keahlian (nim, nama_keahlian, level) VALUES ('$nim_target', '$nama_keahlian', '$level')";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='admin.php?table=keahlian&nim=$nim_target';</script>";
        }
    }
    
    if(isset($_POST['ubah'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $nama_keahlian = mysqli_real_escape_string($conn, $_POST['nama_keahlian']);
        $level = mysqli_real_escape_string($conn, $_POST['level']);
        
        $query = "UPDATE keahlian SET nama_keahlian='$nama_keahlian', level='$level' WHERE id='$id'";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil diubah!'); window.location='admin.php?table=keahlian&nim=$nim_target';</script>";
        }
    }
    
    if($action == 'hapus') {
        $id = mysqli_real_escape_string($conn, $id);
        $query = "DELETE FROM keahlian WHERE id='$id'";
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='admin.php?table=keahlian&nim=$nim_dipilih';</script>";
        }
    }
}

// ==================== PROSES CRUD PUBLIKASI ====================
if($table == 'publikasi') {
    if(isset($_POST['simpan'])) {
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $judul = mysqli_real_escape_string($conn, $_POST['judul']);
        $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
        $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
        
        $query = "INSERT INTO publikasi (nim, judul, penerbit, tahun) VALUES ('$nim_target', '$judul', '$penerbit', '$tahun')";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='admin.php?table=publikasi&nim=$nim_target';</script>";
        }
    }
    
    if(isset($_POST['ubah'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $judul = mysqli_real_escape_string($conn, $_POST['judul']);
        $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
        $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
        
        $query = "UPDATE publikasi SET judul='$judul', penerbit='$penerbit', tahun='$tahun' WHERE id='$id'";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil diubah!'); window.location='admin.php?table=publikasi&nim=$nim_target';</script>";
        }
    }
    
    if($action == 'hapus') {
        $id = mysqli_real_escape_string($conn, $id);
        $query = "DELETE FROM publikasi WHERE id='$id'";
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='admin.php?table=publikasi&nim=$nim_dipilih';</script>";
        }
    }
}

// ==================== PROSES CRUD HOBI ====================
if($table == 'hobi') {
    if(isset($_POST['simpan'])) {
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $nama_hobi = mysqli_real_escape_string($conn, $_POST['nama_hobi']);
        
        $query = "INSERT INTO hobi (nim, nama_hobi) VALUES ('$nim_target', '$nama_hobi')";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='admin.php?table=hobi&nim=$nim_target';</script>";
        }
    }
    
    if(isset($_POST['ubah'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $nim_target = mysqli_real_escape_string($conn, $_POST['nim_target']);
        $nama_hobi = mysqli_real_escape_string($conn, $_POST['nama_hobi']);
        
        $query = "UPDATE hobi SET nama_hobi='$nama_hobi' WHERE id='$id'";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil diubah!'); window.location='admin.php?table=hobi&nim=$nim_target';</script>";
        }
    }
    
    if($action == 'hapus') {
        $id = mysqli_real_escape_string($conn, $id);
        $query = "DELETE FROM hobi WHERE id='$id'";
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='admin.php?table=hobi&nim=$nim_dipilih';</script>";
        }
    }
}

// Ambil data untuk edit
$edit_data = null;
if($action == 'edit') {
    if($table == 'biodata' && isset($_GET['nim'])) {
        $nim = mysqli_real_escape_string($conn, $_GET['nim']);
        $query = "SELECT * FROM $table WHERE nim='$nim'";
    } elseif($table != 'biodata' && !empty($id)) {
        $id_escaped = mysqli_real_escape_string($conn, $id);
        $query = "SELECT * FROM $table WHERE id='$id_escaped'";
    }
    
    if(isset($query)) {
        $result_edit = mysqli_query($conn, $query);
        if($result_edit) {
            $edit_data = mysqli_fetch_assoc($result_edit);
        }
    }
}

// Ambil semua data dari tabel yang aktif
if($table == 'biodata') {
    $query = "SELECT * FROM $table ORDER BY nim DESC";
} else {
    if(!empty($nim_dipilih)) {
        $query = "SELECT * FROM $table WHERE nim='$nim_dipilih' ORDER BY id DESC";
    } else {
        $query = "SELECT * FROM $table ORDER BY id DESC LIMIT 0";
    }
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Profil Mahasiswa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; margin-bottom: 20px; text-align: center; border-bottom: 3px solid #0d47a1; padding-bottom: 15px; }
        h2 { color: #333; margin-bottom: 20px; margin-top: 30px; border-bottom: 2px solid #0d47a1; padding-bottom: 10px; }
        .nav-tabs { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px; background: #1b4965; padding: 15px; border-radius: 5px; }
        .nav-tabs a { color: white; text-decoration: none; padding: 12px 20px; background: #2d5f7f; border-radius: 4px; transition: all 0.3s; font-weight: bold; }
        .nav-tabs a:hover { background: #0d47a1; transform: translateY(-2px); }
        .nav-tabs a.active { background: #0d47a1; box-shadow: 0 4px 6px rgba(0,0,0,0.2); }
        .btn-view-profile { background: #4CAF50 !important; }
        
        .nim-selector { background: #e3f2fd; padding: 20px; border-radius: 5px; margin-bottom: 30px; border-left: 4px solid #2196F3; }
        .nim-selector form { display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
        .nim-selector label { font-weight: bold; color: #0d47a1; }
        .nim-selector select { padding: 10px 15px; border: 2px solid #2196F3; border-radius: 4px; font-size: 14px; min-width: 250px; }
        .nim-selector button { padding: 10px 20px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .nim-selector button:hover { background: #0b7dda; }
        
        .form-container { background: #f9f9f9; padding: 25px; border-radius: 5px; margin-bottom: 30px; border: 1px solid #ddd; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        .form-group.full-width { grid-column: 1 / -1; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="email"], input[type="date"], input[type="number"], select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; }
        textarea { resize: vertical; min-height: 80px; }
        button { padding: 12px 25px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; margin-right: 10px; font-weight: bold; transition: all 0.3s; }
        .btn-simpan { background: #4CAF50; color: white; }
        .btn-simpan:hover { background: #45a049; transform: translateY(-2px); }
        .btn-batal { background: #f44336; color: white; }
        .btn-batal:hover { background: #da190b; transform: translateY(-2px); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #0d47a1; color: white; font-weight: bold; }
        tr:hover { background-color: #f5f5f5; }
        tr:nth-child(even) { background-color: #fafafa; }
        .btn-ubah { background: #2196F3; color: white; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px; display: inline-block; transition: all 0.3s; }
        .btn-hapus { background: #f44336; color: white; padding: 6px 12px; text-decoration: none; border-radius: 3px; font-size: 12px; display: inline-block; transition: all 0.3s; }
        .btn-ubah:hover { background: #0b7dda; transform: translateY(-2px); }
        .btn-hapus:hover { background: #da190b; transform: translateY(-2px); }
        .table-scroll { overflow-x: auto; }
        .info-box { background: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #2196F3; }
        .info-box strong { color: #0d47a1; }
        .warning-box { background: #fff3cd; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #ffc107; color: #856404; }
        @media (max-width: 768px) { .nav-tabs { flex-direction: column; } .nav-tabs a { width: 100%; text-align: center; } .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 ADMIN PANEL - PROFIL MAHASISWA</h1>
        
        <div class="nav-tabs">
            <a href="home.php" class="btn-view-profile">← Daftar Profil</a>
            <a href="?table=biodata" class="<?php echo $table=='biodata' ? 'active' : ''; ?>">Biodata</a>
            <a href="?table=pendidikan<?php echo !empty($nim_dipilih) ? '&nim='.$nim_dipilih : ''; ?>" class="<?php echo $table=='pendidikan' ? 'active' : ''; ?>">Pendidikan</a>
            <a href="?table=pengalaman<?php echo !empty($nim_dipilih) ? '&nim='.$nim_dipilih : ''; ?>" class="<?php echo $table=='pengalaman' ? 'active' : ''; ?>">Pengalaman</a>
            <a href="?table=keahlian<?php echo !empty($nim_dipilih) ? '&nim='.$nim_dipilih : ''; ?>" class="<?php echo $table=='keahlian' ? 'active' : ''; ?>">Keahlian</a>
            <a href="?table=publikasi<?php echo !empty($nim_dipilih) ? '&nim='.$nim_dipilih : ''; ?>" class="<?php echo $table=='publikasi' ? 'active' : ''; ?>">Publikasi</a>
            <a href="?table=hobi<?php echo !empty($nim_dipilih) ? '&nim='.$nim_dipilih : ''; ?>" class="<?php echo $table=='hobi' ? 'active' : ''; ?>">Hobi</a>
        </div>
        
        <?php if($table != 'biodata' && mysqli_num_rows($result_all_nim) > 0): ?>
        <div class="nim-selector">
            <form method="GET" action="">
                <input type="hidden" name="table" value="<?php echo $table; ?>">
                <label>🎯 Pilih NIM Mahasiswa:</label>
                <select name="nim" required>
                    <option value="">-- Pilih NIM --</option>
                    <?php 
                    mysqli_data_seek($result_all_nim, 0);
                    while($row_nim = mysqli_fetch_assoc($result_all_nim)): 
                    ?>
                    <option value="<?php echo $row_nim['nim']; ?>" <?php echo ($nim_dipilih == $row_nim['nim']) ? 'selected' : ''; ?>>
                        <?php echo $row_nim['nim'] . ' - ' . $row_nim['nama']; ?>
                    </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit">Tampilkan Data</button>
            </form>
        </div>
        <?php endif; ?>
        
        <?php if($table != 'biodata' && empty($nim_dipilih)): ?>
            <div class="warning-box" style="text-align: center; padding: 40px;">
                <h2 style="border: none; margin: 0;">⚠️ Pilih NIM Terlebih Dahulu</h2>
                <p style="margin-top: 15px;">Silakan pilih NIM mahasiswa yang ingin Anda kelola datanya.</p>
                <?php if(mysqli_num_rows($result_all_nim) == 0): ?>
                <p style="margin-top: 10px; font-weight: bold;">Belum ada data biodata. <a href="?table=biodata">Tambah biodata dulu</a></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
        
        <?php if($table != 'biodata' && !empty($nim_dipilih)): ?>
        <div class="info-box">
            <strong>📌 Mengelola data untuk NIM:</strong> <?php echo $nim_dipilih; ?>
            <?php
            $query_nama = "SELECT nama FROM biodata WHERE nim='$nim_dipilih'";
            $result_nama = mysqli_query($conn, $query_nama);
            if($result_nama && mysqli_num_rows($result_nama) > 0) {
                $row_nama = mysqli_fetch_assoc($result_nama);
                echo " - " . $row_nama['nama'];
            }
            ?>
        </div>
        <?php endif; ?>
        
        <h2><?php echo $edit_data ? '✏️ FORM UBAH DATA' : '➕ FORM TAMBAH DATA'; ?> - <?php echo strtoupper($table); ?></h2>
        
        <div class="form-container">
            <form method="POST" action="">
                <?php if($edit_data && $table != 'biodata'): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <?php if($table != 'biodata'): ?>
                    <input type="hidden" name="nim_target" value="<?php echo $nim_dipilih; ?>">
                <?php endif; ?>
                
                <?php if($table == 'biodata'): ?>
                    <?php if($edit_data): ?>
                        <input type="hidden" name="nim_lama" value="<?php echo $edit_data['nim']; ?>">
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label>NIM: *</label>
                            <input type="text" name="nim" required value="<?php echo $edit_data ? $edit_data['nim'] : ''; ?>" placeholder="Contoh: 2024081016">
                        </div>
                        <div class="form-group">
                            <label>NAMA: *</label>
                            <input type="text" name="nama" required value="<?php echo $edit_data ? $edit_data['nama'] : ''; ?>" placeholder="Nama Lengkap">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>AGAMA: *</label>
                            <input type="text" name="agama" required value="<?php echo $edit_data ? $edit_data['agama'] : ''; ?>" placeholder="Agama">
                        </div>
                        <div class="form-group">
                            <label>TANGGAL LAHIR: *</label>
                            <input type="date" name="tanggal_lahir" required value="<?php echo $edit_data ? $edit_data['tanggal_lahir'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>TEMPAT LAHIR: *</label>
                            <input type="text" name="tempat_lahir" required value="<?php echo $edit_data ? $edit_data['tempat_lahir'] : ''; ?>" placeholder="Kota Lahir">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>EMAIL: *</label>
                            <input type="email" name="email" required value="<?php echo $edit_data ? $edit_data['email'] : ''; ?>" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label>TELEPON: *</label>
                            <input type="text" name="telepon" required value="<?php echo $edit_data ? $edit_data['telepon'] : ''; ?>" placeholder="081234567890">
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label>ALAMAT: *</label>
                        <textarea name="alamat" required placeholder="Alamat lengkap"><?php echo $edit_data ? $edit_data['alamat'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>FOTO URL: *</label>
                        <input type="text" name="foto" required value="<?php echo $edit_data ? $edit_data['foto'] : 'https://via.placeholder.com/150'; ?>" placeholder="https://via.placeholder.com/150">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>TWITTER:</label>
                            <input type="text" name="twitter" value="<?php echo $edit_data ? $edit_data['twitter'] : ''; ?>" placeholder="https://twitter.com/username">
                        </div>
                        <div class="form-group">
                            <label>FACEBOOK:</label>
                            <input type="text" name="facebook" value="<?php echo $edit_data ? $edit_data['facebook'] : ''; ?>" placeholder="https://facebook.com/username">
                        </div>
                        <div class="form-group">
                            <label>INSTAGRAM:</label>
                            <input type="text" name="instagram" value="<?php echo $edit_data ? $edit_data['instagram'] : ''; ?>" placeholder="https://instagram.com/username">
                        </div>
                    </div>
                
                <?php elseif($table == 'pendidikan'): ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label>JENJANG: *</label>
                            <input type="text" name="jenjang" required value="<?php echo $edit_data ? $edit_data['jenjang'] : ''; ?>" placeholder="Contoh: S1 Sistem Informasi">
                        </div>
                        <div class="form-group">
                            <label>NAMA INSTITUSI: *</label>
                            <input type="text" name="nama_institusi" required value="<?php echo $edit_data ? $edit_data['nama_institusi'] : ''; ?>" placeholder="Nama Universitas/Sekolah">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>TAHUN MULAI: *</label>
                            <input type="number" name="tahun_mulai" required value="<?php echo $edit_data ? $edit_data['tahun_mulai'] : ''; ?>" placeholder="2024" min="1900" max="2100">
                        </div>
                        <div class="form-group">
                            <label>TAHUN SELESAI:</label>
                            <input type="number" name="tahun_selesai" value="<?php echo $edit_data ? $edit_data['tahun_selesai'] : ''; ?>" placeholder="2028" min="1900" max="2100">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>KETERANGAN:</label>
                        <textarea name="keterangan" placeholder="Keterangan tambahan"><?php echo $edit_data ? $edit_data['keterangan'] : ''; ?></textarea>
                    </div>
                
                <?php elseif($table == 'pengalaman'): ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label>POSISI: *</label>
                            <input type="text" name="posisi" required value="<?php echo $edit_data ? $edit_data['posisi'] : ''; ?>" placeholder="Contoh: Web Developer Intern">
                        </div>
                        <div class="form-group">
                            <label>PERUSAHAAN: *</label>
                            <input type="text" name="perusahaan" required value="<?php echo $edit_data ? $edit_data['perusahaan'] : ''; ?>" placeholder="Nama Perusahaan">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>TAHUN MULAI: *</label>
                            <input type="number" name="tahun_mulai" required value="<?php echo $edit_data ? $edit_data['tahun_mulai'] : ''; ?>" placeholder="2024" min="1900" max="2100">
                        </div>
                        <div class="form-group">
                            <label>TAHUN SELESAI:</label>
                            <input type="number" name="tahun_selesai" value="<?php echo $edit_data ? $edit_data['tahun_selesai'] : ''; ?>" placeholder="2025" min="1900" max="2100">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>DESKRIPSI: *</label>
                        <textarea name="deskripsi" required placeholder="Deskripsi pekerjaan"><?php echo $edit_data ? $edit_data['deskripsi'] : ''; ?></textarea>
                    </div>
                
                <?php elseif($table == 'keahlian'): ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label>NAMA KEAHLIAN: *</label>
                            <input type="text" name="nama_keahlian" required value="<?php echo $edit_data ? $edit_data['nama_keahlian'] : ''; ?>" placeholder="Contoh: HTML & CSS">
                        </div>
                        <div class="form-group">
                            <label>LEVEL: *</label>
                            <select name="level" required>
                                <option value="">-- Pilih Level --</option>
                                <option value="Beginner" <?php echo ($edit_data && $edit_data['level']=='Beginner') ? 'selected' : ''; ?>>Beginner</option>
                                <option value="Intermediate" <?php echo ($edit_data && $edit_data['level']=='Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                <option value="Advanced" <?php echo ($edit_data && $edit_data['level']=='Advanced') ? 'selected' : ''; ?>>Advanced</option>
                                <option value="Expert" <?php echo ($edit_data && $edit_data['level']=='Expert') ? 'selected' : ''; ?>>Expert</option>
                            </select>
                        </div>
                    </div>
                
                <?php elseif($table == 'publikasi'): ?>
                    <div class="form-group">
                        <label>JUDUL PUBLIKASI: *</label>
                        <input type="text" name="judul" required value="<?php echo $edit_data ? $edit_data['judul'] : ''; ?>" placeholder="Judul Artikel/Paper">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>PENERBIT: *</label>
                            <input type="text" name="penerbit" required value="<?php echo $edit_data ? $edit_data['penerbit'] : ''; ?>" placeholder="Nama Jurnal/Penerbit">
                        </div>
                        <div class="form-group">
                            <label>TAHUN: *</label>
                            <input type="number" name="tahun" required value="<?php echo $edit_data ? $edit_data['tahun'] : ''; ?>" placeholder="2025" min="1900" max="2100">
                        </div>
                    </div>
                
                <?php elseif($table == 'hobi'): ?>
                    <div class="form-group">
                        <label>NAMA HOBI: *</label>
                        <input type="text" name="nama_hobi" required value="<?php echo $edit_data ? $edit_data['nama_hobi'] : ''; ?>" placeholder="Contoh: Coding">
                    </div>
                
                <?php endif; ?>
                
                <?php if($edit_data): ?>
                    <button type="submit" name="ubah" class="btn-simpan">✓ UBAH</button>
                    <a href="admin.php?table=<?php echo $table; ?><?php echo !empty($nim_dipilih) ? '&nim='.$nim_dipilih : ''; ?>"><button type="button" class="btn-batal">✗ BATAL</button></a>
                <?php else: ?>
                    <button type="submit" name="simpan" class="btn-simpan">✓ SIMPAN</button>
                <?php endif; ?>
            </form>
        </div>
        
        <h2>📊 DATA <?php echo strtoupper($table); ?></h2>
        
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <?php if($table == 'biodata'): ?>
                            <th>NIM</th>
                            <th>NAMA</th>
                            <th>AGAMA</th>
                            <th>TANGGAL LAHIR</th>
                            <th>EMAIL</th>
                        <?php elseif($table == 'pendidikan'): ?>
                            <th>JENJANG</th>
                            <th>INSTITUSI</th>
                            <th>TAHUN MULAI</th>
                            <th>TAHUN SELESAI</th>
                        <?php elseif($table == 'pengalaman'): ?>
                            <th>POSISI</th>
                            <th>PERUSAHAAN</th>
                            <th>TAHUN</th>
                        <?php elseif($table == 'keahlian'): ?>
                            <th>NAMA KEAHLIAN</th>
                            <th>LEVEL</th>
                        <?php elseif($table == 'publikasi'): ?>
                            <th>JUDUL</th>
                            <th>PENERBIT</th>
                            <th>TAHUN</th>
                        <?php elseif($table == 'hobi'): ?>
                            <th>NAMA HOBI</th>
                        <?php endif; ?>
                        <th>KELOLA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while($row = mysqli_fetch_assoc($result)): 
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <?php if($table == 'biodata'): ?>
                            <td><?php echo $row['nim']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['agama']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_lahir'])); ?></td>
                            <td><?php echo $row['email']; ?></td>
                        <?php elseif($table == 'pendidikan'): ?>
                            <td><?php echo $row['jenjang']; ?></td>
                            <td><?php echo $row['nama_institusi']; ?></td>
                            <td><?php echo $row['tahun_mulai']; ?></td>
                            <td><?php echo $row['tahun_selesai'] ? $row['tahun_selesai'] : 'Sekarang'; ?></td>
                        <?php elseif($table == 'pengalaman'): ?>
                            <td><?php echo $row['posisi']; ?></td>
                            <td><?php echo $row['perusahaan']; ?></td>
                            <td><?php echo $row['tahun_mulai'] . ' - ' . ($row['tahun_selesai'] ? $row['tahun_selesai'] : 'Sekarang'); ?></td>
                        <?php elseif($table == 'keahlian'): ?>
                            <td><?php echo $row['nama_keahlian']; ?></td>
                            <td><?php echo $row['level']; ?></td>
                        <?php elseif($table == 'publikasi'): ?>
                            <td><?php echo $row['judul']; ?></td>
                            <td><?php echo $row['penerbit']; ?></td>
                            <td><?php echo $row['tahun']; ?></td>
                        <?php elseif($table == 'hobi'): ?>
                            <td><?php echo $row['nama_hobi']; ?></td>
                        <?php endif; ?>
                        <td>
                            <?php if($table == 'biodata'): ?>
                                <a href="?table=<?php echo $table; ?>&action=edit&nim=<?php echo $row['nim']; ?>" class="btn-ubah">✏️ UBAH</a>
                                <a href="?table=<?php echo $table; ?>&action=hapus&nim=<?php echo $row['nim']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini? Semua data terkait akan terhapus!')">🗑️ HAPUS</a>
                            <?php else: ?>
                                <a href="?table=<?php echo $table; ?>&action=edit&id=<?php echo $row['id']; ?>&nim=<?php echo $nim_dipilih; ?>" class="btn-ubah">✏️ UBAH</a>
                                <a href="?table=<?php echo $table; ?>&action=hapus&id=<?php echo $row['id']; ?>&nim=<?php echo $nim_dipilih; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ HAPUS</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    } else {
                        echo "<tr><td colspan='10' style='text-align: center; padding: 30px;'>Belum ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <?php endif; ?>
    </div>
</body>
</html>
