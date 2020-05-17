<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/style.css" />
    <title>World Weather</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            //Jika telah memilih city
            if ($dataWeather) {
            ?>
                <!-- City -->
                <div class="location">
                    <h1 class="location-timezone"><?= $city ?></h1>
                    <img class="icon" src="http://openweathermap.org/img/wn/<?= $dataWeather[0]["weather"][0]["icon"] ?>.png"></img>
                </div>

                <!-- Menampilkan data hari ini -->
                <div class="avg-section col-12">
                    <h5>Average weather in 5 days: <b><span id="avgWeather"></span> C </b></h5>
                    <h5>Average changes weather in 5 days: <b><span id="avgDiff"></span> C</b> </h5>
                </div>

                <div class="card-deck col-lg-12">
                    <?php

                    //inisialisasi awal
                    $tempMin = 0;
                    $tempMax = 0;
                    $avgTemp = 0;
                    $avgDiff = 0;
                    $tempDiff = 0;
                    $date = 0;
                    $card = 0; //constraint hanya 5 hari yang tampil
                    $dateStart = date("d - m - Y", ($dataWeather[count($dataWeather) - 1]["dt"]));

                    //untuk menampilkan data json
                    // echo "<script>console.log(" . json_encode($dataWeather) . ");</script>";


                    for ($i = count($dataWeather) - 1; $i >= 0; $i--) {
                        $tempMin = $dataWeather[$i]["main"]["temp_min"];
                        for ($j = count($dataWeather) - 1; $j >= 0; $j--) {
                            //Untuk mendapatkan perbedaan suhu, dimana (suhu maksimum - suhu minimum pada hari tersebut)
                            if ($dateStart == date("d - m - Y", ($dataWeather[$j]["dt"]))) {
                                $tempMin = min($tempMin, $dataWeather[$j]["main"]["temp_min"]);
                                $tempMax = max($tempMax, $dataWeather[$j]["main"]["temp_max"]);
                                $tempDiff = $tempMax - $tempMin;
                            }
                        }

                        //Untuk ambil date yang berbeda (5 hari)
                        if ($date == date("d - m - Y", ($dataWeather[$i]["dt"]))) {
                            $tempMin = min($tempMin, $dataWeather[$i]["main"]["temp_min"]);
                            $tempMax = max($tempMax, $dataWeather[$i]["main"]["temp_max"]);
                            $tempDiff = $tempMax - $tempMin;
                            continue;
                        } else {
                            $tempMin = 0;
                            $tempMax = 0;
                            $card++; ?>
                            <div class="col-lg-5 card">
                                <img class=" card-img-top" style="height: 100; width: 100px;" src=" https://openweathermap.org/img/wn/<?= $dataWeather[$i]["weather"][0]["icon"] ?>.png" alt=" Card image cap">
                                <div class="card-body text-center">
                                    <!-- Tanggal -->
                                    <p class="card-text">
                                        <b>
                                            <?= date("d - m - Y", ($dataWeather[$i]["dt"])); ?>
                                        </b>
                                    </p>

                                    <!-- Suhu -->
                                    <h2 class="card-text">
                                        <?= floor($dataWeather[$i]["main"]["temp"]);

                                        // Hitung rata" suhu
                                        $avgTemp = $avgTemp + $dataWeather[$i]["main"]["temp"];
                                        ?>
                                        <span class="temp-span">C</span>
                                    </h2>

                                    <!-- Desc Suhu -->
                                    <p class="card-text detail-section">
                                        <?= $dataWeather[$i]["weather"][0]["main"];  ?>
                                    </p>

                                    <?php
                                    // Simpan date untuk pengecekan
                                    $date = date("d - m - Y", ($dataWeather[$i]["dt"]));

                                    //Ambil data min dan max
                                    $tempMin = $dataWeather[$i]["main"]["temp_min"];
                                    $tempMax = $dataWeather[$i]["main"]["temp_max"];

                                    ?>
                                    <!-- Rata" perubahan cuaca -->
                                    <p class="card-text detail-change">
                                        Daily temperature difference:
                                        <b id="diff">
                                            <?=
                                                round($tempDiff, 2);  ?> C
                                        </b>
                                    </p>
                                </div>
                            </div>
                    <?php
                        }
                        $avgDiff = $avgDiff + $tempDiff;

                        // untuk menampilkan hasil perhitungan rata"
                        echo "<script>
                            var avgWeather = document.getElementById('avgWeather');
                            var avgDiff = document.getElementById('avgDiff');
                            avgWeather.innerHTML =" . round($avgTemp / 5) . ";
                            avgDiff.innerHTML =" . round($avgDiff / 5, 2) . ";
                        </script>";

                        if ($card == 5) //Jika sudah ada 5card (5 hari) -> break.
                            break;
                    } ?>
                </div>

                <!-- Button back untuk kembali ke halaman select city -->
                <a class="btn-danger back" href='javascript:history.back()'>
                    < Back </a> <p class="copyright" style="position: relative;">© Ventryshia Andiyani - ventry.shiandiyani@gmail.com</p>
                    <?php
                } else { //Jika belum memilih city
                    ?>

                        <h1> World Weather </h1>
                        <!-- Form select city -->
                        <form action="<?= site_url() ?>" class="form col-sm-12" method="GET">
                            <select name='city' required>
                                <option disabled selected value="">Select your city</option>
                                <?php
                                foreach ($city as $value) { ?>
                                    <option value="<?= $value ?>">
                                        <?= $value ?>
                                    </option>
                                <?php }
                                ?>
                            </select>
                            <input class="button" type="submit" value="See" />
                        </form>
                        <p class="copyright" style="position: absolute;">© Ventryshia Andiyani - ventry.shiandiyani@gmail.com</p>
                    <?php } ?>
        </div>
</body>

<footer>
</footer>

</html>