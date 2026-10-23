# El Jardín de Carla

Aplicación web en Laravel, Blade, Vite y JavaScript. La interfaz y las interacciones de demostración funcionan sin una cuenta; el área personal usa Laravel, MySQL y almacenamiento local privado. No utiliza Supabase ni requiere servicios de pago.

## Etapas

1. **A — Diseño y navegación:** portada, mapa y pantallas adaptables (implementada).
2. **B — Galería y módulos interactivos:** filtros, vista ampliada, juegos breves, escenas, historias ramificadas y aventuras narrativa y 3D (implementada como prototipos locales).
3. **C — Autenticación y persistencia:** inicio de sesión Laravel, sesiones de base de datos, tablas MySQL, álbumes, preferencias, blog y diario (esquema y cuenta propietaria creados; conexión verificada).
4. **D — Permisos y privacidad:** rutas autenticadas, políticas de propietario, borradores, publicación explícita del blog, diario privado, claves foráneas, fotos privadas y consulta de favoritos (verificado con pruebas y con la conexión MySQL local).
5. **E — Validación y publicación:** pruebas automatizadas y comprobación local de pantallas y persistencia MySQL; cualquier publicación del sitio requiere autorización explícita y una revisión de producción.

No se ha publicado el sitio ni se han agregado fotografías personales. Las fotografías visibles en la galería pública son imágenes externas de demostración. Las tarjetas identificadas como vídeos no reproducen archivos de vídeo.

El blog incluye un editor autenticado para el perfil de Carla: profesión, biografía, estudios, experiencia, logros, intereses, otros datos y foto destacada. El perfil comienza como borrador privado y solo se hace visible mediante la acción explícita «Publicar perfil en el blog». La fotografía se valida y se guarda en el disco privado; el servidor solo la entrega si el perfil está publicado o si quien la solicita es la propietaria. No contiene datos profesionales ni una fotografía precargados. En una base local existente, ejecuta `php artisan migrate` para crear `garden_profiles`.

El mapa incluye un espacio privado de entretenimiento para subir, reproducir y retirar videos MP4, WebM o MOV (máximo 100 MiB) y audios MP3, M4A, AAC, WAV, OGG/OGA o WebM (máximo 20 MiB). También permite guardar enlaces HTTPS a videos de YouTube y enlaces HTTPS directos a archivos MP3 externos. En una base local existente, ejecuta `php artisan migrate` para crear `garden_media` y habilitar los tipos de fuente. Los archivos subidos quedan en el disco `garden_private`; los enlaces se guardan como referencias privadas y no se descargan ni se alojan localmente. El acceso y el borrado se autorizan en el servidor para la cuenta propietaria. Los videos de YouTube se validan para dominios y formatos de enlace admitidos y solo cargan el reproductor `youtube-nocookie.com` cuando alguien pulsa reproducir. Los MP3 externos se reproducen desde la fuente HTTPS con controles HTML nativos. El navegador se conecta directamente al proveedor al reproducir un medio externo, por lo que este puede recibir datos técnicos como la dirección IP. La interfaz solo presenta la colección de la cuenta con sesión; los visitantes ven el acceso de inicio de sesión.

## Configuración local de MySQL

Requiere PHP 8.2+, extensiones `pdo_mysql`, `fileinfo` y GD para las imágenes de prueba, Composer, Node.js, npm y un servidor MySQL. Para configurar la conexión:

1. Copia `.env.example` a `.env` solo si todavía no tienes un `.env`. Si ya lo tienes, actualiza **localmente** `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` para tu instancia MySQL. No pegues contraseñas aquí ni las guardes en el repositorio.
2. Comprueba que MySQL esté activo. Crea `el_jardin_de_carla` en phpMyAdmin y crea un usuario propio para la aplicación con permisos sobre **esa base**, sin usar el usuario `root`. Si no existe la base todavía, `garden:install` puede crearla cuando el usuario configurado disponga de ese permiso; si ya está creada, basta con los permisos de administración de sus tablas.
3. Instala el esquema:

   ```sh
   php artisan garden:install
   ```

   El comando primero intenta conectarse directamente a la base configurada y ejecuta las migraciones. Si esa base aún no existe, intenta crearla con el usuario configurado. No borra ni reinicia bases existentes. Si la base ya existe, sus tablas deben estar vacías o gestionadas por estas migraciones. No ejecutes el comando contra una base con datos ajenos al jardín.

