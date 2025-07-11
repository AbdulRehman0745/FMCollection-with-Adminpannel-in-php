@extends('backEnd.layouts.master')
@section('title', 'Contact Page')
@section('content')

<!-- Animation and Styling -->
<style>
    .container {
        animation: fadeIn 1.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }

    .reply-btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .reply-btn:hover {
        background-color: #218838;
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    .delete-btn:hover {
        background-color: #c82333;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background-color: #343a40;
        color: white;
    }

    .modal-body {
        padding: 15px;
    }

    .modal-footer {
        text-align: center;
    }
</style>

<!-- Contact Messages Section -->
<div class="container mt-5">
    <h2 class="text-center">Contact Messages</h2>

    @if($messages->isEmpty())
        <p class="text-center">No messages found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                    <tr>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ Str::limit($message->message, 50) }}</td>
                        <td>
                            <!-- Reply Button -->
                            <button class="reply-btn" data-toggle="modal" data-target="#replyModal{{ $message->id }}">Reply</button>

                            <!-- Delete Button -->
                            <form action="#" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Reply Modal -->
                    <div class="modal fade" id="replyModal{{ $message->id }}" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="replyModalLabel">Reply to Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="#" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="replyMessage">Reply:</label>
                                            <textarea class="form-control" id="replyMessage" name="replyMessage" rows="4" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Send Reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
