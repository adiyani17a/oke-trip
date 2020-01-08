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
use App\company;
use App\city;
use App\carousel;
use App\itinerary_additional;
use App\itinerary_destination;
use App\booking;
use App\booking_d;
use App\booking_pax;
use App\booking_additional;
use App\payment_history;
use App\payment_history_d;
use App\tokenManagement;
use App\blog;
use App\about;
use App\term_condition;

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

    public function company()
    {
        $company = new company();

        return $company; 
    }

    public function city()
    {
        $city = new city();

        return $city; 
    }

    public function carousel()
    {
        $carousel = new carousel();

        return $carousel; 
    }

    public function itinerary_additional()
    {
        $itinerary_additional = new itinerary_additional();

        return $itinerary_additional; 
    }

    public function itinerary_destination()
    {
        $itinerary_destination = new itinerary_destination();

        return $itinerary_destination; 
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

    public function booking_pax()
    {
        $booking_pax = new booking_pax();

        return $booking_pax; 
    }

    public function booking_additional()
    {
        $booking_additional = new booking_additional();

        return $booking_additional; 
    }

    public function payment_history()
    {
        $payment_history = new payment_history();

        return $payment_history; 
    }

    public function payment_history_d()
    {
        $payment_history_d = new payment_history_d();

        return $payment_history_d; 
    }

    public function token_management()
    {
        $token_management = new tokenManagement();

        return $token_management; 
    }

    public function blog()
    {
        $blog = new blog();

        return $blog; 
    }

    public function about()
    {
        $about = new about();

        return $about; 
    }

    public function term_condition()
    {
        $term_condition = new term_condition();

        return $term_condition; 
    }

    public function tes()
    {
        return $tes = new \App\tes();
    }

    public function log_itinerary()
    {
        return $log_itinerary = new \App\log_itinerary();
    }

    public function log_itinerary_detail()
    {
        return $log_itinerary_detail = new \App\log_itinerary_detail();
    }

    public function log_itinerary_schedule()
    {
        return $log_itinerary_schedule = new \App\log_itinerary_schedule();
    }

    public function log_itinerary_additional()
    {
        return $log_itinerary_additional = new \App\log_itinerary_additional();
    }

    public function log_itinerary_flight()
    {
        return $log_itinerary_flight = new \App\log_itinerary_flight();
    }

    public function log_itinerary_destination()
    {
        return $log_itinerary_destination = new \App\log_itinerary_destination();
    }
}
