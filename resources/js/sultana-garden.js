import * as THREE from 'three';

const loveMessagesForCarla = [
    '«Tu sonrisa es la fuente donde brota toda mi alegría, mi dulce Carla.»',
    '«En este invernadero de luz, mi amor por ti florece con cada latido.»',
    '«Ni mil luciérnagas brillan tanto como la luz de tus ojos, mi vida.»',
    '«El puente de los susurros repite una y otra vez lo mucho que te amo.»',
    '«Entre todas las rosas del mundo, tú eres la flor más hermosa y delicada.»',
    '«El cristal más puro es el reflejo de tu mirada sincera, mi amor eterno.»',
    '«Como las mareas infinitas, mi cariño por ti nunca se detiene.»',
    '«Bajo la sombra de los árboles, solo sueño con caminar de tu mano.»',
    '«En el observatorio de las estrellas, tú eres mi constelación favorita.»',
    '«El viento en la cumbre susurra tu nombre con infinita ternura, Carla.»',
    '«Cada rincón que tocamos florece con la pasión y el amor que te tengo.»',
    '«Tú eres el corazón y el alma que llena de magia este jardín secreto.»',
    '«En la cascada del alba, cada gota canta una melodía dedicada a ti.»',
    '«Ni el frío del invierno puede congelar el calor que enciende tu abrazo.»',
    '«En el crepúsculo dorado, agradezco a la vida por tenerte a mi lado.»',
    '«Las cuevas de la memoria guardan los instantes más bellos junto a ti.»',
    '«En el espejo del destino, veo un futuro maravilloso a tu lado, mi vida.»',
    '«¡El corazón de Liria late por ti! Eres mi amor, mi pasión y mi todo, Carla Lorena.»'
];

// Mensajes de amor por escenario: bíblicos y poéticos, sobre la belleza de Carla Lorena
const stageEnvironmentMessages = [
    // Índice 0 — Escenario 1: El jardín principal (jardín de flores)
    { text: '«Eres la flor más bella de este jardín, Carla Lorena. Tu sonrisa nació del cielo para alegrar al mundo entero.» — Adrián', color: '#ffd700', bgColor: '#1a0a2e', placement: 'sky' },
    // Índice 1 — Escenario 2: El invernadero secreto
    { text: '«He aquí que eres hermosa, amada mía; he aquí eres bella; tus ojos son como palomas.» — Cantares 1:15', color: '#e0f7ff', bgColor: '#0a1a2e', placement: 'ground' },
    // Índice 2 — Campaña Escenario 3: El sendero de las luciérnagas
    { text: '«Eres más radiante que mil luciérnagas, Carla. Tu luz ilumina todos mis pasos en la oscuridad.» — Adrián', color: '#f9e89e', bgColor: '#0a0a2e', placement: 'sky' },
    // Índice 3 — Campaña Escenario 4: El puente de los susurros
    { text: '«Muchas mujeres han obrado con excelencia, mas tú las superas a todas ellas.» — Proverbios 31:29', color: '#ffd700', bgColor: '#0a1a0a', placement: 'pillar' },
    // Índice 4 — Campaña Escenario 5: El laberinto de rosas
    { text: '«Tu amor es más dulce que el vino; tu nombre como ungüento perfumado derramado, Carla Lorena.» — Cantares 1:2-3', color: '#ffb6d9', bgColor: '#2a0a1a', placement: 'ground' },
    // Índice 5 — Campaña Escenario 6: La gruta de cristal
    { text: '«Tus ojos son más puros que el cristal más perfecto. En ellos veo el paraíso, Carla.» — Adrián', color: '#a0e8ff', bgColor: '#0a1225', placement: 'sky' },
    // Índice 6 — Campaña Escenario 7: El valle de las mareas
    { text: '«Las aguas caudalosas no podrán apagar el amor; ni los ríos lo anegarán jamás.» — Cantares 8:7', color: '#7fdfff', bgColor: '#0a2030', placement: 'pillar' },
    // Índice 7 — Campaña Escenario 8: La arboleda de las sombras
    { text: '«Bajo la sombra de este árbol soñé con tu risa, Carla, y el sueño valió más que el mundo.» — Adrián', color: '#c8f5c8', bgColor: '#0a1a0a', placement: 'ground' },
    // Índice 8 — Campaña Escenario 9: El observatorio olvidado
    { text: '«El amor es paciente, es bondadoso. Todo lo espera, todo lo soporta, todo lo puede.» — 1 Corintios 13:4-7', color: '#d8c8ff', bgColor: '#0a0a2a', placement: 'sky' },
    // Índice 9 — Campaña Escenario 10: La cumbre de los vientos
    { text: '«Tu belleza, Carla, supera la de las estrellas de la cumbre. Eres mi constelación eterna.» — Adrián', color: '#fffacd', bgColor: '#08082a', placement: 'pillar' },
    // Índice 10 — Campaña Escenario 11: El jardín de las mareas altas
    { text: '«No hay marea ni distancia que separe lo que el amor une. Carla, eres mi horizonte.» — Adrián', color: '#a0e8e8', bgColor: '#082020', placement: 'ground' },
    // Índice 11 — Campaña Escenario 12: El corazón secreto de Liria
    { text: '«Ponme como sello sobre tu corazón. El amor es fuerte como la muerte y tan ardiente como la llama divina.» — Cantares 8:6', color: '#ffd700', bgColor: '#2a0808', placement: 'sky' },
    // Índice 12 — Campaña Escenario 13: La cascada de los susurros
    { text: '«La cascada susurra tu nombre, Carla Lorena. Cada gota lleva un te amo de Adrián.» — Adrián', color: '#b0e8ff', bgColor: '#081820', placement: 'pillar' },
    // Índice 13 — Campaña Escenario 14: El invernadero congelado
    { text: '«Ni el hielo eterno puede enfriar el fuego de amor que arde en mi corazón por ti, Carla.» — Adrián', color: '#d0f0ff', bgColor: '#081422', placement: 'ground' },
    // Índice 14 — Campaña Escenario 15: El jardín del crepúsculo
    { text: '«En el crepúsculo dorado, cada estrella que nace lleva tu nombre escrito, amor mío.» — Adrián', color: '#ffcc80', bgColor: '#200e04', placement: 'sky' },
    // Índice 15 — Campaña Escenario 16: Las cuevas de la memoria
    { text: '«Te recordaré en cada latido, Carla. La memoria del corazón nunca te olvida.» — Adrián', color: '#e0c8ff', bgColor: '#180820', placement: 'pillar' },
    // Índice 16 — Campaña Escenario 17: El bosque de los espejos
    { text: '«En el espejo del universo solo veo tu rostro, Carla, el más hermoso y el más amado de todos.» — Adrián', color: '#b8d8ff', bgColor: '#080e22', placement: 'ground' },
    // Índice 17 — Campaña Escenario 18: El corazón de Liria
    { text: '«La amé con amor eterno; por eso la atraje con misericordia y con amor inagotable.» — Jeremías 31:3', color: '#ffd700', bgColor: '#1a0820', placement: 'sky' },
];



const flowers = [
    { x: -6, z: 5 },
    { x: 6, z: 0 },
    { x: -4, z: -5 },
];
const lightSeeds = [
    { x: 29, z: -4 },
    { x: 37, z: 4 },
    { x: 44, z: -3 },
];
const adventureStages = [
    { name: 'El sendero de las luciérnagas', friend: 'Nara', task: 'Reúne destellos y enciende el farol antiguo', clue: 'Sigue la hilera de luces junto al sendero hasta el farol.', action: 'Encender farol', color: '#f1d68a', sky: '#e9eddb', ground: '#98ae7c', items: 3, enemies: 1, traps: 1 },
    { name: 'El puente de los susurros', friend: 'Tilo', task: 'Recoge campanillas y haz sonar el puente', clue: 'El puente está en el claro central; las campanillas están más allá de las zarzas.', action: 'Hacer sonar campana', color: '#a9c7d0', sky: '#dce9eb', ground: '#90aaa0', items: 3, enemies: 2, traps: 1 },
    { name: 'El laberinto de rosas', friend: 'Amalia', task: 'Busca las rosas plateadas y abre el rosal', clue: 'Mira los espacios entre las espinas; el camino seguro serpentea hasta el rosal.', action: 'Abrir rosal', color: '#d49bab', sky: '#eee0e1', ground: '#a68a8a', items: 4, enemies: 2, traps: 2 },
    { name: 'La gruta de cristal', friend: 'Ivo', task: 'Recupera los cristales y alinea el prisma', clue: 'La salida está al este; el prisma espera junto a las piedras brillantes.', action: 'Alinear prisma', color: '#a8c9d4', sky: '#dae7ee', ground: '#8ba8a7', items: 4, enemies: 3, traps: 2 },
    { name: 'El valle de las mareas', friend: 'Mar', task: 'Reúne las conchas y gira la rueda de agua', clue: 'Avanza por los bordes despejados hasta la rueda; evita las marcas azules.', action: 'Girar rueda de agua', color: '#83b7b7', sky: '#d5e8e6', ground: '#7fa49a', items: 4, enemies: 3, traps: 3 },
    { name: 'La arboleda de las sombras', friend: 'Roble', task: 'Encuentra las bellotas y activa el tótem', clue: 'Espera a que pasen los guardianes y busca el tótem bajo los árboles.', action: 'Activar tótem', color: '#a4b184', sky: '#dce3d3', ground: '#7d956e', items: 5, enemies: 3, traps: 3 },
    { name: 'El observatorio olvidado', friend: 'Estela', task: 'Reúne los astros y alinea el telescopio', clue: 'La estrella más cálida señala el primer astro; el telescopio está en el observatorio.', action: 'Alinear telescopio', color: '#b0a3cf', sky: '#ddd9eb', ground: '#9292a6', items: 5, enemies: 4, traps: 3 },
    { name: 'La cumbre de los vientos', friend: 'Aire', task: 'Recoge las plumas y orienta la veleta', clue: 'Las cintas del suelo marcan las ráfagas; la veleta espera en el mirador.', action: 'Orientar veleta', color: '#c9d5d5', sky: '#e3ebed', ground: '#9caeaa', items: 5, enemies: 4, traps: 4 },
    { name: 'El jardín de las mareas altas', friend: 'Marina', task: 'Salva las semillas y abre la compuerta', clue: 'Espera cerca del claro y evita los remolinos; la compuerta está junto al canal.', action: 'Abrir compuerta', color: '#91b6a2', sky: '#d5e7e0', ground: '#82a892', items: 6, enemies: 5, traps: 4 },
    { name: 'El corazón secreto de Liria', friend: 'Alba', task: 'Reúne los recuerdos y activa el portal final', clue: 'Cada recuerdo ilumina el portal central. Sigue su resplandor.', action: 'Activar portal', color: '#e0bd79', sky: '#eee5cf', ground: '#a8a47d', items: 6, enemies: 5, traps: 5, mechanic: 'standard' },
    { name: 'La cascada de los susurros', friend: 'Susurro', task: 'Activa los cristales de resonancia en el orden correcto', clue: 'El agua guarda el orden en su caída. Sigue el sonido de las gotas.', action: 'Activar cristal', color: '#a8e6cf', sky: '#fef9e7', ground: '#a2d6a2', items: 5, enemies: 3, traps: 3, mechanic: 'sequence' },
    { name: 'El invernadero de cristal perpetuamente congelado', friend: 'Escarcha', task: 'Transporta la llama viva para derretir los cristales helados', clue: 'El calor del corazón derrite lo que el invierno preservó.', action: 'Derretir cristal', color: '#d0f0fd', sky: '#f0f8ff', ground: '#c7e9f1', items: 6, enemies: 4, traps: 4, mechanic: 'carrier' },
    { name: 'El jardín del crepúsculo', friend: 'Amanecer', task: 'Activa las farolas y reúne los fragmentos celestiales', clue: 'La oscuridad revela lo que la luz oculta. La luz vence a las sombras.', action: 'Aliviar la oscuridad', color: '#ffcc80', sky: '#fff3e0', ground: '#d7ccc8', items: 6, enemies: 4, traps: 4, mechanic: 'shadow' },
    { name: 'Las cuevas de la memoria', friend: 'Eco', task: 'Enciende las lámparas de memoria para revelar los recuerdos olvidados', clue: 'Lo que se apaga vuelve a nacer. La memoria es luz en la oscuridad.', action: 'Encender lámpara', color: '#d4afcd', sky: '#e8e1f0', ground: '#b8a9c9', items: 6, enemies: 5, traps: 3, mechanic: 'memory' },
    { name: 'El bosque de los espejos rotos', friend: 'Reflejo', task: 'Desbloquea los fragmentos usando los reflejos de luz', clue: 'Lo roto puede volver a brillar. Dirige la luz hacia lo oculto.', action: 'Alinear espejo', color: '#bcdfff', sky: '#eaf2f8', ground: '#a3c1ad', items: 6, enemies: 5, traps: 4, mechanic: 'reflection' },
    { name: 'El corazón de Liria', friend: 'Liria', task: 'Restaura el corazón del jardín uniendo todos los artefactos', clue: 'Todos los caminos conducen a casa cuando el corazón recuerda.', action: 'Activar corazón', color: '#f9e5d8', sky: '#fff8f0', ground: '#e6dcc8', items: 6, enemies: 6, traps: 5, mechanic: 'convergence' },
];
const challengeLayouts = [
    { start: [8, -2], items: [[6, -5], [12, 0], [16, 7], [22, -5], [14, 5], [26, 2]], traps: [[10, -3], [14, 3], [18, -4], [22, 4], [26, 0]], enemies: [[11, -6], [15, 5], [19, -6], [23, 6], [26, 0]], ally: [28, 8], exit: [26, -8] },
    { start: [18, -2], items: [[16, 7], [21, 0], [26, 7], [32, -5], [18, -3], [30, 10]], traps: [[20, 4], [25, -3], [29, 7], [33, -4], [22, -10]], enemies: [[19, 5], [24, -7], [28, 2], [32, -7], [33, 7]], ally: [34, 9], exit: [36, 6], bridgeTo: [40, 2] },
    { start: [8, 8], items: [[6, 4], [12, 10], [16, 17], [22, 3], [15, 15], [24, 12]], traps: [[10, 11], [14, 13], [18, 15], [22, 14], [26, 9]], enemies: [[11, 13], [15, 16], [19, 14], [23, 14], [26, 9]], ally: [28, 17], exit: [26, 14] },
    { start: [18, 8], items: [[16, 3], [21, 10], [26, 17], [32, 3], [26, 16], [34, 13]], traps: [[20, 14], [24, 15], [28, 17], [32, 16], [35, 11]], enemies: [[17, 16], [23, 9], [27, 16], [33, 9], [35, 8]], ally: [34, 17], exit: [40, 0], bridgeTo: [43, 0] },
    { start: [46, -2], items: [[44, -5], [50, 0], [54, 7], [58, -6], [50, 6], [60, 2]], traps: [[48, -3], [52, 4], [56, -4], [58, 5], [60, 0]], enemies: [[49, -6], [53, 6], [57, -6], [59, 6], [60, 0]], ally: [62, 8], exit: [60, -8], bridgeFrom: [40, 2] },
    { start: [56, -2], items: [[54, 7], [59, 0], [64, 7], [66, -6], [56, -3], [68, 9]], traps: [[58, 4], [63, -3], [65, 7], [66, -5], [62, -10]], enemies: [[57, 5], [62, -7], [66, 2], [68, -7], [68, 7]], ally: [68, 9], exit: [67, 6] },
    { start: [46, 8], items: [[44, 4], [50, 10], [54, 17], [58, 3], [51, 15], [60, 12]], traps: [[48, 11], [52, 13], [56, 15], [58, 14], [60, 9]], enemies: [[49, 13], [53, 16], [57, 14], [59, 14], [60, 9]], ally: [62, 17], exit: [60, 10], bridgeTo: [55, 14] },
    { start: [60, 8], items: [[56, 2], [61, 10], [66, 17], [68, 4], [58, 15], [66, 13]], traps: [[58, 13], [62, 15], [66, 17], [68, 16], [70, 11]], enemies: [[57, 15], [62, 9], [67, 16], [69, 10], [70, 9]], ally: [70, 17], exit: [55, 16], bridgeTo: [40, 16] },
    { start: [46, 18], items: [[44, 14], [50, 20], [54, 27], [58, 13], [51, 25], [60, 22]], traps: [[48, 17], [52, 19], [56, 21], [58, 20], [60, 15]], enemies: [[49, 21], [53, 24], [57, 23], [59, 23], [60, 18]], ally: [62, 27], exit: [60, 12], bridgeFrom: [55, 14] },
    { start: [56, 18], items: [[54, 13], [59, 21], [64, 28], [68, 13], [59, 25], [68, 22]], traps: [[58, 21], [62, 23], [66, 25], [68, 24], [70, 19]], enemies: [[55, 25], [60, 27], [67, 24], [69, 24], [70, 18]], ally: [70, 27], exit: [60, 20], bridgeTo: [40, 24] },
    { start: [46, 28], items: [[44, 24], [50, 30], [54, 37], [58, 23], [51, 35], [60, 32]], traps: [[48, 27], [52, 29], [56, 31], [58, 30], [60, 25]], enemies: [[49, 31], [53, 36], [57, 35], [59, 35], [60, 30]], ally: [62, 37], exit: [60, 22] },
    { start: [56, 28], items: [[54, 23], [59, 30], [64, 37], [68, 23], [59, 36], [68, 32]], traps: [[56, 30], [60, 32], [64, 34], [68, 33], [70, 28]], enemies: [[55, 35], [60, 37], [67, 33], [69, 33], [70, 27]], ally: [70, 37], exit: [38, 30], bridgeFrom: [55, 14], bridgeTo: [40, 24] },
    { start: [10, 30], items: [[8, 23], [14, 30], [18, 37], [24, 22], [17, 34], [26, 32]], traps: [[12, 26], [16, 28], [20, 30], [22, 29], [26, 24]], enemies: [[9, 31], [15, 37], [19, 35], [23, 33], [26, 28]], ally: [28, 37], exit: [26, 24], bridgeFrom: [40, 16] },
    { start: [20, 30], items: [[18, 23], [23, 30], [28, 37], [34, 22], [25, 34], [36, 32]], traps: [[20, 28], [24, 30], [28, 32], [34, 31], [36, 26]], enemies: [[17, 36], [22, 38], [27, 34], [33, 34], [36, 28]], ally: [34, 37], exit: [36, 28], sequenceOrder: [2, 0, 3, 1, 4] },
    { start: [10, 38], items: [[8, 33], [14, 38], [18, 45], [24, 32], [17, 44], [26, 39]], traps: [[10, 37], [16, 39], [20, 41], [24, 40], [26, 34]], enemies: [[9, 43], [15, 45], [19, 43], [23, 41], [26, 38]], ally: [28, 45], exit: [26, 40], carrierPoint: [16, 36], carrierTargets: [12, 38, 20, 42, 18, 40] },
    { start: [20, 38], items: [[18, 33], [23, 38], [28, 45], [34, 32], [26, 44], [36, 39]], traps: [[18, 42], [24, 44], [28, 46], [34, 45], [36, 40]], enemies: [[17, 46], [22, 48], [27, 44], [33, 44], [36, 38]], ally: [34, 45], exit: [36, 42] },
];
    const biomeAssignments = [0, 0, 0, 0, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 3, 3];
    const biomeData = [
        { name: 'Bosque de los Susurros', storyFragment: 'Cuando el jardín aún era joven, los primeros susurros del viento llevaban semillas de vida por todo el terreno. El Duende guarda las claves que solo el bosque puede escuchar.', features: 'forest', npcName: 'Duende', npcIndex: 1, dialogue: ['Duende: ¡Un forastero! Busco las campanillas perdidas del sendero.', 'Duende: Si las encuentras, te revelaré el secreto que Nara olvidó.'] },
        { name: 'Valle de las Rocas', storyFragment: 'Las rocas del valle han guardado el eco de los primeros días, cuando el agua y el viento tejían caminos de piedra. El Guardián vigila el paso entre los picos.', features: 'rocks', npcName: 'Guardián de Roca', npcIndex: 6, dialogue: ['Guardián: El viento silba tu nombre. ¿Vienes a reclamar la cima?', 'Guardián: Solo si resistes la prueba de la altura.'] },
        { name: 'Cascada del Alba', storyFragment: 'La cascada del alba nunca se detiene; su agua pura alimenta cada rincón del jardín. El Dragón Joven ha velado por la corriente desde tiempos inmemoriales.', features: 'waterfall', npcName: 'Dragón Joven', npcIndex: 10, dialogue: ['Draco: El frío pesa sobre mis escamas... ¿Puedes traerme calor?', 'Draco: La llama viva derrite más que hielo: abre caminos que ni el tiempo puede borrar.'] },
        { name: 'Montaña de los Cristales', storyFragment: 'Los cristales reflejan no el presente, sino el posible. El Árbol Parlante susurra verdades que el tiempo olvidó.', features: 'crystals', npcName: 'Árbol Parlante', npcIndex: 14, dialogue: ['Árbol: Cada rama guarda una historia. Escucha el viento entre las hojas.', 'Árbol: Liria floreció aquí, y aquí florecerá de nuevo.'] },
    ];
    const progressStorageKey = 'el-jardin-de-carla:liria:v1';

