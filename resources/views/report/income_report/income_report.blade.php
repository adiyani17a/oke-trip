<!DOCTYPE html>
<html>
<head>
    <title>Oke-trip.com | Passport</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/dboard/logo/faveicon.png') }}"/>
    {{-- <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ asset('assets/css/chosen/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datapicker/datepicker3.css') }}" rel="stylesheet">
    <style type="text/css">
		.height{
	    	background: white;
			height: 100%;
		}
		.pt-2{
			padding-top: 20px;
		}
		.pl-2{
			padding-top: 20px;
		}
		.pr-2{
			padding-right: 20px !important;
		}
		.width-10{
			width: 10%;
		}
		.width-20{
			width: 20%;
		}
		.border-black{
			border:1px solid #9999;
		}
		.box-git{
			width: 100%;
			height: 133px;
		}
		.nopadding-right {
		 padding-right: 0 !important;
		 margin-right: 0 !important;
		}

		.nopadding-left {
		 padding-left: 0 !important;
		 margin-left: 0 !important;
		}
		.mt-1{
		margin-top: 10px !important;
		}
		.mt-2{
		margin-top: 20px !important;
		}
		.mb-1{
		margin-bottom: 10px !important;
		}
		.mb-2{
		margin-bottom: 20px !important;
		}
		.mr-1{
		margin-right: 10px !important;
		}
		.mr-2{
		margin-right: 20px !important;
		}
		.ml-1{
		margin-left: 10px !important;
		}
		.ml-2{
		margin-left: 20px !important;
		}
		.grey{
		color: grey;
		}
		.width-100{
		width: 100%;
		}
		.none{
		text-decoration: none;
		list-style-type: none;
		}
		.d-inline-block{
		display: inline-block;
		vertical-align: middle;
		}
		.d-inline{
		display: inline;
		vertical-align: middle;
		}
		.d-inline li{
		display: inline;
		}
		.m-auto{
		margin: auto;
		}
		.nav-tabs li a{
		padding-left: 0 !important;
		padding-right: 0 !important;
		text-align: center !important;
		}
		.font-small{
		font-size: 12px;
		}
		.middle{
		height: 47px;
		}
		.black{
		color: black;
		}
		.head{
		background: grey !important;
		color:white;
		width: 100%;
		height: 100%;
		vertical-align: middle;
		}
		.mt-5{
		margin-top: 50px
		}
		.head_awal{
		background-color: black !important;
		color: white;`
		}
		.head_awal1{
		background-color: black !important;
		color: white;`
		}
		.head_awal2{
		background-color: black !important;
		color: white;`
		}
		.hide{
		display: none;
		}
		.disabled{
			pointer-events: none;
		}

		.tree tr{
			border :hidden;
		}

		.tree_1 tr{
			border :hidden;
		}

		hr{
			border-top: 1px solid black;
			margin-top: 2px;
			margin-bottom: 0px;
		}

		.text-right{
			border: none;
		}

		.text-right{
			border: none;
		}

		.border-right-none{
			border-right: none !important;
		}

		.border-none{
			border: none !important;
		}
		.table-border td{
			border: 1px solid black !important;
			padding:1px;
		}

		.table-margin{
			margin-top: 70px;
			background: white;
			font-size: 10px;
			padding: 5px;
		}

		@media print
		{    
		    header, header *
		    {
				display: none !important;
		    }

		    .table thead tr td,.table tbody tr td{
	            border-width: 1px !important;
	            border-style: solid !important;
	            border-color: black !important;
	            background-color: red;
	            -webkit-print-color-adjust:exact ;
	        }
	        body{
	        	background-color: white !important;
	        }

	        .table-margin{
				margin-top: 0px;
			}
		}

		.ttd{
			height: 70px;
			width: 20%;
		}

		.dotted{
			border-bottom: 2px dotted gray;
			width: 100%;
			height: 1px;
			margin-bottom: 5px;
			margin-top: 10px;
			position: relative;
		}	

		.fa-scissors{
			position: absolute;
			top: -10px;
			font-size: 20px;
			font-weight: 800
		}
    </style>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!-- datepicker  --> 
</head>
<body style="background: grey">
	<header id="navigation" style="padding: 0px 0px;height: 60px;vertical-align: middle;background: rgba(0, 0, 0, 0.8); box-shadow: 0px 2px 5px #444; z-index:2;width: 100%;position: fixed;top: 0px;">
    <div class="container" >
      <div class="row">
			<nav class="navbar navbar-light" style="width: 100%">
				<div class="col-md-4">
					<a class="navbar-brand" href="{{ url('/') }}" style="color: white !important">
				    Oke-Trip.com
				  </a>
				</div>
				<div class="col-md-4 d-flex btn-group">
					<button class="btn btn-warning" onclick="excel()" style="float: right;">
						<i class="fa fa-file-excel-o"></i> Excel
					</button>
					<button class="btn btn-success" onclick="print()" style="float: right;">
						<i class="fa fa-print"></i> Print
					</button>
				</div>
			</nav>
      </div>
    </div>
	</header>
	<div id="isi" class="container">
		<div class="row table-margin">
			<div class="col-sm-6">
				<canvas id="myChart"></canvas>
			</div>
		</div>
	</div>
</body>
<div id="xlsDownload" style="display: none"></div>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.js" integrity="sha256-3D7ReNwPUpz68bIJ/oCK/SS06yw2x5MXNNj6tysVUGs=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">
	var pie = [];
	var pie = [];
	var pie = [];

	var color = [];
	pie['labels'] = [];
	pie['value']= [];
	pie['color']= [];
	@foreach ($dataSets as $i=>$d)
		pie['labels'].push('{{ $dataSets[$i]['labels'] }}')
		pie['value'].push('{{ $dataSets[$i]['data'] }}')
		pie['color'].push(dynamicColors());
	@endforeach
	console.log(pie);
	function dynamicColors() {
	    var r = Math.floor(Math.random() * 255);
	    var g = Math.floor(Math.random() * 255);
	    var b = Math.floor(Math.random() * 255);
	    return "rgba(" + r + "," + g + "," + b + ")";
	}

	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    title:'Penjualan Ticket Berdasarkan Destinasi'
	    type: 'doughnut',
	    // The data for our dataset
	    data: {
	        datasets: [{
	            data: pie['value'],
	            backgroundColor: pie['color']
	        }],
	        labels: pie['labels']
	    },
	    // Configuration options go here
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    callback: function(value) {
	                        return accounting.formatNumber(value, 2, " ")
	                    }
	                }
	            }]
	        },
	        responsive: true,
	        maintainAspectRatio: false,
	        legend: {
	            position: 'bottom',
	            labels: {
	                boxWidth: 12,
	                fontSize: 11,
	            }
	        },
	        animation: {
	            animateScale: true,
	            animateRotate: false,
	        },
	    }
	});
	function excel(argument) {
	    var blob = b64toBlob(btoa($('div[id=isi]').html().replace(/[\u00A0-\u2666]/g, function(c) {
	        return '&#' + c.charCodeAt(0) + ';';
	    })), "application/vnd.ms-excel");
	    var blobUrl = URL.createObjectURL(blob);
	    var dd = new Date()
	    var ss = '' + dd.getFullYear() + "-" +
	        (dd.getMonth() + 1) + "-" +
	        (dd.getDate()) +
	        "_" +
	        dd.getHours() +
	        dd.getMinutes() +
	        dd.getSeconds()

	    $("#xlsDownload").html("<a href=\"" + blobUrl + "\" download=\"Print_Data\_" + ss + "\.xls\" id=\"xlsFile\">Downlaod</a>");
	    $("#xlsFile").get(0).click();

	    function b64toBlob(b64Data, contentType, sliceSize) {
	        contentType = contentType || '';
	        sliceSize = sliceSize || 512;

	        var byteCharacters = atob(b64Data);
	        var byteArrays = [];


	        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
	            var slice = byteCharacters.slice(offset, offset + sliceSize);

	            var byteNumbers = new Array(slice.length);
	            for (var i = 0; i < slice.length; i++) {
	                byteNumbers[i] = slice.charCodeAt(i);
	            }

	            var byteArray = new Uint8Array(byteNumbers);

	            byteArrays.push(byteArray);
	        }

	        var blob = new Blob(byteArrays, {
	            type: contentType
	        });
	        return blob;
	    }
	}

</script>
</html>