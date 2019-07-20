@extends('admin.layout.app')
@section('contents')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">            
        <a href="{{ route('dashboard') }}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>           
    </li>
        
</ol>
<!-- Icon Cards-->

    
        <div id="modal" class="delete-modal" style="display:none;">
            <p>Are you sure you want to delete this item?</p>
            <a href="#" rel="modal:close" class="btn btn-danger cls-close">Close</a>
            <a href="javascript:void(0)" class="btn btn-primary cls-yes">Yes</a>
        </div>
    

<div class="row"> 
    <?php        
        $i=1;
        $todays =  date("Y-m-d");                
    ?>
    <div class="col-xl-12 col-sm-8 mb-8">
        <section>  
            @if(Session::has('message'))
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12">		
                        <div class="alert alert-success fade show" role="alert">          
                                {{ Session::get('message')}}   
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> 
                    </div>  
                </div> 
            @endif
        </section>
       
        <section class="wrap-search page-admin">
                <form id="frmsearch" action="{{route('search-booking')}}" method="get">                
                <div class="row"> 
                                
                    <div class="col-md-3">
                        <div class="control-group">
                            <div class="form-group">                        
                                <input type="text" name="search_booking_by" class="form-control" id="search_booking_by"  placeholder="Search Booking By" autocomplete="off" value="<?php if(isset($_GET['search_booking_by'])){ echo $_GET['search_booking_by'];}?>">                        
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">                
                        <div class="control-group">                        
                            <div class="form-group">                                        
                                <select name="search_room_name" id="search_room_name" class="chosen form-control" value="old('room_name')">
                                <option value="">Choose room type</option>
                                @foreach($list_room as $roomList)
                                <option <?php if(isset($_GET['search_room_name'])){ if($_GET['search_room_name']==$roomList->room_id){echo "selected";} }?> value="{{$roomList->room_id}}">{{$roomList->building_name.' - '.$roomList->room_name}}</option>
                                @endforeach                                     
                                </select>                       
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">                
                        <div class="control-group">                        
                            <div class="form-group">
                            <input type = "text" name="search_meeting_date" id = "search_meeting_date" class="form-control" placeholder="Search by date" autocomplete="off">                                  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="control-group">                         
                            <div class="form-group">
                            <span class="icon-search"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" style="display:none;">
                </div><!--/row-->  
                </form><!--/form-->
        </section>

        <div id="table-wrapper">
            <div id="table-scroll">
            <div class="row"> 
                <div class="col-md-3"><a href="{{route('lists-booking.add-new')}}" class="add-new-booking"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></div>
            </div>    
                <table class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Booking By</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Purpose</th>                            
                            <th>Action</th>
                        </tr>
                        
                    </thead>
                    
                    <tbody>
                    @if(count($list_booking)>0)
                        @foreach($list_booking as $obj)
                            <tr class="<?php if($todays==$obj->date){echo 'pending';}else if($todays < $obj->date){echo 'warning';}else{echo 'danger';}?>">
                                <td><?php echo $i;?></td>
                                <td>{{ucfirst($obj->booking_by)}}</td>
                                <td>{{$obj->building_name.' - '.$obj->room_name}}</td>                        
                                <td>{{$obj->date}}</td>
                                <td><?php echo date('h:i A', strtotime($obj->start_time)); ?></td>
                                <td><?php echo date('h:i A', strtotime($obj->end_time)); ?></td>
                                <td>{{ucfirst($obj->purpose)}}</td>                                
                                <td>
                                    <a href="{{route('edit-booking',['id'=>$obj->id])}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><span class="clsor"> | </span>
                                    <a href="javascript:void(0)" data-id="{{$obj->id}}" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php $i++;?>
                        @endforeach
                    @else
                    <tr class="no-result"><td colspan="8">No data</td></tr>
                    @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Booking By</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Purpose</th>                            
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div><!--/col-xl-12 col-sm-8 mb-8-->
</div><!--/row-->

{{ $list_booking->appends(Input::except('page'))->links() }}

@section('scripts')

<script>     
    
    $(".chosen").chosen();
    $(".chosen-container-single").css({"width":"100%"});

    $(function() { 
        
        $('#search_meeting_date').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#search_meeting_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
        });

        $('#search_meeting_date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        
        });

        
        $('.btn-delete').click(function(event) {
            event.preventDefault();
            $("#modal").modal({
                escapeClose: false,
                clickClose: false,
                showClose: false,
                fadeDuration: 200
            });
            $(".cls-yes").attr('data-id',$(this).attr('data-id'));
        });
        
    $("body").on("click",".cls-yes",function(){
        var id=$(this).attr('data-id');
        $.ajax({
            type:"POST",
            url:"{{route('delete-booking')}}",
            data:{id:id,"_token": "{{ csrf_token() }}",},
            success:function(response){
                if(response.status==200){
                    location.reload();
                }
            },
        });
    });
    
        /*
        * Search script
        */
        $("body").on("blur","#search_booking_by",function(){    
                    
            $("#frmsearch").submit();            
        });

        $("body").on("change","#search_room_name",function(){            
            $("#frmsearch").submit();            
        });

        $("body").on("click",".applyBtn",function(){
            $("#frmsearch").submit();        
        });

        $("body").on("click",".icon-search",function(){
            $("#search_meeting_date").focus();
        });

</script>
@endsection
@endsection