<?php

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Ifixit;

class IfixitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offset = 0;
        $limit = 20;  // Limitar a 20 tutoriales

        $endpoint = 'https://www.ifixit.com/api/2.0/guides?limit=' . $limit . '&offset=' . $offset;
        $response = Http::get($endpoint);

        // Si la respuesta es exitosa, procesar los tutoriales
        if ($response->successful()) {
            $guides = $response->json();

            foreach ($guides as $guide) {
                Ifixit::updateOrInsert(
                    ['guide_id' => $guide['guideid']],
                    [
                        'data_type' => $guide['dataType'],
                        'locale' => $guide['locale'],
                        'revision_id' => $guide['revisionid'],
                        'modified_date' => date('Y-m-d H:i:s', $guide['modified_date']),
                        'prereq_modified_date' => isset($guide['prereq_modified_date']) ? date('Y-m-d H:i:s', $guide['prereq_modified_date']) : null,
                        'url' => $guide['url'],
                        'type' => $guide['type'],
                        'category' => $guide['category'],
                        'subject' => $guide['subject'],
                        'title' => $guide['title'],
                        'summary' => $guide['summary'],
                        'difficulty' => $guide['difficulty'] ?? "",
                        'time_required_max' => $guide['time_required_max'] ?? null,
                        'public' => $guide['public'],
                        'user_id' => $guide['userid'],
                        'username' => $guide['username'],
                        'flags' => json_encode($guide['flags']),
                        'image' => json_encode($guide['image']),
                        'steps' => isset($guide['steps']) ? json_encode($guide['steps']) : null, // Asegúrate de que 'steps' esté presente
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
