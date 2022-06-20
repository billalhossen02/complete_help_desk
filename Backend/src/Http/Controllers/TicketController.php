<?php

namespace Cinebaz\SupportTicket\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Cinebaz\SupportTicket\Models\SupportDetail;
use Cinebaz\SupportTicket\Models\Support;
use Cinebaz\SupportTicket\Models\Rating;


class TicketController extends Controller
{

    public function adminTicket()
    {

        $data = Support::latest()->paginate(5);
        return view('billal::admin/allticket',['data' => $data]);

    }

    public function editTicket(Request $request)
    {
        $id = $request->id;
        $data = Support::find($id);
        return view('billal::admin/update',compact('data'));
    }

    public function updateTicket(Request $request)
    {
        $id = $request->id;
        Support::find($id)->update([
  
            'status' => $request->status

        ]);

        return redirect()->route('admin.support.template');
    }

    public function deleteTicket($id)
    {
        $data = Support::find($id)->delete();
        return redirect()->route('admin.support.template');
    }


    public function reply(Request $request)
    {
        $image_path =array();
        
         if ($attachment = $request->file('attachment')){

            foreach($attachment as $image){

            $dest = 'Support/'.date('Ymd');
            $getext = hexdec(uniqid()). '.' .$image->getClientOriginalExtension();
            $image->storeAs($dest,$getext);
            $image_path[] = $dest.'/'.$getext;

        }
                
            SupportDetail::insert([
                'support_id' => $request->id,
                'user_id'  =>auth::user()->id,
                'member_id' => null,
                'message' => $request->message,
                'attachment' => implode ("|" ,$image_path),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

           
        }

        else

        {
            SupportDetail::insert([
            'support_id' => $request->id,
            'user_id'  =>auth::user()->id,
            'member_id' => null,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ]);
        }

            return redirect()->back();

    }


    public function adminReply(Request $request)
    {
        $id = $request->id;
        $data = Support::find($id);
        return view('billal::admin/reply',['data' => $data]);
    }

    public function show(Request $request)
    {
        
        return view('billal::admin/show', ['image'=> $request->image,'from'=>$request->from]);

    }

}
