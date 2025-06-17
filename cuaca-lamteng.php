<?php
$adm4_list = [
    "18.02.27.2001", "18.02.21.2001", "18.02.18.2001", "18.02.26.2001", "18.02.02.2001",
    "18.02.15.2001", "18.02.24.2001", "18.02.14.2001", "18.02.04.2001", "18.02.01.2001",
    "18.02.23.2001", "18.02.03.2001", "18.02.19.2001", "18.02.06.2001", "18.02.28.2001",
    "18.02.09.2001", "18.02.20.2001", "18.02.22.2001", "18.02.16.2001", "18.02.10.2001",
    "18.02.11.2001", "18.02.08.2001", "18.02.12.2001", "18.02.07.2001", "18.02.13.2001",
    "18.02.05.2001", "18.02.17.2001", "18.02.25.2001"
];

function fetch_weather_data($adm4) {
    $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={$adm4}";
    $response = @file_get_contents($url);
    if ($response === false) return null;
    $json = json_decode($response, true);
    return $json;
}

header("Content-Type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Prakiraan Cuaca Lampung Tengah</title>
  <style>
    body { font-family: sans-serif; background: #f4f7ff; color: #022168; padding: 20px; }
    h1 { color: #f8d41a; background: #022168; padding: 10px; border-radius: 8px; }
    .card {
      background: white;
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .location { font-weight: bold; font-size: 1.2em; color: #022168; }
    .detail { font-size: 0.95em; color: #333; margin-top: 5px; }
  </style>
</head>
<body>
<h1>Prakiraan Cuaca - Lampung Tengah</h1>
<?php
foreach ($adm4_list as $adm4) {
    $data = fetch_weather_data($adm4);
    if (!$data || !isset($data['lokasi'])) continue;

    $lokasi = $data['lokasi'];
    $nama = $lokasi['kecamatan'] ?? 'N/A';
    echo "<div class='card'>";
    echo "<div class='location'>Kecamatan: {$nama}</div>";

    if (isset($data['data'][0]['cuaca'][0])) {
        $cuaca = $data['data'][0]['cuaca'][0][0];
        $desc = $cuaca['weather_desc'] ?? 'N/A';
        $temp = $cuaca['t'] ?? 'N/A';
        $hum = $cuaca['hu'] ?? 'N/A';
        $wind = $cuaca['ws'] ?? 'N/A';
        echo "<div class='detail'>Cuaca: {$desc}, Suhu: {$temp}°C, Kelembapan: {$hum}%, Angin: {$wind} km/j</div>";
    } else {
        echo "<div class='detail'>Data cuaca tidak tersedia.</div>";
    }

    echo "</div>";
}
?>
</body>
</html>
