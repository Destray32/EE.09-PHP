<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wzór BMI</title>
    <link rel="stylesheet" href="styl3.css">
</head>
<body>
<?php
    if(isset($_POST["waga"]) && isset($_POST["wzrost"]))
    {
        $waga = $_POST["waga"];
        $wzrost = $_POST["wzrost"];
        $wskaznikBmi = ($waga / ($wzrost*$wzrost)) * 10000;    
    }
    else
        ;
    
    $polaczenie = mysqli_connect('localhost', 'root', '', 'egzamin');

    if(!$polaczenie)
        print("Blad z polaczeniem do bazy!");

    $zapytaniePierwsze = mysqli_query($polaczenie, "SELECT informacja, wart_min, wart_max FROM bmi;")
?>

<div>
    <div class="logo">
        <img src="wzor.png" alt="wzór BMI" srcset="">
    </div>

    <div class="baner">
        <h1>Oblicz swoje BMI</h1>
    </div>
</div>

<div style="clear: both;"></div>

    <div class="blok-glowny">
        <table>
            <tr>
                <th>Interpretacja BMI</th>
                <th>Wartość minimalna</th>
                <th>Wartosc maksymalna</th>
            </tr>
            <?php
                while ($wynik = mysqli_fetch_array($zapytaniePierwsze))
                {
                    echo "<tr><td>".$wynik["informacja"]."</td><td>".$wynik["wart_min"]."</td><td>".$wynik["wart_max"]."</td></tr>";
                }
            ?>
        </table>
    </div>

<div>
    <div class="blok-lewy">
        <h2>Podaj wagę i wzrost</h2>
        <form action="bmi.php" method="post">
            Waga:<input type="number" name="waga" id="" min="1">
            <br>
            Wzrost w cm:<input type="number" name="wzrost" id="" min="1">
            <input type="submit" value="Oblicz i zapamiętaj wynik">
        </form>
        <?php
            if(isset($_POST["waga"]) && isset($_POST["wzrost"]))
            {
                echo "Twoja waga: ".$waga."; Twoj wzrost: ".$wzrost."<br>";
                echo "BMI wynosi: ".$wskaznikBmi;
                $stan = 0;
                switch ($wskaznikBmi) {
                    case $wskaznikBmi<19:
                        $stan = 0;
                        break;
                    
                    case $wskaznikBmi>=19 && $wskaznikBmi<=25:
                        $stan = 1;
                        break;
                    
                    case $wskaznikBmi>=26 && $wskaznikBmi<=30:
                        $stan = 2;
                        break;

                    case $wskaznikBmi>=31 && $wskaznikBmi<=100:
                        $stan = 3;
                        break;
                }
                
                $data = date("Y-m-d");
                $zapytanieDwa = mysqli_query($polaczenie, "INSERT INTO `wynik`(`id`, `bmi_id`, `data_pomiaru`, `wynik`) VALUES (NULL, $stan, '$data', $wskaznikBmi);");
                if (!$zapytanieDwa)
                    echo "Blad przy dodawaniu do bazy danych";
            }
            else
                ;
        ?>
    </div>

    <div class="blok-prawy">
        <img src="rys1.png" alt="ćwiczenia" srcset="">
    </div>
</div>

<div style="clear: both;"></div>

    <footer>
        Autor: 00000000000
        <a href="kwerendy.txt">Zobacz kwerendy</a>
    </footer>

    <?php
        mysqli_close($polaczenie);  ###zamkniecie polaczenia
    ?>
</body>
</html>