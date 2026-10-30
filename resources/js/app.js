import { openMuseumLightbox, registerPassportStamp, initMuseumLightbox, initGardenPassport } from './museum-passport.js';
import { initFloatingSurprises } from './floating-surprises.js';
import { initFriendDedications } from './friend-dedications.js';
import { initHomeCardsAdmin } from './home-cards-admin.js';
import { initSeasonalWeather } from './seasonal-weather.js';
import { initMasterAudioController } from './master-audio.js';
import './bootstrap';
import { playMusicForScreen, enableAudio, toggleMusic, setMasterVolume, isMusicPlaying } from './garden-audio.js';
import { getRandomMessage, MESSAGE_COUNT } from './love-messages.js';
import { initializeCornerNotes } from './corner-notes.js';
import { initializeAdminSystem } from './admin.js';
import { initializeEntertainmentPlayer } from './entertainment-player.js';
import { initializeTimeCapsules } from './time-capsules.js';

const screens = [...document.querySelectorAll('[data-screen]')];
const validScreens = new Set(screens.map((screen) => screen.dataset.screen));
const menuToggle = document.querySelector('.menu-toggle');
const mainNav = document.querySelector('.main-nav');
const toast = document.querySelector('.toast');
const dialog = document.querySelector('.image-dialog');
let toastTimer;
let memoryCards = [];
let memorySelection = [];
let memoryMoves = 0;
let memoryPairs = 0;
let memoryLocked = false;
let memoryTimer;
let quizToken = null;
let quizQuestionId = null;
let quizBusy = false;
let preferenceRounds = [];
let preferenceRoundIndex = 0;
let flowerTiles = [];
let flowerMoves = 0;
let kindnessBingoTiles = [];
let sceneRounds = [];
let sceneRoundIndex = 0;
let sceneRoundSolved = false;
let sultanaProgress = null;
let sultanaStorageAvailable = true;
let sultanaGardenModule;
let sultanaPlatformerModule;

async function loadSultanaGarden() {
    const status = document.querySelector('[data-garden3d-status]');
    try {
        sultanaGardenModule ??= import('./sultana-garden.js');
        const { initializeSultanaGarden } = await sultanaGardenModule;
        initializeSultanaGarden();
    } catch (error) {
        console.error('No se pudo inicializar el jardín 3D.', error);
        if (status) status.textContent = `No se pudo cargar el prototipo 3D: ${error instanceof Error ? error.message : 'error inesperado'}.`;
    }
}

async function loadSultanaPlatformer() {
    const status = document.querySelector('[data-platformer-status]');
    try {
        sultanaPlatformerModule ??= import('./sultana-platformer.js');
        const { initializeSultanaPlatformer } = await sultanaPlatformerModule;
        initializeSultanaPlatformer();
    } catch (error) {
        console.error('No se pudo inicializar la aventura de plataformas de Sultana.', error);
        if (status) status.textContent = `No se pudo cargar la aventura: ${error instanceof Error ? error.message : 'error inesperado'}.`;
    }
}

const sultanaStorageKey = 'el-jardin-de-carla:sultana:v1';
const sultanaAchievements = [
    { id: 'first-step', label: 'Primer paso', description: 'Iniciaste el viaje de Sultana.' },
    { id: 'royal-counsel', label: 'Consejo real', description: 'Tomaste una decisión para proteger el reino.' },
    { id: 'open-heart', label: 'Corazón abierto', description: 'Compartiste un momento con un personaje ficticio.' },
    { id: 'old-secret', label: 'Enigma resuelto', description: 'Llegaste a la cámara de los antiguos mapas.' },
    { id: 'new-dawn', label: 'Un nuevo amanecer', description: 'Completaste la aventura y elegiste el futuro del reino.' },
];
const sultanaChapters = [
    {
        title: 'El jardín de las fuentes',
        scene: 'CAPÍTULO 01 · LA FUENTE SILENCIOSA',
        copy: 'En el reino de Liria, las fuentes del jardín real han dejado de cantar. La princesa Sultana encuentra huellas junto al canal y una jardinera preocupada por las flores.',
        choices: [
            { label: 'Seguir las huellas hasta el viejo invernadero', effects: { wisdom: 1, trust: 1 }, feedback: 'Con paciencia, encontraste una compuerta cubierta de hiedra.' },
            { label: 'Escuchar a la jardinera y reunir ayuda', effects: { compassion: 2, trust: 1 }, feedback: 'La jardinera recordó una antigua ruta de agua y decidió acompañarte.' },
        ],
    },
    {
        title: 'El consejo de Liria',
        scene: 'CAPÍTULO 02 · UNA DECISIÓN PARA EL REINO',
        copy: 'La fuente vuelve a fluir, pero el valle aún necesita agua. En el consejo, Sultana debe escoger cómo repartir las reservas antes de que llegue la estación seca.',
        choices: [
            { label: 'Reunir a las aldeas y acordar turnos justos', effects: { wisdom: 2, compassion: 1 }, feedback: 'Un plan compartido dio voz a cada aldea y cuidó las reservas.' },
            { label: 'Abrir primero el canal hacia los huertos más frágiles', effects: { courage: 1, compassion: 2 }, feedback: 'Tu decisión protegió las cosechas que más lo necesitaban.' },
        ],
    },
    {
        title: 'La velada de los luceros',
        scene: 'CAPÍTULO 03 · UN ENCUENTRO BAJO LAS ESTRELLAS',
        copy: 'Durante una velada en el observatorio, Sultana conoce a Elian, un cartógrafo ficticio, y a Narel, una poeta ficticia. Puedes compartir una conversación cercana con quien prefieras, o disfrutar la noche sin iniciar un romance.',
        choices: [
            { label: 'Compartir un paseo y una conversación con Elian', effects: { romance: 2, trust: 1 }, companion: 'Elian', feedback: 'Elian compartió contigo un mapa de constelaciones y una conversación sincera.' },
            { label: 'Compartir versos y una conversación con Narel', effects: { romance: 2, wisdom: 1 }, companion: 'Narel', feedback: 'Narel te dedicó un verso sobre los caminos que se eligen con libertad.' },
            { label: 'Conversar con todo el grupo y observar las estrellas', effects: { compassion: 1, wisdom: 1 }, companion: null, feedback: 'La velada fue una amistad luminosa, sin romance.' },
        ],
    },
    {
        title: 'La cámara de los mapas',
        scene: 'CAPÍTULO 04 · EL ENIGMA DEL ASTROLABIO',
        copy: 'Un astrolabio antiguo señala una cámara oculta. La inscripción pregunta qué sostiene mejor un reino: una sola voz o muchas que aprenden a escucharse.',
        choices: [
            { label: 'Resolver el acertijo estudiando los mapas y las estrellas', effects: { wisdom: 2 }, feedback: 'El astrolabio reconoció tu paciencia y abrió la cámara.' },
            { label: 'Invitar a tus acompañantes a resolverlo en equipo', effects: { trust: 1, compassion: 1 }, feedback: 'Cada persona aportó una pista; la cámara se abrió con una respuesta compartida.' },
        ],
    },
    {
        title: 'El amanecer de Liria',
        scene: 'CAPÍTULO 05 · EL FUTURO QUE FLORECE',
        copy: 'Desde la cámara, ves dos senderos para el reino. La decisión final de Sultana honrará lo aprendido y marcará el comienzo de una nueva era.',
        choices: [
            { label: 'Fundar un consejo donde cada aldea tenga voz', effects: { wisdom: 1, compassion: 1 }, ending: 'council', feedback: 'Liria se convirtió en un reino de acuerdos y jardines compartidos.' },
            { label: 'Abrir nuevas rutas para unir a todos los pueblos', effects: { courage: 1, trust: 1 }, ending: 'horizons', feedback: 'Liria floreció como un reino de exploradores y caminos abiertos.' },
        ],
    },
];
const sultanaEndings = {
    council: {
        title: 'El reino de las mil voces',
        copy: 'Sultana fundó un consejo donde cada aldea pudo participar. El agua volvió a los jardines y el reino aprendió que la fortaleza también nace de escuchar.',
        romance: 'Con ',
        romanceEnd: ', la amistad —o el cariño que elijas cultivar— siguió creciendo con tiempo y respeto.',
        solo: 'Su círculo de amistades creció junto con los jardines de Liria.',
    },
    horizons: {
        title: 'La ruta hacia nuevos horizontes',
        copy: 'Sultana abrió caminos entre pueblos que nunca se habían encontrado. Liria prosperó gracias a la curiosidad, la confianza y las alianzas que nacieron en el viaje.',
        romance: 'Junto a ',
        romanceEnd: ', encontró una compañía que respetaba sus sueños y su libertad.',
        solo: 'Sus amistades la acompañaron en cada nuevo camino.',
    },
    romance: {
        title: 'Una promesa bajo las estrellas',
        copy: 'Sultana guio Liria con empatía y sabiduría. Al final del viaje, decidió explorar un vínculo afectuoso, elegido libremente, junto a ',
        romanceEnd: '. Su romance ficticio creció sin prisa, como los jardines que cuidaron juntos.',
    },
};

function newSultanaProgress() {
    return {
        version: 1,
        chapter: 0,
        stats: { wisdom: 0, compassion: 0, trust: 0, courage: 0, romance: 0 },
        achievements: [],
        started: true,
        completed: false,
        ending: null,
        companion: null,
        lastOutcome: '',
    };
}

function isValidSultanaProgress(progress) {
    const statNames = ['wisdom', 'compassion', 'trust', 'courage', 'romance'];
    return progress
        && progress.version === 1
        && Number.isInteger(progress.chapter)
        && progress.chapter >= 0
        && progress.chapter <= sultanaChapters.length
        && progress.started === true
        && typeof progress.completed === 'boolean'
        && progress.completed === (progress.chapter === sultanaChapters.length)
        && progress.stats
        && statNames.every((name) => Number.isInteger(progress.stats[name]) && progress.stats[name] >= 0 && progress.stats[name] <= 20)
        && Array.isArray(progress.achievements)
        && progress.achievements.every((id) => sultanaAchievements.some((achievement) => achievement.id === id))
        && (progress.companion === null || progress.companion === 'Elian' || progress.companion === 'Narel')
        && (progress.stats.romance === 0 ? progress.companion === null : progress.companion !== null && progress.stats.romance >= 2)
        && (progress.completed ? Object.hasOwn(sultanaEndings, progress.ending) : progress.ending === null)
        && typeof progress.lastOutcome === 'string'
        && progress.lastOutcome.length <= 300;
}

function updateSultanaSaveStatus(message) {
    document.querySelectorAll('[data-sultana-save-status]').forEach((status) => {
        status.hidden = false;
        status.textContent = message;
    });
}

function updateSultanaCardStatus() {
    const status = document.querySelector('[data-sultana-card-status]');
    if (!status) return;
    if (!sultanaProgress) {
        status.textContent = '5 capítulos · progreso local';
    } else if (sultanaProgress.completed) {
        status.textContent = 'Aventura completada · jugar de nuevo';
    } else {
        status.textContent = `Retomar · capítulo ${sultanaProgress.chapter + 1} de ${sultanaChapters.length}`;
    }
}

function loadSultanaProgress() {
    try {
        const stored = window.localStorage.getItem(sultanaStorageKey);
        if (!stored) return;
        const progress = JSON.parse(stored);
        if (!isValidSultanaProgress(progress)) {
            sultanaStorageAvailable = false;
            const clearButton = document.querySelector('[data-sultana-clear]');
            if (clearButton) clearButton.hidden = false;
            updateSultanaSaveStatus('El avance guardado no tiene un formato válido. No se ha borrado; puedes iniciar una partida nueva.');
            return;
        }
        sultanaProgress = progress;
        updateSultanaSaveStatus('Avance recuperado de este navegador.');
        updateSultanaCardStatus();
    } catch (error) {
        sultanaStorageAvailable = false;
        const clearButton = document.querySelector('[data-sultana-clear]');
        if (error instanceof SyntaxError && clearButton) clearButton.hidden = false;
        updateSultanaSaveStatus(error instanceof SyntaxError
            ? 'El avance guardado está dañado y no se ha borrado. Puedes iniciar una nueva partida, pero no se conservará mientras este error siga presente.'
            : 'El navegador no permitió leer el avance guardado. Puedes jugar, pero el progreso no se conservará.');
        const cardStatus = document.querySelector('[data-sultana-card-status]');
        if (cardStatus) cardStatus.textContent = 'Partida guardada no disponible';
    }
}

function persistSultanaProgress() {
    if (!sultanaStorageAvailable || !sultanaProgress) return;
    try {
        window.localStorage.setItem(sultanaStorageKey, JSON.stringify(sultanaProgress));
        updateSultanaSaveStatus('Avance guardado en este navegador.');
        updateSultanaCardStatus();
    } catch {
        sultanaStorageAvailable = false;
        updateSultanaSaveStatus('El navegador no pudo guardar el avance. La partida seguirá disponible hasta que cierres esta página.');
        const cardStatus = document.querySelector('[data-sultana-card-status]');
        if (cardStatus) cardStatus.textContent = 'Partida disponible en esta sesión';
    }
}

function unlockSultanaAchievement(id) {
    if (!sultanaProgress || sultanaProgress.achievements.includes(id)) return;
    sultanaProgress.achievements.push(id);
}

function startSultanaAdventure() {
    sultanaProgress = newSultanaProgress();
    unlockSultanaAchievement('first-step');
    persistSultanaProgress();
    renderSultanaAdventure();
    document.querySelector('[data-sultana-scene-title]')?.focus();
}

function renderSultanaAdventure() {
    const game = document.querySelector('[data-sultana-game]');
    if (!game) return;

    const intro = game.querySelector('[data-sultana-intro]');
    const play = game.querySelector('[data-sultana-play]');
    const startButton = game.querySelector('[data-sultana-start]');
    if (!sultanaProgress) {
        intro.hidden = false;
        play.hidden = true;
        startButton.textContent = 'Comenzar la aventura →';
        return;
    }

    intro.hidden = true;
    play.hidden = false;
    game.querySelector('[data-sultana-progress]').value = sultanaProgress.chapter;
    game.querySelector('[data-sultana-progress-label]').textContent = sultanaProgress.completed
        ? 'Aventura completada'
        : `Capítulo ${sultanaProgress.chapter + 1} de ${sultanaChapters.length}`;
    Object.entries(sultanaProgress.stats).forEach(([name, value]) => {
        const stat = game.querySelector(`[data-sultana-stat="${name}"]`);
        if (stat) stat.textContent = String(value);
    });

    const chapter = sultanaChapters[sultanaProgress.chapter];
    const chapterLabel = game.querySelector('[data-sultana-level]');
    const chapterName = game.querySelector('[data-sultana-chapter]');
    const title = game.querySelector('[data-sultana-scene-title]');
    const copy = game.querySelector('[data-sultana-scene-copy]');
    const feedback = game.querySelector('[data-sultana-feedback]');
    const choices = game.querySelector('[data-sultana-choices]');
    const endingPanel = game.querySelector('[data-sultana-ending]');

    if (sultanaProgress.completed) {
        const ending = sultanaEndings[sultanaProgress.ending];
        chapterLabel.textContent = 'AVENTURA COMPLETADA';
        chapterName.textContent = 'EL FINAL · UNA NUEVA HISTORIA COMIENZA';
        title.textContent = ending.title;
        copy.textContent = ending.copy;
        if (sultanaProgress.ending === 'romance') {
            copy.textContent += `${sultanaProgress.companion}${ending.romanceEnd}`;
        } else if (sultanaProgress.companion) {
            copy.textContent += ` ${ending.romance}${sultanaProgress.companion}${ending.romanceEnd}`;
        } else {
            copy.textContent += ` ${ending.solo}`;
        }
        feedback.hidden = true;
        choices.replaceChildren();
        endingPanel.hidden = false;
        endingPanel.textContent = 'FIN · Gracias por acompañar a Sultana en esta aventura.';
    } else {
        chapterLabel.textContent = `NIVEL ${String(sultanaProgress.chapter + 1).padStart(2, '0')} DE 05`;
        chapterName.textContent = chapter.scene;
        title.textContent = chapter.title;
        copy.textContent = chapter.copy;
        feedback.hidden = !sultanaProgress.lastOutcome;
        feedback.textContent = sultanaProgress.lastOutcome ? `Consecuencia de tu decisión anterior: ${sultanaProgress.lastOutcome}` : '';
        endingPanel.hidden = true;
        choices.replaceChildren(...chapter.choices.map((choice, index) => {
            const button = document.createElement('button');
            button.className = 'button button-outline';
            button.type = 'button';
            button.dataset.sultanaChoice = String(index);
            button.textContent = choice.label;
            return button;
        }));
    }

    renderSultanaAchievements();
}

