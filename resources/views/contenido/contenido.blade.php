@extends('principal')
@section('contenido')
@if (Auth::check())
@if (Auth::user()->id_rol == 1)

    <template v-if="menu==1">
        <cliente></cliente>
    </template>
    <template v-if="menu==3">
        <producto></producto>
    </template>
    <template v-if="menu==4">
        <usuarios></usuarios>
    </template>
    <template v-if="menu==5">
        <ventas></ventas>
    </template>
    <template v-if="menu==6">
        <rol></rol>
    </template>
    <template v-if="menu==8">
        <encargo></encargo>
    </template>
    @elseif (Auth::user()->id_rol == 2)
    <template v-if="menu==5">
        <ventas></ventas>
    </template>
    <template v-if="menu==1">
        <cliente></cliente>
    </template>
    <template v-if="menu==8">
        <encargo></encargo>
    </template>
    @endif
@endif
@endsection
