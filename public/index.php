<?php
/**
 * Created by PhpStorm.
 * User: sarah
 * Date: 9/26/18
 * Time: 6:35 PM
 */

main::start("../FL_insurance_sample_small.csv");

class main{
    static public function start($filename){
        $records=csv::getRecords($filename);
        $page=html::createTable($records);
        system::printPage($page);
    }
}

class csv{
    public static function getRecords($fileName){
        $csvRaw=fopen($fileName, "r");

        $rowsRaw=array();

        while(!feof($csvRaw)){
            $nextRow=fgets($csvRaw);
            array_push($rowsRaw, $nextRow);
        }

        fclose($csvRaw);

        return $rowsRaw;
    }
}

class html{
    /**
     * @param $records
     * @return string
     */
    static public function createTable($records){
        $html = '<table>'."\n";
        $html .= html::tableRow($records);
        $html .= '</table>'."\n";

        return $html;
    }

    static public function tableRow($row){
        $html = '<tr>'."\n";
        $html .= html::tableColumn($row);
        $html .= '<tr>'."\n";

        return $html;
    }

    static public function tableColumn($column){
        $html = '<td>';
        $html .= $column;
        $html .= '<td>'."\n";

        return $html;
    }
}

class system{
    public static function printPage($page){
        echo $page;
    }
}

?>