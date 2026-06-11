<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Giveaway extends Component
{
    public $mediaUrl;
    public $winner = null;
    public $error = null;
    public $totalValidParticipants = 0;

    public function pickWinner()
    {
        $this->validate([
            'mediaUrl' => 'required|url'
        ], [
            'mediaUrl.required' => 'Debes ingresar el enlace de la publicación.',
            'mediaUrl.url'      => 'El formato del enlace no es válido.',
        ]);

        $this->error  = null;
        $this->winner = null;

        preg_match('#instagram\.com/(?:p|reel|tv)/([A-Za-z0-9_-]+)#', $this->mediaUrl, $matches);

        if (empty($matches[1])) {
            $this->error = 'No se pudo extraer el shortcode. Verifica que sea un enlace válido de Instagram.';
            return;
        }

        $shortcode = $matches[1];
        $token     = config('services.instagram.access_token');
        $igUserId  = config('services.instagram.user_id');

        if (!$token || !$igUserId) {
            $this->error = 'Faltan las credenciales de Instagram en la configuración.';
            return;
        }

        try {
            $mediaId = $this->findMediaIdByShortcode($shortcode, $igUserId, $token);

            if (!$mediaId) {
                $this->error = 'Publicación no encontrada. ¿Pertenece a la cuenta vinculada? (Solo se revisan los últimos ~200 posts)';
                return;
            }

            $comments = $this->fetchAllComments($mediaId, $token);

            if (empty($comments)) {
                $this->error = 'La publicación no tiene comentarios o la API no pudo leerlos.';
                return;
            }

            $valid = array_values(array_filter($comments, function ($c) {
                return substr_count($c['text'], '@') >= 2;
            }));

            $this->totalValidParticipants = count($valid);

            if ($this->totalValidParticipants === 0) {
                $this->error = 'Ningún comentario cumple con el requisito de tener 2 o más menciones (@).';
                return;
            }

            $this->winner = $valid[array_rand($valid)];

            // Dispara el evento para que Alpine.js inicie la cuenta regresiva
            $this->dispatch('winner-found');

        } catch (\Exception $e) {
            $this->error = 'Error al conectar con la API: ' . $e->getMessage();
        }
    }

    private function findMediaIdByShortcode(string $shortcode, string $igUserId, string $token): ?string
    {
        $url   = "https://graph.facebook.com/v19.0/{$igUserId}/media?fields=id,shortcode&limit=25&access_token={$token}";
        $pages = 0;

        while ($url && $pages < 8) {
            $response = Http::timeout(15)->get($url)->json();

            foreach ($response['data'] ?? [] as $media) {
                if (($media['shortcode'] ?? '') === $shortcode) {
                    return $media['id'];
                }
            }

            $url = $response['paging']['next'] ?? null;
            $pages++;
        }

        return null;
    }

    private function fetchAllComments(string $mediaId, string $token): array
    {
        $comments = [];
        $url = "https://graph.facebook.com/v19.0/{$mediaId}/comments?fields=username,text,timestamp&limit=100&access_token={$token}";

        while ($url) {
            $response = Http::timeout(15)->get($url)->json();

            if (isset($response['error'])) {
                throw new \Exception($response['error']['message'] ?? 'Error de la API');
            }

            foreach ($response['data'] ?? [] as $comment) {
                $comments[] = $comment;
            }

            $url = $response['paging']['next'] ?? null;
        }

        return $comments;
    }

    public function render()
    {
        return view('livewire.admin.giveaway')->layout('components.layouts.app');
    }
}