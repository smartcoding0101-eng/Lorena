import { openMuseumLightbox, registerPassportStamp, initMuseumLightbox, initGardenPassport } from './museum-passport.js';
import { initFloatingSurprises } from './floating-surprises.js';
import { initFriendDedications } from './friend-dedications.js';
import { initHomeCardsAdmin } from './home-cards-admin.js';
import { initSeasonalWeather } from './seasonal-weather.js';
import { initMasterAudioController } from './master-audio.js';
import { initNavbarAutoHover } from './navbar-auto-hover.js';
import { initCardsAutoHover } from './cards-auto-hover.js';
import { initFloatingMediaPlayer } from './floating-media-player.js';
import './bootstrap';
import { playMusicForScreen, enableAudio, toggleMusic, setMasterVolume, isMusicPlaying } from './garden-audio.js';
import { getRandomMessage, MESSAGE_COUNT } from './love-messages.js';
import { initializeCornerNotes } from './corner-notes.js';
import { initializeAdminSystem } from './admin.js';
import { initializeEntertainmentPlayer } from './entertainment-player.js';
import { initializeTimeCapsules } from './time-capsules.js';
import { initGardenUXInnovations } from './garden-ux-innovations.js';

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

const memorySymbols = ['🌹', '🌷', '🌸', '🌺', '🌻', '🪷'];
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
        let visibleGalleryCount = 0;
        document.querySelectorAll('.gallery-item').forEach((item) => {
            const isHidden = filterButton.dataset.filter !== 'todos' && item.dataset.kind !== filterButton.dataset.filter;
            item.hidden = isHidden;
            if (!isHidden) visibleGalleryCount += 1;
        });
        const galleryEmpty = document.querySelector('[data-gallery-empty]');
        if (galleryEmpty) {
            galleryEmpty.hidden = visibleGalleryCount > 0;
        }
        return;
    }

    const resetGalleryFilterBtn = event.target.closest('[data-gallery-reset-filter]');
    if (resetGalleryFilterBtn) {
        const allBtn = document.querySelector('[data-filter="todos"]');
        if (allBtn) allBtn.click();
        return;
    }

    const gallerySizeBtn = event.target.closest('[data-gallery-grid-size]');
    if (gallerySizeBtn) {
        const size = gallerySizeBtn.dataset.galleryGridSize || 'standard';
        const grid = document.querySelector('.luxury-gallery-grid');
        if (grid) {
            grid.setAttribute('data-grid-size', size);
        }
        document.querySelectorAll('[data-gallery-grid-size]').forEach((btn) => {
            const active = btn === gallerySizeBtn;
            btn.classList.toggle('is-active', active);
            btn.setAttribute('aria-pressed', String(active));
        });
        try {
            localStorage.setItem('carla_gallery_grid_size', size);
        } catch (e) {}
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
        symbol.textContent = isShowing ? card.symbol : '🌿';
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

    // Inicializar el Reproductor Flotante Multimedia (Audio, Video, YouTube en Segundo Plano)
    const floatingPlayer = initFloatingMediaPlayer();

    // Botón flotante del dock (controlador del Reproductor Multimedia Flotante)
    let btn = document.getElementById('music-toggle-btn');
    if (!btn) {
        btn = document.createElement('button');
        btn.id = 'music-toggle-btn';
        btn.className = 'music-toggle-btn';
        btn.type = 'button';
        btn.setAttribute('aria-label', 'Reproductor multimedia flotante (Música y Video)');
        btn.setAttribute('title', 'Reproductor Multimedia Flotante · Carla Lorena');
        btn.setAttribute('aria-pressed', 'false');
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
        </svg>`;
        let dock = document.getElementById('floating-dock-right');
        if (!dock && document.body) {
            dock = document.createElement('div');
            dock.id = 'floating-dock-right';
            dock.className = 'floating-dock-right';
            dock.setAttribute('aria-label', 'Controles Flotantes del Jardín');
            document.body.appendChild(dock);
        }
        if (document.getElementById('floating-media-player') && dock) {
            dock.appendChild(btn);
        }
    } else {
        btn.setAttribute('aria-label', 'Reproductor multimedia flotante (Música y Video)');
        btn.setAttribute('title', 'Reproductor Multimedia Flotante · Carla Lorena');
        const tooltip = btn.querySelector('.dock-tooltip');
        if (tooltip) tooltip.textContent = 'Música y Video';
    }

    btn.addEventListener('click', () => {
        if (window.GardenMasterAudio && window.GardenMasterAudio.isMuted()) {
            window.GardenMasterAudio.unmuteAll(false);
        }
        floatingPlayer.toggleOpen();
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
            if (window.__gardenVisualEffectsOff) {
                petalsAnimationId = requestAnimationFrame(loop);
                return;
            }

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

    // 2. Tooltips poéticos para las islas del mapa (excluye el mapa botánico que usa su propio sistema anti-colisión)
    const mapIslands = document.querySelectorAll('.floral-island[data-tooltip]:not(#dynamic-floral-garden-realm .floral-island)');
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
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) return;
            if (!window.__gardenAudioCtx) {
                window.__gardenAudioCtx = new AudioContextClass();
            }
            const audioCtx = window.__gardenAudioCtx;
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(frequency, audioCtx.currentTime);
            gain.gain.setValueAtTime(0.0001, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.08, audioCtx.currentTime + 0.05);
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

    // ═══════════════════════════════════════════════════════════════════════
    // MOTOR DE DINAMISMO Y TECNOLOGÍA MOTION · JARDÍN FLORAL VIVIENTE
    // ═══════════════════════════════════════════════════════════════════════
    (function initLivingFloralGarden() {
        const gardenRealm = document.getElementById('dynamic-floral-garden-realm');
        if (!gardenRealm) return;

        const stage3D = document.getElementById('garden-3d-stage');
        const canvas = document.getElementById('garden-motion-canvas');
        const inspectPod = document.getElementById('floral-inspect-pod');
        const podEmblem = document.getElementById('pod-flower-emblem');
        const podTitle = document.getElementById('pod-title');
        const podBiome = document.getElementById('pod-biome-badge');
        const podQuote = document.getElementById('pod-quote');

        // Controles de la barra
        const btnBloomWave = document.getElementById('btn-garden-bloom-wave');
        const btnBreezeToggle = document.getElementById('btn-garden-breeze-toggle');
        const btnWeatherCycle = document.getElementById('btn-garden-weather-cycle');
        const btnSoundToggle = document.getElementById('btn-garden-sound-toggle');
        const labelBreeze = document.getElementById('label-garden-breeze');
        const labelWeather = document.getElementById('label-garden-weather');
        const iconWeather = document.getElementById('icon-garden-weather');
        const labelSound = document.getElementById('label-garden-sound');

        let soundEnabled = true;
        let isBreezeIntense = false;
        let currentAtmosphereIndex = 0;
        const atmospheres = [
            { id: 'sunset', icon: '🌅', label: 'Atardecer Dorado' },
            { id: 'night',  icon: '🌌', label: 'Noche de Luciérnagas' },
            { id: 'day',    icon: '🌞', label: 'Mañana Radiante' }
        ];

        // 1. ESCENARIO FIJO Y ESTABLE (Sin balanceo ni movimiento con el mouse)
        if (stage3D) {
            stage3D.style.transform = 'none';
        }

        gardenRealm.addEventListener('mouseleave', () => {
            if (inspectPod) {
                inspectPod.style.opacity = '0';
                setTimeout(() => { inspectPod.hidden = true; }, 200);
            }
            document.querySelectorAll('.radial-branch').forEach(b => b.classList.remove('is-lit'));
        });

        // 2. LIENZO DEDICADO DE FÍSICA DE PÉTALOS, POLEN Y ESTELA DEL CURSOR
        let ctx = null;
        let petals = [];
        let canvasW = 0, canvasH = 0;
        let lastCursorX = 0, lastCursorY = 0;
        let cursorSpeedX = 0, cursorSpeedY = 0;

        // Clase de Partícula Floral (Pétalos de Sakura, Rosa y Polen)
        class FloralParticle {
            constructor() {
                this.reset(true);
            }

            reset(initial = false) {
                this.x = Math.random() * (canvasW || 900);
                this.y = initial ? Math.random() * (canvasH || 600) : -20;
                this.size = Math.random() * 7 + 5;
                this.type = Math.random() > 0.45 ? 'rose_petal' : (Math.random() > 0.45 ? 'blossom' : 'pollen');
                this.vx = (Math.random() - 0.3) * 1.05;
                this.vy = Math.random() * 1.1 + 0.55;
                this.rotation = Math.random() * Math.PI * 2;
                this.rotSpeed = (Math.random() - 0.5) * 0.04;
                this.oscAmp = Math.random() * 20 + 10;
                this.oscFreq = Math.random() * 0.02 + 0.01;
                this.phase = Math.random() * Math.PI * 2;
                this.opacity = Math.random() * 0.55 + 0.35;
                this.scaleX = 1;
            }

            update(isBreeze = false) {
                this.phase += this.oscFreq * (isBreeze ? 1.6 : 1);
                const speedMult = isBreeze ? 1.9 : 1;
                this.x += (this.vx + Math.sin(this.phase) * 0.9) * speedMult;
                this.y += this.vy * speedMult;
                this.rotation += this.rotSpeed * (isBreeze ? 1.8 : 1);
                this.scaleX = Math.cos(this.phase * 1.4);

                // Interacción suave con la brisa del cursor
                const dx = this.x - lastCursorX;
                const dy = this.y - lastCursorY;
                const dist = Math.hypot(dx, dy);
                if (dist < 120 && dist > 1) {
                    const force = (120 - dist) / 120;
                    this.x += (dx / dist) * force * 5 + cursorSpeedX * 0.4;
                    this.y += (dy / dist) * force * 4 + cursorSpeedY * 0.4;
                }

                if (this.y > (canvasH || 650) + 30 || this.x < -40 || this.x > (canvasW || 950) + 40) {
                    this.reset(false);
                }
            }

            draw(ctx) {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.rotation);
                ctx.scale(this.scaleX, 1);
                ctx.globalAlpha = this.opacity;

                if (this.type === 'rose_petal') {
                    // 🌸 Pétalo orgánico de Rosa Imperial en acuarela
                    const s = this.size;
                    ctx.beginPath();
                    ctx.moveTo(0, -s);
                    ctx.bezierCurveTo(s * 0.85, -s * 0.75, s * 0.9, s * 0.45, 0, s);
                    ctx.bezierCurveTo(-s * 0.9, s * 0.45, -s * 0.85, -s * 0.75, 0, -s);
                    ctx.closePath();
                    const grad = ctx.createRadialGradient(0, -s * 0.25, 0, 0, 0, s);
                    grad.addColorStop(0, '#fff1f5');
                    grad.addColorStop(0.55, '#fda4af');
                    grad.addColorStop(1, '#e11d48');
                    ctx.fillStyle = grad;
                    ctx.shadowColor = 'rgba(225, 29, 72, 0.35)';
                    ctx.shadowBlur = 6;
                    ctx.fill();
                } else if (this.type === 'blossom') {
                    // 🌺 Corola delicada de 5 pétalos (Sakura Imperial)
                    const s = this.size * 0.52;
                    for (let i = 0; i < 5; i++) {
                        ctx.save();
                        ctx.rotate((i * Math.PI * 2) / 5);
                        ctx.beginPath();
                        ctx.ellipse(0, -s * 0.95, s * 0.48, s * 0.85, 0, 0, Math.PI * 2);
                        ctx.fillStyle = '#fbcfe8';
                        ctx.fill();
                        ctx.restore();
                    }
                    ctx.beginPath();
                    ctx.arc(0, 0, s * 0.38, 0, Math.PI * 2);
                    ctx.fillStyle = '#fef08a';
                    ctx.fill();
                } else {
                    // ✨ Rocío de polen dorado suave
                    const s = this.size * 0.45;
                    ctx.beginPath();
                    ctx.arc(0, 0, s, 0, Math.PI * 2);
                    const grad = ctx.createRadialGradient(0, 0, 0, 0, 0, s);
                    grad.addColorStop(0, '#ffffff');
                    grad.addColorStop(0.5, '#fef08a');
                    grad.addColorStop(1, '#f472b6');
                    ctx.fillStyle = grad;
                    ctx.shadowColor = 'rgba(212, 175, 55, 0.55)';
                    ctx.shadowBlur = 7;
                    ctx.fill();
                }
                ctx.restore();
            }
        }

        if (canvas) {
            ctx = canvas.getContext('2d');
            function resizeCanvas() {
                const rect = gardenRealm.getBoundingClientRect();
                if (rect.width > 0 && rect.height > 0) {
                    canvasW = canvas.width = Math.round(rect.width);
                    canvasH = canvas.height = Math.round(rect.height);
                }
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            function initPetals(count = 36) {
                petals = [];
                for (let i = 0; i < count; i++) {
                    petals.push(new FloralParticle());
                }
            }
            initPetals(36);

            gardenRealm.addEventListener('mousemove', (e) => {
                const rect = gardenRealm.getBoundingClientRect();
                const curX = e.clientX - rect.left;
                const curY = e.clientY - rect.top;
                cursorSpeedX = (curX - lastCursorX) * 0.3;
                cursorSpeedY = (curY - lastCursorY) * 0.3;
                lastCursorX = curX;
                lastCursorY = curY;
            });

            function renderPetals() {
                if (window.__gardenVisualEffectsOff) {
                    if (ctx && canvasW > 0 && canvasH > 0) ctx.clearRect(0, 0, canvasW, canvasH);
                    requestAnimationFrame(renderPetals);
                    return;
                }
                const isScreenActive = !gardenRealm.closest('.screen')?.hidden;
                if (isScreenActive && ctx) {
                    const rect = gardenRealm.getBoundingClientRect();
                    if (rect.width > 0 && (canvasW !== Math.round(rect.width) || canvasH !== Math.round(rect.height))) {
                        canvasW = canvas.width = Math.round(rect.width);
                        canvasH = canvas.height = Math.round(rect.height);
                    }
                    if (canvasW > 0 && canvasH > 0) {
                        ctx.clearRect(0, 0, canvasW, canvasH);
                        for (let p of petals) {
                            p.update(isBreezeIntense);
                            p.draw(ctx);
                        }
                    }
                }
                requestAnimationFrame(renderPetals);
            }
            requestAnimationFrame(renderPetals);
        }

        // 3. ILUMINACIÓN DE RAMAS, CÁPSULA EDITORIAL & POD ANTI-COLISIÓN EN HOVER
        const flowerNodes = gardenRealm.querySelectorAll('.living-flower-node');
        const radialBranches = gardenRealm.querySelectorAll('.radial-branch');

        // Referencias a la Cápsula Editorial Integrada
        const meiBar = document.getElementById('map-editorial-inspect-bar');
        const meiEmblem = document.getElementById('mei-emblem');
        const meiTitle = document.getElementById('mei-title');
        const meiBadge = document.getElementById('mei-badge');
        const meiQuote = document.getElementById('mei-quote');
        const meiHint = document.getElementById('mei-action-hint');

        function hideInspectPod() {
            if (!inspectPod) return;
            inspectPod.style.opacity = '0';
            inspectPod.hidden = true;
            inspectPod.classList.remove('is-below');
        }

        flowerNodes.forEach((node) => {
            const screenTarget = node.dataset.go;
            const noteFreq = parseFloat(node.dataset.note) || 523.25;
            const flowerName = node.dataset.flower || '';
            const tooltipText = node.dataset.tooltip || '';
            const emblem = node.querySelector('.place-symbol')?.textContent || '🌹';
            const title = node.querySelector('.flower-node-title')?.textContent || '';
            const cleanQuote = tooltipText.includes(': ') ? tooltipText.split(': ').slice(1).join(': ') : tooltipText;

            node.addEventListener('mouseenter', () => {
                // Iluminar enredadera conectada
                radialBranches.forEach(b => {
                    const match = b.dataset.branch === screenTarget;
                    b.classList.toggle('is-lit', match);
                });

                // Sonido armónico si está habilitado
                if (soundEnabled && typeof playSoftChime === 'function') {
                    playSoftChime(noteFreq);
                }

                // Actualizar Cápsula Editorial Integrada
                if (meiBar) {
                    meiBar.classList.add('is-active');
                    if (meiEmblem) meiEmblem.textContent = emblem;
                    if (meiTitle) meiTitle.textContent = title;
                    if (meiBadge) meiBadge.textContent = flowerName;
                    if (meiQuote) meiQuote.textContent = `«${cleanQuote}»`;
                    if (meiHint) meiHint.textContent = `Entrar a ${title} →`;
                }

                // Posicionar Pod Flotante con sistema Anti-Colisión
                if (inspectPod) {
                    if (podEmblem) podEmblem.textContent = emblem;
                    if (podTitle) podTitle.textContent = title;
                    if (podBiome) podBiome.textContent = flowerName;
                    if (podQuote) podQuote.textContent = `«${cleanQuote}»`;

                    const realmRect = gardenRealm.getBoundingClientRect();
                    const nodeRect = node.getBoundingClientRect();

                    const rawCenterX = (nodeRect.left + nodeRect.width / 2) - realmRect.left;
                    const nodeCenterY = (nodeRect.top + nodeRect.height / 2) - realmRect.top;

                    // Clamping horizontal para que nunca se corte en los bordes laterales
                    const marginX = 148;
                    const clampedX = Math.max(marginX, Math.min(realmRect.width - marginX, rawCenterX));

                    // Si el nodo está en la mitad superior del mapa, el globo abre HACIA ABAJO; si está abajo, HACIA ARRIBA
                    const openBelow = nodeCenterY < realmRect.height * 0.48;
                    inspectPod.classList.toggle('is-below', openBelow);

                    const posY = openBelow
                        ? (nodeRect.bottom - realmRect.top) + 10
                        : (nodeRect.top - realmRect.top) - 10;

                    inspectPod.style.left = `${clampedX}px`;
                    inspectPod.style.top = `${posY}px`;
                    inspectPod.hidden = false;
                    inspectPod.style.opacity = '1';
                }
            });

            node.addEventListener('mouseleave', () => {
                radialBranches.forEach(b => b.classList.remove('is-lit'));
                hideInspectPod();
            });
        });

        gardenRealm.addEventListener('mouseleave', () => {
            radialBranches.forEach(b => b.classList.remove('is-lit'));
            hideInspectPod();
            if (meiBar) {
                meiBar.classList.remove('is-active');
                if (meiEmblem) meiEmblem.textContent = '🌹';
                if (meiTitle) meiTitle.textContent = 'El Corazón del Jardín de Carla';
                if (meiBadge) meiBadge.textContent = 'GRAN ROSA IMPERIAL';
                if (meiQuote) meiQuote.textContent = '«Pasa el cursor sobre cualquier flor del mapa para iluminar su sendero y descubrir lo que guarda para ti.»';
                if (meiHint) meiHint.textContent = 'Explora los 11 rincones ✿';
            }
        });

        // 4. CONTROLES DE LA BARRA DE DINAMISMO

        // Floración Radiante (Bloom Wave)
        btnBloomWave?.addEventListener('click', () => {
            btnBloomWave.classList.add('is-active');
            gardenRealm.classList.add('garden-full-bloom');
            if (soundEnabled && typeof playSoftChime === 'function') {
                const chordNotes = [523.25, 659.25, 783.99, 1046.50, 1318.51, 1567.98];
                chordNotes.forEach((n, i) => setTimeout(() => playSoftChime(n), i * 110));
            }
            if (typeof showToast === 'function') {
                showToast('🌹 «¡La Gran Rosa Imperial despliega una cascada de pétalos y luz para ti, Carla!» ✨');
            }

            if (canvas) {
                const centerX = (canvasW || 500) * 0.5;
                const centerY = (canvasH || 320) * 0.5;
                for (let k = 0; k < 60; k++) {
                    const p = new FloralParticle();
                    p.x = centerX + (Math.random() - 0.5) * 50;
                    p.y = centerY + (Math.random() - 0.5) * 50;
                    const angle = Math.random() * Math.PI * 2;
                    const spd = Math.random() * 8 + 3;
                    p.vx = Math.cos(angle) * spd;
                    p.vy = Math.sin(angle) * spd;
                    p.size = Math.random() * 9 + 6;
                    petals.push(p);
                }
            }

            setTimeout(() => {
                gardenRealm.classList.remove('garden-full-bloom');
                btnBloomWave.classList.remove('is-active');
                if (!isBreezeIntense) {
                    petals = petals.slice(0, 36);
                }
            }, 2000);
        });

        // Alternar Brisa de Pétalos
        btnBreezeToggle?.addEventListener('click', () => {
            isBreezeIntense = !isBreezeIntense;
            gardenRealm.dataset.gardenBreeze = isBreezeIntense ? 'intense' : 'normal';
            if (labelBreeze) {
                labelBreeze.textContent = isBreezeIntense ? 'Torbellino de Pétalos' : 'Brisa de Pétalos';
            }
            btnBreezeToggle.classList.toggle('is-active', isBreezeIntense);

            if (isBreezeIntense) {
                while (petals.length < 85) {
                    petals.push(new FloralParticle());
                }
                if (soundEnabled && typeof playSoftChime === 'function') playSoftChime(783.99);
                if (typeof showToast === 'function') showToast('🌸 Brisa intensa de pétalos activa en el jardín');
            } else {
                petals = petals.slice(0, 36);
                if (typeof showToast === 'function') showToast('🌹 Brisa suave de pétalos restaurada');
            }
        });

        // Ciclo de Atmósferas Lumínicas
        btnWeatherCycle?.addEventListener('click', () => {
            currentAtmosphereIndex = (currentAtmosphereIndex + 1) % atmospheres.length;
            const current = atmospheres[currentAtmosphereIndex];
            gardenRealm.dataset.gardenAtmosphere = current.id;

            if (iconWeather) iconWeather.textContent = current.icon;
            if (labelWeather) labelWeather.textContent = current.label;

            btnWeatherCycle.classList.add('is-active');
            setTimeout(() => btnWeatherCycle.classList.remove('is-active'), 600);

            if (soundEnabled && typeof playSoftChime === 'function') {
                playSoftChime(current.id === 'night' ? 440.00 : (current.id === 'day' ? 987.77 : 659.25));
            }
            if (typeof showToast === 'function') {
                showToast(`${current.icon} Atmósfera: ${current.label}`);
            }
        });

        // Activar / Pausar Armonía
        btnSoundToggle?.addEventListener('click', () => {
            soundEnabled = !soundEnabled;
            btnSoundToggle.classList.toggle('is-active', soundEnabled);
            if (labelSound) {
                labelSound.textContent = soundEnabled ? 'Armonía Activa' : 'Armonía en Pausa';
            }
            if (soundEnabled && typeof playSoftChime === 'function') {
                playSoftChime(659.25);
            }
            if (typeof showToast === 'function') {
                showToast(soundEnabled ? '🌷 Armonía del jardín activada' : '🔇 Armonía en silencio');
            }
        });

        // Clic en el Gran Prisma Central de Carla
        const centerPrismTrigger = document.getElementById('map-center-rose-trigger');
        centerPrismTrigger?.addEventListener('click', () => {
            btnBloomWave?.click();
        });

        // 5. GIRO DE LUZ SECUENCIAL POR LOS MEDALLONES (CADA 3 SEGUNDOS)
        let rotatingIndex = 0;
        let isUserHoveringMap = false;

        const allMapMedallions = [
            ...Array.from(flowerNodes),
            centerPrismTrigger
        ].filter(Boolean);

        function triggerSequentialMedallionGleam() {
            // Si la usuaria está interactuando con el puntero en el mapa o la pantalla no está activa, pausar el ciclo automático
            const isMapActive = !gardenRealm.closest('.screen')?.hidden;
            if (!isMapActive || isUserHoveringMap || allMapMedallions.length === 0) {
                return;
            }

            // Remover el brillo del nodo anterior
            allMapMedallions.forEach(m => {
                m.classList.remove('sunlit-active', 'is-rotating-active');
            });

            // Activar el nodo actual en la órbita
            const currentNode = allMapMedallions[rotatingIndex];
            if (currentNode) {
                currentNode.classList.add('sunlit-active', 'is-rotating-active');

                // Si es un nodo de flor, iluminar sutilmente su enredadera conectada
                const screenTarget = currentNode.dataset?.go;
                if (screenTarget) {
                    radialBranches.forEach(b => {
                        b.classList.toggle('is-lit', b.dataset.branch === screenTarget);
                    });
                } else {
                    radialBranches.forEach(b => b.classList.remove('is-lit'));
                }
            }

            rotatingIndex = (rotatingIndex + 1) % allMapMedallions.length;
        }

        // Detectar si la usuaria está interactuando para cederle el control
        gardenRealm.addEventListener('mouseenter', () => {
            isUserHoveringMap = true;
            allMapMedallions.forEach(m => m.classList.remove('sunlit-active', 'is-rotating-active'));
        });

        gardenRealm.addEventListener('mouseleave', () => {
            isUserHoveringMap = false;
        });

        // Iniciar intervalo de 3 segundos
        const medallionGleamTimer = setInterval(triggerSequentialMedallionGleam, 3000);
        window.addEventListener('beforeunload', () => clearInterval(medallionGleamTimer));
    })();

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


/* --- Rincón de Lectura Dinámico (Cambio Diario Automático + Aleatorio) --- */
function initReadingNook() {
    const famousQuotes = [
        { id: 'q1', topic: 'amor', badge: 'FRASE CÉLEBRE · AUTENTICIDAD', title: 'La belleza de ser auténtica', text: '«La belleza comienza en el instante en que decides ser tú misma.»', author: '— Coco Chanel', reflection: '«Las palabras que te elevan son las que más te pertenecen.»' },
        { id: 'q2', topic: 'naturaleza', badge: 'FRASE CÉLEBRE · ESPERANZA', title: 'Sembrar el mañana', text: '«Plantar un jardín es creer en el mañana.»', author: '— Audrey Hepburn', reflection: '«Cada semilla cuidada con amor transforma el paisaje de los días.»' },
        { id: 'q3', topic: 'sabiduria', badge: 'FRASE CÉLEBRE · FORTALEZA INTERIOR', title: 'El verano invencible', text: '«En medio del invierno, aprendí por fin que había en mí un verano invencible.»', author: '— Albert Camus', reflection: '«Tu luz interior siempre es más cálida que cualquier tormenta.»' },
        { id: 'q4', topic: 'naturaleza', badge: 'FRASE CÉLEBRE · JARDÍN & VIDA', title: 'Donde florece la esperanza', text: '«Donde florecen las flores, florece también la esperanza.»', author: '— Lady Bird Johnson', reflection: '«Un rincón florido basta para recordar la bondad del mundo.»' },
        { id: 'q5', topic: 'literatura', badge: 'FRASE CÉLEBRE · ARTE & VUELO', title: 'Alas para volar', text: '«Pies, ¿para qué los quiero si tengo alas para volar?»', author: '— Frida Kahlo', reflection: '«La imaginación y la sensibilidad no conocen fronteras.»' },
        { id: 'q6', topic: 'sabiduria', badge: 'FRASE CÉLEBRE · PAZ INTERIOR', title: 'El refugio de la serenidad', text: '«La paz viene de adentro. No la busques afuera.»', author: '— Buda', reflection: '«Cuando el corazón está en calma, todo alrededor armoniza.»' },
        { id: 'q7', topic: 'literatura', badge: 'FRASE CÉLEBRE · LIBERTAD CREATIVA', title: 'La llave de tu propio pensamiento', text: '«No hay barrera, cerradura ni cerrojo que puedas imponer a la libertad de mi mente.»', author: '— Virginia Woolf', reflection: '«Un espíritu libre convierte cada lectura en un universo infinito.»' },
        { id: 'q8', topic: 'amor', badge: 'FRASE CÉLEBRE · LUZ PROPIA', title: 'Dejar entrar la luz', text: '«La herida es el lugar por donde entra la luz.»', author: '— Rumi', reflection: '«Todo aprendizaje sincero hace más luminosa nuestra mirada.»' },
        { id: 'q9', topic: 'literatura', badge: 'FRASE CÉLEBRE · MEMORIA VIVA', title: 'Los recuerdos del corazón', text: '«La vida no es la que uno vivió, sino la que uno recuerda y cómo la recuerda para contarla.»', author: '— Gabriel García Márquez', reflection: '«Atesorar momentos hermosos es vivirlos dos veces.»' },
        { id: 'q10', topic: 'naturaleza', badge: 'FRASE CÉLEBRE · PRIMAVERA ETERNA', title: 'Las flores del porvenir', text: '«Podrán cortar todas las flores, pero no podrán detener la primavera.»', author: '— Pablo Neruda', reflection: '«El renacer de la alegría siempre encuentra su camino.»' },
        { id: 'q11', topic: 'amor', badge: 'FRASE CÉLEBRE · TERNURA', title: 'Defender la alegría', text: '«Defender la alegría como una trinchera, defenderla del caos y de las pesadillas.»', author: '— Mario Benedetti', reflection: '«Tu sonrisa es el tesoro más noble de este jardín, Carla Lorena.»' },
        { id: 'q12', topic: 'sabiduria', badge: 'FRASE CÉLEBRE · GRATITUD', title: 'La dicha de lo cotidiano', text: '«No es más feliz quien más tiene, sino quien menos necesita y más agradece.»', author: '— Séneca', reflection: '«En los detalles sencillos reside la verdadera fortuna.»' },
        { id: 'q13', topic: 'literatura', badge: 'FRASE CÉLEBRE · SENSIBILIDAD', title: 'El encanto de las cosas bellas', text: '«No hay encanto igual a la ternura del corazón.»', author: '— Jane Austen', reflection: '«La bondad sincera nunca pasa de moda.»' },
        { id: 'q14', topic: 'naturaleza', badge: 'FRASE CÉLEBRE · CONTEMPLACIÓN', title: 'El lenguaje secreto de la naturaleza', text: '«Mira profundamente en la naturaleza y entonces comprenderás todo mejor.»', author: '— Albert Einstein', reflection: '«El ritmo de las estaciones nos enseña paciencia y armonía.»' },
        { id: 'q15', topic: 'amor', badge: 'FRASE CÉLEBRE · ESENCIA', title: 'Brillar sin pedir permiso', text: '«Nada puede empañar la luz que brilla desde el interior.»', author: '— Maya Angelou', reflection: '«Quien camina con nobleza ilumina cada lugar que pisa.»' },
        { id: 'q16', topic: 'literatura', badge: 'FRASE CÉLEBRE · POESÍA', title: 'Habitar en la posibilidad', text: '«Para siempre está compuesto de muchos ahoras.»', author: '— Emily Dickinson', reflection: '«Cada instante presente es una página dorada por escribir.»' },
        { id: 'q17', topic: 'sabiduria', badge: 'FRASE CÉLEBRE · PROPÓSITO', title: 'La libertad de elegir nuestra actitud', text: '«Cuando ya no podemos cambiar una situación, tenemos el desafío de cambiarnos a nosotros mismos.»', author: '— Viktor Frankl', reflection: '«La serenidad es el arte de responder con gracia.»' },
        { id: 'q18', topic: 'amor', badge: 'FRASE CÉLEBRE · CORAZÓN VALIENTE', title: 'La valentía de sentir', text: '«Rara vez nos damos cuenta de que lo más extraordinario de la vida ocurre en la dulzura de un instante.»', author: '— Clarice Lispector', reflection: '«Dedicado a tu sensibilidad única, Carla Lorena.»' },
        { id: 'q19', topic: 'naturaleza', badge: 'FRASE CÉLEBRE · PERFUME DE ROSAS', title: 'El rastro de la bondad', text: '«Siempre queda un poco de fragancia en las manos que te entregan rosas.»', author: '— Proverbio Oriental', reflection: '«Todo gesto de cariño embellece a quien lo da y a quien lo recibe.»' },
        { id: 'q20', topic: 'sabiduria', badge: 'FRASE CÉLEBRE · ARMONÍA', title: 'La música del alma', text: '«La felicidad es cuando lo que piensas, lo que dices y lo que haces están en armonía.»', author: '— Mahatma Gandhi', reflection: '«Vivir en coherencia con el corazón trae paz duradera.»' }
    ];

    const classicWisdomGems = [
        { badge: 'JOYA LITERARIA · EL PRINCIPITO', eyebrow: 'CRÓNICA DE SABIDURÍA & CALMA', title: 'El secreto de las cosas esenciales', body: '«He aquí mi secreto, que no puede ser más simple: solo con el corazón se puede ver bien; lo esencial es invisible a los ojos.»', author: '— Antoine de Saint-Exupéry · El Principito', mini: '«El tiempo que dedicaste a tu rosa es lo que la hace tan importante.»' },
        { badge: 'JOYA LITERARIA · ORGULLO Y PREJUICIO', eyebrow: 'CLÁSICOS UNIVERSALES', title: 'El refugio de una buena lectura', body: '«Declaro que después de todo no hay placer comparable a la lectura. ¡Cuan pronto se cansa uno de cualquier otra cosa, menos de un libro!»', author: '— Jane Austen · Orgullo y Prejuicio', mini: '«Cada página leída en calma abre un jardín interior.»' },
        { badge: 'JOYA LITERARIA · EL JARDÍN SECRETO', eyebrow: 'LITERATURA BOTÁNICA', title: 'Donde nacen las rosas', body: '«Si miras de la forma correcta, puedes ver que todo el mundo es un jardín lleno de magia esperando florecer.»', author: '— Frances Hodgson Burnett · El Jardín Secreto', mini: '«Cuidar tus pensamientos es cultivar rosas en el alma.»' },
        { badge: 'JOYA LITERARIA · CIEN AÑOS DE SOLEDAD', eyebrow: 'REALISMO MÁGICO', title: 'El asombro de las cosas nuevas', body: '«Las cosas tienen vida propia; todo es cuestión de despertarles el ánima con una mirada llena de asombro.»', author: '— Gabriel García Márquez · Crónicas', mini: '«Nunca pierdas la capacidad de maravillarte, Carla Lorena.»' },
        { badge: 'JOYA LITERARIA · CARTAS A UN JOVEN POETA', eyebrow: 'FILOSOFÍA DE LA PACIENCIA', title: 'Vivir las preguntas con amor', body: '«Ten paciencia con todo lo que aún no está resuelto en tu corazón e intenta amar las preguntas mismas como cuartos cerrados o libros escritos en un idioma muy hermoso.»', author: '— Rainer Maria Rilke · Cartas a un joven poeta', mini: '«Todo florece cuando llega su estación precisa.»' },
        { badge: 'JOYA LITERARIA · MUJERCITAS', eyebrow: 'VALENTÍA & SUEÑOS', title: 'Aprender a navegar sin miedo', body: '«No tengo miedo de las tormentas, porque estoy aprendiendo a navegar mi propio barco con esperanza y alegría.»', author: '— Louisa May Alcott · Mujercitas', mini: '«Tu determinación tiene la dulzura y la fuerza de las mareas.»' },
        { badge: 'JOYA LITERARIA · WALDEN', eyebrow: 'VIDA SERENA & NATURALEZA', title: 'Despertar a la belleza del presente', body: '«Debemos aprender a despertar y mantenernos despiertos, no por ayuda mecánica, sino por una infinita expectativa del amanecer.»', author: '— Henry David Thoreau · Walden', mini: '«Cada mañana trae una promesa nueva entre las hojas.»' },
        { badge: 'JOYA LITERARIA · EL PROFETA', eyebrow: 'POESÍA FILOSÓFICA', title: 'La belleza en el espejo del corazón', body: '«La belleza no está en el rostro; la belleza es una luz que habita en la bondad del corazón.»', author: '— Khalil Gibran · El Profeta', mini: '«Tu nobleza ilumina todo lo que te rodea.»' }
    ];

    const botanicalNotesPool = [
        { badge: 'NOTA · DEDICADA', pin: '🌹', title: 'Sobre florecer a tu propio ritmo', body: '«Las flores jamás compiten con la flor vecina; simplemente despliegan su esplendor. Jamás olvides el inmenso valor que guarda tu propio proceso.»', author: 'Para Carla · Con infinita ternura' },
        { badge: 'NOTA · SERENIDAD', pin: '🌷', title: 'La paz de los instantes lentos', body: '«Una infusión tibia, una mirada al horizonte al atardecer y unos minutos sin urgencias. En la sencillez noble habita la plenitud.»', author: 'Rincón de Lectura · Atelier' },
        { badge: 'NOTA · LUZ PROPIA', pin: '🌸', title: 'Tu brillo inconfundible', body: '«Hay personas que dejan una estela inolvidable con solo sonreír, por su nobleza pura y su calidez de corazón. Tú iluminas este espacio, Carla.»', author: 'El Jardín Secreto · Carla Lorena' },
        { badge: 'NOTA · GRATITUD', pin: '🌺', title: 'El arte de agradecer hoy', body: '«Cuando miras el día con gratitud, hasta la brisa más suave se convierte en una caricia inolvidable para el espíritu.»', author: 'Cuaderno Botánico · Edición Viva' },
        { badge: 'NOTA · CONFIANZA', pin: '🌻', title: 'Siempre mirando hacia el sol', body: '«Como los girasoles en la pradera, orienta tus pensamientos hacia lo que te da alegría, calma y esperanza verdadera.»', author: 'Herbario de Luz · Para Carla' },
        { badge: 'NOTA · SUEÑOS', pin: '🪷', title: 'La semilla de tus anhelos', body: '«Todo gran sueño comenzó siendo un destello silencioso en el corazón. Cuídalo con paciencia, porque está destinado a florecer.»', author: 'Archivo de Inspiración · Atelier' },
        { badge: 'NOTA · DULZURA', pin: '🌹', title: 'Ser amable contigo misma', body: '«Háblate siempre con la misma ternura con la que cuidarías la rosa más delicada del jardín. Mereces toda tu propia compasión.»', author: 'Refugio Interior · Carla Lorena' },
        { badge: 'NOTA · ARMONÍA', pin: '🌿', title: 'Soltar lo que pesa', body: '«Los árboles dejan caer sus hojas en otoño sin temor, sabiendo que la próxima primavera volverán a vestirse de vida.»', author: 'Sabiduría de las Estaciones' },
        { badge: 'NOTA · ALEGRÍA', pin: '🌷', title: 'Coleccionar momentos dorados', body: '«Al final del día, lo que más abriga el alma son las risas sinceras, los abrazos honestos y la paz de estar en casa.»', author: 'Memoria Viva · El Jardín' }
    ];

    const poemsPool = [
        {
            title: 'Canto al Atardecer',
            mood: 'Para leer con una taza de té y silencio amable',
            stanza1: '«Hay jardines que nacen en la tierra,<br>y otros que florecen en la mirada.<br>Tú llevas contigo la primavera eterna,<br>la risa clara y la paz guardada.»',
            stanza2: '«Que ningún invierno apague tu calidez,<br>que los senderos te sean siempre amables,<br>y que al volver aquí encuentres otra vez,<br>motivos para soñar inagotables.»',
            signature: 'Escrito con amor para Carla Lorena'
        },
        {
            title: 'Soneto de las Rosas de Abril',
            mood: 'Versos de luz para comenzar el día con esperanza',
            stanza1: '«Entre pétalos suaves despierta la mañana,<br>bordando de carmín la brisa del vergel,<br>y cada flor pronuncia tu nombre en la ventana,<br>con tinta de rocío y aromas de laurel.»',
            stanza2: '«Camina sin premura por tu sendero claro,<br>que el cielo guarda estrellas para tu caminar;<br>en este jardín vivo tendrás siempre un amparo,<br>donde tu corazón pueda siempre brillar.»',
            signature: 'Pergamino del Jardín · Edición del Día'
        },
        {
            title: 'Balada del Agua Serena',
            mood: 'Lectura pausada para tardes de lluvia o sosiego',
            stanza1: '«Como el arroyo manso que besa la pradera,<br>así fluya la calma dentro de tu interior;<br>que nada te apresure, que todo cuanto espera<br>madure al dulce abrigo de tu propio esplendor.»',
            stanza2: '«Respira hondo el presente, contempla lo vivido,<br>agradece los pasos que te han traído aquí;<br>en cada rincón noble de este jardín querido,<br>florece una alegría pensada para ti.»',
            signature: 'Caligrafía Botánica · Para Carla Lorena'
        },
        {
            title: 'Nocturno de los Luceros',
            mood: 'Para leer bajo la calma de las constelaciones',
            stanza1: '«Cuando la noche tiende su manto de terciopelo,<br>y encienden las estrellas su lámpara inmortal,<br>un murmullo de rosas se eleva hasta el cielo<br>cuidando tus anhelos con celo de cristal.»',
            stanza2: '«Descansa en la certeza de todo lo que vales,<br>de la bondad sincera que habita en tu mirar;<br>mañana el sol de oro abrirá los rosales<br>para verte de nuevo sonreír y soñar.»',
            signature: 'Antología Nocturna · El Jardín de Carla'
        },
        {
            title: 'Oda a los Caminos Nuevos',
            mood: 'Inspiración viva para abrazar nuevos comienzos',
            stanza1: '«No temas a la senda que aún no has recorrido,<br>pues cada paso firme despierta una canción;<br>el viento va barriendo las hojas del olvido<br>y siembra primaveras en tu imaginación.»',
            stanza2: '«Avanza con la gracia de quien confía y cree,<br>llevando por bandera tu noble claridad;<br>que todo cuanto sueñes y tu corazón desee<br>encuentre su camino hacia la realidad.»',
            signature: 'Colección de Autor · Carla Lorena'
        }
    ];

    // Semilla diaria basada en la fecha local (cambia automáticamente todos los días)
    const now = new Date();
    const dateKey = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;
    let daySeed = 0;
    for (let i = 0; i < dateKey.length; i++) {
        daySeed = (daySeed * 31 + dateKey.charCodeAt(i)) >>> 0;
    }

    const dailyDateBadge = document.getElementById('library-daily-date-badge');
    if (dailyDateBadge) {
        const formattedDate = now.toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' });
        dailyDateBadge.textContent = `EDICIÓN DE HOY · ${formattedDate.toUpperCase()}`;
    }

    const FAV_STORAGE_KEY = 'carla_library_fav_quotes_v1';
    function getFavIds() {
        try {
            return JSON.parse(localStorage.getItem(FAV_STORAGE_KEY) || '[]');
        } catch (_) {
            return [];
        }
    }
    function saveFavIds(ids) {
        try {
            localStorage.setItem(FAV_STORAGE_KEY, JSON.stringify(ids));
        } catch (_) {}
        updateFavCountUI();
    }
    function updateFavCountUI() {
        const favCountEl = document.getElementById('library-fav-count');
        if (favCountEl) {
            favCountEl.textContent = `(${getFavIds().length})`;
        }
    }

    let currentTopic = 'todas';
    let currentQuote = famousQuotes[daySeed % famousQuotes.length];
    let currentWisdomIndex = daySeed % classicWisdomGems.length;
    let currentNotesOffset = daySeed % botanicalNotesPool.length;
    let currentPoemIndex = daySeed % poemsPool.length;

    function getFilteredQuotes() {
        if (currentTopic === 'todas') return famousQuotes;
        if (currentTopic === 'favoritas') {
            const favs = getFavIds();
            const list = famousQuotes.filter(q => favs.includes(q.id));
            return list.length > 0 ? list : famousQuotes;
        }
        return famousQuotes.filter(q => q.topic === currentTopic);
    }

    function renderQuote(quote, animate = true) {
        if (!quote) return;
        currentQuote = quote;
        const card = document.getElementById('daily-quote-card');
        const badgeEl = document.getElementById('quote-category-badge');
        const titleEl = document.getElementById('quote-title');
        const textEl = document.getElementById('quote-text');
        const authorEl = document.getElementById('quote-author');
        const reflectionEl = document.getElementById('quote-reflection');
        const favBtn = document.getElementById('fav-quote-btn');
        const favIcon = document.getElementById('fav-quote-icon');
        const favLabel = document.getElementById('fav-quote-label');

        const applyContent = () => {
            if (badgeEl) badgeEl.textContent = quote.badge;
            if (titleEl) titleEl.textContent = quote.title;
            if (textEl) textEl.textContent = quote.text;
            if (authorEl) authorEl.textContent = quote.author;
            if (reflectionEl) reflectionEl.textContent = quote.reflection;

            const isFav = getFavIds().includes(quote.id);
            if (favBtn) favBtn.setAttribute('aria-pressed', String(isFav));
            if (favIcon) favIcon.textContent = isFav ? '♥' : '♡';
            if (favLabel) favLabel.textContent = isFav ? 'Guardada' : 'Guardar';
        };

        if (animate && card) {
            card.classList.add('is-transitioning-card');
            setTimeout(() => {
                applyContent();
                card.classList.remove('is-transitioning-card');
            }, 160);
        } else {
            applyContent();
        }
    }

    function renderWisdom(index, animate = true) {
        const gem = classicWisdomGems[index % classicWisdomGems.length];
        if (!gem) return;
        const card = document.getElementById('daily-wisdom-card');
        const applyContent = () => {
            const badge = document.getElementById('wisdom-badge');
            const eyebrow = document.getElementById('wisdom-eyebrow');
            const title = document.getElementById('wisdom-title');
            const body = document.getElementById('wisdom-body');
            const author = document.getElementById('wisdom-author');
            const mini = document.getElementById('wisdom-mini');
            if (badge) badge.textContent = gem.badge;
            if (eyebrow) eyebrow.textContent = gem.eyebrow;
            if (title) title.textContent = gem.title;
            if (body) body.textContent = gem.body;
            if (author) author.textContent = gem.author;
            if (mini) mini.textContent = gem.mini;
        };
        if (animate && card) {
            card.classList.add('is-transitioning-card');
            setTimeout(() => {
                applyContent();
                card.classList.remove('is-transitioning-card');
            }, 160);
        } else {
            applyContent();
        }
    }

    function renderNotes(offset, animate = true) {
        const slots = document.querySelectorAll('[data-note-slot]');
        slots.forEach((slot, idx) => {
            const note = botanicalNotesPool[(offset + idx) % botanicalNotesPool.length];
            if (!note) return;
            const applyNote = () => {
                const badge = slot.querySelector('[data-note-badge]');
                const pin = slot.querySelector('.note-pin');
                const title = slot.querySelector('[data-note-title]');
                const body = slot.querySelector('[data-note-body]');
                const author = slot.querySelector('[data-note-author]');
                if (badge) badge.textContent = note.badge;
                if (pin) pin.textContent = note.pin;
                if (title) title.textContent = note.title;
                if (body) body.textContent = note.body;
                if (author) author.textContent = note.author;
            };
            if (animate) {
                slot.classList.add('is-transitioning-card');
                setTimeout(() => {
                    applyNote();
                    slot.classList.remove('is-transitioning-card');
                }, 160);
            } else {
                applyNote();
            }
        });
    }

    function renderPoem(index, animate = true) {
        const poem = poemsPool[index % poemsPool.length];
        if (!poem) return;
        const card = document.getElementById('dynamic-poem-card');
        const applyPoem = () => {
            const title = document.getElementById('poem-title');
            const mood = document.getElementById('poem-mood');
            const s1 = document.getElementById('poem-stanza-1');
            const s2 = document.getElementById('poem-stanza-2');
            const sig = document.getElementById('poem-signature');
            if (title) title.textContent = poem.title;
            if (mood) mood.textContent = poem.mood;
            if (s1) s1.innerHTML = poem.stanza1;
            if (s2) s2.innerHTML = poem.stanza2;
            if (sig) sig.textContent = poem.signature;
        };
        if (animate && card) {
            card.classList.add('is-transitioning-card');
            setTimeout(() => {
                applyPoem();
                card.classList.remove('is-transitioning-card');
            }, 160);
        } else {
            applyPoem();
        }
    }

    // Inicializar con la Selección del Día automática
    updateFavCountUI();
    renderQuote(currentQuote, false);
    renderWisdom(currentWisdomIndex, false);
    renderNotes(currentNotesOffset, false);
    renderPoem(currentPoemIndex, false);

    // Eventos de botones interactivos
    document.getElementById('next-quote-btn')?.addEventListener('click', () => {
        const pool = getFilteredQuotes();
        const others = pool.filter(q => q.id !== currentQuote?.id);
        const next = others.length > 0
            ? others[Math.floor(Math.random() * others.length)]
            : pool[0];
        renderQuote(next, true);
    });

    document.getElementById('fav-quote-btn')?.addEventListener('click', () => {
        if (!currentQuote) return;
        const favs = getFavIds();
        const idx = favs.indexOf(currentQuote.id);
        if (idx >= 0) {
            favs.splice(idx, 1);
            showToast('Frase retirada de tus favoritas');
        } else {
            favs.push(currentQuote.id);
            showToast('♥ Frase célebre guardada en tus favoritas');
        }
        saveFavIds(favs);
        renderQuote(currentQuote, false);
    });

    document.getElementById('copy-quote-btn')?.addEventListener('click', () => {
        if (!currentQuote) return;
        const fullText = `${currentQuote.text} ${currentQuote.author}`;
        navigator.clipboard?.writeText(fullText).then(() => {
            showToast('📋 Frase célebre copiada al portapapeles');
        }).catch(() => {
            showToast('📋 ' + fullText);
        });
    });

    document.getElementById('next-wisdom-btn')?.addEventListener('click', () => {
        let nextIdx = Math.floor(Math.random() * classicWisdomGems.length);
        if (nextIdx === currentWisdomIndex) {
            nextIdx = (currentWisdomIndex + 1) % classicWisdomGems.length;
        }
        currentWisdomIndex = nextIdx;
        renderWisdom(currentWisdomIndex, true);
    });

    document.getElementById('shuffle-notes-btn')?.addEventListener('click', () => {
        currentNotesOffset = (currentNotesOffset + 1 + Math.floor(Math.random() * (botanicalNotesPool.length - 1))) % botanicalNotesPool.length;
        renderNotes(currentNotesOffset, true);
        showToast('🌹 Notas del corazón renovadas al azar');
    });

    document.getElementById('next-poem-btn')?.addEventListener('click', () => {
        let nextIdx = Math.floor(Math.random() * poemsPool.length);
        if (nextIdx === currentPoemIndex) {
            nextIdx = (currentPoemIndex + 1) % poemsPool.length;
        }
        currentPoemIndex = nextIdx;
        renderPoem(currentPoemIndex, true);
        showToast('❦ Nuevo poema desplegado en el pergamino');
    });

    document.getElementById('library-randomize-all-btn')?.addEventListener('click', () => {
        const pool = getFilteredQuotes();
        const others = pool.filter(q => q.id !== currentQuote?.id);
        renderQuote(others.length > 0 ? others[Math.floor(Math.random() * others.length)] : pool[0], true);

        currentWisdomIndex = (currentWisdomIndex + 1 + Math.floor(Math.random() * (classicWisdomGems.length - 1))) % classicWisdomGems.length;
        renderWisdom(currentWisdomIndex, true);

        currentNotesOffset = (currentNotesOffset + 2 + Math.floor(Math.random() * (botanicalNotesPool.length - 2))) % botanicalNotesPool.length;
        renderNotes(currentNotesOffset, true);

        currentPoemIndex = (currentPoemIndex + 1 + Math.floor(Math.random() * (poemsPool.length - 1))) % poemsPool.length;
        renderPoem(currentPoemIndex, true);

        const statusEl = document.getElementById('library-edition-status');
        if (statusEl) {
            statusEl.textContent = 'MODO EXPLORACIÓN ALEATORIA ACTIVO · DESCUBRIENDO NUEVAS JOYAS';
        }
        showToast('✨ Toda la Biblioteca se ha renovado con una selección aleatoria');
    });

    document.querySelectorAll('[data-quote-topic]').forEach((chip) => {
        chip.addEventListener('click', () => {
            const topic = chip.dataset.quoteTopic || 'todas';
            if (topic === 'favoritas' && getFavIds().length === 0) {
                showToast('♡ Aún no tienes frases guardadas. Pulsa "Guardar" en tu frase favorita.');
                return;
            }
            currentTopic = topic;
            document.querySelectorAll('[data-quote-topic]').forEach((btn) => {
                const active = btn === chip;
                btn.classList.toggle('is-selected', active);
                btn.setAttribute('aria-pressed', String(active));
            });
            const pool = getFilteredQuotes();
            renderQuote(pool[Math.floor(Math.random() * pool.length)], true);
        });
    });

    window._stopAppRelaxMelody = function() {};
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
        if (window.__gardenVisualEffectsOff) {
            ctx.clearRect(0,0,gc.width,gc.height);
            rafId = requestAnimationFrame(loop);
            return;
        }
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
        const currentHash = (window.location.hash || '').replace(/^#/, '').trim();
        const isHomeEntry = !currentHash || currentHash === 'inicio';
        const hasFormToast = Boolean(document.querySelector('.toast.is-visible'));

        if ((!isHomeEntry || hasFormToast) && sessionStorage.getItem(SPLASH_SESSION_KEY)) {
            splashEl.remove();
            return;
        }

        splashEl.style.removeProperty('display');

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

        // Efecto 3D Tilt interactivo al mover el ratón sobre la tarjeta Glassmorphism
        if (cardEl) {
            cardEl.addEventListener('mousemove', function(e) {
                const rect = cardEl.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                const tiltX = (y / (rect.height / 2)) * -6;
                const tiltY = (x / (rect.width / 2)) * 6;
                cardEl.style.transform = `perspective(1000px) rotateX(${tiltX.toFixed(2)}deg) rotateY(${tiltY.toFixed(2)}deg) translateY(-2px)`;

                // Desplazar ligeramente las mariposas para efecto de paralaje vivo
                const bf1 = cardEl.querySelector('.bf-top-left');
                const bf2 = cardEl.querySelector('.bf-bottom-right');
                if (bf1) bf1.style.transform = `translate(${x * 0.04}px, ${y * 0.04}px) rotate(-18deg)`;
                if (bf2) bf2.style.transform = `translate(${x * -0.04}px, ${y * -0.04}px) rotate(24deg)`;
            });

            cardEl.addEventListener('mouseleave', function() {
                cardEl.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0)';
                const bf1 = cardEl.querySelector('.bf-top-left');
                const bf2 = cardEl.querySelector('.bf-bottom-right');
                if (bf1) bf1.style.transform = 'rotate(-18deg)';
                if (bf2) bf2.style.transform = 'rotate(24deg)';
            });
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
        let dock = document.getElementById('floating-dock-right');
        if (!dock && document.body) {
            dock = document.createElement('div');
            dock.id = 'floating-dock-right';
            dock.className = 'floating-dock-right';
            dock.setAttribute('aria-label', 'Controles Flotantes del Jardín');
            document.body.appendChild(dock);
        }
        if (dock) {
            dock.appendChild(btn);
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
    let flowers = [];

    function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
        if (Array.isArray(flowers) && flowers.length > 0) {
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

    flowers = createStaticFlowers();

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


// ── Estados Efímeros 24h Estilo WhatsApp con Autoajuste Inteligente ──────────
function initGardenStatuses24h() {
    const section = document.getElementById('home-statuses-section');
    const strip = document.getElementById('home-statuses-strip');
    if (!section || !strip) return;

    const isAdmin = section.dataset.isAdmin === '1';
    const countPill = document.getElementById('home-statuses-count-pill');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Elementos del Modal de Subida (Admin)
    const uploadDialog = document.getElementById('garden-status-upload-dialog');
    const uploadForm = document.getElementById('garden-status-upload-form');
    const fileInput = document.getElementById('status-upload-input');
    const captionInput = document.getElementById('status-upload-caption');
    const emptyDropzone = document.getElementById('status-dropzone-empty');
    const previewStage = document.getElementById('status-live-preview-stage');
    const previewBlurBg = document.getElementById('status-preview-blur-bg');
    const previewMainImg = document.getElementById('status-preview-main-img');
    const previewCountBadge = document.getElementById('status-preview-count-badge');
    const submitBtn = document.getElementById('btn-submit-status-upload');

    // Elementos del Visor estilo WhatsApp
    const viewerDialog = document.getElementById('garden-status-viewer-dialog');
    const progressTrack = document.getElementById('status-viewer-progress-track');
    const viewerTime = document.getElementById('status-viewer-time');
    const viewerBackdrop = document.getElementById('status-viewer-backdrop-blur');
    const viewerPhoto = document.getElementById('status-viewer-main-photo');
    const viewerCaption = document.getElementById('status-viewer-caption');
    const viewerFooter = document.getElementById('status-viewer-footer');
    const btnPause = document.getElementById('btn-status-viewer-pause');
    const btnDeleteInViewer = document.getElementById('btn-status-viewer-delete');
    const btnCloseViewer = document.getElementById('btn-status-viewer-close');
    const btnPrev = document.getElementById('btn-status-prev');
    const btnNext = document.getElementById('btn-status-next');

    const STORY_DURATION_MS = 6000; // 6 segundos por estado
    let currentIndex = 0;
    let isPaused = false;
    let progressPct = 0;
    let rafId = null;
    let lastTick = 0;

    const emptyMsg = document.getElementById('home-statuses-empty-msg');

    function getActiveCards() {
        return Array.from(strip.querySelectorAll('.status-active-item'));
    }

    function syncSectionVisibility() {
        const now = Date.now();
        getActiveCards().forEach((card) => {
            const exp = Date.parse(card.dataset.expiresAt || '');
            if (!Number.isNaN(exp) && exp <= now) {
                card.remove();
            }
        });

        const remainingCards = getActiveCards();
        const count = remainingCards.length;
        if (countPill) {
            countPill.textContent = `${count} ${count === 1 ? 'estado activo' : 'estados activos'}`;
        }

        if (emptyMsg) {
            emptyMsg.hidden = count > 0;
        }
        section.hidden = false;
    }

    // Construir HTML de una tarjeta de estado recién subida
    function createStatusCardElement(st) {
        const article = document.createElement('article');
        article.className = 'status-story-card status-active-item';
        article.setAttribute('role', 'button');
        article.setAttribute('tabindex', '0');
        article.dataset.statusId = st.id;
        article.dataset.imageUrl = st.image_url;
        article.dataset.caption = st.caption || '';
        article.dataset.timeAgo = st.time_ago || 'Justo ahora';
        article.dataset.remaining = st.remaining_label || '24h';
        article.dataset.expiresAt = st.expires_at_iso || '';
        article.setAttribute('aria-label', `Ver estado de Carla: ${st.caption || 'Instante del jardín'}`);

        const safeCaption = (st.caption || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        article.innerHTML = `
            <div class="status-card-bg-blur" style="background-image: url('${st.image_url}');"></div>
            <img class="status-card-img" src="${st.image_url}" alt="${safeCaption || 'Estado del jardín'}" loading="lazy">
            <div class="status-card-shade"></div>
            <div class="status-card-top">
                <span class="status-ring-avatar" aria-hidden="true">
                    <span class="status-ring-inner">🌹</span>
                </span>
                <span class="status-ttl-badge" title="Desaparece automáticamente a las 24 horas">⏳ ${st.remaining_label || '24h'}</span>
                ${isAdmin ? `<button type="button" class="status-card-delete-btn" data-delete-status="${st.id}" title="Eliminar este estado" aria-label="Eliminar estado">✕</button>` : ''}
            </div>
            <div class="status-card-bottom">
                ${safeCaption ? `<p class="status-card-caption">${safeCaption}</p>` : ''}
                <span class="status-card-time">${st.time_ago || 'Justo ahora'}</span>
            </div>
        `;
        return article;
    }

    // Abrir modal de subida (Admin)
    function openUploadModal() {
        if (!uploadDialog) return;
        uploadForm?.reset();
        if (emptyDropzone) emptyDropzone.hidden = false;
        if (previewStage) previewStage.hidden = true;
        if (typeof uploadDialog.showModal === 'function') {
            uploadDialog.showModal();
        } else {
            uploadDialog.setAttribute('open', '');
        }
    }

    function closeUploadModal() {
        if (!uploadDialog) return;
        if (typeof uploadDialog.close === 'function') {
            uploadDialog.close();
        } else {
            uploadDialog.removeAttribute('open');
        }
    }

    document.getElementById('btn-open-status-uploader')?.addEventListener('click', openUploadModal);
    document.getElementById('btn-header-add-status')?.addEventListener('click', openUploadModal);
    document.getElementById('btn-close-status-upload')?.addEventListener('click', closeUploadModal);
    document.getElementById('btn-cancel-status-upload')?.addEventListener('click', closeUploadModal);

    // Vista previa con Autoajuste Inteligente Dual al elegir imagen
    fileInput?.addEventListener('change', () => {
        const files = fileInput.files;
        if (!files || files.length === 0) {
            if (emptyDropzone) emptyDropzone.hidden = false;
            if (previewStage) previewStage.hidden = true;
            return;
        }
        const firstFile = files[0];
        const objectUrl = URL.createObjectURL(firstFile);
        if (previewBlurBg) previewBlurBg.style.backgroundImage = `url('${objectUrl}')`;
        if (previewMainImg) previewMainImg.src = objectUrl;
        if (previewCountBadge) {
            previewCountBadge.textContent = files.length === 1
                ? '✨ Autoajuste inteligente activo · Dura 24h'
                : `✨ ${files.length} imágenes seleccionadas · Autoajuste activo`;
        }
        if (emptyDropzone) emptyDropzone.hidden = true;
        if (previewStage) previewStage.hidden = false;
    });

    // Subir estado por AJAX y agregarlo al instante
    uploadForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!fileInput?.files?.length) return;

        const formData = new FormData();
        Array.from(fileInput.files).forEach((f) => formData.append('images[]', f));
        if (captionInput?.value?.trim()) {
            formData.append('caption', captionInput.value.trim());
        }

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Publicando estado...';
        }

        try {
            const res = await fetch('/admin/garden-statuses', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });
            const data = await res.json();
            if (res.ok && Array.isArray(data.statuses)) {
                data.statuses.forEach((st) => {
                    const cardEl = createStatusCardElement(st);
                    strip.appendChild(cardEl);
                });
                syncSectionVisibility();
                closeUploadModal();
            }
        } catch (err) {
            console.error('Error al publicar estado:', err);
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = '✨ Publicar por 24 horas';
            }
        }
    });

    // Eliminar un estado
    async function deleteStatusById(statusId) {
        if (!statusId) return;
        try {
            const res = await fetch(`/admin/garden-statuses/${statusId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            if (res.ok) {
                const targetCard = strip.querySelector(`.status-active-item[data-status-id="${statusId}"]`);
                targetCard?.remove();
                syncSectionVisibility();

                if (viewerDialog?.open) {
                    const cards = getActiveCards();
                    if (cards.length === 0) {
                        closeStatusViewer();
                    } else {
                        if (currentIndex >= cards.length) currentIndex = cards.length - 1;
                        renderViewerSlide(currentIndex);
                    }
                }
            }
        } catch (err) {
            console.error('Error al eliminar estado:', err);
        }
    }

    // ── VISOR DE ESTADOS ESTILO WHATSAPP ──
    function stopViewerLoop() {
        if (rafId) {
            cancelAnimationFrame(rafId);
            rafId = null;
        }
    }

    function updateProgressBarsUI() {
        if (!progressTrack) return;
        const fills = progressTrack.querySelectorAll('.status-progress-fill');
        fills.forEach((fill, idx) => {
            if (idx < currentIndex) {
                fill.style.width = '100%';
            } else if (idx > currentIndex) {
                fill.style.width = '0%';
            } else {
                fill.style.width = `${Math.min(100, Math.max(0, progressPct))}%`;
            }
        });
    }

    function viewerTick(ts) {
        if (!viewerDialog?.open) {
            stopViewerLoop();
            return;
        }
        if (!lastTick) lastTick = ts;
        const dt = ts - lastTick;
        lastTick = ts;

        if (!isPaused) {
            progressPct += (dt / STORY_DURATION_MS) * 100;
            updateProgressBarsUI();
            if (progressPct >= 100) {
                goNextSlide();
                return;
            }
        }
        rafId = requestAnimationFrame(viewerTick);
    }

    function renderViewerSlide(idx) {
        const cards = getActiveCards();
        if (cards.length === 0) {
            closeStatusViewer();
            return;
        }
        currentIndex = Math.max(0, Math.min(cards.length - 1, idx));
        const activeCard = cards[currentIndex];

        const imgUrl = activeCard.dataset.imageUrl || '';
        const caption = activeCard.dataset.caption || '';
        const timeAgo = activeCard.dataset.timeAgo || 'Justo ahora';
        const remaining = activeCard.dataset.remaining || '24h';

        // Construir segmentos de progreso estilo WhatsApp
        if (progressTrack) {
            progressTrack.innerHTML = cards
                .map(() => '<div class="status-progress-seg"><div class="status-progress-fill"></div></div>')
                .join('');
        }

        if (viewerBackdrop) viewerBackdrop.style.backgroundImage = `url('${imgUrl}')`;
        if (viewerPhoto) {
            viewerPhoto.src = imgUrl;
            viewerPhoto.alt = caption || 'Estado de Carla Lorena';
        }
        if (viewerTime) viewerTime.textContent = `${timeAgo} · ⏳ Expira en ${remaining}`;
        if (viewerCaption) viewerCaption.textContent = caption;
        if (viewerFooter) viewerFooter.hidden = !caption;

        progressPct = 0;
        isPaused = false;
        if (btnPause) btnPause.textContent = '⏸';
        updateProgressBarsUI();

        stopViewerLoop();
        lastTick = 0;
        rafId = requestAnimationFrame(viewerTick);
    }

    function openStatusViewer(startIndex = 0) {
        syncSectionVisibility();
        const cards = getActiveCards();
        if (!viewerDialog || cards.length === 0) return;

        if (!viewerDialog.open) {
            if (typeof viewerDialog.showModal === 'function') {
                viewerDialog.showModal();
            } else {
                viewerDialog.setAttribute('open', '');
            }
        }
        renderViewerSlide(startIndex);
    }

    function closeStatusViewer() {
        stopViewerLoop();
        if (!viewerDialog) return;
        if (typeof viewerDialog.close === 'function') {
            viewerDialog.close();
        } else {
            viewerDialog.removeAttribute('open');
        }
    }

    function goNextSlide() {
        const cards = getActiveCards();
        if (currentIndex + 1 < cards.length) {
            renderViewerSlide(currentIndex + 1);
        } else {
            closeStatusViewer();
        }
    }

    function goPrevSlide() {
        if (currentIndex > 0) {
            renderViewerSlide(currentIndex - 1);
        } else {
            renderViewerSlide(0);
        }
    }

    // Delegación de clics en la franja de estados
    strip.addEventListener('click', (e) => {
        const delBtn = e.target.closest('[data-delete-status]');
        if (delBtn) {
            e.stopPropagation();
            e.preventDefault();
            deleteStatusById(delBtn.dataset.deleteStatus);
            return;
        }

        const storyCard = e.target.closest('.status-active-item');
        if (storyCard) {
            const cards = getActiveCards();
            const idx = cards.indexOf(storyCard);
            if (idx !== -1) {
                openStatusViewer(idx);
            }
        }
    });

    btnCloseViewer?.addEventListener('click', closeStatusViewer);
    btnPrev?.addEventListener('click', (e) => { e.stopPropagation(); goPrevSlide(); });
    btnNext?.addEventListener('click', (e) => { e.stopPropagation(); goNextSlide(); });

    btnPause?.addEventListener('click', () => {
        isPaused = !isPaused;
        btnPause.textContent = isPaused ? '▶' : '⏸';
    });

    btnDeleteInViewer?.addEventListener('click', () => {
        const cards = getActiveCards();
        const activeCard = cards[currentIndex];
        if (activeCard?.dataset.statusId) {
            deleteStatusById(activeCard.dataset.statusId);
        }
    });

    // Mantener presionado sobre la imagen pausa el estado (como en WhatsApp)
    const viewerStage = document.getElementById('status-viewer-stage');
    viewerStage?.addEventListener('pointerdown', (e) => {
        if (e.target.closest('button')) return;
        isPaused = true;
        if (btnPause) btnPause.textContent = '▶';
    });
    viewerStage?.addEventListener('pointerup', (e) => {
        if (e.target.closest('button')) return;
        isPaused = false;
        if (btnPause) btnPause.textContent = '⏸';
    });

    // Vigilar cada 30s que los estados cumplidas sus 24h desaparezcan visualmente
    setInterval(syncSectionVisibility, 30000);
    syncSectionVisibility();
}

