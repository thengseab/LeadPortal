<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\room_booking;
use DB;
use Illuminate\Foundation\Http\FormRequest;

class BookController extends Controller
{
    public function index(){
        
        $today=date("Y-m-d");        
        $list_room=DB::table('rooms')                    
                    ->join('floors', 'rooms.floor_id', '=', 'floors.id')
                    ->join('buildings', 'floors.building_id', '=', 'buildings.id')
                    ->select('rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
                    ->where('rooms.status', 0)
                    ->get();
        
        $list_booking=DB::table('room_bookings')   
                        ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
                        ->join('floors', 'rooms.floor_id', '=', 'floors.id')
                        ->join('buildings', 'floors.building_id', '=', 'buildings.id')
                        ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
                        ->where('room_bookings.status', 0)
                        ->where('room_bookings.date',$today)
                        ->orderBy('room_bookings.date', 'DESC')
                        ->paginate(10);
        return view("book",compact("list_booking","list_room"));
    }

    public function listsBooking(){

        $list_room=DB::table('rooms')                    
                    ->join('floors', 'rooms.floor_id', '=', 'floors.id')
                    ->join('buildings', 'floors.building_id', '=', 'buildings.id')
                    ->select('rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
                    ->where('rooms.status', 0)
                    ->get();

        $list_booking=DB::table('room_bookings')   
                        ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
                        ->join('floors', 'rooms.floor_id', '=', 'floors.id')
                        ->join('buildings', 'floors.building_id', '=', 'buildings.id')
                        ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
                        ->where('room_bookings.status', 0)                        
                        ->orderBy('room_bookings.date', 'DESC')
                        ->paginate(10);
        return view("book",compact("list_booking","list_room"));
    }

    public function save(Request $request){        
        
        $this->validate($request,[
            'booking_by'=>'required|max:50',
            'room_name'=>'required',
            'meeting_date'=>'required',
            'start_time' => 'required',
            'end_time'=>'required|after:start_time',  
            'purpose'=>'required|max:100',
            
        ],
        [
            'booking_by.required' => 'This field is required',
            'room_name.required' => 'This field is required',
            'meeting_date.required' => 'This field is required',
            'start_time.required' => 'This field is required',
            'end_time.required' => 'This field is required',
            'end_time.after' => 'End Time must be greater than start Time',
            'purpose.required' => 'This field is required',
        ]);

        $today=date("Y-m-d");
        $date_booking=date("Y-m-d", strtotime($request->meeting_date));
        $start_time=date("H:i:s", strtotime($request->start_time));
        $end_time=date("H:i:s", strtotime($request->end_time));

        $room_bookings=new room_booking();
        $room_bookings->booking_by=$request->booking_by;
        $room_bookings->room_id=$request->room_name;
        $room_bookings->date=$date_booking;
        $room_bookings->start_time=$start_time;
        $room_bookings->end_time=$end_time;
        $room_bookings->purpose=$request->purpose;
        if($date_booking > $today){
            $room_bookings->verify=0;
        }else{
            $room_bookings->verify=1;
        } 
        
        $exist=room_booking::where('date',$date_booking)    
               ->where('id','<>',$request->booking_id)  
               ->where('status',0)         
               ->where('room_id',$request->room_name)
               ->where('start_time','<=',$start_time)
               ->where('end_time','>',$start_time)->first();  

        if ((!is_null($exist)) && ($exist != $request->booking_id)){
            \Session::flash('info','There is already a booking in that start time <br> There is already a booking between that start and  end time !');    		
            return redirect()->back()->withInput()->withErrors('error');
                
        }
        $exist_start_time  = room_booking::where('date',$date_booking)
                ->where('id','<>',$request->booking_id) 
                ->where('status',0)
                ->where('room_id',$request->room_name)
                ->where('start_time','<',$end_time)
                ->where('start_time','>', $start_time)->first();
        
        if($exist_start_time != $request->booking_id){
            if (!is_null($exist_start_time)) {
                \Session::flash('info','There is already a booking between that start and  end time <br> There is already a booking in that end time !');    		
                    return redirect()->back()->withInput()->withErrors('error');
            }
        }
        $exist_end_time  = room_booking::where('date',$date_booking)
                ->where('id','<>',$request->booking_id) 
                ->where('status',0)
                ->where('room_id',$request->room_name)
                ->where('start_time','<', $end_time)
                ->where('end_time','>', $end_time)->first();  

        if($exist_end_time != $request->booking_id){
            if (!is_null($exist_end_time)) {                        
                \Session::flash('info','There is already a booking in that end time !');    		
                return redirect()->back()->withInput()->withErrors('error');
            }
        }

        if($room_bookings->save()){
            \Session::flash('message','Add Successfully !');    		
            return redirect()->back();
        }
        return redirect()->back()->withInput()->withErrors('error');

        

    }

    public function search(Request $request){

        $list_room=DB::table('rooms')                    
        ->join('floors', 'rooms.floor_id', '=', 'floors.id')
        ->join('buildings', 'floors.building_id', '=', 'buildings.id')
        ->select('rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
        ->where('rooms.status', 0)
        ->get();

        if(isset($_GET['search_meeting_date']) && !empty($_GET['search_meeting_date'])){

            $path=explode("-",$request->search_meeting_date);
            $start_date=date_create($path[0]);
            $end_date=date_create($path[1]);        
            $from=date_format($start_date,"Y-m-d"); 
            $to=date_format($end_date,"Y-m-d"); 

        }
       
        if(!empty($_GET['search_booking_by']) && !empty($_GET['search_room_name']) && !empty($_GET['search_meeting_date'])){

            $list_booking=DB::table('room_bookings')   
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
            ->where('room_bookings.status', 0)
            ->where('room_bookings.booking_by','like','%'.$request->search_booking_by.'%')
            ->where('room_bookings.room_id',$request->search_room_name)
            ->whereBetween('room_bookings.date',array($from,$to))
            ->orderBy('room_bookings.date', 'DESC')
            ->paginate(10);           

        }else if(!empty($_GET['search_booking_by']) && !empty($_GET['search_room_name'])){

            $list_booking=DB::table('room_bookings')   
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
            ->where('room_bookings.status', 0)
            ->where('room_bookings.booking_by','like','%'.$request->search_booking_by.'%')
            ->where('room_bookings.room_id',$request->search_room_name)
            ->orderBy('room_bookings.date', 'DESC')
            ->paginate(10);           

        }else if(!empty($_GET['search_booking_by']) && !empty($_GET['search_meeting_date'])){

            $list_booking=DB::table('room_bookings')   
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
            ->where('room_bookings.status', 0)
            ->where('room_bookings.booking_by','like','%'.$request->search_booking_by.'%')
            ->whereBetween('room_bookings.date',array($from,$to))
            ->orderBy('room_bookings.date', 'DESC')
            ->paginate(10);            

        }else if(!empty($_GET['search_room_name']) && !empty($_GET['search_meeting_date'])){

            $list_booking=DB::table('room_bookings')   
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
            ->where('room_bookings.status', 0)            
            ->where('room_bookings.room_id',$request->search_room_name)
            ->whereBetween('room_bookings.date',array($from,$to))
            ->orderBy('room_bookings.date', 'DESC')
            ->paginate(10);           

        }else if(!empty($_GET['search_booking_by']) && empty($_GET['search_room_name']) && empty($_GET['search_meeting_date'])){

            $list_booking=DB::table('room_bookings')   
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
            ->where('room_bookings.status', 0)
            ->where('room_bookings.booking_by','like','%'.$request->search_booking_by.'%')            
            ->orderBy('room_bookings.date', 'DESC')
            ->paginate(10);            

        }else if(empty($_GET['search_booking_by']) && !empty($_GET['search_room_name']) && empty($_GET['search_meeting_date'])){

            $list_booking=DB::table('room_bookings')   
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
            ->where('room_bookings.status', 0)            
            ->where('room_bookings.room_id',$request->search_room_name)
            ->orderBy('room_bookings.date', 'DESC')
            ->paginate(10);           

        }else if(empty($_GET['search_booking_by']) && empty($_GET['search_room_name']) && !empty($_GET['search_meeting_date'])){

            $list_booking=DB::table('room_bookings')   
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
            ->where('room_bookings.status', 0)
            ->whereBetween('room_bookings.date',array($from,$to))
            ->orderBy('room_bookings.date', 'DESC')
            ->paginate(10);  

        }else{
            $list_booking=DB::table('room_bookings')   
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')                 
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('room_bookings.*','rooms.name AS room_name','rooms.id AS room_id', 'floors.name AS floor_name', 'buildings.name AS building_name')
            ->where('room_bookings.status', 0)
            ->orderBy('room_bookings.date', 'DESC')
            ->paginate(10);
            
        }
        return view("book",compact("list_booking","list_room"));
    }

    
}
