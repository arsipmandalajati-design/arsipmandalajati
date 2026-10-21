@extends('layouts.app')

@section('page-icon')
<i class="bi bi-send-fill"></i>
@endsection

@section('page-title')
Role dan Hak akses
@endsection

@section('page-description')
Kelola peran pengguna sesuai dengan kewenangannya di Kecamatan Mandalajati.
@endsection

@section('content')

<div class="container">
    <h4 class="mb-3">Role & Hak Akses</h4>
    <p class="text-muted">Pilih role, lalu nyalakan/matikan aksi yang diizinkan. Perubahan otomatis tersimpan.</p>

    <div class="row mb-3">
        <div class="col-md-4">
            <label>Pilih Role</label>
            <select id="roleSelect" class="form-select">
                <option value="">-- Pilih Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label>Cari Menu</label>
            <input type="text" id="cariMenu" class="form-control" placeholder="Ketik nama menu...">
        </div>
    </div>

    <div id="alertBox"></div>

    <table class="table table-bordered align-middle" id="tabelMatrix" style="display:none;">
        <thead class="table-dark">
            <tr>
                <th style="width:25%">Menu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="matrixBody"></tbody>
    </table>

    <div id="emptyState" class="text-muted">Pilih role dulu untuk mengatur hak aksesnya.</div>
</div>

<style>
    #tabelMatrix td { vertical-align: middle; }
    #tabelMatrix .form-check-input:checked { background-color: #0d6efd; border-color: #0d6efd; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {

    function loadMatrix(roleId) {
    $.get("{{ route('konfigurasi.akses-role.matrix') }}", { role_id: roleId }, function (data) {
        let html = '';
        data.forEach(menu => {
            let actions = menu.actions.map(a => `
                <div class="form-check form-switch d-inline-block me-4">
                    <input type="checkbox" class="form-check-input toggle-permission" role="switch"
                        style="width:2.5em; height:1.3em; cursor:pointer;"
                        data-role="${roleId}" data-permission="${a.permission_id}"
                        ${a.active ? 'checked' : ''}>
                    <label class="form-check-label ms-1">${a.name}</label>
                </div>`).join('');
            html += `<tr><td class="fw-semibold">${menu.nama_menu}</td><td class="py-3">${actions}</td></tr>`;
        });
        $('#matrixBody').html(html);
        $('#tabelMatrix').show();
        $('#emptyState').hide();
    });
}

    $('#roleSelect').on('change', function () {
        const roleId = $(this).val();
        if (!roleId) { $('#tabelMatrix').hide(); $('#emptyState').show(); return; }
        loadMatrix(roleId);
    });

    $(document).on('change', '.toggle-permission', function () {
        $.post("{{ route('konfigurasi.akses-role.toggle') }}", {
            _token: '{{ csrf_token() }}',
            role_id: $(this).data('role'),
            permission_id: $(this).data('permission'),
            is_active: $(this).is(':checked') ? 1 : 0,
        }, function () {
            $('#alertBox').html('<div class="alert alert-success py-1 px-2 small" style="max-width:200px">Tersimpan</div>');
            setTimeout(() => $('#alertBox').html(''), 1200);
        });
    });

    $('#btnCopy').on('click', function () {
        const sourceId = $('#copySource').val();
        const targetId = $('#roleSelect').val();
        if (!sourceId || !targetId) { alert('Pilih role tujuan dan role sumber dulu.'); return; }
        if (sourceId === targetId) { alert('Role sumber dan tujuan tidak boleh sama.'); return; }
        if (!confirm('Ini akan menimpa hak akses role tujuan. Lanjutkan?')) return;

        $.post("{{ route('konfigurasi.akses-role.copy') }}", {
            _token: '{{ csrf_token() }}',
            source_role_id: sourceId,
            target_role_id: targetId,
        }, function () { loadMatrix(targetId); });
    });

    $('#cariMenu').on('keyup', function () {
        const q = $(this).val().toLowerCase();
        $('#matrixBody tr').filter(function () {
            $(this).toggle($(this).find('td:first').text().toLowerCase().indexOf(q) > -1);
        });
    });

});
</script>
@endsection