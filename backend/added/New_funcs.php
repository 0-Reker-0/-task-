<?php
/**
 * New_funcs this is a class developed according to technical specifications
 */
class New_funcs
{
    /**
     * select_cars() This function calculates the cost of additional 
     * services and initializes the calculation of the car rental price car_price()
     * @param object $db database class object for queries within the class without initializing new connections
     * @param array $data data received from the user
     * @return int final price
     */
    public static function select_cars(object $db, array $data):int
    {
        $val = 0;
        foreach($data as $key => $record){
            if($key != 'product' && $key != 'dayImput')
                $val += intval($record);
        }
        $query = $db->mselect_rows('a25_products', ['ID' => $data['product']], 0, 1, 'id');
        $car = self::car_price($query, $data['dayImput']);
        $val += $car;
        
        return $val;
    }
    /**
     * car_price() function calculates the cost of the car based on the data received from the database
     * @param array $query given obtained from the database
     * @param int $day days entered by the user
     * @return int of the received price, or the default price value
     */
    private static function car_price(
        array $query,
        int $day
    ):int
    {
        $tarif = $query[0]['TARIFF'];
        if($tarif == false)
            return intval($query[0]['PRICE']);
        $car = unserialize($query[0]['TARIFF']);
        foreach($car as $arend => $int){
            if($arend>=$day){
                return $int;
            }
        }
        return intval($query[0]['PRICE']);
    }
}
