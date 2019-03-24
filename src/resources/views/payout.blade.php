<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 3/23/2019
 * Time: 11:17 PM
 */
@extends('web::layouts.grids.4-4-4')
@section('title',trans('payout::payout.list'))
@section('page_header', trans('fitting::fitting.list'))

@section('left')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="box-title">Payout Calculator</h3>
            <button type="button" id="importLog" class="btn btn-xs btn-box-tool" data-toggle="tooltip" data-placement="top" title="Import Fleet Log">
                <span class="fa fa-plus-square"></span>
            </button>
        </div>
        <div class="panel-body">
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
                @if (count($payoutlist) > 0)
                @foreach($payoutlist as $payout)
                    <tr>
                        <td data-order=" {{ $payout->character_id }}">
                            {!! img('character', $payout->character_id, 32, ['class' => 'img-circle eve-icon small-icon'], false) !!}
                            <a href="{{ route('payout.view.sheet', ['character_id' => $payout->character_id]) }}">
                                <span class="id-to-name" data-id="{{ $payout->character_id }}">{{ trans('web::seat.unknown') }}</span>
                            </a>
                        </td>
                        <td class="text-right" data-order="{{ $payout->item }}">{{ $payout->item }}</td>
                        <td class="text-right" data-order="{{ $payout->quantity }}">{{ number($payout->quantity, 0) }} m<sup>3</sup></td>
                        <td class="text-right" data-order="{{ $payout->isk }}">{{ number($payout->isk, 0) }} ISK</td>
                    </tr>
                 @endforeach
                 @endif
                </tbody>
            </table>
        </div>
        <div class="panel-footer">Total : {{ number($payoutlist->sum('isk')) }} ISK</div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="payoutPasteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class ="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
                    <h4 class="modal-title">Are you sure?</h4>
                </div>
                <form role="form" action="{{ route('payout.savePayout') }}" method="post">
                    <div class="modal-body">
                        <p>Cut and Paste you fleet log in the box below</p>
                        {{ csrf_field() }}
                        <textarea name="payoutarea" id="payoutarea" rows="15" style="width: 100%">Paste logs here</textarea>

                    </div>
                    <div class="modal-footer">
                        <div class="btn-group pull-right" role="group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-primary" id="saveLog" value="Submit Log" />
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@push('javascrpt')
    <script type="application/javascript">

        $('#importLog').on('click', function () {
            $('#payoutPasteModal').modal('show');
        });

        $('#payoutPasteModal').on('click', 'saveLog', function() {

        });
        function fillPayoutTable(result) {
            if(result) {



            }

        }



    </script>
    @endpush