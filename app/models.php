<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\destination;
use App\groupMenu;
use App\menuList;
use App\privilege;
use App\role;
use App\User;
use App\additional;
use App\itinerary;
use App\itinerary_detail;
use App\itinerary_flight;
use App\itinerary_schedule;
use App\tour_leader;
use App\booking;
use App\booking_d;
use App\booking_additional;

class models extends Model
{
    public function destination()
    {
    	$destination = new destination();

    	return $destination; 
    }

    public function groupMenu()
    {
    	$groupMenu = new groupMenu();

    	return $groupMenu; 
    }

    public function menuList()
    {
    	$menuList = new menuList();

    	return $menuList; 
    }

    public function privilege()
    {
    	$privilege = new privilege();

    	return $privilege; 
    }

    public function role()
    {
        $role = new role();

        return $role; 
    }

    public function user()
    {
        $user = new User();

        return $user; 
    }

    public function additional()
    {
        $additional = new additional();

        return $additional; 
    }

    public function itinerary()
    {
        $itinerary = new itinerary();

        return $itinerary; 
    }

    public function itinerary_detail()
    {
        $itinerary_detail = new itinerary_detail();

        return $itinerary_detail; 
    }

    public function itinerary_flight()
    {
        $itinerary_flight = new itinerary_flight();

        return $itinerary_flight; 
    }

    public function itinerary_schedule()
    {
        $itinerary_schedule = new itinerary_schedule();

        return $itinerary_schedule; 
    }

    public function tour_leader()
    {
        $tour_leader = new tour_leader();

        return $tour_leader; 
    }

    public function booking()
    {
        $booking = new booking();

        return $booking; 
    }

    public function booking_d()
    {
        $booking_d = new booking_d();

        return $booking_d; 
    }

    public function booking_additional()
    {
        $booking_additional = new booking_additional();

        return $booking_additional; 
    }
}