4. Crea la cuenta propietaria desde la terminal si aún no existe:

   ```sh
   php artisan garden:create-owner
   ```

   El comando solicita nombre y correo, oculta la contraseña al escribirla, exige al menos 12 caracteres y guarda solo un hash. No hay registro público ni contraseña inicial predeterminada.
5. Inicia la aplicación:

   ```sh
   npm install
   npm run dev
   ```

   En otra terminal:

   ```sh
   php artisan serve
   ```

Para compilar recursos y ejecutar pruebas:

```sh
npm run build
php artisan test
```

Las pruebas automatizadas usan una base SQLite en memoria y no modifican MySQL. La conexión y las migraciones MySQL se comprueban aparte; la prueba de persistencia de modelos usa una transacción que se revierte y no deja datos de prueba.

## Contenido y privacidad

| Tipo | Datos | Protección |
| --- | --- | --- |
| Público | Portada, contenido fijo de muestra e imágenes de demostración | No contiene álbumes ni fotos personales. |
| Público | Entradas de blog publicadas explícitamente | Solo se consultan entradas `blog` con estado `published`; el cuerpo se representa como texto plano y no hay comentarios. |
| Público | Preguntas activas de “Conociendo a Carla Lorena” | El servidor entrega 10 al azar; nunca incluye respuestas ni verificadores en la página o en las respuestas JSON. |
| Privado de Carla | Álbumes, fotografías, descripciones, favoritos, preferencias, borradores y diario | Inicio de sesión, consulta asociada al usuario y políticas Laravel por propietario. |
| Privado de Carla | Audios y videos del espacio de entretenimiento | Validación de formato y tamaño en el servidor, guardado fuera de `public/`, rutas de streaming y eliminación bajo sesión autenticada y autorización del propietario. No se publican URLs directas. |
| Referencias privadas de Carla | Enlaces de YouTube y URLs directas a MP3 | Las URLs solo se muestran en el espacio autenticado y se validan como HTTPS. YouTube acepta únicamente enlaces de video en dominios oficiales; MP3 acepta URLs cuyo path termina en `.mp3`. La reproducción se solicita directamente al proveedor desde el navegador, no desde el servidor Laravel. |
| Privado de Carla | Preguntas, hashes HMAC de respuestas y foto-recompensa del cuestionario | Solo la primera cuenta propietaria puede administrar preguntas y subir o retirar la foto. La imagen permanece en el disco privado y no tiene URL pública. |
| Editable por Carla | Títulos, descripciones, favoritos, álbumes, entradas del diario, borradores del blog y cuestionario | Sesión autenticada, validación del servidor, CSRF y autorización en cada operación. El espacio personal ofrece un resumen y enlaces rápidos; los favoritos se consultan en una pantalla privada. Cada artículo del blog comienza como borrador y requiere una acción explícita de publicación. Las entradas del diario no se pueden publicar. |
| Administrativo | `.env`, credenciales y comandos de instalación/alta | Solo terminal y configuración del servidor; no hay panel técnico ni secretos en el navegador. |

Las fotos admitidas son JPG, PNG y WebP, con un máximo de 10 MB. Se guardan en `storage/app/private/garden`, no en `public/` ni mediante `storage:link`. La ruta de descarga requiere sesión, vuelve a comprobar que el usuario sea propietario y responde con `Cache-Control: private, no-store`. No se generan enlaces públicos ni URL firmadas públicas. El almacenamiento es local: el servidor necesita permisos de escritura y los archivos deben incluirse en una estrategia privada de copias de seguridad antes de producción.

### Cuestionario “Conociendo a Carla Lorena”

