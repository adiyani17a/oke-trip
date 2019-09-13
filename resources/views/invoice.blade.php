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

	.px-1{
		padding-left: 0.25rem; 
		padding-right: 0.25rem;
	}

	.py-1{
		padding-top: 0.25rem; 
		padding-bottom: 0.25rem;
	}

	.text-center{
		text-align: center;
	}

	th{
		text-align: center;
	}

	.text-right{
		text-align: right;
	}
</style>
<div class="invoice-box" style="margin-bottom: 10px;">
	<table cellpadding="0" cellspacing="0" style="width: 100%">
		<tr class="top">
			<td colspan="2">
				<img src="http://panel.oke-trip.com/dist/img/logo.png" style="width:200px; max-width:300px;">
			</td>
			<td colspan="2" class="text-right">
				<p>{{ $data['data']->kode }}<br> {{ carbon\carbon::parse($data['data']->created_at)->format('d, F Y')  }}</p>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<hr>
			</td>
		</tr>
			<tr class="information">
				<td colspan="2">
					<h4>Invoice To</h4>
					<p>{{ $data['data']->users->name }}<br>Email: {{ $data['data']->users->email }}</p>
					<p>{{ $data['data']->users->address }} <br>{{ $data['data']->users->telp  }}</p>
				</td>
				<td colspan="2"  class="text-right">
					<h4>Pay To</h4>
					<p>Lukman Hartono<br>Email: oke-trip.com@gmail.com</p>
					<p>Jl. Nginden Intan Raya No. 7, Surabaya <br> 0315992855</p>
				</td>
			</tr>
		@php
			$total = 0;
		@endphp
		<tr class="heading">
			<td class="px-2 py-2">Item</td>
			<td class="px-2 py-2">Cost</td>
			<td class="px-2 py-2">Quantity</td>
			<td class="px-2 py-2">Price</td>
		</tr>
		@foreach($data['invoice_list'] as $i => $d)
			@if($data['invoice_list'][$i]['nominal'] != 0)
				<tr class="item" v-for="(item,idx) in pricing" v-if="item.nominal != 0">
					<td class="px-1 py-1">{{ $data['invoice_list'][$i]['name'] }}</td>
					<td class="px-1 py-1">@if($data['invoice_list'][$i]['type'] == 'Agent Com' or $data['invoice_list'][$i]['type'] == 'Staff Com') - @endif Rp. {{ number_format($data['invoice_list'][$i]['chargePerAmount'], 0, ".", ",") }}</td>
					<td class="px-1 py-1">{{ $data['invoice_list'][$i]['value'] }}</td>
					<td class="px-1 py-1">@if($data['invoice_list'][$i]['type'] == 'Agent Com' or $data['invoice_list'][$i]['type'] == 'Staff Com') - @endif Rp. {{ number_format($data['invoice_list'][$i]['nominal'], 0, ".", ",") }}</td>
				</tr>
			@endif
			@php
				$total += $data['invoice_list'][$i]['nominal'];
			@endphp
		@endforeach
		<tr class="total">
			<td colspan="3"></td>
			<td class="px-2 py-2">Total : <b class="font-bold">Rp. {{ number_format($total, 0, ".", ",") }}</b></td>
		</tr>
	</table>
</div>