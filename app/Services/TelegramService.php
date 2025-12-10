<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    /**
     * Kirim pesan ke Telegram
     */
    public function sendMessage($message)
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            Log::warning('Telegram configuration is missing');
            return false;
        }

        try {
            $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

            $response = Http::post($url, [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'HTML'
            ]);

            if ($response->successful()) {
                Log::info('Telegram notification sent successfully');
                return true;
            } else {
                Log::error('Failed to send Telegram notification: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Telegram notification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format pesan untuk notifikasi sertifikat kadaluarsa
     */
    public function notifySertifikatExpiring($user, $sertifikat, $tipeSertifikat, $daysLeft)
    {
        $status = $daysLeft <= 0 ? '🔴 SUDAH KADALUARSA' : '⚠️ AKAN KADALUARSA';

        $message = "<b>🚨 REMINDER SERTIFIKAT {$tipeSertifikat}</b>\n\n";
        $message .= "<b>Status:</b> {$status}\n";
        $message .= "<b>Nama Perawat:</b> {$user->name}\n";
        $message .= "<b>NIK:</b> " . ($user->profile->nik ?? '-') . "\n";
        $message .= "<b>No HP:</b> " . ($user->profile->no_hp ?? '-') . "\n\n";

        $message .= "<b>Detail Sertifikat:</b>\n";
        $message .= "• Nomor: {$sertifikat->nomor}\n";
        $message .= "• Nama: {$sertifikat->nama}\n";
        $message .= "• Lembaga: {$sertifikat->lembaga}\n";
        $message .= "• Tanggal Terbit: " . date('d/m/Y', strtotime($sertifikat->tgl_terbit)) . "\n";
        $message .= "• Tanggal Expired: " . date('d/m/Y', strtotime($sertifikat->tgl_expired)) . "\n";

        if ($daysLeft > 0) {
            $message .= "\n⏰ Sisa waktu: <b>{$daysLeft} hari</b>";
        } else {
            $message .= "\n❌ Sudah lewat: <b>" . abs($daysLeft) . " hari</b>";
        }

        $message .= "\n\n📝 Segera lakukan perpanjangan!";

        return $this->sendMessage($message);
    }

    public function sendVerificationCode($chatId, $code)
    {
        $message = "🔐 <b>Kode Verifikasi Telegram</b>\n\n";
        $message .= "Kode Anda: <code>{$code}</code>\n\n";
        $message .= "Masukkan kode ini di halaman pengaturan untuk menghubungkan akun Telegram Anda.\n";
        $message .= "Kode berlaku 15 menit.";

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        return Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ])->successful();
    }

    public function notifySertifikatExpiringToUser($chatId, $sertifikat, $tipeSertifikat, $daysLeft)
    {
        // Same as notifySertifikatExpiring but send to specific chat_id
        $status = $daysLeft <= 0 ? '🔴 SUDAH KADALUARSA' : '⚠️ AKAN KADALUARSA';

        $message = "<b>🚨 REMINDER SERTIFIKAT {$tipeSertifikat}</b>\n\n";
        $message .= "<b>Status:</b> {$status}\n";
        $message .= "<b>Detail Sertifikat:</b>\n";
        $message .= "• Nomor: {$sertifikat->nomor}\n";
        $message .= "• Nama: {$sertifikat->nama}\n";
        $message .= "• Tanggal Expired: " . date('d/m/Y', strtotime($sertifikat->tgl_expired)) . "\n";

        if ($daysLeft > 0) {
            $message .= "\n⏰ Sisa waktu: <b>{$daysLeft} hari</b>";
        } else {
            $message .= "\n❌ Sudah lewat: <b>" . abs($daysLeft) . " hari</b>";
        }

        $message .= "\n\n📝 Segera lakukan perpanjangan!";

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        return Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ])->successful();
    }
}
