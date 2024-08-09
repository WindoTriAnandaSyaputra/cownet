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

// Mengambil data dari database
$sql = "SELECT timestamp, status, temperature FROM mpu6050_data1 ORDER BY timestamp DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Sapi</title>
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
    <h1>STATUS SAPI</h1>
    <table>
        <tr>
            <th>Rentang Waktu</th>
            <th>Status</th>
            <th>Suhu</th>
        </tr>
        <?php
        $lastNormalTimestamp = null;
        $normalTemperatures = [];
        $statusStarted = false;

        if ($result->num_rows > 0) {
            $previousRow = null;

            while ($row = $result->fetch_assoc()) {
                $timestamp = $row["timestamp"];
                $status = $row["status"];
                $temperature = number_format($row["temperature"], 2);

                // Check if the row is duplicate of the previous one
                if ($previousRow !== null && $timestamp == $previousRow["timestamp"] && $status == $previousRow["status"]) {
                    continue;
                }

                if ($status == "Normal") {
                    if (!$statusStarted) {
                        // Start a new normal period
                        $lastNormalTimestamp = $timestamp;
                        $statusStarted = true;
                    }
                    $normalTemperatures[] = $temperature;
                } else {
                    // End the normal period if one was active
                    if ($statusStarted) {
                        if (!empty($normalTemperatures) && $lastNormalTimestamp !== null) {
                            $averageTemperature = array_sum($normalTemperatures) / count($normalTemperatures);
                            echo "<tr>
                                    <td>{$lastNormalTimestamp} - {$timestamp}</td>
                                    <td>Normal</td>
                                    <td>" . number_format($averageTemperature, 2) . "</td>
                                  </tr>";
                            $normalTemperatures = [];
                            $lastNormalTimestamp = null;
                            $statusStarted = false;
                        }
                    }
                    // Tampilkan status tidak normal
                    echo "<tr>
                            <td>{$timestamp}</td>
                            <td>{$status}</td>
                            <td>{$temperature}</td>
                          </tr>";
                }

                // Store current row as previous row
                $previousRow = $row;
            }

            // Tampilkan status normal terakhir jika ada
            if ($statusStarted && !empty($normalTemperatures) && $lastNormalTimestamp !== null) {
                $averageTemperature = array_sum($normalTemperatures) / count($normalTemperatures);
                echo "<tr>
                        <td>{$lastNormalTimestamp} - {$timestamp}</td>
                        <td>Normal</td>
                        <td>" . number_format($averageTemperature, 2) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
