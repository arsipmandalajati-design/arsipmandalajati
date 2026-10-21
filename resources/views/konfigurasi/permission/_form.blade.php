@php $p = $permission ?? null; @endphp

<div class="mb-3">
    <label>Module (nama menu terkait, misal: arsip, users, agenda)</label>
    <input type="text" name="module" class="form-control" value="{{ old('module', $p->module ?? '') }}">
    @error('module') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Nama Aksi (create / read / update / delete)</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $p->name ?? '') }}">
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>