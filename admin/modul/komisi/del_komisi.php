<?php
// menangkap data id yang di kirim dari url
$id = $_GET['id_kom'];

// menghapus data dari database
mysqli_query($koneksi, "DELETE FROM komisi WHERE id_kom='$id'");

// mengalihkan halaman kembali ke index.php
echo " <script>
      alert('Data Berhasil Dihapus !');
      window.location='?page=komisi';
      </script>";
