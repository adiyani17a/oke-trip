
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
	<table cellpadding="0" cellspacing="0" style="width: 100%;font-size: 10px;">
		<tr class="top">
			<td colspan="7">
				<table>
					<tr>
						<td class="title">
							<img src="http://panel.oke-trip.com/dist/img/logo.png" style="width:200px; max-width:200px;">
						</td>
						<td>

						</td>
					</tr>
				</table>
			</td>
			<td colspan="3" style="text-align: right;">
				<label>Flight Date</label>
				<p>{{ carbon\carbon::parse($data->itinerary_detail->start)->format('d-F-Y') }} - {{ carbon\carbon::parse($data->itinerary_detail->end)->format('d-F-Y') }}</p>
				<p>{{ $data->itinerary_code }}</p>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: left;">
				<label>Flight Details :</label>
				<p style="color: hotpink">{!! $data->flight_detail !!}</p>
			</td>
		</tr>
		<tr class="heading">
			<th rowspan="2" class="px-2 py-2 border">No</th>
			<th rowspan="2" class="px-2 py-2 border">Name</th>
			<th rowspan="2" class="px-2 py-2 border">Gender</th>
			<th rowspan="2" class="px-2 py-2 border">Room Type</th>
			<th colspan="3" class="px-2 py-2 border">Passport</th>
			<th colspan="2" class="px-2 py-2 border">Birth</th>
			<th rowspan="2" class="px-2 py-2 border">CP</th>
		</tr>
		<tr class="heading">
			<th class="px-2 py-2 border" width="10%">Number</th>
			<th class="px-2 py-2 border">Issued</th>
			<th class="px-2 py-2 border">Expired</th>
			<th class="px-2 py-2 border">Place</th>
			<th class="px-2 py-2 border">Date</th>
		</tr>
		@php
			$count = 1;
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
		@foreach($data->itinerary_detail->booking as $i => $d)
			<tr>
				<td class="px-2 py-2 border" style="background-color: #efef;" colspan="10">
					Booking Code : {{ $d->kode }}
				</td>
			</tr>
			@foreach($d->booking_d as $i1 => $d1)
				@php
					if ($d1->bed == 'Single Bed') {
						$single += 1;
					}else if($d1->bed == 'Double Bed'){
						$double += 1;
					}else if($d1->bed == 'Twin Bed'){
						$twin += 1;
					}else if($d1->bed == 'Triple Bed'){
						$triple += 1;
					}else if($d1->bed == 'Double/Twin + CnB'){
						$doubleCnB += 1;
					}else if($d1->bed == 'Double/Twin + CwB'){
						$doubleCwB += 1;
					}
				@endphp
				@foreach($d1->booking_pax as $i2 => $d2)
					<tr class="border">
						<td  class="text-center px-2 py-2 border-l @if(count($d1->booking_pax)-1 == $i2) border-b @endif">{{ $count }}</td>
						<td  class="px-2 py-2 @if(count($d1->booking_pax)-1 == $i2) border-b @endif">{{ $d2->name }}</td>
						<td  class="px-2 py-2 @if(count($d1->booking_pax)-1 == $i2) border-b @endif">{{ ucwords($d2->gender) }}</td>
						@if($i2 == 0)
						<td  class="px-2 py-2 border-b" rowspan="{{ count($d1->booking_pax) }}">{{ ucwords($d1->bed) }}</td>
						@endif
						<td  class="px-2 py-2 @if(count($d1->booking_pax)-1 == $i2) border-b @endif">
							{{ $d2->passport }}
						</td>
						<td  class="px-2 py-2 @if(count($d1->booking_pax)-1 == $i2) border-b @endif">
							{{ $d2->issuing }}
						</td>
						<td  class="px-2 py-2 @if(count($d1->booking_pax)-1 == $i2) border-b @endif">
							{{ carbon\carbon::parse($d2->exp_date)->format('d-M-y') }}
						</td>
						<td  class="px-2 py-2 @if(count($d1->booking_pax)-1 == $i2) border-b @endif">
							{{ $d2->birth_place }}
						</td>
						<td  class="px-2 py-2 @if(count($d1->booking_pax)-1 == $i2) border-b @endif">
							{{ carbon\carbon::parse($d2->birth_date)->format('d-M-y') }}
						</td>
						<td  class="px-2 py-2 border-r  @if(count($d1->booking_pax)-1 == $i2) border-b @endif">
							{{ $d->users->telp }}
						</td>
						@php
							$count++;
							if ($d2->type == 'Adult') {
								$adult += 1;
							}elseif($d2->type == 'Child With Bed' or $d2->type == 'Child No Bed'){
								$child += 1;
							}elseif($d2->type == 'Infant'){

								$infant += 1;
							}
						@endphp
					</tr>
				@endforeach
			@endforeach
		@endforeach
	</table>
	<table style="font-size: 10px;">
		<tr>
			<td colspan="10">
				<table>
					<tr>
						<td class="px-2 py-2" colspan="2">
							Single
						</td>
						<td class="px-2 py-2">
							: {{ $single }}
						</td>
					</tr>
					<tr>
						<td class="px-2 py-2"  colspan="2">
							Double
						</td>
						<td class="px-2 py-2">
							: {{ $double }}
						</td>
					</tr>
					<tr>
						<td class="px-2 py-2"  colspan="2">
							Twin
						</td>
						<td class="px-2 py-2">
							: {{ $twin }}
						</td>
					</tr>
					<tr>
						<td class="px-2 py-2"  colspan="2">
							Triple
						</td> 
						<td class="px-2 py-2">
							: {{ $triple }}
						</td>
					</tr>
					<tr>
						<td class="px-2 py-2"  colspan="2">
							Double & CnB
						</td>
						<td class="px-2 py-2">
							: {{ $doubleCnB }}
						</td>
					</tr>
					<tr>
						<td class="px-2 py-2"  colspan="2">
							Double & CwB
						</td>
						<td class="px-2 py-2">
							: {{ $doubleCwB }}
						</td>
					</tr>
				</table>
			</td>
			<td  colspan="2">
				<table>
					<tr>
						<td class="px-2 py-2" colspan="2">
							Adult
						</td>
						<td class="px-2 py-2">
							: {{ $adult }}
						</td>
					</tr>
					<tr>
						<td class="px-2 py-2"  colspan="2">
							Child
						</td>
						<td class="px-2 py-2">
							: {{ $child }}
						</td>
					</tr>
					<tr>
						<td class="px-2 py-2"  colspan="2">
							Infant
						</td>
						<td class="px-2 py-2">
							: {{ $infant }}
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
