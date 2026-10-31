<?php
// Memeriksa Session dan Menghubungkan Database
 session_start();
 if (!isset($_SESSION["username"])) { // Memeriksa apakah session username tersedia.
    header("Location: login.php");
    exit();
 }

 include("connection.php");

  // Mengambil NIM dan Menghapus Data Mahasiswa
if (isset($_GET["nim"])) { // Memeriksa apakah parameter nim tersedia pada URL
  $nim = htmlentities(strip_tags(trim($_GET["nim"]))); // strip_tags() menghapus tag HTML, htmlentities() mengubah karakter khusus HTML menjadi bentuk teks.
  $nim = mysqli_real_escape_string($connection, $nim); // mysqli_real_escape_string(): Fungsi PHP untuk memberikan penanganan khusus pada karakter tertentu dalam input agar tidak merusak query SQL.   maksudnya jelaskna secara singkat

  $query = "DELETE FROM student WHERE nim='$nim'"; // Kode ini menghapus data mahasiswa berdasarkan NIM tertentu, bukan menghapus seluruh data dalam tabel.
  $result = mysqli_query($connection, $query); 

  // Menampilkan Hasil Penghapusan
  if ($result) {
    $message = urlencode("Data mahasiswa dengan NIM <b>$nim</b> berhasil dihapus."); // urlencode() menyesuaikan teks agar aman dikirim melalui URL.
    header("Location: student_view.php?message={$message}"); // Mengarahkan browser ke student_view.php dan menyertakan pesan keberhasilan melalui parameter URL bernama message.
    exit();
  }
  else {
    die("Gagal menghapus data: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
  }
} else {
  header("Location: student_view.php"); // Mengarahkan pengguna kembali ke halaman daftar mahasiswa tanpa menghapus data.
  exit();
}
?>
