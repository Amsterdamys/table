<?php

class ShowTable{

    /**
     * name of file with json
     */
    const FILENAME = 'data.json';

    /**
     * @var null
     * containter for php array with data
     */
    private $data = null;

    public function __construct(){
        if($this->checkFile() === false){
            exit('File does not exist!');
        }

        $this->getData();

        return false;
    }

    /**
     * @return string
     * shows table with data
     */
    public function show(){
        $table  = $this->genereteHead(array_shift($this->data));

        $table .= $this->genereteBody($this->data);

        return $this->getWrapper($table);
    }

    /**
     * checks and gets data
     */
    private function getData(){
        $data  = file_get_contents(self::FILENAME);

        $this->data = json_decode($data, true);

        if(!is_array($this->data)) exit('Json format is incorrect');
    }

    /**
     * @return bool
     * checks the file for existence
     */
    public function checkFile(){
        if(!file_exists(self::FILENAME)) return false;

        return true;
    }

    /**
     * @param $data
     * @return string
     * generates html structure of head
     */
    private function genereteHead($data){
        $str = "<thead>".$this->getTr($data, 'th')."</thead>";

        return $str;
    }

    /**
     * @param $data
     * @return string
     * generates html structure of body
     */
    private function genereteBody($data){

        $tbody = '<tbody>';

        foreach ($data as $v) {
            $tbody .= $this->getTr($v);
        }
        $tbody .= '</tbody>';

        return $tbody;
    }

    /**
     * @param $data
     * @return string
     * gets tr
     */
    private function getTr($data, $tag = 'td'){
        return "<tr>
                    <$tag>$data[0]</$tag>
                    <$tag>$data[1]</$tag>
                    <$tag>$data[2]</$tag>
                </tr>
                ";
    }

    /**
     * @param $data
     * @return string
     * gets wrapper of table
     */
    private function getWrapper($data){
        return "<table>$data</table>";
    }

}

$show = new ShowTable();

echo $show->show();
