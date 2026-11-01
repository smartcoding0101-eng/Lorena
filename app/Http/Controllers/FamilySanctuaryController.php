<?php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\FamilyMemory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;

class FamilySanctuaryController extends Controller
{
    private const IMAGE_MAX_KILOBYTES = 15360; // 15 MB

    public static function ensureDefaultFamilyData(): void
    {
        if (!Schema::hasTable('family_members') || !Schema::hasTable('family_memories')) {
            return;
        }

        if (FamilyMember::count() > 0) {
            return;
        }

        $carla = FamilyMember::create([
            'slug' => 'carla-lorena',
            'name' => 'Carla Lorena',
            'role_badge' => 'Corazón del Hogar · Mamá & Luz',
            'category' => 'carla',
            'avatar_icon' => '👑',
            'bio' => 'El alma de nuestra familia, quien llena cada rincón de ternura, elegancia, alegría y amor incondicional.',
            'special_date' => 'Reina de Nuestro Jardín',
            'favorite_quote' => '«La familia es el jardín donde el amor florece para siempre.»',
            'photo_path' => 'images/carla-hero.jpg',
            'theme_color' => 'rose',
            'sort_order' => 1,
        ]);

        $adrian = FamilyMember::create([
            'slug' => 'adrian',
            'name' => 'Adrián',
            'role_badge' => 'Compañero de Vida · Papá & Guardián',
            'category' => 'adrian',
            'avatar_icon' => '💎',
            'bio' => 'Cómplice de cada sueño, pilar de fortaleza, risas compartidas y amor eterno junto a Carla Lorena.',
            'special_date' => 'Siempre Juntos · Destino & Hogar',
            'favorite_quote' => '«Contigo cada día es el inicio de nuestra mejor historia.»',
            'photo_path' => 'images/hero-option-2.jpg',
            'theme_color' => 'sapphire',
            'sort_order' => 2,
        ]);

        $ody = FamilyMember::create([
            'slug' => 'ody',
            'name' => 'Ody',
            'role_badge' => 'Mi Mascota Amada · Guardián Peludo',
            'category' => 'ody',
            'avatar_icon' => '🐾',
            'bio' => 'Nuestro compañero más leal y travieso; experto en dar bienvenidas felices, repartir cariño puro y alegrar cada mañana.',
            'special_date' => 'Huellitas en el Corazón',
            'favorite_quote' => '«La lealtad más pura tiene cuatro patitas y un corazón gigante.»',
            'photo_path' => 'images/fondo-flores.jpg',
            'theme_color' => 'amber',
            'sort_order' => 3,
        ]);

        $childOne = FamilyMember::create([
            'slug' => 'hijo-pequeno-sol',
            'name' => 'Nuestro Hijo · Pequeño Sol',
            'role_badge' => 'Hijo Amado · Alegría del Futuro',
            'category' => 'children',
            'avatar_icon' => '🌟',
            'bio' => 'Bendición luminosa de nuestro hogar, reflejo del amor de Carla Lorena y Adrián, lleno de curiosidad, nobleza y sonrisas.',
            'special_date' => 'Semilla de Amor #1',
            'favorite_quote' => '«Cada paso tuyo ilumina el universo entero.»',
            'photo_path' => 'images/hero-option-1.jpg',
            'theme_color' => 'emerald',
            'sort_order' => 4,
        ]);

        $childTwo = FamilyMember::create([
            'slug' => 'hija-estrella-dulce',
            'name' => 'Nuestra Hija · Estrella Dulce',
            'role_badge' => 'Hija Amada · Flor del Jardín',
            'category' => 'children',
            'avatar_icon' => '🌸',
            'bio' => 'Ternura infinita, magia y dulzura que multiplica la felicidad de nuestra familia en cada abrazo.',
            'special_date' => 'Semilla de Amor #2',
            'favorite_quote' => '«Eres la melodía más dulce de nuestro hogar.»',
            'photo_path' => 'images/carla-hero.jpg',
            'theme_color' => 'amethyst',
            'sort_order' => 5,
        ]);

        if (FamilyMemory::count() === 0) {
            FamilyMemory::create([
                'family_member_id' => $carla->id,
                'category' => 'todos',
                'title' => 'El abrazo que une a toda nuestra familia',
                'story' => 'Carla Lorena, Adrián, nuestro fiel Ody y nuestros hijos reunidos en el corazón del jardín. El verdadero tesoro de la vida.',
                'memory_date' => 'Recuerdo Eterno',
                'emotion_tag' => 'Amor Familiar',
                'image_path' => 'images/carla-hero.jpg',
                'is_featured' => true,
            ]);

            FamilyMemory::create([
                'family_member_id' => $adrian->id,
                'category' => 'adrian',
                'title' => 'Carla Lorena & Adrián · Cómplices de vida',
                'story' => 'Construyendo juntos un hogar lleno de respeto, sueños cumplidos, risas y amor verdadero.',
                'memory_date' => 'Nuestro Pacto',
                'emotion_tag' => 'Zafiro Eterno',
                'image_path' => 'images/hero-option-2.jpg',
                'is_featured' => true,
            ]);

            FamilyMemory::create([
                'family_member_id' => $ody->id,
                'category' => 'ody',
                'title' => 'Las travesuras y ternura de Ody en el jardín',
                'story' => 'Ody corriendo feliz entre las flores, cuidando a toda la familia con su alegría inagotable.',
                'memory_date' => 'Día de Juegos',
                'emotion_tag' => 'Mascota Leal 🐾',
                'image_path' => 'images/fondo-flores.jpg',
                'is_featured' => false,
            ]);

            FamilyMemory::create([
                'family_member_id' => $childOne->id,
                'category' => 'children',
                'title' => 'Risas y sueños con nuestros hijos',
                'story' => 'Tardes inolvidables viendo crecer a nuestros hijos rodeados del cariño de mamá, papá y Ody.',
                'memory_date' => 'Instante Mágico',
                'emotion_tag' => 'Nuestros Hijos 🌟',
                'image_path' => 'images/hero-option-1.jpg',
                'is_featured' => false,
            ]);
        }
    }