// ── Inicialización UX: Modo Museo y Pasaporte del Jardín ─────────────
function initAllModules() {
    const modules = [
        ['initNavbarAutoHover', initNavbarAutoHover],
        ['initCardsAutoHover', initCardsAutoHover],
        ['initMuseumLightbox', initMuseumLightbox],
        ['initGardenPassport', initGardenPassport],
        ['initFloatingSurprises', initFloatingSurprises],
        ['initFriendDedications', initFriendDedications],
        ['initHomeCardsAdmin', initHomeCardsAdmin],
        ['initSeasonalWeather', initSeasonalWeather],
        ['initSystemGuide', initSystemGuide],
        ['initDailyBloom', initDailyBloom],
        // ['initGlobalInteractiveGardenBackground', initGlobalInteractiveGardenBackground], // DESACTIVADO: flores de fondo
        ['initGardenStatuses24h', initGardenStatuses24h],
        ['initButtonRipples', initButtonRipples],
        ['initTiltAndSpringPhysics', initTiltAndSpringPhysics]
    ];

    for (const [name, fn] of modules) {
        try {
            if (typeof fn === 'function') fn();
        } catch (err) {
            console.error(`Error inicializando módulo ${name}:`, err);
        }
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllModules);
} else {
    initAllModules();
}



