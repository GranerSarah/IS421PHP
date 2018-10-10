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

            $nextRow=fgetcsv($csvRaw);

            if($count==0){
                $fieldNames=$nextRow;
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
        $record=array_combine($fieldNames, $values);

        foreach($record as $property => $value){
            $this->createProperty($property,$value);
        }

    }

    public function createProperty($name='columndName',$value='cellValue'){
        $this->{$name}=$value;
    }
}

class recordFactory{
    public static function create(Array $fieldNames=null,Array$values=null){
        $record=new record($fieldNames,$values);

        return $record;
    }
}

class html{
    /**
     * @param $records
     * @return string
     */
    static public function createTable($records){

        $count=0;

        foreach($records as $record){

            if($count==0){

                $array=$record->returnArray();
                $fields=array_keys($array);
                $values=array_values($array);
                print_r($fields);
                print_r($values);
            }
            else{
                $array=$record->returnArray();
                $values=array_values($array);
                print_r($values);
            }
            $count++;
        }
    }
}

class system{
    public static function printPage($page){
        echo $page;
    }
}

?>