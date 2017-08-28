<?php

namespace Tests;

use Tests\TestCase;

class Tracking extends TestCase
{
    /** @test */
    public function search_hotel_by_all()
    {
        $response = $this->get('hotel-search?city=a&name=Hotel&price_min=50&price_max=120&date_from=10-10-2020&date_to=15-10-2020&sort_type=price&sort_by=asc');

        $response->assertStatus(200);
    }

    /** @test */
    public function search_hotel_by_none()
    {
        $response = $this->get('hotel-search?city=a&name=Hotel&price_min=50&price_max=120&date_from=10-10-2020&date_to=15-10-2020&sort_type=price&sort_by=asc');

        $response->assertStatus(200);
    }

    /** @test */
    public function search_hotel_by_city()
    {
        $response = $this->get('hotel-search?city=a');

        $response->assertStatus(200);
    }

    /** @test */
    public function search_hotel_by_hotelname()
    {
        $response = $this->get('hotel-search?name=Hotel');

        $response->assertStatus(200);
    }

    /** @test */
    public function search_hotel_by_price()
    {
          $response = $this->get('hotel-search?price_min=50&price_max=120');

        $response->assertStatus(200);
    }

    /** @test */
    public function search_hotel_by_date()
    {
        $response = $this->get('hotel-search?date_from=10-10-2020&date_to=15-10-2020');

        $response->assertStatus(200);
    }

    /** @test */
    public function sort_hotel_by_hotelname()
    {
        $response = $this->get('hotel-search?sort_type=name&sort_by=asc');

        $response->assertStatus(200);
    }

    /** @test */
    public function sort_hotel_by_price()
    {
        $response = $this->get('hotel-search?sort_type=price&sort_by=asc');

        $response->assertStatus(200);
    }
}