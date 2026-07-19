<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                            ->latest()
                            ->get();

        // Tandai semua sudah dibaca
        Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update([
                'is_read' => 1
            ]);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }
    public function read($id)
{
    $notif = Notification::findOrFail($id);

    $notif->update([
        'is_read'=>1
    ]);

    if($notif->jenis=="agenda"){

        return redirect()->route(
            'agenda.edit',
            $notif->reference_id
        );

    }

    if($notif->jenis=="surat_masuk"){

        return redirect()->route(
            'suratmasuk.edit',
            $notif->reference_id
        );

    }

    if($notif->jenis=="surat_keluar"){

        return redirect()->route(
            'suratkeluar.edit',
            $notif->reference_id
        );

    }

    return back();
}
}