function initDiaryAtelier() {
    const titleInput = document.getElementById('diary-new-title');
    const categoryInput = document.getElementById('diary-new-category');
    const excerptInput = document.getElementById('diary-new-excerpt');
    const bodyInput = document.getElementById('diary-new-body');
    const wordCounter = document.getElementById('diary-word-counter');
    const searchInput = document.getElementById('diary-search-input');
    const searchEmpty = document.getElementById('diary-search-empty');

    function updateWordCounter() {
        if (!bodyInput || !wordCounter) return;
        const text = bodyInput.value.trim();
        const words = text ? text.split(/\s+/).length : 0;
        wordCounter.textContent = `${words} ${words === 1 ? 'palabra' : 'palabras'} · Privado`;
    }

    if (bodyInput) {
        bodyInput.addEventListener('input', updateWordCounter);
        updateWordCounter();
    }

    document.querySelectorAll('.diary-seed-chip').forEach((chip) => {
        chip.addEventListener('click', () => {
            if (titleInput && !titleInput.value.trim()) {
                titleInput.value = chip.dataset.diarySeedTitle || '';
            }
            if (categoryInput) {
                categoryInput.value = chip.dataset.diarySeedCategory || '';
            }
            if (excerptInput && !excerptInput.value.trim()) {
                excerptInput.value = chip.dataset.diarySeedExcerpt || '';
            }
            if (bodyInput) {
                const prompt = chip.dataset.diarySeedPrompt || '';
                if (!bodyInput.value.trim()) {
                    bodyInput.value = prompt;
                }
                bodyInput.focus();
                updateWordCounter();
            }
        });
    });

    document.querySelectorAll('.diary-mood-tag').forEach((tag) => {
        tag.addEventListener('click', () => {
            if (categoryInput) {
                categoryInput.value = tag.dataset.diaryMood || '';
            }
            document.querySelectorAll('.diary-mood-tag').forEach((t) => t.classList.remove('is-active'));
            tag.classList.add('is-active');
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            const cards = document.querySelectorAll('[data-diary-card]');
            let visible = 0;
            cards.forEach((card) => {
                const haystack = (card.dataset.diarySearch || card.textContent || '').toLowerCase();
                const match = !q || haystack.includes(q);
                card.hidden = !match;
                if (match) visible++;
            });
            if (searchEmpty) {
                searchEmpty.hidden = !(q && visible === 0);
            }
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDiaryAtelier);
} else {
    initDiaryAtelier();
}


function initBlogEditorialDesk() {
    const categoryInput = document.getElementById('blog-new-category');
    const bodyInput = document.getElementById('blog-new-body');
    const wordCounter = document.getElementById('blog-word-counter');
    const manageSearchInput = document.getElementById('blog-manage-search');
    const filterEmptyMsg = document.getElementById('blog-manage-filter-empty');
    const statusTabs = document.querySelectorAll('.blog-status-tab');
    let currentStatusFilter = 'all';

    function updateBlogWordCount() {
        if (!bodyInput || !wordCounter) return;
        const text = bodyInput.value.trim();
        const words = text ? text.split(/\s+/).length : 0;
        wordCounter.textContent = `${words} ${words === 1 ? 'palabra' : 'palabras'} · Borrador`;
    }

    if (bodyInput) {
        bodyInput.addEventListener('input', updateBlogWordCount);
        updateBlogWordCount();
    }

    document.querySelectorAll('.blog-quick-cat-chip').forEach((chip) => {
        chip.addEventListener('click', () => {
            if (categoryInput) {
                categoryInput.value = chip.dataset.blogPickCategory || '';
            }
            document.querySelectorAll('.blog-quick-cat-chip').forEach((c) => c.classList.remove('is-active'));
            chip.classList.add('is-active');
        });
    });

    function filterManageCards() {
        const cards = document.querySelectorAll('[data-blog-manage-card]');
        if (!cards.length) return;
        const query = (manageSearchInput?.value || '').trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach((card) => {
            const status = card.dataset.blogManageStatus || '';
            const haystack = (card.dataset.blogManageSearch || card.textContent || '').toLowerCase();
            const matchesStatus = currentStatusFilter === 'all' || status === currentStatusFilter;
            const matchesQuery = !query || haystack.includes(query);
            const show = matchesStatus && matchesQuery;
            card.hidden = !show;
            if (show) visibleCount++;
        });

        if (filterEmptyMsg) {
            filterEmptyMsg.hidden = visibleCount > 0;
        }
    }

    statusTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            currentStatusFilter = tab.dataset.blogManageFilter || 'all';
            statusTabs.forEach((t) => t.classList.remove('is-active'));
            tab.classList.add('is-active');
            filterManageCards();
        });
    });

    if (manageSearchInput) {
        manageSearchInput.addEventListener('input', filterManageCards);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBlogEditorialDesk);
} else {
    initBlogEditorialDesk();
}

