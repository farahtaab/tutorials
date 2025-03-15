<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Guide;

class GuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offset = 0;
        $limit = 20;  // Limitar a solo 20 tutoriales para evitar demasiados registros

        // Cambia la URL para obtener solo 20 tutoriales
        $endpoint = 'https://www.ifixit.com/api/2.0/guides?limit=' . $limit . '&offset=' . $offset;
        $response = Http::get($endpoint);

        // Si la respuesta es exitosa, procesar los tutoriales
        if ($response->successful()) {
            $guides = $response->json();

            foreach ($guides as $guide) {
                Guide::updateOrInsert(
                    ['guide_id' => $guide['guideid']],
                    [
                        'title' => $guide['title'],
                        'category' => $guide['category'],
                        'subject' => $guide['subject'],
                        'summary' => $guide['summary'],
                        'introduction_raw' => $guide['introduction_raw'] ?? '',
                        'introduction_rendered' => $guide['introduction_rendered'] ?? '',
                        'conclusion_raw' => $guide['conclusion_raw'] ?? '',
                        'conclusion_rendered' => $guide['conclusion_rendered'] ?? '',
                        'difficulty' => $guide['difficulty'] ?? '',
                        'time_required_min' => $guide['time_required_min'] ?? null,
                        'time_required_max' => $guide['time_required_max'] ?? null,
                        'public' => $guide['public'],
                        'locale' => $guide['locale'],
                        'type' => $guide['type'],
                        'url' => $guide['url'],
                        'documents' => isset($guide['documents']) ? json_encode($guide['documents']) : json_encode([]),
                        'flags' => isset($guide['flags']) ? json_encode($guide['flags']) : json_encode([]),
                        'image' => isset($guide['image']) ? json_encode($guide['image']) : json_encode([]),
                        'prerequisites' => isset($guide['prerequisites']) ? json_encode($guide['prerequisites']) : json_encode([]),
                        'steps' => isset($guide['steps']) ? json_encode($guide['steps']) : json_encode([]),
                        'tools' => isset($guide['tools']) ? json_encode($guide['tools']) : json_encode([]),
                        'author_id' => $guide['author_id'] ?? null,
                        'author_username' => $guide['author_username'] ?? '',
                        'author_image' => isset($guide['author_image']) ? json_encode($guide['author_image']) : json_encode([]),
                        // Manejar created_date de manera segura
                        'created_date' => isset($guide['created_date']) ? date('Y-m-d H:i:s', $guide['created_date']) : null,
                        'published_date' => isset($guide['published_date']) ? date('Y-m-d H:i:s', $guide['published_date']) : null,
                        'modified_date' => isset($guide['modified_date']) ? date('Y-m-d H:i:s', $guide['modified_date']) : null,
                        'prereq_modified_date' => isset($guide['prereq_modified_date']) ? date('Y-m-d H:i:s', $guide['prereq_modified_date']) : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
