<?php

/*
 * Kaikki tietokantakyselyt ja yhteydenotto.
 */

if (!session_is_registered("käyttäjänimi")) {
    header("HTTP/1.1 403 Forbidden");
} else {
    $dbname = "keus";
    $user = "keus";
    $salasana = "a646a8dd503014f5";

    $GLOBALS['yhteys'] = pg_connect("dbname=$dbname user=$user password=$salasana");
    if ($GLOBALS['yhteys'] == FALSE) {
        echo "Tietokantayhteys epäonnistui!";
    }

    function select($mita, $mista, $miten) {
        $result = pg_query($GLOBALS['yhteys'], "SELECT $mita FROM $mista where $miten");
        $palautus = pg_fetch_all($result);
        return $palautus;
    }

    function selectorder($mita, $mista, $jarjestys) {
        $result = pg_query($GLOBALS['yhteys'], "SELECT $mita FROM $mista order by $jarjestys");
        $palautus = pg_fetch_all($result);
        return $palautus;
    }

    function delete($mista, $miten) {
        $kysely = pg_query($GLOBALS['yhteys'], "DELETE FROM $mista WHERE $miten");
    }

    function update($mita, $miten) {
        $kysely = pg_query($GLOBALS['yhteys'], "UPDATE $mita SET $miten");
    }

    function escape($string) {
        $palautus = pg_escape_string($GLOBALS['yhteys'], htmlspecialchars($string));
        return $palautus;
    }

    function insert($minne, $mita) {
        $kysely = pg_query($GLOBALS['yhteys'], "INSERT INTO $minne VALUES ($mita)");
    }

    /*
     * Tekee postgre muotosesta taulukosta php arrayn
     */

    function array_parse($text, &$output, $limit = false, $offset = 1) {
        $offset = 1;
        if (false === $limit) {
            $limit = strlen($text) - 1;
            $output = array();
        }
        if ('{}' != $text)
            do {
                if ('{' != $text{$offset}) {
                    preg_match("/(\\{?\"([^\"\\\\]|\\\\.)*\"|[^,{}]+)+([,}]+)/", $text, $match, 0, $offset);
                    $offset += strlen($match[0]);
                    $output[] = ( '"' != $match[1]{0} ? $match[1] : stripcslashes(substr($match[1], 1, -1)) );
                    if ('},' == $match[3])
                        return $offset;
                }
                else
                    $offset = pg_array_parse($text, $output[], $limit, $offset + 1);
            }
            while ($limit > $offset);
        return $output;
    }

}
?>
