<?php
// Memeriksa Session dan Menguhubungkan Database
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include("connection.php");

$message = $_GET["message"] ?? "";
$query = "SELECT * FROM student ORDER BY nim ASC";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <link href="assets/style.css" rel="stylesheet">
</head>

<!-- Menampilkan Header dan Menu Nafigasi -->
<body>
    <div class="container">
        <div id="header">
            <h1 id="logo">Data Mahasiswa</h1>
        </div>

        <hr>

        <nav>
            <ul>
                <li><a href="student_view.php">Tampil</a></li>
                <li><a href="student_add.php">Tambah</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <br>

        <!-- Menampilkan Pesan dan Mengambil Data Mahasiswa -->
        <?php if ($message !== ""): ?>
            <div class="pesan">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <?php
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die(
                "Query Error: " . mysqli_errno($connection) . " - " .
                mysqli_error($connection)
            );
        }
        ?>

        <!-- Menampilkan Tabel Data Mahasiswa -->
        <table border="1">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Fakultas</th>
                    <th>Jurusan</th>
                    <th>IPK</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($data["nim"], ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= htmlspecialchars($data["name"], ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= htmlspecialchars($data["birth_city"], ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= date("d-m-Y", strtotime($data["birth_date"])) ?></td>
                        <td><?= htmlspecialchars($data["faculty"], ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= htmlspecialchars($data["department"], ENT_QUOTES, "UTF-8") ?></td>
                        <td><?= htmlspecialchars($data["gpa"], ENT_QUOTES, "UTF-8") ?></td>
                        <td>
                            <a href="student_edit.php?nim=<?= urlencode($data["nim"]) ?>">Edit</a>
                            |
                            <a
                                href="student_delete.php?nim=<?= urlencode($data["nim"]) ?>"
                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                            >Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Membersihkan Hasil Query dan Menutup Koneksi -->
        <?php
        mysqli_free_result($result);
        mysqli_close($connection);
        ?>
    </div>
</body>
</html>