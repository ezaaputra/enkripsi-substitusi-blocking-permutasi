<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Substitusi | Bloking Permutasi</title>
</head>
<body>

<div class="container">
<form method="POST" class="mt-5">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="plaintext">Plain Text</label>
            <input type="text" class="form-control" name="plaintext" id="plaintext">
        </div>
        <div class="form-group col-md-4">
            <label for="inputState">Metode</label>
            <select name="metode" id="inputState" class="form-control">
                <option selected value="encript">Encript</option>
                <option value="decript">Decript</option>
            </select>
        </div>
    </div>
    <button type="sumbit" name="submit" class="btn btn-info">Process</button>
</form>

<?php
// Substitusi
if (isset($_POST['submit'])) {
    $kalimat = $_POST['plaintext'];
    $metode = $_POST['metode'];

    if ($metode == "encript") {
        // echo "<b>Enkripsi Substitusi: </b>".substitusi($kalimat, $metode)."<br>";
        // echo "<b>Enkripsi Bloking: </b>".blok($kalimat, $metode)."<br>";
        // echo "<b>Enkripsi Permutasi: </b>".permutasi($kalimat, $metode)."<br>";
        $gabungan = substitusi(blok(permutasi($kalimat, $metode), $metode), $metode);
        echo "<b>Enkripsi Gabungan: </b>".str_replace(array('_'), '',$gabungan);
    } else {
        // echo "<b>Dekripsi Substitusi: </b>".substitusi($kalimat, $metode)."<br>";
        // echo "<b>Dekripsi Bloking: </b>".blok($kalimat, $metode)."<br>";
        // echo "<b>Dekripsi Permutasi: </b>".permutasi($kalimat, $metode)."<br>";
        $gabungan = permutasi(blok(substitusi($kalimat, $metode), $metode), $metode);
        echo "<b>Dekripsi Gabungan: </b>".str_replace(array('_'), '',$gabungan);
    }
}

function substitusi($plaintext, $method){
    $chr        = '!"#$%&\'()*+,-.0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
    $chrRandom  = 'G1Y}i|#7UQK:xSp%-Tb]hoE$jX&u<zl4=!\'{^BeZ6Dv89P)>.q*\f[H3W_cyrNCJ@"tn0aLkR(~;O?2g5,dmwM+FsAVI`';
    if ($method == "encript") {
        // Enkripsi
        $encript   = strtr($plaintext, $chr, $chrRandom);
        return $encript;
    }else {
        // Dekripsi
        $decript      = strtr($plaintext, $chrRandom, $chr);
        return $decript;
    }   
}

function blok($plaintext, $method){
    $x=array();
    $jumlahBlok=7;
    if ($method == "encript") {
        // Enkripsi
        for($i=0; $i<strlen($plaintext); $i++){
            $nomorBlok = $i%$jumlahBlok;
            $x[$nomorBlok] = (isset($x[$nomorBlok])?$x[$nomorBlok]:'').substr($plaintext,$i,1);
        }
        
        for ($i=0; $i < count($x); $i++) { 
            if (strlen($x[$i])<strlen($x[0])) {
                $x[$i] = $x[$i]."_";
            }
        }

        $encript = join('',$x);
        return $encript;
    }else {
        // Dekripsi
        for($i=0; $i<strlen($plaintext); $i++){
            $nomorBlok = $i%ceil(strlen($plaintext)/$jumlahBlok);
            $x[$nomorBlok] = (isset($x[$nomorBlok])?$x[$nomorBlok]:'').substr($plaintext,$i,1);
        }
        $decript = join('',$x);
        return $decript;
    }
    
}

function permutasi($plaintext, $method){
    $x=array();
    if ($method == "encript") {
        // Enkripsi
        $encript = "";
        for ($i=0; $i < ceil(strlen($plaintext)/6); $i++) { 
            $x[$i] = substr($plaintext,$i*6,6);

            $a = $x[$i];
            
            $a = substr_replace($a, substr($x[$i], 0, 1), 1, 1);
            $a = substr_replace($a, substr($x[$i], 1, 1), 0, 1);

            $a = substr_replace($a, substr($x[$i], 2, 1), 3, 1);
            $a = substr_replace($a, substr($x[$i], 3, 1), 2, 1);
    
            $a = substr_replace($a, substr($x[$i], 4, 1), 5, 1);
            $a = substr_replace($a, substr($x[$i], 5, 1), 4, 1);
            
            $encript .= $a;    
        }
        return $encript;
    }else {
        // Dekripsi
        $decript = "";
        for ($i=0; $i < ceil(strlen($plaintext)/6); $i++) { 
            $x[$i] = substr($plaintext,$i*6,6);

            $a = $x[$i];
            
            $a = substr_replace($a, substr($x[$i], 1, 1), 0, 1);
            $a = substr_replace($a, substr($x[$i], 0, 1), 1, 1);
    
            $a = substr_replace($a, substr($x[$i], 3, 1), 2, 1);
            $a = substr_replace($a, substr($x[$i], 2, 1), 3, 1);
    
            $a = substr_replace($a, substr($x[$i], 5, 1), 4, 1);
            $a = substr_replace($a, substr($x[$i], 4, 1), 5, 1);
            
            $decript .= $a;    
        }
        return $decript;
    }
}

?>
</div>

</body>
</html>

