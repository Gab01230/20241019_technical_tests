<?php

/*

Étant donné un vecteur contenant n nombres dans l'ordre croissant, trouvez le nombre manquant.
On suppose qu’il y a un seul nombre manquant.

Input : un nombre entier n > 0, un tableau inputVector[n].
Output : le nombre manquant.

Le code donné prend en entrée un fichier contenant les paramètres et renvoie les résultats comme dans le fichier de sortie.
Le résultat de sortie doit être affiché avec un caractère de retour à la ligne à la fin (cf le code donné).

Exemples :
Pour n = 5 et inputVector = [1, 2, 3, 4, 6], le résultat est 5.
Pour n = 20 et inputVector = [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20], le résultat est 3.

Le fichier MissingNumber.input contient un exemple de jeu de données
Le fichier MissingNumber.php est le fichier php à compléter

*/

class MissingNumber{
    public function __construct($file) {
        $this->input_filename = $file;
    }

    public function Main() {
        $data = $this->readString();
        $n = $data[0];
        
        $result = "";
        $inputVector = explode(" ", $data[1]);

        /* 
        * Le code à mettre ici
        */

        $inputVectorSum = $this->getActualSum($inputVector);

        $result = $this->getTheoricalSum($n, $inputVector[0]) - $inputVectorSum;

        return $result;
    }

    /**
     * Calculate the sum of the input vector for n+1 numbers in a row
     * starting from the first number given in the input vector
     */
    public function getTheoricalSum($givenArrayLength, $firstNumber): int
    {
        $res = $firstNumber;

        for($i = 0; $i < $givenArrayLength; $i++ ) {
            $firstNumber++;
            $res += $firstNumber;
        }

        return $res;
    }

    /**
     * calculate the sum of the input vector numbers
     */
    public function getActualSum(array $givenArray): int
    {
        $res = 0;
        for ($i = 0; $i < count($givenArray); $i++) {
            $res += $givenArray[$i];
        }

        return $res;
    }

    public function readString() {
        $file = fopen($this->input_filename, "r");

        if (!$file) {
            throw new Exception("File not found (404)", 1);
        }

        $line = array();

        while (!feof($file)){
            array_push($line, str_replace(PHP_EOL, "", fgets($file)));
        }

        return $line;
    }
}

$o = new MissingNumber($argv[1]);

echo $o->Main() . PHP_EOL;