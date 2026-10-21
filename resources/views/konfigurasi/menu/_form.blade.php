@php $m = $menu ?? null; @endphp

<div class="mb-3">
    <label>Nama Menu</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $m->name ?? '') }}">
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Slug (nama route pendek, huruf kecil, tanpa spasi)</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', $m->slug ?? '') }}">
    @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-3">
    <label>Route (nama route Laravel, misal arsip.index)</label>
    <input type="text" name="route" class="form-control" value="{{ old('route', $m->route ?? '') }}">
</div>

<div class="mb-3">
    <label>Icon (class bootstrap icon, misal bi bi-folder)</label>
    <input type="text" name="icon" class="form-control" value="{{ old('icon', $m->icon ?? '') }}">
</div>

<div class="mb-3">
    <label>Urutan</label>
    <input type="number" name="order" class="form-control" value="{{ old('order', $m->order ?? 0) }}">
</div>