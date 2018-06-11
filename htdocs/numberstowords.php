<?php

class NumbersToWords {

    private $hyphen = '-';
    private $conjunction = ' and ';
    private $separator   = ', ';

    private $list_singles = array('','one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen');                
    private $list_tens = array('','ten','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety','hundred');   
    private $list_thousands = array('','thousand','million','billion','trillion','quadrillion','quintillion','sextillion');

    //converts the dollars portion of the mumber into words
    private function convert_dollars($number) {
        //save original int number
        $number_int = (int)$number;

        //extract the whole numbers only (ie. excluding the cents) and convert to a string
        $number = (string)((int)$number_int);

        //check if number is a number
        if(ctype_digit($number)) {

            //stores the numbers in words grouped into lots of thousands
            $words = array();

            //determine the precision of the number
            $precision = strlen($number);

            //determine the number of levels required in the currency format (ie. levels between the commas, lots of thousands)
            //for example 1 comma has 2 levels to start off with, each level and each level includes 3 decimal precisions to left
            $levels = (int) (($precision+2)/3);

            //determine the absolute maximum number of precision based on the levels
            $max_precision = $levels * 3;

            //group the numbers into groups 3 numerical precision
            $number = substr('00'.$number , -$max_precision);
            $num_levels = str_split($number, 3); 

            //loop through each 
            foreach($num_levels as $num_part) {

                //extract the hundreds precision followed by tens and single
                $levels--;
                $hundreds = (int)($num_part/100);
                $hundreds = ($hundreds ? ' ' . $this->list_singles[$hundreds] . ' Hundred' . ' ' : '' );
                $tens = (int)($num_part % 100);
                $singles = '';

                //if number less than 20
                if($tens < 20) {
                    $tens = ( $tens ? ' ' . $this->list_singles[$tens] . ' ' : '' );
                } else {
                //number is greater than 20
                    $tens = (int) ( $tens / 10 );
                    $tens = $this->list_tens[$tens];
                    $singles = (int) ( $num_part % 10 );
                    $singles = $this->list_singles[$singles];
                }

                //put the words together including the thousand's plus precisions
                $words[] = $hundreds . (strlen($hundreds) && strlen($tens) ? $this->conjunction : '') . $tens . (strlen($singles)? $this->hyphen : '') . $singles . (($levels && (int) ( $num_part ) ) ? ' ' . $this->list_thousands[$levels] . ' ' : '');
            }

            //clean up and put words into grammically correct english
            $commas = count($words);
            $commas = ($commas > 1 ? $commas - 1 : $commas);
            $words  = implode($this->separator,array_filter($words));

            //Some finishing touch
            //Replacing multiples of spaces with one space
            $words  = trim(str_replace(' ,',',',$words),$this->separator);
            
            return $words . ' dollar' . ($number_int > 1 ? 's' : '');

        }
    }
    
    //converts the cents portion of the mumber into words
    private function convert_cents($number) {
        //convert input to float value
        $number = floatval($number);

        //extract the fraction / decimal portion (ie. cents) of the number - rounded up to 2 decimal places
        $number = round(($number - floor($number)) * 100);
        $tens = (int)($number % 100);

        //check if number is less 20
        if($number > 0 && $number < 20) {
            return $this->list_singles[$number] . ' cent' . ($number > 1 ? 's' : '');
        } elseif($number > 0 && $number < 100) {
             //ensure number is less than 100
            $tens = (int) ( $tens / 10 );
            $tens = ' ' . $this->list_tens[$tens];
            $singles = (int) ( $number % 10 );
            $singles = $this->list_singles[$singles];
            return $tens . (strlen($singles)? $this->hyphen : '') . $singles . ' cent' . ($number > 1 ? 's' : '');     
        } else {
            return '';
        }
    }

    //convert the number dollars and cents into words
    public function convert($number) {
        $value_dollars = $this->convert_dollars($number);
        $value_cents = $this->convert_cents($number);
        return $value_dollars . ($value_cents != '' ? $this->conjunction : '') . $this->convert_cents($number) . " only";
    }
}

?>