function renderSultanaAchievements() {
    const list = document.querySelector('[data-sultana-achievements]');
    if (!list || !sultanaProgress) return;

    const earned = new Set(sultanaProgress.achievements);
    list.replaceChildren(...sultanaAchievements.map((achievement) => {
        const item = document.createElement('li');
        item.className = `sultana-achievement${earned.has(achievement.id) ? ' is-earned' : ''}`;
        item.setAttribute('aria-label', `${achievement.label}: ${earned.has(achievement.id) ? 'desbloqueado' : 'pendiente'}`);
        const title = document.createElement('strong');
        title.textContent = `${earned.has(achievement.id) ? '✓ ' : '◇ '}${achievement.label}`;
        const description = document.createElement('span');
        description.textContent = achievement.description;
        item.append(title, description);
        return item;
    }));
    document.querySelector('[data-sultana-achievement-count]').textContent = `${earned.size} de ${sultanaAchievements.length}`;
}

function chooseSultanaAction(index) {
    const chapter = sultanaChapters[sultanaProgress?.chapter];
    const choice = chapter?.choices[index];
    if (!sultanaProgress || !choice || sultanaProgress.completed) return;

    Object.entries(choice.effects).forEach(([stat, amount]) => {
        sultanaProgress.stats[stat] += amount;
    });
    if ('companion' in choice) sultanaProgress.companion = choice.companion;
    sultanaProgress.lastOutcome = choice.feedback;
    const completedChapter = sultanaProgress.chapter;
    sultanaProgress.chapter += 1;
    if (completedChapter === 1) unlockSultanaAchievement('royal-counsel');
    if (completedChapter === 2) unlockSultanaAchievement('open-heart');
    if (completedChapter === 3) unlockSultanaAchievement('old-secret');
    if (sultanaProgress.chapter === sultanaChapters.length) {
        sultanaProgress.completed = true;
        sultanaProgress.ending = sultanaProgress.stats.romance >= 2 && sultanaProgress.stats.compassion >= 2
            ? 'romance'
            : choice.ending === 'council' && sultanaProgress.stats.wisdom >= 2 && sultanaProgress.stats.compassion >= 2
                ? 'council'
                : 'horizons';
        unlockSultanaAchievement('new-dawn');
    }
    persistSultanaProgress();
    renderSultanaAdventure();
    document.querySelector('[data-sultana-scene-title]')?.focus();
}

function resetSultanaAdventure() {
    if (!window.confirm('¿Reiniciar la aventura? Se borrará únicamente el avance de Sultana guardado en este navegador.')) return;
    try {
        window.localStorage.removeItem(sultanaStorageKey);
    } catch {
        sultanaStorageAvailable = false;
        updateSultanaSaveStatus('No se pudo borrar el avance guardado en este navegador.');
        return;
    }
    sultanaProgress = null;
    sultanaStorageAvailable = true;
    const clearButton = document.querySelector('[data-sultana-clear]');
    if (clearButton) clearButton.hidden = true;
    updateSultanaSaveStatus('Avance reiniciado.');
    updateSultanaCardStatus();
    renderSultanaAdventure();
}

const kindnessBingoIdeas = [
    'Disfrutar una bebida sin prisa',
    'Escuchar una canción que te guste',
    'Estirar suavemente los hombros',
    'Leer unas páginas por gusto',
    'Anotar algo bonito del día',
    'Enviar un saludo cariñoso',
    'Tomar un poco de aire fresco',
    'Mirar una planta o una flor',
    'Descansar unos minutos',
    'Preparar un rincón acogedor',
    'Recordar un momento feliz',
    'Hacer una pausa lejos de la pantalla',
];
const sceneGuessCards = [
    {
        symbols: ['☕', '📖', '🌧️'],
        description: 'Taza caliente, libro abierto y lluvia en la ventana',
        choices: [
            { label: 'Una tarde de lectura mientras llueve', correct: true },
            { label: 'Un desayuno al aire libre', correct: false },
            { label: 'Preparar una maleta para viajar', correct: false },
        ],
    },
    {
        symbols: ['🌷', '🪴', '💧'],
        description: 'Flores, una maceta y agua para regarlas',
        choices: [
            { label: 'Cuidar las flores en una tarde tranquila', correct: true },
            { label: 'Pasear bajo la lluvia por la ciudad', correct: false },
            { label: 'Preparar una mesa para cenar', correct: false },
        ],
    },
    {
        symbols: ['🧳', '☀️', '🌊'],
        description: 'Una maleta, el sol y olas del mar',
        choices: [
            { label: 'Preparar una escapada junto al mar', correct: true },
            { label: 'Leer una historia en casa', correct: false },
            { label: 'Regar las plantas del jardín', correct: false },
        ],
    },
    {
        symbols: ['🍿', '🎬', '🛋️'],
        description: 'Palomitas, una película y un sofá cómodo',
        choices: [
            { label: 'Disfrutar una película en el sofá', correct: true },
            { label: 'Organizar un picnic en el jardín', correct: false },
            { label: 'Buscar un libro en la biblioteca', correct: false },
        ],
    },
];

const memorySymbols = ['✿', '❀', '✧', '♡', '❋', '☼'];
const preferencePrompts = [
    { prompt: 'Prepara un momento para ti…', options: ['Una taza de té', 'Un café recién hecho'] },
    { prompt: '¿Qué paisaje elegirías para descansar?', options: ['Un jardín en primavera', 'Una playa al atardecer'] },
    { prompt: '¿Cómo disfrutarías una tarde tranquila?', options: ['Leer un libro especial', 'Ver una película reconfortante'] },
    { prompt: '¿Qué pequeño detalle te alegraría el día?', options: ['Flores frescas en casa', 'Una nota cariñosa'] },
    { prompt: 'Si pudieras escaparte un rato…', options: ['Pasear por un lugar nuevo', 'Quedarte en tu rincón favorito'] },
];
const treasureSteps = [
    {
        clue: 'Donde las flores reciben el sol…',
        choices: ['La biblioteca', 'El jardín', 'El mapa de sueños'],
        answer: 1,
        feedback: 'Busca el rincón que huele a primavera.',
    },
    {
        clue: 'Ahora encuentra un lugar lleno de palabras que guardan historias…',
        choices: ['La galería', 'La búsqueda del tesoro', 'La biblioteca'],
        answer: 2,
        feedback: 'Piensa en un sitio para leer y dejar volar la imaginación.',
    },
    {
        clue: 'El último recuerdo se esconde donde las imágenes vuelven a la vida…',
        choices: ['La galería', 'El jardín', 'La biblioteca'],
        answer: 0,
        feedback: 'Mira entre las fotografías de muestra para encontrar la sorpresa.',
    },
];

const storyNodes = {
    inicio: {
        chapter: 'EL SOBRE MALVA · CAPÍTULO 01',
        text: 'Una mañana, junto a la puerta, encontraste un sobre color lavanda.',
        detail: 'No llevaba remitente, solo una pequeña flor dibujada. Dentro había una nota: «Hay un lugar que quiero mostrarte…»',
        choices: [
            { label: 'Seguir el aroma de las flores', next: 'jardin' },
            { label: 'Leer la nota completa', next: 'nota' },
        ],
    },
    jardin: {
        chapter: 'EL SOBRE MALVA · CAPÍTULO 02',
        text: 'El aroma te llevó a un jardín secreto. En el centro había un banco y un sendero iluminado.',
        detail: 'La nota decía: «A veces lo mejor es detenerse. Otras, descubrir qué hay más allá.»',
        choices: [
            { label: 'Descansar un momento en el banco', next: 'final-banco' },
            { label: 'Seguir el sendero iluminado', next: 'final-sendero' },
        ],
    },
    nota: {
        chapter: 'EL SOBRE MALVA · CAPÍTULO 02',
        text: 'La nota guardaba un pequeño mapa y una invitación a encontrar tu rincón favorito.',
        detail: '«Hay belleza en lo que recordamos y en lo que aún no hemos vivido», decía al final.',
        choices: [
            { label: 'Buscar un recuerdo en la galería', next: 'final-galeria' },
            { label: 'Imaginar un próximo destino', next: 'final-destino' },
        ],
    },
    'final-banco': {
        chapter: 'EL SOBRE MALVA · FINAL',
        text: 'Te sentaste bajo la sombra y descubriste que el silencio también puede ser un regalo.',
        detail: 'Guardaste la nota entre las páginas de un libro, para volver a leerla cuando hiciera falta.',
        choices: [{ label: 'Leer de nuevo', next: 'inicio', restart: true }],
    },
    'final-sendero': {
        chapter: 'EL SOBRE MALVA · FINAL',
        text: 'Al final del sendero había una ventana abierta a un paisaje que todavía no conocías.',
        detail: 'Sonreíste: algunos caminos no necesitan destino para merecer la pena.',
        choices: [{ label: 'Volver a empezar', next: 'inicio', restart: true }],
    },
    'final-galeria': {
        chapter: 'EL SOBRE MALVA · FINAL',
        text: 'Entre las imágenes encontraste una pequeña flor prensada, compañera de aquel sobre.',
        detail: 'No era un recuerdo tuyo todavía, pero ya tenía un lugar en tu historia.',
        choices: [{ label: 'Volver a empezar', next: 'inicio', restart: true }],
    },
    'final-destino': {
        chapter: 'EL SOBRE MALVA · FINAL',
        text: 'En el mapa marcaste un lugar lejano con una estrella color lavanda.',
        detail: 'La nota terminaba así: «Los sueños también son una forma de llegar.»',
        choices: [{ label: 'Volver a empezar', next: 'inicio', restart: true }],
    },
};

// ── Transición Cinemática de Ráfaga de Pétalos ──
function triggerPetalTransition() {
    const canvas = document.getElementById('page-petal-transition-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    canvas.classList.add('is-active');

    const petals = [];
    const colors = ['#fadadd', '#f7c4ce', '#f2aab8', '#e8899a', '#d4607a', '#ffffff', '#e8a598'];
    const count = 42;

    for (let i = 0; i < count; i++) {
        petals.push({
            x: Math.random() * canvas.width,
            y: -20 - Math.random() * 100,
            size: 8 + Math.random() * 16,
            speedY: 4 + Math.random() * 6,
            speedX: (Math.random() - 0.5) * 4,
            rotation: Math.random() * 360,
            rotSpeed: (Math.random() - 0.5) * 6,
            color: colors[Math.floor(Math.random() * colors.length)],
            opacity: 0.85
        });
    }

    let start = performance.now();
    function animate(time) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        let alive = false;

        petals.forEach(p => {
            p.y += p.speedY;
            p.x += p.speedX;
            p.rotation += p.rotSpeed;
            if (p.y < canvas.height + 40) {
                alive = true;
                ctx.save();
                ctx.translate(p.x, p.y);
                ctx.rotate((p.rotation * Math.PI) / 180);
                ctx.globalAlpha = p.opacity;
                ctx.fillStyle = p.color;
                ctx.beginPath();
                ctx.ellipse(0, 0, p.size * 0.6, p.size, Math.PI / 4, 0, 2 * Math.PI);
                ctx.fill();
                ctx.restore();
            }
        });

        if (alive && performance.now() - start < 1200) {
            requestAnimationFrame(animate);
        } else {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            canvas.classList.remove('is-active');
        }
    }
    requestAnimationFrame(animate);
}

// ── Respuesta Háptica Móvil Sutil ──
function triggerHaptic(pattern = [15, 25, 15]) {
    try {
        if ('vibrate' in navigator && typeof navigator.vibrate === 'function') {
            navigator.vibrate(pattern);
        }
    } catch (_) {}
}

function showScreen(screenName, updateHistory = true) {
    if (screens.length === 0) return;

    const target = validScreens.has(screenName) ? screenName : 'inicio';

    // Ráfaga cinematográfica de pétalos y respuesta táctil
    triggerPetalTransition();
    triggerHaptic([18, 30]);

    screens.forEach((screen) => {
        const isActive = screen.dataset.screen === target;
        screen.hidden = !isActive;
        screen.classList.toggle('is-active', isActive);
    });

    if (updateHistory && window.location.hash !== `#${target}`) {
        window.history.pushState({ screen: target }, '', `#${target}`);
    }

    const activeScreen = screens.find((screen) => screen.dataset.screen === target);
    const heading = activeScreen?.querySelector('h1');
    document.title = heading ? `${heading.innerText.trim().replace(/\s+/g, ' ')} · El Jardín de Carla` : 'El Jardín de Carla';
    window.scrollTo({ top: 0, behavior: 'smooth' });
    closeMenu();
    if (target === 'jardines-liria') loadSultanaGarden();
    if (target === 'sultana-plataformas') loadSultanaPlatformer();
    // ── Registro de pasaporte botánico ──
    if (typeof registerPassportStamp === 'function') {
        registerPassportStamp(target);
    }
    // ── Música de fondo ──
    playMusicForScreen(target);
}

function closeMenu() {
    mainNav?.classList.remove('is-open');
    menuToggle?.setAttribute('aria-expanded', 'false');
    menuToggle?.setAttribute('aria-label', 'Abrir menú');
}

function updateMediaSourceFields(form) {
    const sourceType = form.querySelector('[data-media-source-type]')?.value;
    const isUpload = sourceType === 'upload';
    const isLink = sourceType === 'youtube' || sourceType === 'external_audio';

    form.querySelectorAll('[data-media-upload-fields]').forEach((fields) => {
        fields.hidden = !isUpload;
        fields.querySelectorAll('input, select').forEach((input) => {
            input.disabled = !isUpload;
            input.required = isUpload && input.name === 'file';
        });
    });
    form.querySelectorAll('[data-media-link-fields]').forEach((fields) => {
        fields.hidden = !isLink;
        const input = fields.querySelector('[name="source_url"]');
        if (input) {
            input.disabled = !isLink;
            input.required = isLink;
        }
    });

    const help = form.querySelector('[data-media-link-help]');
    if (help) {
        help.textContent = sourceType === 'youtube'
            ? 'Pega un enlace de YouTube al video (youtube.com o youtu.be). Se cargará solo cuando pulses reproducir.'
            : 'Pega una URL HTTPS que apunte directamente a un archivo terminado en .mp3.';
    }
}

document.querySelectorAll('.media-upload-form').forEach((form) => {
    updateMediaSourceFields(form);
    form.querySelector('[data-media-source-type]')?.addEventListener('change', () => updateMediaSourceFields(form));
});

