<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Flipkart Products</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>
<body>
	<div class="container-fluid pt-5 pb-5">
		<div class="row">
			<div class="col-md-12">
				<h1 class="text-center">Flipkart Products</h1>
				<hr>
				<div class="float-left">
					<h3><span class="badge badge-primary">BTC to INR Conversion rate: {{ $convRate }}</span></h3>
				</div>
				<div class="float-right">
					<button class="btn btn-outline-primary" id="scrap-now">
						<img src="{{ asset('images/loading.gif') }}" class="d-none" id="scrap-now-load"> 
						Scrap Now
					</button>
				</div>
			</div>
			<div class="col-md-12 mt-3">
				<div class="table-responsive">
					<table class="table table-bordered table-striped text-center align-middle" id="tableData">
						<thead>
							<tr>
								<th rowspan="2">Image</th>
								<th rowspan="2">Product ID</th>
								<th rowspan="2">Title</th>
								<th rowspan="2">Variant</th>
								<th rowspan="2">Rating</th>
								<th colspan="2">Store Price</th>
								<th colspan="2">Original Price</th>
							</tr>
							<tr>
								<th>INR</th>
								<th>BTC</th>
								<th>INR</th>
								<th>BTC</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($products as $prod)
								<tr>
									<td>
										@if ($prod->image)
											<img src="{{ $prod->image }}" class="img-responsive" width="150">
										@endif
									</td>
									<td>{{ $prod->product_id }}</td>
									<td>{{ $prod->title }}</td>
									<td>{{ $prod->variant }}</td>
									<td>{{ $prod->rating }}</td>
									<td>{{ floatval($prod->store_price) }}</td>
									<td>{{ floatval($prod->store_price/$convRate) }}</td>
									<td>{{ floatval($prod->original_price) }}</td>
									<td>{{ floatval($prod->original_price/$convRate) }}</td>
								</tr>
							@empty
								<tr>
									<td colspan="9">No Products Yet!! Please click "Scrap Now" button</td>
									<! ––  added below lines (td) to bypass data table plugin error. ref: https://stackoverflow.com/a/34012324/1926279 ––>
									<td style="display:none;"></td>
									<td style="display:none;"></td>
									<td style="display:none;"></td>
									<td style="display:none;"></td>
									<td style="display:none;"></td>
									<td style="display:none;"></td>
									<td style="display:none;"></td>
									<td style="display:none;"></td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
</body>
</html>