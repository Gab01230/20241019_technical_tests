<?php

/*

Une chaîne de 100 caractères maximum contenant uniquement des lettres de l'alphabet anglais vous est proposée. Une chaîne qui apparait au moins 2 fois à la suite est appelée un bloc de répétition.

L’objectif est d’écrire un algorithme capable de déterminer le bloc de répétition le plus long (un bloc est une chaîne composée de 2 lettres différentes ou plus).

Nous partons du principe que chaque chaîne comporte un bloc de répétition et qu’il n’y a qu’un seul bloc de répétition le plus long.

Entrée : chaîne contenant une phrase.
Sortie : chaîne contenant le plus long bloc de répétition.

Le code donné prend en entrée un fichier contenant les paramètres et renvoie les résultats comme dans le fichier de sortie.
Le résultat de sortie doit être affiché avec un caractère de retour à la ligne à la fin (cf le code donné).

Exemples : Pour la chaîne "tototoday", la sortie est "tototo".
Pour la chaîne "liveiveive tomomorrow", la sortie est "iveiveive".

Le fichier RepetitionGame.input contient un exemple de jeu de données
Le fichier RepetitionGame.php est le fichier php à compléter

*/

/**
 * Au vu de l'énoncé, j'aurais mis plus "rr" en réponse plutôt que iveiveive. 
 * Il manque une solution plus complète (exemple iviviviviv)
 * La solution demande une récursive, mais je ne suis pas à l'aise avec le sujet. A bosser!
 */

class RepetitionGame{
    public function __construct($file) {
        $this->input_filename = $file;
    }

    public function Main() {
        $data = $this->readString();
        $text = $data[0];

        $result = "";

        /* 
        * Le code à mettre ici
        */

        try {
            $this->validateInputString($text);

            $text = $this->formateInputString($text);

            $result = array_unique($this->findBiggestRepeatedString($text));

            return $this->findLonguestRepeatitionInARow($result, $text);
            
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        
        return $result;
    }

    public function findBiggestRepeatedString($inputString): array {
        $maxLengthNeedle = floor(strlen($inputString) / 2);

        $repeatitions = [];
        
        // from floor of total lenght divided per 2, we'll check if the string is repeated
        // first found wins
        while ($maxLengthNeedle > 0) {
            $offset = 0;
            
            while($offset < strlen($inputString)) {
                $needle = substr($inputString, $offset, $maxLengthNeedle);

                if (strlen($needle) < $maxLengthNeedle) {
                    break;
                }

                if (substr_count($inputString, $needle) > 1) {
                    $repeatitions[] = $needle;
                    //return $needle;
                }

                $offset++;
            }
            if (count($repeatitions) > 0) {
                return $repeatitions;
            }

            $maxLengthNeedle--;
        }

        return [];

    }

    public function findLonguestRepeatitionInARow(array $repeatedStrings, $inputString): string 
    {
        $max = 0;

        // we'll keep first repeatition per default
        $longestRepeatition = $repeatedStrings[0];

        foreach ($repeatedStrings as $needle) {
            $actualRepeatation = $needle;
            $maxRepeatitionPossible = floor(strlen($inputString)/strlen($needle));

            for ($i=0; $i < $maxRepeatitionPossible; $i++) {
                $actualRepeatation = $actualRepeatation.$needle;

                while (strlen($actualRepeatation) < strlen($longestRepeatition)) {
                    $actualRepeatation = $actualRepeatation.$needle;
                }

                if (strpos($inputString, $actualRepeatation) === false) {
                    break;
                }

                $longestRepeatition = $actualRepeatation;
            }
        }

        return $longestRepeatition;
    }

    public function validateInputString(string $inputString): void
    {
        if(!preg_match("/^[a-z\s]+$/", $inputString )) {
            throw new Exception("Input string should only contain letters from a to z and spaces");
        }

        if(strlen($inputString) > 100 ) {
            throw new Exception("Input string should not contain more than 100 chars");
        }
    }

    /**
     * Delete all non repeated characters
     */
    public function formateInputString(string $inputString): string 
    {
        $lowerCaseLetterAndSpaceArray = str_split('abcdefghijklmnopqrstuvwxyz ');

        foreach ($lowerCaseLetterAndSpaceArray as $char) {
            if (substr_count($inputString, $char) < 2) {
                $inputString = str_replace($char, '', $inputString);
            }
        }

        return $inputString;
    }


    public function readString(){
        $file = fopen($this->input_filename, "r");
        $line = array();

        while (!feof($file)){
            array_push($line, str_replace(PHP_EOL, "", fgets($file)));
        }

        return $line;
    }
}

$o = new RepetitionGame($argv[1]);

echo $o->Main() . PHP_EOL;