Carla puede administrar preguntas desde el espacio privado; se requieren al menos 10 activas y la partida elige 10 al azar. Las respuestas se escriben y pueden tener hasta ocho variantes. Se normalizan (mayúsculas, acentos y puntuación) y se guardan como HMAC SHA-256 con `APP_KEY`; el texto original de las respuestas no se persiste ni se devuelve al navegador. Si cambia `APP_KEY`, habrá que volver a registrar las variantes de respuesta.

Cada partida usa una selección fija en el servidor, expira en una hora y termina al primer error. El límite público es 10 nuevas partidas por hora y dirección IP. Solo una partida perfecta permite solicitar la foto. Para iniciar el juego, Carla debe cargar una imagen autorizada de forma explícita; hasta que existan 10 preguntas activas y una foto autorizada, el endpoint responde que está en preparación. Tras revelarse en el navegador, la foto puede guardarse o capturarse; por eso no se debe subir una imagen cuya difusión no esté autorizada.

Las políticas Laravel comprueban la propiedad de cada álbum y fotografía. Una clave foránea compuesta garantiza además que la fotografía y su álbum pertenezcan al mismo usuario, incluso si hay un error de asociación en la aplicación. El usuario MySQL de la aplicación debe limitar sus permisos a `el_jardin_de_carla`; no uses `root` como credencial de ejecución. **MySQL no ofrece políticas RLS equivalentes a Supabase**: las credenciales de la base solo residen en el servidor y no se entregan al navegador. Si en el futuro se necesita aislamiento SQL para consultas realizadas fuera de Laravel, deberá diseñarse y verificarse expresamente; no se presupone aquí.

## Limitaciones antes de publicar

