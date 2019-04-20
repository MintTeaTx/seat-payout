
@extends('web::layouts.grids.4-4-4')
@section('title',trans('payout::payout.list'))
@section('page_header', 'Dicks out for Harambe')

@section('left')
    <div class="box box-primary box-solid">
	   <div class="box-header">
		  <h3 class="box-title">Fleet Log</h3>
	   </div>
	   <form role="form" action="{{ route('payout.savePayout') }}" method="post">
		  <div class="box-body">
			 {{ csrf_field() }}
			 <label>Fleet log</label><br>
			 <textarea name="fleetLog" id="fleetLog" rows="15" style="width: 100%" onclick="this.focus();this.select();"> </textarea>
		  </div>
		  <div class="row">
		  	<div class="col-md-6">
			  <div class="box-body">
				 {{ csrf_field() }}
				 <label>Hauler(s)</label><br>
				 <select multiple class="form-control" id="haulerList" name="haulerList[]" size=10></select>
			  </div>
			</div>
			<div class="col-md-6">
			  <div class="box-body">
				 {{csrf_field()}}
				 <label>Item(s)</label><br>
				 <select multiple class="form-control" id="filter" name="filter[]" size=10></select><br>
			  </div>
			</div>
		</div>

		  <div class='box-footer'>
			 <div class="btn-group pull-right" role="group"><br>
				<input type="submit" class="btn-primary" id="savePayout" value="Submit Log"/>

			 </div>
		  </div>
	   </form>
    </div>
@endsection
@section('center')
    <div class="box box-primary box-solid">
	   <div class="box-header">
		  <h3 class="box-title">Payouts</h3>
	   </div>
	   <div class="box-body">
		  <table id='payoutlist' class="table table-hover table-responsive" style="vertical-align: top">
			 <thead>
			 <tr>
				<th>Character</th>
				<th>Item Name</th>
				<th class="text-right">Quantity</th>
				<th class="text-right">ISK</th>

			 </tr>
			 </thead>
			 <tbody>
			 <?php $subtotals = array(); ?>
			 @if (count($payouts) > 0)
				@foreach($payouts as $payout)
				    @if(!in_array($payout['item'],$filter))
					   @continue
				    @endif
					<?php
						$item = $payout['item'];
						$quantity = $payout['quantity'];
						$isk = $payout['isk'];
						if ( ! array_key_exists( $item, $subtotals ) ) {
							$subtotals[ $item ] = array( 'quantity' => 0, 'isk' => 0 );
						}
						$subtotals[ $item ]['quantity'] = (int) $subtotals[ $item ]['quantity'] + $quantity;
						$subtotals[ $item ]['isk'] = (int) $subtotals[ $item ]['isk'] + $isk;
					?>
				    <tr>
					   <td>{{ (string)$payout['character_name'] }}</td>
					   <td data-order="{{ $payout['item'] }}">{{ $payout['item'] }}</td>
					   <td class="text-right" data-order="{{ $payout['quantity'] }}">{{ number($payout['quantity'], 0) }} </td>
					   <td class="text-right" data-order="{{$payout['isk'] }}"> {{ number_format( $payout['isk'] ) }}</td>
				    </tr>
				@endforeach
			 @endif
			 </tbody>
		  </table>
	   </div>
    </div>

	@if ( count( $subtotals ) > 0 )
		<div class="box box-primary box-solid">
			<div class="box-header">
				<h3 class="box-title">Totals</h3>
			</div>
			<div class="box-body">
				<table id='totalslist' class="table table-hover table-responsive" style="vertical-align: top">
					<thead>
						<tr>
							<th>Item Name</th>
							<th class="text-right">Quantity</th>
							<th class="text-right">Paid Out</th>
							<th class="text-right">Profit</th>
						</tr>
					</thead>
					<tbody>
						@foreach ( $subtotals as $item => $subtotal )
							<?php
								$total = ( $subtotal['isk'] / 0.95 );
								$profit = $total - $subtotal['isk'];
							?>
							<tr>
								<td>{{ $item }}</td>
								<td class="text-right">{{ number( $subtotal['quantity'], 0 ) }}</td>
								<td class="text-right">{{ number_format( $subtotal['isk'] ) }}</td>
								<td class="text-right">{{ number_format( $profit ) }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif

    <div class="box box-primary box-solid">
	   <div class="box-header">
		  <h3 class="box-title">Haulers</h3>
	   </div>
	   <div class="box-body">
		  <table id="haulerTable" class="table table-hover" style="vertical-align: top">
			 <thead>
			 <tr>
				<th>
				    Haulers
				</th>
			 </tr>
			 </thead>
			 <tbody>
			 @if (count($haulerarray) > 0)
				@foreach($haulerarray as $hauler)
				    <tr>
					   <td>{{ $hauler }}</td>
				    </tr>
				    @endforeach
			 @endif
			 </tbody>
		  </table>
	   </div>
    </div>

@endsection
@push('javascript')
<script type="application/javascript">
	$( '#fleetLog' ).focusout( function(){
		var items = [];
		var names = [];
		var regex = [
			// JS doesn't support named capture groups, so both regex must push names/items to the same groupIndex
			/^[\d:]*?\s(?<name>.*?)\shas looted[\d\s,]*?x\s(?<item>.*)$/gm,
			/^[\d\.]*?\s[\d:]*?\s(?<name>.*?\s.*?)\s(?<item>.*?)\s\d.*?$/gm
		];
		var fleetLog = $( '#fleetLog' ).val();
		let m;
		jQuery( regex ).each( function( index ) {
			while ( ( m = this.exec( fleetLog ) ) !== null ) {
				if ( m.index === this.lastIndex ) { this.lastIndex++; } // avoid infinite loops
				m.forEach ( ( match, groupIndex ) => {
					if ( ( 2 == groupIndex ) && ( ! items.includes( match ) ) ) {
						items.push( match.trim() );
					}
					if ( ( 1 == groupIndex ) && ( ! names.includes( match ) ) ) {
						names.push( match.trim() );
					}
				});
			}
		} );
		items.sort((a, b) => a.localeCompare(b, undefined, {sensitivity: 'base'}));
		$( '#filter' ).find( 'option' ).remove();
		$.each( items, function( key, value ) {
			$( '#filter' ).append( $( '<option>', { value : value } ).text( value ) );
		});
		names.sort((a, b) => a.localeCompare(b, undefined, {sensitivity: 'base'}));
		$( '#haulerList' ).find( 'option' ).remove();
		$.each( names, function( key, value ) {
			$( '#haulerList' ).append( $( '<option>', { value : value } ).text( value ) );
		});
	});
</script>
@endpush
