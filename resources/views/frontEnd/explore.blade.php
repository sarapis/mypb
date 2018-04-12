@extends('layouts.app')
@section('title')
Explore
@stop
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


<style type="text/css">
.table a{
    text-decoration:none !important;
    color: rgba(40,53,147,.9);
    white-space: normal;
}
.footable.breakpoint > tbody > tr > td > span.footable-toggle{
    position: absolute;
    right: 25px;
    font-size: 25px;
    color: #000000;
}
</style>

@section('content')
<div class="wrapper">
    @include('layouts.sidebar')
    <!-- Page Content Holder -->
    <div id="content">
        <!-- <div id="map" style="height: 30vh;"></div> -->
        <!-- Example Striped Rows -->
        <div class="row">
            <div class="col-md-8 pr-0">
                <div class="panel m-15 content-panel">

                    <div class="panel-body p-0">
                        <div class="example table-responsive">
                            <table class="table table-striped toggle-arrow-tiny"  id="examplePagination">
                                <thead>
                                  <tr class="footable-header">
                                    <th class="text-center">@sortablelink('project_status', 'Status')</th>
                                    <th class="pr-20">@sortablelink('project_title', 'Name')</th>
                                    <!-- <th data-breakpoints="all">@sortablelink('cost_num', 'Price')</th>
                                    <th data-breakpoints="all">@sortablelink('process.vote_year', 'Year')</th>
                                    <th data-breakpoints="all">@sortablelink('votes', 'Votes')</th>
                                    <th data-breakpoints="all">@sortablelink('status_date_updated', 'Update')</th>
                                    <th data-toggle="true"></th> -->
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects as $project)
                                    <tr> 
                                        <td class="text-center">
                                            @if($project->project_status!='')
                                                @if($project->project_status=='Complete')
                                                    <button type="button" class="btn btn-floating btn-success btn-xs waves-effect waves-classic"><i class="icon fa-check" aria-hidden="true"></i></button>
                                                @elseif($project->project_status=='Project Status Needed')
                                                    <button type="button" class="btn btn-floating  btn-xs waves-effect waves-classic"></button>
                                                @elseif($project->project_status=='Rejected')
                                                    <button type="button" class="btn btn-floating btn-danger btn-xs waves-effect waves-classic"><i class="icon fa-remove" aria-hidden="true"></i></button>
                                                @elseif($project->project_status=='Lost vote')
                                                    <button type="button" class="btn btn-floating btn-danger btn-xs waves-effect waves-classic"><i class="icon fa-remove" aria-hidden="true"></i></button>
                                                @elseif($project->project_status=='On hold - Requires Additional Funds')
                                                    <button type="button" class="btn btn-floating btn-danger btn-xs waves-effect waves-classic"><i class="icon fa-remove" aria-hidden="true"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-floating btn-warning btn-xs waves-effect waves-classic"><i class="icon fa-minus" aria-hidden="true"></i></button>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="pr-30">
                                            @if($project->project_title!='')
                                                <a href="/profile/{{$project->id}}">{{$project->project_title}}</a>
                                            @endif
                                        </td>
                                        <!-- <td>
                                            @if($project->cost_num!='')
                                                ${{number_format($project->cost_num)}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($project->process->vote_year!='')
                                                {{$project->process->vote_year}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($project->votes!='')
                                                {{$project->votes}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($project->status_date_updated!='')
                                                {{$project->status_date_updated}}
                                            @endif
                                        </td> -->
                                        <td><i class="fa fa-chevron-right" style="padding-top: 8px;color: #000000;"></i></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="5">
                                      <div class="text-right">
                                        <ul class="pagination">
                                            
                                        </ul>
                                      </div>
                                    </td>
                                  </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="pagination">
                        {{ $projects->appends(\Request::except('page'))->render() }}
                        </div>
                    </div>
                    <!-- End Example Striped Rows -->
                </div>
            </div>
            <div class="col-md-4 p-0">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
<script>
 $(document).ready(function () {
    var address_district = <?php echo json_encode($address_district); ?>;
    if( address_district != ''){
    
        $('#btn-district span').html("District: "+address_district);
        $('#btn-district').show();
    };
});
</script>
<script>
$(document).ready(function(){
    $(document).ajaxStart(function(){

         $("*").animsition({
          inClass: 'fade-in',
          inDuration: 800,
          loading: true,
          loadingClass: 'loader-overlay',
          loadingParentElement: 'html',
          loadingInner: '\n      <div class="loader-content">\n        <div class="loader-index">\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n          <div></div>\n        </div>\n      </div>',
          onLoadEvent: true
        });
    });
    $(document).ajaxComplete(function(){

        $('.loader-overlay').remove();

    });
});
</script>
<script>
  var locations = <?php print_r(json_encode($projects)) ?>;
  console.log(locations);

    var mymap = new GMaps({
      el: '#map',
      lat: 40.726172,
      lng: -73.910452,
      zoom:10
    });


    $.each( locations['data'], function(index, value ){
        mymap.addMarker({
          lat: value.latitude,
          lng: value.longitude
          // ,
          // title: value.city,
          // click: function(e) {
          //   alert('This is '+value.city+', gujarat from India.');
          //}
        });
   });
</script>
@endsection


