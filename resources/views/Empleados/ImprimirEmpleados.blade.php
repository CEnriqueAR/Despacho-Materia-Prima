@extends('layouts.MenuBanda')
@section('content')
    <center>
        <h1>Student Information List </h1>
        <table class="table" >
            <tr><th>Id</th><th>Name</th><th>Email</th><th>Course</th></tr>
            @foreach($empleado as $empleado)
                <tr><td>{{ $empleado->codigo }}</td>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->puesto }}</td>
                </tr>
        @endforeach
    </center>
@endsection