@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow border-0">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

<i class="bi bi-bell-fill"></i>

Notifikasi

</h4>

</div>

<div class="card-body">

@forelse($notifications as $item)

<div class="border rounded p-3 mb-3">

<h6 class="fw-bold">

{{ $item->judul }}

</h6>

<p class="mb-1">

{{ $item->pesan }}

</p>

<small class="text-muted">

{{ $item->created_at->diffForHumans() }}

</small>

</div>

@empty

<div class="text-center text-muted">

Belum ada notifikasi.

</div>

@endforelse

</div>

</div>

</div>

@endsection