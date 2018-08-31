@extends('layouts.master')

@section('content')
<h4> Date range view: </h4> 
             <input type="text" class="daterange" id="datevalue" />
	
<script>

  $('.daterange').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
 	window.open("/survey/1/results?startdate="+start.format('YYYY-MM-DD')+" 00:00"+"&enddate="+end.format('YYYY-MM-DD')+" 24:00","_self");
 	console.log("/survey/1/results?startdate="+start.format('YYYY-MM-DD')+"&enddate="+end.format('YYYY-MM-DD'));
  });

</script>
<html lang="en">


<h1>Results for survey: {{ $survey->title }} <a href="{{ URL::to('downloadExcel/csv') }}"><button class="btn btn-primary btn-xs">Download</button></a></h1>
<br>


<div class="col-md-12">

    <ul class="list-unstyled">
    <?php $chk = (isset($_GET['startdate']) ? 1 : 0); ?>  
     	
        @foreach ($responses as $response)
        
       <?php $colapseref =  $response->first()->session_sid;
        $surveydate =  $response->last()->created_at;
        ?>
        
        <?php if($chk == 1):?>
        
   
     	<?php
     	         /**
     * Version 4
     *
     * 
     * 
     */
     
     	$begindate = strtotime($_GET['startdate']);
     	$finaldate = strtotime($_GET['enddate']);
        $testsurveydate = strtotime($surveydate);
		
		
		
		if ( $testsurveydate>= $begindate && $testsurveydate <= $finaldate):?>

        
        <li>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <table style = "width: 100%">
                    <tr>
                    <td>
                    Survey type:
                    <a data-toggle="collapse" href="#<?php echo $colapseref ?>">
                        @if($response->first()->type == 'voice')
                        <span class="label label-primary">
                        @else
                        <span class="label label-success">
                        @endif
                            {{ $response->first()->type }}
                        </span>
                    </a>
                    </td>
                    <td>
                    Customer Number: {{ $response->first()->caller }}
                    </td>
                    <td>
                    Agent ID: {{ $response->last()->agentid }}
                    </td>
                    <td>
                    Survey time: {{ $response->first()->created_at }}
                    </td>
                    </tr>
                    </table>
                </div>
                
                <div class="panel-body">
                <div id="<?php echo $colapseref ?>" class="panel-collapse collapse">    
                    @foreach ($response as $questionResponse)
                    <ol class="list-group">
                        <li class="list-group-item">Question: {{ $questionResponse->question->body }}</li>
                        <li class="list-group-item">Answer type: {{ $questionResponse->question->kind }}</li>
                        <li class="list-group-item">
                            @if($questionResponse->question->kind === 'free-answer' && $questionResponse->type === 'voice')
                            <div class="voice-response">
                                <span class="voice-response-text">Response:</span>
                                <i class="fa fa-play-circle fa-2x play-icon"></i>
                                <audio class="voice-response" src="{{ $questionResponse->response }}"></audio>
                            </div>
                            @elseif($questionResponse->question->kind === 'yes-no')
                                @if($questionResponse->response == 1)
                                YES
                                @else
                                NO
                                @endif
                            @else
                            {{ $questionResponse->response }}
                            @endif
                        </li>
                        @if(!is_null($questionResponse->transcription))
                        <li class="list-group-item">Transcribed Answer: {{ $questionResponse->transcription }}</li>
                        @endif
                    </ol>
                    @endforeach
                </div>
                </div>
            </div>
        </li>
        
        <?php endif; ?>
        
        <?php else: ?>
                <li>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <table style = "width: 100%">
                    <tr>
                    <td>
                    Survey type:
                    <a data-toggle="collapse" href="#<?php echo $colapseref ?>">
                        @if($response->first()->type == 'voice')
                        <span class="label label-primary">
                        @else
                        <span class="label label-success">
                        @endif
                            {{ $response->first()->type }}
                        </span>
                    </a>
                    </td>
                    <td>
                    Customer Number: {{ $response->first()->caller }}
                    </td>
                    <td>
                    Agent ID: {{ $response->last()->agentid }}
                    </td>
                    <td>
                    Survey time: {{ $response->first()->created_at }}
                    </td>
                    </tr>
                    </table>
                </div>
                
                <div class="panel-body">
                <div id="<?php echo $colapseref ?>" class="panel-collapse collapse">    
                    @foreach ($response as $questionResponse)
                    <ol class="list-group">
                        <li class="list-group-item">Question: {{ $questionResponse->question->body }}</li>
                        <li class="list-group-item">Answer type: {{ $questionResponse->question->kind }}</li>
                        <li class="list-group-item">
                            @if($questionResponse->question->kind === 'free-answer' && $questionResponse->type === 'voice')
                            <div class="voice-response">
                                <span class="voice-response-text">Response:</span>
                                <i class="fa fa-play-circle fa-2x play-icon"></i>
                                <audio class="voice-response" src="{{ $questionResponse->response }}"></audio>
                            </div>
                            @elseif($questionResponse->question->kind === 'yes-no')
                                @if($questionResponse->response == 1)
                                YES
                                @else
                                NO
                                @endif
                            @else
                            {{ $questionResponse->response }}
                            @endif
                        </li>
                        @if(!is_null($questionResponse->transcription))
                        <li class="list-group-item">Transcribed Answer: {{ $questionResponse->transcription }}</li>
                        @endif
                    </ol>
                    @endforeach
                </div>
                </div>
            </div>
        </li>
       <?php endif; ?>
        @endforeach
        
    </ul>
</div>
@stop
 