function initFamilySanctuary() {
    const screenEl = document.getElementById('screen-familia');
    if (!screenEl) return;

    const jsonEl = document.getElementById('family-initial-json');
    let initialState = { unlocked: false, members: [], memories: [] };
    if (jsonEl) {
        try {
            initialState = JSON.parse(jsonEl.textContent || '{}');
        } catch (err) {
            console.error('Error parseando datos iniciales de Mi Familia:', err);
        }
    }

    let isUnlocked = Boolean(initialState.unlocked);
    let members = Array.isArray(initialState.members) ? initialState.members : [];
    let memories = Array.isArray(initialState.memories) ? initialState.memories : [];
    let selectedMemberId = members[0]?.id || null;
    let activeCategoryFilter = 'todos';

    const vaultGate = document.getElementById('family-vault-gate');
    const sanctuaryContent = document.getElementById('family-sanctuary-content');
    const secDot = document.getElementById('family-sec-dot');
    const secStatusText = document.getElementById('family-sec-status-text');

    const statMembersCount = document.getElementById('family-stat-members-count');
    const statChildrenCount = document.getElementById('family-stat-children-count');
    const statMemoriesCount = document.getElementById('family-stat-memories-count');

    const parentsRow = document.getElementById('family-tree-parents-row');
    const offspringRow = document.getElementById('family-tree-offspring-row');
    const membersCardsGrid = document.getElementById('family-members-cards-grid');
    const memoriesGrid = document.getElementById('family-memories-grid');
    const memoriesEmpty = document.getElementById('family-memories-empty');
    const searchInput = document.getElementById('family-memories-search');

    // Spotlight Elements
    const spotlightBlur = document.getElementById('family-spotlight-blur');
    const spotlightImg = document.getElementById('family-spotlight-img');
    const spotlightIcon = document.getElementById('family-spotlight-icon');
    const spotlightRole = document.getElementById('family-spotlight-role');
    const spotlightName = document.getElementById('family-spotlight-name');
    const spotlightDate = document.getElementById('family-spotlight-date');
    const spotlightBio = document.getElementById('family-spotlight-bio');
    const spotlightQuote = document.getElementById('family-spotlight-quote');
    const btnSpotlightEdit = document.getElementById('btn-spotlight-edit-member');
    const btnSpotlightFilter = document.getElementById('btn-spotlight-filter-memories');

    // Dialogs
    const quickAuthDialog = document.getElementById('family-quick-auth-dialog');
    const memberEditorDialog = document.getElementById('family-member-editor-dialog');
    const memoryEditorDialog = document.getElementById('family-memory-editor-dialog');
    const lightboxDialog = document.getElementById('family-memory-lightbox-dialog');

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    function setCsrfToken(newToken) {
        if (!newToken) return;
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta) meta.setAttribute('content', newToken);
    }

    function escapeHtml(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function openDialog(dlg) {
        if (!dlg) return;
        if (typeof dlg.showModal === 'function') {
            if (!dlg.open) dlg.showModal();
        } else {
            dlg.setAttribute('open', '');
        }
    }

    function closeDialog(dlg) {
        if (!dlg) return;
        if (typeof dlg.close === 'function') {
            if (dlg.open) dlg.close();
        } else {
            dlg.removeAttribute('open');
        }
    }

    function updateStatsUI() {
        if (statMembersCount) statMembersCount.textContent = String(members.length);
        if (statChildrenCount) {
            statChildrenCount.textContent = String(members.filter((m) => m.category === 'children').length);
        }
        if (statMemoriesCount) statMemoriesCount.textContent = String(memories.length);
    }

    function renderSpotlight() {
        const current = members.find((m) => Number(m.id) === Number(selectedMemberId)) || members[0];
        if (!current) return;
        selectedMemberId = current.id;
        const photoUrl = current.photo_url || '/images/carla-hero.jpg';
        if (spotlightBlur) spotlightBlur.style.backgroundImage = `url('${photoUrl}')`;
        if (spotlightImg) {
            spotlightImg.src = photoUrl;
            spotlightImg.alt = current.name;
        }
        if (spotlightIcon) spotlightIcon.textContent = current.avatar_icon || '💎';
        if (spotlightRole) spotlightRole.textContent = current.role_badge || 'Integrante Familiar';
        if (spotlightName) spotlightName.textContent = current.name || '';
        if (spotlightDate) {
            spotlightDate.textContent = current.special_date ? `✦ ${current.special_date}` : '✦ Tesoro de Mi Familia';
        }
        if (spotlightBio) {
            spotlightBio.textContent = current.bio || 'Parte esencial del corazón y la alegría de nuestro hogar.';
        }
        if (spotlightQuote) {
            spotlightQuote.textContent = current.favorite_quote || '«El amor en familia es nuestra mayor fortuna.»';
        }
    }

    function renderConstellationTree() {
        if (!parentsRow || !offspringRow) return;

        const parents = members.filter((m) => m.category === 'carla' || m.category === 'adrian');
        const offspring = members.filter((m) => m.category !== 'carla' && m.category !== 'adrian');

        const buildNodeHtml = (m) => {
            const isSel = Number(m.id) === Number(selectedMemberId);
            const photoUrl = escapeHtml(m.photo_url || '/images/carla-hero.jpg');
            return `
                <button type="button" class="family-tree-node-btn ${isSel ? 'is-selected' : ''}" data-tree-member-id="${m.id}">
                    <div class="family-tree-node-avatar">
                        <img src="${photoUrl}" alt="${escapeHtml(m.name)}" loading="lazy">
                        <span class="family-tree-node-icon">${escapeHtml(m.avatar_icon || '💎')}</span>
                    </div>
                    <strong class="family-tree-node-name">${escapeHtml(m.name)}</strong>
                    <span class="family-tree-node-role">${escapeHtml(m.role_badge)}</span>
                </button>
            `;
        };

        parentsRow.innerHTML = parents.map(buildNodeHtml).join('');
        offspringRow.innerHTML = offspring.map(buildNodeHtml).join('');
    }

    function renderMemberCards() {
        if (!membersCardsGrid) return;
        const coreSlugs = ['carla-lorena', 'adrian', 'ody'];

        membersCardsGrid.innerHTML = members.map((m) => {
            const photoUrl = escapeHtml(m.photo_url || '/images/carla-hero.jpg');
            const canDelete = !coreSlugs.includes(m.slug);
            return `
                <article class="family-member-card" data-member-card-id="${m.id}">
                    <div class="family-member-card-media" data-select-member="${m.id}" style="cursor: pointer;">
                        <div class="family-member-card-blur" style="background-image: url('${photoUrl}');"></div>
                        <img class="family-member-card-img" src="${photoUrl}" alt="${escapeHtml(m.name)}" loading="lazy">
                        <span class="family-member-card-icon">${escapeHtml(m.avatar_icon || '🌟')}</span>
                    </div>
                    <div class="family-member-card-body">
                        <span class="family-member-card-role">${escapeHtml(m.role_badge)}</span>
                        <h3 class="family-member-card-name">${escapeHtml(m.name)}</h3>
                        <p class="family-member-card-bio">${escapeHtml(m.bio || '')}</p>
                        <div class="family-member-card-footer">
                            <button type="button" class="button button-sm button-outline" data-edit-member="${m.id}">
                                ✏️ Editar
                            </button>
                            <div style="display: flex; gap: 6px;">
                                <button type="button" class="button button-sm button-outline" data-filter-member-cat="${escapeHtml(m.category)}" title="Ver fotos">
                                    📸 Fotos
                                </button>
                                ${canDelete ? `<button type="button" class="button button-sm button-outline" data-delete-member="${m.id}" title="Eliminar integrante">🗑️</button>` : ''}
                            </div>
                        </div>
                    </div>
                </article>
            `;
        }).join('');

        // Actualizar selector de integrantes en el modal de recuerdos
        const memberSelect = document.getElementById('family-memory-member-select');
        if (memberSelect) {
            memberSelect.innerHTML = '<option value="">— General de la categoría —</option>' +
                members.map((m) => `<option value="${m.id}">${escapeHtml(m.avatar_icon || '💎')} ${escapeHtml(m.name)}</option>`).join('');
        }
    }

    function renderMemoriesAlbum() {
        if (!memoriesGrid) return;
        const query = (searchInput?.value || '').trim().toLowerCase();

        const filtered = memories.filter((mem) => {
            const matchCat = activeCategoryFilter === 'todos' || mem.category === activeCategoryFilter;
            const haystack = `${mem.title || ''} ${mem.story || ''} ${mem.emotion_tag || ''} ${mem.member_name || ''}`.toLowerCase();
            const matchQuery = !query || haystack.includes(query);
            return matchCat && matchQuery;
        });

        if (memoriesEmpty) {
            memoriesEmpty.hidden = filtered.length > 0;
        }

        memoriesGrid.innerHTML = filtered.map((mem) => {
            const imgUrl = escapeHtml(mem.image_url || '/images/carla-hero.jpg');
            return `
                <article class="family-memory-card" data-memory-id="${mem.id}">
                    <div class="family-memory-stage" data-open-memory-lightbox="${mem.id}">
                        <div class="family-memory-blur" style="background-image: url('${imgUrl}');"></div>
                        <img class="family-memory-img" src="${imgUrl}" alt="${escapeHtml(mem.title)}" loading="lazy">
                        <span class="family-memory-tag-pill">💎 ${escapeHtml(mem.emotion_tag || 'Amor Familiar')}</span>
                        <div class="family-memory-actions">
                            <button type="button" class="family-memory-edit-btn" data-edit-memory="${mem.id}" title="Editar esta foto y recuerdo">✏️</button>
                            <button type="button" class="family-memory-delete-btn" data-delete-memory="${mem.id}" title="Eliminar recuerdo">✕</button>
                        </div>
                    </div>
                    <div class="family-memory-body">
                        <div class="family-memory-meta">
                            <span>${escapeHtml(mem.member_name || 'Mi Familia')}</span>
                            <span>${escapeHtml(mem.memory_date || 'Recuerdo Eterno')}</span>
                        </div>
                        <h3 class="family-memory-title">${escapeHtml(mem.title)}</h3>
                        ${mem.story ? `<p class="family-memory-story">${escapeHtml(mem.story)}</p>` : ''}
                    </div>
                    <div class="family-memory-card-edit-bar">
                        <span style="font-size: 0.74rem; color: #64748b;">📸 Foto editable</span>
                        <button type="button" class="family-card-edit-photo-btn" data-edit-memory="${mem.id}">
                            ✏️ Editar Foto / Datos
                        </button>
                    </div>
                </article>
            `;
        }).join('');
    }

    function renderAllFamilyUI() {
        screenEl.dataset.familyUnlocked = isUnlocked ? '1' : '0';
        if (vaultGate) vaultGate.hidden = isUnlocked;
        if (sanctuaryContent) sanctuaryContent.hidden = !isUnlocked;

        if (secDot) {
            secDot.classList.toggle('is-unlocked', isUnlocked);
            secDot.classList.toggle('is-locked', !isUnlocked);
        }
        if (secStatusText) {
            secStatusText.textContent = isUnlocked
                ? '🔒 BÓVEDA FAMILIAR DESBLOQUEADA · MODO ADMINISTRADOR'
                : '🔐 ACCESO RESTRINGIDO · EXCLUSIVO ADMINISTRADOR';
        }

        if (!isUnlocked) return;

        if (!selectedMemberId && members.length > 0) {
            selectedMemberId = members[0].id;
        }
        updateStatsUI();
        renderConstellationTree();
        renderSpotlight();
        renderMemberCards();
        renderMemoriesAlbum();
    }

    // Interceptar clic en el Pétalo / Zafiro "Mi Familia" del Mapa si aún no está desbloqueado
    document.querySelectorAll('[data-family-vault-node="1"]').forEach((node) => {
        node.addEventListener('click', (e) => {
            if (!isUnlocked) {
                e.preventDefault();
                e.stopPropagation();
                const errBox = document.getElementById('family-modal-error');
                if (errBox) errBox.hidden = true;
                openDialog(quickAuthDialog);
                setTimeout(() => document.getElementById('family-modal-login')?.focus(), 60);
            }
        }, true);
    });

    document.getElementById('btn-close-family-auth-modal')?.addEventListener('click', () => closeDialog(quickAuthDialog));
    document.getElementById('btn-cancel-family-auth-modal')?.addEventListener('click', () => closeDialog(quickAuthDialog));

    // Función compartida para desbloquear la Bóveda Familiar por AJAX
    async function handleUnlockSubmit(formEl, errorEl, submitBtnEl, navigateOnSuccess = false) {
        if (!formEl) return;
        const formData = new FormData(formEl);
        const login = String(formData.get('login') || '').trim();
        const password = String(formData.get('password') || '');

        if (!login || !password) return;

        if (errorEl) errorEl.hidden = true;
        const originalText = submitBtnEl?.textContent || 'Desbloquear';
        if (submitBtnEl) {
            submitBtnEl.disabled = true;
            submitBtnEl.textContent = 'Verificando credenciales...';
        }

        try {
            const res = await fetch('/family-sanctuary/unlock', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ login, password }),
            });
            const data = await res.json();

            if (res.ok && data.unlocked) {
                if (data.csrf_token) setCsrfToken(data.csrf_token);
                isUnlocked = true;
                members = Array.isArray(data.members) ? data.members : [];
                memories = Array.isArray(data.memories) ? data.memories : [];
                selectedMemberId = members[0]?.id || null;
                renderAllFamilyUI();
                closeDialog(quickAuthDialog);

                if (navigateOnSuccess) {
                    const goLink = document.createElement('a');
                    goLink.href = '#familia';
                    goLink.dataset.go = 'familia';
                    document.body.appendChild(goLink);
                    goLink.click();
                    goLink.remove();
                    window.location.hash = 'familia';
                }
            } else {
                if (errorEl) {
                    errorEl.textContent = data.message || 'Credenciales inválidas. Solo el administrador puede ingresar.';
                    errorEl.hidden = false;
                }
            }
        } catch (err) {
            if (errorEl) {
                errorEl.textContent = 'No se pudo verificar el acceso. Inténtalo de nuevo.';
                errorEl.hidden = false;
            }
        } finally {
            if (submitBtnEl) {
                submitBtnEl.disabled = false;
                submitBtnEl.textContent = originalText;
            }
        }
    }

    document.getElementById('family-modal-unlock-form')?.addEventListener('submit', (e) => {
        e.preventDefault();
        handleUnlockSubmit(
            e.currentTarget,
            document.getElementById('family-modal-error'),
            document.getElementById('family-modal-submit-btn'),
            true
        );
    });

    document.getElementById('family-inline-unlock-form')?.addEventListener('submit', (e) => {
        e.preventDefault();
        handleUnlockSubmit(
            e.currentTarget,
            document.getElementById('family-inline-error'),
            document.getElementById('family-inline-submit-btn'),
            false
        );
    });

    // Interacción con el Árbol / Constelación
    document.getElementById('family-tree-canvas')?.addEventListener('click', (e) => {
        const nodeBtn = e.target.closest('[data-tree-member-id]');
        if (!nodeBtn) return;
        selectedMemberId = Number(nodeBtn.dataset.treeMemberId);
        renderConstellationTree();
        renderSpotlight();
    });

    // Botones del Spotlight
    btnSpotlightEdit?.addEventListener('click', () => {
        const current = members.find((m) => Number(m.id) === Number(selectedMemberId));
        if (current) openMemberModal(current);
    });

    btnSpotlightFilter?.addEventListener('click', () => {
        const current = members.find((m) => Number(m.id) === Number(selectedMemberId));
        if (!current) return;
        setActiveFilterPill(current.category || 'todos');
        document.getElementById('family-album-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // Modal de Crear / Editar Integrante o Hijo
    const memberForm = document.getElementById('family-member-editor-form');
    const memberPhotoInput = document.getElementById('family-member-photo-input');
    const memberDropEmpty = document.getElementById('family-member-dropzone-empty');
    const memberDropPreview = document.getElementById('family-member-dropzone-preview');
    const memberPreviewBlur = document.getElementById('family-member-preview-blur');
    const memberPreviewImg = document.getElementById('family-member-preview-img');

    function openMemberModal(member = null) {
        if (!memberEditorDialog || !memberForm) return;
        memberForm.reset();
        document.getElementById('family-member-id').value = member ? String(member.id) : '';
        document.getElementById('family-member-modal-title').textContent = member
            ? `Editar Perfil de ${member.name}`
            : 'Agregar Nuevo Hijo / Integrante';
        document.getElementById('family-member-name').value = member?.name || '';
        document.getElementById('family-member-category').value = member?.category || 'children';
        document.getElementById('family-member-role').value = member?.role_badge || 'Hijo Amado · Alegría del Hogar';
        document.getElementById('family-member-icon').value = member?.avatar_icon || '🌟';
        document.getElementById('family-member-date').value = member?.special_date || '';
        document.getElementById('family-member-quote').value = member?.favorite_quote || '';
        document.getElementById('family-member-bio').value = member?.bio || '';

        if (member?.photo_url) {
            if (memberPreviewBlur) memberPreviewBlur.style.backgroundImage = `url('${member.photo_url}')`;
            if (memberPreviewImg) memberPreviewImg.src = member.photo_url;
            if (memberDropEmpty) memberDropEmpty.hidden = true;
            if (memberDropPreview) memberDropPreview.hidden = false;
        } else {
            if (memberDropEmpty) memberDropEmpty.hidden = false;
            if (memberDropPreview) memberDropPreview.hidden = true;
        }

        openDialog(memberEditorDialog);
    }

    memberPhotoInput?.addEventListener('change', () => {
        const file = memberPhotoInput.files?.[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        if (memberPreviewBlur) memberPreviewBlur.style.backgroundImage = `url('${url}')`;
        if (memberPreviewImg) memberPreviewImg.src = url;
        if (memberDropEmpty) memberDropEmpty.hidden = true;
        if (memberDropPreview) memberDropPreview.hidden = false;
    });

    document.getElementById('btn-open-new-member-modal')?.addEventListener('click', () => openMemberModal(null));
    document.getElementById('btn-Add-Child-Shortcut')?.addEventListener('click', () => openMemberModal(null));
    document.getElementById('btn-close-member-modal')?.addEventListener('click', () => closeDialog(memberEditorDialog));
    document.getElementById('btn-cancel-member-modal')?.addEventListener('click', () => closeDialog(memberEditorDialog));

    memberForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const memberId = document.getElementById('family-member-id')?.value;
        const saveBtn = document.getElementById('btn-save-member-modal');
        const formData = new FormData(memberForm);
        const url = memberId ? `/admin/family-members/${memberId}` : '/admin/family-members';

        if (saveBtn) {
            saveBtn.disabled = true;
            saveBtn.textContent = 'Guardando...';
        }

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: formData,
            });
            const data = await res.json();
            if (res.ok && data.member) {
                if (memberId) {
                    members = members.map((m) => (Number(m.id) === Number(data.member.id) ? data.member : m));
                } else {
                    members.push(data.member);
                }
                selectedMemberId = data.member.id;
                renderAllFamilyUI();
                closeDialog(memberEditorDialog);
            }
        } catch (err) {
            console.error('Error guardando integrante:', err);
        } finally {
            if (saveBtn) {
                saveBtn.disabled = false;
                saveBtn.textContent = '✨ Guardar Integrante';
            }
        }
    });

    // Delegación en la grilla de tarjetas de integrantes
    membersCardsGrid?.addEventListener('click', async (e) => {
        const selectEl = e.target.closest('[data-select-member]');
        if (selectEl) {
            selectedMemberId = Number(selectEl.dataset.selectMember);
            renderConstellationTree();
            renderSpotlight();
            return;
        }

        const editBtn = e.target.closest('[data-edit-member]');
        if (editBtn) {
            const target = members.find((m) => Number(m.id) === Number(editBtn.dataset.editMember));
            if (target) openMemberModal(target);
            return;
        }

        const filterBtn = e.target.closest('[data-filter-member-cat]');
        if (filterBtn) {
            setActiveFilterPill(filterBtn.dataset.filterMemberCat || 'todos');
            document.getElementById('family-album-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            return;
        }

        const delBtn = e.target.closest('[data-delete-member]');
        if (delBtn) {
            const id = delBtn.dataset.deleteMember;
            try {
                const res = await fetch(`/admin/family-members/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                });
                if (res.ok) {
                    members = members.filter((m) => Number(m.id) !== Number(id));
                    if (Number(selectedMemberId) === Number(id)) {
                        selectedMemberId = members[0]?.id || null;
                    }
                    renderAllFamilyUI();
                }
            } catch (err) {
                console.error('Error eliminando integrante:', err);
            }
        }
    });

    // Modal de Subir / Editar Fotografía / Recuerdo Familiar
    const memoryForm = document.getElementById('family-memory-editor-form');
    const memoryImageInput = document.getElementById('family-memory-image-input');
    const memoryDropEmpty = document.getElementById('family-memory-dropzone-empty');
    const memoryDropPreview = document.getElementById('family-memory-dropzone-preview');
    const memoryPreviewBlur = document.getElementById('family-memory-preview-blur');
    const memoryPreviewImg = document.getElementById('family-memory-preview-img');

    function updateMemoryMemberSelect(selectedMemberVal = '') {
        const sel = document.getElementById('family-memory-member-select');
        if (!sel) return;
        sel.innerHTML = '<option value="">— General de la categoría —</option>' + members.map((m) => {
            return `<option value="${m.id}" ${String(m.id) === String(selectedMemberVal) ? 'selected' : ''}>${escapeHtml(m.name)} (${escapeHtml(m.role_badge || m.category)})</option>`;
        }).join('');
    }

    function openMemoryModal(memory = null) {
        if (!memoryEditorDialog || !memoryForm) return;
        memoryForm.reset();
        document.getElementById('family-memory-id').value = memory ? String(memory.id) : '';
        document.getElementById('family-memory-modal-title').textContent = memory
            ? `Editar Fotografía / Recuerdo: ${memory.title}`
            : 'Subir Recuerdo al Álbum Familiar';

        document.getElementById('family-memory-title').value = memory?.title || '';
        document.getElementById('family-memory-category').value = memory?.category || 'todos';
        document.getElementById('family-memory-date').value = memory?.memory_date || '';
        document.getElementById('family-memory-tag').value = memory?.emotion_tag || '';
        document.getElementById('family-memory-story').value = memory?.story || '';

        updateMemoryMemberSelect(memory?.family_member_id || '');

        const imgUrl = memory?.image_url;
        if (imgUrl) {
            if (memoryPreviewBlur) memoryPreviewBlur.style.backgroundImage = `url('${imgUrl}')`;
            if (memoryPreviewImg) memoryPreviewImg.src = imgUrl;
            if (memoryDropEmpty) memoryDropEmpty.hidden = true;
            if (memoryDropPreview) memoryDropPreview.hidden = false;
        } else {
            if (memoryDropEmpty) memoryDropEmpty.hidden = false;
            if (memoryDropPreview) memoryDropPreview.hidden = true;
        }

        const saveBtn = document.getElementById('btn-save-memory-modal');
        if (saveBtn) {
            saveBtn.textContent = memory ? '💎 Guardar Cambios en la Foto' : '💎 Publicar en el Álbum Familiar';
        }

        openDialog(memoryEditorDialog);
    }

    memoryImageInput?.addEventListener('change', () => {
        const file = memoryImageInput.files?.[0];
        if (!file) return;
        const url = URL.createObjectURL(file);
        if (memoryPreviewBlur) memoryPreviewBlur.style.backgroundImage = `url('${url}')`;
        if (memoryPreviewImg) memoryPreviewImg.src = url;
        if (memoryDropEmpty) memoryDropEmpty.hidden = true;
        if (memoryDropPreview) memoryDropPreview.hidden = false;
    });

    document.getElementById('btn-open-new-memory-modal')?.addEventListener('click', openMemoryModal);
    document.getElementById('btn-album-add-photo')?.addEventListener('click', openMemoryModal);
    document.getElementById('btn-close-memory-modal')?.addEventListener('click', () => closeDialog(memoryEditorDialog));
    document.getElementById('btn-cancel-memory-modal')?.addEventListener('click', () => closeDialog(memoryEditorDialog));

    memoryForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const memoryId = document.getElementById('family-memory-id')?.value;
        const saveBtn = document.getElementById('btn-save-memory-modal');
        const formData = new FormData(memoryForm);
        const url = memoryId ? `/admin/family-memories/${memoryId}` : '/admin/family-memories';

        if (saveBtn) {
            saveBtn.disabled = true;
            saveBtn.textContent = memoryId ? 'Guardando foto...' : 'Publicando recuerdo...';
        }

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                },
                body: formData,
            });
            const data = await res.json();
            if (res.ok && data.memory) {
                if (memoryId) {
                    memories = memories.map((m) => (Number(m.id) === Number(data.memory.id) ? data.memory : m));
                } else {
                    memories.unshift(data.memory);
                }
                updateStatsUI();
                renderMemoriesAlbum();
                closeDialog(memoryEditorDialog);
            }
        } catch (err) {
            console.error('Error guardando recuerdo familiar:', err);
        } finally {
            if (saveBtn) {
                saveBtn.disabled = false;
                saveBtn.textContent = memoryId ? '💎 Guardar Cambios en la Foto' : '💎 Publicar en el Álbum Familiar';
            }
        }
    });

    // Filtros y buscador del álbum familiar
    function setActiveFilterPill(cat) {
        activeCategoryFilter = cat || 'todos';
        document.querySelectorAll('#family-filter-pills .family-filter-pill').forEach((pill) => {
            pill.classList.toggle('is-active', pill.dataset.familyFilter === activeCategoryFilter);
        });
        renderMemoriesAlbum();
    }

    document.querySelectorAll('#family-filter-pills .family-filter-pill').forEach((pill) => {
        pill.addEventListener('click', () => setActiveFilterPill(pill.dataset.familyFilter));
    });

    searchInput?.addEventListener('input', renderMemoriesAlbum);

    // Delegación en la grilla de recuerdos (Lightbox, Editar y Eliminar)
    memoriesGrid?.addEventListener('click', async (e) => {
        const editBtn = e.target.closest('[data-edit-memory]');
        if (editBtn) {
            e.stopPropagation();
            const id = editBtn.dataset.editMemory;
            const target = memories.find((m) => Number(m.id) === Number(id));
            if (target) openMemoryModal(target);
            return;
        }

        const delBtn = e.target.closest('[data-delete-memory]');
        if (delBtn) {
            e.stopPropagation();
            const id = delBtn.dataset.deleteMemory;
            try {
                const res = await fetch(`/admin/family-memories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                });
                if (res.ok) {
                    memories = memories.filter((m) => Number(m.id) !== Number(id));
                    updateStatsUI();
                    renderMemoriesAlbum();
                }
            } catch (err) {
                console.error('Error eliminando recuerdo:', err);
            }
            return;
        }

        const openStage = e.target.closest('[data-open-memory-lightbox]');
        if (openStage) {
            const mem = memories.find((m) => Number(m.id) === Number(openStage.dataset.openMemoryLightbox));
            if (!mem) return;
            const imgUrl = mem.image_url || '/images/carla-hero.jpg';
            const lbBlur = document.getElementById('family-lightbox-blur');
            const lbImg = document.getElementById('family-lightbox-img');
            const lbTag = document.getElementById('family-lightbox-tag');
            const lbDate = document.getElementById('family-lightbox-date');
            const lbTitle = document.getElementById('family-lightbox-title');
            const lbStory = document.getElementById('family-lightbox-story');

            if (lbBlur) lbBlur.style.backgroundImage = `url('${imgUrl}')`;
            if (lbImg) lbImg.src = imgUrl;
            if (lbTag) lbTag.textContent = mem.emotion_tag || 'Amor Familiar';
            if (lbDate) lbDate.textContent = `${mem.member_name || 'Mi Familia'} · ${mem.memory_date || 'Recuerdo Eterno'}`;
            if (lbTitle) lbTitle.textContent = mem.title || '';
            if (lbStory) lbStory.textContent = mem.story || '';

            const lbEditBtn = document.getElementById('btn-lightbox-edit-photo');
            if (lbEditBtn) {
                lbEditBtn.onclick = () => {
                    closeDialog(lightboxDialog);
                    openMemoryModal(mem);
                };
            }

            openDialog(lightboxDialog);
        }
    });

    document.getElementById('btn-close-family-lightbox')?.addEventListener('click', () => closeDialog(lightboxDialog));

    renderAllFamilyUI();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initFamilySanctuary();
        initGardenUXInnovations();
    });
} else {
    initFamilySanctuary();
    initGardenUXInnovations();
}
