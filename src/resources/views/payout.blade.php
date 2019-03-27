
@extends('web::layouts.grids.4-4-4')
@section('title',trans('payout::payout.list'))
@section('page_header', 'Vol it doesn\'t work yet but it will')

@section('left')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title">Fleet Log</h3>
        </div>
        <form role="form" action="{{ route('payout.savePayout') }}" method="post">
            <div class="box-body">
		{{ csrf_field() }}
                <label>Fleet Log Paste Box</label>
                <textarea name="fleetLog" id="fleetLog" rows="15" style="width: 100%" onclick="this.focus();this.select();"> </textarea>
            </div>
            <div class='box-footer'>
                <div class="btn-group pull-right" role="group">
                    <input type="submit" class="btn-primary" id="savePayout" value="Submit Log"/>

                </div>
            </div>
        </form>
    </div>
@endsection
@section('center')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title">Output</h3>
        </div>
        <div class="box-body">
            <table id='payoutlist' class="table table-hover" style="vertical-align: top">
                <thead>
                <tr>
                    <th></th>
                    <th>Character</th>
                    <th>Item Name</th>
                    <th>ISK</th>
                    <th class="pull-right">Option</th>
                </tr>
                </thead>
                <tbody>
                @if (count($payouts) > 0)
                    @foreach($payouts as $payout)
                        <tr>
                            <td data-order=" {{ $payout->character_id }}">
                                <a href="{{ route('payout.view.sheet', ['character_id' => $payout->character_id]) }}">
                                    <span class="id-to-name" data-id="{{ $payout['user_id']}}">{{ trans('web::seat.unknown') }}</span>
                                </a>
                            </td>
                            <td class="text-right" data-order="{{ $payout['item'] }}">{{ $payout['item'] }}</td>
                            <td class="text-right" data-order="{{ $payout['quantity'] }}">{{ number($payout['quantity'], 0) }} m<sup>3</sup></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('javascrpt')
    <script type="application/javascript">


       $('#payouts').DataTable();

        $('#importLog').on('click', function () {

        });


        $('#payoutPasteModal').on('click', 'saveLog', function() {

        });

    </script>
@endpush
