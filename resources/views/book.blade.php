@extends('layout.app')
@section('contents')
    
    <section>
        <!-- <div class="container">
            <h2 class="head-room-booking-title page-section-heading text-center text-uppercase text-secondary mb-0">Room Booking</h2>
            
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div> 
        </div> -->
    
        <div class="col-lg-10 cls-front-page mx-auto head-room-booking-title">
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

                @if(Session::has('info'))
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">		
                            <div class="alert alert-danger fade show" role="alert">          
                                    {!! Session::get('info')!!}   
                                
                            </div> 
                        </div>  
                    </div> 
                @endif

                <div class="card-header booking-room-title">ROOM BOOKING</div>
                <div class="card-body">                    
                    <form id="booking_room_form" action="{{route('room-booking.save')}}" method="post">
                        {!! csrf_field() !!}
                        <input type="text" name="booking_id" class="form-control" id="booking_id" style="display:none;">
                        <div class="row">                          
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Booking By <b>*</b></label>
                                        <input type="text" value="{{old('booking_by')}}" name="booking_by" class="form-control" id="booking_by"  placeholder="Booking By" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('booking_by')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Room Name</label>
                                    <div class="form-group">                                        
                                        <select name="room_name" class="chosen form-control">
                                        @foreach($list_room as $roomList)
                                        <option value="{{$roomList->room_id}}">{{$roomList->building_name.' - '.$roomList->room_name}}</option>
                                        @endforeach                                     
                                        </select>
                                        <span class="text-danger">{{$errors->first('room_name')}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Date</label>  
                                    <div class="form-group">
                                        <input type = "text" name="meeting_date" id = "meeting_date" class="form-control" autocomplete="off" value="{{old('meeting_date')}}">                                        
                                        <span class="text-danger">{{$errors->first('meeting_date')}}</span>                                        
                                    </div>
                                </div>
                            </div>

                        </div><!--/row-->

                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Start Time (12-Hour Time)</label>
                                        <input class="form-control" id="start_time" type="text" name="start_time" value="{{old('start_time')}}"/>
                                        <span class="text-danger">{{$errors->first('start_time')}}</span>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>End Time (12-Hour Time)</label>
                                        <input class="form-control" id="end_time" type="text" name="end_time" value="{{old('end_time')}}"/>
                                        <span class="text-danger">{{$errors->first('end_time')}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Purpose <b>*</b></label>
                                        <input type="text" name="purpose" class="form-control" id="purpose" value="{{old('purpose')}}" placeholder="Purpose" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('purpose')}}</span>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!--/row-->
                        
                        <div class="form-group text-right">                            
                            <button class="btn-save" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Create</button>
                        </div>
                        
                        
                    </form>
                </div>
            </div>
        
    </section> 

    <section>
        <div class="col-lg-10 mx-auto">
            
            <?php        
                $i=1;
                $todays =  date("Y-m-d");                
            ?>


            <section class="wrap-search">
                    <form id="frmsearch" action="{{route('room-booking.search')}}" method="get">
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

            <div class="result-search"></div>
            <div class="swap-data">
            <div id="table-wrapper">
                <div id="table-scroll">
                    <div class="row">
                        <div class="col-md-3">                            
                            @if(Request::segment(2)=='show-all')<a href="{{route('book')}}" class="add-new-booking cls-back"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Today</a>@endif                              
                            <a href="{{route('room-booking.show-all')}}" class="add-new-booking"><i class="fa fa-eye" aria-hidden="true"></i> Show all</a>                        
                        </div>
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
                                   
                                </tr>
                                <?php $i++;?>
                            @endforeach
                        @else
                        <tr class="no-result"><td colspan="7">No data</td></tr>
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
                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
    
            {{ $list_booking->appends(Input::except('page'))->links() }}
            
            </div><!--/swap-data-->
        </div>  
    </section>    

    @section('scripts')
  
    <script>     
      
        $(".chosen").chosen();
        $(".chosen-container-single").css({"width":"100%"});      

        $('#start_time').timepicki();     
        $('#end_time').timepicki(); 

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

        var _gotoToday = jQuery.datepicker._gotoToday;
        jQuery.datepicker._gotoToday = function(a){
            var target = jQuery(a);
            var inst = this._getInst(target[0]);
            _gotoToday.call(this, a);
            jQuery.datepicker._selectDate(a, jQuery.datepicker._formatDate(inst,inst.selectedDay, inst.selectedMonth, inst.selectedYear));
        }; 

        $(function() { 
            if(($("#booking_by").val()=='') && ($("#purpose").val() =='')){
                $('#meeting_date').datepicker({
                    showButtonPanel: true,
                    dateFormat : 'yy/mm/d',
                });

                $('#meeting_date').datepicker().datepicker('setDate', 'today');  
                $.datepicker._gotoToday = function(id) { 
                    $(id).datepicker('setDate', new Date()).datepicker('hide').blur(); 
                };  

                var d = new Date();
                var n = d.toLocaleString([], { hour: '2-digit', minute: '2-digit' });
                $("#start_time").val(n);
                $("#end_time").val(n);
            }
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
       
    </script>
     
    @endsection
@endsection