export function initializeSultanaGarden() {
    const screen = document.querySelector('[data-screen="jardines-liria"]');
    const stage = screen?.querySelector('[data-garden3d-stage]');
    if (!screen || !stage || stage.dataset.initialized === 'true') return;
    stage.dataset.initialized = 'true';

    const status = screen.querySelector('[data-garden3d-status]');
    const collectionCount = screen.querySelector('[data-garden3d-count]');
    const levelIndicator = screen.querySelector('[data-garden3d-level]');
    const objectiveText = screen.querySelector('[data-garden3d-objective-text]');
    const objectiveArrow = screen.querySelector('[data-garden3d-objective-arrow]');
    const questTitle = screen.querySelector('[data-garden3d-quest-title]');
    const questStep = screen.querySelector('[data-garden3d-quest-step]');
    const questProgress = screen.querySelector('[data-garden3d-quest-progress]');
    const questTrack = screen.querySelector('[data-garden3d-quest-track]');
    const pauseButton = screen.querySelector('[data-garden3d-pause]');
    const pauseOverlay = screen.querySelector('[data-garden3d-pause-overlay]');
    const finale = screen.querySelector('[data-garden3d-finale]');
    const loading = screen.querySelector('[data-garden3d-loading]');
    const actionButton = screen.querySelector('[data-garden3d-interact]');
    const loveBanner = screen.querySelector('[data-garden3d-love-banner]');
    const loveQuote = screen.querySelector('[data-garden3d-love-quote]');
    let loveBannerTimer = null;
    const showLoveBanner = (customQuote) => {
        if (!loveBanner || !loveQuote) return;
        const quote = customQuote || loveMessagesForCarla[Math.min(campaignStage - 1, loveMessagesForCarla.length - 1)] || loveMessagesForCarla[0];
        loveQuote.textContent = quote;
        loveBanner.hidden = false;
        clearTimeout(loveBannerTimer);
        loveBannerTimer = setTimeout(() => {
            loveBanner.hidden = true;
        }, 7500);
    };
    const collected = new Set();
    const collectedSeeds = new Set();
    const heldKeys = new Set();
    const touchDirections = new Set();
    let sprinting = false;
    let paused = false;
    let lastStatus = '';
    let lastAction = '';

    const setStatus = (message) => {
        if (lastStatus === message) return;
        lastStatus = message;
        status.textContent = message;
    };

    let storageAvailable = true;
    let savedProgress = null;
    let invalidSavedProgress = false;
    let storedProgress = null;
    try {
        storedProgress = window.localStorage.getItem(progressStorageKey);
    } catch {
        storageAvailable = false;
    }
    if (storedProgress) {
        let parsed;
        try {
            parsed = JSON.parse(storedProgress);
        } catch {
            invalidSavedProgress = true;
        }
        if (!invalidSavedProgress) {
            const validIndices = (indices, length) => Array.isArray(indices)
                && indices.every((index) => Number.isInteger(index) && index >= 0 && index < length)
                && new Set(indices).size === indices.length;
            if (!parsed || typeof parsed !== 'object'
                || ![1, 2, 3, 4].includes(parsed.version)
                || !validIndices(parsed.flowers, flowers.length)
                || typeof parsed.fountain !== 'boolean'
                || !validIndices(parsed.seeds, lightSeeds.length)
                || typeof parsed.tree !== 'boolean'
                || !parsed.player
                || !Number.isFinite(parsed.player.x)
                || !Number.isFinite(parsed.player.z)
                || (parsed.version >= 2 && (!Number.isInteger(parsed.campaignStage)
                    || parsed.campaignStage < 1 || parsed.campaignStage > 19
                    || !validIndices(parsed.challengeItems, 6)
                    || !Number.isInteger(parsed.health) || parsed.health < 1 || parsed.health > 3
                    || typeof parsed.allyHelped !== 'boolean'
                    || typeof parsed.sequenceProgress !== 'number'
                    || typeof parsed.flameCarried !== 'boolean'
                    || typeof parsed.carrierProgress !== 'number'
                    || typeof parsed.reflectionRevealed !== 'boolean'
                    || (parsed.campaignStage > 2 && (!parsed.tree || parsed.challengeItems.length > adventureStages[parsed.campaignStage - 3]?.items))))
                || (parsed.version === 3 && typeof parsed.landmarkActivated !== 'boolean')
                || (parsed.version === 4 && (!Array.isArray(parsed.biomeNPCsSpoken) || parsed.biomeNPCsSpoken.length !== 4 || !parsed.biomeNPCsSpoken.every((v) => typeof v === 'boolean')))
                || (parsed.fountain && parsed.flowers.length !== flowers.length)
                || (!parsed.fountain && parsed.seeds.length > 0)
                || (parsed.tree && (!parsed.fountain || parsed.seeds.length !== lightSeeds.length))) {
                invalidSavedProgress = true;
            } else {
                savedProgress = parsed;
            }
        }
    }
    let restored = savedProgress?.fountain ?? false;
    let level = restored ? 2 : 1;
    let treeAwakened = savedProgress?.tree ?? false;
    let campaignStage = savedProgress?.version >= 2
        ? savedProgress.campaignStage
        : treeAwakened ? 3 : restored ? 2 : 1;
    let challengeItemsCollected = new Set(savedProgress?.version >= 2 ? savedProgress.challengeItems : []);
    let health = savedProgress?.version >= 2 ? savedProgress.health : 3;
    let biomeStoriesKnown = new Set(savedProgress?.version >= 4 ? savedProgress.biomeNPCsSpoken.map((v, i) => v ? i : -1).filter((i) => i >= 0) : []);

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false, powerPreference: 'low-power' });
    } catch {
        stage.dataset.initialized = 'false';
        loading.innerHTML = '<span aria-hidden="true">☼</span><p>Este navegador o dispositivo no tiene WebGL disponible. Prueba en un navegador actualizado con aceleración gráfica activada.</p>';
        setStatus('No se pudo iniciar la escena 3D en este dispositivo.');
        return;
    }

    const scene = new THREE.Scene();
    scene.background = new THREE.Color('#dce8d8');
    scene.fog = new THREE.Fog('#dce8d8', 24, 58);

    const camera = new THREE.PerspectiveCamera(47, 1, 0.1, 100);
    camera.position.set(0, 6.4, 14);
    let cameraYaw = 0;
    let cameraHeight = 5.5;
    let cameraDrag = null;

    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.5));
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFShadowMap;
    stage.append(renderer.domElement);
    renderer.domElement.setAttribute('aria-label', 'Escena tridimensional interactiva del jardín de Liria');
    renderer.domElement.setAttribute('title', 'Arrastra para girar la cámara');
    renderer.domElement.addEventListener('pointerdown', (event) => {
        if (event.button !== 0 || cameraDrag) return;
        cameraDrag = { pointerId: event.pointerId, x: event.clientX, y: event.clientY };
        renderer.domElement.setPointerCapture(event.pointerId);
    });
    renderer.domElement.addEventListener('pointermove', (event) => {
        if (!cameraDrag || cameraDrag.pointerId !== event.pointerId) return;
        cameraYaw -= (event.clientX - cameraDrag.x) * 0.008;
        cameraHeight = THREE.MathUtils.clamp(cameraHeight + (event.clientY - cameraDrag.y) * 0.025, 3.5, 9);
        cameraDrag.x = event.clientX;
        cameraDrag.y = event.clientY;
    });
    const endCameraDrag = (event) => {
        if (cameraDrag?.pointerId === event.pointerId) cameraDrag = null;
    };
    renderer.domElement.addEventListener('pointerup', endCameraDrag);
    renderer.domElement.addEventListener('pointercancel', endCameraDrag);
    renderer.domElement.addEventListener('lostpointercapture', endCameraDrag);

    scene.add(new THREE.HemisphereLight('#fff8ec', '#74835d', 2.1));
    const sunlight = new THREE.DirectionalLight('#fff4dc', 2.3);
    sunlight.position.set(-8, 16, 9);
    sunlight.castShadow = true;
    sunlight.shadow.mapSize.set(1024, 1024);
    sunlight.shadow.camera.left = -19;
    sunlight.shadow.camera.right = 19;
    sunlight.shadow.camera.top = 19;
    sunlight.shadow.camera.bottom = -19;
    scene.add(sunlight);

    const garden = new THREE.Group();
    scene.add(garden);

    const material = (color, roughness = 0.88) => new THREE.MeshStandardMaterial({ color, roughness });
    const grassMaterial = material('#91a878');
    const pathMaterial = material('#d9c8a6');
    const hedgeMaterial = material('#647d5b');
    const trunkMaterial = material('#795b48');
    const leafMaterials = ['#78916b', '#8da37a', '#a5ad7e'].map((color) => material(color));
    const treeBlockers = [];

    const addBox = (parent, size, position, mat) => {
        const mesh = new THREE.Mesh(new THREE.BoxGeometry(...size), mat);
        mesh.position.set(...position);
        mesh.receiveShadow = true;
        mesh.castShadow = size[1] > 0.5;
        parent.add(mesh);
        return mesh;
    };

    const addPlanter = (parent, x, z, palette, width = 3.2, depth = 1.3) => {
        const planter = new THREE.Group();
        planter.position.set(x, 0, z);
        parent.add(planter);
        const soil = material('#76654d');
        const stone = material('#c3b19a');
        addBox(planter, [width, 0.16, depth], [0, 0.12, 0], soil);
        addBox(planter, [width + 0.18, 0.22, 0.12], [0, 0.12, depth / 2], stone);
        addBox(planter, [width + 0.18, 0.22, 0.12], [0, 0.12, -depth / 2], stone);
        addBox(planter, [0.12, 0.22, depth], [-width / 2, 0.12, 0], stone);
        addBox(planter, [0.12, 0.22, depth], [width / 2, 0.12, 0], stone);
        const bloomMaterials = palette.map((color) => material(color));
        const leaf = material('#71875f');
        for (let index = 0; index < 7; index += 1) {
            const localX = (index / 6 - 0.5) * (width - 0.45);
            const localZ = index % 2 ? -0.28 : 0.28;
            const stem = new THREE.Mesh(new THREE.CylinderGeometry(0.025, 0.035, 0.52, 5), leaf);
            stem.position.set(localX, 0.42, localZ);
            planter.add(stem);
            const bloom = new THREE.Mesh(new THREE.SphereGeometry(0.14, 8, 6), bloomMaterials[index % bloomMaterials.length]);
            bloom.position.set(localX, 0.72, localZ);
            bloom.scale.set(1, 0.72, 1);
            planter.add(bloom);
        }
        return planter;
    };

    const addBench = (parent, x, z, rotation = 0) => {
        const bench = new THREE.Group();
        bench.position.set(x, 0, z);
        bench.rotation.y = rotation;
        parent.add(bench);
        const wood = material('#8b6d53');
        addBox(bench, [2.1, 0.13, 0.46], [0, 0.62, 0], wood);
        addBox(bench, [2.1, 0.13, 0.16], [0, 1.0, -0.17], wood);
        [-0.78, 0.78].forEach((side) => {
            addBox(bench, [0.12, 0.62, 0.12], [side, 0.31, 0], wood);
            addBox(bench, [0.12, 0.62, 0.12], [side, 0.31, -0.17], wood);
        });
    };

    const addLantern = (parent, x, z) => {
        const lantern = new THREE.Group();
        lantern.position.set(x, 0, z);
        parent.add(lantern);
        const bronze = material('#74624c', 0.55);
        const glow = new THREE.MeshStandardMaterial({
            color: '#f4dca2',
            emissive: '#e9bd70',
            emissiveIntensity: 0.55,
            roughness: 0.36,
        });
        const post = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.075, 1.55, 7), bronze);
        post.position.y = 0.78;
        lantern.add(post);
        const shade = new THREE.Mesh(new THREE.BoxGeometry(0.36, 0.42, 0.36), glow);
        shade.position.y = 1.72;
        lantern.add(shade);
        const roof = new THREE.Mesh(new THREE.ConeGeometry(0.29, 0.2, 4), bronze);
        roof.position.y = 2.03;
        roof.rotation.y = Math.PI / 4;
        lantern.add(roof);
        return shade;
    };

    const ground = new THREE.Mesh(new THREE.PlaneGeometry(82, 58), grassMaterial);
    ground.rotation.x = -Math.PI / 2;
    ground.position.set(30, -0.08, 18);
    ground.receiveShadow = true;
    garden.add(ground);

    const mainPath = new THREE.Mesh(new THREE.PlaneGeometry(5, 25), pathMaterial);
    mainPath.rotation.x = -Math.PI / 2;
    mainPath.position.set(0, -0.035, -1);
    mainPath.receiveShadow = true;
    garden.add(mainPath);

    const crossPath = new THREE.Mesh(new THREE.PlaneGeometry(25, 4), pathMaterial);
    crossPath.rotation.x = -Math.PI / 2;
    crossPath.position.set(0, -0.03, 0);
    crossPath.receiveShadow = true;
    garden.add(crossPath);
    for (let index = 0; index < 11; index += 1) {
        const stone = new THREE.Mesh(new THREE.CylinderGeometry(0.055, 0.07, 0.025, 7), material('#bdad91'));
        stone.position.set((index % 2 ? 1 : -1) * (2.65 + (index % 3) * 0.18), -0.008, 10 - index * 2.05);
        garden.add(stone);
    }
    addPlanter(garden, -8, -2.2, ['#c77f8d', '#e0ad73', '#9b87b4']);
    addPlanter(garden, 8, 2.2, ['#e0ad73', '#bf8491', '#879d78']);
    addBench(garden, -8.1, 3.8, Math.PI / 2);
    addLantern(garden, -4.1, -4.6);
    addLantern(garden, 4.2, -4.6);
    addLantern(garden, -4.1, 7.1);
    addLantern(garden, 4.2, 7.1);

    addBox(garden, [0.22, 0.58, 32], [-15.4, 0.24, 0], hedgeMaterial);
    for (const index of [-1, 1]) {
        addBox(garden, [0.22, 0.58, 11], [15.4, 0.24, index * 10.5], hedgeMaterial);
        addBox(garden, [32, 0.58, 0.22], [0, 0.24, index * 15.4], hedgeMaterial);
    }

    const secondArea = new THREE.Group();
    garden.add(secondArea);
    secondArea.visible = false;
    const extensionPath = new THREE.Mesh(new THREE.PlaneGeometry(24, 4), pathMaterial);
    extensionPath.rotation.x = -Math.PI / 2;
    extensionPath.position.set(25, -0.025, 0);
    extensionPath.receiveShadow = true;
    secondArea.add(extensionPath);
    const greenhouseClearing = new THREE.Mesh(new THREE.CircleGeometry(10, 40), grassMaterial);
    greenhouseClearing.rotation.x = -Math.PI / 2;
    greenhouseClearing.position.set(37, -0.035, 0);
    greenhouseClearing.receiveShadow = true;
    secondArea.add(greenhouseClearing);
    addBox(secondArea, [0.22, 0.58, 30], [49.5, 0.24, 0], hedgeMaterial);
    for (const index of [-1, 1]) {
        addBox(secondArea, [36, 0.58, 0.22], [32.5, 0.24, index * 15.4], hedgeMaterial);
    }
    const glassMaterial = new THREE.MeshStandardMaterial({
        color: '#d8e9df',
        roughness: 0.35,
        metalness: 0.05,
        transparent: true,
        opacity: 0.36,
        depthWrite: false,
    });
    const greenhouse = new THREE.Group();
    greenhouse.position.set(37, 0, -3);
    secondArea.add(greenhouse);
    addBox(greenhouse, [9, 3, 0.16], [0, 1.5, -4], glassMaterial);
    addBox(greenhouse, [9, 3, 0.16], [0, 1.5, 4], glassMaterial);
    addBox(greenhouse, [0.16, 3, 8], [-4.5, 1.5, 0], glassMaterial);
    addBox(greenhouse, [0.16, 3, 8], [4.5, 1.5, 0], glassMaterial);
    const leftRoof = addBox(greenhouse, [6.4, 0.16, 8.5], [-2, 3.1, 0], glassMaterial);
    leftRoof.rotation.z = -0.35;
    const rightRoof = addBox(greenhouse, [6.4, 0.16, 8.5], [2, 3.1, 0], glassMaterial);
    rightRoof.rotation.z = 0.35;
    const frameMaterial = material('#8b9a78');
    [-4.45, 0, 4.45].forEach((x) => addBox(greenhouse, [0.09, 3, 0.12], [x, 1.5, 3.92], frameMaterial));
    [-2.7, 0, 2.7].forEach((z) => addBox(greenhouse, [0.1, 3, 0.12], [-4.4, 1.5, z], frameMaterial));
    addBox(greenhouse, [0.1, 3, 0.12], [4.4, 1.5, 0], frameMaterial);
    addBench(greenhouse, 0, -1.3);
    addPlanter(greenhouse, -2.7, 2.4, ['#c77f8d', '#e0ad73'], 2, 0.9);
    addPlanter(greenhouse, 2.7, 2.4, ['#9b87b4', '#879d78'], 2, 0.9);
    addLantern(secondArea, 28, -2.8);
    addLantern(secondArea, 28, 2.8);
    addLantern(secondArea, 47, -2.8);
    addLantern(secondArea, 47, 2.8);

    const seedObjects = lightSeeds.map(({ x, z }, index) => {
        const seed = new THREE.Group();
        seed.position.set(x, 0, z);
        secondArea.add(seed);
        const crystal = new THREE.Mesh(
            new THREE.OctahedronGeometry(0.42, 0),
            material(['#e4bf79', '#b4c794', '#d4a9bc'][index], 0.34),
        );
        crystal.position.y = 0.8;
        crystal.castShadow = true;
        seed.add(crystal);
        const ring = new THREE.Mesh(new THREE.TorusGeometry(0.48, 0.035, 6, 20), material('#f4dfad'));
        ring.rotation.x = Math.PI / 2;
        ring.position.y = 0.08;
        seed.add(ring);
        return seed;
    });

    const heartTree = new THREE.Group();
    heartTree.position.set(41, 0, 0);
    secondArea.add(heartTree);
    treeBlockers.push({ x: heartTree.position.x, z: heartTree.position.z, radius: 1.05 });
    const heartTrunk = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.34, 2.4, 8), trunkMaterial);
    heartTrunk.position.y = 1.2;
    heartTrunk.castShadow = true;
    heartTree.add(heartTrunk);
    const heartCanopy = new THREE.Mesh(new THREE.IcosahedronGeometry(1.45, 1), material('#93a982'));
    heartCanopy.position.y = 2.8;
    heartCanopy.castShadow = true;
    heartTree.add(heartCanopy);
    const heartHalo = new THREE.Mesh(new THREE.TorusGeometry(1.9, 0.065, 8, 32), material('#efd48c'));
    heartHalo.position.y = 2.8;
    heartHalo.visible = false;
    heartTree.add(heartHalo);
    const heartSpark = new THREE.PointLight('#f1d68a', 0, 8);
    heartSpark.position.y = 2.8;
    heartTree.add(heartSpark);

    const addTree = (x, z, scale) => {
        treeBlockers.push({ x, z, radius: 0.9 * scale });
        const tree = new THREE.Group();
        tree.position.set(x, 0, z);
        tree.scale.setScalar(scale);
        const trunk = new THREE.Mesh(new THREE.CylinderGeometry(0.18, 0.25, 1.3, 7), trunkMaterial);
        trunk.position.y = 0.65;
        trunk.castShadow = true;
        tree.add(trunk);
        const crown = new THREE.Mesh(new THREE.IcosahedronGeometry(0.95, 1), leafMaterials[treeBlockers.length % leafMaterials.length]);
        crown.position.y = 1.75;
        crown.castShadow = true;
        tree.add(crown);
        garden.add(tree);
    };

    [
        [-12, -10, 1.25], [-9, -12, 0.9], [-13, 1, 1.1], [-11, 11, 1.15],
        [11, -12, 1.05], [13, -7, 1.2], [12, 9, 1.15], [9, 12, 0.92],
        [-8, 12, 0.85], [7, -10, 0.9],
    ].forEach(([x, z, scale]) => addTree(x, z, scale));

    const fountain = new THREE.Group();
    fountain.position.set(0, 0, -10);
    garden.add(fountain);
    const stoneMaterial = material('#c9b8a6');
    const bowl = new THREE.Mesh(new THREE.CylinderGeometry(1.8, 1.55, 0.65, 12), stoneMaterial);
    bowl.position.y = 0.34;
    bowl.receiveShadow = true;
    bowl.castShadow = true;
    fountain.add(bowl);
    const water = new THREE.Mesh(new THREE.CylinderGeometry(1.38, 1.38, 0.12, 16), material('#85bec0', 0.32));
    water.position.y = 0.69;
    water.visible = false;
    fountain.add(water);
    const fountainStem = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.35, 1.1, 10), stoneMaterial);
    fountainStem.position.y = 1.12;
    fountainStem.castShadow = true;
    fountain.add(fountainStem);
    const fountainTop = new THREE.Mesh(new THREE.SphereGeometry(0.42, 14, 10), material('#ddc9b0'));
    fountainTop.position.y = 1.78;
    fountain.add(fountainTop);
    const waterJet = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.12, 1.05, 8), material('#a8dcda', 0.28));
    waterJet.position.y = 2.43;
    waterJet.visible = false;
    fountain.add(waterJet);
    const fountainRing = new THREE.Mesh(new THREE.TorusGeometry(1.82, 0.12, 8, 24), stoneMaterial);
    fountainRing.rotation.x = Math.PI / 2;
    fountainRing.position.y = 0.68;
    fountain.add(fountainRing);

    const addFlower = ({ x, z }, index) => {
        const flower = new THREE.Group();
        flower.position.set(x, 0, z);
        garden.add(flower);
        const stem = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.065, 0.78, 6), material('#66845c'));
        stem.position.y = 0.39;
        flower.add(stem);
        const leaf = new THREE.Mesh(new THREE.SphereGeometry(0.16, 8, 6), material('#8ea16b'));
        leaf.scale.set(1.7, 0.45, 0.75);
        leaf.position.set(index % 2 ? 0.14 : -0.14, 0.35, 0);
        flower.add(leaf);
        const bloom = new THREE.Group();
        bloom.position.y = 0.84;
        flower.add(bloom);
        const petalMaterial = material(['#c77f8d', '#d9a06f', '#9b87b4'][index]);
        for (let petal = 0; petal < 5; petal += 1) {
            const angle = petal * (Math.PI * 2 / 5);
            const mesh = new THREE.Mesh(new THREE.SphereGeometry(0.19, 9, 7), petalMaterial);
            mesh.scale.set(0.85, 0.52, 1.25);
            mesh.position.set(Math.cos(angle) * 0.2, 0, Math.sin(angle) * 0.2);
            mesh.rotation.y = -angle;
            bloom.add(mesh);
        }
        const center = new THREE.Mesh(new THREE.SphereGeometry(0.13, 9, 7), material('#e8c876'));
        bloom.add(center);
        const marker = new THREE.Mesh(new THREE.TorusGeometry(0.32, 0.035, 6, 18), material('#f4d89e'));
        marker.rotation.x = Math.PI / 2;
        marker.position.y = 0.05;
        flower.add(marker);
        flower.userData.index = index;
        flower.userData.bloom = bloom;
        flower.userData.baseY = bloom.position.y;
        return flower;
    };
    const flowerObjects = flowers.map(addFlower);

    // Nombres aleatorios refinados para personajes secundarios y aliados
    const randomCharacterNames = [
        'Mateo el Cuidador',
        'Eliseo el Jardinero',
        'Ariadna la Guía',
        'Darío el Sabio',
        'Valeria del Alba',
        'Lucas el Botánico',
        'Caelum el Místico',
        'Silvia de la Arboleda',
        'Bastián de las Rosas',
        'Clara de los Vientos',
        'Gabriel el Guardián',
        'Aura de la Fuente',
        'Faelar el Explorador',
        'Isolda del Bosque',
        'Renato el Custodio'
    ];
    let nextRandomNameIdx = 0;
    const getRandomCharacterName = () => {
        const name = randomCharacterNames[nextRandomNameIdx % randomCharacterNames.length];
        nextRandomNameIdx++;
        return name;
    };

    // Generador de carteles flotantes (NameTags) en letras pequeñas y elegantes
    const buildCharacterNameTag = (text, isPlayer = false) => {
        const canvas = document.createElement('canvas');
        canvas.width = 384;
        canvas.height = 96;
        const ctx = canvas.getContext('2d');
        if (!ctx) return null;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Cápsula de fondo estilizada
        const radius = 24;
        const x = 12, y = 14, w = canvas.width - 24, h = canvas.height - 28;

        ctx.save();
        ctx.beginPath();
        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + w - radius, y);
        ctx.quadraticCurveTo(x + w, y, x + w, y + radius);
        ctx.lineTo(x + w, y + h - radius);
        ctx.quadraticCurveTo(x + w, y + h, x + w - radius, y + h);
        ctx.lineTo(x + radius, y + h);
        ctx.quadraticCurveTo(x, y + h, x, y + h - radius);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x + radius, y);
        ctx.closePath();

        if (isPlayer) {
            // Fondo real de alta distinción para la Princesa Carla Lorena
            const grad = ctx.createLinearGradient(x, y, x + w, y + h);
            grad.addColorStop(0, 'rgba(84, 30, 44, 0.90)');
            grad.addColorStop(1, 'rgba(52, 16, 26, 0.94)');
            ctx.fillStyle = grad;
            ctx.fill();
            ctx.strokeStyle = '#f8d488';
            ctx.lineWidth = 4;
            ctx.stroke();
        } else {
            // Fondo neutro elegante y traslúcido para los personajes secundarios
            const grad = ctx.createLinearGradient(x, y, x + w, y + h);
            grad.addColorStop(0, 'rgba(40, 36, 32, 0.84)');
            grad.addColorStop(1, 'rgba(26, 24, 22, 0.88)');
            ctx.fillStyle = grad;
            ctx.fill();
            ctx.strokeStyle = 'rgba(218, 208, 192, 0.78)';
            ctx.lineWidth = 3;
            ctx.stroke();
        }
        ctx.restore();

        // Tipografía en letras pequeñas y nítidas
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        if (isPlayer) {
            ctx.font = 'bold 27px "Cinzel Decorative", "Playfair Display", Georgia, serif';
            ctx.fillStyle = '#fff8e8';
            ctx.shadowColor = 'rgba(248, 212, 136, 0.7)';
            ctx.shadowBlur = 6;
            ctx.fillText(`👑 ${text}`, canvas.width / 2, y + h / 2 + 1);
        } else {
            ctx.font = '600 24px "DM Sans", -apple-system, sans-serif';
            ctx.fillStyle = '#f4eee4';
            ctx.shadowColor = 'rgba(0, 0, 0, 0.6)';
            ctx.shadowBlur = 4;
            ctx.fillText(text, canvas.width / 2, y + h / 2 + 1);
        }

        const texture = new THREE.CanvasTexture(canvas);
        texture.minFilter = THREE.LinearFilter;
        texture.needsUpdate = true;

        const spriteMat = new THREE.SpriteMaterial({
            map: texture,
            transparent: true,
            depthWrite: false,
        });
        const sprite = new THREE.Sprite(spriteMat);
        const scaleW = isPlayer ? 1.45 : 1.25;
        const scaleH = scaleW * (canvas.height / canvas.width);
        sprite.scale.set(scaleW, scaleH, 1);
        // Posicionado suavemente sobre la cabeza/corona
        sprite.position.set(0, isPlayer ? 2.65 : 2.45, 0);
        return sprite;
    };

    const createCharacter = ({ x, z, player = false, name = null }) => {
        const root = new THREE.Group();
        root.position.set(x, 0, z);
        garden.add(root);
        // Modelo Botánico de Alta Costura para Carla Lorena
        const skin = material(player ? '#fedbc9' : '#d6ad8f');
        const cloth = material(player ? '#c46d80' : '#74876a'); // Terciopelo Rosa Real
        const accent = material(player ? '#e8a8b5' : '#b97e77'); // Seda Rosa Suave
        const goldMat = new THREE.MeshStandardMaterial({
            color: '#f7cf68',
            emissive: '#d8a838',
            emissiveIntensity: 0.35,
            metalness: 0.7,
            roughness: 0.25
        });
        const torso = new THREE.Mesh(new THREE.CapsuleGeometry(0.34, 0.58, 4, 8), cloth);
        torso.position.y = 1.12;
        torso.castShadow = true;
        root.add(torso);
        const skirt = new THREE.Mesh(new THREE.ConeGeometry(0.56, 0.78, 12), accent);
        skirt.position.y = 0.55;
        skirt.rotation.x = Math.PI;
        skirt.castShadow = true;
        root.add(skirt);
        if (player) {
            // Ribete dorado de la falda
            const skirtTrim = new THREE.Mesh(new THREE.TorusGeometry(0.55, 0.035, 6, 20), goldMat);
            skirtTrim.rotation.x = Math.PI / 2;
            skirtTrim.position.y = 0.18;
            root.add(skirtTrim);
            // Broche floral de oro en el pecho
            const heartBrooch = new THREE.Mesh(new THREE.SphereGeometry(0.075, 8, 8), goldMat);
            heartBrooch.position.set(0, 1.32, 0.32);
            root.add(heartBrooch);
        }
        const head = new THREE.Mesh(new THREE.SphereGeometry(0.31, 14, 12), skin);
        head.position.y = 1.88;
        head.castShadow = true;
        root.add(head);
        const hairMat = material(player ? '#4e323b' : '#564546');
        const hair = new THREE.Mesh(new THREE.SphereGeometry(0.34, 14, 10, 0, Math.PI * 2, 0, Math.PI * 0.55), hairMat);
        hair.position.set(0, 2.0, -0.025);
        root.add(hair);
        if (player) {
            // Cabello Real Largo hasta la cintura para la Princesa Carla Lorena
            // Volumen superior trasero que cubre nuca y nacimiento
            const backHairVolume = new THREE.Mesh(
                new THREE.SphereGeometry(0.33, 12, 10, 0, Math.PI * 2, 0, Math.PI * 0.7),
                hairMat
            );
            backHairVolume.position.set(0, 1.95, -0.07);
            backHairVolume.castShadow = true;
            root.add(backHairVolume);

            // Mechones traseros largos que caen en cascada hasta la cintura con articulación doble
            const hairStrands = [];
            const strandOffsets = [-0.18, -0.09, 0, 0.09, 0.18];
            strandOffsets.forEach((offset, idx) => {
                const strandPivot = new THREE.Group();
                const angle = (idx - 2) * 0.25;
                const posX = Math.sin(angle) * 0.20;
                const posZ = -0.18 - Math.cos(angle) * 0.05;
                strandPivot.position.set(posX, 1.80, posZ);
                strandPivot.rotation.z = offset * -0.15;

                const upperLength = 0.46;
                const upperLock = new THREE.Mesh(
                    new THREE.CylinderGeometry(0.055, 0.048, upperLength, 7),
                    hairMat
                );
                upperLock.position.y = -upperLength / 2;
                upperLock.castShadow = true;
                strandPivot.add(upperLock);

                const lowerPivot = new THREE.Group();
                lowerPivot.position.y = -upperLength;

                const lowerLength = 0.48;
                const lowerLock = new THREE.Mesh(
                    new THREE.CylinderGeometry(0.048, 0.026, lowerLength, 7),
                    hairMat
                );
                lowerLock.position.y = -lowerLength / 2;
                lowerLock.castShadow = true;
                lowerPivot.add(lowerLock);

                strandPivot.add(lowerPivot);
                strandPivot.userData.lowerJoint = lowerPivot;

                root.add(strandPivot);
                hairStrands.push(strandPivot);
            });
            root.userData.hairStrands = hairStrands;

            // Mechones frontales elegantes cayendo sobre el pecho
            const frontHairStrands = [];
            [-0.22, 0.22].forEach((side) => {
                const frontPivot = new THREE.Group();
                frontPivot.position.set(side, 1.82, 0.10);
                const frontUpper = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.035, 0.38, 6), hairMat);
                frontUpper.position.y = -0.19;
                frontUpper.rotation.z = side * -0.14;
                frontUpper.castShadow = true;
                frontPivot.add(frontUpper);

                const frontLower = new THREE.Mesh(new THREE.CylinderGeometry(0.035, 0.02, 0.32, 6), hairMat);
                frontLower.position.set(side * 0.03, -0.48, 0.02);
                frontLower.rotation.z = side * -0.10;
                frontLower.castShadow = true;
                frontPivot.add(frontLower);

                root.add(frontPivot);
                frontHairStrands.push(frontPivot);
            });
            root.userData.frontHairStrands = frontHairStrands;

            // Broche real de sujeción del cabello en la nuca
            const hairClasp = new THREE.Mesh(new THREE.TorusGeometry(0.08, 0.02, 6, 14), goldMat);
            hairClasp.position.set(0, 1.76, -0.22);
            root.add(hairClasp);

            // Corona Dorada Real con resplandor
            const crownRing = new THREE.Mesh(new THREE.TorusGeometry(0.24, 0.035, 6, 16), goldMat);
            crownRing.position.y = 2.22;
            crownRing.rotation.x = Math.PI / 2;
            root.add(crownRing);
            for (let i = 0; i < 5; i++) {
                const spike = new THREE.Mesh(new THREE.ConeGeometry(0.045, 0.16, 5), goldMat);
                const ang = (i / 5) * Math.PI * 2;
                spike.position.set(Math.cos(ang) * 0.22, 2.28, Math.sin(ang) * 0.22);
                root.add(spike);
            }
            // Halo de Amor y Destellos sobre Carla Lorena
            const loveHaloLight = new THREE.PointLight('#f5c2cd', 1.4, 4.5);
            loveHaloLight.position.set(0, 2.1, 0);
            root.add(loveHaloLight);
        }
        const eyesMaterial = material('#382729');
        // Ojos ubicados en el frente (+Z) hacia donde camina y mira el personaje de frente
        [-0.1, 0.1].forEach((offset) => {
            const eye = new THREE.Mesh(new THREE.SphereGeometry(0.029, 6, 5), eyesMaterial);
            eye.position.set(offset, 1.91, 0.282);
            root.add(eye);
        });
        if (player) {
            const smileMat = material('#c45b70');
            const smile = new THREE.Mesh(new THREE.TorusGeometry(0.05, 0.015, 4, 8, Math.PI), smileMat);
            smile.position.set(0, 1.81, 0.29);
            smile.rotation.x = Math.PI;
            root.add(smile);
        }
        const legs = [-1, 1].map((side) => {
            const pivot = new THREE.Group();
            pivot.position.set(side * 0.14, 0.32, 0);
            const leg = new THREE.Mesh(new THREE.CylinderGeometry(0.09, 0.075, 0.48, 7), material(player ? '#7a4d59' : '#655964'));
            leg.position.y = -0.12;
            pivot.add(leg);
            root.add(pivot);
            return pivot;
        });
        const arms = [-1, 1].map((side) => {
            const pivot = new THREE.Group();
            pivot.position.set(side * 0.36, 1.38, 0);
            const arm = new THREE.Mesh(new THREE.CylinderGeometry(0.09, 0.075, 0.48, 7), cloth);
            arm.position.y = -0.22;
            pivot.add(arm);
            root.add(pivot);
            return pivot;
        });
        const characterName = player ? 'Carla Lorena' : (name || getRandomCharacterName());
        root.userData.characterName = characterName;
        const nameTag = buildCharacterNameTag(characterName, player);
        if (nameTag) {
            root.add(nameTag);
            root.userData.nameTag = nameTag;
        }
        root.userData.setName = (newName) => {
            if (root.userData.nameTag) {
                root.remove(root.userData.nameTag);
                if (root.userData.nameTag.material.map) root.userData.nameTag.material.map.dispose();
                root.userData.nameTag.material.dispose();
            }
            root.userData.characterName = newName;
            const newTag = buildCharacterNameTag(newName, player);
            if (newTag) {
                root.add(newTag);
                root.userData.nameTag = newTag;
            }
        };
        return { root, torso, legs, arms };
    };

    const player = createCharacter({ x: 0, z: 10, player: true, name: 'Carla Lorena' });
    const gardener = createCharacter({ x: 5.6, z: -7.5, name: 'Eliseo el Jardinero' });
    gardener.root.userData.waypoints = [
        [5.6, -7.5],
        [8.2, -5.2],
        [3.5, -5.8],
    ];
    gardener.root.userData.wpIdx = 0;
    gardener.root.userData.patrolSpeed = 1.35;
    gardener.root.userData.seed = 0.5;
    const challengeItems = Array.from({ length: 6 }, (_, index) => {
        const item = new THREE.Group();
        const gem = new THREE.Mesh(
            new THREE.OctahedronGeometry(0.34, 0),
            material(['#f1d68a', '#a9c7d0', '#d49bab', '#a8c9d4', '#83b7b7', '#a4b184'][index]),
        );
        gem.position.y = 0.82;
        gem.castShadow = true;
        item.add(gem);
        const ring = new THREE.Mesh(new THREE.TorusGeometry(0.43, 0.035, 6, 18), material('#f4dfad'));
        ring.rotation.x = Math.PI / 2;
        ring.position.y = 0.08;
        item.add(ring);
        secondArea.add(item);
        return item;
    });
    const challengeAlly = createCharacter({ x: 37, z: 9, name: 'Ariadna la Aliada' });
    challengeAlly.root.visible = false;
    const exitGate = new THREE.Group();
    const gateMaterial = new THREE.MeshStandardMaterial({
        color: '#d6b767',
        emissive: '#d6b767',
        emissiveIntensity: 0.28,
        roughness: 0.42,
    });
    [-1.1, 1.1].forEach((x) => {
        const pillar = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.18, 2.4, 8), gateMaterial);
        pillar.position.set(x, 1.2, 0);
        exitGate.add(pillar);
    });
    const gateArch = new THREE.Mesh(new THREE.TorusGeometry(1.1, 0.12, 8, 24, Math.PI), gateMaterial);
    gateArch.position.y = 2.35;
    gateArch.rotation.z = Math.PI;
    exitGate.add(gateArch);
    exitGate.position.set(36, 0, -9);
    exitGate.visible = false;
    secondArea.add(exitGate);

    // Puente Floreciente de Unión entre Mundos
    const realmBridge = new THREE.Group();
    realmBridge.visible = false;
    secondArea.add(realmBridge);

    const bridgePlankMat = material('#7d5642', 0.85);
    const bridgeRoseMat = material('#e292a4', 0.4);
    const bridgeLight = new THREE.PointLight('#ffdfb3', 0, 14);
    bridgeLight.position.y = 1.2;
    realmBridge.add(bridgeLight);

    const buildBridgeBetweenRealms = (fromPos, toPos) => {
        while (realmBridge.children.length > 1) {
            realmBridge.remove(realmBridge.children[realmBridge.children.length - 1]);
        }
        const dx = toPos[0] - fromPos[0];
        const dz = toPos[1] - fromPos[1];
        const length = Math.hypot(dx, dz);
        const angle = Math.atan2(dx, dz);

        realmBridge.position.set(fromPos[0], 0.1, fromPos[1]);
        realmBridge.rotation.y = angle;

        const plankCount = Math.max(6, Math.ceil(length / 0.95));
        for (let i = 0; i <= plankCount; i++) {
            const zStep = (i / plankCount) * length;
            const plank = new THREE.Mesh(new THREE.BoxGeometry(2.2, 0.16, 0.72), bridgePlankMat);
            plank.position.set(0, 0, zStep);
            plank.castShadow = true;
            plank.receiveShadow = true;
            realmBridge.add(plank);

            if (i % 3 === 0) {
                [-1.15, 1.15].forEach((side) => {
                    const post = new THREE.Mesh(new THREE.CylinderGeometry(0.045, 0.055, 0.75, 6), bridgePlankMat);
                    post.position.set(side, 0.38, zStep);
                    realmBridge.add(post);

                    const rose = new THREE.Mesh(new THREE.SphereGeometry(0.11, 8, 6), bridgeRoseMat);
                    rose.position.set(side, 0.78, zStep);
                    realmBridge.add(rose);
                });
            }
        }
        bridgeLight.position.set(0, 1.2, length / 2);
        bridgeLight.intensity = 2.4;
        realmBridge.visible = true;
    };

    // ===== SISTEMA DE MENSAJES DE AMOR EN ESCENARIOS 3D =====
    const buildLoveSignTexture = (text, textColor, bgColor) => {
        const W = 1024, H = 288;
        const canvas = document.createElement('canvas');
        canvas.width = W; canvas.height = H;
        const ctx = canvas.getContext('2d');
        const r = parseInt(bgColor.slice(1,3),16);
        const g = parseInt(bgColor.slice(3,5),16);
        const b = parseInt(bgColor.slice(5,7),16);
        ctx.clearRect(0,0,W,H);
        ctx.fillStyle = `rgba(${r},${g},${b},0.92)`;
        ctx.fillRect(4,4,W-8,H-8);
        const grad = ctx.createLinearGradient(0,0,W,0);
        grad.addColorStop(0,'rgba(255,255,255,0.04)');
        grad.addColorStop(0.5,'rgba(255,255,255,0.14)');
        grad.addColorStop(1,'rgba(255,255,255,0.04)');
        ctx.fillStyle = grad; ctx.fillRect(4,4,W-8,H-8);
        ctx.strokeStyle = textColor; ctx.lineWidth = 5;
        ctx.strokeRect(10,10,W-20,H-20);
        ctx.strokeStyle = textColor+'55'; ctx.lineWidth = 2;
        ctx.strokeRect(18,18,W-36,H-36);
        ctx.font='bold 42px serif'; ctx.fillStyle='#ff69b4';
        ctx.textAlign='left';  ctx.fillText('♥',26,64);
        ctx.textAlign='right'; ctx.fillText('♥',W-26,64);
        ctx.font='24px serif'; ctx.fillStyle='#ff9fc4';
        ctx.textAlign='left';  ctx.fillText('♡',62,52);
        ctx.textAlign='right'; ctx.fillText('♡',W-62,52);
        ctx.fillStyle = textColor; ctx.textAlign = 'center';
        ctx.font = 'bold 26px Georgia,serif';
        const maxW = W - 110; const lh = 40;
        const words = text.split(' ');
        const lines = []; let cur = '';
        for (const w of words) {
            const t = cur ? `${cur} ${w}` : w;
            if (ctx.measureText(t).width > maxW && cur) { lines.push(cur); cur = w; }
            else cur = t;
        }
        if (cur) lines.push(cur);
        let y = (H - lines.length * lh) / 2 + lh * 0.88;
        for (const l of lines) { ctx.fillText(l, W/2, y); y += lh; }
        const tex = new THREE.CanvasTexture(canvas);
        tex.needsUpdate = true;
        return tex;
    };

    // Floating sign mesh (sky / pillar) — billboard
    const loveSignMesh = new THREE.Mesh(
        new THREE.PlaneGeometry(9.5, 2.8),
        new THREE.MeshBasicMaterial({ transparent:true, opacity:0.96, side:THREE.DoubleSide, depthWrite:false })
    );
    loveSignMesh.visible = false;
    loveSignMesh.userData.baseY = 9.5;
    secondArea.add(loveSignMesh);

    // Ground inscription mesh
    const loveGroundMesh = new THREE.Mesh(
        new THREE.PlaneGeometry(11, 3.4),
        new THREE.MeshBasicMaterial({ transparent:true, opacity:0.92, side:THREE.DoubleSide, depthWrite:false })
    );
    loveGroundMesh.rotation.x = -Math.PI / 2;
    loveGroundMesh.visible = false;
    secondArea.add(loveGroundMesh);

    // Static sky sign for main garden — Stage 1
    const gardenLoveSign = new THREE.Mesh(
        new THREE.PlaneGeometry(7.5, 2.3),
        new THREE.MeshBasicMaterial({
            map: buildLoveSignTexture(stageEnvironmentMessages[0].text, stageEnvironmentMessages[0].color, stageEnvironmentMessages[0].bgColor),
            transparent:true, opacity:0.94, side:THREE.DoubleSide, depthWrite:false
        })
    );
    gardenLoveSign.position.set(0, 7.8, 0);
    garden.add(gardenLoveSign);

    // Static ground sign for secondArea greenhouse — Stage 2
    const greenhouseLoveSign = new THREE.Mesh(
        new THREE.PlaneGeometry(10, 3.2),
        new THREE.MeshBasicMaterial({
            map: buildLoveSignTexture(stageEnvironmentMessages[1].text, stageEnvironmentMessages[1].color, stageEnvironmentMessages[1].bgColor),
            transparent:true, opacity:0.90, side:THREE.DoubleSide, depthWrite:false
        })
    );
    greenhouseLoveSign.rotation.x = -Math.PI / 2;
    greenhouseLoveSign.position.set(38, 0.04, 1);
    secondArea.add(greenhouseLoveSign);

    const updateStageSign = () => {
        const si = campaignStage - 3;
        loveSignMesh.visible = false;
        loveGroundMesh.visible = false;
        if (si < 0 || si >= challengeLayouts.length) return;
        const mi = Math.min(si + 2, stageEnvironmentMessages.length - 1);
        const msg = stageEnvironmentMessages[mi];
        const layout = challengeLayouts[si];
        const cx = layout.items.reduce((s,p) => s + p[0], 0) / layout.items.length;
        const cz = layout.items.reduce((s,p) => s + p[1], 0) / layout.items.length;
        const tex = buildLoveSignTexture(msg.text, msg.color, msg.bgColor);
        if (msg.placement === 'ground') {
            loveGroundMesh.material.map = tex;
            loveGroundMesh.material.needsUpdate = true;
            loveGroundMesh.position.set(cx, 0.04, cz);
            loveGroundMesh.visible = true;
        } else {
            const baseY = msg.placement === 'sky' ? 9.5 : 3.8;
            loveSignMesh.material.map = tex;
            loveSignMesh.material.needsUpdate = true;
            loveSignMesh.position.set(cx, baseY, cz);
            loveSignMesh.userData.baseY = baseY;
            loveSignMesh.visible = true;
        }
    };
    // ===== FIN SISTEMA DE MENSAJES =====

    const enemyTypes = ['patrol', 'patrol', 'flying', 'sentry', 'phase', 'flying'];
    const enemySlotColors = ['#67434f', '#8a5a44', '#4a6a5a', '#5d4b7d', '#a0523d', '#6b4f8a'];
    const enemyNames = ['Guardián Sombrío', 'Centinela Nocturno', 'Espectro Errante', 'Sombra Veloz', 'Vigía del Ocaso', 'Fantasma del Valle'];
    const enemyCharacterCount = enemyTypes.length; // 6 enemigos (patrol ×2, flying ×2, sentry, phase)
    const enemyCharacters = Array.from({ length: enemyCharacterCount }, (_, index) => {
        const enemy = createCharacter({ x: 22 + index * 2, z: index % 2 ? 6 : -6, name: enemyNames[index % enemyNames.length] });
        enemy.root.visible = false;
        enemy.root.scale.setScalar(0.78);
        const enemyType = enemyTypes[index];
        const enemyColor = enemySlotColors[index];
        enemy.root.userData.type = enemyType;
        const enemyMat = material(enemyColor);
        const hornMaterial = material(enemyColor, 0.55);
        [-1, 1].forEach((side) => {
            const horn = new THREE.Mesh(new THREE.ConeGeometry(0.13, 0.42, 6), hornMaterial);
            horn.position.set(side * 0.2, 2.26, -0.02);
            horn.rotation.z = side * -0.35;
            enemy.root.add(horn);
        });
        if (enemyType === 'flying') {
            enemy.root.userData.flyHeight = 1.8;
            [-1, 1].forEach((side) => {
                const wing = new THREE.Mesh(new THREE.BoxGeometry(1.1, 0.04, 0.4), enemyMat);
                wing.position.set(side * 0.7, 1.9, side * 0.18);
                wing.rotation.y = side * 0.3;
                enemy.root.add(wing);
            });
            const eyeGlow = new THREE.Mesh(new THREE.SphereGeometry(0.05, 6, 5),
                new THREE.MeshStandardMaterial({ color: enemyColor, emissive: enemyColor, emissiveIntensity: 0.6, roughness: 0.3 }));
            eyeGlow.position.set(0, 1.95, -0.28);
            enemy.root.add(eyeGlow);
        } else if (enemyType === 'sentry') {
            const baseRing = new THREE.Mesh(
                new THREE.TorusGeometry(0.8, 0.08, 4, 12),
                material('#5a4a42', 0.5),
            );
            baseRing.rotation.x = Math.PI / 2;
            baseRing.position.y = 0.15;
            enemy.root.add(baseRing);
            enemy.root.userData.patrolX = enemy.root.position.x;
            enemy.root.userData.patrolZ = enemy.root.position.z;
        } else if (enemyType === 'phase') {
            const eyeGlow = new THREE.Mesh(new THREE.SphereGeometry(0.05, 6, 5),
                new THREE.MeshStandardMaterial({ color: '#a870d1', emissive: '#a870d1', emissiveIntensity: 0.8, roughness: 0.3 }));
            eyeGlow.position.set(0, 1.92, -0.28);
            enemy.root.add(eyeGlow);
            enemy.root.userData.eyeGlow = eyeGlow;
        }
        const warningRing = new THREE.Mesh(
            new THREE.TorusGeometry(0.68, 0.055, 6, 18),
            new THREE.MeshStandardMaterial({
                color: enemyType === 'phase' ? '#7d5a9e' : '#b66068',
                emissive: enemyType === 'phase' ? '#7d5a9e' : '#a53548',
                emissiveIntensity: 0.45,
                roughness: 0.5,
            }),
        );
        warningRing.rotation.x = Math.PI / 2;
        warningRing.position.y = 0.08;
        enemy.root.add(warningRing);
        enemy.root.userData.warningRing = warningRing;
        return enemy;
    });
    const trapObjects = Array.from({ length: 5 }, (_, index) => {
        const trap = new THREE.Group();
        const ring = new THREE.Mesh(
            new THREE.TorusGeometry(0.82, 0.08, 6, 20),
            material(index % 2 ? '#c47e79' : '#d28d74'),
        );
        ring.rotation.x = Math.PI / 2;
        ring.position.y = 0.06;
        trap.add(ring);
        const center = new THREE.Mesh(new THREE.CircleGeometry(0.58, 16), new THREE.MeshStandardMaterial({
            color: '#806954',
            emissive: '#b04440',
            emissiveIntensity: 0.22,
            roughness: 0.72,
        }));
        center.rotation.x = -Math.PI / 2;
        center.position.y = 0.015;
        trap.add(center);
        trap.visible = false;
        secondArea.add(trap);
        return trap;
    });
    const stageLandmarks = adventureStages.map((config, index) => {
        const landmark = new THREE.Group();
        landmark.position.set(29, 0, 11);
        const accent = material(config.color, 0.5);
        const wood = material('#80674e');
        const leaf = material(config.ground);
        const addPart = (geometry, mat, position, rotation = [0, 0, 0]) => {
            const mesh = new THREE.Mesh(geometry, mat);
            mesh.position.set(...position);
            mesh.rotation.set(...rotation);
            mesh.castShadow = true;
            mesh.receiveShadow = true;
            landmark.add(mesh);
            return mesh;
        };
        addPart(new THREE.CylinderGeometry(1.3, 1.45, 0.18, 12), material('#c3b19a'), [0, 0.08, 0]);
        if (index === 0) {
            addPart(new THREE.CylinderGeometry(0.09, 0.14, 2.2, 8), wood, [0, 1.2, 0]);
            addPart(new THREE.SphereGeometry(0.48, 12, 10), accent, [0, 2.45, 0]);
            addPart(new THREE.SphereGeometry(0.2, 10, 8), material('#fff0b6'), [0, 2.45, 0]);
        } else if (index === 1) {
            addPart(new THREE.BoxGeometry(3.2, 0.2, 1.1), wood, [0, 0.7, 0]);
            [-1.25, 1.25].forEach((x) => addPart(new THREE.BoxGeometry(0.14, 1.5, 0.14), accent, [x, 1.35, 0]));
            addPart(new THREE.BoxGeometry(2.8, 0.14, 0.14), accent, [0, 2.0, 0]);
        } else if (index === 2) {
            [-0.85, 0, 0.85].forEach((x, i) => {
                addPart(new THREE.CylinderGeometry(0.035, 0.05, 1.7, 5), leaf, [x, 0.95, 0]);
                addPart(new THREE.SphereGeometry(0.28, 9, 7), accent, [x, 1.9 + (i % 2) * 0.2, 0]);
            });
        } else if (index === 3) {
            [-0.75, 0, 0.75].forEach((x, i) => addPart(
                new THREE.OctahedronGeometry(i === 1 ? 0.9 : 0.58, 0),
                accent,
                [x, i === 1 ? 1.15 : 0.8, 0],
            ));
        } else if (index === 4 || index === 8) {
            addPart(new THREE.TorusGeometry(index === 4 ? 1 : 0.75, 0.16, 8, 24), accent, [0, 0.85, 0], [Math.PI / 2, 0, 0]);
            addPart(new THREE.CylinderGeometry(0.16, 0.16, 1.3, 8), leaf, [0, 0.8, 0]);
            addPart(new THREE.SphereGeometry(0.35, 10, 8), material('#a8dcda'), [0.5, 1.7, 0]);
        } else if (index === 5) {
            addPart(new THREE.CylinderGeometry(0.2, 0.35, 1.4, 8), wood, [0, 0.8, 0]);
            addPart(new THREE.IcosahedronGeometry(1, 1), leaf, [0, 1.9, 0]);
            addPart(new THREE.IcosahedronGeometry(0.58, 1), accent, [0.5, 2.35, 0.15]);
        } else if (index === 6) {
            addPart(new THREE.CylinderGeometry(0.1, 0.18, 2.4, 8), wood, [0, 1.3, 0]);
            addPart(new THREE.CylinderGeometry(0.32, 0.32, 0.8, 10), accent, [0, 2.15, 0], [0.45, 0, 0]);
            addPart(new THREE.TorusGeometry(1.05, 0.065, 8, 24), accent, [0, 2.1, 0], [Math.PI / 2, 0, 0]);
        } else if (index === 7) {
            addPart(new THREE.CylinderGeometry(0.12, 0.2, 2.5, 8), wood, [0, 1.35, 0]);
            [-1, 1].forEach((side) => addPart(new THREE.BoxGeometry(0.16, 1.5, 0.12), accent, [side * 0.55, 2.2, 0], [0, 0, side * 0.62]));
            addPart(new THREE.SphereGeometry(0.22, 10, 8), leaf, [0, 2.2, 0]);
        } else if (index === 10) {
            addPart(new THREE.CylinderGeometry(0.14, 0.18, 0.22, 8), material('#c3b19a'), [0, 0.08, 0]);
            [-0.7, 0, 0.7].forEach((x, i) => {
                addPart(new THREE.OctahedronGeometry(i === 1 ? 0.7 : 0.48, 0), material(['#e4bf79', '#b4c794', '#d4a9bc'][i]), [x, 0.5 + (i % 2) * 0.3, 0]);
                addPart(new THREE.ConeGeometry(0.24, 0.48, 6), accent, [x, 0.8 + (i % 2) * 0.3, 0]);
            });
            addPart(new THREE.TorusGeometry(0.95, 0.08, 8, 24), accent, [0, 1.8, 0], [Math.PI / 2, 0, 0]);
        } else if (index === 11) {
            addPart(new THREE.CylinderGeometry(0.26, 0.34, 1.4, 10), material('#d0f0fd', 0.18), [0, 0.8, 0]);
            addPart(new THREE.IcosahedronGeometry(0.52, 0), material('#b0d8f0', 0.26), [0, 1.5, 0]);
            [-0.5, 0.5].forEach((x, i) => {
                addPart(new THREE.OctahedronGeometry(0.34, 0), material('#a8e6cf', 0.32), [x, 1.2, 0]);
                const frost = addPart(new THREE.TetrahedronGeometry(0.22, 0), material('#f0ffff', 0.4), [x * 1.4, 0.6, 0]);
                frost.rotation.y = i ? 0.8 : -0.8;
            });
            addPart(new THREE.CylinderGeometry(0.18, 0.18, 0.14, 8), material('#8ad0f0'), [0, 1.5, 0]);
        } else if (index === 12) {
            addPart(new THREE.CylinderGeometry(1.1, 1.2, 0.18, 16), material('#9e7e5e'), [0, 0.08, 0]);
            addPart(new THREE.ConeGeometry(0.14, 1.5, 6), material('#c9a680'), [0, 0.95, 0]);
            addPart(new THREE.ConeGeometry(0.12, 1.5, 6), material('#c9a680'), [0, 0.95, 0]);
            addPart(new THREE.ConeGeometry(0.12, 1.5, 6), material('#c9a680'), [0, 0.95, 0]);
            for (let i = 0; i < 12; i += 1) {
                const angle = i * Math.PI / 6;
                addPart(new THREE.BoxGeometry(0.08, 0.42, 0.08), material('#9e7e5e'), [Math.cos(angle) * 0.9, 0.38, Math.sin(angle) * 0.9]);
            }
            addPart(new THREE.SphereGeometry(0.14, 8, 6), material('#ffd76e'), [0, 1.4, 0]);
        } else if (index === 13) {
            addPart(new THREE.CylinderGeometry(0.18, 0.24, 0.28, 10), material('#7d6b8a'), [0, 0.12, 0]);
            addPart(new THREE.CylinderGeometry(0.12, 0.12, 1.8, 8), material('#b39ddb'), [0, 1.05, 0]);
            addPart(new THREE.SphereGeometry(0.24, 10, 8), material('#ce93d8', 0.18), [0, 2.05, 0]);
            [-0.42, 0.42].forEach((x) => {
                addPart(new THREE.PlaneGeometry(0.7, 0.5), material('#e1bee7', 0.12), [x, 1.8, 0], [0, x > 0 ? -0.18 : 0.18, 0]);
            });
            const flameMat = new THREE.MeshStandardMaterial({ color: '#f4b142', emissive: '#f4a442', emissiveIntensity: 0.8, roughness: 0.35 });
            addPart(new THREE.ConeGeometry(0.16, 0.48, 6), flameMat, [0, 2.3, 0]);
        } else if (index === 14) {
            const mirrorMat = new THREE.MeshStandardMaterial({ color: '#d0e6f0', roughness: 0.12, metalness: 0.7, transparent: true, opacity: 0.58, depthWrite: false, envMapIntensity: 0.8 });
            addPart(new THREE.CylinderGeometry(1, 1.1, 0.16, 16), material('#81c784'), [0, 0.08, 0]);
            addPart(new THREE.PlaneGeometry(1.6, 1.6), mirrorMat, [0, 0.6, 0.16]);
            addPart(new THREE.PlaneGeometry(1.6, 1.6), mirrorMat, [0, 0.6, 0.16]);
            addPart(new THREE.PlaneGeometry(1.6, 1.6), mirrorMat, [0, 0.6, 0.16]);
            addPart(new THREE.TorusGeometry(0.85, 0.06, 6, 18), accent, [0, 1.18, 0], [Math.PI / 2, 0, 0]);
            addPart(new THREE.OctahedronGeometry(0.38, 0), material('#fff0b6'), [0, 1.15, 0]);
        } else if (index === 15) {
            const heartShape = new THREE.Shape();
            const cx = 0, cy = 1.1;
            heartShape.absellipse(cx - 0.48, cy, 0.48, 0.6, 0, Math.PI, 0, false);
            heartShape.absellipse(cx + 0.48, cy, 0.48, 0.6, Math.PI, 0, 0, false);
            heartShape.moveTo(-0.54, cy);
            heartShape.bezierCurveTo(-0.8, 0.3, -0.3, -0.4, cx, -0.3);
            heartShape.bezierCurveTo(0.3, -0.4, 0.8, 0.3, 0.54, cy);
            const heartGeometry = new THREE.ExtrudeGeometry(heartShape, { depth: 0.18, bevelEnabled: true });
            addPart(heartGeometry, material('#e0a69e'), [0, 1.2, -0.09], [-Math.PI / 2, 0, 0]);
            addPart(new THREE.CylinderGeometry(0.14, 0.18, 2.4, 8), material('#7d5a9e'), [0, 0.6, 0]);
            addPart(new THREE.SphereGeometry(0.26, 12, 10), material('#f9e5d8'), [0, 2.6, 0]);
            for (let i = 0; i < 6; i += 1) {
                const angle = (i * Math.PI * 2) / 6;
                addPart(new THREE.ConeGeometry(0.08, 0.52, 5), accent, [Math.cos(angle) * 1.3, 2.4, Math.sin(angle) * 1.3], [0, angle, 0]);
            }
        } else {
            [-0.9, 0.9].forEach((x) => addPart(new THREE.CylinderGeometry(0.15, 0.24, 2.2, 8), accent, [x, 1.2, 0]));
            addPart(new THREE.TorusGeometry(0.9, 0.13, 8, 24, Math.PI), accent, [0, 2.25, 0], [0, 0, Math.PI]);
            addPart(new THREE.OctahedronGeometry(0.34, 0), material('#fff0b6'), [0, 1.1, 0]);
        }
        const glow = new THREE.PointLight(config.color, 0, 9);
        glow.position.y = 2.4;
        landmark.add(glow);
        landmark.visible = false;
        secondArea.add(landmark);
        return landmark;
    });
    const flameObject = new THREE.Group();
    flameObject.position.set(0, 0, 0);
    const flameCore = new THREE.Mesh(
        new THREE.SphereGeometry(0.3, 10, 8),
        new THREE.MeshStandardMaterial({ color: '#f4a442', emissive: '#f4a442', emissiveIntensity: 0.9, roughness: 0.25 }),
    );
    flameCore.castShadow = true;
    flameObject.add(flameCore);
    const flameParticle = new THREE.Mesh(
        new THREE.SphereGeometry(0.55, 8, 6),
        new THREE.MeshStandardMaterial({ color: '#f0c878', emissive: '#f0c878', emissiveIntensity: 0.5, transparent: true, opacity: 0.6, roughness: 0.2 }),
    );
    flameParticle.castShadow = true;
    flameObject.add(flameParticle);
    const flameLight = new THREE.PointLight('#f4a442', 1.2, 6);
    flameObject.add(flameLight);
    flameObject.visible = false;
    secondArea.add(flameObject);
    const fogPlaneGeometry = new THREE.PlaneGeometry(40, 40);
    const fogMaterial = new THREE.MeshStandardMaterial({
        color: '#a8a4d6',
        transparent: true,
        opacity: 0,
        roughness: 1,
        metalness: 0,
        side: THREE.DoubleSide,
        depthWrite: false,
    });
    const fogPlane = new THREE.Mesh(fogPlaneGeometry, fogMaterial);
    fogPlane.rotation.x = -Math.PI / 2;
    fogPlane.position.set(30, 0.2, 18);;
    fogPlane.visible = false;
    secondArea.add(fogPlane);
    const mirrorObjects = Array.from({ length: 8 }, (_, index) => {
        const mirror = new THREE.Group();
        const mirrorMat = new THREE.MeshStandardMaterial({
            color: '#d0e6f0',
            roughness: 0.08,
            metalness: 0.85,
            transparent: true,
            opacity: 0,
            depthWrite: false,
            envMapIntensity: 1,
        });
        const frame = new THREE.Mesh(new THREE.BoxGeometry(1.4, 1.8, 0.12), material('#81c784'));
        frame.castShadow = true;
        mirror.add(frame);
        const surface = new THREE.Mesh(new THREE.PlaneGeometry(1.1, 1.5), mirrorMat);
        surface.position.z = 0.065;
        mirror.add(surface);
        mirror.userData.surface = surface;
        mirror.visible = false;
        secondArea.add(mirror);
        return mirror;
    });
    const forestTrees = Array.from({ length: 24 }, (_, index) => {
        const tree = new THREE.Group();
        const trunk = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.12, 1.2, 6), material('#654329'));
        trunk.castShadow = true;
        trunk.receiveShadow = true;
        tree.add(trunk);
        const foliageMat = material(biomeData[0].colors?.decoration ?? '#2d5a27');
        for (let layer = 0; layer < 3; layer += 1) {
            const foliage = new THREE.Mesh(new THREE.SphereGeometry(0.45 - layer * 0.08, 8, 6), foliageMat);
            foliage.position.y = 1.0 + layer * 0.6;
            foliage.castShadow = true;
            tree.add(foliage);
        }
        tree.position.set(0, 0, 0);
        tree.visible = false;
        secondArea.add(tree);
        tree.userData.foliageMat = foliageMat;
        tree.userData.baseY = 0;
        return tree;
    });
    const rockFormations = Array.from({ length: 12 }, (_, index) => {
        const rock = new THREE.Group();
        const rockMat = material('#7a6a5a', 0.7);
        const parts = 3 + (index % 4);
        for (let part = 0; part < parts; part += 1) {
            const size = 0.6 + Math.random() * 0.8;
            const geo = new THREE.BoxGeometry(size, size * 0.7, size * 0.8);
            geo.translate(Math.random() * 0.4 - 0.2, size * 0.35, Math.random() * 0.4 - 0.2);
            const mesh = new THREE.Mesh(geo, rockMat);
            mesh.position.set((Math.random() - 0.5) * 1.5, 0, (Math.random() - 0.5) * 1.5);
            mesh.rotation.set(Math.random() * 0.4, Math.random() * Math.PI, Math.random() * 0.4);
            mesh.castShadow = true;
            mesh.receiveShadow = true;
            rock.add(mesh);
        }
        rock.position.set(0, 0, 0);
        rock.visible = false;
        secondArea.add(rock);
        return rock;
    });
    const waterfallFeatures = Array.from({ length: 6 }, (_, index) => {
        const cascade = new THREE.Group();
        const waterMat = new THREE.MeshStandardMaterial({ color: '#a8e6cf', emissive: '#a8e6cf', emissiveIntensity: 0.4, transparent: true, opacity: 0.7, roughness: 0.1, metalness: 0.6 });
        const stream = new THREE.Mesh(new THREE.PlaneGeometry(1.8, 2.4), waterMat);
        stream.rotation.x = -0.3;
        stream.position.set(0, 1.2, 0);
        cascade.add(stream);
        const mistGeo = new THREE.PlaneGeometry(2.2, 2.8);
        const mistMat = new THREE.MeshStandardMaterial({ color: '#ffffff', transparent: true, opacity: 0.18, depthWrite: false, side: THREE.DoubleSide });
        const mist = new THREE.Mesh(mistGeo, mistMat);
        mist.position.set(0, 0.3, 0.12);
        mist.rotation.x = -0.3;
        cascade.add(mist);
        const splashGeo = new THREE.TorusGeometry(0.4 + index * 0.08, 0.06, 6, 12);
        const splash = new THREE.Mesh(splashGeo, waterMat);
        splash.position.set(0, 0.08, 0);
        splash.rotation.x = Math.PI / 2;
        cascade.add(splash);
        const sprayLight = new THREE.PointLight('#a8e6cf', 0.6, 4);
        sprayLight.position.set(0, 0.5, 0);
        cascade.add(sprayLight);
        cascade.position.set(0, 0, 0);
        cascade.visible = false;
        secondArea.add(cascade);
        cascade.userData.sprayLight = sprayLight;
        return cascade;
    });
    const crystalFormations = Array.from({ length: 16 }, (_, index) => {
        const cluster = new THREE.Group();
        const crystalMat = material(['#bcdfff', '#d4afcd', '#f0e68c', '#e6e6fa'][index % 4]);
        const count = 3 + (index % 5);
        for (let i = 0; i < count; i += 1) {
            const crystal = new THREE.Mesh(new THREE.OctahedronGeometry(0.18 + Math.random() * 0.2, 0), crystalMat);
            crystal.position.set((Math.random() - 0.5) * 1.2, Math.random() * 0.8 + 0.2, (Math.random() - 0.5) * 1.2);
            crystal.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, Math.random() * Math.PI);
            crystal.castShadow = true;
            crystal.receiveShadow = true;
            cluster.add(crystal);
        }
        const glow = new THREE.Mesh(new THREE.OctahedronGeometry(0.35, 0), new THREE.MeshStandardMaterial({ color: '#ffffff', emissive: '#ffffff', emissiveIntensity: 0.3, transparent: true, opacity: 0.5, roughness: 0.2, depthWrite: false }));
        cluster.add(glow);
        cluster.position.set(0, 0, 0);
        cluster.visible = false;
        secondArea.add(cluster);
        cluster.userData.glow = glow;
        return cluster;
    });
    const biomeFeatures = { forest: forestTrees, rocks: rockFormations, waterfall: waterfallFeatures, crystals: crystalFormations };
    const biomeFeaturePositions = {
        forest: [[8, -3], [14, 3], [18, -6], [22, 6], [24, -4], [12, 8], [18, -5], [22, 4], [24, -9], [10, 6], [16, -3], [20, 9], [24, -5], [13, -9], [18, 7], [22, -2], [26, 9], [12, 4], [18, 10], [22, -7], [26, 6], [14, -6], [20, 9], [24, 2]],
        rocks: [[42, 2], [47, -7], [51, 8], [55, -2], [43, 8], [49, -6], [54, 4], [57, -4], [40, -3], [46, 9], [51, -4], [56, 6]],
        waterfall: [[44, 14], [50, 19], [55, 11], [59, 15], [46, 6], [52, 3]],
        crystals: [[9, 16], [14, 21], [18, 14], [22, 23], [25, 11], [27, 17], [11, 18], [16, 23], [20, 16], [24, 24], [26, 12], [13, 16], [18, 17], [22, 11], [25, 19], [27, 17]],
    };
    const biomeNames = ['Silvano del Bosque', 'Braulio de las Rocas', 'Aura de las Cascadas', 'Caelum de los Cristales'];
    const biomeNPCs = Array.from({ length: 4 }, (_, index) => {
        const npc = createCharacter({ x: 0, z: 0, name: biomeNames[index] || getRandomCharacterName() });
        npc.root.visible = false;
        npc.root.scale.setScalar(0.85);
        npc.root.userData.biomeIndex = index;
        npc.root.userData.dialogue = biomeData[index].dialogue;
        npc.root.userData.hasSpoken = false;
        const biomeColor = biomeData[index].colors?.decoration ?? '#888888';
        const accentMat = material(biomeColor);
        [-1, 1].forEach((side) => {
            const horn = new THREE.Mesh(new THREE.ConeGeometry(0.15, 0.5, 7), accentMat);
            horn.position.set(side * 0.22, 2.3, -0.02);
            horn.rotation.z = side * -0.38;
            npc.root.add(horn);
        });
        if (index === 0) {
            const hat = new THREE.Mesh(new THREE.ConeGeometry(0.32, 0.48, 7), material('#8fbc8f'));
            hat.position.y = 2.35;
            npc.root.add(hat);
        } else if (index === 1) {
            const stoneMat = new THREE.MeshStandardMaterial({ color: '#6a5a4a', roughness: 0.8 });
            const stonePlate = new THREE.Mesh(new THREE.BoxGeometry(1.2, 0.1, 0.8), stoneMat);
            stonePlate.position.y = -0.05;
            npc.root.add(stonePlate);
            const crystal = new THREE.Mesh(new THREE.OctahedronGeometry(0.28, 0), material('#a8e6cf', 0.3));
            crystal.position.set(0, 2.5, 0);
            npc.root.add(crystal);
        } else if (index === 2) {
            const wingMat = new THREE.MeshStandardMaterial({ color: '#8b4513', transparent: true, opacity: 0.7 });
            [-1, 1].forEach((side) => {
                const wing = new THREE.Mesh(new THREE.BoxGeometry(1.4, 0.04, 0.5), wingMat);
                wing.position.set(side * 0.8, 1.8, side * 0.2);
                wing.rotation.y = side * 0.35;
                npc.root.add(wing);
            });
            const eyeGlow = new THREE.Mesh(new THREE.SphereGeometry(0.05, 6, 5), new THREE.MeshStandardMaterial({ color: '#ff6b35', emissive: '#ff6b35', emissiveIntensity: 0.7, roughness: 0.3 }));
            eyeGlow.position.set(0, 1.92, -0.28);
            npc.root.add(eyeGlow);
            npc.root.userData.eyeGlow = eyeGlow;
        } else if (index === 3) {
            const leafMat = material('#228b22');
            for (let i = 0; i < 6; i += 1) {
                const leaf = new THREE.Mesh(new THREE.SphereGeometry(0.25, 6, 5), leafMat);
                const angle = i * Math.PI / 3;
                leaf.position.set(Math.cos(angle) * 1.5, 1.2 + Math.sin(angle) * 0.3, Math.sin(angle) * 1.5);
                npc.root.add(leaf);
            }
        }
        secondArea.add(npc.root);
        return npc;
    });
    const bridgeObjects = Array.from({ length: 3 }, (_, index) => {
        const bridge = new THREE.Group();
        const bridgeMat = material('#8b7355', 0.8);
        const plankMat = material('#654329', 0.8);
        if (index === 0) {
            for (let i = 0; i < 6; i += 1) {
                const plank = new THREE.Mesh(new THREE.BoxGeometry(2.2, 0.18, 0.8), plankMat);
                plank.position.x = i * 1.1;
                plank.castShadow = true;
                plank.receiveShadow = true;
                bridge.add(plank);
            }
            const railMat = material('#5d4a3a', 0.9);
            [-0.35, 0.35].forEach((side) => {
                const rail = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.06, 6.6, 6), railMat);
                rail.rotation.z = Math.PI / 2;
                rail.position.set(3.3, 0.6, side);
                rail.castShadow = true;
                bridge.add(rail);
            });
            bridge.position.set(40, 0.1, 0);
        } else if (index === 1) {
            const angle = Math.atan2(18 - 16, 46 - 58);
            const length = Math.hypot(46 - 58, 18 - 16);
            for (let i = 0; i < Math.ceil(length / 1.1); i += 1) {
                const plank = new THREE.Mesh(new THREE.BoxGeometry(1.0, 0.18, 0.7), plankMat);
                plank.position.x = i * 1.1;
                plank.castShadow = true;
                plank.receiveShadow = true;
                bridge.add(plank);
            }
            const railMat = material('#5d4a3a', 0.9);
            [-0.3, 0.3].forEach((side) => {
                const rail = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.05, length + 0.4, 6), railMat);
                rail.rotation.z = angle;
                rail.position.set(length / 2, 0.55, side);
                rail.castShadow = true;
                bridge.add(rail);
            });
            bridge.rotation.y = angle;
            bridge.position.set(58, 0.15, 16);
        } else if (index === 2) {
            for (let i = 0; i < 5; i += 1) {
                const plank = new THREE.Mesh(new THREE.BoxGeometry(2.2, 0.18, 0.8), plankMat);
                plank.position.x = i * 1.1;
                plank.castShadow = true;
                plank.receiveShadow = true;
                bridge.add(plank);
            }
            const railMat = material('#5d4a3a', 0.9);
            [-0.35, 0.35].forEach((side) => {
                const rail = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.06, 5.5, 6), railMat);
                rail.rotation.z = Math.PI / 2;
                rail.position.set(2.75, 0.6, side);
                rail.castShadow = true;
                bridge.add(rail);
            });
            bridge.position.set(35, 0.15, 30);
        }
        bridge.visible = false;
        secondArea.add(bridge);
        bridge.userData.requiredStage = (index + 1) * 4 + 3;
        return bridge;
    });
    let allyHelped = savedProgress?.version >= 2 && savedProgress.allyHelped;
    let landmarkActivated = savedProgress?.version === 3 && savedProgress.landmarkActivated;
    let challengeDamageCooldown = 0;
    let sequenceProgress = savedProgress?.sequenceProgress ?? 0;
    let flameCarried = savedProgress?.flameCarried ?? false;
    let carrierProgress = savedProgress?.carrierProgress ?? 0;
    let reflectionRevealed = savedProgress?.reflectionRevealed ?? (landmarkActivated && campaignStage > 2);
    const stageConfig = () => adventureStages[campaignStage - 3];
    const configureChallengeStage = () => {
        const config = stageConfig();
        const layout = campaignStage > 2 ? challengeLayouts[campaignStage - 3] : null;
        challengeItems.forEach((item, index) => {
            const position = layout?.items[index] ?? [0, 0];
            item.position.set(position[0], 0, position[1]);
            item.visible = Boolean(config && index < config.items && !challengeItemsCollected.has(index));
            if (item.children[0]) item.children[0].material.color.set(config?.color ?? '#f1d68a');
        });
        challengeAlly.root.visible = Boolean(config && !allyHelped);
        const allyPosition = layout?.ally ?? [37, 9];
        challengeAlly.root.position.set(allyPosition[0], 0, allyPosition[1]);
        if (config && challengeAlly.root.userData.setName) {
            const allyNames = [
                'Ariadna la Guía', 'Silvia la Sabia', 'Darío el Sabio', 'Valeria del Alba',
                'Lucas el Botánico', 'Caelum el Místico', 'Bastián de las Rosas', 'Clara de los Vientos',
                'Gabriel el Guardián', 'Aura de la Fuente', 'Faelar el Explorador', 'Isolda del Bosque',
                'Renato el Custodio', 'Elena de las Estrellas', 'Lucía de la Arboleda', 'Marcos el Viajero'
            ];
            const allyName = allyNames[(campaignStage - 3) % allyNames.length] || getRandomCharacterName();
            challengeAlly.root.userData.setName(allyName);
        }
        challengeAlly.root.userData.waypoints = [
            [allyPosition[0], allyPosition[1]],
            [allyPosition[0] - 2.6, allyPosition[1] + 2.0],
            [allyPosition[0] + 2.4, allyPosition[1] - 1.8],
        ];
        challengeAlly.root.userData.wpIdx = 0;
        challengeAlly.root.userData.patrolSpeed = 1.35;
        challengeAlly.root.userData.seed = 1.8;
        exitGate.visible = Boolean(config);
        const exitPosition = layout?.exit ?? [36, -9];
        exitGate.position.set(exitPosition[0], 0, exitPosition[1]);
        exitGate.children.forEach((part) => part.material.color.set(config?.color ?? '#d6b767'));
        trapObjects.forEach((trap, index) => {
            const position = layout?.traps[index] ?? [0, 0];
            trap.position.set(position[0], 0, position[1]);
            trap.visible = Boolean(config && index < config.traps);
        });
        stageLandmarks.forEach((landmark, index) => {
            const active = Boolean(config && index === campaignStage - 3);
            landmark.visible = active;
            if (active && layout) {
                const itemAvgX = layout.items.reduce((s, p) => s + p[0], 0) / layout.items.length;
                const itemAvgZ = layout.items.reduce((s, p) => s + p[1], 0) / layout.items.length;
                landmark.position.set(itemAvgX, 0, itemAvgZ);
            }
            landmark.scale.setScalar(active && landmarkActivated ? 1.08 : 1);
            if (active) landmark.children[landmark.children.length - 1].intensity = landmarkActivated ? 3 : 0.2;
        });
        const skyColor = config?.sky ?? '#dce8d8';
        scene.background.set(skyColor);
        scene.fog.color.set(skyColor);
        grassMaterial.color.set(config?.ground ?? '#91a878');
        enemyCharacters.forEach((enemy, index) => {
            enemy.root.visible = Boolean(config && index < config.enemies);
            const position = layout?.enemies[index] ?? [21 + index * 3, index % 2 ? 6 : -6];
            enemy.root.position.set(position[0], 0, position[1]);
            enemy.root.userData.patrolX = position[0];
            enemy.root.userData.patrolZ = position[1];
            const enemyType = enemy.root.userData.type;
            if (enemyType === 'flying') {
                enemy.root.position.y = enemy.root.userData.flyHeight;
            } else {
                enemy.root.position.y = 0;
            }
            if (enemy.root.userData.eyeGlow) enemy.root.userData.eyeGlow.material.emissiveIntensity = enemyType === 'phase' ? 0.05 : 0;
            if (enemy.root.userData.warningRing) enemy.root.userData.warningRing.material.emissiveIntensity = 0.45;
        });
        const mechanic = config?.mechanic ?? 'standard';
        reflectionRevealed = landmarkActivated;
        flameObject.visible = false;
        flameLight.intensity = 0;
        fogPlane.visible = false;
        fogMaterial.opacity = 0;
        mirrorObjects.forEach((mirror) => {
            mirror.visible = false;
            mirror.userData.surface.material.opacity = 0;
        });
        challengeItems.forEach((item) => {
            item.userData.revealed = true;
        });
        if (mechanic === 'carrier') {
            const carrierPoint = layout?.carrierPoint ?? [22, 0];
            flameObject.position.set(carrierPoint[0], 0.4, carrierPoint[1]);
            flameObject.visible = challengeItemsCollected.size < config.items && !flameCarried;
            if (flameCarried) flameLight.intensity = 1.5;
        }
        if (mechanic === 'memory') {
            fogPlane.visible = true;
            fogMaterial.opacity = config?.fogLevel ?? 0.75;
        }
        if (mechanic === 'shadow' || mechanic === 'memory') {
            challengeItems.forEach((item, index) => {
                if (index < config.items) {
                    item.userData.ambientIntensity = 0.5;
                }
            });
        }
        if (mechanic === 'reflection') {
            challengeItems.forEach((item, index) => {
                if (index < config.items) {
                    item.userData.revealed = reflectionRevealed;
                    item.visible = reflectionRevealed && !challengeItemsCollected.has(index);
                }
            });
            const mirrorCount = Math.min(config.items, 8);
            for (let index = 0; index < mirrorCount; index += 1) {
                const pos = layout.items[index];
                mirrorObjects[index].position.set(pos[0], 0.5, pos[1]);
                mirrorObjects[index].visible = !reflectionRevealed;
            }
        }
        updateBiomeDisplay();
        updateStageSign();
    };
    const updateBiomeDisplay = () => {
        const stageIndex = campaignStage - 3;
        const currentBiome = stageIndex >= 0 && stageIndex < 16 ? biomeAssignments[stageIndex] : -1;
        const biomeKey = biomeData[currentBiome]?.features;
        Object.keys(biomeFeatures).forEach((key) => {
            const positions = biomeFeaturePositions[key];
            biomeFeatures[key].forEach((obj, index) => {
                obj.visible = key === biomeKey;
                if (obj.visible && positions?.[index]) {
                    obj.position.set(positions[index][0], 0, positions[index][1]);
                }
            });
        });
         if (currentBiome >= 0 && stageIndex >= 0) {
            const biomeInfo = biomeData[currentBiome];
            const stageWithinBiome = stageIndex % 4;
            biomeNPCs.forEach((npc, index) => {
                const shouldShow = index === currentBiome && campaignStage >= biomeData[index].npcIndex;
                npc.root.visible = shouldShow;
                if (shouldShow) {
                    const positions = biomeNPCPositions[biomeData[index].features + 'NPC'] || [[25, 0]];
                    const pos = positions[stageWithinBiome] || positions[0];
                    npc.root.position.set(pos[0], 0, pos[1]);
                    npc.root.userData.waypoints = [
                        [pos[0], pos[1]],
                        [pos[0] + 2.5, pos[1] + 1.8],
                        [pos[0] - 2.2, pos[1] - 1.8],
                    ];
                    npc.root.userData.wpIdx = 0;
                    npc.root.userData.patrolSpeed = 1.3;
                    npc.root.userData.seed = 2.4 + index;
                    if (npc.root.userData.hasSpoken) {
                        if (npc.root.userData.eyeGlow) npc.root.userData.eyeGlow.material.emissiveIntensity = 0.3;
                    }
                }
            });
            bridgeObjects.forEach((bridge) => {
                bridge.visible = campaignStage >= bridge.userData.requiredStage;
            });
            if (stageWithinBiome === 0 && campaignStage > 3) {
                setStatus(`Has entrado en ${biomeInfo.name}. ${biomeInfo.storyFragment}`);
            }
        }
    };
    const biomeNPCPositions = {
        forestNPC: [[16, 5], [26, 5], [16, 10], [26, 10]],
        rocksNPC: [[46, 5], [56, 5], [46, 10], [56, 10]],
        waterfallNPC: [[46, 18], [56, 18], [46, 26], [56, 26]],
        crystalsNPC: [[16, 18], [26, 18], [16, 28], [26, 28]],
    };
    const playerPosition = player.root.position;
    let lastSavedPosition = { x: playerPosition.x, z: playerPosition.z };
    let nearbyTarget = null;
    savedProgress?.flowers.forEach((index) => collected.add(index));
    savedProgress?.seeds.forEach((index) => collectedSeeds.add(index));
    let collectedCount = collected.size;
    let lastObjectiveLabel = '';
    let lastObjectiveBearing = null;
    if (savedProgress) {
        const maxX = restored ? 72 : 14;
        const savedX = THREE.MathUtils.clamp(savedProgress.player.x, -14, maxX);
        const savedZ = THREE.MathUtils.clamp(savedProgress.player.z, -14, 42);
        const collides = (x, z) => treeBlockers.some((tree) => Math.hypot(x - tree.x, z - tree.z) < tree.radius + 0.42);
        if (!collides(savedX, savedZ)) playerPosition.set(savedX, 0, savedZ);
        lastSavedPosition = { x: playerPosition.x, z: playerPosition.z };
        flowerObjects.forEach((flower, index) => { flower.visible = !collected.has(index); });
        seedObjects.forEach((seed, index) => { seed.visible = !collectedSeeds.has(index); });
        secondArea.visible = restored;
        water.visible = restored;
        waterJet.visible = restored;
        heartHalo.visible = treeAwakened;
        heartSpark.intensity = treeAwakened ? 2.1 : 0;
        configureChallengeStage();
    }
    configureChallengeStage();
    if (savedProgress?.version >= 4) {
        biomeNPCs.forEach((npc, i) => { npc.root.userData.hasSpoken = savedProgress.biomeNPCsSpoken[i] === true; });
    }

    const saveProgress = () => {
        if (!storageAvailable) return;
        try {
            window.localStorage.setItem(progressStorageKey, JSON.stringify({
                version: 4,
                flowers: [...collected],
                fountain: restored,
                seeds: [...collectedSeeds],
                tree: treeAwakened,
                campaignStage,
                challengeItems: [...challengeItemsCollected],
                allyHelped,
                landmarkActivated,
                sequenceProgress,
                flameCarried,
                carrierProgress,
                reflectionRevealed,
                health,
                biomeNPCsSpoken: biomeNPCs.map((npc) => npc.root.userData.hasSpoken),
                biomeStories: biomeData.map((b) => b.storyFragment),
                player: { x: playerPosition.x, z: playerPosition.z },
            }));
            lastSavedPosition = { x: playerPosition.x, z: playerPosition.z };
        } catch {
            storageAvailable = false;
            setStatus('El avance cambió, pero el navegador no pudo guardarlo. Comprueba el espacio disponible o la configuración de privacidad.');
        }
    };

    const savePositionIfChanged = () => {
        if (Math.hypot(playerPosition.x - lastSavedPosition.x, playerPosition.z - lastSavedPosition.z) > 0.1) {
            saveProgress();
        }
    };

    const clearSavedProgress = () => {
        if (!storageAvailable) {
            setStatus('El paseo se reinició, pero el navegador no permite borrar o guardar el avance local.');
            return;
        }
        try {
            window.localStorage.removeItem(progressStorageKey);
        } catch {
            storageAvailable = false;
            setStatus('El paseo se reinició en pantalla, pero el navegador no pudo borrar el avance guardado.');
        }
    };

    const takeChallengeHit = () => {
        if (campaignStage < 3 || campaignStage > 18 || challengeDamageCooldown > 0) return;
        challengeDamageCooldown = 1.5;
        health -= 1;
        const startLayout = challengeLayouts[campaignStage - 3];
        const startPos = startLayout?.start ?? [18, 0];
        playerPosition.set(startPos[0], 0, startPos[1]);
        if (health <= 0) {
            challengeItemsCollected.clear();
            allyHelped = false;
            landmarkActivated = false;
            sequenceProgress = 0;
            flameCarried = false;
            carrierProgress = 0;
            reflectionRevealed = false;
            health = 3;
            configureChallengeStage();
            setStatus(`Se agotaron tus vidas. ${stageConfig().name} vuelve a empezar desde el inicio.`);
        } else {
            setStatus(`¡Cuidado! Perdiste un corazón (${health} de 3). El escenario conserva los objetos reunidos.`);
        }
        collectionCount.textContent = `Recuerdos: ${challengeItemsCollected.size} de ${stageConfig().items} · Vidas: ${health}`;
            if (challengeItemsCollected.size === 1 || challengeItemsCollected.size === stageConfig().items) showLoveBanner();
        saveProgress();
        updateQuestLog();
        updateActionPrompt();
        lastObjectiveLabel = '';
        updateObjectiveGuide();
    };

    const updateActionPrompt = () => {
        if (campaignStage > 2 && campaignStage <= 18) {
            const config = stageConfig();
            const mechanic = config?.mechanic ?? 'standard';
            const layout = challengeLayouts[campaignStage - 3];
            let targetItem = null;
            if (mechanic === 'sequence') {
                const nextOrder = layout.sequenceOrder[sequenceProgress];
                if (nextOrder !== undefined && !challengeItemsCollected.has(nextOrder)
                    && playerPosition.distanceTo(challengeItems[nextOrder].position) < 1.8) {
                    targetItem = { item: challengeItems[nextOrder], index: nextOrder };
                }
            } else {
                targetItem = challengeItems.find((item, index) => index < config.items
                    && !challengeItemsCollected.has(index) && item.visible
                    && playerPosition.distanceTo(item.position) < 1.8);
                if (targetItem) {
                    targetItem = { item: targetItem, index: challengeItems.indexOf(targetItem) };
                }
            }
            if (mechanic !== 'carrier' || flameCarried) {
                if (mechanic === 'carrier' && flameCarried) {
                    const layout = challengeLayouts[campaignStage - 3];
                    const targetIdx = carrierProgress;
                    if (targetIdx * 2 < layout.carrierTargets.length) {
                        const targetX = layout.carrierTargets[targetIdx * 2];
                        const targetZ = layout.carrierTargets[targetIdx * 2 + 1];
                        if (Math.hypot(playerPosition.x - targetX, playerPosition.z - targetZ) < 2.2) {
                            nearbyTarget = { type: 'carrier-target' };
                            lastAction = 'Depositar llama';
                            actionButton.textContent = lastAction;
                            actionButton.disabled = false;
                            return;
                        }
                    }
                }
                if (targetItem) {
                    nearbyTarget = { type: 'challenge-item', object: targetItem.item, itemIndex: targetItem.index };
                    lastAction = 'Recoger objeto';
                } else if (challengeItemsCollected.size === config.items && allyHelped && !landmarkActivated
                    && playerPosition.distanceTo(stageLandmarks[campaignStage - 3].position) < 3) {
                    nearbyTarget = { type: 'challenge-landmark' };
                    lastAction = config.action;
                } else if (challengeItemsCollected.size === config.items && allyHelped && landmarkActivated
                    && playerPosition.distanceTo(exitGate.position) < 2.8) {
                    nearbyTarget = { type: 'challenge-gate' };
                    lastAction = campaignStage === 18 ? 'Completar aventura' : 'Abrir siguiente sendero';
                } else if (!allyHelped && playerPosition.distanceTo(challengeAlly.root.position) < 2.5) {
                    nearbyTarget = { type: 'challenge-ally' };
                    lastAction = 'Escuchar pista';
                } else {
                    const biomeNPC = biomeNPCs.find((npc) => npc.root.visible && playerPosition.distanceTo(npc.root.position) < 2.5);
                    if (biomeNPC && !biomeNPC.root.userData.hasSpoken) {
                        nearbyTarget = { type: 'biome-npc', index: biomeNPC.root.userData.biomeIndex };
                        lastAction = 'Escuchar historia';
                    } else if (biomeNPC) {
                        nearbyTarget = { type: 'biome-npc', index: biomeNPC.root.userData.biomeIndex };
                        lastAction = 'Volver a escuchar';
                    } else {
                        nearbyTarget = null;
                        lastAction = 'Interactuar';
                    }
                }
            } else if (mechanic === 'carrier' && !flameCarried
                && challengeItemsCollected.size < config.items
                && playerPosition.distanceTo(flameObject.position) < 2) {
                nearbyTarget = { type: 'carrier-flame' };
                lastAction = 'Recoger llama';
            } else {
                nearbyTarget = null;
                lastAction = 'Interactuar';
            }
        } else if (level === 1) {
            const targetFlower = flowerObjects.find((flower) => {
                if (collected.has(flower.userData.index)) return false;
                return playerPosition.distanceTo(flower.position) < 1.7;
            });
            if (targetFlower) {
                nearbyTarget = { type: 'flower', object: targetFlower };
                lastAction = 'Recoger flor';
            } else if (playerPosition.distanceTo(gardener.root.position) < 2.5) {
                nearbyTarget = { type: 'gardener' };
                lastAction = 'Hablar';
            } else if (playerPosition.distanceTo(fountain.position) < 2.8) {
                nearbyTarget = { type: 'fountain' };
                lastAction = 'Activar fuente';
            } else {
                nearbyTarget = null;
                lastAction = 'Interactuar';
            }
        } else {
            const targetSeed = seedObjects.find((seed, index) => !collectedSeeds.has(index)
                && playerPosition.distanceTo(seed.position) < 1.8);
            if (targetSeed) {
                nearbyTarget = { type: 'seed', object: targetSeed };
                lastAction = 'Recoger semilla';
            } else if (playerPosition.distanceTo(heartTree.position) < 2.5) {
                nearbyTarget = { type: 'heart-tree' };
                lastAction = treeAwakened ? 'Árbol despierto' : 'Despertar árbol';
            } else {
                nearbyTarget = null;
                lastAction = 'Interactuar';
            }
        }

        actionButton.textContent = lastAction;
        actionButton.disabled = !nearbyTarget || (nearbyTarget.type === 'heart-tree' && treeAwakened) || (nearbyTarget.type === 'challenge-item' && !nearbyTarget.object.visible);
    };

    const questList = screen.querySelector('.garden3d-quest-list');
    const campaignTitles = ['La fuente silenciosa', 'El invernadero secreto', ...adventureStages.map(({ name }) => name)];
    const renderCampaignList = () => {
        questList.replaceChildren(...campaignTitles.map((title, index) => {
            const item = document.createElement('li');
            item.dataset.garden3dCampaignStage = String(index + 1);
            item.innerHTML = `<span>${String(index + 1).padStart(2, '0')}</span><span></span><strong></strong>`;
            item.children[1].textContent = title;
            return item;
        }));
    };
    renderCampaignList();

    const updateQuestLog = () => {
        const currentTitle = campaignTitles[campaignStage - 1];
        const completed = campaignStage > 18;
        const totalStages = 18;
        questTitle.textContent = completed ? 'Liria está a salvo' : currentTitle;
        questStep.textContent = completed ? 'COMPLETADO' : `${String(campaignStage).padStart(2, '0')} / ${totalStages}`;
        const progress = completed ? 18 : campaignStage - 1;
        questProgress.style.width = `${progress / totalStages * 100}%`;
        questTrack.setAttribute('aria-valuenow', String(progress));
        const stages = [...questList.querySelectorAll('[data-garden3d-campaign-stage]')];
        stages.forEach((item, index) => {
            const stageNumber = index + 1;
            const completedStage = stageNumber < campaignStage || completed;
            const current = stageNumber === campaignStage && !completed;
            const value = stageNumber === 1
                ? collectedCount === flowers.length ? 'Completado' : `${collectedCount} / ${flowers.length} flores`
                : stageNumber === 2
                    ? treeAwakened ? 'Completado' : restored ? `${collectedSeeds.size} / ${lightSeeds.length} semillas` : 'Pendiente'
                    : completedStage ? 'Completado' : current
                                ? (() => {
                                    const config = adventureStages[stageNumber - 3];
                                    if (!config) return 'Por desbloquear';
                                    const mechanic = config.mechanic;
                                    const baseInfo = `${challengeItemsCollected.size} / ${config.items} · ${health} ♥`;
                                    if (mechanic === 'sequence') {
                                        return `${baseInfo} · Secuencia: ${sequenceProgress}`;
                                    } else if (mechanic === 'carrier') {
                                        const layout = challengeLayouts[stageNumber - 3];
                                        const carrierMax = layout.carrierTargets ? Math.ceil(layout.carrierTargets.length / 2) : 0;
                                        return `${baseInfo} · Llama: ${carrierProgress}/${carrierMax}`;
                                    } else if (mechanic === 'reflection') {
                                        return `${baseInfo} · ${reflectionRevealed ? 'Esquinas: activado' : 'Esquinas: pendiente'} · Hito: ${landmarkActivated ? 'listo' : 'pendiente'}`;
                                    } else if (mechanic === 'memory') {
                                        return `${baseInfo} · Niebla: activa · Hito: ${landmarkActivated ? 'listo' : 'pendiente'}`;
                                    } else if (mechanic === 'shadow') {
                                        return `${baseInfo} · Luz: pendiente · Hito: ${landmarkActivated ? 'listo' : 'pendiente'}`;
                                    }
                                    return `${baseInfo} · ${landmarkActivated ? 'Hito: listo' : allyHelped ? 'Pista: escuchada' : 'Aliada: pendiente'}`;
                                })()
                        : 'Por desbloquear';
            item.children[2].textContent = value;
            item.classList.toggle('is-complete', completedStage);
            if (current) item.setAttribute('aria-current', 'step');
            else item.removeAttribute('aria-current');
        });
        const storiesKnown = biomeNPCs.filter((npc) => npc.root.userData.hasSpoken).length;
        if (campaignStage > 2) {
            collectionCount.textContent = `Recuerdos: ${challengeItemsCollected.size} de ${stageConfig().items} · Historias: ${storiesKnown} de 4 · Vidas: ${health}`;
        }
        finale.hidden = !completed;
        if (completed) {
            questTitle.textContent = 'Liria está a salvo';
        }
    };

    const updateObjectiveGuide = () => {
        if (campaignStage > 18) {
            objectiveText.textContent = 'Aventura completada';
            objectiveArrow.hidden = true;
            return;
        }

        const config = campaignStage > 2 && campaignStage <= 18 ? stageConfig() : null;
        const mechanic = config?.mechanic ?? 'standard';
        const layout = campaignStage > 2 ? challengeLayouts[campaignStage - 3] : null;
        const targets = campaignStage > 2
            ? config
                ? (() => {
                    const baseTargets = [];
                    if (mechanic === 'sequence') {
                        const nextOrder = layout.sequenceOrder[sequenceProgress];
                        if (nextOrder !== undefined && !challengeItemsCollected.has(nextOrder)) {
                            baseTargets.push({ label: 'Cristal de resonancia', position: challengeItems[nextOrder].position });
                        }
                    } else if (mechanic === 'carrier') {
                        const carrierMax = layout.carrierTargets ? Math.ceil(layout.carrierTargets.length / 2) : 0;
                        if (!flameCarried && carrierProgress <= carrierMax && challengeItemsCollected.size < config.items) {
                            baseTargets.push({ label: 'Recoge la llama viva', position: flameObject.position });
                        } else if (flameCarried) {
                            const targetIdx = carrierProgress;
                            if (targetIdx * 2 < layout.carrierTargets.length) {
                                baseTargets.push({ label: 'Lleva la llama al punto marcado', position: new THREE.Vector3(layout.carrierTargets[targetIdx * 2], 0, layout.carrierTargets[targetIdx * 2 + 1]) });
                            }
                        }
                        if (carrierProgress > carrierMax || reflectionRevealed) {
                            challengeItems
                                .filter((item, index) => index < config.items && !challengeItemsCollected.has(index) && item.visible)
                                .forEach((item) => {
                                    baseTargets.push({ label: 'Objeto brillante', position: item.position });
                                });
                        }
                    } else if (mechanic === 'reflection' && !reflectionRevealed) {
                        baseTargets.push({ label: config.action, position: stageLandmarks[campaignStage - 3].position });
                    } else {
                        challengeItems
                            .filter((item, index) => index < config.items && !challengeItemsCollected.has(index) && item.visible)
                            .forEach((item) => {
                                const itemLabel = mechanic === 'memory' ? 'Lámpara de memoria'
                                    : mechanic === 'shadow' ? 'Fragmento celestial'
                                    : mechanic === 'reflection' ? 'Fragmento reflejado'
                                    : 'Objeto brillante';
                                baseTargets.push({ label: itemLabel, position: item.position });
                            });
                    }
                    if (challengeItemsCollected.size === config.items && (!allyHelped || (mechanic === 'carrier' && !reflectionRevealed))) {
                        if (!allyHelped) baseTargets.push({ label: 'Busca a tu aliada y escucha su pista', position: challengeAlly.root.position });
                    }
                    if (challengeItemsCollected.size === config.items && allyHelped && !landmarkActivated) {
                        baseTargets.push({ label: config.action, position: stageLandmarks[campaignStage - 3].position });
                    }
                    if (challengeItemsCollected.size === config.items && allyHelped && landmarkActivated && (mechanic !== 'reflection' || reflectionRevealed)) {
                        if (mechanic === 'carrier' && !reflectionRevealed) {
                            baseTargets.push({ label: 'Coloca la llama en el punto central', position: new THREE.Vector3(config.sky, 0, config.ground) });
                        } else {
                            baseTargets.push({ label: 'Alcanza el arco de salida', position: exitGate.position });
                        }
                    }
                    return baseTargets;
                })()
                : []
            : level === 1
            ? collectedCount < flowers.length
                ? flowerObjects
                    .filter((flower) => !collected.has(flower.userData.index))
                    .map((flower) => ({ label: 'Busca la flor iluminada más cercana', position: flower.position }))
                : [{ label: 'Despierta la fuente', position: fountain.position }]
            : collectedSeeds.size < seedObjects.length
                ? seedObjects
                    .filter((seed, index) => !collectedSeeds.has(index))
                    .map((seed) => ({ label: 'Busca la semilla de luz más cercana', position: seed.position }))
                : [{ label: 'Despierta el árbol del corazón', position: heartTree.position }];
        const target = targets.reduce((closest, candidate) => {
            const distance = Math.hypot(
                candidate.position.x - playerPosition.x,
                candidate.position.z - playerPosition.z,
            );
            return !closest || distance < closest.distance ? { ...candidate, distance } : closest;
        }, null);

        if (!target) return;
        const distance = Math.round(target.distance);
        const label = `${target.label} · ${distance} m`;
        if (label !== lastObjectiveLabel) {
            objectiveText.textContent = label;
            lastObjectiveLabel = label;
        }
        objectiveArrow.hidden = false;
        const dx = target.position.x - playerPosition.x;
        const dz = target.position.z - playerPosition.z;
        const bearing = Math.round((Math.atan2(dx, -dz) + cameraYaw) * 180 / Math.PI);
        if (bearing !== lastObjectiveBearing) {
            objectiveArrow.style.transform = `rotate(${bearing}deg)`;
            lastObjectiveBearing = bearing;
        }
    };

    const interact = () => {
        if (!nearbyTarget) {
            if (campaignStage > 2 && campaignStage <= 18) {
                const config = stageConfig();
                const mechanic = config?.mechanic ?? 'standard';
                const layout = challengeLayouts[campaignStage - 3];
                if (mechanic === 'carrier' && !flameCarried && challengeItemsCollected.size < config.items) {
                    setStatus('Acércate a la llama viva para recogerla y derretir los cristales.');
                } else if (mechanic === 'carrier' && flameCarried && carrierProgress < (layout.carrierTargets ? Math.ceil(layout.carrierTargets.length / 2) : 0)) {
                    setStatus('Lleva la llama a los puntos marcados en el suelo para derretir los cristales.');
                } else if (mechanic === 'reflection' && !reflectionRevealed) {
                    setStatus('Activa el espejo del hito para revelar los fragmentos ocultos.');
                } else {
                    setStatus(challengeItemsCollected.size < config.items
                        ? `Acércate a uno de los recuerdos iluminados. Reúne ${config.items} para continuar.`
                        : !allyHelped
                            ? `Acércate a ${config.friend} para escuchar su pista.`
                            : !landmarkActivated
                                ? `Acércate al hito del escenario para ${config.action.toLowerCase()}.`
                                : 'Acércate al arco de salida para abrir el siguiente escenario.');
                }
            } else if (level === 1) {
                setStatus(collectedCount < flowers.length
                    ? `Acércate a una flor iluminada para recogerla. Necesitas reunir ${flowers.length}.`
                    : 'Acércate a la fuente hasta que aparezca «Activar fuente» y pulsa E.');
            } else {
                setStatus(collectedSeeds.size < seedObjects.length
                    ? 'Acércate a una semilla de luz para recogerla.'
                    : 'Acércate al árbol del corazón para completar la zona.');
            }
            return;
        }
        if (nearbyTarget.type === 'flower') {
            const index = nearbyTarget.object.userData.index;
            if (collected.has(index)) return;
            collected.add(index);
            collectedCount += 1;
            collectionCount.textContent = `Flores: ${collectedCount} de ${flowers.length}`;
            nearbyTarget.object.visible = false;
            setStatus(`Flor recogida · ${collectedCount} de ${flowers.length}. ${collectedCount === flowers.length ? 'La fuente te espera al final del sendero.' : 'Busca las flores que aún brillan.'}`);
            saveProgress();
            updateQuestLog();
        } else if (nearbyTarget.type === 'gardener') {
            setStatus(collectedCount === flowers.length
                ? 'Jardinera: ¡Has reunido las tres flores! Llevémoslas a la fuente.'
                : 'Jardinera: las flores antiguas guardan la energía que necesita la fuente.');
            gardener.root.rotation.y = Math.atan2(playerPosition.x - gardener.root.position.x, playerPosition.z - gardener.root.position.z);
            gardener.arms[0].rotation.z = -0.9;
            showLoveBanner('«Carla Lorena, tu ternura hace florecer hasta la flor más tímida de este reino.»');
        } else if (nearbyTarget.type === 'fountain') {
            if (collectedCount < flowers.length) {
                setStatus(`La fuente sigue dormida. Primero reúne las tres flores (${collectedCount} de ${flowers.length}).`);
                return;
            }
            restored = true;
            water.visible = true;
            waterJet.visible = true;
            level = 2;
            secondArea.visible = true;
            levelIndicator.textContent = 'Zona 2 de 18 · El invernadero secreto';
            collectionCount.textContent = `Semillas: 0 de ${seedObjects.length}`;
            setStatus('¡La fuente ha despertado y la puerta se abrió! Cruza el sendero hacia el invernadero y reúne tres semillas de luz.');
            showLoveBanner(loveMessagesForCarla[1]);
            saveProgress();
            updateQuestLog();
        } else if (nearbyTarget.type === 'seed') {
            const index = seedObjects.indexOf(nearbyTarget.object);
            if (collectedSeeds.has(index)) return;
            collectedSeeds.add(index);
            nearbyTarget.object.visible = false;
            collectionCount.textContent = `Semillas: ${collectedSeeds.size} de ${seedObjects.length}`;
            setStatus(`Semilla de luz recogida · ${collectedSeeds.size} de ${seedObjects.length}. ${collectedSeeds.size === seedObjects.length ? 'El árbol del corazón te espera en el claro.' : 'Busca las semillas que aún brillan.'}`);
            saveProgress();
            updateQuestLog();
        } else if (nearbyTarget.type === 'heart-tree') {
            if (collectedSeeds.size < seedObjects.length) {
                setStatus(`El árbol aún necesita las tres semillas de luz (${collectedSeeds.size} de ${seedObjects.length}).`);
                return;
            }
            treeAwakened = true;
            heartHalo.visible = true;
            heartSpark.intensity = 2.1;
            campaignStage = 3;
            challengeItemsCollected.clear();
            allyHelped = false;
            landmarkActivated = false;
            health = 3;
            realmBridge.visible = false;
            const startLayout = challengeLayouts[campaignStage - 3];
            const startPos = startLayout?.start ?? [18, 0];
            playerPosition.set(startPos[0], 0, startPos[1]);
            configureChallengeStage();
            levelIndicator.textContent = `Escenario 3 de 18 · ${stageConfig().name}`;
            collectionCount.textContent = `Recuerdos: 0 de ${stageConfig().items} · Vidas: ${health}`;
            setStatus(`¡El árbol del corazón ha florecido! ${stageConfig().name} comienza ahora. Habla con tu aliada para recibir una pista.`);
            showLoveBanner(loveMessagesForCarla[2]);
            saveProgress();
            updateQuestLog();
            updateActionPrompt();
            lastObjectiveLabel = '';
            updateObjectiveGuide();
        } else if (nearbyTarget.type === 'challenge-item') {
            const index = nearbyTarget.itemIndex;
            const config = stageConfig();
            const layout = challengeLayouts[campaignStage - 3];
            if (config?.mechanic === 'sequence') {
                const nextInOrder = layout.sequenceOrder[sequenceProgress];
                if (index !== nextInOrder) {
                    setStatus(`Debes activar los cristales en el orden correcto. El siguiente es el índice ${nextInOrder + 1}.`);
                    return;
                }
                sequenceProgress += 1;
            }
            if (challengeItemsCollected.has(index)) return;
            challengeItemsCollected.add(index);
            nearbyTarget.object.visible = false;
            collectionCount.textContent = `Recuerdos: ${challengeItemsCollected.size} de ${stageConfig().items} · Vidas: ${health}`;
            setStatus(challengeItemsCollected.size === stageConfig().items
                ? `${stageConfig().items} objetos reunidos. ${allyHelped ? 'Busca el arco de salida.' : 'Ahora encuentra a tu aliada y escucha su pista.'}`
                : `${stageConfig().task} · ${challengeItemsCollected.size} de ${stageConfig().items}.`);
            saveProgress();
            updateQuestLog();
            updateActionPrompt();
            lastObjectiveLabel = '';
            updateObjectiveGuide();
        } else if (nearbyTarget.type === 'challenge-ally') {
            allyHelped = true;
            challengeAlly.root.rotation.y = Math.atan2(playerPosition.x - challengeAlly.root.position.x, playerPosition.z - challengeAlly.root.position.z);
            challengeAlly.arms[0].rotation.z = -0.9;
            showLoveBanner(`«${stageConfig().friend}: Carla, el amor de Adrián ilumina tus pasos en este sendero.»`);
            setStatus(`${stageConfig().friend} comparte una pista: ${stageConfig().clue}`);
            saveProgress();
            updateQuestLog();
            updateActionPrompt();
            lastObjectiveLabel = '';
            updateObjectiveGuide();
        } else if (nearbyTarget.type === 'challenge-landmark') {
            landmarkActivated = true;
            const landmark = stageLandmarks[campaignStage - 3];
            landmark.children[landmark.children.length - 1].intensity = 3;
            landmark.scale.setScalar(1.08);
            const config = stageConfig();
            if (config?.mechanic === 'reflection') {
                reflectionRevealed = true;
                challengeItems.forEach((item, index) => {
                    if (index < config.items && !challengeItemsCollected.has(index)) {
                        item.userData.revealed = true;
                        item.visible = true;
                    }
                });
                mirrorObjects.forEach((mirror) => { mirror.visible = false; });
                setStatus(`${config.action}: los espejos revelan los fragmentos ocultos. El arco de salida ya está abierto.`);
            } else {
                setStatus(`${config.action}: el hito floreció. ¡Un puente une este mundo con el siguiente! Cruza por él hacia el nuevo sendero.`);
            }
            if (campaignStage >= 3 && campaignStage < 18) {
                const nextLayout = challengeLayouts[campaignStage - 2];
                if (nextLayout) {
                    buildBridgeBetweenRealms([exitGate.position.x, exitGate.position.z], nextLayout.start);
                    showLoveBanner(`«Carla: ¡Un puente floreciente une los mundos para ti! Sigue el sendero.»`);
                }
            }
            saveProgress();
            updateQuestLog();
            updateActionPrompt();
            lastObjectiveLabel = '';
            updateObjectiveGuide();
        } else if (nearbyTarget.type === 'challenge-gate') {
            campaignStage += 1;
            challengeItemsCollected.clear();
            allyHelped = false;
            landmarkActivated = false;
            sequenceProgress = 0;
            flameCarried = false;
            carrierProgress = 0;
            reflectionRevealed = false;
            health = 3;
            challengeDamageCooldown = 0;
            const startLayout = challengeLayouts[campaignStage - 3];
            const startPos = startLayout?.start ?? [18, 0];
            playerPosition.set(startPos[0], 0, startPos[1]);
            configureChallengeStage();
            if (campaignStage > 18) {
                exitGate.visible = false;
                levelIndicator.textContent = 'Aventura completada · Liria';
                collectionCount.textContent = '18 escenarios superados';
                setStatus('¡Has superado los dieciocho escenarios! La historia final de Liria ya está aquí.');
            } else {
                const newBiome = biomeData[biomeAssignments[campaignStage - 3]];
                levelIndicator.textContent = `Escenario ${campaignStage} de 18 · ${newBiome.name} · ${stageConfig().name}`;
                collectionCount.textContent = `Recuerdos: 0 de ${stageConfig().items} · Vidas: ${health}`;
                setStatus(`Sendero abierto. Comienza ${stageConfig().name}: ${stageConfig().task.toLowerCase()}.`);
                showLoveBanner(loveMessagesForCarla[campaignStage - 1]);
                const stageIndex = campaignStage - 3;
                const stageWithinBiome = stageIndex % 4;
                if (stageWithinBiome === 0 && campaignStage > 3) {
                    setStatus(`Has entrado en ${newBiome.name}. ${newBiome.storyFragment}`);
                }
            }
            saveProgress();
            updateQuestLog();
            updateActionPrompt();
            lastObjectiveLabel = '';
            updateObjectiveGuide();
        } else if (nearbyTarget.type === 'carrier-flame') {
            const layout = challengeLayouts[campaignStage - 3];
            const config = stageConfig();
            if (flameCarried) return;
            flameCarried = true;
            carrierProgress = 1;
            setStatus('¡Has tomado la llama viva! Lleva la llama a los puntos marcados para derretir los cristales.');
            challengeItems.forEach((item, index) => {
                if (index < config.items && index < layout.carrierTargets.length / 2) {
                    item.userData.revealed = true;
                    item.visible = !challengeItemsCollected.has(index);
                }
            });
            collectionCount.textContent = `Objetos: ${challengeItemsCollected.size} de ${config.items} · Llama: activa`;
            saveProgress();
            updateQuestLog();
            updateActionPrompt();
            lastObjectiveLabel = '';
            updateObjectiveGuide();
        } else if (nearbyTarget.type === 'carrier-target') {
            const layout = challengeLayouts[campaignStage - 3];
            const config = stageConfig();
            const targetIndex = carrierProgress;
            if (targetIndex * 2 >= layout.carrierTargets.length) {
                setStatus('¡Todos los puntos de calor han sido activados! El arco de salida está abierto.');
                flameCarried = false;
                carrierProgress += 1;
                reflectionRevealed = true;
                challengeItems.forEach((item, index) => {
                    if (index < config.items) {
                        item.userData.revealed = true;
                        item.visible = !challengeItemsCollected.has(index);
                    }
                });
            } else {
                const tx = layout.carrierTargets[targetIndex * 2];
                const tz = layout.carrierTargets[targetIndex * 2 + 1];
                playerPosition.set(tx, 0, tz);
                carrierProgress += 1;
                setStatus(`La llama derritió los cristales del punto ${carrierProgress}. ¡Continúa con el siguiente!`);
                challengeItems.forEach((item, index) => {
                    if (index < config.items && index < carrierProgress * 2) {
                        item.userData.revealed = true;
                        item.visible = !challengeItemsCollected.has(index);
                    }
                });
            }
            saveProgress();
            collectionCount.textContent = `Objetos: ${challengeItemsCollected.size} de ${config.items} · Llama: ${carrierProgress}`;
            updateQuestLog();
            updateActionPrompt();
            lastObjectiveLabel = '';
            updateObjectiveGuide();
        } else if (nearbyTarget.type === 'biome-npc') {
            const biomeIndex = nearbyTarget.index;
            const npc = biomeNPCs[biomeIndex];
            if (!npc.root.userData.hasSpoken) {
                npc.root.userData.hasSpoken = true;
                biomeStoriesKnown.add(biomeIndex);
                if (npc.root.userData.eyeGlow) npc.root.userData.eyeGlow.material.emissiveIntensity = 0.9;
                const biomeInfo = biomeData[biomeIndex];
                const dialogue = biomeInfo.dialogue;
                setStatus(`${biomeInfo.dialogue[0]}\n${biomeInfo.dialogue[1]}`);
            } else {
                const biomeInfo = biomeData[biomeIndex];
                setStatus(`${biomeInfo.npcName}: ${biomeInfo.dialogue[1]}`);
            }
            saveProgress();
            updateQuestLog();
        }
    };

    const reset = () => {
        releaseControls();
        collected.clear();
        collectedSeeds.clear();
        collectedCount = 0;
        collectionCount.textContent = `Flores: 0 de ${flowers.length}`;
        restored = false;
        level = 1;
        treeAwakened = false;
        campaignStage = 1;
        challengeItemsCollected.clear();
        allyHelped = false;
        landmarkActivated = false;
        health = 3;
        challengeDamageCooldown = 0;
        sequenceProgress = 0;
        flameCarried = false;
        carrierProgress = 0;
        reflectionRevealed = false;
        flameObject.visible = false;
        flameLight.intensity = 0;
        fogPlane.visible = false;
        fogMaterial.opacity = 0;
        mirrorObjects.forEach((mirror) => { mirror.visible = false; });
        secondArea.visible = false;
        biomeNPCs.forEach((npc) => { npc.root.visible = false; npc.root.userData.hasSpoken = false; });
        biomeStoriesKnown.clear();
        levelIndicator.textContent = 'Zona 1 de 18 · La fuente silenciosa';
        flowerObjects.forEach((flower) => { flower.visible = true; });
        seedObjects.forEach((seed) => { seed.visible = true; });
        player.root.position.set(0, 0, 10);
        player.root.rotation.y = 0;
        cameraYaw = 0;
        cameraHeight = 5.5;
        lastObjectiveLabel = '';
        lastObjectiveBearing = null;
        lastSavedPosition = { x: playerPosition.x, z: playerPosition.z };
        gardener.arms.forEach((arm) => { arm.rotation.z = 0; });
        water.visible = false;
        waterJet.visible = false;
        heartHalo.visible = false;
        heartSpark.intensity = 0;
        configureChallengeStage();
        paused = false;
        pauseButton.textContent = 'Pausar';
        pauseButton.setAttribute('aria-pressed', 'false');
        pauseOverlay.hidden = true;
        finale.hidden = true;
        objectiveArrow.hidden = false;
        setStatus('Jardín reiniciado. Busca tres flores para despertar la fuente y abrir los dieciséis nuevos escenarios.');
        clearSavedProgress();
        updateQuestLog();
        updateActionPrompt();
    };

    const normalizeKey = (key) => key.toLowerCase();
    const isScreenActive = () => !screen.hidden;
    const releaseControls = () => {
        heldKeys.clear();
        touchDirections.clear();
        screen.querySelectorAll('[data-garden3d-direction]').forEach((button) => button.setAttribute('aria-pressed', 'false'));
        sprinting = false;
        sprintButton.setAttribute('aria-pressed', 'false');
    };
    const setPaused = (value) => {
        paused = value;
        if (paused) releaseControls();
        pauseButton.textContent = paused ? 'Continuar' : 'Pausar';
        pauseButton.setAttribute('aria-pressed', String(paused));
        pauseOverlay.hidden = !paused;
        if (paused) {
            setStatus('Paseo en pausa. Tu avance está guardado en este navegador.');
            savePositionIfChanged();
        } else {
            setStatus('Paseo reanudado. Continúa cuando quieras.');
        }
    };

    window.addEventListener('keydown', (event) => {
        if (!isScreenActive() || event.target instanceof HTMLElement
            && event.target.matches('input, textarea, select, [contenteditable="true"]')) return;
        const key = normalizeKey(event.key);
        if (key === 'p' && !event.repeat) {
            event.preventDefault();
            setPaused(!paused);
            return;
        }
        if (paused) return;
        if (['w', 'a', 's', 'd', 'arrowup', 'arrowdown', 'arrowleft', 'arrowright', 'shift', ' '].includes(key)) {
            event.preventDefault();
            heldKeys.add(key);
        }
        if ((key === 'e' || key === ' ') && !event.repeat) interact();
    });
    window.addEventListener('keyup', (event) => heldKeys.delete(normalizeKey(event.key)));
    window.addEventListener('blur', releaseControls);

    screen.querySelectorAll('[data-garden3d-direction]').forEach((button) => {
        const direction = button.dataset.garden3dDirection;
        button.addEventListener('pointerdown', (event) => {
            event.preventDefault();
            touchDirections.add(direction);
            button.setAttribute('aria-pressed', 'true');
            button.setPointerCapture(event.pointerId);
        });
        const release = () => {
            touchDirections.delete(direction);
            button.setAttribute('aria-pressed', 'false');
        };
        button.addEventListener('pointerup', release);
        button.addEventListener('pointercancel', release);
        button.addEventListener('lostpointercapture', release);
    });

    const sprintButton = screen.querySelector('[data-garden3d-sprint]');
    sprintButton.addEventListener('pointerdown', (event) => {
        event.preventDefault();
        sprinting = true;
        sprintButton.setAttribute('aria-pressed', 'true');
    });
    const stopSprint = () => {
        sprinting = false;
        sprintButton.setAttribute('aria-pressed', 'false');
    };
    sprintButton.addEventListener('pointerup', stopSprint);
    sprintButton.addEventListener('pointercancel', stopSprint);
    sprintButton.addEventListener('lostpointercapture', stopSprint);
    actionButton.addEventListener('click', interact);
    pauseButton.addEventListener('click', () => setPaused(!paused));
    screen.querySelector('[data-garden3d-resume]').addEventListener('click', () => setPaused(false));

    // ── Diálogo de confirmación de reinicio ──────────────────────────────────────
    const confirmOverlay = screen.querySelector('[data-garden3d-confirm-overlay]');
    const confirmOkBtn   = screen.querySelector('[data-garden3d-confirm-ok]');
    const confirmCancel  = screen.querySelector('[data-garden3d-confirm-cancel]');

    const showResetConfirm = (onConfirm) => {
        confirmOverlay.hidden = false;
        confirmOkBtn.focus();
        const handleOk = () => {
            confirmOverlay.hidden = true;
            cleanup();
            onConfirm();
        };
        const handleCancel = () => {
            confirmOverlay.hidden = true;
            cleanup();
        };
        const handleKey = (e) => {
            if (e.key === 'Escape') handleCancel();
        };
        const cleanup = () => {
            confirmOkBtn.removeEventListener('click', handleOk);
            confirmCancel.removeEventListener('click', handleCancel);
            confirmOverlay.removeEventListener('keydown', handleKey);
        };
        confirmOkBtn.addEventListener('click', handleOk);
        confirmCancel.addEventListener('click', handleCancel);
        confirmOverlay.addEventListener('keydown', handleKey);
    };

    screen.querySelector('[data-garden3d-reset]').addEventListener('click', () => {
        showResetConfirm(reset);
    });
    screen.querySelector('[data-garden3d-replay]').addEventListener('click', () => {
        showResetConfirm(reset);
    });


    const resize = () => {
        const width = stage.clientWidth;
        const height = stage.clientHeight;
        if (!width || !height) return;
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height, false);
    };
    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(stage);
    resize();
    loading.remove();
    levelIndicator.textContent = campaignStage > 18
        ? 'Aventura completada · Liria'
        : campaignStage > 2
            ? `Escenario ${campaignStage} de 18 · ${stageConfig().name}`
            : restored ? 'Zona 2 de 18 · El invernadero secreto' : 'Zona 1 de 18 · La fuente silenciosa';
    collectionCount.textContent = campaignStage > 2
        ? `Recuerdos: ${challengeItemsCollected.size} de ${stageConfig()?.items ?? 0} · Vidas: ${health}`
        : restored
            ? `Semillas: ${collectedSeeds.size} de ${seedObjects.length}`
            : `Flores: ${collectedCount} de ${flowers.length}`;
    updateQuestLog();
    showLoveBanner();
    setStatus(invalidSavedProgress
        ? 'El avance guardado no es válido; esta partida comienza desde el inicio.'
        : !storageAvailable
            ? 'No se pudo acceder al almacenamiento local; el avance de esta sesión no se guardará.'
            : campaignStage > 18
                ? 'Avance recuperado. Has completado los dieciocho escenarios y la historia final de Liria.'
                : campaignStage > 2
                    ? `Avance recuperado. ${stageConfig().name}: ${challengeItemsCollected.size} de ${stageConfig().items} objetos; tienes ${health} vidas.`
                    : treeAwakened
                ? 'Avance recuperado. El árbol del corazón ya ha florecido; continúa con los escenarios secretos.'
                : restored
                    ? 'Avance recuperado. La fuente está despierta; reúne las semillas de luz del invernadero.'
                    : collectedCount > 0
                        ? `Avance recuperado. Ya reuniste ${collectedCount} de ${flowers.length} flores.`
                        : 'Jardín listo. Reúne tres flores y devuelve el agua a la fuente.');

    let lastFrameTime = 0;
    let elapsedTime = 0;
    let lastPositionSaveCheck = 0;

    const updateNPCPatrol = (npc, delta, elapsed) => {
        if (!npc || !npc.root || !npc.root.visible) return;
        const wps = npc.root.userData.waypoints;
        if (!wps || wps.length === 0) return;

        const distToPlayer = playerPosition.distanceTo(npc.root.position);
        // Si el jugador está cerca (diálogo / interacción), pausar patrulla y mirar a Carla Lorena
        if (distToPlayer < 4.8) {
            const targetAngle = Math.atan2(playerPosition.x - npc.root.position.x, playerPosition.z - npc.root.position.z);
            npc.root.rotation.y = THREE.MathUtils.lerp(npc.root.rotation.y, targetAngle, delta * 3.5);
            npc.legs.forEach((leg) => { leg.rotation.x *= 0.85; });
            npc.arms.forEach((arm) => { arm.rotation.x *= 0.85; });
            npc.torso.position.y = THREE.MathUtils.lerp(npc.torso.position.y, 1.12, 0.1);
            return;
        }

        const currentWp = wps[npc.root.userData.wpIdx % wps.length];
        const dx = currentWp[0] - npc.root.position.x;
        const dz = currentWp[1] - npc.root.position.z;
        const dist = Math.hypot(dx, dz);

        if (dist < 0.35) {
            npc.root.userData.wpIdx = (npc.root.userData.wpIdx + 1) % wps.length;
        } else {
            const speed = npc.root.userData.patrolSpeed || 1.35;
            const moveStep = Math.min(dist, speed * delta);
            npc.root.position.x += (dx / dist) * moveStep;
            npc.root.position.z += (dz / dist) * moveStep;

            const targetAngle = Math.atan2(dx, dz);
            npc.root.rotation.y = THREE.MathUtils.lerp(npc.root.rotation.y, targetAngle, delta * 4.5);

            const seed = npc.root.userData.seed || 0;
            const stride = Math.sin(elapsed * 6.5 + seed);
            npc.legs[0].rotation.x = stride * 0.52;
            npc.legs[1].rotation.x = -stride * 0.52;
            npc.arms[0].rotation.x = -stride * 0.38;
            npc.arms[1].rotation.x = stride * 0.38;
            npc.torso.position.y = 1.12 + Math.abs(stride) * 0.025;
        }
    };
    const update = () => {
        if (screen.hidden) {
            lastFrameTime = 0;
            return;
        }
        const now = performance.now() / 1000;
        const delta = lastFrameTime ? Math.min(now - lastFrameTime, 0.05) : 1 / 60;
        lastFrameTime = now;
        if (paused) {
            renderer.render(scene, camera);
            return;
        }
        elapsedTime += delta;
        challengeDamageCooldown = Math.max(0, challengeDamageCooldown - delta);
        const elapsed = elapsedTime;
        const forward = heldKeys.has('w') || heldKeys.has('arrowup') || touchDirections.has('forward');
        const backward = heldKeys.has('s') || heldKeys.has('arrowdown') || touchDirections.has('back');
        const left = heldKeys.has('a') || heldKeys.has('arrowleft') || touchDirections.has('left');
        const right = heldKeys.has('d') || heldKeys.has('arrowright') || touchDirections.has('right');
        const inputX = Number(right) - Number(left);
        const inputZ = Number(backward) - Number(forward);
        const length = Math.hypot(inputX, inputZ);
        const wantsSprint = sprinting || heldKeys.has('shift');

        if (length > 0) {
            const dx = inputX * Math.cos(cameraYaw) + inputZ * Math.sin(cameraYaw);
            const dz = -inputX * Math.sin(cameraYaw) + inputZ * Math.cos(cameraYaw);
            const speed = wantsSprint ? 8 : 4.2;
            const stepX = dx / length * speed * delta;
            const stepZ = dz / length * speed * delta;
            const collides = (x, z) => treeBlockers.some((tree) => Math.hypot(x - tree.x, z - tree.z) < tree.radius + 0.42);
            const nextX = THREE.MathUtils.clamp(playerPosition.x + stepX, -14, level === 2 ? 80 : 14);
            const nextZ = THREE.MathUtils.clamp(playerPosition.z + stepZ, -14, level === 2 ? 45 : 14);
            if (!collides(nextX, nextZ)) {
                playerPosition.x = nextX;
                playerPosition.z = nextZ;
            } else if (!collides(nextX, playerPosition.z)) {
                playerPosition.x = nextX;
            } else if (!collides(playerPosition.x, nextZ)) {
                playerPosition.z = nextZ;
            }
            player.root.rotation.y = Math.atan2(dx, dz);
            const stride = Math.sin(elapsed * (wantsSprint ? 15 : 9));
            player.legs[0].rotation.x = stride * 0.62;
            player.legs[1].rotation.x = -stride * 0.62;
            player.arms[0].rotation.x = -stride * 0.45;
            player.arms[1].rotation.x = stride * 0.45;
            player.torso.position.y = 1.12 + Math.abs(stride) * 0.035;
            if (now - lastPositionSaveCheck >= 1) {
                lastPositionSaveCheck = now;
                if (Math.hypot(playerPosition.x - lastSavedPosition.x, playerPosition.z - lastSavedPosition.z) > 0.5) {
                    saveProgress();
                }
            }
        } else {
            player.legs.forEach((leg) => { leg.rotation.x *= 0.82; });
            player.arms.forEach((arm) => { arm.rotation.x *= 0.82; });
            player.torso.position.y = THREE.MathUtils.lerp(player.torso.position.y, 1.12 + Math.sin(elapsed * 2) * 0.025, 0.12);
        }

        // Ondulación dinámica y física del cabello largo de la Princesa Carla Lorena
        if (player.root.userData.hairStrands) {
            const isMoving = length > 0;
            const hairSpeed = isMoving ? (wantsSprint ? 15 : 9) : 1.8;
            const swayZ = isMoving ? (wantsSprint ? 0.28 : 0.16) : 0.05;
            const liftX = isMoving ? (wantsSprint ? -0.36 : -0.20) : -0.04;
            player.root.userData.hairStrands.forEach((strand, i) => {
                const phase = elapsed * hairSpeed + i * 0.45;
                strand.rotation.z = Math.sin(phase) * (swayZ * 0.5);
                strand.rotation.x = liftX + Math.sin(phase * 1.2) * (swayZ * 0.7);
                if (strand.userData.lowerJoint) {
                    strand.userData.lowerJoint.rotation.x = liftX * 0.7 + Math.sin(phase * 1.2 - 0.4) * (swayZ * 0.9);
                    strand.userData.lowerJoint.rotation.z = Math.sin(phase - 0.35) * (swayZ * 0.5);
                }
            });
        }
        if (player.root.userData.frontHairStrands) {
            const isMoving = length > 0;
            const frontSpeed = isMoving ? (wantsSprint ? 14 : 8) : 2.0;
            const swayAmount = isMoving ? 0.14 : 0.04;
            player.root.userData.frontHairStrands.forEach((strand, i) => {
                const phase = elapsed * frontSpeed + i * 0.6;
                strand.rotation.x = Math.sin(phase) * swayAmount;
                strand.rotation.z = (i === 0 ? -1 : 1) * 0.08 + Math.cos(phase) * 0.05;
            });
        }

        flowerObjects.forEach((flower, index) => {
            if (!collected.has(index)) {
                flower.userData.bloom.position.y = flower.userData.baseY + Math.sin(elapsed * 2 + index) * 0.08;
                flower.userData.bloom.rotation.y += delta * 0.4;
            }
        });
        seedObjects.forEach((seed, index) => {
            if (!collectedSeeds.has(index)) {
                seed.children[0].rotation.y += delta * 0.8;
                seed.children[0].position.y = 0.8 + Math.sin(elapsed * 2.2 + index) * 0.1;
            }
        });
        if (campaignStage >= 3 && campaignStage <= 18) {
            const config = stageConfig();
            enemyCharacters.forEach((enemy, index) => {
                if (!enemy.root.visible) return;
                const enemyType = enemy.root.userData.type;
                const patrolCenter = enemy.root.userData.patrolX;
                const patrolZ = enemy.root.userData.patrolZ;
                if (enemyType === 'flying') {
                    const flyRadius = 2.6 + index * 0.25;
                    const flySpeed = 0.7 + campaignStage * 0.02;
                    enemy.root.position.x = THREE.MathUtils.clamp(
                        patrolCenter + Math.cos(elapsed * flySpeed) * flyRadius,
                        17,
                        38,
                    );
                    enemy.root.position.z = patrolZ + Math.sin(elapsed * flySpeed) * flyRadius;
                    enemy.root.position.y = enemy.root.userData.flyHeight + Math.sin(elapsed * 3.5 + index) * 0.35;
                    enemy.root.rotation.y = Math.atan2(
                        -Math.sin(elapsed * flySpeed),
                        Math.cos(elapsed * flySpeed),
                    );
                    if (playerPosition.distanceTo(enemy.root.position) < 1.3) takeChallengeHit();
                } else if (enemyType === 'sentry') {
                    enemy.root.position.y = 0;
                    enemy.root.rotation.y = Math.sin(elapsed * 1.5 + index) * 0.7;
                    if (playerPosition.distanceTo(enemy.root.position) < 1.3) takeChallengeHit();
                } else if (enemyType === 'phase') {
                    const phaseCycle = Math.sin(elapsed * 2.8 + index * 1.4);
                    const isPhaseVisible = phaseCycle > -0.15;
                    enemy.root.userData.eyeGlow && (enemy.root.userData.eyeGlow.material.emissiveIntensity = isPhaseVisible ? 0.8 : 0.05);
                    if (enemy.root.userData.warningRing) enemy.root.userData.warningRing.material.emissiveIntensity = isPhaseVisible ? 0.5 : 0.1;
                    if (isPhaseVisible) {
                        enemy.root.position.x = THREE.MathUtils.clamp(
                            patrolCenter + Math.sin(elapsed * (0.6 + campaignStage * 0.02) + index) * (1.3 + campaignStage * 0.035),
                            17,
                            38,
                        );
                        enemy.root.rotation.y = Math.sin(elapsed + index) > 0 ? Math.PI / 2 : -Math.PI / 2;
                        if (playerPosition.distanceTo(enemy.root.position) < 1.15) takeChallengeHit();
                    }
                } else {
                    enemy.root.position.x = THREE.MathUtils.clamp(
                        patrolCenter + Math.sin(elapsed * (0.8 + campaignStage * 0.035) + index) * (1.6 + campaignStage * 0.06),
                        17,
                        38,
                    );
                    enemy.root.rotation.y = Math.sin(elapsed + index) > 0 ? Math.PI / 2 : -Math.PI / 2;
                    if (playerPosition.distanceTo(enemy.root.position) < 1.15) takeChallengeHit();
                }
            });
            trapObjects.forEach((trap) => {
                if (!trap.visible) return;
                trap.rotation.y += delta * 0.7;
                trap.scale.setScalar(1 + Math.sin(elapsed * 3 + trap.position.x) * 0.04);
                if (Math.hypot(playerPosition.x - trap.position.x, playerPosition.z - trap.position.z) < 1.05) takeChallengeHit();
            });
            challengeItems.forEach((item, index) => {
                if (index < config.items && item.visible) {
                    item.children[0].rotation.y += delta * 0.8;
                    item.children[0].position.y = 0.82 + Math.sin(elapsed * 2 + index) * 0.09;
                }
            });
            const mechanic = config?.mechanic ?? 'standard';
            if (mechanic === 'carrier') {
                if (flameCarried) {
                    flameObject.position.lerp(playerPosition.clone().add(new THREE.Vector3(0, 1.2, 0)), delta * 5);
                    flameLight.intensity = 1.5 + Math.sin(elapsed * 8) * 0.4;
                } else if (flameObject.visible && challengeItemsCollected.size < config.items) {
                    flameObject.position.y = 0.4 + Math.sin(elapsed * 2.5) * 0.12;
                    flameLight.intensity = 1.2 + Math.sin(elapsed * 4) * 0.3;
                }
            }
            if (mechanic === 'memory' && fogPlane.visible) {
                fogMaterial.opacity = (config?.fogLevel ?? 0.75) + Math.sin(elapsed * 0.8) * 0.05;
            }
            mirrorObjects.forEach((mirror) => {
                if (mirror.visible && mirror.userData.surface.visible !== false) {
                    mirror.userData.surface.material.opacity = reflectionRevealed ? 0.25 : 0;
                    mirror.rotation.y += delta * 0.3;
                }
            });
            if (mechanic === 'memory' || mechanic === 'shadow') {
                challengeItems.forEach((item, index) => {
                    if (index < config.items && item.visible && !challengeItemsCollected.has(index)) {
                        const flicker = 0.6 + Math.sin(elapsed * 3 + index * 0.7) * 0.4;
                        item.children[0].material.emissiveIntensity = flicker * 0.4;
                    }
                });
            }
            if (mechanic === 'shadow') {
                fogMaterial.opacity = 0.15 + Math.sin(elapsed * 0.5 + campaignStage) * 0.05;
                fogPlane.visible = true;
            } else {
                fogPlane.visible = false;
            }
        }
        if (treeAwakened) heartHalo.rotation.y += delta * 0.5;

        // Animate love signs: billboard effect + gentle float
        if (loveSignMesh.visible) {
            loveSignMesh.position.y = loveSignMesh.userData.baseY + Math.sin(elapsed * 0.85) * 0.22;
            loveSignMesh.lookAt(camera.position);
        }
        if (gardenLoveSign.visible) {
            gardenLoveSign.position.y = 7.8 + Math.sin(elapsed * 0.72) * 0.18;
            gardenLoveSign.lookAt(camera.position);
        }

        const desiredCameraPosition = new THREE.Vector3(
            playerPosition.x + Math.sin(cameraYaw) * 8.2,
            cameraHeight,
            playerPosition.z + Math.cos(cameraYaw) * 8.2,
        );
        camera.position.lerp(desiredCameraPosition, 1 - Math.exp(-4 * delta));
        camera.lookAt(playerPosition.x, 1, playerPosition.z - 1.1);

        // Patrulla suave y viva de personajes aliados amigables (jardinero, aliada, habitantes de bioma)
        updateNPCPatrol(gardener, delta, elapsed);
        if (challengeAlly.root.visible && !allyHelped) {
            updateNPCPatrol(challengeAlly, delta, elapsed);
        }
        biomeNPCs.forEach((npc) => {
            if (npc.root.visible) {
                updateNPCPatrol(npc, delta, elapsed);
            }
        });
        waterJet.scale.y = restored ? 0.9 + Math.sin(elapsed * 5) * 0.12 : 1;
        updateActionPrompt();
        updateObjectiveGuide();
        renderer.render(scene, camera);
    };

    const visibilityObserver = new MutationObserver(() => {
        if (!screen.hidden) {
            renderer.setAnimationLoop(update);
            resize();
        } else {
            savePositionIfChanged();
            renderer.setAnimationLoop(null);
            releaseControls();
        }
    });
    visibilityObserver.observe(screen, { attributes: true, attributeFilter: ['hidden'] });
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) savePositionIfChanged();
    });
    window.addEventListener('pagehide', savePositionIfChanged);
    if (isScreenActive()) {
        renderer.setAnimationLoop(update);
    }
}
