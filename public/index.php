<?php
/**
 * Created by PhpStorm.
 * User: sarah
 * Date: 9/26/18
 * Time: 6:35 PM
 */

main::start("../FL_insurance_sample.csv");

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

        for($x=0;$x<count($records);$x++){
            $html .= html::tableRow($records[$x],$x);
        }

        $html .= '</table>'."\n";

        return $html;
    }

    static public function tableRow($row, $rowNum){
        $html="";

        if($rowNum%2==0){
            $html="<tr class=\"even\">";
        }
        else{
            $html="<tr class=\"odd\">";
        }

        if($rowNum>0){
            $html .= html::tableColumn($row);
        }
        else{
            $html .= html::tableHead($row);
        }

        $html .= '</tr>'."\n";

        return $html;
    }

    static public function tableColumn($row){
        $html="";

        $columns=explode(",",$row);

        for($z=0;$z<count($columns);$z++){
            $html .= "<td>"."\n";
            $html .= $columns[$z]."\n";
            $html .= "</td>"."\n";
        }

        return $html;
    }

    static public function tableHead($firstRow){
        $headings = explode(",", $firstRow);
        $html="";

        for ($y=0;$y<count($headings);$y++){
            $html .= "<th>"."\n";
            $html .= $headings[$y]."\n";
            $html .= "</th>"."\n";
        }

        return $html;
    }
}

class system{
    public static function printPage($page){
        echo $page;
    }
}

?>