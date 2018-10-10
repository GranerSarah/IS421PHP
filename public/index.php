<?php
/**
 * Created by PhpStorm.
 * User: sarah
 * Date: 9/26/18
 * Time: 6:35 PM
 */

main::start("FL_insurance_sample.csv");

class main{
    static public function start($filename){

        $records=csv::getRecords($filename);
        $table=html::createTable($records);
    }
}

class csv{
    public static function getRecords($fileName){

        $csvRaw=fopen($fileName, "r");

        $columnNames=array();

        $records=array();

        $count=0;

        while(!feof($csvRaw)){

            $rowRaw=fgets($csvRaw);
            $nextRow=explode(",",$rowRaw);

            if($count==0){
                $columnNames=$nextRow;
            }else{
                $records[]=recordFactory::create($columnNames,$nextRow);
            }

            $count++;

        }

        fclose($csvRaw);

        return $records;
    }
}

class record{

    public function __construct(Array $fieldNames=null,$values=null){

        for($rowNum=0;$rowNum<count($values);$rowNum++){
            $cells=$values;
            for($cellNum=0;$cellNum<count($cells);$cellNum++){
                $this->createProperty($fieldNames[$cellNum],$cells[$cellNum]);
            }
        }

    }

    public function returnArray(){
        $array=(array) $this;
        return $array;
    }

    public function createProperty($name='columnName',$value='cellValue'){
        $this->{$name}=$value;
    }
}

class recordFactory{
    public static function create(Array $fieldNames=null, Array $values=null){

        $record=new record($fieldNames,$values);

        return $record;
    }
}

class html{
    /**
     * @param $records
     * @return string
     */
    static public function createTable($records)
    {

        echo("<table>");

        $count = 0;

        foreach ($records as $record) {

            $array=$record->returnArray();
            $values=array_values($array);

            if ($count == 0) {

                $headings=html::tableHead($values);
                print_r($headings);

            } else {
                $row=html::tableRow($values, $count);
                print_r($row);
            }
            $count++;
        }

        echo("</table>");
    }

    static public function tableHead(Array $headings=null){
        $row="<thead>\n<tr>\n";

        foreach($headings as $heading){
            $row.="<th>";
            $row.=$heading;
            $row.="</th>\n";
        }

        $row.="</tr>\n</thead>";

        return $row;

    }

    static public function tableRow(Array $values=null, $rowNum=0){

        $row="<tr>\n";

        if($rowNum%2==0){
            foreach($values as $cell){
                $row.=html::tableCellsEven($cell);
            }
        }else{
            foreach($values as $cell){
                $row.=html::tableCellsOdd($cell);
            }
        }

        $row.="</tr>\n";

        return $row;
    }

    static public function tableCellsEven($value=""){
        $cell="<td>";
        $cell.=$value;
        $cell.="</td>\n";

        return $cell;
    }

    static public function tableCellsOdd($value=""){
        $cell="<td style=\"background-color:coral;\">";
        $cell.=$value;
        $cell.="</td>\n";

        return $cell;
    }
}


?>