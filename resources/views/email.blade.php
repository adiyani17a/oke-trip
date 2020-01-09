<html>

<body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
  <table style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
    <thead>
      <tr>
        <th colspan="2">Reminder</th>
      </tr>
      <tr>
        <th style="text-align:left;">
          <img src="http://panel.oke-trip.com/dist/img/AdminLTELogo.png" style="width: 100px;height: 100px;" alt="Oke-Trip">
        </th>
        <th style="text-align:right;font-weight:400;">{{ carbon\carbon::now()->format('d F Y') }}</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Order status</span><b style="color:red;font-weight:normal;margin:0">Waiting For Repayment</b></p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Booking ID</span> {{ $d->kode }}</p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Order amount</span> Rp. {{ number_format($d->total) }}</p>
          <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Rest Of Bill</span>
            @if (!is_null($d->payment_history))
              Rp. {{ number_format($d->total-$d->payment_history->where('status_payment','Approve')->sum('total_payment')) }}
            @else
              Rp. {{ number_format($d->total) }}
            @endif
          </p>
        </td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span> {{ $d->users->name }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Email</span> {{ $d->users->email }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone</span> {{ $d->users->telp }}</p>
        </td>
        <td style="width:50%;padding:20px;vertical-align:top">
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Address</span> {{ $d->users->address }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Number of Pax</span> {{ $d->booking_pax->count() }}</p>
          <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Duration of your vacation</span> {{ carbon\carbon::parse($d->itinerary_detail->start)->format('d/m/Y') }} to {{ carbon\carbon::parse($d->itinerary_detail->end)->format('d/m/Y') }} ({{ (strtotime($d->itinerary_detail->end) - strtotime($d->itinerary_detail->start)) /86400 }} Days)</p>
        </td>
      </tr>
{{--       <tr>
        <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Items</td>
      </tr>
      <tr>
        <td colspan="2" style="padding:15px;">
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;">
            <span style="display:block;font-size:13px;font-weight:normal;">Homestay with fooding & lodging</span> Rs. 3500 <b style="font-size:12px;font-weight:300;"> /person/day</b>
          </p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">Pickup & Drop</span> Rs. 2000 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">Local site seeing with guide</span> Rs. 800 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">Tea tourism with guide</span> Rs. 500 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">River side camping with guide</span> Rs. 1500 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
          <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span style="display:block;font-size:13px;font-weight:normal;">Trackking and hiking with guide</span> Rs. 1000 <b style="font-size:12px;font-weight:300;"> /person/day</b></p>
        </td>
      </tr> --}}
    </tbody>
    <tfooter>
      <tr>
        <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
          <strong style="display:block;margin:0 0 10px 0;">Regards</strong> Oke Trip<br> Jl. Nginden Intan Raya No.7 Ngenden Jangkungan<br> Kec. Sukolilo, Kota SBY<br> Jawa Timur 60118<br><br>
          <b>Phone:</b> 5992855<br>
          <b>Email:</b> oke-trip@gmail.com
        </td>
      </tr>
    </tfooter>
  </table>
</body>

</html>