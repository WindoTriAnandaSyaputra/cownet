<?php
error_reporting(0);
session_start();

// Cek apakah pengguna telah login, jika belum, arahkan ke halaman login
if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])){
    header("location: login.php");
    exit(); // Hentikan eksekusi kode selanjutnya
}

// Sambungkan ke database
$servername = "localhost";
$username = "u252328825_root";
$password = "e4E!lp3Scn$";
$dbname = "u252328825_dbcownet";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil semua data dari tabel cowshed_data
$sql = "SELECT * FROM cowshed_data ORDER BY timestamp DESC";
$result = $conn->query($sql);

// Tampilkan judul halaman
echo "<div class='panel-heading'>
        <font size='+2' face='arial' color='black'><b><center>Monitoring Suhu, Kelembaban, dan Kualitas Udara Kandang Sapi</center></b></font>
      </div>";

// Cek apakah ada hasil dari query
if ($result->num_rows > 0) {
    $data = [];
    // Baca semua data dari hasil query ke array
    while($row = $result->fetch_assoc()) {
        $timestamp = strtotime($row['timestamp']);
        // Bulatkan timestamp ke interval 30 menit terdekat
        $rounded_timestamp = floor($timestamp / 1800) * 1800;
        $row['rounded_timestamp'] = $rounded_timestamp;
        $data[] = $row;
    }

    // Mengelompokkan data berdasarkan rounded_timestamp
    $grouped_data = [];
    foreach ($data as $row) {
        $rounded_timestamp = $row['rounded_timestamp'];
        if (!isset($grouped_data[$rounded_timestamp])) {
            $grouped_data[$rounded_timestamp] = [
                'temperature' => [],
                'humidity' => [],
                'ammonia' => [],
                'interval_start' => date('Y-m-d H:i:s', $rounded_timestamp),
                'interval_end' => date('Y-m-d H:i:s', $rounded_timestamp + 1800)
            ];
        }
        $grouped_data[$rounded_timestamp]['temperature'][] = $row['temperature'];
        $grouped_data[$rounded_timestamp]['humidity'][] = $row['humidity'];
        $grouped_data[$rounded_timestamp]['ammonia'][] = $row['ammonia'];
    }

    // Menghitung rata-rata untuk setiap kelompok data
    foreach ($grouped_data as $timestamp => $group) {
        $grouped_data[$timestamp]['avg_temperature'] = array_sum($group['temperature']) / count($group['temperature']);
        $grouped_data[$timestamp]['avg_humidity'] = array_sum($group['humidity']) / count($group['humidity']);
        $grouped_data[$timestamp]['avg_ammonia'] = array_sum($group['ammonia']) / count($group['ammonia']);
    }

    // Tampilkan data dalam format tabel HTML dengan sedikit CSS
    echo "<div style='width: 100%; margin: 10px auto;'>
            <table style='width: 100%; border-collapse: collapse;'>
                <thead style='background-color: #007bff; color: white;'>
                    <tr>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Interval Waktu</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Rata-rata Suhu</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Rata-rata Kelembaban</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Rata-rata Ammonia</th>
                    </tr>
                </thead>
                <tbody>";

    foreach ($grouped_data as $group) {
        echo "<tr>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . $group['interval_start'] . " - " . $group['interval_end'] . "</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . number_format($group['avg_temperature'], 2) . "</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . number_format($group['avg_humidity'], 2) . "</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . number_format($group['avg_ammonia'], 2) . "</td>
              </tr>";
    }

    echo "      </tbody>
            </table>
          </div>";
} else {
    echo "<p style='text-align:center; margin-top:20px;'>Tidak ada data</p>";
}

$conn->close();
?>
