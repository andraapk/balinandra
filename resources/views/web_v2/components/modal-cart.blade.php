<!-- Modal -->
<style type="text/css">
	#modal-cart li{
		list-style: none;
	}
	#modal-cart {
	  text-align: center;
	  padding: 0!important;
	}

	#modal-cart:before {
	  content: '';
	  display: inline-block;
	  height: 100%;
	  vertical-align: middle;
	  margin-right: -4px;
	}

	#modal-cart .modal-dialog {
	  display: inline-block;
	  text-align: left;
	  vertical-align: middle;
	}	
</style>

<div class="modal fade" id="modal-cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
					<i style="color: black;" class="fa fa-times-circle" aria-hidden="true"></i>
				</span></button>
				<h4 class="modal-title" id="myModalLabel">Shopping Bag</h4>
			</div>
			<div class="modal-body pl-0 pr-0">
				<div id="content-cart-mobile">
				</div>
			</div>
		</div>
	</div>
</div>

@section('js')
	$( document ).ready(function() {
		setMobileCart();     
	});

	function setMobileCart(){
		var htmlString = $('#cart-content').html();
		$('#content-cart-mobile').html( htmlString );
	}
@append
