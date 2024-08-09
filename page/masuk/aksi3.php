<?php
// Koneksi ke database
$servername = "srv1415.hstgr.io";
$username = "u252328825_root";
$password = "e4E!lp3Scn$";
$dbname = "u252328825_dbcownet";

$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menentukan status sapi
function determine_status($pitch, $roll, $yaw) {
    if (
        ($pitch >= -80 && $pitch <= -57) || ($pitch >= 50 && $pitch <= 80) ||
        ($roll >= -140 && $roll <= -100) || ($roll >= 100 && $roll <= 140) ||
        ($yaw >= -80 && $yaw <= -35) || ($yaw >= 35 && $yaw <= 80)
    ) {
        return "Tidak Normal";
    } else {
        return "Normal";
    }
}

// Fungsi untuk menentukan posisi sapi
function determineCowPosition($pitch, $roll) {
    if (($pitch <= 50 && $pitch >= -10) && (($roll <= 180 && $roll >= 165) || ($roll <= -165 && $roll >= -180))) {
        return "Berdiri";
    } elseif (($pitch <= 50 && $pitch >= 0) && (($roll <= 165 && $roll >= 140) || ($roll <= -140 && $roll >= -165))) {
        return "Berbaring";
    } elseif ($pitch <= -10 && $pitch >= -57) {
        return "Makan/Minum";
    } else {
        return "Posisi tidak diketahui";
    }
}

// Mengambil data dari database
$sql = "SELECT id, pitch, roll, yaw, temperature, timestamp FROM mpu6050_data3 ORDER BY timestamp DESC";
$result = $conn->query($sql);

$output = "";

if ($result->num_rows > 0) {
    $data_seen = [];
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $pitch = $row["pitch"];
        $roll = $row["roll"];
        $yaw = $row["yaw"];
        $temperature = $row["temperature"];
        $timestamp = $row["timestamp"];

        // Cek apakah data sudah ada di array $data_seen
        $data_key = $timestamp . $pitch . $roll . $yaw . $temperature;
        if (isset($data_seen[$data_key])) {
            continue;
        }
        $data_seen[$data_key] = true;

        // Menentukan posisi dan status
        $posisi = determineCowPosition($pitch, $roll);
        $status = determine_status($pitch, $roll, $yaw);

        // Update posisi dan status ke database
        $update_sql = "UPDATE mpu6050_data3 SET position='$posisi', status='$status' WHERE id=$id";
        $conn->query($update_sql);

        // Menambahkan data ke output tabel
        $output .= "<tr>
                        <td>{$timestamp}</td>
                        <td>{$pitch}</td>
                        <td>{$roll}</td>
                        <td>{$yaw}</td>
                        <td>" . number_format($temperature, 2) . "</td>
                        <td>$posisi</td>
                        <td>$status</td>
                    </tr>";
    }
} else {
    $output = "<tr><td colspan='7'>Tidak ada data</td></tr>";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Posisi Sapi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #a0a0a0;
            color: black;
        }
        td {
            background-color: #fff;
        }
        h1 {
            text-align: center;
            color: black;
        }
    </style>
</head>
<body>
    <h1>DATA POSISI SAPI</h1>
    <table>
        <tr>
            <th>Timestamp</th>
            <th>Pitch</th>
            <th>Roll</th>
            <th>Yaw</th>
            <th>Temperature</th>
            <th>Posisi</th>
            <th>Status</th>
        </tr>
        <?php echo $output; ?>
    </table>
</body>
</html>
