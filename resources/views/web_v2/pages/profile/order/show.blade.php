<?php 
	$status 	= ['abandoned' => 'Terabaikan', 'cart' => 'Keranjang', 'wait' => 'Checkout', 'veritrans_processing_payment' => 'Menunggu Pembayaran via Veritrans', 'paid' => 'Pembayaran Diterima', 'packed' => 'Menunggu Pengiriman', 'shipping' => 'Dalam Pengiriman', 'delivered' => 'Pesanan Complete', 'canceled' => 'Pesanan Dibatalkan'];
?>
	<div class="row ml-0 mr-0 pl-sm pr-sm">
		<div class="col-md-8 col-sm-8 col-xs-12">
			<table>
				<tbody>
					<tr>
						<td><strong>{{ Session::get('whoami')['name'] }}</strong></td>
					</tr>
					<tr>
						<td>{{ Session::get('whoami')['email'] }}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<div class="row clearfix">
				&nbsp;
			</div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12">
			<table class="row">
				<tbody>
					<tr class="row">
						<td class="col-sm-6" valign="middle"><strong>Invoice ID</strong></td>
						<td valign="middle"> {{ $data['order']['ref_number']}} </td>
					</tr>
					<tr class="row">
						<td class="col-sm-6" valign="middle"><strong>Invoice Date</strong></td>
						<td valign="middle">@date_indo($data['order']['transact_at'])</td>
					</tr>
					<tr class="row">
						<td class="col-sm-6" valign="middle"><strong>Status</strong></td>
						<td valign="middle"> 
							{{ $status[$data['order']['status']] }} 
						</td>
					</tr>
					@if($data['order']['status'] == 'wait' || $data['order']['status'] == 'veritrans_processing_payment')
					<tr class="row">
						<td class="col-sm-6" valign="middle"><strong>Due Date</strong></td>
						<td valign="middle">@date_indo(Carbon::parse($data['order']['transact_at'].' '.$balin['info']['expired_cart']['value'])->format('Y-m-d'))</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row ml-0 mr-0 pl-sm pr-sm">
		<!-- normal tablet -->
		<div class="col-md-12 col-sm-12 chart-div">
			<div class="col-md-12">
				<div class="row border-1 border-solid border-grey-light">
					<div class="col-md-1 col-sm-1 hidden-xs">
						<p class="mt-5 mb-5">No</p>
					</div>
					<div class="col-md-1 col-sm-2 hidden-xs">
						<p class="mt-5 mb-5">Produk</p>
					</div>					
					<div class="col-md-10 col-sm-9 hidden-xs">
						<div class="row">
							<div class="col-sm-4 col-md-4"></div>
							<div class="col-sm-2 col-md-2">
								<p class="mt-5 mb-5 text-center">Kuantitas</p>
							</div>
							<div class="col-sm-2 col-md-2">
								<p class="mt-5 mb-5 text-center">Harga</p>
							</div>
							<div class="col-sm-2 col-md-2">
								<p class="mt-5 mb-5 text-right">Diskon</p>
							</div>
							<div class="col-md-2 col-sm-2">
								<p class="mt-5 mb-5 text-center">Total</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			{{-- list produk detail --}}
			<div class="row">
				<?php $numItems = count($data['order']['transactiondetails']); $i = 0; ?>
				@forelse($data['order']['transactiondetails'] as $k => $v)
					<div class="col-md-12 ">
						<div class="row border-right-1 border-left-1 {{ ($v != end($data['order']['transactiondetails']) ? 'border-bottom-1' : '') }} border-grey-light mr-0 ml-0">
							<div class="col-md-1 col-sm-1">
								<p class="mt-xs">{!! ($k+1) !!}</p>
							</div>
							<div class="col-md-1 col-sm-2 clearfix">
								<img class="img-responsive m-t-sm" src="{{ $v['varian']['product']['thumbnail'] }}" >
							</div>
							<div class="col-md-10 col-sm-9">
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<p class="mt-5 mb-5 m-b-xs">{{ $v['varian']['product']['name'] }}</p>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4 col-md-4">
										<p class="text-regular">Size :
											@if (strpos($v['varian']['size'], '.')==true)
												<?php $frac = explode('.', $v['varian']['size']); ?>
												{{ $frac[0].' &frac12;'}}
											@else
												{{ $v['varian']['size'] }}
											@endif
										</p>
									</div>
									<div class="col-sm-2 col-md-2 text-center">
										{{ $v['quantity'] }}
									</div>
									<div class="col-sm-2 col-md-2 text-right">
										@money_indo($v['price'])
									</div>
									<div class="col-sm-2 col-md-2 text-right">
										@money_indo($v['discount'])
									</div>
									<div class="col-sm-2 col-md-2 text-right">
										@money_indo((($v['price'] - $v['discount']) * $v['quantity']))
									</div>
								</div>							
							</div>
						</div>
					</div>
				@empty
					<div class="col-md-12 text-center">
						<p>Tidak ada produk yang dibeli</p>
					</div>
				@endforelse						
			</div>
		</div>	

		<!-- mobile -->
	</div>
	<div class="row ml-0 mr-0 pl-sm pr-sm">
		<div class="col-md-12 col-sm-12">
			<table class="table table-bordered table-hover table-striped">
				<tbody>
					@if (isset($data['order']['transactiondetails']))
						<?php 
							$discount_point = ($data['order']['amount'] + $data['order']['shipping_cost'] - $data['order']['voucher_discount'] - $data['order']['unique_number']);
						?>
						<tr>
							<td class="text-left pl-sm col-md-8 col-sm-8"><strong>Ongkos Kirim</strong></td>
							<td class="text-right pr-sm">@money_indo( $data['order']['shipping_cost'] )</td>
						</tr>

						<tr>
							<td class="text-left pl-sm col-md-8 col-sm-8"><strong>Diskon Voucher</strong></td>
							<td class="text-right pr-sm text-red">@money_indo( $data['order']['voucher_discount'] )</td>
						</tr>
						<tr>
							<td class="text-left pl-sm col-md-8 col-sm-8"><strong>Potongan Point</strong></td>
							<td class="text-right pr-sm text-red">@money_indo( $data['order']['point_discount'])</td>
						</tr>
						<tr>
							<td class="text-left pl-sm col-md-8 col-sm-8"><strong>Potongan Transfer</strong></td>
							<td class="text-right pr-sm text-red">@money_indo( $data['order']['unique_number'] )</td>
						</tr>
						<tr>
							<td class="text-left pl-sm col-md-8 col-sm-8"><strong>Biaya Tambahan </strong>
								@foreach($data['order']['transactionextensions'] as $key => $value)
									<br/> {{$value['productextension']['name']}}
								@endforeach
							</td>
							<td class="text-right pr-sm">@money_indo( $data['order']['extend_cost'] )</td>
						</tr>
						@if(isset($data['order']['payment']))
							<tr>
								<td class="text-left pl-sm col-md-8 col-sm-8"><strong>{{ucwords($data['order']['payment']['method'])}}</strong></td>
								<td class="text-right pr-sm text-red">@money_indo( $data['order']['payment']['amount'] )</td>
							</tr>
						@endif
						<tr>
							<td class="text-left pl-sm col-md-8 col-sm-8"><strong>Total Yang Harus Dibayarkan</strong></td>
							<td class="text-right pr-sm">@money_indo( $data['order']['bills'] )</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		<!-- mobile -->
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row ml-0 mr-0 pl-sm pr-sm">
		<div class="col-md-4">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>Alamat Pengiriman</th>
					</tr>
				</thead>
				<tbody>
					@if (isset($data['order']['shipment']))
						<tr>
							<td>a.n. {{ $data['order']['shipment']['receiver_name'] }}</td>
						</tr>
						<tr>
							<td>{{ $data['order']['shipment']['address']['phone'] }}</td>
						</tr>
						<tr>
							<td>{{ $data['order']['shipment']['address']['address'] }}, {{ $data['order']['shipment']['address']['zipcode'] }}</td>
						</tr>
					@else
						<tr>
							<td>Belum ada alamat pengiriman</td>
						</tr>
					@endif
				</tbody>
			</table>
			@if (isset($data['order']['shipment']) && !is_null($data['order']['shipment']['receipt_number']))
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>Resi Pengiriman</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><strong>{{ $data['order']['shipment']['receipt_number'] }}</strong></td>
							</tr>
					</tbody>
				</table>
			@endif
		</div>
		<div class="col-md-4">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						@if (count($data['order']['payment']))
							<th colspan="2">Nota Bayar</th>
						@elseif($data['order']['bills'] == 0)
							<th colspan="2">Pelunasan Dengan Point</th>
						@else
							<th colspan="2">Lakukan Pembayaran Melalui</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@if (count($data['order']['payment']))
						<tr>
							<td><strong>Tanggal</strong></td>
							<td>@date_indo( $data['order']['payment']['ondate'] )</td>
						</tr>
						<tr>
							<td><strong>Nama Akun</strong></td>
							<td>{{ $data['order']['payment']['account_name'] }}</td>
						</tr>
						<tr>
							<td><strong>Nomor Rekening</strong></td>
							<td>{{ $data['order']['payment']['account_number'] }}</td>
						</tr>
						<tr>
							<td><strong>Total Bayar</strong></td>
							<td>@money_indo( $data['order']['payment']['amount'] )</td>
						</tr>
					@elseif($data['order']['bills'] == 0)
						<tr>
							<td colspan="2">@money_indo( $data['order']['point_discount'])</td>
						</tr>
					@else
						<tr>
							<td colspan="2">{!!$balin['info']['bank_information']['value']!!}</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="col-md-4">
			<table class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th colspan="2">Riwayat Pesanan</th>
					</tr>
				</thead>
				<tbody>
					@if (isset($data['order']['orderlogs']))
						@forelse ($data['order']['orderlogs'] as $k => $v)
							@if (in_array($v['status'], ['wait', 'veritrans_processing_payment', 'paid', 'packed', 'shipping', 'delivered', 'canceled']))
								<tr>
									<td> 
										<strong> {{ $status[$v['status']] }} </strong>
										@if ($v['status'] == 'delivered')
											<p>{{ $v['notes'] }}</p>
										@endif
									</td>
									<td> @datetime_indo( $v['changed_at'] ) </td>
								</tr>
							@endif
						@empty
							<tr>
								<td colspan="2"> Tidak ada riwayat pesanan </td>
							</tr>
						@endforelse
					@endif
				</tbody>
			</table>
		</div>
	</div>