    /**
     * Desbloqueo rápido con usuario/correo y contraseña de Administrador desde el Mapa o la Bóveda Familiar.
     */
    public function unlock(Request $request): JsonResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $loginInput = trim($data['login']);

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [Str::lower($loginInput)])
            ->orWhereRaw('LOWER(name) = ?', [Str::lower($loginInput)])
            ->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'unlocked' => false,
                'message' => 'Usuario o contraseña incorrectos. Verifica tus credenciales de administrador.',
            ], 422);
        }

        $isAdmin = (bool) ($user->is_admin ?? false) || in_array($user->id, [1, 2], true);
        if (!$isAdmin) {
            return response()->json([
                'unlocked' => false,
                'message' => 'Acceso restringido: solo la cuenta de administrador puede ingresar a Mi Familia.',
            ], 403);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        self::ensureDefaultFamilyData();

        return response()->json([
            'unlocked' => true,
            'message' => 'Bóveda familiar desbloqueada. Bienvenida a Mi Familia.',
            'csrf_token' => csrf_token(),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'members' => FamilyMember::query()->orderBy('sort_order')->orderBy('id')->get(),
            'memories' => FamilyMemory::query()->with('member')->orderByDesc('is_featured')->orderByDesc('id')->get(),
        ]);
    }

    /**
     * Obtener integrantes y recuerdos del álbum familiar (Solo Admin).
     */
    public function index(): JsonResponse
    {
        self::ensureDefaultFamilyData();

        return response()->json([
            'success' => true,
            'members' => FamilyMember::query()->orderBy('sort_order')->orderBy('id')->get(),
            'memories' => FamilyMemory::query()->with('member')->orderByDesc('is_featured')->orderByDesc('id')->get(),
        ]);
    }

    /**
     * Agregar un nuevo integrante o hijo al álbum familiar (Solo Admin).
     */
    public function storeMember(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'role_badge' => ['required', 'string', 'max:140'],
            'category' => ['required', 'string', 'in:carla,adrian,ody,children'],
            'avatar_icon' => ['nullable', 'string', 'max:16'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'special_date' => ['nullable', 'string', 'max:120'],
            'favorite_quote' => ['nullable', 'string', 'max:280'],
            'theme_color' => ['nullable', 'string', 'max:40'],
            'photo' => ['nullable', File::image()->max(self::IMAGE_MAX_KILOBYTES)],
        ]);

        $photoPath = 'images/carla-hero.jpg';
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $photoPath = $file->storeAs('family-sanctuary/members', Str::uuid()->toString() . '.' . $ext, 'public');
        }

        $baseSlug = Str::slug($data['name']) ?: 'integrante';
        $slug = $baseSlug . '-' . Str::lower(Str::random(5));

        $member = FamilyMember::create([
            'slug' => $slug,
            'name' => trim($data['name']),
            'role_badge' => trim($data['role_badge']),
            'category' => $data['category'],
            'avatar_icon' => trim((string) ($data['avatar_icon'] ?? '🌟')) ?: '🌟',
            'bio' => $data['bio'] ?? null,
            'special_date' => $data['special_date'] ?? null,
            'favorite_quote' => $data['favorite_quote'] ?? null,
            'photo_path' => $photoPath,
            'theme_color' => $data['theme_color'] ?? 'sapphire',
            'sort_order' => (int) FamilyMember::max('sort_order') + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Integrante agregado al álbum familiar.',
            'member' => $member->fresh(),
        ], 201);
    }

    /**
     * Actualizar perfil o fotografía de un integrante familiar (Solo Admin).
     */
    public function updateMember(Request $request, FamilyMember $familyMember): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'role_badge' => ['required', 'string', 'max:140'],
            'category' => ['required', 'string', 'in:carla,adrian,ody,children'],
            'avatar_icon' => ['nullable', 'string', 'max:16'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'special_date' => ['nullable', 'string', 'max:120'],
            'favorite_quote' => ['nullable', 'string', 'max:280'],
            'theme_color' => ['nullable', 'string', 'max:40'],
            'photo' => ['nullable', File::image()->max(self::IMAGE_MAX_KILOBYTES)],
        ]);

        if ($request->hasFile('photo')) {
            if ($familyMember->photo_path && str_starts_with($familyMember->photo_path, 'family-sanctuary/') && Storage::disk('public')->exists($familyMember->photo_path)) {
                Storage::disk('public')->delete($familyMember->photo_path);
            }
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $familyMember->photo_path = $file->storeAs('family-sanctuary/members', Str::uuid()->toString() . '.' . $ext, 'public');
        }

        $familyMember->fill([
            'name' => trim($data['name']),
            'role_badge' => trim($data['role_badge']),
            'category' => $data['category'],
            'avatar_icon' => trim((string) ($data['avatar_icon'] ?? $familyMember->avatar_icon)) ?: '🌟',
            'bio' => $data['bio'] ?? null,
            'special_date' => $data['special_date'] ?? null,
            'favorite_quote' => $data['favorite_quote'] ?? null,
            'theme_color' => $data['theme_color'] ?? $familyMember->theme_color,
        ])->save();

        return response()->json([
            'success' => true,
            'message' => 'Perfil familiar actualizado con éxito.',
            'member' => $familyMember->fresh(),
        ]);
    }

    /**
     * Eliminar un integrante familiar (Solo Admin).
     */
    public function destroyMember(FamilyMember $familyMember): JsonResponse
    {
        if ($familyMember->photo_path && str_starts_with($familyMember->photo_path, 'family-sanctuary/') && Storage::disk('public')->exists($familyMember->photo_path)) {
            Storage::disk('public')->delete($familyMember->photo_path);
        }

        $familyMember->delete();

        return response()->json([
            'success' => true,
            'message' => 'Integrante eliminado del álbum familiar.',
        ]);
    }

    /**
     * Subir un nuevo recuerdo o fotografía al álbum familiar (Solo Admin).
     */
    public function storeMemory(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'story' => ['nullable', 'string', 'max:1500'],
            'category' => ['required', 'string', 'in:todos,carla,adrian,ody,children'],
            'family_member_id' => ['nullable', 'integer', 'exists:family_members,id'],
            'memory_date' => ['nullable', 'string', 'max:100'],
            'emotion_tag' => ['nullable', 'string', 'max:80'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', File::image()->max(self::IMAGE_MAX_KILOBYTES)],
        ]);

        $imagePath = 'images/carla-hero.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $imagePath = $file->storeAs('family-sanctuary/memories', Str::uuid()->toString() . '.' . $ext, 'public');
        }

        $memory = FamilyMemory::create([
            'family_member_id' => $data['family_member_id'] ?? null,
            'category' => $data['category'],
            'title' => trim($data['title']),
            'story' => $data['story'] ?? null,
            'memory_date' => trim((string) ($data['memory_date'] ?? 'Recuerdo Especial')) ?: 'Recuerdo Especial',
            'emotion_tag' => trim((string) ($data['emotion_tag'] ?? 'Amor Familiar')) ?: 'Amor Familiar',
            'image_path' => $imagePath,
            'is_featured' => (bool) ($data['is_featured'] ?? false),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recuerdo guardado en el álbum familiar.',
            'memory' => $memory->load('member'),
        ], 201);
    }

    /**
     * Actualizar una fotografía o datos de un recuerdo en el álbum familiar (Solo Admin).
     */
    public function updateMemory(Request $request, FamilyMemory $familyMemory): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'story' => ['nullable', 'string', 'max:1500'],
            'category' => ['required', 'string', 'in:todos,carla,adrian,ody,children'],
            'family_member_id' => ['nullable', 'integer', 'exists:family_members,id'],
            'memory_date' => ['nullable', 'string', 'max:100'],
            'emotion_tag' => ['nullable', 'string', 'max:80'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', File::image()->max(self::IMAGE_MAX_KILOBYTES)],
        ]);

        if ($request->hasFile('image')) {
            if ($familyMemory->image_path && str_starts_with($familyMemory->image_path, 'family-sanctuary/') && Storage::disk('public')->exists($familyMemory->image_path)) {
                Storage::disk('public')->delete($familyMemory->image_path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension() ?: 'jpg';
            $familyMemory->image_path = $file->storeAs('family-sanctuary/memories', Str::uuid()->toString() . '.' . $ext, 'public');
        }

        $familyMemory->fill([
            'family_member_id' => $data['family_member_id'] ?? null,
            'category' => $data['category'],
            'title' => trim($data['title']),
            'story' => $data['story'] ?? null,
            'memory_date' => trim((string) ($data['memory_date'] ?? 'Recuerdo Especial')) ?: 'Recuerdo Especial',
            'emotion_tag' => trim((string) ($data['emotion_tag'] ?? 'Amor Familiar')) ?: 'Amor Familiar',
            'is_featured' => (bool) ($data['is_featured'] ?? false),
        ])->save();

        return response()->json([
            'success' => true,
            'message' => 'Fotografía del recuerdo actualizada con éxito.',
            'memory' => $familyMemory->fresh()->load('member'),
        ]);
    }

    /**
     * Eliminar un recuerdo del álbum familiar (Solo Admin).
     */
    public function destroyMemory(FamilyMemory $familyMemory): JsonResponse
    {
        if ($familyMemory->image_path && str_starts_with($familyMemory->image_path, 'family-sanctuary/') && Storage::disk('public')->exists($familyMemory->image_path)) {
            Storage::disk('public')->delete($familyMemory->image_path);
        }

        $familyMemory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recuerdo eliminado del álbum familiar.',
        ]);
    }
}

