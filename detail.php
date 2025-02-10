<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "tokodonat";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan semua input terisi
    if (!empty($_POST['namaProduk']) && !empty($_POST['alamat']) && !empty($_POST['jumlah']) && !empty($_POST['metodePembayaran'])) {
        $namaProduk = $_POST['namaProduk'];
        $alamat = $_POST['alamat'];
        $jumlah = (int) $_POST['jumlah'];
        $metodePembayaran = $_POST['metodePembayaran'];

        $harga_satuan = 1000; // Harga satuan donat
        $total_harga = $jumlah * $harga_satuan; // Hitung total harga

        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO pesanan (nama_produk, alamat, jumlah, metode_pembayaran, total_harga) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisi", $namaProduk, $alamat, $jumlah, $metodePembayaran, $total_harga);

        if ($stmt->execute()) {
            echo "<h3>Pesanan berhasil disimpan!</h3>";
            echo "<p>Nama Produk: <strong>$namaProduk</strong></p>";
            echo "<p>Alamat: <strong>$alamat</strong></p>";
            echo "<p>Jumlah: <strong>$jumlah</strong></p>";
            echo "<p>Metode Pembayaran: <strong>$metodePembayaran</strong></p>";
            echo "<p>Total Harga: <strong>Rp " . number_format($total_harga, 0, ',', '.') . "</strong></p>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Semua data harus diisi.";
    }
}

$conn->close();
?>