- La base MySQL local, su esquema y la cuenta propietaria están configurados en el entorno local. No hay cuentas ni credenciales de demostración incorporadas al repositorio.
- La memoria, la búsqueda, las rutas de la historia, “¿Qué prefieres?”, el rompecabezas floral y el bingo de pequeños momentos son interacciones del navegador; sus resultados, marcas y movimientos no se guardan. Las elecciones y marcas permanecen únicamente en la pantalla mientras se juega.
- El cuestionario solo queda jugable después de que Carla añada al menos 10 preguntas activas y autorice y cargue la foto-recompensa. Los cinco juegos propuestos ya tienen prototipos jugables; “Adivina la escena” usa símbolos de demostración y no almacena resultados.
- “Las crónicas de la princesa Sultana” es una aventura ficticia de cinco capítulos. Guarda elecciones, cualidades y logros únicamente en `localStorage` del navegador actual; no requiere cuenta, no sincroniza entre dispositivos y puede perderse al borrar los datos del navegador. Incluye varios desenlaces según las decisiones y una opción de reinicio con confirmación. El romance opcional involucra solo a personajes inventados; Sultana no representa una biografía de Carla.
- “Los jardines secretos de Liria” es una aventura 3D local hecha con Three.js y formas geométricas, con doce etapas: las dos zonas originales y diez escenarios nuevos (luciérnagas, puente, laberinto, gruta, valle, arboleda, observatorio, cumbre, mareas altas y corazón secreto). Cada nuevo escenario tiene paleta, hito visual y distribución propios, objetivos, una aliada identificada con una pista contextual, enemigos patrulleros y trampas en cantidad creciente. Para avanzar, hay que reunir los objetos, escuchar a la aliada, activar el hito único del escenario y alcanzar el arco de salida; por ejemplo, encender un farol, hacer sonar una campana, alinear un prisma o abrir una compuerta. Los enemigos y trampas quitan vidas; al perder un corazón se vuelve al inicio del escenario conservando los objetos reunidos, mientras que agotar las tres vidas reinicia los objetivos de ese escenario. Incluye progresión visible, guía al objetivo pendiente, controles de teclado y táctiles, pausa y guardado local de la partida. Los datos se conservan en `localStorage` del navegador actual; no se envían a un servidor ni se sincronizan entre dispositivos. Los avances anteriores del capítulo y los primeros datos de campaña se migran al esquema actual al siguiente guardado. Reiniciar pide confirmación. Requiere WebGL; algunos móviles o navegadores pueden no ser compatibles. Es un prototipo geométrico, sin modelos profesionales, voz, música, multijugador ni cinemáticas.
- “Sultana y los senderos del alba” es un prototipo original de plataformas 2D lateral, separado de la exploración 3D. Incluye nueve niveles de dificultad creciente, pétalos como objetivos, sombras patrulleras, zarzas, checkpoints, tres corazones, salto doble desde el segundo nivel y destellos protectores desde el tercero. Cada escenario añade reliquias coleccionables temáticas distintas; encontrarlas recupera corazones y, desde el tercer nivel, concede destellos. Al perder un corazón, Sultana reaparece en el último checkpoint; al perder los tres, se reinicia desde el inicio del nivel actual con los coleccionables, enemigos y checkpoints restaurados. Los puntos se obtienen al recoger pétalos y reliquias, vencer enemigos y superar niveles. Los mejores resultados por nivel se guardan al completarlo; el récord de campaña solo se registra al completar los nueve niveles comenzando desde el primero y avanzando en orden. Los enemigos tienen tres patrones: las sombras patrullan, los murciélagos vuelan en vertical y los espíritus se abalanzan brevemente hacia Sultana; los tres pueden vencerse al saltarles encima. Los niveles 6–9 amplían los recorridos, encadenan plataformas más estrechas, elevan la cantidad de objetivos y enemigos, y culminan en “La corona de las estrellas”. Al superar el noveno nivel se muestra una escena final con una historia dedicada a Carla y una ilustración SVG original de Sultana en Liria. La ilustración es ficticia, no es una fotografía de Carla; solo debe sustituirse por una foto autorizada que proporcione la usuaria. El cierre ofrece volver a jugar desde el inicio. Sultana tiene una animación geométrica sencilla al correr y saltar, orientada hacia su dirección de movimiento. La partida se puede pausar y reanudar con el botón o con P sin perder el nivel. Al cruzar la salida con los pétalos necesarios, el nivel siguiente empieza automáticamente; se ofrece un botón para avanzar antes de que termine la breve transición. Se juega con teclado o controles táctiles; el máximo nivel desbloqueado, el final y los mejores resultados se guardan solo en `localStorage` del navegador. Reiniciar el avance borra desbloqueos y récords. No tiene cuenta, sincronización, editor de niveles ni recursos gráficos externos. Es una demostración Canvas 2D, no un juego 3D ni un producto publicado.
- El lector y la música son muestras, sin reproducción multimedia.
- No hay comentarios, recuperación de contraseña, verificación de correo ni moderación. El diario no se publica y los borradores del blog no se muestran a visitantes.
- Los archivos almacenados localmente no están cifrados automáticamente en reposo. Protege el sistema de archivos y las copias de seguridad.
- Los enlaces externos no hacen privada la fuente original. Aunque la referencia solo aparece en la cuenta autenticada, cuando se reproduce un video o audio el proveedor externo recibe la conexión del navegador y puede registrar datos técnicos. El reproductor de YouTube usa el dominio de privacidad mejorada y espera a una acción explícita; los MP3 externos no comienzan a cargarse hasta que se reproducen. Asegúrate de tener permiso para enlazar el contenido y de que la fuente permita reproducción desde otros sitios.
- El espacio multimedia es privado de la cuenta propietaria configurada; no es una biblioteca compartida para visitantes ni entre usuarios. Antes de usar cargas máximas, ajusta el `php.ini` que usa Apache para permitir al menos `upload_max_filesize = 100M` y `post_max_size = 110M`, y reinicia Apache. Revisa también `max_execution_time`, `max_input_time` y los límites del proxy/servidor web. Si dichos topes no alcanzan, PHP o el servidor pueden rechazar la petición antes de que Laravel pueda mostrar su propio error.
- La publicación está desactivada por defecto y no se ha autorizado ni realizado.
