<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        switch (Auth::user()->role) {
            case 'manager':
                return redirect()->route('manager');
                break;
            case 'user':
                return view('user');
                break;
        }
    }

    public function home_store(Request $request)
    {
        $data = $request->validate([
            'topic'       => 'required|max:255',
            'message'       => 'required|max:500',
            'image'            => 'nullable|mimes:jpg,jpeg,png|max:50000'
        ]);
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['user_name'] = $user->name;
        $data['user_email'] = $user->email;
        Message::create($data);

        return redirect(route('user'));

    }

    public function manager()
    {
        $messages = Message::all();

        return view('manager', [
            'messages' => $messages
        ]);
    }

    public function manager_store(Request $request)
    {
        Message::where("id", $request->changed_id)->update([
            "status" => true
        ]);
        return redirect(route('manager'));
    }
}
