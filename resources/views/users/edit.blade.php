@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="chart-box">

        <h3 class="mb-4">
            Edit User
        </h3>

        <form action="{{ route('users.update', $user->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label>Nama</label>

                <input type="text"
                       name="name"
                       value="{{ $user->name }}"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input type="email"
                       name="email"
                       value="{{ $user->email }}"
                       class="form-control">

            </div>

            <button class="btn btn-primary">
                Update
            </button>

        </form>

    </div>

</div>

@endsection