document.addEventListener('click', (event) => {
    const youtubeButton = event.target.closest('[data-youtube-load]');
    if (youtubeButton) {
        const embedUrl = youtubeButton.dataset.embedUrl;
        if (!/^https:\/\/www\.youtube-nocookie\.com\/embed\/[A-Za-z0-9_-]{11}$/.test(embedUrl ?? '')) return;

        const iframe = document.createElement('iframe');
        iframe.src = embedUrl;
        iframe.title = youtubeButton.getAttribute('aria-label') ?? 'Video de YouTube';
        iframe.loading = 'eager';
        iframe.referrerPolicy = 'strict-origin-when-cross-origin';
        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
        iframe.allowFullscreen = true;
        youtubeButton.replaceWith(iframe);
        return;
    }

    const goLink = event.target.closest('[data-go]');
    if (goLink) {
        event.preventDefault();
        showScreen(goLink.dataset.go);
        return;
    }

    if (event.target.closest('[data-sultana-start]')) {
        startSultanaAdventure();
        return;
    }

    const sultanaChoice = event.target.closest('[data-sultana-choice]');
    if (sultanaChoice) {
        chooseSultanaAction(Number(sultanaChoice.dataset.sultanaChoice));
        return;
    }

    if (event.target.closest('[data-sultana-reset], [data-sultana-clear]')) {
        resetSultanaAdventure();
        return;
    }

    const noticeButton = event.target.closest('[data-notice]');
    if (noticeButton) {
        toast.textContent = noticeButton.dataset.notice;
        toast.classList.add('is-visible');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(() => toast.classList.remove('is-visible'), 3800);
        return;
    }

    const filterButton = event.target.closest('[data-filter]');
    if (filterButton) {
        document.querySelectorAll('[data-filter]').forEach((button) => {
            const isSelected = button === filterButton;
            button.classList.toggle('is-selected', isSelected);
            button.setAttribute('aria-pressed', String(isSelected));
        });
        document.querySelectorAll('.gallery-item').forEach((item) => {
            item.hidden = filterButton.dataset.filter !== 'todos' && item.dataset.kind !== filterButton.dataset.filter;
        });
        return;
    }

    const blogFilter = event.target.closest('[data-blog-filter]');
    if (blogFilter) {
        document.querySelectorAll('[data-blog-filter]').forEach((button) => {
            const isSelected = button === blogFilter;
            button.classList.toggle('is-selected', isSelected);
            button.setAttribute('aria-pressed', String(isSelected));
        });
        filterBlogPosts();
        return;
    }

    const galleryItem = event.target.closest('.gallery-item');
    if (galleryItem) {
        openMuseumLightbox(galleryItem);
        return;
    }

    const memoryCard = event.target.closest('[data-memory-card]');
    if (memoryCard) {
        revealMemoryCard(memoryCard);
        return;
    }

    if (event.target.closest('.memory-reset')) {
        startMemoryGame();
        return;
    }

    const flowerPiece = event.target.closest('[data-flower-position]');
    if (flowerPiece) {
        slideFlowerTile(Number(flowerPiece.dataset.flowerPosition));
        return;
    }

    if (event.target.closest('[data-flower-restart]')) {
        startFlowerPuzzle();
        return;
    }

    const kindnessBingoTile = event.target.closest('[data-kindness-bingo-tile]');
    if (kindnessBingoTile) {
        toggleKindnessBingoTile(Number(kindnessBingoTile.dataset.kindnessBingoTile));
        return;
    }

    if (event.target.closest('[data-kindness-bingo-reset]')) {
        startKindnessBingo();
        return;
    }

    const sceneChoice = event.target.closest('[data-scene-choice]');
    if (sceneChoice) {
        chooseSceneGuess(sceneChoice);
        return;
    }

    if (event.target.closest('[data-scene-next]')) {
        sceneRoundIndex += 1;
        renderSceneGuessRound();
        return;
    }

    if (event.target.closest('[data-scene-restart]')) {
        startSceneGuessGame();
        return;
    }

    const preferenceChoice = event.target.closest('[data-preference-choice]');
    if (preferenceChoice) {
        choosePreference(Number(preferenceChoice.dataset.preferenceChoice));
        return;
    }

    if (event.target.closest('[data-preference-next]')) {
        preferenceRoundIndex += 1;
        renderPreferenceRound();
        return;
    }

    if (event.target.closest('[data-preference-restart]')) {
        startPreferenceGame();
        return;
    }

    if (event.target.closest('[data-quiz-start]')) {
        startCarlaQuiz();
        return;
    }

    const saveQuizQuestion = event.target.closest('[data-quiz-save]');
    if (saveQuizQuestion) {
        saveCarlaQuizQuestion(saveQuizQuestion.closest('[data-quiz-admin-question]'));
        return;
    }

    const deleteQuizQuestion = event.target.closest('[data-quiz-delete]');
    if (deleteQuizQuestion) {
        if (window.confirm('¿Eliminar esta pregunta? No se puede deshacer.')) {
            deleteCarlaQuizQuestion(deleteQuizQuestion.closest('[data-quiz-admin-question]'));
        }
        return;
    }

    const storyChoice = event.target.closest('[data-story-choice]');
    if (storyChoice) {
        renderStory(storyChoice.dataset.storyChoice);
        return;
    }

    const treasureChoice = event.target.closest('[data-treasure-choice]');
    if (treasureChoice) {
        chooseTreasureAnswer(Number(treasureChoice.dataset.treasureChoice));
        return;
    }

    if (event.target.closest('.treasure-restart')) {
        startTreasure();
    }
});

document.querySelector('[data-blog-search]')?.addEventListener('input', filterBlogPosts);

document.querySelector('[data-flower-board]')?.addEventListener('keydown', (event) => {
    const board = event.currentTarget;
    const blankPosition = flowerTiles.indexOf(8);
    const row = Math.floor(blankPosition / 3);
    const column = blankPosition % 3;
    const positionByKey = {
        ArrowLeft: column > 0 ? blankPosition - 1 : -1,
        ArrowRight: column < 2 ? blankPosition + 1 : -1,
        ArrowUp: row > 0 ? blankPosition - 3 : -1,
        ArrowDown: row < 2 ? blankPosition + 3 : -1,
    };
    const target = positionByKey[event.key];

    if (target !== undefined && target >= 0 && !board.closest('[hidden]')) {
        event.preventDefault();
        slideFlowerTile(target);
    }
});

function filterBlogPosts() {
    const search = document.querySelector('[data-blog-search]')?.value.trim().toLocaleLowerCase('es') ?? '';
    const category = document.querySelector('[data-blog-filter].is-selected')?.dataset.blogFilter ?? 'todos';
    const cards = [...document.querySelectorAll('[data-blog-card]')];
    let visibleCount = 0;

    cards.forEach((card) => {
        const matchesCategory = category === 'todos' || card.dataset.category === category;
        const matchesSearch = !search || card.dataset.search.includes(search);
        card.hidden = !matchesCategory || !matchesSearch;
        if (!card.hidden) visibleCount += 1;
    });

    const emptyMessage = document.querySelector('[data-blog-empty]');
    if (emptyMessage) emptyMessage.hidden = visibleCount > 0;
}

menuToggle?.addEventListener('click', () => {
    const isOpen = mainNav.classList.toggle('is-open');
    menuToggle.setAttribute('aria-expanded', String(isOpen));
    menuToggle.setAttribute('aria-label', isOpen ? 'Cerrar menú' : 'Abrir menú');
});

document.querySelectorAll('.dialog-close').forEach((btn) => {
    btn.addEventListener('click', () => {
        const parentDialog = btn.closest('dialog');
        parentDialog?.close();
    });
});
document.querySelectorAll('dialog').forEach((d) => {
    d.addEventListener('click', (event) => {
        if (event.target === d) d.close();
    });
});

document.addEventListener('submit', (event) => {
    const form = event.target.closest('[data-confirm]');

    if (form && !window.confirm(form.dataset.confirm)) {
        event.preventDefault();
        return;
    }

    if (event.target.matches('[data-quiz-answer-form]')) {
        event.preventDefault();
        submitCarlaQuizAnswer(event.target);
        return;
    }

    if (event.target.matches('[data-quiz-create]')) {
        event.preventDefault();
        createCarlaQuizQuestion(event.target);
    }
});

function quizCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

async function quizRequest(url, method = 'POST', data = {}) {
    const response = await fetch(url, {
        method,
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': quizCsrfToken(),
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: method === 'GET' ? undefined : JSON.stringify(data),
    });
    const payload = await response.json().catch(() => ({}));

    if (!response.ok) {
        const validationMessage = Object.values(payload.errors ?? {}).flat()[0];
        throw new Error(validationMessage ?? payload.message ?? 'No se pudo completar la operación. Inténtalo de nuevo.');
    }

    return payload;
}

async function startCarlaQuiz() {
    const intro = document.querySelector('[data-quiz-intro]');
    const play = document.querySelector('[data-quiz-play]');
    const result = document.querySelector('[data-quiz-result]');
    const reward = document.querySelector('[data-quiz-reward]');
    const restart = document.querySelector('.quiz-restart');
    if (!intro || quizBusy) return;

    quizBusy = true;
    document.querySelectorAll('[data-quiz-start]').forEach((button) => { button.disabled = true; });
    result.hidden = true;
    reward.hidden = true;
    play.hidden = true;
    restart.hidden = true;

    try {
        const game = await quizRequest('/games/conociendo-a-carla/start');
        quizToken = game.game_token;
        showCarlaQuizQuestion(game.question, game.completed, game.total);
        intro.hidden = true;
        play.hidden = false;
    } catch (error) {
        intro.hidden = false;
        result.textContent = error.message;
        result.classList.remove('is-success');
        result.hidden = false;
    } finally {
        quizBusy = false;
        document.querySelectorAll('[data-quiz-start]').forEach((button) => { button.disabled = false; });
    }
}

function showCarlaQuizQuestion(question, completed, total) {
    quizQuestionId = question.id;
    document.querySelector('[data-quiz-question]').textContent = question.question;
    document.querySelector('[data-quiz-progress-label]').textContent = `Pregunta ${completed + 1} de ${total}`;
    document.querySelector('[data-quiz-progress]').value = completed;
    const input = document.querySelector('#quiz-answer');
    input.value = '';
    input.focus();
}

async function submitCarlaQuizAnswer(form) {
    if (quizBusy || !quizToken || !quizQuestionId) return;

    const answer = new FormData(form).get('answer')?.toString().trim();
    if (!answer) return;

    const button = form.querySelector('button[type="submit"]');
    const result = document.querySelector('[data-quiz-result]');
    quizBusy = true;
    button.disabled = true;
    result.hidden = true;

    try {
        const outcome = await quizRequest('/games/conociendo-a-carla/answer', 'POST', {
            game_token: quizToken,
            question_id: quizQuestionId,
            answer,
        });

        if (outcome.status === 'failed') {
            document.querySelector('[data-quiz-play]').hidden = true;
            result.textContent = outcome.message;
            result.classList.remove('is-success');
            result.hidden = false;
            document.querySelector('.quiz-restart').hidden = false;
            return;
        }

        if (outcome.status === 'passed') {
            document.querySelector('[data-quiz-play]').hidden = true;
            result.textContent = outcome.message;
            result.classList.add('is-success');
            result.hidden = false;
            const image = document.querySelector('[data-quiz-reward-image]');
            image.src = outcome.reward_url;
            document.querySelector('[data-quiz-reward]').hidden = false;
            document.querySelector('.quiz-restart').hidden = false;
            return;
        }

        showCarlaQuizQuestion(outcome.question, outcome.completed, 10);
    } catch (error) {
        result.textContent = error.message;
        result.classList.remove('is-success');
        result.hidden = false;
    } finally {
        quizBusy = false;
        button.disabled = false;
    }
}

async function createCarlaQuizQuestion(form) {
    const data = new FormData(form);
    const button = form.querySelector('button[type="submit"]');
    const feedback = document.querySelector('[data-quiz-admin-feedback]');
    button.disabled = true;

    try {
        await quizRequest('/games/conociendo-a-carla/questions', 'POST', {
            question: data.get('question'),
            answer_variants: String(data.get('answer_variants') ?? '').split(/\r?\n/).map((answer) => answer.trim()).filter(Boolean),
            is_active: data.has('is_active'),
        });
        form.reset();
        form.querySelector('[name="is_active"]').checked = true;
        feedback.textContent = 'Pregunta guardada. El panel se actualizará.';
        window.location.reload();
    } catch (error) {
        feedback.textContent = error.message;
    } finally {
        button.disabled = false;
    }
}

async function saveCarlaQuizQuestion(card) {
    if (!card) return;

    const feedback = document.querySelector('[data-quiz-admin-feedback]');
    const button = card.querySelector('[data-quiz-save]');
    const variantsText = card.querySelector('[data-answer-variants]').value;
    const payload = {
        question: card.querySelector('[data-question-text]').value,
        is_active: card.querySelector('[data-question-active]').checked,
    };
    if (variantsText.trim()) {
        payload.answer_variants = variantsText.split(/\r?\n/).map((answer) => answer.trim()).filter(Boolean);
    }

    button.disabled = true;
    try {
        const result = await quizRequest(`/games/conociendo-a-carla/questions/${card.dataset.questionId}`, 'PUT', payload);
        card.querySelector('[data-answer-variants]').value = '';
        card.querySelector('[data-question-text]').value = result.question.question;
        card.querySelector('[data-question-active]').checked = result.question.is_active;
        card.querySelector('label[for^="quiz-answers-"] span').textContent = `(${result.question.variants_count} guardadas; deja vacío para conservarlas)`;
        feedback.textContent = result.message;
        updateQuizQuestionCounts(card.dataset.wasActive === 'true', result.question.is_active);
        card.dataset.wasActive = String(result.question.is_active);
    } catch (error) {
        feedback.textContent = error.message;
    } finally {
        button.disabled = false;
    }
}

async function deleteCarlaQuizQuestion(card) {
    if (!card) return;

    const feedback = document.querySelector('[data-quiz-admin-feedback]');
    try {
        const result = await quizRequest(`/games/conociendo-a-carla/questions/${card.dataset.questionId}`, 'DELETE');
        const wasActive = card.dataset.wasActive === 'true';
        card.remove();
        updateQuizQuestionCounts(wasActive, false);
        feedback.textContent = result.message;
    } catch (error) {
        feedback.textContent = error.message;
    }
}

function updateQuizQuestionCounts(wasActive, isActive) {
    const count = document.querySelector('[data-quiz-active-count]');
    const label = document.querySelector('[data-quiz-admin-count]');
    if (!count || !label) return;

    const activeCount = Math.max(0, Number(count.textContent) - Number(wasActive) + Number(isActive));
    count.textContent = String(activeCount);
    label.textContent = `${activeCount} activas · se necesitan 10 para jugar`;
}

function shuffle(items) {
    const shuffled = [...items];

    for (let index = shuffled.length - 1; index > 0; index -= 1) {
        const swapIndex = Math.floor(Math.random() * (index + 1));
        [shuffled[index], shuffled[swapIndex]] = [shuffled[swapIndex], shuffled[index]];
    }

    return shuffled;
}

function startMemoryGame() {
    if (!document.querySelector('.memory-board')) return;

    window.clearTimeout(memoryTimer);
    memoryCards = shuffle([...memorySymbols, ...memorySymbols].map((symbol, index) => ({
        id: index,
        symbol,
        matched: false,
        revealed: false,
    })));
    memorySelection = [];
    memoryMoves = 0;
    memoryPairs = 0;
    memoryLocked = false;
    document.querySelector('[data-memory-moves]').textContent = '0';
    document.querySelector('[data-memory-pairs]').textContent = '0 / 6';
    document.querySelector('[data-memory-message]').textContent = 'Elige dos cartas para encontrar una pareja.';
    renderMemoryBoard();
}

function flowerPositionsAreAdjacent(first, second) {
    const sameRow = Math.floor(first / 3) === Math.floor(second / 3);
    const sameColumn = first % 3 === second % 3;
    return (sameRow && Math.abs(first - second) === 1)
        || (sameColumn && Math.abs(first - second) === 3);
}

function startFlowerPuzzle() {
    const board = document.querySelector('[data-flower-board]');
    if (!board) return;

    flowerTiles = [0, 1, 2, 3, 4, 5, 6, 7, 8];
    flowerMoves = 0;
    let blankPosition = flowerTiles.indexOf(8);
    let previousBlank = -1;

    for (let move = 0; move < 48; move += 1) {
        const candidates = flowerTiles
            .map((_, position) => position)
            .filter((position) => position !== blankPosition
                && position !== previousBlank
                && flowerPositionsAreAdjacent(position, blankPosition));
        const nextBlank = candidates[Math.floor(Math.random() * candidates.length)];
        [flowerTiles[blankPosition], flowerTiles[nextBlank]] = [flowerTiles[nextBlank], flowerTiles[blankPosition]];
        previousBlank = blankPosition;
        blankPosition = nextBlank;
    }

    if (flowerTiles.every((piece, position) => piece === position)) {
        const neighbor = flowerPositionsAreAdjacent(blankPosition, blankPosition % 3 === 2 ? blankPosition - 1 : blankPosition + 1)
            ? (blankPosition % 3 === 2 ? blankPosition - 1 : blankPosition + 1)
            : blankPosition - 3;
        [flowerTiles[blankPosition], flowerTiles[neighbor]] = [flowerTiles[neighbor], flowerTiles[blankPosition]];
    }

    document.querySelector('[data-flower-moves]').textContent = '0';
    document.querySelector('[data-flower-message]').textContent = 'Pulsa una pieza junto al espacio vacío para moverla.';
    renderFlowerPuzzle();
}

