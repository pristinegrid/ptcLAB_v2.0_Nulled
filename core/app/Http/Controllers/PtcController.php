<?php

namespace App\Http\Controllers;

use App\Models\Ptc;
use App\Models\PtcView;
use App\Models\Transaction;
use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PtcController extends Controller
{
	public function index(){
    	$page_title = "PTC Ads";
    	$ads = Ptc::where('status',1)->where('remain','>',0)->inRandomOrder()->orderBy('remain','desc')->limit(50)->get();

    	$viewed = PtcView::where('user_id',auth()->user()->id)->where('vdt',Date('Y-m-d'))->pluck('ptc_id')->toArray();

    	$empty_message = "Ads Not Found";
    	return view(activeTemplate().'user.ptc.index',compact('ads','page_title','empty_message','viewed'));
    }

    public function show($hash){

	$decrypted = Crypt::decryptString($hash);
	$dcdata  = explode('|', $decrypted);
	$id = $dcdata[0];

		if($dcdata[1] != auth()->user()->id){
			$notify[] = ['error',"Opps! You are not aligable for this link"];
			return redirect()->route('user.home')->withNotify($notify);
		}
    	$page_title = "Show PTC";
    	$ptc = Ptc::where('id',$id)->where('remain','>',0)->where('status',1)->firstOrFail();
        $viewads = PtcView::where('user_id',auth()->user()->id)->where('vdt',Date('Y-m-d'))->get();
        if($viewads->count() == auth()->user()->dpl){
            $notify[] = ['error','Opps! Your limit is over. You cannot see more ads today'];
            return back()->withNotify($notify);
        }
        if ($viewads->where('ptc_id',$ptc->id)->first()) {
            $notify[] = ['error','You cannot see this add before 24 hour'];
            return back()->withNotify($notify);
        }
    	return view(activeTemplate().'user.ptc.show',compact('ptc','page_title'));
    }

    public function confirm($hash)
    {
        $user = auth()->user();
        $decrypted = Crypt::decryptString($hash);
        $dcdata  = explode('|', $decrypted);
        $id = $dcdata[0];
        if($dcdata[1] != $user->id){
            $notify[] = ['error',"Opps! You are not aligable for this link"];
            return redirect()->route('user.home')->withNotify($notify);
        }
        $ptc = Ptc::where('id',$id)->where('remain','>',0)->where('status',1)->firstOrFail();
        $viewads = PtcView::where('user_id',$user->id)->where('vdt',Date('Y-m-d'))->get();
        if($viewads->count() >= $user->dpl){
            $notify[] = ['error','Opps! Your limit is over. You cannot see more ads today'];
            return back()->withNotify($notify);
        }
        if ($viewads->where('ptc_id',$ptc->id)->first()) {
            $notify[] = ['error','You cannot see this add before 24 hour'];
            return back()->withNotify($notify);
        }
        $ptc->increment('showed');
        $ptc->decrement('remain');
        $ptc->save();

        $user->balance += $ptc->amount;
        $user->save();

        Transaction::create([
            'user_id'=>$user->id,
            'amount'=>$ptc->amount,
            'trx_type'=>'+',
            'charge'=>0,
            'details'=>'Earn amount from ads',
            'remark'=>'earn',
            'post_balance'=>$user->balance,
            'trx'=>getTrx(),
        ]);
        PtcView::create([
            'ptc_id'=>$ptc->id,
            'user_id'=>$user->id,
            'amount'=>$ptc->amount,
            'vdt'=>Date('Y-m-d'),
            'created_at'=>Carbon::now(),
        ]);
        $gnl = GeneralSetting::first();
        if ($gnl->ref_ptc == 1) {
                levelCommision($user->id, $ptc->amount, $commissionType = 'Ads View Commssion');
            }

        $notify[] = ['success','Successfully viewed this ads'];
        return redirect()->route('user.ptc.index')->withNotify($notify);
    }

    public function clicks()
    {
        $page_title = "PTC Clicks";
        $ptc = PtcView::where('user_id',auth()->user()->id)->get();
        $viewads = $ptc->groupBy('vdt')->map(function ($item,$key) {
            $data['clicks'] = collect($item)->count();
            $data['amount'] = collect($item)->sum('amount');
            $data['date'] = $key;
            return $data;
        })->sort()->reverse()->paginate(getPaginate());
        $empty_message = "No Click Found";
        return view(activeTemplate().'user.ptc.clicks',compact('viewads','page_title','empty_message'));
    }

}