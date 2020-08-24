@extends('layouts._base')

@section('base-content')
    <div class="FSPanel">
        <img src="{{ asset('images/logo.svg') }}" alt="" class="FSPanel__logo">
        <button v-if="beta" @click="type = 'camera'" class="js-overlay-trigger Button Button--sign-out"><span>📷</span><span>Sign out</span></button>
        <button @click="type = 'manual'" class="js-overlay-trigger Button Button--sign-out"><span>👋</span><span>Sign out</span></button>
    </div>
    <div class="LogBook">
        <div class="LogBook__label"><span>Pull up to see who's out</span><img src="{{ asset('images/chev-up.svg') }}" alt=""></div>
        <h2 class="LogBook__title">Swipe your name left</h2>
        <p class="LogBook__time">to sign back into the office</p>
        <ul class="LogBook__lines">
            @foreach ($groups as $group)
                @foreach ($group->markers as $marker)
                    <li class="js-line-parent LogBook__line" data-marker="{{ $marker->id }}">
                        <div class="js-line LogBook__line-content">
                            <div class="LogBook__line-name">{{ $marker->name }}</div>
                            <div class="LogBook__line-status">{{ $group->status }}</div>
                            <div class="LogBook__line-datetime">{{ $group->signedOutAt() }}</div>
                            <div class="LogBook__line-datetime">{{ $group->returningAt() }}</div>
                        </div>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
    @include('partials.signout')
@endsection
