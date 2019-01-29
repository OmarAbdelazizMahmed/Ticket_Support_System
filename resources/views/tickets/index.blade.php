@extends('laypouts.app')

@section('title', 'All Tickets')


@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
                <div class="card">
                        <div class="card-header">
                            <i class="fa fa-tickets"> Tickets</i>
                        </div>
        
                        <div class="card-body">
                                @if ($tickets->Empty())
                                    <p>There are currently no tickets.</p>
                                @else
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>title</th>
                                                <th>Status</th>
                                                <th>Last Updated</th>
                                                <th style="text-align:center" colspan="2">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tickets as $ticket)
                                                <tr>
                                                    <td>
                                                        @foreach ($categories as $category)
                                                            @if ($category->id === $ticket->category_id)
                                                                {{ $category->name}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('tickets/'.$ticket->ticket_id)}}">
                                                            #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if ($ticket->status == 'Open')
                                                            <span class="badge badge-success">{{ $ticket->status }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ $ticket->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $ticket->updated_at}}</td>
                                                    <td>
                                                        <a href="{{ url('tickets/'.$ticket->ticket_id)}}" class="btn btn-primary">Comment</a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ url('admin/close_ticket/'.$ticket->ticket_id)}}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-danger" type="submit">Close</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$ticket->render()}}
                                @endif
                            </div>
                    </div>
            </div>
    </div>
@endsection