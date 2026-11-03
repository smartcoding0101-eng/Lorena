<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\GardenDestination;
use App\Models\GardenGalleryItem;
use App\Models\GardenMedia;
use App\Models\GardenPoem;
use App\Models\GardenPost;
use App\Models\TimeCapsule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DynamicGardenContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedGallery();
        $this->seedDestinations();
        $this->seedPoems();

        $user = User::first();
        if ($user) {
            self::seedPersonalSanctuary($user);
        }
    }

    public static function seedGallery(): void
    {
        if (GardenGalleryItem::count() > 0) {
            return;
        }

        $items = [
            [
                'title' => 'Flores de domingo',
                'category' => 'foto',
                'pill' => 'Colección Carla',
                'tag_label' => 'FOTOGRAFÍA BOTÁNICA',
                'quote' => '«Para recordarte lo bonito que es florecer despacio y a tu propio ritmo.»',
                'image_path' => 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=1400&q=90',
                'video_url' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Aire de montaña',
                'category' => 'foto',
                'pill' => 'Serenidad',
                'tag_label' => 'PAISAJE DE CALMA',
                'quote' => '«Un lugar de paz que guarda tu nombre entre sus reflejos.»',
                'image_path' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1400&q=90',
                'video_url' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Una tarde dorada',
                'category' => 'video',
                'pill' => 'Luz Cálida',
                'tag_label' => 'POSTAL EN MOVIMIENTO',
                'quote' => '«La hora mágica cuando el sol abraza la pradera en silencio.»',
                'image_path' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1400&q=90',
                'video_url' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Bajo las estrellas',
                'category' => 'especiales',
                'pill' => 'Infinito',
                'tag_label' => 'NOCHE CELESTIAL',
                'quote' => '«En cada estrella un deseo sincero guardado para ti.»',
                'image_path' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1400&q=90',
                'video_url' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'El camino más bonito',
                'category' => 'amigos',
                'pill' => 'Caminos Juntos',
                'tag_label' => 'SENDERO FLORIDO',
                'quote' => '«Cualquier camino se vuelve hermoso si nos lleva a sonreír y soñar.»',
                'image_path' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1400&q=90',
                'video_url' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Luz de atardecer',
                'category' => 'familia',
                'pill' => 'Ocaso Suave',
                'tag_label' => 'POSTAL DORADA',
                'quote' => '«Un destello dorado para calmar los pensamientos y abrazar el alma.»',
                'image_path' => 'https://images.unsplash.com/photo-1470252649378-9c29740c9fa8?auto=format&fit=crop&w=1400&q=90',
                'video_url' => null,
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            GardenGalleryItem::create($item);
        }
    }

    public static function seedDestinations(): void
    {
        if (GardenDestination::count() > 0) {
            return;
        }

        $destinations = [
            [
                'title' => 'Un verano junto al mar',
                'location_tag' => 'ITALIA · COSTA',
                'description' => 'Calles de colores, agua tranquila y tardes sin prisa.',
                'image_path' => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Entre montañas',
                'location_tag' => 'DOLOMITAS · NATURALEZA',
                'description' => 'Abrir la ventana y encontrar un paisaje nuevo.',
                'image_path' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1000&q=85',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($destinations as $d) {
            GardenDestination::create($d);
        }
    }

    public static function seedPoems(): void
    {
        if (GardenPoem::count() > 0) {
            return;
        }

        $poems = [
            [
                'title' => 'Canto al Atardecer',
                'mood' => 'Para leer con una taza de té y silencio amable',
                'stanza1' => "«Hay jardines que nacen en la tierra,<br>y otros que florecen en la mirada.<br>Tú llevas contigo la primavera eterna,<br>la risa clara y la paz guardada.»",
                'stanza2' => "«Que ningún invierno apague tu calidez,<br>que los senderos te sean siempre amables,<br>y que al volver aquí encuentres otra vez,<br>motivos para soñar inagotables.»",
                'signature' => 'Escrito con amor para Carla Lorena',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Soneto de las Rosas de Abril',
                'mood' => 'Versos de luz para comenzar el día con esperanza',
                'stanza1' => "«Entre pétalos suaves despierta la mañana,<br>bordando de carmín la brisa del vergel,<br>y cada flor pronuncia tu nombre en la ventana,<br>con tinta de rocío y aromas de laurel.»",
                'stanza2' => "«Camina sin premura por tu sendero claro,<br>que el cielo guarda estrellas para tu caminar;<br>en este jardín vivo tendrás siempre un amparo,<br>donde tu corazón pueda siempre brillar.»",
                'signature' => 'Pergamino del Jardín · Edición del Día',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Balada del Agua Serena',
                'mood' => 'Lectura pausada para tardes de lluvia o sosiego',
                'stanza1' => "«Como el arroyo manso que besa la pradera,<br>así fluya la calma dentro de tu interior;<br>que nada te apresure, que todo cuanto espera<br>madure al dulce abrigo de tu propio valor.»",
                'stanza2' => "«Guarda en tus ojos limpios la dicha transparente,<br>de saberte querida con honda lealtad;<br>que el manantial no olvida su cauce preferente,<br>ni el alma que te nombra con tanta verdad.»",
                'signature' => 'Para Carla · Con devoción perenne',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Nocturno de los Luceros',
                'mood' => 'Paz nocturna para cerrar los ojos y descansar',
                'stanza1' => "«Cuando caiga la noche sobre tu frente clara,<br>y el silencio del cuarto te invite a reposar,<br>piensa que hay un lucero que nunca se apagara,<br>velando por tus sueños de aquí a la eternidad.»",
                'stanza2' => "«No temas a las sombras ni al viento que se queja,<br>que este rincón florece tan solo para ti;<br>la paz más infinita tu corazón corteja,<br>y el alba de mañana te hará sonreír.»",
                'signature' => 'Bajo la cúpula de estrellas de Carla',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Oda a los Caminos Claros',
                'mood' => 'Impulso y motivación para alcanzar cualquier anhelo',
                'stanza1' => "«No hay sendero imposible para tus pasos firmes,<br>ni cima que resista tu noble devoción;<br>tienes alas de seda para jamás rendirte,<br>y un faro inquebrantable dentro del corazón.»",
                'stanza2' => "«Avanza con confianza, que el mundo se engalana<br>cuando tu paso alegre dibuja un nuevo son;<br>serás siempre el milagro que vence la desgana,<br>y la razón más dulce de nuestra admiración.»",
                'signature' => 'Inspirado en la fuerza de Carla Lorena',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Madrigal del Jazmín Blanco',
                'mood' => 'Frescura y ternura para perfumar el mediodía',
                'stanza1' => "«Blanco como el suspiro del nardo en la floresta,<br>así es el sentimiento que habita en este hogar;<br>cada risa compartida se vuelve nuestra fiesta,<br>y cada abrazo tuyo un refugio de mar.»",
                'stanza2' => "«Que nunca falte aroma de flores en tu mesa,<br>ni notas de alegría que acallen el dolor;<br>en este edén secreto reside tu promesa,<br>de vida florecida con infinito amor.»",
                'signature' => 'Con aroma a jazmín silvestre',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Elegía de la Ternura',
                'mood' => 'Reflexión profunda para momentos de introspección',
                'stanza1' => "«Hay una luz sagrada que en tus pupilas mora,<br>que alivia las heridas de quien te ve pasar;<br>eres remanso tibio donde la pena llora<br>y aprende lentamente de nuevo a respirar.»",
                'stanza2' => "«Sigue sembrando afecto, ternura y armonía,<br>que el fruto de tus manos jamás se borrará;<br>este jardín eterno te canta noche y día,<br>y en cada primavera tu nombre vivirá.»",
                'signature' => 'Antología Secreta · Carla Lorena',
                'sort_order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($poems as $p) {
            GardenPoem::create($p);
        }
    }

    public static function seedPersonalSanctuary(User $user): void
    {
        if ($user->albums()->count() > 0 || $user->gardenPosts()->count() > 0 || $user->timeCapsules()->count() > 0) {
            return;
        }

        // 1. Albums
        $album1 = $user->albums()->create([
            'title' => 'Jardín & Recuerdos de Primavera',
            'description' => 'Colección de momentos luminosos, paseos entre flores y días llenos de serenidad.',
        ]);

        $album2 = $user->albums()->create([
            'title' => 'Destellos Inolvidables',
            'description' => 'Instantes de paz, sonrisas y memorias atesoradas con infinito cariño.',
        ]);

        // 2. Photos with local files in garden_private disk
        $disk = Storage::disk('garden_private');

        $photoConfigs = [
            [
                'album' => $album1,
                'title' => 'Luz dorada en el sendero',
                'desc' => 'El instante exacto en que la luz acaricia el jardín y todo parece detenerse.',
                'fav' => true,
                'src' => public_path('images/hero-option-1.jpg'),
            ],
            [
                'album' => $album1,
                'title' => 'Perfume de magnolias y calma',
                'desc' => 'Pétalos suaves y la frescura de una mañana tranquila para respirar paz.',
                'fav' => false,
                'src' => public_path('images/fondo-flores.jpg'),
            ],
            [
                'album' => $album2,
                'title' => 'Sonrisas al atardecer',
                'desc' => 'Un recuerdo entrañable lleno de calidez, dulzura y gratitud sincera.',
                'fav' => true,
                'src' => public_path('images/hero-option-2.jpg'),
            ],
            [
                'album' => $album2,
                'title' => 'Cielo sereno y horizontes de ensueño',
                'desc' => 'La paz de contemplar a lo lejos sabiendo que cada paso florece con amor.',
                'fav' => false,
                'src' => public_path('images/carla-hero.jpg'),
            ],
        ];

        foreach ($photoConfigs as $cfg) {
            $src = $cfg['src'];
            $data = file_exists($src) ? file_get_contents($src) : '';
            $ext = pathinfo($src, PATHINFO_EXTENSION) ?: 'jpg';
            $rel = sprintf('%d/%d/%s.%s', $user->id, $cfg['album']->id, Str::uuid(), $ext);
            $disk->put($rel, $data);

            AlbumPhoto::create([
                'user_id' => $user->id,
                'album_id' => $cfg['album']->id,
                'path' => $rel,
                'title' => $cfg['title'],
                'description' => $cfg['desc'],
                'mime_type' => 'image/jpeg',
                'file_size' => strlen($data),
                'is_favorite' => $cfg['fav'],
            ]);
        }

        // 3. Diary Entries
        $user->gardenPosts()->create([
            'title' => 'Un atardecer de infinita gratitud',
            'category' => 'Gratitud',
            'excerpt' => 'Hoy el viento trajo calma y me recordó lo afortunada que soy de tener este espacio de paz.',
            'body' => "Hay días en los que simplemente necesitamos detener el reloj, respirar hondo y contemplar lo lejos que hemos llegado. Este rincón me da esa serenidad que a veces el mundo exterior olvida regalarnos. Guardo este día en el corazón con inmensa ternura.",
            'kind' => 'diary',
            'status' => 'draft',
            'slug' => Str::slug('Un atardecer de infinita gratitud') . '-' . Str::lower(Str::random(8)),
        ]);

        $user->gardenPosts()->create([
            'title' => 'Pequeños momentos que iluminan la vida',
            'category' => 'Reflexión',
            'excerpt' => 'Aprender a florecer a mi propio ritmo, con la suavidad de un pétalo al amanecer.',
            'body' => "No hay prisa cuando se camina con amor propio y con personas que valoran tu esencia. Me prometo seguir cuidando mis sueños, regando mis ilusiones y sonriendo por cada nuevo amanecer en mi jardín secreto.",
            'kind' => 'diary',
            'status' => 'draft',
            'slug' => Str::slug('Pequeños momentos que iluminan la vida') . '-' . Str::lower(Str::random(8)),
        ]);

        // 4. Time Capsules
        $user->timeCapsules()->create([
            'title' => 'Carta para abrir en una tarde de lluvia',
            'mood' => 'love',
            'author_name' => $user->name ?? 'Carla Lorena',
            'unlock_at' => now()->addMonths(2),
            'message' => 'Si estás leyendo esto, es porque la lluvia te acompaña y este mensaje secreto ha venido a abrazarte. Recuerda siempre sonreír, porque tu luz es el regalo más precioso de este mundo.',
            'is_opened' => false,
        ]);

        $user->timeCapsules()->create([
            'title' => 'Promesa guardada bajo las estrellas',
            'mood' => 'future',
            'author_name' => $user->name ?? 'Carla Lorena',
            'unlock_at' => now()->addMonths(6),
            'message' => 'Una promesa para el futuro: jamás olvides lo valiosa, única y amada que eres. En cada paso que des, este santuario guardará siempre el eco de tu felicidad.',
            'is_opened' => false,
        ]);

        // 5. Blog Drafts
        $user->gardenPosts()->create([
            'title' => 'El arte de florecer sin prisa',
            'category' => 'Inspiración',
            'excerpt' => 'Reflexiones sobre el tiempo, la paciencia y la belleza de madurar con gracia.',
            'body' => "En un mundo que a menudo nos exige correr, detenerse a observar una flor abrirse es un acto de rebeldía y sabiduría. Las flores más bellas no compiten entre sí; simplemente esperan su luz y florecen cuando su momento es perfecto.",
            'kind' => 'blog',
            'status' => 'draft',
            'slug' => Str::slug('El arte de florecer sin prisa') . '-' . Str::lower(Str::random(8)),
        ]);

        // 6. Media
        $user->gardenMedia()->create([
            'title' => 'Melodía de Atardecer y Viento Suave',
            'description' => 'Pieza instrumental para acompañar tus momentos de lectura y contemplación.',
            'media_type' => 'audio',
            'source_type' => 'external_audio',
            'source_url' => 'https://actions.google.com/sounds/v1/weather/gentle_rain_on_leaves.ogg',
        ]);
    }
}