function startKindnessBingo() {
    const board = document.querySelector('[data-kindness-bingo-board]');
    if (!board) return;

    const ideas = shuffle(kindnessBingoIdeas).slice(0, 8);
    kindnessBingoTiles = [...ideas.slice(0, 4), null, ...ideas.slice(4)]
        .map((idea, index) => ({ idea, marked: index === 4 }));
    renderKindnessBingo();
}

function startSceneGuessGame() {
    if (!document.querySelector('[data-scene-guess-game]')) return;

    sceneRounds = shuffle(sceneGuessCards);
    sceneRoundIndex = 0;
    sceneRoundSolved = false;
    renderSceneGuessRound();
}

function renderSceneGuessRound() {
    const game = document.querySelector('[data-scene-guess-game]');
    if (!game) return;

    const round = sceneRounds[sceneRoundIndex];
    const progress = game.querySelector('[data-scene-progress]');
    const illustration = game.querySelector('[data-scene-illustration]');
    const prompt = game.querySelector('[data-scene-prompt]');
    const options = game.querySelector('[data-scene-options]');
    const feedback = game.querySelector('[data-scene-feedback]');
    const next = game.querySelector('[data-scene-next]');
    const restart = game.querySelector('[data-scene-restart]');

    if (!round) {
        progress.textContent = 'CUATRO ESCENAS COMPLETADAS';
        illustration.hidden = true;
        prompt.textContent = '¡Qué mirada tan atenta!';
        options.replaceChildren();
        feedback.textContent = 'Has recorrido todas las escenas. No guardamos tus respuestas; puedes volver a jugar cuando quieras.';
        next.hidden = true;
        restart.hidden = false;
        return;
    }

    sceneRoundSolved = false;
    progress.textContent = `ESCENA ${String(sceneRoundIndex + 1).padStart(2, '0')} DE ${sceneRounds.length}`;
    illustration.hidden = false;
    illustration.setAttribute('aria-label', round.description);
    illustration.replaceChildren(...round.symbols.map((symbol) => {
        const item = document.createElement('span');
        item.setAttribute('aria-hidden', 'true');
        item.textContent = symbol;
        return item;
    }));
    prompt.textContent = '¿Qué pequeño momento representan estos detalles?';
    options.replaceChildren(...shuffle(round.choices).map((choice) => {
        const button = document.createElement('button');
        button.className = 'button button-outline';
        button.type = 'button';
        button.dataset.sceneChoice = '';
        button.dataset.sceneCorrect = String(choice.correct);
        button.textContent = choice.label;
        return button;
    }));
    feedback.textContent = 'Elige la opción que te sugieren los detalles.';
    next.hidden = true;
    next.textContent = 'Continuar →';
    restart.hidden = true;
}

function chooseSceneGuess(button) {
    if (sceneRoundSolved || !sceneRounds[sceneRoundIndex]) return;

    if (button.dataset.sceneCorrect !== 'true') {
        button.classList.add('is-selected');
        button.disabled = true;
        document.querySelector('[data-scene-feedback]').textContent = 'No era esa escena. Puedes probar con otra opción.';
        return;
    }

    sceneRoundSolved = true;
    button.classList.add('is-selected');
    document.querySelectorAll('[data-scene-choice]').forEach((option) => { option.disabled = true; });
    document.querySelector('[data-scene-feedback]').textContent = '¡Exacto! Has leído muy bien los detalles de la escena.';
    const next = document.querySelector('[data-scene-next]');
    next.hidden = false;
    next.textContent = sceneRoundIndex === sceneRounds.length - 1 ? 'Terminar →' : 'Continuar →';
}

function kindnessBingoHasLine() {
    const lines = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],
        [0, 3, 6], [1, 4, 7], [2, 5, 8],
        [0, 4, 8], [2, 4, 6],
    ];

    return lines.some((line) => line.every((index) => kindnessBingoTiles[index]?.marked));
}

function renderKindnessBingo() {
    const board = document.querySelector('[data-kindness-bingo-board]');
    if (!board || kindnessBingoTiles.length !== 9) return;

    const markedCount = kindnessBingoTiles.filter((tile, index) => index !== 4 && tile.marked).length;
    const hasBingo = kindnessBingoHasLine();
    document.querySelector('[data-kindness-bingo-count]').textContent = `${markedCount} de 8 momentos marcados`;
    document.querySelector('[data-kindness-bingo-message]').textContent = hasBingo
        ? '¡Bingo amable! Has creado un pequeño momento para ti. Puedes seguir jugando o cambiar una marca.'
        : 'Elige una idea pequeña que te siente bien.';
    board.replaceChildren(...kindnessBingoTiles.map((tile, index) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = `kindness-bingo-tile${tile.marked ? ' is-marked' : ''}${index === 4 ? ' is-free' : ''}`;
        button.dataset.kindnessBingoTile = String(index);
        button.setAttribute('aria-pressed', String(tile.marked));
        button.textContent = index === 4 ? 'Casilla libre · un respiro para ti' : tile.idea;
        if (tile.marked) {
            const check = document.createElement('span');
            check.className = 'kindness-bingo-check';
            check.setAttribute('aria-hidden', 'true');
            check.textContent = '✓';
            button.append(check);
        }
        return button;
    }));
}

function toggleKindnessBingoTile(index) {
    const tile = kindnessBingoTiles[index];
    if (!tile || index === 4) return;

    tile.marked = !tile.marked;
    renderKindnessBingo();
}

function renderFlowerPuzzle() {
    const board = document.querySelector('[data-flower-board]');
    if (!board) return;

    const blankPosition = flowerTiles.indexOf(8);
    const isSolved = flowerTiles.every((piece, position) => piece === position);
    board.replaceChildren(...flowerTiles.map((piece, position) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'flower-piece';
        button.dataset.flowerPosition = String(position);
        button.dataset.flowerPiece = String(piece);

        if (piece === 8) {
            button.classList.add('is-empty');
            button.disabled = true;
            button.setAttribute('aria-label', 'Espacio vacío');
            button.setAttribute('aria-hidden', 'true');
            return button;
        }

        const canMove = flowerPositionsAreAdjacent(position, blankPosition);
        button.classList.toggle('is-movable', canMove);
        button.disabled = isSolved;
        button.setAttribute('aria-label', canMove ? `Pieza floral ${piece + 1}, mover al espacio vacío` : `Pieza floral ${piece + 1}, no está junto al espacio vacío`);
        button.style.backgroundPosition = `${(piece % 3) * 50}% ${Math.floor(piece / 3) * 50}%`;
        return button;
    }));

    if (isSolved) {
        board.querySelectorAll('button').forEach((button) => { button.disabled = true; });
        document.querySelector('[data-flower-message]').textContent = `¡Completaste el jardín floral en ${flowerMoves} movimientos!`;
        board.setAttribute('aria-label', 'Rompecabezas floral completado.');
    } else {
        board.setAttribute('aria-label', 'Rompecabezas floral de ocho piezas. Puedes usar las flechas del teclado cuando una pieza tenga el foco.');
    }
}

function slideFlowerTile(position) {
    const blankPosition = flowerTiles.indexOf(8);
    if (!flowerPositionsAreAdjacent(position, blankPosition)) {
        document.querySelector('[data-flower-message]').textContent = 'Esa pieza no está junto al espacio vacío. Prueba con una pieza marcada.';
        return;
    }

    [flowerTiles[position], flowerTiles[blankPosition]] = [flowerTiles[blankPosition], flowerTiles[position]];
    flowerMoves += 1;
    document.querySelector('[data-flower-moves]').textContent = String(flowerMoves);
    renderFlowerPuzzle();
}

function startPreferenceGame() {
    if (!document.querySelector('[data-preference-game]')) return;

    preferenceRounds = shuffle(preferencePrompts);
    preferenceRoundIndex = 0;
    renderPreferenceRound();
}

function renderPreferenceRound() {
    const game = document.querySelector('[data-preference-game]');
    if (!game) return;

    const round = preferenceRounds[preferenceRoundIndex];
    const progress = game.querySelector('[data-preference-progress]');
    const prompt = game.querySelector('[data-preference-prompt]');
    const options = game.querySelector('[data-preference-options]');
    const feedback = game.querySelector('[data-preference-feedback]');
    const next = game.querySelector('[data-preference-next]');
    const restart = game.querySelector('[data-preference-restart]');

    if (!round) {
        progress.textContent = 'CINCO ELECCIONES COMPLETADAS';
        prompt.textContent = 'Gracias por compartir este pequeño momento.';
        options.hidden = true;
        feedback.textContent = 'No guardamos tus elecciones. Puedes volver a jugar cuando quieras.';
        next.hidden = true;
        restart.hidden = false;
        return;
    }

    progress.textContent = `RONDA ${String(preferenceRoundIndex + 1).padStart(2, '0')} DE ${preferenceRounds.length}`;
    prompt.textContent = round.prompt;
    options.hidden = false;
    options.replaceChildren(...round.options.map((option, index) => {
        const button = document.createElement('button');
        button.className = 'button button-outline';
        button.type = 'button';
        button.dataset.preferenceChoice = String(index);
        button.setAttribute('aria-pressed', 'false');
        button.textContent = option;
        return button;
    }));
    feedback.textContent = 'No hay respuestas correctas: elige la opción que te haga sonreír.';
    next.hidden = true;
    next.textContent = preferenceRoundIndex === preferenceRounds.length - 1 ? 'Terminar →' : 'Continuar →';
    restart.hidden = true;
}

function choosePreference(choiceIndex) {
    const game = document.querySelector('[data-preference-game]');
    const round = preferenceRounds[preferenceRoundIndex];
    if (!game || !round?.options[choiceIndex]) return;

    game.querySelectorAll('[data-preference-choice]').forEach((button, index) => {
        const selected = index === choiceIndex;
        button.classList.toggle('is-selected', selected);
        button.setAttribute('aria-pressed', String(selected));
    });
    game.querySelector('[data-preference-feedback]').textContent = 'Una elección encantadora. Cuando quieras, seguimos.';
    game.querySelector('[data-preference-next]').hidden = false;
}

function renderMemoryBoard() {
    const board = document.querySelector('.memory-board');
    if (!board) return;

    board.replaceChildren(...memoryCards.map((card) => {
        const button = document.createElement('button');
        const isShowing = card.revealed || card.matched;
        button.className = `memory-card${isShowing ? ' is-revealed' : ''}${card.matched ? ' is-matched' : ''}`;
        button.type = 'button';
        button.dataset.memoryCard = String(card.id);
        button.setAttribute('aria-label', isShowing ? `Carta ${card.symbol}${card.matched ? ', pareja encontrada' : ''}` : 'Carta oculta');
        button.setAttribute('aria-pressed', String(isShowing));
        button.disabled = card.matched;

        const symbol = document.createElement('span');
        symbol.setAttribute('aria-hidden', 'true');
        symbol.textContent = isShowing ? card.symbol : '✳';
        button.append(symbol);
        return button;
    }));
}

function revealMemoryCard(button) {
    const card = memoryCards.find((item) => item.id === Number(button.dataset.memoryCard));
    if (!card || memoryLocked || card.revealed || card.matched) return;

    card.revealed = true;
    memorySelection.push(card);
    renderMemoryBoard();

    if (memorySelection.length < 2) return;

    memoryMoves += 1;
    document.querySelector('[data-memory-moves]').textContent = String(memoryMoves);
    const [firstCard, secondCard] = memorySelection;

    if (firstCard.symbol === secondCard.symbol) {
        firstCard.matched = true;
        secondCard.matched = true;
        memorySelection = [];
        memoryPairs += 1;
        document.querySelector('[data-memory-pairs]').textContent = `${memoryPairs} / ${memorySymbols.length}`;
        const message = memoryPairs === memorySymbols.length
            ? `¡Encontraste las seis parejas en ${memoryMoves} intentos!`
            : '¡Encontraste una pareja! Sigue cuando quieras.';
        document.querySelector('[data-memory-message]').textContent = message;
        renderMemoryBoard();
        return;
    }

    memoryLocked = true;
    document.querySelector('[data-memory-message]').textContent = 'No son pareja. Prueba con otras dos cartas.';
    memoryTimer = window.setTimeout(() => {
        firstCard.revealed = false;
        secondCard.revealed = false;
        memorySelection = [];
        memoryLocked = false;
        renderMemoryBoard();
    }, 850);
}

function renderStory(nodeName) {
    const node = storyNodes[nodeName];
    if (!node || !document.querySelector('[data-story-card]')) return;

    document.querySelector('[data-story-chapter]').textContent = node.chapter;
    document.querySelector('[data-story-text]').textContent = node.text;
    document.querySelector('[data-story-detail]').textContent = node.detail;
    const choices = document.querySelector('[data-story-choices]');
    choices.replaceChildren(...node.choices.map((choice) => {
        const button = document.createElement('button');
        button.className = `button ${choice.restart ? 'button-outline' : 'button-primary'}`;
        button.type = 'button';
        button.dataset.storyChoice = choice.next;
        button.textContent = choice.label;
        return button;
    }));
}

function startTreasure() {
    const game = document.querySelector('[data-treasure-game]');
    if (!game) return;
    game.dataset.step = '0';
    game.dataset.complete = 'false';
    renderTreasureStep(0);
}

function renderTreasureStep(stepIndex) {
    const game = document.querySelector('[data-treasure-game]');
    const step = treasureSteps[stepIndex];
    const complete = !step;
    game.dataset.complete = String(complete);
    game.querySelector('[data-treasure-step]').textContent = complete
        ? 'AVENTURA COMPLETADA'
        : `PISTA ${String(stepIndex + 1).padStart(2, '0')} DE ${String(treasureSteps.length).padStart(2, '0')}`;
    game.querySelector('[data-treasure-progress]').style.width = `${(stepIndex / treasureSteps.length) * 100}%`;
    game.querySelector('[data-treasure-clue]').textContent = complete
        ? '¡Encontraste el tesoro!'
        : step.clue;
    game.querySelector('[data-treasure-feedback]').textContent = complete
        ? 'El tesoro era el placer de descubrir rincones nuevos. Puedes volver a jugar cuando quieras.'
        : step.feedback;
    game.querySelector('[data-treasure-options]').replaceChildren(...(step?.choices ?? []).map((choice, index) => {
        const button = document.createElement('button');
        button.className = 'button button-outline treasure-choice';
        button.type = 'button';
        button.dataset.treasureChoice = String(index);
        button.textContent = choice;
        return button;
    }));
    game.querySelector('.treasure-restart').hidden = !complete;
}

function chooseTreasureAnswer(answer) {
    const game = document.querySelector('[data-treasure-game]');
    const stepIndex = Number(game.dataset.step);
    const step = treasureSteps[stepIndex];
    if (!step) return;

    if (answer !== step.answer) {
        game.querySelector('[data-treasure-feedback]').textContent = 'Esa no era la pista. Prueba otra vez: no hay prisa.';
        return;
    }

    const nextStep = stepIndex + 1;
    game.dataset.step = String(nextStep);
    renderTreasureStep(nextStep);
}

window.addEventListener('popstate', () => showScreen(window.location.hash.slice(1), false));
window.addEventListener('hashchange', () => showScreen(window.location.hash.slice(1), false));

const initialScreen = window.location.hash.slice(1)
    || (document.querySelector('[data-screen="albumes"] [role="alert"]') ? 'albumes' : 'inicio');

showScreen(initialScreen, false);

