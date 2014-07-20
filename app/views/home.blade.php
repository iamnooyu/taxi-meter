@extends('layout')

@section('content')
    <form method="post" action="calculate">
		From: <input type="text" name="from">  To : <input type="text" name="to"> <input type="submit" value="Calculate"> 
    </form>
@stop