@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                <ul class="users">
                @foreach ($users as $user)
                    <li class="user" id="{{ $user->id }}">
                        <span class="pending">1</span>
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ $user->avatar }}" alt="" class="media-object">
                            </div>
                            <div class="media-body">
                                <p class="name">{{ $user->name }}</p>
                                <p class="email">{{ $user->email }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-6" id="messages">
            <div class="message-wrapper">
                <ul class="messages">
                    <li class="message clearfix">
                        <div class="sent">
                            <p>Test</p>
                            <p class="date">1 Sep, 2020</p>
                        </div>
                    </li>
                    <li class="message clearfix">
                        <div class="received">
                            <p>Test</p>
                            <p class="date">1 Sep, 2020</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="input-text">
                <input type="text" name="message" class="submit">
            </div>
        </div>
    </div>
</div>
@endsection