<?php

class PhoneKeyboardConverter
{
    /**
     * Ta funkcja zmienia łańcuch znaków na ciąg numeryczny
     *  zgodny z klawiaturą telefonu.
     * @param $input string łańcuch znaków A-Z lub ' '
     * @return string ciąg numeryczny
     */
    function convertToNumeric(string $input): string
    {
        $result = '';
        // Niemożliwe jest przetłumaczenie pustego ciągu
        if(empty($input)) {
            return $result;
        }
        $input = strtoupper($input);
        for($i = 0; $i < strlen($input); $i++) {
            // Ponieważ ' ' w ASCII nie należy do przedziału A-Z musi
            // mieć swój własny przypadek
            if($input[$i] == ' ') {
                $result .= '0,';
            } else {
                $result .= $this->convertSingleCharToNumeric($input[$i]) . ',';
            }

        }
        // Usuwamy ostatni przecinek
        return substr($result, 0, -1);
    }

    /**
     *  Ta funkcja zmienia ciąg numeryczny odpowiadający
     *  klawiaturze telefonu na łańcuch znaków.
     * @param $input string ciąg numeryczny 2,22,222,3 itd. do 999 lub '0'
     * @return string łańcuch znaków
     */
    function convertToString(string $input): string
    {
        $result = '';
        // Niemożliwe jest przetłumaczenie pustego ciągu
        if(empty($input)) {
            return $result;
        }
        $chars = preg_split("/,/", $input);
        for($i = 0; $i < count($chars); $i++) {
            // Przypadek '0' nie pasuje do wzoru dla innych znaków
            if($chars[$i] == '0') {
                $result .= ' ';
            } else {
                /*
                * Zakładamy że dane są poprawne i nie występują kombinacje 123, 112 itd.
                * Mnożąc pierwszą cyfrę znaku pomniejszoną o 2 przez 3 daje nam początek przedziału znaków
                * na przykład A,B,C -> 0, D,E,F -> 3. Dodając liczbę powtórzeń cyfr - 1, otrzymujemy numer litery
                * A -> 0, B -> 1 itd. Dodając wartość ASCII 'a' otrzymujemy numer ASCII.
                */
                $cur = (intval($chars[$i][0]) - 2 )* 3 + strlen($chars[$i]) - 1 + ord("a");
                // "7777" i "8" mapują na 's', dlatego dodanie 1 do wartości ASCII znaków od "8" naprawia formułę.
                if($chars[$i] == "8" or $cur > ord('s')) {
                    $result .= chr($cur  + 1);
                } else {
                    $result .= chr($cur );
                }

            }

        }
        return $result;

    }

    /**
     *  Ta funkcja zmienia pojedyńczy znak
     *  w jego odpowiednik numeryczny.
     * @param $input string znak od A do Z
     * @return string odpowiednik numeryczny
     */
    private function convertSingleCharToNumeric(string $input): string
    {
        $input = strtoupper($input);
        // Zamiana numeru znaku na liczbę A -> 0, B -> 1 itd.
        $num_val = ord($input) - ord('A');
        if(ord($input) <= ord('R')) {
            /* Dla znaku wcześniejszego od 'R' można znaleźć jego wartość numeryczną przez podzielenie jego numeru
            * przez 3 i dodanie 2, gdyż pomijamy przyciski 0 i 1
            * Ilość naciśnięć można poza wyjątkami znaleźć wykorzystując resztę z dzielenia przez 3 + 1.
            */
            return str_repeat(strval(intval($num_val/3 + 2)), $num_val % 3 + 1);
        } elseif($input == 'S') {
            return "7777";
        } elseif ($input == "Z") {
            return "9999";
        } else {
            // Pomijając przypadek "7777" odejmujemy 1 od wartości numerycznej, przez co poprzednia formuła działa
            return str_repeat(strval(intval(($num_val - 1)/3 + 2)), ($num_val - 1) % 3 + 1);
        }

    }

}