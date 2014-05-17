<?php

class BaseForm extends Nette\Application\UI\Form
{
         public function PrevedDatum($datum)
    {
        $array = explode('.', $datum);
        $den = trim($array[0]);
        $mesic = trim($array[1]);
        $rok = trim($array[2]);
        
        $den = str_pad($den, 2, '0', STR_PAD_LEFT);
        $mesic = str_pad($mesic, 2, '0', STR_PAD_LEFT);
        $rok = str_pad($rok, 4, '0', STR_PAD_LEFT);
            
        $nove_datum = "$rok-$mesic-$den";
        return $nove_datum;
    }
}

?>
