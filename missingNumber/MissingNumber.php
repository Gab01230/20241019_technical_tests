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

class MissingNumber
{
    public function __construct(private readonly SplFileInfo $file, int $mode = 0) {}

    public function Main(): int
    {
        list(, $data) = explode("\n", file_get_contents($this->file->getRealPath()));

        $numbers = array_map('intval', explode(' ', $data));
        for ($i = 1; $i < count($numbers); ++$i) {
            $expected = $numbers[$i - 1] + 1;
            if ($expected !== $numbers[$i]) {
                return $expected;
            }
        }

        return -1;
    }
}

$o = new MissingNumber(new SplFileInfo($argv[1]));

echo $o->Main() . PHP_EOL;