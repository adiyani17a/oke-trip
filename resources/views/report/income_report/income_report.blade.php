<!DOCTYPE html>
<html>
<head>
    <title>Oke-trip.com | Passport</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/dboard/logo/faveicon.png') }}"/>
    {{-- <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
    <link href="{{ asset('assets/css/chosen/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datapicker/datepicker3.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
			padding-top: 20px;
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
				padding-top: 0px;
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
		.hidden{
			display: none;
		}
    </style>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js" integrity="sha256-vucLmrjdfi9YwjGY/3CQ7HnccFSS/XRS1M/3k/FDXJw=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/fontawesome.min.css" integrity="sha256-mM6GZq066j2vkC2ojeFbLCcjVzpsrzyMVUnRnEQ5lGw=" crossorigin="anonymous" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/fontawesome.min.js" integrity="sha256-7zqZLiBDNbfN3W/5aEI1OX/5uvck9V0yhwKOA9Oe49M=" crossorigin="anonymous"></script>
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
			<div class="col-sm-12">
				<div class="col-sm-3">
					<label><b>Tanggal</b></label>
					<input type="text" class="daterange form-control" name="daterange" value="{{ carbon\carbon::now()->startOfMonth()->format('d/m/Y') }} - {{ carbon\carbon::now()->endOfMonth()->format('d/m/Y') }}" />
					<input type="hidden" id="start" value="{{ carbon\carbon::now()->startOfMonth()->format('Y-m-d') }}">
					<input type="hidden" id="end" value="{{ carbon\carbon::now()->endOfMonth()->format('Y-m-d') }}">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="col-sm-12 text-center loading hidden">
	                <i class="fas fa-circle-notch fa-spin"  style="font-size: 38px;margin-top: 20px;color: hotpink"></i>
	            </div>
				<canvas id="myChart"></canvas>
			</div>
			<div class="col-sm-6">
				<table id="datatable" class="table table-bordered">
					<caption>Jumlah Penjualan Berdasarkan Agen</caption>
					<thead>
						<th>Nama Agen</th>
						<th>Jumlah Pax</th>
						<th>Total Net</th>
					</thead>
					<tbody>
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
<div id="xlsDownload" style="display: none"></div>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.js" integrity="sha256-3D7ReNwPUpz68bIJ/oCK/SS06yw2x5MXNNj6tysVUGs=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css" integrity="sha256-FdatTf20PQr/rWg+cAKfl6j4/IY3oohFAJ7gVC3M34E=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha256-nbyata2PJRjImhByQzik2ot6gSHSU4Cqdz5bNYL2zcU=" crossorigin="anonymous" />
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
	var chart;
	$(function() {
	    $('.daterange').daterangepicker({
	        autoclose: true,
	          "opens": "right",
	          locale: {
	          format: 'DD/MM/YYYY'
	      }     
	    }, function(start, end, label) {
	        getDataDestination(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
	        $('#start').val(start);
	        $('#end').val(end);
	        table.ajax.reload(null,false);
	    });
	});

	function dynamicColors() {
	    var r = Math.floor(Math.random() * 255);
	    var g = Math.floor(Math.random() * 255);
	    var b = Math.floor(Math.random() * 255);
	    return "rgba(" + r + "," + g + "," + b + ")";
	}

	setTimeout(function() {
		try{
	    	chart.update();
		}catch(err){

		}
	}, 0);

	function getDataDestination(start = `{{ carbon\carbon::now()->startOfMonth()->format('Y-m-d') }}`,end = `{{ carbon\carbon::now()->endOfMonth()->format('Y-m-d') }}`) {
		$('.loading').removeClass('hidden');
	    $.ajax({
	        url: '{{ route('getDataDestination') }}',
	        data: {
	            start,
	            end
	        },
	        type: 'get',
	        success: function(data) {
				$('.loading').addClass('hidden');
	            var pie = [];
	            var pie = [];
	            var pie = [];
	            var table;
	            var color = [];
	            pie['labels'] = [];
	            pie['value'] = [];
	            pie['color'] = [];

	            data.data.forEach((d,i)=>{
	            	pie['value'].push(d.data);
	            	pie['labels'].push(d.labels);
		            pie['color'].push(dynamicColors());
	            });
	   
	            ctx = document.getElementById('myChart').getContext('2d');
	            chart = new Chart(ctx, {
	                // The type of chart we want to create
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
	                    tooltips: {
	                        callbacks: {
	                            label: function(tooltipItem, data) {
	                                var value = data.datasets[0].data[tooltipItem.index];
	                                if (parseInt(value) >= 1000) {
	                                    return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	                                } else {
	                                    return 'Rp. ' + value;
	                                }
	                            }
	                        }
	                    },
	                    title: {
	                        display: true,
	                        text: 'Penjualan Berdasarkan Destinasi'
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
	            chart.canvas.parentNode.style.height = '256px';
	            chart.canvas.parentNode.style.width = '256px';
	        },
	        error: function(data) {

	        }
	    });
	}

	$('.select2').select2({
	    theme: "bootstrap4",
	    width:'100%'
	});

	$(document).ready(function() {
	    table = $('#datatable').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: {
	            url: '{{ route('datatableAgen') }}',
	            data:{
	            	awal(){
	            		return $('#start').val();
	            	},
	            	akhir(){
	            		return $('#end').val();
	            	}
	            }
	        },
	        columns: [{
	            data: 'name',
	            name: 'name',
	            class: 'text-left'
	        }, {
	            data: 'pax',
	            name: 'pax',
	            class: 'text-center'
	        }, {
	            data: 'total',
	            name: 'total',
	            render: $.fn.dataTable.render.number(',', '.', 2),
	            class: 'text-right'
	        }]
	    });
		getDataDestination();
	})
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