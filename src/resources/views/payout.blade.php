
@extends('web::layouts.grids.4-4-4')
@section('title',trans('payout::payout.list'))
@section('page_header', 'Vol it\'s like mostly working holy fuck')

@section('left')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title">Fleet Log</h3>
        </div>
        <form role="form" action="{{ route('payout.savePayout') }}" method="post">
            <div class="box-body">
		{{ csrf_field() }}
                <label>Fleet Log Paste Box</label><br>
                <textarea name="fleetLog" id="fleetLog" rows="15" style="width: 100%" onclick="this.focus();this.select();"> </textarea>
            </div>
            <div class="box-body">
                {{ csrf_field() }}
                <label>Hauler Exclusion Paste Box</label><br>
                <textarea name="haulerList" id="haulerList" rows="3" style="width: 100%" onclick="this.focus();this.select();"> </textarea>
            </div>
            <div class="box-body">
                {{csrf_field()}}
                <label>Item Filter</label><br>
                <input type="text" name="filter"><br>
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
            <h3 class="box-title">Output</h3>
        </div>
        <div class="box-body">
            <table id='payoutlist' class="table table-hover table-responsive" style="vertical-align: top">
                <thead>
                <tr>
                    <th>Character</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>ISK</th>

                </tr>
                </thead>
                <tbody>
                @if (count($payouts) > 0)
                    @foreach($payouts as $payout)
                        @if(!in_array($payout['item'],$filter))
                            @continue
                        @endif
                        <tr>
                            <td>{{ (string)$payout['character_name'] }}</td>
                            <td data-order="{{ $payout['item'] }}">{{ $payout['item'] }}</td>
                            <td class="text-right" data-order="{{ $payout['quantity'] }}">{{ number($payout['quantity'], 0) }} </td>
                            <td class="text-right" data-order="{{$payout['isk'] }}"> {{ number($payout['isk']) }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
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
@push('javascrpt')
    <script type="application/javascript">


       $('#payouts').DataTable();

        $('#importLog').on('click', function () {

        });


        $('#payoutPasteModal').on('click', 'saveLog', function() {

        });

    </script>
@endpush
