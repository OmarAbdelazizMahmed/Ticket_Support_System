<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Ticket;

use App\Notifications\TicketCreated;
use Illuminate\Support\Facades\Auth;
class TicketsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $tickets = Ticket::paginate(10);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function create(){
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }
    public function store(Request $request,TicketCreated $mailer){
        //validation
        $this->validate($request, [
            'title'=> 'required',
            'category' => 'required',
            'priority' => 'required',
            'message' => 'required'
        ]);
        //instantiating new object
        $ticket = new Ticket([
            'title' => $request->input('title'),
            'user_id' => Auth::user()->id,
            'ticket_id' => strtoupper(str_random(10)),
            'category_id' => $request->input('category'),
            'priority' => $request->input('priority'),
            'message' => $request->input('message'),
            'status' =>'Open'
        ]);
        $ticket->save();
        Auth::user()->notify(new TicketCreated(Auth::user(), $ticket));
        $msg =  'Aticket with ID: # '.$ticket->ticket_id.' has been opened.';
        return redirect()->back()->with('status',$msg);
        
    }
    public function userTickets(){
        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();

        return view('tickets.user_tickets', compact('tickets', 'categories'));
    }
    public function show($ticket_id){
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        
        $comments = $ticket->comments;

        $category = $ticket->category;

        return view('tickets.show',compact('ticket','comments','category'));
    }

    public function close($ticket_id){
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Closed';

        $ticket->save();

        $ticketOwner = $ticket->user;

        $ticketOwner->notify(new TicketClosed($ticketOwner, $ticket));
        return redirect()->back()->with('status','The ticket has been close');
    }
}
