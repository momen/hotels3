<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function searchHotel()
    {
        $city = (Input::get('city') != "") ? strip_tags(htmlentities(trim(stripslashes(Input::get('city'))))) : "";
        $name = (Input::get('name') != "") ? strip_tags(htmlentities(trim(stripslashes(Input::get('name'))))) : "";
        $price_min = (Input::get('price_min') != "") ? Input::get('price_min') : "";
        $price_max = (Input::get('price_max') != "") ? Input::get('price_max') : ""; 
        $date_from = (Input::get('date_from') != "") ? Input::get('date_from') : "";
        $date_to = (Input::get('date_to') != "")? Input::get('date_to') : "";
        $sort_type = (Input::get('sort_type') != "" && in_array(Input::get('sort_type'), ['price', 'name']) ) ? Input::get('sort_type') : "price"; 
        $sort_by = (Input::get('sort_by') != "" && in_array(Input::get('sort_type'), ['asc', 'desc'])) ? Input::get('sort_by') : "asc"; 

        $json = file_get_contents("https://api.myjson.com/bins/tl0bp");
        $data = json_decode($json);
        $hotels = $data->hotels;
        $name_ids = $destination_ids = $price_range_ids = $date_range_ids = $return_array = $response = $array_ids = array();

        $response['data'] = array();
        $response['status'] = "ok";
        $hotels = static::sortBy($sort_type, $hotels, $sort_by);

        if(count($hotels) > 0)
        {
            $array_ids = array_keys($hotels);
            if ($name != "")
            {
                $ids = static::getResultArray($hotels, "name", $name);
                $array_ids = array_intersect($array_ids, $ids);
            }
            if ($city != "")
            {
                $ids = static::getResultArray($hotels, "city", $city);
                $array_ids = array_intersect($array_ids, $ids);
            }
            if($price_min != "" && $price_max != "")
            {
                foreach($hotels as $hotel_id => $hotel)
                {
                    if($hotel->price >= $price_min && $hotel->price <= $price_max)
                    {
                        $ids[] = $hotel_id;    
                    }
                }
                $array_ids = array_intersect($array_ids, $ids);
            }
            if($date_to != "" && $date_from != "")
            {
                foreach($hotels as $hotel_id => $hotel)
                {
                    $date_range_id = false;
                    if(isset($hotel->availability))
                    {
                        foreach($hotel->availability as $date_range)
                        {
                            if(strtotime($date_range->from) <= strtotime($date_from) && strtotime($date_range->to) >= strtotime($date_to))
                            {
                                $date_range_id = true;    
                            }
                        }
                    }
                    $ids[] = ($date_range_id) ? $hotel_id : "";
                }
                $ids = array_unique($ids);
                $array_ids = array_intersect($array_ids, $ids);
            }
                
            $result_array = $array_ids;
            $result_array = array_flip($result_array);

            if(count($result_array) > 0)
            {
                foreach ($result_array as $key => $value) 
                {
                    if(isset($hotels[$key]))
                    {
                        $return_array[] = $hotels[$key]; 
                    }   
                }
            }
            $response['data'] = $return_array;
        }
        return response($response, 200);
    }

    static function sortBy( $field, &$array, $direction = 'asc')
    {
        usort($array, create_function('$a, $b', '
            $a = $a->'.$field.';
            $b = $b->'.$field.';

            if ($a == $b)
            {
                return 0;
            }

            return ($a ' . ($direction == 'desc' ? '>' : '<') .' $b) ? -1 : 1;
        '));
        return $array;
    }

    static function getResultArray($hotelArray, $param, $search_text)
    {
        $array = array();
        if(count($hotelArray) > 0)
        {
            foreach($hotelArray as $hotel_id => $hotel)
            {
                if ($search_text != "" && stripos($hotel->$param, $search_text) !== FALSE)
                {
                    $array[] = $hotel_id;
                }
            }
        }
        return $array;
    }

}
