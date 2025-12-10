<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Carbon\Carbon;

class TelegramPolling extends Command
{
    protected $signature = 'telegram:polling';
    protected $description = 'Listen to Telegram updates via polling';

    public function handle()
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $offset = 0;

        $this->info('Listening to Telegram updates...');

        while (true) {
            $response = Http::get("https://api.telegram.org/bot{$botToken}/getUpdates", [
                'offset' => $offset,
                'timeout' => 30
            ]);

            $updates = $response->json()['result'] ?? [];

            foreach ($updates as $update) {
                $offset = $update['update_id'] + 1;

                if (isset($update['message']['text'])) {
                    $chatId = $update['message']['chat']['id'];
                    $text = strtoupper(trim($update['message']['text']));

                    $this->line("Received: {$text} from {$chatId}");

                    // Cek kode verifikasi
                    $user = User::where('telegram_verification_code', $text)
                        ->where('telegram_verification_expires_at', '>', Carbon::now())
                        ->first();

                    if ($user) {
                        $user->telegram_chat_id = $chatId;
                        $user->telegram_verification_code = null;
                        $user->telegram_verification_expires_at = null;
                        $user->save();

                        Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                            'chat_id' => $chatId,
                            'text' => "✅ Akun berhasil terhubung!\n\nHalo {$user->name}, Anda akan menerima notifikasi sertifikat."
                        ]);

                        $this->info("✓ User {$user->name} connected!");
                    }
                }
            }

            sleep(1);
        }
    }
}