// ── Activar audio tras el primer gesto del usuario ─────────────────────────────
(function bootstrapAudio() {
    const EVENTS = ['pointerdown', 'keydown', 'touchstart'];
    function onFirstGesture() {
        enableAudio();
        EVENTS.forEach((e) => document.removeEventListener(e, onFirstGesture, { capture: true }));
    }
    EVENTS.forEach((e) => document.addEventListener(e, onFirstGesture, { capture: true, once: false }));

    // Botón flotante de música
    let btn = document.getElementById('music-toggle-btn');
    if (!btn) {
        btn = document.createElement('button');
        btn.id = 'music-toggle-btn';
        btn.className = 'music-toggle-btn';
        btn.type = 'button';
        btn.setAttribute('aria-label', 'Activar música de fondo');
        btn.setAttribute('title', 'Música de fondo');
        btn.setAttribute('aria-pressed', 'false');
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
        </svg>`;
        const dock = document.getElementById('floating-dock-right');
        if (dock) {
            dock.appendChild(btn);
        } else {
            document.body.appendChild(btn);
        }
    }
    btn.addEventListener('click', () => {
        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) {
            window.GardenMasterAudio.unmuteAll(false);
        }
        enableAudio();
        const playing = toggleMusic();
        btn.setAttribute('aria-pressed', String(playing));
        btn.classList.toggle('is-playing', playing);
        btn.setAttribute('aria-label', playing ? 'Pausar música' : 'Reanudar música');
    });

    // Inicializar el Botón Flotante Maestro de Apagado General de Sonido
    initMasterAudioController();
})();
startMemoryGame();
startFlowerPuzzle();
startKindnessBingo();
startSceneGuessGame();
startPreferenceGame();
renderStory('inicio');
startTreasure();
updateSultanaCardStatus();
loadSultanaProgress();
renderSultanaAdventure();
initBotanicalGarden();

/* --- Santuario Botánico de Carla Lorena: Lógica Interactiva y Pétalos Flotantes --- */
function initBotanicalGarden() {
    const modal = document.getElementById('flower-modal');
    const closeBtn = modal?.querySelector('.flower-modal-close');
    const saveBtn = modal?.querySelector('.flower-modal-btn');
    const cards = document.querySelectorAll('.flower-card[data-flower-name]');
    
    cards.forEach((card) => {
        const handleOpen = () => {
            if (!modal) return;
            const name = card.dataset.flowerName || 'Flor del Jardín';
            const symbol = card.dataset.flowerSymbol || 'Armonía';
            const dedication = card.dataset.flowerDedication || 'Un detalle especial en este jardín.';
            const icon = card.dataset.flowerIcon || '🌸';
            
            modal.querySelector('#flower-modal-title').textContent = name;
            modal.querySelector('#flower-modal-symbol').textContent = symbol;
            modal.querySelector('#flower-modal-dedication').textContent = dedication;
            modal.querySelector('.flower-modal-icon').textContent = icon;
            
            modal.showModal();
        };

        card.addEventListener('click', handleOpen);
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                handleOpen();
            }
        });
    });

    closeBtn?.addEventListener('click', () => modal.close());
    saveBtn?.addEventListener('click', () => {
        modal.close();
        showToast('Guardado en el corazón de este jardín ✿');
    });

    modal?.addEventListener('click', (e) => {
        if (e.target === modal) modal.close();
    });

    // Control de ambientación sonora con Web Audio API (suave, sin archivos pesados)
    let audioCtx = null;
    let ambientNodes = {};

    function toggleAmbientSound(type, btn) {
        if (!audioCtx) {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        if (audioCtx.state === 'suspended') {
            audioCtx.resume();
        }

        const isPressed = btn.getAttribute('aria-pressed') === 'true';
        if (isPressed) {
            btn.setAttribute('aria-pressed', 'false');
            if (ambientNodes[type]) {
                ambientNodes[type].gain?.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + 0.8);
                setTimeout(() => {
                    ambientNodes[type].source?.stop();
                    delete ambientNodes[type];
                }, 900);
            }
        } else {
            btn.setAttribute('aria-pressed', 'true');
            // Generar síntesis suave de sonido blanco filtrado tipo brisa
            if (type === 'breeze') {
                const bufferSize = audioCtx.sampleRate * 2;
                const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
                const data = buffer.getChannelData(0);
                for (let i = 0; i < bufferSize; i++) {
                    data[i] = (Math.random() * 2 - 1) * 0.15;
                }
                const whiteNoise = audioCtx.createBufferSource();
                whiteNoise.buffer = buffer;
                whiteNoise.loop = true;

                const filter = audioCtx.createBiquadFilter();
                filter.type = 'lowpass';
                filter.frequency.setValueAtTime(320, audioCtx.currentTime);

                const gainNode = audioCtx.createGain();
                gainNode.gain.setValueAtTime(0.0001, audioCtx.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.12, audioCtx.currentTime + 1.2);

                whiteNoise.connect(filter);
                filter.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                whiteNoise.start();

                ambientNodes[type] = { source: whiteNoise, gain: gainNode };
                showToast('🍃 Susurro de brisa suave activado');
            } else if (type === 'birds') {
                showToast('🕊️ Armonía y trinos serenos activados');
            }
        }
    }

    const ambientButtons = document.querySelectorAll('[data-garden-ambient]');
    ambientButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const type = btn.dataset.gardenAmbient;
            if (type === 'petals') {
                const isPressed = btn.getAttribute('aria-pressed') === 'true';
                btn.setAttribute('aria-pressed', isPressed ? 'false' : 'true');
                togglePetalsAnimation(!isPressed);
            } else {
                toggleAmbientSound(type, btn);
            }
        });
    });

    window._stopAppAmbientSounds = function() {
        Object.keys(ambientNodes).forEach((type) => {
            try {
                if (audioCtx) {
                    ambientNodes[type]?.gain?.gain.setValueAtTime(0.0001, audioCtx.currentTime);
                }
                ambientNodes[type]?.source?.stop();
            } catch (_) {}
            delete ambientNodes[type];
        });
        ambientButtons.forEach(btn => {
            if (btn.dataset.gardenAmbient !== 'petals') {
                btn.setAttribute('aria-pressed', 'false');
            }
        });
        if (audioCtx && audioCtx.state === 'running') {
            try { audioCtx.suspend(); } catch (_) {}
        }
    };

    // Animación suave de lluvia de pétalos en Canvas
    const canvas = document.getElementById('garden-petals-canvas');
    let petalsActive = true;
    let petalsAnimationId = null;

    function togglePetalsAnimation(active) {
        petalsActive = active;
        if (!canvas) return;
        canvas.style.display = active ? 'block' : 'none';
        if (active && !petalsAnimationId) {
            runPetals();
        }
    }

    function runPetals() {
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        const flowerTypes = [
            { type: 'rose', color: 'rgba(244, 114, 182, ', ratio: 0.65 },
            { type: 'sunflower', color: 'rgba(251, 191, 36, ', ratio: 0.45 },
            { type: 'tulip', color: 'rgba(236, 72, 153, ', ratio: 0.55 },
            { type: 'lavender', color: 'rgba(192, 132, 252, ', ratio: 0.4 },
            { type: 'peony', color: 'rgba(254, 205, 211, ', ratio: 0.7 }
        ];

        const petals = Array.from({ length: 36 }, () => {
            const flower = flowerTypes[Math.floor(Math.random() * flowerTypes.length)];
            return {
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                size: 7 + Math.random() * 9,
                speedY: 0.5 + Math.random() * 0.9,
                speedX: -0.4 + Math.random() * 0.8,
                angle: Math.random() * 360,
                spin: (Math.random() - 0.5) * 1.8,
                opacity: 0.35 + Math.random() * 0.45,
                color: flower.color,
                ratio: flower.ratio
            };
        });

        function loop() {
            if (!petalsActive) {
                petalsAnimationId = null;
                return;
            }
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const gardenScreen = document.querySelector('[data-screen="jardin"]');
            const isGardenVisible = gardenScreen && !gardenScreen.hidden;

            if (isGardenVisible) {
                petals.forEach((p) => {
                    p.y += p.speedY;
                    p.x += Math.sin(p.angle * Math.PI / 180) * 0.6 + p.speedX;
                    p.angle += p.spin;

                    if (p.y > canvas.height + 25) {
                        p.y = -25;
                        p.x = Math.random() * canvas.width;
                    }

                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.angle * Math.PI / 180);
                    ctx.fillStyle = `${p.color}${p.opacity})`;
                    ctx.beginPath();
                    // Forma orgánica de pétalo asimétrico suave
                    ctx.ellipse(0, 0, p.size, p.size * p.ratio, Math.PI / 12, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.restore();
                });
            }

            petalsAnimationId = requestAnimationFrame(loop);
        }
        loop();
    }

    runPetals();
    initReadingNook();
    initRomanticFeatures();
}

/* --- Funciones Románticas Avanzadas UI/UX --- */
function initRomanticFeatures() {
    // 1. Cartas con sello de lacre digital
    const letterCards = document.querySelectorAll('.wax-letter-card');
    letterCards.forEach((card) => {
        const sealBtn = card.querySelector('.wax-seal-btn');
        const toggleLetter = () => {
            const isOpen = card.classList.contains('is-open');
            card.classList.toggle('is-open');
            if (!isOpen) {
                showToast('✨ Sello de lacre abierto con cariño');
                // Efecto sonoro sutil de apertura
                playSoftChime(523.25);
            }
        };

        sealBtn?.addEventListener('click', toggleLetter);
        sealBtn?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleLetter();
            }
        });
    });

    // 2. Tooltips poéticos para las islas del mapa
    const mapIslands = document.querySelectorAll('.floral-island[data-tooltip]');
    const tooltip = document.getElementById('map-island-tooltip');

    mapIslands.forEach((island) => {
        island.addEventListener('mouseenter', (e) => {
            if (!tooltip) return;
            tooltip.textContent = island.dataset.tooltip || '';
            tooltip.hidden = false;
            tooltip.style.opacity = '1';
            positionTooltip(e);
        });

        island.addEventListener('mousemove', (e) => {
            positionTooltip(e);
        });

        island.addEventListener('mouseleave', () => {
            if (!tooltip) return;
            tooltip.style.opacity = '0';
            setTimeout(() => { tooltip.hidden = true; }, 200);
        });
    });

    function positionTooltip(e) {
        if (!tooltip || tooltip.hidden) return;
        tooltip.style.left = `${e.clientX}px`;
        tooltip.style.top = `${e.clientY - 12}px`;
    }

    // 3. Estela mágica de pétalos y destellos dorados con el cursor
    const cursorCanvas = document.getElementById('romantic-magic-cursor');
    if (!cursorCanvas) return;
    const ctx = cursorCanvas.getContext('2d');
    if (!ctx) return;

    let particles = [];
    function resizeCursorCanvas() {
        cursorCanvas.width = window.innerWidth;
        cursorCanvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resizeCursorCanvas);
    resizeCursorCanvas();

    function addCursorParticle(x, y) {
        // Generar 2 partículas (un pétalo y un destello dorado)
        particles.push({
            x: x + (Math.random() - 0.5) * 8,
            y: y + (Math.random() - 0.5) * 8,
            size: 3 + Math.random() * 4,
            speedX: (Math.random() - 0.5) * 1.2,
            speedY: (Math.random() - 0.5) * 1.2 - 0.5,
            opacity: 1,
            color: Math.random() > 0.4 ? 'rgba(235, 160, 175,' : 'rgba(240, 205, 170,',
            angle: Math.random() * 360,
            spin: (Math.random() - 0.5) * 4
        });
        if (particles.length > 55) {
            particles.shift();
        }
    }

    let lastMove = 0;
    window.addEventListener('pointermove', (e) => {
        const now = performance.now();
        if (now - lastMove > 28) {
            addCursorParticle(e.clientX, e.clientY);
            lastMove = now;
        }
    }, { passive: true });

    function animateCursorParticles() {
        ctx.clearRect(0, 0, cursorCanvas.width, cursorCanvas.height);

        for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];
            p.x += p.speedX;
            p.y += p.speedY;
            p.opacity -= 0.022;
            p.angle += p.spin;

            if (p.opacity <= 0) {
                particles.splice(i, 1);
                continue;
            }

            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.angle * Math.PI / 180);
            ctx.fillStyle = `${p.color} ${p.opacity})`;
            ctx.beginPath();
            ctx.ellipse(0, 0, p.size, p.size * 0.65, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }

        requestAnimationFrame(animateCursorParticles);
    }
    animateCursorParticles();

    function playSoftChime(frequency) {
        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(frequency, audioCtx.currentTime);
            gain.gain.setValueAtTime(0.0001, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.06, audioCtx.currentTime + 0.05);
            gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + 1.2);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 1.3);
        } catch (_) {}
    }
    // 4. Rosa Encantada Interactiva de Carla Lorena
    const roseTrigger = document.getElementById('enchanted-rose-trigger');
    const roseDialog = document.getElementById('enchanted-rose-dialog');
    const roseCloseBtn = roseDialog?.querySelector('.enchanted-close-btn');

    roseTrigger?.addEventListener('click', () => {
        if (!roseDialog) return;
        roseDialog.showModal();
        playSoftChime(659.25); // E5 chord note
        setTimeout(() => playSoftChime(783.99), 180); // G5 note
        showToast('🌹 Has abierto el secreto de la Rosa');
    });

    roseTrigger?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            roseDialog?.showModal();
        }
    });

    roseCloseBtn?.addEventListener('click', () => roseDialog?.close());
    roseDialog?.addEventListener('click', (e) => {
        if (e.target === roseDialog) roseDialog.close();
    });

    // 5. El Árbol de los Deseos y Promesas
    const wishBuds = document.querySelectorAll('.wish-bud-card');
    wishBuds.forEach((bud) => {
        bud.addEventListener('click', () => {
            const msg = bud.querySelector('.bud-unfolded-msg');
            const hint = bud.querySelector('.bud-folded-hint');
            if (msg) {
                const isHidden = msg.hidden;
                msg.hidden = !isHidden;
                if (hint) {
                    hint.textContent = isHidden ? '✦ Abierto con amor' : 'Toca para abrir ✦';
                }
                if (isHidden) {
                    playSoftChime(587.33); // D5 chime
                    showToast('🌸 Deseo florecido para ti');
                }
            }
        });
    });

    // 6. Corazón Central de Carla: Rosa Emblema y Diálogo de Amor
    const heartEmblem = document.querySelector('.luxury-heart-emblem');
    const mapRoseDialog = document.getElementById('map-rose-dialog');
    const closeRoseBtn = document.getElementById('btn-close-map-rose-dialog');
    const roseChimeBtn = document.getElementById('btn-rose-chime');
    const roseCopyBtn = document.getElementById('btn-rose-copy-love');
    const roseTabs = document.querySelectorAll('.map-rose-tab');

    function openMapRoseModal() {
        if (!mapRoseDialog) return;
        playSoftChime(523.25);
        setTimeout(() => playSoftChime(659.25), 140);
        setTimeout(() => playSoftChime(880.00), 280);
        setTimeout(() => playSoftChime(1046.50), 420);

        if (mapRoseDialog instanceof HTMLDialogElement) {
            mapRoseDialog.showModal();
        }
    }

    heartEmblem?.addEventListener('click', () => {
        openMapRoseModal();
    });

    heartEmblem?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            openMapRoseModal();
        }
    });

    closeRoseBtn?.addEventListener('click', () => {
        if (mapRoseDialog instanceof HTMLDialogElement) {
            mapRoseDialog.close();
        }
    });

    mapRoseDialog?.addEventListener('click', (e) => {
        if (e.target === mapRoseDialog && mapRoseDialog instanceof HTMLDialogElement) {
            mapRoseDialog.close();
        }
    });

    // Pestañas: Carta · Poema · Sentimiento
    roseTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabId = tab.dataset.roseTab;
            roseTabs.forEach(t => {
                const isActive = t === tab;
                t.classList.toggle('is-active', isActive);
                t.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            document.querySelectorAll('.map-rose-tab-content').forEach(content => {
                const isCurrent = content.id === `rose-tab-${tabId}`;
                content.classList.toggle('is-active', isCurrent);
                content.hidden = !isCurrent;
            });

            playSoftChime(783.99);
        });
    });

    // Melodía del Corazón
    roseChimeBtn?.addEventListener('click', () => {
        const chordNotes = [523.25, 659.25, 783.99, 1046.50, 1318.51];
        chordNotes.forEach((n, i) => {
            setTimeout(() => playSoftChime(n), i * 160);
        });
        showToast('🎶 Arpegio de amor resonando en el corazón de Carla');
    });

    // Guardar Carta y Poema en Portapapeles
    roseCopyBtn?.addEventListener('click', () => {
        const letterText = `🌹 PARA CARLA LORENA — CARTA DEL CORAZÓN DEL JARDÍN SECRETO\n\n` +
            `«Tú eres la raíz de toda la belleza que aquí respira. No hay rincón en este jardín que no guarde tu ternura, ni flor que no busque emular tu delicadeza. Gracias por ser mi calma en la tormenta, por iluminar mis amaneceres con la nobleza de tu alma y por enseñarme que el amor más grande se cultiva en los pequeños detalles de cada día.»\n\n` +
            `POEMA: DONDE FLORECE TU MIRADA\n` +
            `Dicen que el rosal florece lento,\naguardando el rocío de la mañana,\npero ante la gracia de tu aliento,\ntoda primavera se hace temprana.\n\n` +
            `Eres brisa que calma la fatiga,\npoesía que no necesita rima,\nla melodía dulce que me abriga,\nla más radiante flor sobre la cima.\n\n` +
            `— Con devoción infinita, por y para siempre. ♡`;

        if (navigator.clipboard) {
            navigator.clipboard.writeText(letterText).then(() => {
                showToast('💌 ¡Carta y poema guardados con todo mi amor en tu portapapeles!');
                playSoftChime(880.00);
            }).catch(() => {
                showToast('💌 Carta seleccionada para ti');
            });
        }
    });

    // 7. Chime armónico al posar sobre los medallones del mapa
    const medallions = document.querySelectorAll('.luxury-medallion');
    const medallionNotes = [523.25, 587.33, 659.25, 698.46, 783.99, 880.00, 987.77, 1046.50];
    medallions.forEach((medallion, idx) => {
        medallion.addEventListener('mouseenter', () => {
            const note = medallionNotes[idx % medallionNotes.length];
            playSoftChime(note);
        });
    });

    // 9. Interacción de la pantalla Dedicatoria
    const dedicationSparkBtn = document.getElementById('dedication-spark-btn');
    dedicationSparkBtn?.addEventListener('click', () => {
        playSoftChime(523.25); // C5
        setTimeout(() => playSoftChime(659.25), 150); // E5
        setTimeout(() => playSoftChime(783.99), 300); // G5
        setTimeout(() => playSoftChime(1046.50), 450); // C6
        showToast('🌹 «Cada pétalo florece con un pensamiento de amor para ti, Carla.» ✨');
    });

    // 8. Experiencia sonora para el Poema en Pergamino
    const poetryChimeBtn = document.getElementById('poetry-chime-btn');
    poetryChimeBtn?.addEventListener('click', () => {
        playSoftChime(440.00); // A4
        setTimeout(() => playSoftChime(554.37), 180); // C#5
        setTimeout(() => playSoftChime(659.25), 360); // E5
        setTimeout(() => playSoftChime(880.00), 540); // A5
        showToast('❦ Versos dedicados con todo el cariño para Carla Lorena');
    });
}


/* --- Rincón de Lectura y Música Calma --- */
function initReadingNook() {
    const quotes = [
        { text: "“La belleza comienza en el instante en que decides ser tú misma.”", author: "— Coco Chanel" },
        { text: "“Plantar un jardín es creer en el mañana.”", author: "— Audrey Hepburn" },
        { text: "“La paz viene de adentro. No la busques afuera.”", author: "— Buda" },
        { text: "“Donde florecen las flores, florece la esperanza.”", author: "— Lady Bird Johnson" },
        { text: "“En medio del invierno, aprendí por fin que había en mí un verano invencible.”", author: "— Albert Camus" },
        { text: "“Que la calma te acompañe siempre en cada paso que des, Carla.”", author: "— Dedicado para ti" }
    ];

    let currentQuoteIndex = 0;
    const nextBtn = document.getElementById('next-quote-btn');
    const quoteText = document.getElementById('quote-text');
    const quoteAuthor = document.getElementById('quote-author');

    nextBtn?.addEventListener('click', () => {
        currentQuoteIndex = (currentQuoteIndex + 1) % quotes.length;
        if (quoteText && quoteAuthor) {
            quoteText.style.opacity = '0';
            quoteAuthor.style.opacity = '0';
            setTimeout(() => {
                quoteText.textContent = quotes[currentQuoteIndex].text;
                quoteAuthor.textContent = quotes[currentQuoteIndex].author;
                quoteText.style.opacity = '1';
                quoteAuthor.style.opacity = '1';
            }, 180);
        }
    });

    // Reproductor de acordes pentatónicos relajantes con Web Audio
    const melodyBtn = document.getElementById('relax-melody-btn');
    let melodyAudioCtx = null;
    let melodyInterval = null;
    let isPlaying = false;

    melodyBtn?.addEventListener('click', () => {
        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) {
            window.GardenMasterAudio.unmuteAll(false);
        }
        if (!melodyAudioCtx) {
            melodyAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        if (melodyAudioCtx.state === 'suspended') {
            melodyAudioCtx.resume();
        }

        const icon = melodyBtn.querySelector('.melody-btn-icon');
        const text = melodyBtn.querySelector('.melody-btn-text');

        if (isPlaying) {
            isPlaying = false;
            clearInterval(melodyInterval);
            melodyBtn.setAttribute('aria-pressed', 'false');
            if (icon) icon.textContent = '▶';
            if (text) text.textContent = 'Escuchar sintonía de calma';
            showToast('Música en pausa');
        } else {
            isPlaying = true;
            melodyBtn.setAttribute('aria-pressed', 'true');
            if (icon) icon.textContent = '⏸';
            if (text) text.textContent = 'Pausar melodía serena';
            showToast('♫ Melodía serena del jardín sonando');

            // Frecuencias pentatónicas en Hertz (C Mayor pentatónico cálido: C4, D4, E4, G4, A4, C5)
            const notes = [261.63, 293.66, 329.63, 392.00, 440.00, 523.25];

            function playChime() {
                if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) return;
                if (!isPlaying || !melodyAudioCtx) return;
                const freq = notes[Math.floor(Math.random() * notes.length)];
                const osc = melodyAudioCtx.createOscillator();
                const gain = melodyAudioCtx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, melodyAudioCtx.currentTime);

                gain.gain.setValueAtTime(0.0001, melodyAudioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.08, melodyAudioCtx.currentTime + 0.1);
                gain.gain.exponentialRampToValueAtTime(0.0001, melodyAudioCtx.currentTime + 2.8);

                osc.connect(gain);
                gain.connect(melodyAudioCtx.destination);

                osc.start();
                osc.stop(melodyAudioCtx.currentTime + 3.0);
            }

            playChime();
            melodyInterval = setInterval(playChime, 1800);
        }
    });

    window._stopAppRelaxMelody = function() {
        if (isPlaying) {
            isPlaying = false;
            clearInterval(melodyInterval);
            melodyBtn?.setAttribute('aria-pressed', 'false');
            const icon = melodyBtn?.querySelector('.melody-btn-icon');
            const text = melodyBtn?.querySelector('.melody-btn-text');
            if (icon) icon.textContent = '▶';
            if (text) text.textContent = 'Escuchar sintonía de calma';
            if (melodyAudioCtx && melodyAudioCtx.state === 'running') {
                try { melodyAudioCtx.suspend(); } catch (_) {}
            }
        }
    };
}


/* =========================================================
   🌹 LLUVIA GLOBAL DE PÉTALOS DE ROSA
   ========================================================= */
(function initGlobalRosePetals() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    function start() {
        if (!document.body || document.getElementById('global-rose-petals')) return;
        var gc = document.createElement('canvas');
        gc.id = 'global-rose-petals';
        gc.setAttribute('aria-hidden', 'true');
        gc.style.cssText = 'position:fixed;inset:0;width:100%;height:100%;pointer-events:none;z-index:9999;';
        document.body.appendChild(gc);
        var ctx = gc.getContext('2d');
        function resize() { gc.width = window.innerWidth; gc.height = window.innerHeight; }
        window.addEventListener('resize', resize, { passive: true });
        resize();
    var COLORS = [[255,182,193],[242,155,170],[220,130,150],[255,220,228],[255,200,210],[210,160,175]];
    var TYPES = ['oval','teardrop','round','leaf'];
    var TOTAL = 42;
    function mkPetal() {
        var c = COLORS[Math.floor(Math.random() * COLORS.length)];
        return { x: Math.random()*gc.width, y: -20 - Math.random()*gc.height,
            size: 5+Math.random()*9, speedY: 0.45+Math.random()*0.85,
            speedX: (Math.random()-0.5)*0.4, angle: Math.random()*360,
            spin: (Math.random()-0.5)*1.8, sway: Math.random()*360,
            swayAmp: 0.3+Math.random()*0.7, swaySpd: 0.4+Math.random()*0.6,
            opacity: 0.22+Math.random()*0.38, color: c,
            type: TYPES[Math.floor(Math.random()*TYPES.length)] };
    }
    var petals = [];
    for (var i = 0; i < TOTAL; i++) { var p = mkPetal(); p.y = Math.random()*gc.height; petals.push(p); }
    function drawPetal(p) {
        ctx.save(); ctx.translate(p.x, p.y); ctx.rotate(p.angle * Math.PI / 180);
        ctx.globalAlpha = p.opacity;
        var r = p.color[0], g = p.color[1], b = p.color[2];
        ctx.fillStyle = 'rgb('+r+','+g+','+b+')';
        ctx.beginPath();
        if (p.type === 'oval') { ctx.ellipse(0,0,p.size,p.size*0.55,0,0,Math.PI*2); }
        else if (p.type === 'teardrop') { ctx.moveTo(0,-p.size); ctx.bezierCurveTo(p.size*0.6,-p.size*0.4,p.size*0.6,p.size*0.4,0,p.size*0.6); ctx.bezierCurveTo(-p.size*0.6,p.size*0.4,-p.size*0.6,-p.size*0.4,0,-p.size); }
        else if (p.type === 'round') { ctx.ellipse(0,0,p.size*0.75,p.size*0.75,0,0,Math.PI*2); }
        else { ctx.moveTo(0,-p.size); ctx.quadraticCurveTo(p.size*0.9,0,0,p.size); ctx.quadraticCurveTo(-p.size*0.9,0,0,-p.size); }
        ctx.fill();
        ctx.globalAlpha = p.opacity * 0.18;
        ctx.strokeStyle = 'rgb('+(Math.max(r-40,0))+','+(Math.max(g-40,0))+','+(Math.max(b-40,0))+')';
        ctx.lineWidth = 0.5; ctx.beginPath(); ctx.moveTo(0,-p.size*0.65); ctx.lineTo(0,p.size*0.65); ctx.stroke();
        ctx.restore();
    }
    var rafId, lastTs = 0;
    function loop(ts) {
        var dt = Math.min((ts - lastTs) / 16.67, 3); lastTs = ts;
        ctx.clearRect(0,0,gc.width,gc.height);
        petals.forEach(function(p) {
            p.sway += p.swaySpd * dt; p.y += p.speedY * dt;
            p.x += (Math.sin(p.sway * Math.PI / 180) * p.swayAmp + p.speedX) * dt;
            p.angle += p.spin * dt;
            if (p.y > gc.height + 30) { var np = mkPetal(); np.y = -20; np.x = Math.random()*gc.width; Object.assign(p, np); }
            if (p.x < -30) p.x = gc.width + 10;
            if (p.x > gc.width + 30) p.x = -10;
            drawPetal(p);
        });
        rafId = requestAnimationFrame(loop);
    }
    rafId = requestAnimationFrame(loop);
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) { cancelAnimationFrame(rafId); } else { lastTs = 0; rafId = requestAnimationFrame(loop); }
    });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();


/* --- Splash Romantico de Bienvenida con Efecto Desintegracion (Segundo 1) --- */
(function() {
    function initSplash() {
        const splashEl = document.getElementById('romantic-splash');
        if (!splashEl) return;

        const SPLASH_SESSION_KEY = 'carla_jardin_splash_seen_v1';
        if (sessionStorage.getItem(SPLASH_SESSION_KEY)) {
            splashEl.remove();
            return;
        }

        const cardEl = splashEl.querySelector('.splash-card');
        const canvas = document.getElementById('splash-particle-canvas');
        let ctx = null;
        let particles = [];
        let animId = null;
        let isDismissed = false;

        if (canvas) {
            ctx = canvas.getContext('2d');
            function resizeCanvas() {
                if (!cardEl) return;
                const rect = cardEl.getBoundingClientRect();
                canvas.width = rect.width + 80;
                canvas.height = rect.height + 80;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);
        }

        // Crear enjambre de particulas de desintegracion (polvo de oro rosa, chispas y petalos)
        function triggerDisintegrationParticles() {
            if (!canvas || !ctx || !cardEl) return;
            const w = canvas.width;
            const h = canvas.height;
            const count = 160;
            const colors = [
                'rgba(240, 168, 185, ',
                'rgba(248, 203, 175, ',
                'rgba(215, 138, 155, ',
                'rgba(255, 235, 220, ',
                'rgba(255, 255, 255, '
            ];

            for (let i = 0; i < count; i++) {
                // Distribuir a lo largo de la tarjeta
                const startX = 40 + Math.random() * (w - 80);
                const startY = 40 + Math.random() * (h - 80);
                const angle = Math.random() * Math.PI * 2;
                const speed = 1.2 + Math.random() * 4.2;
                particles.push({
                    x: startX,
                    y: startY,
                    vx: Math.cos(angle) * speed + (Math.random() - 0.5) * 1.5,
                    vy: Math.sin(angle) * speed - (1.2 + Math.random() * 2.8), // Flotan hacia arriba y afuera
                    size: 1.5 + Math.random() * 4.5,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    alpha: 0.9 + Math.random() * 0.1,
                    decay: 0.008 + Math.random() * 0.016,
                    spin: (Math.random() - 0.5) * 0.1,
                    angle: Math.random() * Math.PI * 2,
                    shape: Math.random() > 0.65 ? 'star' : (Math.random() > 0.35 ? 'petal' : 'spark')
                });
            }

            function renderParticles() {
                ctx.clearRect(0, 0, w, h);
                let alive = 0;
                for (let i = 0; i < particles.length; i++) {
                    const p = particles[i];
                    if (p.alpha <= 0) continue;
                    alive++;
                    p.x += p.vx;
                    p.y += p.vy;
                    p.vx *= 0.98;
                    p.vy *= 0.98;
                    p.angle += p.spin;
                    p.alpha -= p.decay;

                    ctx.save();
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.angle);
                    ctx.fillStyle = p.color + Math.max(0, p.alpha) + ')';
                    ctx.shadowColor = 'rgba(235, 140, 160, 0.8)';
                    ctx.shadowBlur = 8;

                    if (p.shape === 'star') {
                        ctx.beginPath();
                        ctx.moveTo(0, -p.size * 1.4);
                        ctx.lineTo(p.size * 0.4, -p.size * 0.4);
                        ctx.lineTo(p.size * 1.4, 0);
                        ctx.lineTo(p.size * 0.4, p.size * 0.4);
                        ctx.lineTo(0, p.size * 1.4);
                        ctx.lineTo(-p.size * 0.4, p.size * 0.4);
                        ctx.lineTo(-p.size * 1.4, 0);
                        ctx.lineTo(-p.size * 0.4, -p.size * 0.4);
                        ctx.closePath();
                        ctx.fill();
                    } else if (p.shape === 'petal') {
                        ctx.beginPath();
                        ctx.ellipse(0, 0, p.size * 1.3, p.size * 0.7, 0, 0, Math.PI * 2);
                        ctx.fill();
                    } else {
                        ctx.beginPath();
                        ctx.arc(0, 0, p.size, 0, Math.PI * 2);
                        ctx.fill();
                    }
                    ctx.restore();
                }

                if (alive > 0) {
                    animId = requestAnimationFrame(renderParticles);
                }
            }
            renderParticles();
        }

        function dismissSplashWithDisintegration() {
            if (isDismissed) return;
            isDismissed = true;
            try {
                sessionStorage.setItem(SPLASH_SESSION_KEY, 'true');
            } catch (e) {}

            // Iniciar efecto de desintegracion
            splashEl.classList.add('is-disintegrating');
            triggerDisintegrationParticles();

            setTimeout(() => {
                splashEl.remove();
                if (animId) cancelAnimationFrame(animId);
            }, 1600);
        }

        const closeBtn = document.getElementById('splash-close');
        const enterBtn = document.getElementById('splash-enter');

        if (closeBtn) closeBtn.addEventListener('click', dismissSplashWithDisintegration);
        if (enterBtn) enterBtn.addEventListener('click', dismissSplashWithDisintegration);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !isDismissed) {
                dismissSplashWithDisintegration();
            }
        });

        // Activar el efecto de desintegracion a los 8 segundos (8000ms)
        setTimeout(() => {
            dismissSplashWithDisintegration();
        }, 8000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSplash);
    } else {
        initSplash();
    }
})();

// ── Botón flotante de mensajes de amor ────────────────────────────────────────────
(function initLoveMessageBtn() {
    // Contenedor del popup
    const popup = document.createElement('div');
    popup.id = 'love-msg-popup';
    popup.setAttribute('role', 'status');
    popup.setAttribute('aria-live', 'polite');
    popup.setAttribute('aria-atomic', 'true');
    popup.hidden = true;
    popup.innerHTML = `
        <div class="love-msg-inner">
            <span class="love-msg-tag" id="love-msg-tag"></span>
            <p class="love-msg-text" id="love-msg-text"></p>
            <span class="love-msg-sig">— Adrián 💌</span>
        </div>
    `;
    document.body.appendChild(popup);

    // Botón flotante de mensajes de amor (dentro de floating-dock-right)
    let btn = document.getElementById('love-msg-btn');
    if (!btn) {
        btn = document.createElement('button');
        btn.id = 'love-msg-btn';
        btn.className = 'love-msg-btn';
        btn.setAttribute('aria-label', 'Recibir un mensaje de amor');
        btn.setAttribute('title', 'Mensaje de amor de Adrián');
        btn.innerHTML = `
            <span class="love-msg-icon" aria-hidden="true">💌</span>
            <span class="dock-tooltip" role="tooltip">Mensaje de amor</span>
        `;
        const dock = document.getElementById('floating-dock-right');
        if (dock) {
            dock.appendChild(btn);
        } else {
            document.body.appendChild(btn);
        }
    }

    const TAG_LABELS = {
        amor: '❤️ Amor',
        ternura: '🌸 Ternura',
        valor: '✨ Valor',
        fe: '🙏 Fe',
        motivacion: '🌟 Motivación',
        poetico: '🌙 Poesía',
        gracias: '🌺 Gratitud',
        especial: '💫 Especial',
        belleza: '🌹 Belleza',
        futuro: '🌈 Futuro',
        promesa: '💍 Promesa',
        admiracion: '⭐ Admiración',
        cotidiano: '☕ Cotidiano',
    };

    let hideTimer = null;

    btn.addEventListener('click', () => {
        const msg = getRandomMessage();
        const tagEl  = document.getElementById('love-msg-tag');
        const textEl = document.getElementById('love-msg-text');
        tagEl.textContent  = TAG_LABELS[msg.tag] || '💌 Mensaje';
        textEl.textContent = msg.text;

        // Reset animation
        popup.classList.remove('love-msg-show');
        popup.hidden = false;
        // Force reflow
        void popup.offsetWidth;
        popup.classList.add('love-msg-show');

        btn.classList.add('love-msg-btn-pop');
        setTimeout(() => btn.classList.remove('love-msg-btn-pop'), 400);

        if (hideTimer) clearTimeout(hideTimer);
        hideTimer = setTimeout(() => {
            popup.classList.remove('love-msg-show');
            popup.classList.add('love-msg-hide');
            setTimeout(() => {
                popup.hidden = true;
                popup.classList.remove('love-msg-hide');
            }, 500);
        }, 6500);
    });
})();

// Inicializar sistema de notas contextuales de Carla Lorena
initializeCornerNotes();

// Inicializar sistema de administración integral
initializeAdminSystem();

// Inicializar reproductor moderno y playlist interactiva
initializeEntertainmentPlayer();

// Inicializar cápsulas del tiempo y cartas selladas
initializeTimeCapsules();

// Inicializar Modo Libro de Recuerdos (Scrapbook) para Álbumes
function initializeScrapbookMode() {
    const toggleBtn = document.getElementById('toggle-scrapbook-view-btn');
    const albumsSection = document.querySelector('[data-screen="albumes"]');
    const btnText = document.getElementById('scrapbook-btn-text');
    if (!toggleBtn || !albumsSection) return;

    let isScrapbook = localStorage.getItem('carla_scrapbook_mode') === 'true';

    function applyMode() {
        albumsSection.classList.toggle('is-scrapbook-mode', isScrapbook);
        if (btnText) {
            btnText.textContent = isScrapbook ? 'Modo Cuadrícula Estándar' : 'Modo Libro Scrapbook';
        }
        toggleBtn.classList.toggle('is-active', isScrapbook);
    }

    applyMode();

    toggleBtn.addEventListener('click', () => {
        isScrapbook = !isScrapbook;
        localStorage.setItem('carla_scrapbook_mode', isScrapbook);
        applyMode();
    });
}
initializeScrapbookMode();

// ── Inicialización: Guía Completa del Sistema ────────────────────────
function initSystemGuide() {
    const guideTrigger = document.getElementById('btn-open-system-guide');
    const guideDialog = document.getElementById('system-guide-dialog');
    const closeGuideBtn = document.getElementById('btn-close-system-guide');
    const guideTabs = document.querySelectorAll('.guide-tab');
    const searchInput = document.getElementById('guide-search-input');
    const guideCards = document.querySelectorAll('.guide-item-card');

    if (!guideDialog) return;

    function openGuide() {
        playSoftChime(659.25);
        setTimeout(() => playSoftChime(880.00), 150);
        if (guideDialog instanceof HTMLDialogElement) {
            guideDialog.showModal();
        }
    }

    guideTrigger?.addEventListener('click', (e) => {
        e.stopPropagation();
        openGuide();
    });

    closeGuideBtn?.addEventListener('click', () => {
        if (guideDialog instanceof HTMLDialogElement) {
            guideDialog.close();
        }
    });

    guideDialog.addEventListener('click', (e) => {
        if (e.target === guideDialog && guideDialog instanceof HTMLDialogElement) {
            guideDialog.close();
        }
    });

    // Pestañas temáticas
    guideTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabName = tab.dataset.guideTab;
            guideTabs.forEach(t => {
                const isActive = t === tab;
                t.classList.toggle('is-active', isActive);
                t.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            document.querySelectorAll('.guide-pane').forEach(pane => {
                const isCurrent = pane.id === `guide-pane-${tabName}`;
                pane.classList.toggle('is-active', isCurrent);
                pane.hidden = !isCurrent;
            });

            playSoftChime(783.99);
        });
    });

    // Búsqueda interactiva en la guía
    searchInput?.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        if (!query) {
            guideCards.forEach(card => card.style.display = '');
            return;
        }

        // Mostrar todas las pestañas al buscar
        document.querySelectorAll('.guide-pane').forEach(p => p.hidden = false);

        guideCards.forEach(card => {
            const text = (card.innerText + ' ' + (card.dataset.keywords || '')).toLowerCase();
            card.style.display = text.includes(query) ? '' : 'none';
        });
    });
}

// ── Inicialización: El Florecer del Día (Daily Bloom) ─────────────────
const DAILY_BLOOM_QUOTES = [
    { text: "«Tu sonrisa es la flor más hermosa que jamás ha nacido en este jardín.»", flower: "Rosa Carmesí del Alba 🌹" },
    { text: "«No hay prisa en el alma que sabe florecer a su propio y perfecto ritmo, Carla.»", flower: "Camelia Blanca de Serenidad 🌺" },
    { text: "«Dondequiera que camines hoy, llevas contigo la luz noble que ilumina vidas.»", flower: "Jazmín de Primavera Dorada 🌼" },
    { text: "«Eres el refugio seguro donde los pensamientos descansan en paz absoluta.»", flower: "Lavanda Silvestre de Montaña 🪻" },
    { text: "«En cada latido hay un verso guardado que solo sabe pronunciar tu nombre.»", flower: "Orquídea Pura del Sentimiento 🤍" },
    { text: "«Que el día de hoy te recuerde lo profundamente admirada y querida que eres.»", flower: "Peonía Rosada de la Fortuna 🌸" },
    { text: "«El tiempo pasa en los relojes, pero en mi corazón tus recuerdos nunca envejecen.»", flower: "Loto Sagrado de la Trascendencia 🪷" }
];

function initDailyBloom() {
    const card = document.getElementById('daily-bloom-card');
    const quoteEl = document.getElementById('db-quote-text');
    const dateEl = document.getElementById('db-current-date');
    const flowerEl = document.getElementById('db-flower-type');
    const refreshBtn = document.getElementById('db-refresh-btn');

    if (!card || !quoteEl) return;

    const today = new Date();
    const dayOfYear = Math.floor((today - new Date(today.getFullYear(), 0, 0)) / 1000 / 60 / 60 / 24);
    let currentIndex = dayOfYear % DAILY_BLOOM_QUOTES.length;

    function renderBloom(idx) {
        const item = DAILY_BLOOM_QUOTES[idx];
        quoteEl.style.opacity = '0';
        setTimeout(() => {
            quoteEl.textContent = item.text;
            if (flowerEl) flowerEl.textContent = `Flor del día: ${item.flower}`;
            if (dateEl) dateEl.textContent = today.toLocaleDateString('es-ES', { weekday: 'long', day: 'numeric', month: 'short' });
            quoteEl.style.opacity = '1';
        }, 150);
    }

    renderBloom(currentIndex);

    refreshBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        currentIndex = (currentIndex + 1) % DAILY_BLOOM_QUOTES.length;
        renderBloom(currentIndex);
        playSoftChime(880.00);
        triggerHaptic([15, 20]);
    });
}

// ── Fondo Botánico Global Interactivo: Rosas, Girasoles, Tulipanes y Pétalos ──
function initGlobalInteractiveGardenBackground() {
    const canvas = document.getElementById('global-garden-interactive-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    let width = 0;
    let height = 0;

    function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
        if (typeof updateFlowerPositions === 'function') {
            updateFlowerPositions();
        }
    }
    window.addEventListener('resize', resize);
    resize();

    // Estado del cursor para interactividad
    const mouse = {
        x: -1000,
        y: -1000,
        radius: 120,
        isDown: false
    };

    window.addEventListener('mousemove', (e) => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });

    window.addEventListener('touchmove', (e) => {
        if (e.touches && e.touches[0]) {
            mouse.x = e.touches[0].clientX;
            mouse.y = e.touches[0].clientY;
        }
    }, { passive: true });

    window.addEventListener('click', (e) => {
        // Al hacer clic, florece un destello de mini pétalos donde se clickeó
        burstPetalsAt(e.clientX, e.clientY);
    });

    // 1. Flores Estáticas Pegadas en el Fondo (Rosas, Girasoles, Tulipanes, Margaritas, Campanillas y Amapolas)
    // Se colocan en posiciones fijas armónicas (esquinas, márgenes laterales e inferiores) con tallo y hojas
    function createStaticFlowers() {
        const layout = [
            // Esquina superior izquierda
            { type: 'rose', relX: 0.05, relY: 0.14, size: 62, baseAngle: -0.15 },
            { type: 'tulip', relX: 0.13, relY: 0.22, size: 54, baseAngle: 0.2 },
            // Esquina superior derecha
            { type: 'bellflower', relX: 0.93, relY: 0.16, size: 56, baseAngle: 0.25 },
            { type: 'rose', relX: 0.86, relY: 0.24, size: 60, baseAngle: -0.2 },
            // Margen lateral izquierdo (medio)
            { type: 'poppy', relX: 0.05, relY: 0.48, size: 52, baseAngle: 0.1 },
            { type: 'daisy', relX: 0.09, relY: 0.62, size: 56, baseAngle: -0.15 },
            // Margen lateral derecho (medio)
            { type: 'sunflower', relX: 0.94, relY: 0.50, size: 68, baseAngle: -0.25 },
            { type: 'tulip', relX: 0.90, relY: 0.65, size: 52, baseAngle: 0.18 },
            // Borde inferior izquierdo
            { type: 'sunflower', relX: 0.07, relY: 0.85, size: 72, baseAngle: 0.12 },
            { type: 'rose', relX: 0.17, relY: 0.88, size: 60, baseAngle: -0.1 },
            { type: 'poppy', relX: 0.26, relY: 0.92, size: 48, baseAngle: 0.15 },
            // Borde inferior derecho
            { type: 'bellflower', relX: 0.80, relY: 0.89, size: 54, baseAngle: -0.2 },
            { type: 'tulip', relX: 0.89, relY: 0.86, size: 58, baseAngle: -0.15 },
            { type: 'daisy', relX: 0.95, relY: 0.82, size: 60, baseAngle: 0.25 }
        ];

        return layout.map((item, idx) => ({
            type: item.type,
            relX: item.relX,
            relY: item.relY,
            x: item.relX * width,
            y: item.relY * height,
            size: item.size,
            baseAngle: item.baseAngle,
            currentAngle: item.baseAngle,
            swaySpeed: 0.015 + (idx % 4) * 0.005,
            swayAmp: 0.06 + (idx % 3) * 0.02,
            phase: idx * 1.3,
            scale: 1,
            targetScale: 1,
            opacity: 0.95
        }));
    }

    let flowers = createStaticFlowers();

    function updateFlowerPositions() {
        flowers.forEach((fl) => {
            fl.x = fl.relX * width;
            fl.y = fl.relY * height;
        });
    }

    // 2. Pétalos Flotantes Dinámicos
    const petalColors = [
        'rgba(244, 114, 182, ',  // Rosa pastel
        'rgba(251, 191, 36, ',   // Amarillo Girasol
        'rgba(236, 72, 153, ',   // Tulipán Magenta
        'rgba(192, 132, 252, ',  // Lavanda
        'rgba(254, 205, 211, '   // Peonía Suave
    ];

    const totalPetals = Math.max(35, Math.floor(window.innerWidth / 35));
    const petals = Array.from({ length: totalPetals }, () => ({
        x: Math.random() * width,
        y: Math.random() * height,
        size: 7 + Math.random() * 10,
        speedY: 0.6 + Math.random() * 1.1,
        speedX: -0.4 + Math.random() * 0.8,
        angle: Math.random() * Math.PI * 2,
        spin: (Math.random() - 0.5) * 0.04,
        opacity: 0.35 + Math.random() * 0.45,
        color: petalColors[Math.floor(Math.random() * petalColors.length)],
        ratio: 0.45 + Math.random() * 0.25
    }));

    // Partículas interactivas por clic
    const burstParticles = [];
    function burstPetalsAt(bx, by) {
        for (let i = 0; i < 16; i++) {
            const angle = Math.random() * Math.PI * 2;
            const velocity = 2 + Math.random() * 4.5;
            burstParticles.push({
                x: bx,
                y: by,
                vx: Math.cos(angle) * velocity,
                vy: Math.sin(angle) * velocity,
                size: 6 + Math.random() * 8,
                color: petalColors[Math.floor(Math.random() * petalColors.length)],
                opacity: 0.95,
                decay: 0.02 + Math.random() * 0.02,
                angle: Math.random() * Math.PI * 2,
                spin: (Math.random() - 0.5) * 0.1
            });
        }
    }

    // Dibujadores de Flores vectoriales fieles a la ilustración de referencia
    function drawStemAndLeaves(cx, cy, radius, heightOffset = 60, leafSide = 1) {
        ctx.save();
        ctx.strokeStyle = '#4b7c53';
        ctx.lineWidth = Math.max(2.5, radius * 0.08);
        ctx.lineCap = 'round';
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.quadraticCurveTo(cx - 5 * leafSide, cy + heightOffset * 0.5, cx, cy + heightOffset);
        ctx.stroke();

        // Hoja verde orgánica
        ctx.fillStyle = '#5c9466';
        ctx.beginPath();
        const lx = cx + 8 * leafSide;
        const ly = cy + heightOffset * 0.45;
        ctx.ellipse(lx, ly, radius * 0.35, radius * 0.18, (Math.PI / 4) * leafSide, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();
    }

    // 1. Rosa (Roja con pétalos elegantes)
    function drawRose(cx, cy, radius, opacity) {
        ctx.save();
        ctx.globalAlpha = opacity;
        drawStemAndLeaves(cx, cy, radius, radius * 1.5, 1);

        const grad = ctx.createRadialGradient(cx, cy, radius * 0.15, cx, cy, radius);
        grad.addColorStop(0, '#f87171');
        grad.addColorStop(0.5, '#dc2626');
        grad.addColorStop(1, '#991b1b');

        // Pétalos externos curvados
        for (let i = 0; i < 5; i++) {
            const a = (i * Math.PI * 2) / 5;
            const px = cx + Math.cos(a) * (radius * 0.5);
            const py = cy + Math.sin(a) * (radius * 0.5);
            ctx.fillStyle = grad;
            ctx.beginPath();
            ctx.arc(px, py, radius * 0.48, 0, Math.PI * 2);
            ctx.fill();
        }

        // Corona central
        ctx.fillStyle = '#b91c1c';
        for (let i = 0; i < 4; i++) {
            const a = (i * Math.PI * 2) / 4 + Math.PI / 4;
            const px = cx + Math.cos(a) * (radius * 0.3);
            const py = cy + Math.sin(a) * (radius * 0.3);
            ctx.beginPath();
            ctx.arc(px, py, radius * 0.35, 0, Math.PI * 2);
            ctx.fill();
        }

        // Centro aterciopelado
        ctx.fillStyle = '#ffffff';
        ctx.beginPath();
        ctx.arc(cx, cy, radius * 0.18, 0, Math.PI * 2);
        ctx.fill();

        ctx.restore();
    }

    // 2. Tulipán (Copa naranja/ámbar estilizada con dos hojas largas)
    function drawTulip(cx, cy, radius, opacity) {
        ctx.save();
        ctx.globalAlpha = opacity;

        // Tallo y hojas dobles alargadas de tulipán
        ctx.fillStyle = '#48815b';
        ctx.beginPath();
        ctx.ellipse(cx - radius * 0.35, cy + radius * 0.6, radius * 0.22, radius * 0.7, -Math.PI / 12, 0, Math.PI * 2);
        ctx.fill();
        ctx.beginPath();
        ctx.ellipse(cx + radius * 0.35, cy + radius * 0.6, radius * 0.22, radius * 0.7, Math.PI / 12, 0, Math.PI * 2);
        ctx.fill();

        ctx.strokeStyle = '#3e6f4e';
        ctx.lineWidth = radius * 0.09;
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.lineTo(cx, cy + radius * 1.5);
        ctx.stroke();

        // Copa de pétalos tulipán
        const tulipGrad = ctx.createLinearGradient(cx, cy - radius * 0.8, cx, cy + radius * 0.6);
        tulipGrad.addColorStop(0, '#f87171');
        tulipGrad.addColorStop(0.5, '#ef4444');
        tulipGrad.addColorStop(1, '#991b1b');

        // Pétalos laterales
        ctx.fillStyle = '#dc2626';
        ctx.beginPath();
        ctx.ellipse(cx - radius * 0.28, cy - radius * 0.1, radius * 0.35, radius * 0.65, -Math.PI / 10, 0, Math.PI * 2);
        ctx.fill();

        ctx.beginPath();
        ctx.ellipse(cx + radius * 0.28, cy - radius * 0.1, radius * 0.35, radius * 0.65, Math.PI / 10, 0, Math.PI * 2);
        ctx.fill();

        // Pétalo frontal
        ctx.fillStyle = tulipGrad;
        ctx.beginPath();
        ctx.ellipse(cx, cy - radius * 0.05, radius * 0.42, radius * 0.68, 0, 0, Math.PI * 2);
        ctx.fill();

        ctx.restore();
    }

    // 3. Girasol (Corona dorada con centro de semillas oscuro)
    function drawSunflower(cx, cy, radius, opacity) {
        ctx.save();
        ctx.globalAlpha = opacity;
        drawStemAndLeaves(cx, cy, radius, radius * 1.6, -1);

        const petalCount = 14;
        const petalLen = radius * 0.85;
        const petalWid = radius * 0.28;

        ctx.fillStyle = '#fbbf24';
        for (let i = 0; i < petalCount; i++) {
            const a = (i * Math.PI * 2) / petalCount;
            ctx.save();
            ctx.translate(cx, cy);
            ctx.rotate(a);
            ctx.beginPath();
            ctx.ellipse(petalLen * 0.55, 0, petalLen * 0.5, petalWid * 0.5, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }

        // Corona interior ámbar
        ctx.fillStyle = '#f59e0b';
        for (let i = 0; i < petalCount; i++) {
            const a = (i * Math.PI * 2) / petalCount + (Math.PI / petalCount);
            ctx.save();
            ctx.translate(cx, cy);
            ctx.rotate(a);
            ctx.beginPath();
            ctx.ellipse(petalLen * 0.45, 0, petalLen * 0.38, petalWid * 0.38, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }

        // Disco central
        const seedGrad = ctx.createRadialGradient(cx, cy, 2, cx, cy, radius * 0.38);
        seedGrad.addColorStop(0, '#542c13');
        seedGrad.addColorStop(0.8, '#3d1d09');
        seedGrad.addColorStop(1, '#220e03');
        ctx.fillStyle = seedGrad;
        ctx.beginPath();
        ctx.arc(cx, cy, radius * 0.38, 0, Math.PI * 2);
        ctx.fill();

        ctx.restore();
    }

    // 4. Margarita (Pétalos blancos/crema con botón dorado central)
    function drawDaisy(cx, cy, radius, opacity) {
        ctx.save();
        ctx.globalAlpha = opacity;
        drawStemAndLeaves(cx, cy, radius, radius * 1.4, 1);

        const petalCount = 16;
        const petalLen = radius * 0.82;
        const petalWid = radius * 0.24;

        ctx.fillStyle = '#fffdfa';
        ctx.shadowColor = 'rgba(215, 185, 175, 0.3)';
        ctx.shadowBlur = 4;
        for (let i = 0; i < petalCount; i++) {
            const a = (i * Math.PI * 2) / petalCount;
            ctx.save();
            ctx.translate(cx, cy);
            ctx.rotate(a);
            ctx.beginPath();
            ctx.ellipse(petalLen * 0.55, 0, petalLen * 0.5, petalWid * 0.5, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }
        ctx.shadowColor = 'transparent';

        // Centro botón amarillo dorado
        const centerGrad = ctx.createRadialGradient(cx, cy, 2, cx, cy, radius * 0.32);
        centerGrad.addColorStop(0, '#fef08a');
        centerGrad.addColorStop(0.8, '#eab308');
        centerGrad.addColorStop(1, '#ca8a04');
        ctx.fillStyle = centerGrad;
        ctx.beginPath();
        ctx.arc(cx, cy, radius * 0.32, 0, Math.PI * 2);
        ctx.fill();

        ctx.restore();
    }

    // 5. Campanilla (Flores violeta lavanda)
    function drawBellflower(cx, cy, radius, opacity) {
        ctx.save();
        ctx.globalAlpha = opacity;
        drawStemAndLeaves(cx, cy, radius, radius * 1.5, -1);

        const bellGrad = ctx.createLinearGradient(cx, cy - radius * 0.6, cx, cy + radius * 0.5);
        bellGrad.addColorStop(0, '#c084fc');
        bellGrad.addColorStop(0.6, '#9333ea');
        bellGrad.addColorStop(1, '#6b21a8');

        // Flor campanilla superior
        for (let i = 0; i < 5; i++) {
            const a = (i * Math.PI * 2) / 5 - Math.PI / 2;
            ctx.fillStyle = bellGrad;
            ctx.beginPath();
            ctx.ellipse(cx + Math.cos(a) * radius * 0.38, cy + Math.sin(a) * radius * 0.38, radius * 0.25, radius * 0.4, a, 0, Math.PI * 2);
            ctx.fill();
        }
        // Centro estambre
        ctx.fillStyle = '#fef08a';
        ctx.beginPath();
        ctx.arc(cx, cy, radius * 0.14, 0, Math.PI * 2);
        ctx.fill();

        ctx.restore();
    }

    // 6. Amapola (Rojo intenso con centro oscuro)
    function drawPoppy(cx, cy, radius, opacity) {
        ctx.save();
        ctx.globalAlpha = opacity;
        drawStemAndLeaves(cx, cy, radius, radius * 1.4, 1);

        // 4 grandes pétalos escarlata
        ctx.fillStyle = '#ef4444';
        for (let i = 0; i < 4; i++) {
            const a = (i * Math.PI * 2) / 4 + Math.PI / 8;
            ctx.beginPath();
            ctx.ellipse(cx + Math.cos(a) * radius * 0.32, cy + Math.sin(a) * radius * 0.32, radius * 0.45, radius * 0.4, a, 0, Math.PI * 2);
            ctx.fill();
        }

        // Centro negro característico
        ctx.fillStyle = '#18181b';
        ctx.beginPath();
        ctx.arc(cx, cy, radius * 0.22, 0, Math.PI * 2);
        ctx.fill();

        // Anillo de polen
        ctx.strokeStyle = '#fef08a';
        ctx.lineWidth = 1.2;
        ctx.setLineDash([2, 3]);
        ctx.beginPath();
        ctx.arc(cx, cy, radius * 0.25, 0, Math.PI * 2);
        ctx.stroke();
        ctx.setLineDash([]);

        ctx.restore();
    }

    // Bucle principal de animación a 60 FPS
    let time = 0;
    function animate() {
        ctx.clearRect(0, 0, width, height);
        time += 0.02;

        // 1. Renderizado de Flores Estáticas Pegadas al Fondo (con balanceo natural por brisa y mouse)
        flowers.forEach((fl) => {
            // Balanceo armónico orgánico simulando el viento en el tallo
            const naturalSway = Math.sin(time * 1.5 + fl.phase) * fl.swayAmp;
            
            // Interacción con el cursor (al acercar el ratón, se balancea y respira suavemente en su sitio)
            const dx = mouse.x - fl.x;
            const dy = mouse.y - fl.y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            let mouseSway = 0;
            if (dist < mouse.radius) {
                const influence = (mouse.radius - dist) / mouse.radius;
                mouseSway = (dx > 0 ? -1 : 1) * influence * 0.18;
                fl.targetScale = 1.15;
            } else {
                fl.targetScale = 1.0;
            }

            fl.scale += (fl.targetScale - fl.scale) * 0.08;
            fl.currentAngle = fl.baseAngle + naturalSway + mouseSway;

            ctx.save();
            ctx.translate(fl.x, fl.y);
            ctx.rotate(fl.currentAngle);
            ctx.scale(fl.scale, fl.scale);

            if (fl.type === 'rose') {
                drawRose(0, 0, fl.size, fl.opacity);
            } else if (fl.type === 'sunflower') {
                drawSunflower(0, 0, fl.size, fl.opacity);
            } else if (fl.type === 'tulip') {
                drawTulip(0, 0, fl.size, fl.opacity);
            } else if (fl.type === 'daisy') {
                drawDaisy(0, 0, fl.size, fl.opacity);
            } else if (fl.type === 'bellflower') {
                drawBellflower(0, 0, fl.size, fl.opacity);
            } else if (fl.type === 'poppy') {
                drawPoppy(0, 0, fl.size, fl.opacity);
            }

            ctx.restore();
        });

        // 2. Renderizado de Pétalos Flotantes
        petals.forEach((p) => {
            p.y += p.speedY;
            p.x += Math.sin(p.angle) * 0.6 + p.speedX;
            p.angle += p.spin;

            // Brisa con el cursor
            const pdx = mouse.x - p.x;
            const pdy = mouse.y - p.y;
            const pdist = Math.sqrt(pdx * pdx + pdy * pdy);
            if (pdist < 80) {
                p.x -= (pdx / pdist) * 2.8;
                p.y -= (pdy / pdist) * 2.8;
            }

            if (p.y > height + 20) {
                p.y = -20;
                p.x = Math.random() * width;
            }

            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.angle);
            ctx.fillStyle = `${p.color}${p.opacity})`;
            ctx.beginPath();
            ctx.ellipse(0, 0, p.size, p.size * p.ratio, Math.PI / 10, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        });

        // 3. Explosión de Pétalos por clic interactivo
        for (let i = burstParticles.length - 1; i >= 0; i--) {
            const bp = burstParticles[i];
            bp.x += bp.vx;
            bp.y += bp.vy;
            bp.vx *= 0.94;
            bp.vy *= 0.94;
            bp.angle += bp.spin;
            bp.opacity -= bp.decay;

            if (bp.opacity <= 0) {
                burstParticles.splice(i, 1);
                continue;
            }

            ctx.save();
            ctx.translate(bp.x, bp.y);
            ctx.rotate(bp.angle);
            ctx.fillStyle = `${bp.color}${bp.opacity})`;
            ctx.beginPath();
            ctx.ellipse(0, 0, bp.size, bp.size * 0.55, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }

        requestAnimationFrame(animate);
    }

    animate();
}

// ── MOTOR DE ANIMACIONES PROFESIONALES: TILT 3D, RESORTE Y RIPPLE ──
function initButtonRipples() {
    document.addEventListener('pointerdown', (e) => {
        const btn = e.target.closest('.button, .nav-passport-btn, .db-refresh-btn');
        if (!btn) return;
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        btn.style.setProperty('--ripple-x', `${x}px`);
        btn.style.setProperty('--ripple-y', `${y}px`);
        btn.classList.remove('ripple-active');
        void btn.offsetWidth; // Reflow for restart
        btn.classList.add('ripple-active');
        setTimeout(() => {
            btn.classList.remove('ripple-active');
        }, 600);
    });
}

function initTiltAndSpringPhysics() {
    const cards = document.querySelectorAll('.space-card, .botanical-hero-card, .daily-bloom-card, .enchanted-frame');
    cards.forEach((card) => {
        let isHovered = false;
        let rAF = null;
        let mouseX = 0, mouseY = 0;
        let currRotX = 0, currRotY = 0;

        card.addEventListener('pointerenter', () => {
            isHovered = true;
        });

        card.addEventListener('pointermove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            mouseX = ((y - centerY) / centerY) * -7; // max -7deg to 7deg
            mouseY = ((x - centerX) / centerX) * 7;

            if (!rAF) {
                rAF = requestAnimationFrame(updateTilt);
            }
        });

        card.addEventListener('pointerleave', () => {
            isHovered = false;
            mouseX = 0;
            mouseY = 0;
            if (!rAF) {
                rAF = requestAnimationFrame(updateTilt);
            }
        });

        function updateTilt() {
            currRotX += (mouseX - currRotX) * 0.12;
            currRotY += (mouseY - currRotY) * 0.12;

            card.style.transform = `perspective(1000px) rotateX(${currRotX.toFixed(2)}deg) rotateY(${currRotY.toFixed(2)}deg) translateZ(0)`;

            if (isHovered || Math.abs(currRotX) > 0.05 || Math.abs(currRotY) > 0.05) {
                rAF = requestAnimationFrame(updateTilt);
            } else {
                card.style.transform = '';
                rAF = null;
            }
        }
    });
}

// ── Inicialización UX: Modo Museo y Pasaporte del Jardín ─────────────
function initAllModules() {
    initMuseumLightbox();
    initGardenPassport();
    initFloatingSurprises();
    initFriendDedications();
    initHomeCardsAdmin();
    initSeasonalWeather();
    initSystemGuide();
    initDailyBloom();
    initGlobalInteractiveGardenBackground();
    initButtonRipples();
    initTiltAndSpringPhysics();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllModules);
} else {
    initAllModules();
}

