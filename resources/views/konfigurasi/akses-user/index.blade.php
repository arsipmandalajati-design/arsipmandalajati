@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Akses User (Override Per Orang)</h4>
    <p class="text-muted">Dipakai untuk kasus khusus — kasih akses tambahan ke satu orang tanpa mengubah role-nya. Untuk pengaturan akses per role, pakai menu <strong>Akses Role</strong>.</p>

    <div class="row mb-3">
        <div class="col-md-5">
            <label>Pilih User</label>
            <select id="userSelect" class="form-select">
                <option value="">-- Pilih User --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role ?? '-' }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
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

    <div id="emptyState" class="text-muted">Pilih user dulu untuk mengatur akses tambahannya.</div>
</div>

<style>
    #tabelMatrix td { vertical-align: middle; }
    #tabelMatrix .form-check-input:checked { background-color: #0d6efd; border-color: #0d6efd; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function loadMatrix(userId) {
        $.get("{{ route('konfigurasi.akses-user.matrix') }}", { user_id: userId }, function (data) {
            let html = '';
            data.forEach(menu => {
                let actions = menu.actions.map(a => `
                    <div class="form-check form-switch d-inline-block me-4">
                        <input type="checkbox" class="form-check-input toggle-permission" role="switch"
                            style="width:2.5em; height:1.3em; cursor:pointer;"
                            data-user="${userId}" data-permission="${a.permission_id}"
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

    $('#userSelect').on('change', function () {
        const userId = $(this).val();
        if (!userId) { $('#tabelMatrix').hide(); $('#emptyState').show(); return; }
        loadMatrix(userId);
    });

    $(document).on('change', '.toggle-permission', function () {
        $.post("{{ route('konfigurasi.akses-user.toggle') }}", {
            _token: '{{ csrf_token() }}',
            user_id: $(this).data('user'),
            permission_id: $(this).data('permission'),
            is_active: $(this).is(':checked') ? 1 : 0,
        }, function () {
            $('#alertBox').html('<div class="alert alert-success py-1 px-2 small" style="max-width:200px">Tersimpan</div>');
            setTimeout(() => $('#alertBox').html(''), 1200);
        });
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