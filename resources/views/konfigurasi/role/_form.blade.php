@php $r = $role ?? null; @endphp

<div class="mb-3">
    <label>Nama Role</label>
    <input type="text" name="nama_role" class="form-control" value="{{ old('nama_role', $r->nama_role ?? '') }}">
    @error('nama_role') <small class="text-danger">{{ $message }}</small> @enderror
</div>