@extends('admin.layout.app')
@section('contents')
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">            
        <a href="{{ route('lists-booking',['action'=>'all']) }}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back</a>           
    </li>
        
</ol>
<!-- Icon Cards-->
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

                @if(Session::has('info'))
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">		
                            <div class="alert alert-danger fade show" role="alert">          
                                    {!! Session::get('info')!!}                                   
                            </div> 
                        </div>  
                    </div> 
                @endif

                <div class="card-header admin-page-booking-room-title">ROOM BOOKING</div>
                <div class="card-body admin-page">                    
                    <form id="booking_room_form" action="{{!empty($list_booking->id)? route('update-booking',['id'=>$list_booking->id]):route('lists-booking.save')}}" method="post">
                        {!! csrf_field() !!}
                        <input type="text" name="booking_id" class="form-control" id="booking_id" value="{{!empty($list_booking->id)? $list_booking->id:''}}" style="display:none;">
                        <div class="row">                          
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Booking By <b>*</b></label>
                                        <input type="text" value="{{!empty($list_booking->id)? $list_booking->booking_by:old('booking_by')}}" name="booking_by" class="form-control" id="booking_by"  placeholder="Booking By" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('booking_by')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="control-group">
                                    <label>Room Name</label>
                                    <div class="form-group">                                        
                                        <select name="room_name" class="chosen form-control" value="old('room_name')">
                                        @foreach($list_room as $roomList)
                                        <option <?php if(!empty($list_booking->id)){if($list_booking->room_id==$roomList->room_id){echo "selected";}}?> value="{{$roomList->room_id}}">{{$roomList->building_name.' - '.$roomList->room_name}}</option>
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
                                        <input type = "text" name="meeting_date" id = "meeting_date" class="form-control" autocomplete="off" value="{{!empty($list_booking->id)? date('Y/m/d',strtotime($list_booking->date)):old('meeting_date')}}">                                        
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
                                        <input class="form-control" id="start_time" type="text" name="start_time" value="{{!empty($list_booking->id)? date('h:i A',strtotime($list_booking->start_time)):old('start_time')}}"/>
                                        <span class="text-danger">{{$errors->first('start_time')}}</span>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>End Time (12-Hour Time)</label>
                                        <input class="form-control" id="end_time" type="text" name="end_time" value="{{!empty($list_booking->id)? date('h:i A',strtotime($list_booking->end_time)):old('end_time')}}"/>
                                        <span class="text-danger">{{$errors->first('end_time')}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="control-group">
                                    <div class="form-group">
                                        <label>Purpose <b>*</b></label>
                                        <input type="text" name="purpose" class="form-control" id="purpose" value="{{!empty($list_booking->id)? $list_booking->purpose:old('purpose')}}" placeholder="Purpose" autocomplete="off">
                                        <span class="text-danger">{{$errors->first('purpose')}}</span>
                                    </div>
                                </div>
                            </div>
                            
                        </div><!--/row-->
                        
                        <div class="form-group text-right">
                            
                            <button class="btn-save" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i>{{!empty($list_booking->id)? ' Save':' Create'}}</button>
                        </div>
                    </form>
                </div>
                    
        </section> 
</div><!--/ col-xl-12 col-sm-8 mb-8 -->
</div><!--/ row-->

@section('scripts')

<script>     
    
    $(".chosen").chosen();
        $(".chosen-container-single").css({"width":"100%"});      

        $('#start_time').timepicki();     
        $('#end_time').timepicki(); 

        var pathArray = window.location.pathname.split('/');
        if(pathArray[3]!='edit'){

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
                
        }else{
            $(function() { 
                $('#meeting_date').datepicker({
                    showButtonPanel: true,
                    dateFormat : 'yy/mm/d',            

                });                              

            });           

            var _gotoToday = jQuery.datepicker._gotoToday;
            jQuery.datepicker._gotoToday = function(a){
                var target = jQuery(a);
                var inst = this._getInst(target[0]);
                _gotoToday.call(this, a);
                jQuery.datepicker._selectDate(a, jQuery.datepicker._formatDate(inst,inst.selectedDay, inst.selectedMonth, inst.selectedYear));
            };     

            $('#start_time').timepicki();     
            $('#end_time').timepicki(); 
        }
        
</script>
@endsection
@endsection