<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<p>
		@if ($data['order']['data']['voucher']['type'] == 'free_shipping_cost')
			Selamat! Anda mendapat potongan : gratis biaya pengiriman.
		@elseif ($data['order']['data']['voucher']['type'] == 'debit_point')
			Selamat! Anda mendapat bonus balin point sebesar {{ $data['order']['data']['voucher']['value'] }} (Balin Point akan ditambahkan jika pesanan sudah dibayar)
		@endif
	</p>
</div>