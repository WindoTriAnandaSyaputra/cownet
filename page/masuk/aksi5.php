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
        ($pitch >= -80 && $pitch <= -57) || ($pitch >= 41 && $pitch <= 80) ||
        ($roll >= -140 && $roll <= -101) || ($roll >= 101 && $roll <= 140) ||
        ($yaw >= -40 && $yaw <= -21) || ($yaw >= 21 && $yaw <= 40)
    ) {
        return "Tidak Normal";
    } else {
        return "Normal";
    }
}

// Fungsi untuk menentukan posisi sapi
function determineCowPosition($pitch, $roll) {
    if ($pitch >= -25 && $pitch <= 25) {
        return "Berdiri";
    } elseif ($pitch >= -56 && $pitch <= -26) {
        return "Makan/Minum";
    } elseif ($roll >= 150 && $roll <= 165) {
        return "Berbaring";
    } elseif ($roll <= -150 && $roll >= -165) {
        return "Berbaring";
    } else {
        return "Posisi tidak diketahui";
    }
}

// Mengambil data dari database
$sql = "SELECT id, pitch, roll, yaw, temperature, timestamp FROM mpu6050_data5 ORDER BY timestamp DESC";
$result = $conn->query($sql);
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
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pitch = $row["pitch"];
                $roll = $row["roll"];
                $yaw = $row["yaw"];
                $temperature = $row["temperature"];
                $timestamp = $row["timestamp"];

                // Menentukan posisi dan status
                $posisi = determineCowPosition($pitch, $roll);
                $status = determine_status($pitch, $roll, $yaw);

                // Debugging output
                echo "<tr>
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
            echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
