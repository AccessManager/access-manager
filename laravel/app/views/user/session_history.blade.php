@extends('user.header_footer')
@section('user_title')
Sessions History
@stop

@section('user_container')
	

	<table class="table table-striped table-responsive table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Start Time</th>
                                <th>Stop Time</th>
                                <th>Duration</th>
                                <th>Session Download</th>
                                <th>Session Upload</th>
                                <th>Total Data Transfer</th>
                                <th>IP Address</th>
                                <th>MAC Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($sess_history))
                            <?php $i = $sess_history->getFrom(); ?>
                            @foreach($sess_history as $session)
                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    {{date("d M y - H:i:s", strtotime($session->acctstarttime))}}
                                </td>
                                <td>
                                    @if( ! is_null($session->acctstoptime) )
                                    {{date("d M y - H:i:s", strtotime($session->acctstoptime))}}
                                    @else
                                    ---
                                    @endif
                                </td>
                                <td>
                                    {{formatTime($session->acctsessiontime)}}
                                </td>
                                <td>
                                    {{formatBytes($session->acctoutputoctets)}}
                                </td>
                                <td>
                                    {{formatBytes($session->acctinputoctets)}}
                                </td>
                                <td>
                                    {{formatBytes($session->acctinputoctets + $session->acctoutputoctets)}}
                                </td>
                                <td>{{$session->framedipaddress}}</td>
                                <td>{{$session->callingstationid}}</td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan='9'>No Records Found.</td>
                            </tr>
                            @endif
                        </tbody>
                        
                    </table>
                    <div class="row">
                <div class="col-lg12 col-md-12 col-sm-12">
                    {{$sess_history->links()}}
                </div>
            </div>


@stop