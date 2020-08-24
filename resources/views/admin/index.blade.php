@extends('layouts._admin')

@section('content')
    <div class="FSPanel">
        <div id="js-admin-container" class="FSPanel__container">
            <div class="LogBook LogBook__full">
                <h2 class="LogBook__title">{{ $signedOut }} Currently signed out</h2>
                <form class="LogBook__controls" method="POST" action="{{ route('admin.status.destroy') }}">
                    {{ csrf_field() }}
                    <button value="overdue" class="Button" name="bulk" type="submit">Sign in overdue</button>
                    <button value="all" class="Button" name="bulk" type="submit">Sign in all</button>
                    <a href="#" @click="type = 'manual'" class="js-overlay-trigger Button">Sign someone out</a>
                </form>
                <ul class="LogBook__lines LogBook__lines--admin">
                    <form method="POST" action="{{ route('admin.status.destroy') }}">
                        {{ csrf_field() }}
                        @foreach ($groups as $group)
                            @foreach ($group->markers as $marker)
                                <li class="LogBook__line {{ $group->overdue ? 'LogBook__line--overdue' : null }}" data-marker="{{ $marker->id }}">
                                    <div class="LogBook__line-content">
                                        <div class="LogBook__line-name">{{ $marker->name }}</div>
                                        <div class="LogBook__line-status">{{ $group->status }}</div>
                                        <div class="LogBook__line-datetime">{{ $group->signedOutAt() }}</div>
                                        <div class="LogBook__line-datetime">
                                            {{ $group->returningAt() }}
                                        </div>
                                        <button class="Button Button--small LogBook__line-delete" name="single" value="{{ $marker->name }}" type="submit">Sign in</button>
                                    </div>
                                </li>
                            @endforeach
                        @endforeach
                    </form>
                </ul>
            </div>
            <div class="LogBook LogBook__full">
                <h2 class="LogBook__title">Create Employee</h2>
                <form class="Form Form--flex" method="POST" action="{{ route('admin.employee.store') }}">
                    {{ csrf_field() }}
                    <input class="Form__input" type="text" name="name" placeholder="Employee Name">
                    <button class="Button" type="submit">Create Employee</button>
                </form>
            </div>
            <div class="LogBook LogBook__full">
                <h2 class="LogBook__title">Delete Employee</h2>
                <div class="Form Form--flex">
                    <select ref="employee_removal_id" name="employee_id" class="Form__select">
                        <option selected disabled value="">Select Employee</option>
                        @foreach($employees->sortBy('name') as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                    <button class="Button" @click.prevent="confirmEmployeeRemoval()">DELETE</button>
                </div>
                @foreach($employees as $employee)
                    <div v-cloak v-if="removeEmployeeID == {{ $employee->id }}" class="Form Form--flex">
                        <form method="POST" action="{{ route('admin.employee.destroy', $employee) }}">
                            {{ csrf_field() }}
                            <button class="Button Button--warning" type="select">Confirm deletion of {{ $employee->name }}</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('partials.signout')
@endsection
