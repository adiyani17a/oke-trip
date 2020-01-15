
<style type="text/css">
	.invoice-box table tr.information table td {
	  padding-bottom: 40px;
	}

	.invoice-box table tr.heading td {
	  background: #eee;
	  border-bottom: 1px solid #ddd;
	  font-weight: bold;
	}

	.invoice-box table tr.details td {
	  padding-bottom: 20px;
	}

	.invoice-box table tr.item td {
	  border-bottom: 1px solid #eee;
	}

	.invoice-box table tr.item.last td {
	  border-bottom: none;
	}

	.invoice-box table tr.item input {
	  padding-left: 5px;
	}

	.invoice-box table tr.item td:first-child input {
	  margin-left: -5px;
	  width: 100%;
	}

	.invoice-box table tr.total td:nth-child(2) {
	  border-top: 2px solid #eee;
	  font-weight: bold;
	}

	.invoice-box input[type="number"] {
	  width: 60px;
	}

	@media only screen and (max-width: 600px) {
	  .invoice-box table tr.top table td {
	    width: 100%;
	    display: block;
	    text-align: center;
	  }

	  .invoice-box table tr.information table td {
	    width: 100%;
	    display: block;
	    text-align: center;
	  }
	}

	.border{
		border: 1px solid #9f9f9f;
	}

	.border-x{
		border-left: 1px solid #9f9f9f;
		border-right: 1px solid #9f9f9f;
	}

	.border-l{
		border-left: 1px solid #9f9f9f;
	}

	.border-r{
		border-right: 1px solid #9f9f9f;
	}

	.border-y{
		border-top: 1px solid #9f9f9f;
		border-bottom: 1px solid #9f9f9f;
	}

	.border-t{
		border-top: 1px solid #9f9f9f;
	}

	.border-b{
		border-bottom: 1px solid #9f9f9f;
	}

	.px-2{
		padding-left: 0.5rem; 
		padding-right: 0.5rem;
	}

	.py-2{
		padding-top: 0.5rem; 
		padding-bottom: 0.5rem;
	}

	.text-center{
		text-align: center;
	}

	th{
		text-align: center;
	}
</style>
<div class="invoice-box" style="margin-bottom: 10px;">
	@php
		if ($data->itinerary_detail->tour_leader != null) {
			$count = 2;
		}else{
			$count = 1;
		}

		$single = 0;
		$double = 0;
		$twin = 0;
		$triple = 0;
		$doubleCnB = 0;
		$doubleCwB = 0;
		$adult = 0;
		$infant = 0;
		$child = 0;
	@endphp
	@if ($data->itinerary_detail->tour_leader != null)
		@php
			$single+=1;
		@endphp
		<tr class="border" style="background-color: yellow;">
			<img style="width: 150px;height: 75px" src="{{ asset($data->itinerary_detail->tour_leader->image) }}">
		</tr>
	@endif
	@foreach($data->itinerary_detail->booking as $i => $d)
		@foreach($d->booking_d as $i1 => $d1)
			@foreach($d1->booking_pax as $i2 => $d2)
				<div style="display: inline-block;width: 30%;padding: 10px;">
					<img style="width: 150px;height: 75px" src="{{ asset($d2->passport_image) }}">
				</div>
			@endforeach
		@endforeach
	@endforeach
</div>
