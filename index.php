<?php
    $errors = ["distance"=>""];
    $distance = "";
    $difficulty = ["ver", "zwaar", "moeilijk"];
    $difficulty = $difficulty[array_rand($difficulty)];
    $mi = "";
    $km = "";

    if(count($_POST) > 0){

        if(!isset($_POST["distance"])){
            $errors["distance"] = "Er liep iets mis bij het versturen van de afstand.";
        } else {
            $distance = $_POST["distance"];
            if(empty(trim($distance))){
                $errors["distance"] = "Gelieve een afstand op te geven.";
            } else if(strlen(trim($distance)) < 3){
                $errors["distance"] = "De afstand moet uit minstens 3 tekens bestaan.";
            } else {
                $input = trim($distance);
                $unit = strtolower(substr($input, -2));
                $number = substr($input, 0, -2);
                if(!is_numeric($number)){
                    $errors["distance"] = "De afstand moet een geldig getal bevatten.";
                } else {
                    if($unit == "km"){
                        $km = floatval($number);
                        $mi = round($km * 0.621371, 2);
                    } else if($unit == "mi"){
                        $mi = floatval($number);
                        $km = round($mi * 1.60934, 2);
                    } else {
                        $errors["distance"] = "Gebruik km of mi als eenheid.";
                        
                    }
                }
            }
        }
        if(empty(join("", $errors))){
            echo "De opgegeven afstand is ".$km." km of ".$mi." mi.<br>";
            if($km > 30){
                echo "Deze afstand fiets ik niet, het is te ".$difficulty.".";
           }
        }
    }
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afstand</title>
    <style>
        label {
            display: inline-block;
            width: 60px;
        }
        input {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form method="POST" novalidate>
        <label for="distance">Afstand:</label><input type="text" name="distance" id="distance" value="<?php echo $distance;?>">
        <?php echo "<span style='color: red;'>".$errors["distance"]."</span>";?><br>

        <input type="submit" value="bereken">
    </form>
</body>
</html>