<?php

namespace Calendar\Http;

use Calendar\DataLayer\LeapYear;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController
{

    public function indexAction(Request $request, $year)
    {
        $leapyear = new LeapYear();
        if ($leapyear->isLeapYear($year)) {
            return new Response('Yep, leap year');
        }

        return new Response('Nah, not a leap year');
    }
}