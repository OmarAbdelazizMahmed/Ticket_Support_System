<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use App\Comment;
class CommentsController extends Controller
{
    public function postComment(Request $request){
        $this->validate($request, [
            'comment' =>'required'
        ]);
        
        $comment = Comment::create([
            'ticket_id' => $request->input('ticket_id'),
            'user_id' =>Auth::user()->id,
            'comment' => $request->input('comment')
        ]);

        if($comment->ticket->user->id !== Auth::user()->id){
            Auth::user()->notify(new TicketCommented(Auth::user(),$comment->ticket,  $comment));
        }

        return redirect()->back()->with('status', 'Your comment has been submitted.');
    } 
    
    
}
