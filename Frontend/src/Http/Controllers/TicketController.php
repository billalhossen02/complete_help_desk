<?php

namespace Cinebaz\SupportTicket\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Cinebaz\SupportTicket\Models\Support;
use Cinebaz\SupportTicket\Models\SupportDetail;
use Cinebaz\SupportTicket\Models\Image;
use Cinebaz\SupportTicket\Models\Rating;
use Cinebaz\SupportTicket\Models\UserReply;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Cinebaz\SupportTicket\Http\Requests\SupportFV;





class TicketController extends Controller
{

    public function ticket()
    {
        $user = Member::find(auth('member')->user()->id);
        return view('billal::create',compact('user'));
    }

    public function storeData(Request $request)
    {
        $data = new Support();
        $data->user_id = auth('member')->user()->id;
        $data->user_name = $request->name;
        $data->user_email = $request->email;
        $data->subject = $request->subject;
        $data->department = $request->department;
        $data->priority = $request->priority;
        $data->message = $request->message;


       if($attachment = $request->file('attachment'))

            {

                $dest = 'Support/'.date('Ymd');
                $getext = date('Ymdhis'). '.' .$attachment->getClientOriginalExtension();
                $attachment->storeAs('public/'.$dest, $getext);
                $data->attachment = $dest.'/'.$getext;


            }

      else

        {
            $data->attachment = 'NULL';
        }

        $data->save();

        return redirect()->route('member.auth.myticket',[app()->getLocale()])->with('success','Ticket created successfully.');

    }


    public function myTicket()
    {
        $member = auth('member')->user();
        $id = $member->id;
        $user = Member::find($id);
        $data = Support::where('user_id', $id)->latest()->paginate(5);
        return view('billal::allticket',['data' => $data, 'user' => $user]);
    }


    public function replyBlade(Request $request)
    {
 
        $user = Member::find(auth('member')->user()->id);
        $id = $request->id;
        $data = Support::find($id);
        return view('billal::reply',compact('data','user'));
    }

    public function userReply(SupportFV $request)
    {

        $image_path =array();

        if ($attachment = $request->file('attachment')){

           foreach($attachment as $image){

        $dest = 'Support/'.date('Ymd');
        $getext = hexdec(uniqid()). '.' .$image->getClientOriginalExtension();
        $image->storeAs('public/'.$dest,$getext);
        $image_path[] = $dest.'/'.$getext;
        

       }

        SupportDetail::insert([
            'support_id' => $request->id,
            'attachment' => implode ("|" ,$image_path),
            'member_id' => auth('member')->user()->id,
            'user_id' => null,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    else

    {
        SupportDetail::insert([
            'support_id' => $request->id,
            'member_id' => auth('member')->user()->id,
            'user_id' => null,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

        return redirect()->back();

    }

    public function show(Request $request)
    {
        $user = Member::find(auth('member')->user()->id);
        return view('billal::show', ['image'=> $request->image, 'user' => $user, 'from' =>$request->from] );

    }


    public function rating(Request $request)
    {
        $id = $request->id;
        $data = new Rating();
        $data->support_id = $id;
        $data->comment = $request->comment;
        $data->value = $request->rating;
        $data->save();

        return redirect()->back();
    }

    public function updateStatus(Request $request){

       $id = $request->id;
       Support::find($id)->update([

            'status' => $request->status,
       ]);

        return redirect()->back();

    }
}
