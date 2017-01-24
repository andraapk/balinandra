<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
		<p>Pesanan Anda telah kami terima dengan nomor pesanan <strong>#{{ $data['order']['ref_number'] }}</strong> dengan nominal yang harus dibayarkan <strong>@money_indo( $data['order']['bills'] )</strong>.</p>
		<?php $due_date = Carbon::parse($data['order']['transact_at'])->addDay(); ?>
		<p>Email tagihan akan dikirimkan ke alamat email Anda, harap melakukan pembayaran sebelum tanggal <strong>@datetime_indo_with_name_month( $due_date )</strong>.</p>
		<p>&nbsp;</p>
		<p>Pembayaran dilakukan melalui transfer ke rekening : </p>
		<p>{!! $balin['info']['bank_information']['value'] !!}</p>
		<p>&nbsp;</p>
		<p><small><i>Anda dapat melihat pesanan anda di menu pribadi (Bagian Informasi Pengiriman & Tracking Order). <br>Lihatlah tagihan anda, yang kami kirimkan ke alamat email Anda.</i></small></p>
	</div>
</div>