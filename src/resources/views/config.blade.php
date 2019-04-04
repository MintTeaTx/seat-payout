
@extends('web::layouts.grids.4-4-4')
@section('title','Payout Configuration')
@section('page_header', 'This shit works so good on the first try like what the fuck how did I do that')

@section('left')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title">Fleet Log</h3>
        </div>
        <form role="form" action="{{ route('payout.config.save') }}" method="post">
            <div class="box-body">
                <div class="form-group">
                    <label>Item Name</label><br>
                    {{csrf_field()}}
                    <input type="text" name="item"><br>
                    <label>ISK amount</label><br>
                    <input type="text" name="isk"><br>
                    <input type="radio" name="type" value="create" checked>Create or Update<br>
                    <input type="radio" name="type" value="remove">Remove<br>
                </div>
            </div>
            <input type="submit" class="btn-primary" id="savePayout" value="Submit"/>
        </form>
    </div>
@endsection
@section('center')
    <div class="box box-primary box-solid">
        <div class="box-header">
            <h3 class="box-title">Fixed Payout Amounts</h3>
        </div>
        <div class="box-body">
            <table id='entryList' class="table table-hover table-responsive" style="vertical-align: top">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>ISK</th>

                </tr>
                </thead>
                <tbody>
                @if (count($entries) > 0)
                    @foreach($entries as $entry)
                        <tr>
                            <td data-order="{{ $entry['item'] }}">{{ $entry['item'] }}</td>
                            <td class="text-right" data-order="{{$entry['isk'] }}"> {{ number($entry['isk']) }}</td>
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
