<?php declare(strict_types = 1);

class Import extends DBH
{

    public function upload($params)
    {


        $getfile=$params.".csv";
        // echo $getfile;
        return $this->getcsvcontent($getfile);
    }

    private function checkfile($params)
    {
        $csv_value=false;
        if(strpos($params, '.csv') !== false) {
            $csv_value = true;
        }
        return $csv_value;
    }

    private function checkcurrency($params)
    {
        return $this->getcurrency($params);
    }

    private function getcsvcontent($params)
    {
        $response = array();
        if($this->checkfile($params)) {
            
            if (($handle = fopen($params, "r")) !== FALSE) {

                $i=0;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    
                    if($i!=0) {
                       
                        $results = $this->createupdate($data); 
                        $response[]=$results;
                    }
                    
                    $i++;
                }

              fclose($handle);
            }
        }
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }

}