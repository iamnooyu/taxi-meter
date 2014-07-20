<?php

class Calculate extends BaseController {
	public function calculatePrice()
	{
		$from = Input::get('from', "พาต้า");
		$to = Input::get('to', "เซนทรัล+ปิ่นเกล้า");
		$apiKey = "YOUR API KEY"; // Need to Enable Distance Matrix API on Google Maps API
		$taxiFare = 0;

		$location = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".str_replace(' ', '+', $from)."&destinations=".str_replace(' ', '+', $to)."&mode=driving&key=".$apiKey;

		$json = file_get_contents($location);
		$obj = json_decode($json);

		$distance = $obj->rows[0]->elements[0]->distance->value;

		// Calculate Price

		$distanceKm = $distance / 1000;

		if ($distanceKm <= 1)
			$taxiFare = 35;
		else if  ($distanceKm <=12)
			$taxiFare = 35 + ($distanceKm - 1)*5;
		else if ($distanceKm <=20)
			$taxiFare = 90 + ($distanceKm - 12)*5.5;
		else if ($distanceKm <=40)
			$taxiFare = 134 + ($distanceKm - 20)*6;
		else if ($distanceKm <=60)
			$taxiFare = 254 + ($distanceKm - 40)*6.5;
		else if ($distanceKm <=60)
			$taxiFare = 384 + ($distanceKm - 60)*7.5;
		else 
			$taxiFare = 534 + ($distanceKm - 80)*8.5;

		$taxiFare = round($taxiFare);

		return View::make('result',array('from' => $from, 'to' => $to, 'price' => $taxiFare));
	}
}