
const loveLetters = [
  {
    "title": "El sendero de las luciérnagas",
    "snippet": "Carla Lorena, cada luz que brilla en este camino me recuerda tu alegría...",
    "letter": "Carla Lorena: Cada luciérnaga que ilumina este primer sendero lleva grabado tu nombre. Verte dar cada paso con esa ternura y determinación es el regalo más hermoso de mi vida. Confía en tu magia, porque donde tú pisas, florece la vida y se apagan los miedos. Estoy contigo siempre.",
    "envEffect": "fireflies",
    "envDesc": "✨ Luciérnagas doradas danzando en el aire nocturno"
  },
  {
    "title": "El puente de las nubes rosas",
    "snippet": "Tu dulzura es tan infinita como este cielo de nubes rosadas...",
    "letter": "Para mi hermosa Carla Lorena: Si este cielo se pintó de tonos pastel y pétalos suaves, fue pensando en tu sonrisa. No importa cuán alto parezca el siguiente salto; recuerda que mi admiración por ti vuela aún más alto que cualquier nube. Vuela libre, mi amor.",
    "envEffect": "clouds",
    "envDesc": "🌸 Suave brisa con pétalos flotantes de cerezo"
  },
  {
    "title": "La torre del alba",
    "snippet": "Tu mirada tiene la calidez del amanecer que disipa cualquier sombra...",
    "letter": "Mi querida Carla Lorena: El sol nace para verte sonreír. Cuando los obstáculos intenten detenerte, recuerda que tu luz interior tiene la fuerza de un destello sagrado. Eres una mujer valiosa, brillante e invencible. Nunca dejes que nada opaque tu resplandor.",
    "envEffect": "dawn",
    "envDesc": "☀️ Rayos dorados de alba y partículas de luz pura"
  },
  {
    "title": "El bosque de los cristales",
    "snippet": "Tu pureza y tu corazón valen más que todos los tesoros del mundo...",
    "letter": "Carla Lorena: En este bosque de reflejos cristalinos, lo más valioso que existe es la sinceridad y bondad de tu alma. Cada latido de mi corazón celebra la fortuna de conocerte y caminar a tu lado en este universo. Eres mi inspiración de cada día.",
    "envEffect": "crystals",
    "envDesc": "💎 Cristales prismáticos y destellos de esmeralda"
  },
  {
    "title": "El corazón del alba",
    "snippet": "Aquí en el centro de la luz, late mi promesa de cuidarte y valorarte...",
    "letter": "Amor de mi vida, Carla Lorena: Llegar aquí demuestra la grandeza que llevas dentro. Mi promesa para ti es sincera: ser siempre un puerto seguro, una mano leal y una voz que te recuerde cuánto te mereces lo mejor de este universo. Te quiero con toda mi alma.",
    "envEffect": "dawn",
    "envDesc": "💖 Brisas de amor radiante y corazones dorados"
  },
  {
    "title": "Las cavernas de cristal",
    "snippet": "Ni la cueva más profunda puede ocultar la luz que nace de tus ojos...",
    "letter": "Carla Lorena: Aunque los caminos a veces sean oscuros o silenciosos, tu fortaleza siempre encuentra una salida resplandeciente. Estoy inmensamente orgulloso de ti, de cada batalla que has ganado y de la dulzura con la que siempre sigues adelante.",
    "envEffect": "crystals",
    "envDesc": "🔮 Esferas místicas de zafiro y perlas de luz"
  },
  {
    "title": "El archipiélago de las nubes",
    "snippet": "Un horizonte sin límites para tus sueños más hermosos...",
    "letter": "Para Carla Lorena: Que ningún miedo recorte tus alas. El archipiélago te pertenece hoy y el cielo entero mañana. Sigue soñando en grande, que yo estaré aplaudiendo cada uno de tus logros y amándote en cada paso del camino.",
    "envEffect": "clouds",
    "envDesc": "☁️ Nubes viajeras y estrellas plateadas que caen suavemente"
  },
  {
    "title": "El laberinto de las mareas",
    "snippet": "Como las mareas fieles a la luna, mi cariño hacia ti nunca cambia...",
    "letter": "Carla Lorena: El mar puede ser turbulento, pero tu serenidad calma las aguas. Eres mi paz, mi rincón favorito en el mundo y el pensamiento dulce que me acompaña a cualquier hora. Que este laberinto sea solo un recordatorio de lo inteligente que eres para encontrar tu camino.",
    "envEffect": "tides",
    "envDesc": "🌊 Brisa marina y gotas de rocío luminiscente"
  },
  {
    "title": "La corona de las estrellas",
    "snippet": "La corona más hermosa es la bondad con la que iluminas el mundo...",
    "letter": "Reina de mi vida, Carla Lorena: Has llegado a la cima de las estrellas. La verdadera magia de esta aventura no es la meta, sino el corazón puro con el que cruzas cada meta en la vida real. Este reino y todo lo hermoso fue creado para ti, hoy y siempre. Con todo mi amor eterno, Adrián.",
    "envEffect": "stars",
    "envDesc": "✨ Lluvia de estrellas fugaces y polvo de galaxias doradas"
  }
];

const difficultyPresets = {
    calm: {
        id: 'calm',
        name: 'Serena',
        maxLives: 5,
        startingLives: 5,
        speedMultiplier: 0.72,
        damageInvulnerability: 2.2,
        jumpBoost: 1.08,
    },
    adventure: {
        id: 'adventure',
        name: 'Aventura',
        maxLives: 3,
        startingLives: 3,
        speedMultiplier: 1.0,
        damageInvulnerability: 1.2,
        jumpBoost: 1.0,
    },
    challenge: {
        id: 'challenge',
        name: 'Desafío Real',
        maxLives: 2,
        startingLives: 2,
        speedMultiplier: 1.35,
        damageInvulnerability: 0.8,
        jumpBoost: 0.98,
    }
};
let currentDifficulty = 'adventure';

const saveKey = 'el-jardin-de-carla:sultana-plataformas:v1';
const canvasWidth = 960;
const canvasHeight = 440;
const playerSize = { width: 30, height: 48 };
const levels = [
    {
        name: 'El sendero de las luciérnagas',
        theme: ['#f3d8ca', '#b9d3b1', '#728e68'],
        worldWidth: 2050,
        requiredPetals: 5,
        ability: 'Salto y carrera',
        collectible: { name: 'luciérnagas', symbol: '✦', color: '#f6d875', positions: [[430, 245], [920, 205], [1680, 200]] },
        platforms: [
            [0, 360, 450, 80], [535, 360, 310, 80], [910, 360, 390, 80],
            [1360, 360, 690, 80], [260, 290, 145, 18], [610, 265, 135, 18],
            [1000, 295, 155, 18], [1200, 245, 130, 18], [1510, 285, 150, 18],
            [1740, 235, 145, 18],
        ],
        petals: [[185, 322], [326, 250], [650, 225], [1050, 255], [1250, 205], [1580, 245], [1790, 195]],
        hazards: [[690, 342, 78, 18], [1090, 342, 82, 18]],
        enemies: [[390, 450, 360, 360, 55], [1065, 1230, 910, 360, 66], [1605, 1710, 1360, 285, 50], [720, 820, 535, 360, 62, 'bat'], [1850, 1950, 1740, 235, 58, 'wisp']],
        checkpoints: [780, 1450],
        charges: [],
    },
    {
        name: 'El puente de las nubes rosas',
        theme: ['#d5d7ec', '#c9b7d2', '#8a779e'],
        worldWidth: 2350,
        requiredPetals: 7,
        ability: 'Salto doble',
        collectible: { name: 'plumas de nube', symbol: '❧', color: '#f0d8ef', positions: [[355, 220], [820, 190], [1460, 180], [1900, 190]] },
        platforms: [
            [0, 360, 320, 80], [410, 360, 300, 80], [800, 360, 270, 80],
            [1170, 360, 260, 80], [1530, 360, 330, 80], [1950, 360, 400, 80],
            [220, 285, 120, 18], [490, 250, 135, 18], [690, 295, 125, 18],
            [900, 230, 150, 18], [1100, 275, 135, 18], [1300, 220, 145, 18],
            [1580, 275, 145, 18], [1790, 225, 135, 18], [2040, 280, 155, 18],
        ],
        petals: [[170, 320], [255, 250], [535, 215], [735, 260], [950, 195], [1150, 240], [1350, 185], [1640, 240], [1840, 190], [2100, 245]],
        hazards: [[555, 342, 72, 18], [930, 342, 72, 18], [1605, 342, 78, 18]],
        enemies: [[250, 315, 200, 360, 58], [610, 700, 410, 360, 68], [1240, 1400, 1170, 360, 72], [1700, 1830, 1530, 275, 78], [930, 1045, 800, 360, 74, 'bat'], [2100, 2290, 1950, 360, 82, 'wisp']],
        checkpoints: [800, 1530],
        charges: [],
    },
    {
        name: 'La torre del alba',
        theme: ['#dbb6ba', '#d8b58f', '#8b6a72'],
        worldWidth: 2650,
        requiredPetals: 9,
        ability: 'Destello protector',
        collectible: { name: 'llaves solares', symbol: '⚿', color: '#f1c95e', positions: [[420, 250], [850, 190], [1160, 225], [1800, 170], [2230, 205]] },
        platforms: [
            [0, 360, 350, 80], [455, 360, 275, 80], [830, 360, 280, 80],
            [1200, 360, 260, 80], [1560, 360, 300, 80], [1960, 360, 230, 80],
            [2280, 360, 370, 80], [250, 285, 140, 18], [510, 235, 130, 18],
            [690, 285, 145, 18], [900, 220, 145, 18], [1080, 270, 135, 18],
            [1290, 205, 145, 18], [1500, 260, 140, 18], [1690, 205, 135, 18],
            [1860, 275, 130, 18], [2070, 215, 150, 18], [2320, 275, 140, 18],
        ],
        petals: [[155, 320], [290, 250], [555, 200], [735, 250], [945, 185], [1120, 235], [1330, 170], [1540, 225], [1730, 170], [1900, 240], [2130, 180], [2370, 240]],
        hazards: [[520, 342, 75, 18], [900, 342, 84, 18], [1260, 342, 75, 18], [1630, 342, 85, 18], [2020, 342, 75, 18]],
        enemies: [[275, 345, 230, 360, 62], [740, 825, 730, 285, 65], [1040, 1150, 830, 360, 74], [1500, 1580, 1460, 360, 86], [1770, 1840, 1690, 205, 90], [2130, 2260, 1960, 360, 78], [520, 650, 455, 360, 70, 'bat'], [2400, 2600, 2280, 360, 84, 'wisp']],
        checkpoints: [830, 1560, 2280],
        charges: [[610, 205], [1400, 175], [1990, 235]],
    },
    {
        name: 'El bosque de los cristales',
        theme: ['#c6d8d1', '#9eb9a5', '#617b70'],
        worldWidth: 3000,
        requiredPetals: 11,
        ability: 'Salto doble y destello',
        collectible: { name: 'corazones de cristal', symbol: '◆', color: '#b7eee5', positions: [[370, 245], [760, 215], [1140, 190], [1880, 220], [2260, 190], [2700, 220]] },
        platforms: [
            [0, 360, 320, 80], [420, 360, 280, 80], [800, 360, 280, 80],
            [1190, 360, 270, 80], [1570, 360, 260, 80], [1940, 360, 260, 80],
            [2310, 360, 330, 80], [2750, 360, 250, 80],
            [205, 285, 125, 18], [485, 235, 135, 18], [690, 285, 125, 18],
            [875, 225, 145, 18], [1080, 275, 130, 18], [1260, 215, 145, 18],
            [1465, 270, 130, 18], [1640, 210, 145, 18], [1835, 275, 135, 18],
            [2020, 220, 145, 18], [2220, 275, 130, 18], [2405, 210, 145, 18],
            [2600, 270, 135, 18], [2785, 220, 145, 18],
        ],
        petals: [
            [155, 320], [250, 250], [530, 200], [735, 250], [930, 190],
            [1130, 240], [1320, 180], [1515, 235], [1700, 175], [1880, 240],
            [2080, 185], [2270, 240], [2465, 175], [2650, 235], [2845, 185],
        ],
        hazards: [
            [500, 342, 72, 18], [900, 342, 78, 18], [1270, 342, 78, 18],
            [1650, 342, 80, 18], [2040, 342, 78, 18], [2420, 342, 80, 18],
            [2790, 342, 78, 18],
        ],
        enemies: [
            [260, 300, 210, 360, 68], [600, 680, 620, 235, 72],
            [970, 1060, 800, 360, 76], [1360, 1440, 1360, 215, 82],
            [1740, 1810, 1570, 360, 86], [2120, 2180, 2020, 220, 88],
            [2500, 2580, 2310, 360, 94], [2860, 2950, 2750, 220, 96],
            [450, 530, 420, 360, 75, 'bat'], [2210, 2290, 1940, 360, 90, 'wisp'],
        ],
        checkpoints: [800, 1570, 2310],
        charges: [[610, 195], [1280, 175], [2050, 180], [2630, 230]],
    },
    {
        name: 'El corazón del alba',
        theme: ['#efd7c1', '#d8ae9a', '#806675'],
        worldWidth: 3500,
        requiredPetals: 12,
        ability: 'Salto doble y destello final',
        collectible: { name: 'flores del alba', symbol: '✿', color: '#eea9c2', positions: [[360, 245], [735, 230], [1085, 190], [1450, 190], [2180, 205], [2880, 230], [3290, 200]] },
        platforms: [
            [0, 360, 300, 80], [405, 360, 265, 80], [770, 360, 260, 80],
            [1135, 360, 260, 80], [1500, 360, 260, 80], [1870, 360, 260, 80],
            [2240, 360, 260, 80], [2610, 360, 260, 80], [2980, 360, 290, 80],
            [3380, 360, 120, 80],
            [190, 280, 125, 18], [455, 225, 135, 18], [660, 285, 120, 18],
            [825, 215, 145, 18], [1030, 275, 125, 18], [1190, 205, 145, 18],
            [1395, 275, 120, 18], [1555, 210, 145, 18], [1760, 270, 125, 18],
            [1925, 205, 145, 18], [2130, 280, 120, 18], [2295, 210, 145, 18],
            [2500, 275, 125, 18], [2665, 205, 145, 18], [2870, 275, 125, 18],
            [3035, 210, 145, 18], [3240, 270, 130, 18], [3400, 220, 100, 18],
        ],
        petals: [
            [130, 320], [230, 245], [500, 190], [710, 250], [890, 180],
            [1080, 235], [1255, 170], [1450, 235], [1620, 175], [1810, 230],
            [1985, 170], [2180, 245], [2355, 175], [2550, 240], [2725, 170],
            [2920, 240], [3095, 175], [3300, 235], [3435, 180],
        ],
        hazards: [
            [460, 342, 78, 18], [830, 342, 82, 18], [1200, 342, 80, 18],
            [1560, 342, 82, 18], [1930, 342, 84, 18], [2300, 342, 82, 18],
            [2670, 342, 84, 18], [3040, 342, 86, 18], [3400, 342, 70, 18],
        ],
        enemies: [
            [245, 290, 200, 360, 72], [560, 650, 405, 225, 78],
            [925, 1010, 770, 360, 84], [1290, 1375, 1190, 205, 88],
            [1655, 1740, 1500, 360, 92], [2025, 2110, 1925, 205, 96],
            [2395, 2480, 2240, 360, 100], [2765, 2850, 2665, 205, 104],
            [3135, 3220, 2980, 360, 108], [3430, 3480, 3380, 220, 115],
            [950, 1080, 830, 360, 86, 'bat'], [3000, 3170, 2980, 360, 100, 'wisp'],
        ],
        checkpoints: [770, 1500, 2240, 2980],
        charges: [[510, 180], [1190, 165], [1925, 165], [2665, 165], [3240, 230]],
    },
    {
        name: 'Las cavernas de cristal',
        theme: ['#cbd5e8', '#aaa6c9', '#666785'],
        worldWidth: 3900,
        requiredPetals: 14,
        ability: 'Salto doble y destello',
        collectible: { name: 'perlas de caverna', symbol: '◉', color: '#b4e1ee', positions: [[350, 240], [735, 250], [1100, 230], [1800, 240], [2500, 230], [3200, 245], [3570, 230]] },
        platforms: [
            [0, 360, 300, 80], [405, 360, 265, 80], [770, 360, 250, 80],
            [1120, 360, 255, 80], [1475, 360, 255, 80], [1830, 360, 250, 80],
            [2180, 360, 255, 80], [2535, 360, 250, 80], [2885, 360, 260, 80],
            [3245, 360, 270, 80], [3615, 360, 285, 80],
            [180, 285, 120, 18], [445, 230, 135, 18], [650, 285, 125, 18],
            [820, 215, 140, 18], [1010, 280, 125, 18], [1175, 220, 140, 18],
            [1360, 275, 125, 18], [1530, 205, 145, 18], [1725, 275, 125, 18],
            [1890, 215, 140, 18], [2070, 280, 120, 18], [2235, 215, 145, 18],
            [2430, 275, 125, 18], [2600, 205, 140, 18], [2785, 275, 125, 18],
            [2950, 215, 145, 18], [3140, 280, 125, 18], [3310, 210, 145, 18],
            [3500, 275, 125, 18], [3690, 215, 150, 18],
        ],
        petals: [
            [125, 320], [220, 250], [490, 195], [705, 250], [875, 180],
            [1065, 245], [1230, 185], [1415, 240], [1585, 170], [1780, 240],
            [1945, 180], [2125, 245], [2290, 175], [2485, 240], [2655, 170],
            [2845, 240], [3015, 180], [3200, 245], [3375, 175], [3560, 240],
            [3750, 180],
        ],
        hazards: [
            [450, 342, 78, 18], [830, 342, 82, 18], [1190, 342, 80, 18],
            [1550, 342, 82, 18], [1905, 342, 84, 18], [2260, 342, 82, 18],
            [2615, 342, 84, 18], [2970, 342, 86, 18], [3330, 342, 84, 18],
            [3700, 342, 82, 18],
        ],
        enemies: [
            [250, 290, 200, 360, 78], [555, 650, 405, 230, 82],
            [930, 1000, 770, 360, 86], [1280, 1360, 1175, 220, 90],
            [1640, 1715, 1475, 360, 94], [1990, 2060, 1890, 215, 96],
            [2350, 2420, 2180, 360, 100], [2700, 2770, 2600, 205, 104],
            [3060, 3130, 2885, 360, 108], [3420, 3500, 3310, 210, 112],
            [3780, 3870, 3615, 360, 118],
            [700, 755, 670, 285, 78, 'bat'], [3300, 3580, 3245, 360, 108, 'wisp'],
        ],
        checkpoints: [770, 1475, 2180, 2885, 3615],
        charges: [[520, 190], [1230, 175], [1945, 170], [2655, 165], [3375, 165]],
    },
    {
        name: 'El archipiélago de las nubes',
        theme: ['#d4e5ee', '#b5c9df', '#718ba8'],
        worldWidth: 4250,
        requiredPetals: 16,
        ability: 'Salto doble y destello',
        collectible: { name: 'conchas celestes', symbol: '◖', color: '#f3c7df', positions: [[320, 250], [680, 240], [1010, 185], [1670, 190], [2330, 185], [2990, 180], [3650, 190], [3970, 230]] },
        platforms: [
            [0, 360, 280, 80], [380, 360, 230, 80], [710, 360, 230, 80],
            [1040, 360, 230, 80], [1370, 360, 230, 80], [1700, 360, 230, 80],
            [2030, 360, 230, 80], [2360, 360, 230, 80], [2690, 360, 230, 80],
            [3020, 360, 230, 80], [3350, 360, 230, 80], [3680, 360, 230, 80],
            [4010, 360, 240, 80],
            [150, 285, 115, 18], [405, 235, 120, 18], [600, 290, 115, 18],
            [735, 220, 125, 18], [930, 275, 115, 18], [1065, 205, 125, 18],
            [1260, 275, 115, 18], [1395, 215, 125, 18], [1590, 280, 115, 18],
            [1725, 205, 125, 18], [1920, 275, 115, 18], [2055, 210, 125, 18],
            [2250, 280, 115, 18], [2385, 205, 125, 18], [2580, 275, 115, 18],
            [2715, 210, 125, 18], [2910, 280, 115, 18], [3045, 205, 125, 18],
            [3240, 275, 115, 18], [3375, 210, 125, 18], [3570, 280, 115, 18],
            [3705, 205, 125, 18], [3900, 275, 115, 18], [4040, 215, 130, 18],
        ],
        petals: [
            [110, 320], [190, 250], [445, 200], [655, 255], [775, 185],
            [980, 240], [1105, 170], [1310, 240], [1435, 180], [1640, 245],
            [1765, 170], [1970, 240], [2095, 175], [2300, 245], [2425, 170],
            [2630, 240], [2755, 175], [2960, 245], [3085, 170], [3290, 240],
            [3415, 175], [3620, 245], [3745, 170], [3950, 240], [4080, 180],
        ],
        hazards: [
            [420, 342, 72, 18], [750, 342, 75, 18], [1080, 342, 75, 18],
            [1410, 342, 75, 18], [1740, 342, 75, 18], [2070, 342, 75, 18],
            [2400, 342, 75, 18], [2730, 342, 75, 18], [3060, 342, 75, 18],
            [3390, 342, 75, 18], [3720, 342, 75, 18], [4050, 342, 75, 18],
        ],
        enemies: [
            [235, 270, 200, 360, 80], [510, 590, 405, 235, 86],
            [855, 920, 710, 360, 90], [1185, 1250, 1065, 205, 94],
            [1515, 1580, 1370, 360, 98], [1845, 1910, 1725, 205, 102],
            [2175, 2240, 2030, 360, 106], [2505, 2570, 2385, 205, 110],
            [2835, 2900, 2690, 360, 114], [3165, 3230, 3045, 205, 118],
            [3495, 3560, 3350, 360, 122], [3825, 3890, 3705, 205, 126],
            [4140, 4230, 4010, 360, 130],
            [650, 700, 610, 290, 84, 'bat'], [3060, 3240, 3020, 360, 116, 'wisp'],
        ],
        checkpoints: [710, 1370, 2030, 2690, 3350, 4010],
        charges: [[445, 195], [1105, 165], [1765, 165], [2425, 165], [3085, 165], [3745, 165]],
    },
    {
        name: 'El laberinto de las mareas',
        theme: ['#c8e1df', '#95c0be', '#547d82'],
        worldWidth: 4650,
        requiredPetals: 18,
        ability: 'Salto doble y destello',
        collectible: { name: 'sellos lunares', symbol: '☾', color: '#c6e8de', positions: [[300, 240], [665, 230], [985, 175], [1625, 175], [2265, 180], [2905, 170], [3545, 170], [4185, 175], [4500, 230]] },
        platforms: [
            [0, 360, 275, 80], [375, 360, 220, 80], [695, 360, 220, 80],
            [1015, 360, 220, 80], [1335, 360, 220, 80], [1655, 360, 220, 80],
            [1975, 360, 220, 80], [2295, 360, 220, 80], [2615, 360, 220, 80],
            [2935, 360, 220, 80], [3255, 360, 220, 80], [3575, 360, 220, 80],
            [3895, 360, 220, 80], [4215, 360, 220, 80], [4535, 360, 115, 80],
            [130, 285, 110, 18], [385, 225, 120, 18], [575, 285, 110, 18],
            [705, 215, 120, 18], [895, 275, 110, 18], [1025, 205, 120, 18],
            [1215, 275, 110, 18], [1345, 210, 120, 18], [1535, 280, 110, 18],
            [1665, 205, 120, 18], [1855, 275, 110, 18], [1985, 210, 120, 18],
            [2175, 280, 110, 18], [2305, 205, 120, 18], [2495, 275, 110, 18],
            [2625, 210, 120, 18], [2815, 280, 110, 18], [2945, 205, 120, 18],
            [3135, 275, 110, 18], [3265, 210, 120, 18], [3455, 280, 110, 18],
            [3585, 205, 120, 18], [3775, 275, 110, 18], [3905, 210, 120, 18],
            [4095, 280, 110, 18], [4225, 205, 120, 18], [4415, 275, 110, 18],
            [4545, 215, 100, 18],
        ],
        petals: [
            [100, 320], [170, 250], [430, 190], [625, 250], [745, 180],
            [945, 240], [1065, 170], [1265, 240], [1385, 175], [1585, 245],
            [1705, 170], [1905, 240], [2025, 175], [2225, 245], [2345, 170],
            [2545, 240], [2665, 175], [2865, 245], [2985, 170], [3185, 240],
            [3305, 175], [3505, 245], [3625, 170], [3825, 240], [3945, 175],
            [4145, 245], [4265, 170], [4465, 240], [4580, 180],
        ],
        hazards: [
            [400, 342, 68, 18], [720, 342, 72, 18], [1040, 342, 72, 18],
            [1360, 342, 72, 18], [1680, 342, 72, 18], [2000, 342, 72, 18],
            [2320, 342, 72, 18], [2640, 342, 72, 18], [2960, 342, 72, 18],
            [3280, 342, 72, 18], [3600, 342, 72, 18], [3920, 342, 72, 18],
            [4240, 342, 72, 18], [4560, 342, 60, 18],
        ],
        enemies: [
            [225, 265, 180, 360, 82], [495, 575, 385, 225, 90],
            [815, 895, 695, 360, 94], [1135, 1215, 1025, 205, 98],
            [1455, 1535, 1335, 360, 102], [1775, 1855, 1665, 205, 106],
            [2095, 2175, 1975, 360, 110], [2415, 2495, 2305, 205, 114],
            [2735, 2815, 2615, 360, 118], [3055, 3135, 2945, 205, 122],
            [3375, 3455, 3255, 360, 126], [3695, 3775, 3585, 205, 130],
            [4015, 4095, 3895, 360, 134], [4335, 4415, 4225, 205, 138],
            [4580, 4640, 4535, 360, 145],
            [650, 685, 595, 285, 86, 'bat'], [3280, 3470, 3255, 360, 128, 'wisp'],
        ],
        checkpoints: [695, 1335, 1975, 2615, 3255, 3895, 4535],
        charges: [[430, 185], [1065, 165], [1705, 165], [2345, 165], [2985, 165], [3625, 165], [4265, 165]],
    },
    {
        name: 'La corona de las estrellas',
        theme: ['#e6d7eb', '#c2a8cf', '#77658c'],
        worldWidth: 5100,
        requiredPetals: 20,
        ability: 'Salto doble y destello maestro',
        collectible: { name: 'estrellas de la corona', symbol: '✧', color: '#ffe081', positions: [[310, 245], [650, 240], [965, 185], [1595, 180], [2225, 175], [2855, 180], [3485, 180], [4115, 180], [4745, 240], [5020, 225]] },
        platforms: [
            [0, 360, 270, 80], [370, 360, 215, 80], [685, 360, 215, 80],
            [1000, 360, 215, 80], [1315, 360, 215, 80], [1630, 360, 215, 80],
            [1945, 360, 215, 80], [2260, 360, 215, 80], [2575, 360, 215, 80],
            [2890, 360, 215, 80], [3205, 360, 215, 80], [3520, 360, 215, 80],
            [3835, 360, 215, 80], [4150, 360, 215, 80], [4465, 360, 215, 80],
            [4780, 360, 320, 80],
            [115, 285, 105, 18], [385, 220, 115, 18], [565, 285, 105, 18],
            [700, 205, 115, 18], [880, 275, 105, 18], [1015, 195, 115, 18],
            [1195, 275, 105, 18], [1330, 205, 115, 18], [1510, 280, 105, 18],
            [1645, 195, 115, 18], [1825, 275, 105, 18], [1960, 205, 115, 18],
            [2140, 280, 105, 18], [2275, 195, 115, 18], [2455, 275, 105, 18],
            [2590, 205, 115, 18], [2770, 280, 105, 18], [2905, 195, 115, 18],
            [3085, 275, 105, 18], [3220, 205, 115, 18], [3400, 280, 105, 18],
            [3535, 195, 115, 18], [3715, 275, 105, 18], [3850, 205, 115, 18],
            [4030, 280, 105, 18], [4165, 195, 115, 18], [4345, 275, 105, 18],
            [4480, 205, 115, 18], [4660, 280, 105, 18], [4800, 205, 125, 18],
            [4960, 270, 110, 18],
        ],
        petals: [
            [90, 320], [155, 250], [425, 185], [615, 250], [735, 170],
            [925, 235], [1050, 160], [1240, 235], [1365, 170], [1555, 240],
            [1680, 160], [1870, 235], [1995, 170], [2185, 240], [2310, 160],
            [2500, 235], [2625, 170], [2815, 240], [2940, 160], [3130, 235],
            [3255, 170], [3445, 240], [3570, 160], [3760, 235], [3885, 170],
            [4075, 240], [4200, 160], [4390, 235], [4515, 170], [4705, 245],
            [4840, 165], [4995, 235],
        ],
        hazards: [
            [395, 342, 68, 18], [710, 342, 72, 18], [1025, 342, 72, 18],
            [1340, 342, 72, 18], [1655, 342, 72, 18], [1970, 342, 72, 18],
            [2285, 342, 72, 18], [2600, 342, 72, 18], [2915, 342, 72, 18],
            [3230, 342, 72, 18], [3545, 342, 72, 18], [3860, 342, 72, 18],
            [4175, 342, 72, 18], [4490, 342, 72, 18], [4805, 342, 72, 18],
            [4990, 342, 70, 18],
        ],
        enemies: [
            [220, 260, 170, 360, 88], [495, 575, 385, 220, 96],
            [810, 890, 700, 360, 100], [1125, 1205, 1015, 195, 104],
            [1440, 1520, 1330, 360, 108], [1755, 1835, 1645, 195, 112],
            [2070, 2150, 1960, 360, 116], [2385, 2465, 2275, 195, 120],
            [2700, 2780, 2590, 360, 124], [3015, 3095, 2905, 195, 128],
            [3330, 3410, 3220, 360, 132], [3645, 3725, 3535, 195, 136],
            [3960, 4040, 3850, 360, 140], [4275, 4355, 4165, 195, 144],
            [4590, 4670, 4480, 360, 148], [4905, 4990, 4780, 360, 155],
            [650, 675, 585, 285, 90, 'bat'], [4150, 4420, 4150, 360, 145, 'wisp'],
        ],
        checkpoints: [685, 1315, 1945, 2575, 3205, 3835, 4465, 4780],
        charges: [[425, 180], [1050, 155], [1680, 155], [2310, 155], [2940, 155], [3570, 155], [4200, 155], [4840, 155]],
    },
];

export function initializeSultanaPlatformer() {
    const screen = document.querySelector('[data-screen="sultana-plataformas"]');
    const canvas = screen?.querySelector('[data-platformer-canvas]');
    if (!screen || !canvas || canvas.dataset.initialized === 'true') return;
    canvas.dataset.initialized = 'true';

    const context = canvas.getContext('2d');
    const status = screen.querySelector('[data-platformer-status]');
    const levelLabel = screen.querySelector('[data-platformer-level]');
    const petalsLabel = screen.querySelector('[data-platformer-petals]');
    const livesLabel = screen.querySelector('[data-platformer-lives]');
    const scoreLabel = screen.querySelector('[data-platformer-score]');
    const bestLevelLabel = screen.querySelector('[data-platformer-best-level]');
    const bestCampaignLabel = screen.querySelector('[data-platformer-best-campaign]');
    const abilityLabel = screen.querySelector('[data-platformer-ability]');
    const relicsLabel = screen.querySelector('[data-platformer-relics]');
    const levelSelect = screen.querySelector('[data-platformer-select]');
    const restartButton = screen.querySelector('[data-platformer-restart]');
    const pauseButton = screen.querySelector('[data-platformer-pause]');
    const nextButton = screen.querySelector('[data-platformer-next]');
    const finalePanel = screen.querySelector('[data-platformer-finale]');
    const finaleTitle = screen.querySelector('#platformer-finale-title');
    const difficultySelect = screen.querySelector('[data-platformer-difficulty]');
    const scrollButton = screen.querySelector('[data-platformer-scroll-btn]');
    const loveBanner = screen.querySelector('[data-platformer-love-banner]');
    const letterSnippet = screen.querySelector('[data-platformer-letter-snippet]');
    const readLetterBtn = screen.querySelector('[data-platformer-read-letter]');
    const letterModal = screen.querySelector('[data-platformer-letter-modal]');
    const modalTitle = screen.querySelector('[data-platformer-modal-title]');
    const modalText = screen.querySelector('[data-platformer-modal-text]');
    const modalClose = screen.querySelector('[data-platformer-letter-close]');
    const modalConfirm = screen.querySelector('[data-platformer-letter-confirm]');

    const replayButton = screen.querySelector('[data-platformer-replay]');
    if (!context) {
        status.textContent = 'Este navegador no permite iniciar el escenario de plataformas.';
        return;
    }

    let progress = {
        version: 2,
        unlockedLevel: 1,
        completed: false,
        bestScore: 0,
        bestLevelScores: Array(levels.length).fill(0),
    };
    let storageAvailable = true;
    try {
        const saved = window.localStorage.getItem(saveKey);
        if (saved) {
            const parsed = JSON.parse(saved);
            if ((parsed?.version === 1 || parsed?.version === 2)
                && Number.isInteger(parsed.unlockedLevel)
                && parsed.unlockedLevel >= 1
                && parsed.unlockedLevel <= levels.length
                && typeof parsed.completed === 'boolean') {
                progress = {
                    version: 2,
                    unlockedLevel: parsed.unlockedLevel,
                    completed: parsed.completed,
                    bestScore: Number.isSafeInteger(parsed.bestScore) && parsed.bestScore >= 0 ? parsed.bestScore : 0,
                    bestLevelScores: Array.from({ length: levels.length }, (_, index) => {
                        const score = parsed.bestLevelScores?.[index];
                        return Number.isSafeInteger(score) && score >= 0 ? score : 0;
                    }),
                };
            }
        }
    } catch {
        storageAvailable = false;
    }

    let currentLevel = progress.unlockedLevel - 1;
    let player;
    let petals;
    let relics;
    let enemies;
    let charges;
    let checkpoints;
    let activeCheckpoint = 0;
    let frameId = 0;
    let lastTime = 0;
    let elapsed = 0;
    let cameraX = 0;
    let runScore = 0;
    let levelScore = 0;
    let levelScoreStart = 0;
    let campaignAttempt = false;
    let gameComplete = false;
    let paused = false;
    let nextLevelDelay = 0;
    let gateMessageCooldown = 0;
    const keys = new Set();
        const touch = new Set();

    let visualParticles = [];
    function spawnParticle(x, y, vx, vy, color, size, life, shape = 'circle') {
        if (visualParticles.length > 90) visualParticles.shift();
        visualParticles.push({ x, y, vx, vy, color, size, life, maxLife: life, shape });
    };

    function updateVisualParticles(delta) {
        for (let i = visualParticles.length - 1; i >= 0; i--) {
            const p = visualParticles[i];
            p.life -= delta;
            if (p.life <= 0) {
                visualParticles.splice(i, 1);
                continue;
            }
            p.x += p.vx * delta;
            p.y += p.vy * delta;
            if (p.shape === 'star' || p.shape === 'petal') {
                p.y += Math.sin(p.life * 6) * 12 * delta;
            }
        }
    };

    function drawVisualParticles() {
        visualParticles.forEach(p => {
            const screenX = p.x - cameraX;
            if (screenX < -20 || screenX > canvasWidth + 20) return;
            const alpha = Math.max(0, p.life / p.maxLife);
            context.save();
            context.globalAlpha = alpha;
            context.fillStyle = p.color;
            if (p.shape === 'star') {
                context.beginPath();
                context.arc(screenX, p.y, p.size, 0, Math.PI * 2);
                context.fill();
                context.strokeStyle = '#ffffff';
                context.lineWidth = 1;
                context.beginPath();
                context.moveTo(screenX - p.size * 1.8, p.y);
                context.lineTo(screenX + p.size * 1.8, p.y);
                context.moveTo(screenX, p.y - p.size * 1.8);
                context.lineTo(screenX, p.y + p.size * 1.8);
                context.stroke();
            } else if (p.shape === 'petal') {
                context.beginPath();
                context.ellipse(screenX, p.y, p.size * 1.5, p.size, Math.PI / 4, 0, Math.PI * 2);
                context.fill();
            } else {
                context.beginPath();
                context.arc(screenX, p.y, p.size, 0, Math.PI * 2);
                context.fill();
            }
            context.restore();
        });
    };

    function announce(message) { status.textContent = message; };

    function openLetterModal() {
        const letterData = loveLetters[currentLevel] || loveLetters[0];
        if (modalTitle) modalTitle.textContent = "Escenario " + (currentLevel + 1) + ": " + letterData.title;
        if (modalText) {
            modalText.innerHTML = "<p>" + letterData.letter + "</p><p style=\"margin-top:12px; font-size:13px; color:#85636c;\"><strong>Atmósfera de este rincón:</strong> " + letterData.envDesc + "</p>";
        }
        if (letterModal && typeof letterModal.showModal === 'function') {
            letterModal.showModal();
        }
    };
    function closeLetterModal() {
        if (letterModal && typeof letterModal.close === 'function') {
            letterModal.close();
        }
    };

    function saveProgress() {
        if (!storageAvailable) return false;
        try {
            window.localStorage.setItem(saveKey, JSON.stringify(progress));
            return true;
        } catch {
            storageAvailable = false;
            return false;
        }
    };
    const levelData = () => levels[currentLevel];
    const worldPlatforms = () => levelData().platforms.map(([x, y, width, height]) => ({ x, y, width, height }));
    function enemyVerticalOffset(enemy) {
        if (enemy.kind === 'bat') return Math.sin(elapsed * 3.2 + enemy.id) * 24;
        if (enemy.kind === 'wisp') return Math.sin(elapsed * 2.1 + enemy.id) * 13;
        return 0;
    };
    function enemyCollisionBox(enemy) {
        const centerY = enemy.floor - 14 + enemyVerticalOffset(enemy);
        if (enemy.kind === 'bat') return { x: enemy.x - 18, y: centerY - 12, width: 36, height: 24 };
        if (enemy.kind === 'wisp') return { x: enemy.x - 17, y: centerY - 14, width: 34, height: 28 };
        return { x: enemy.x - 17, y: enemy.floor - 27, width: 34, height: 27 };
    };

    function createPlayer(startX = 70) {
        const diff = difficultyPresets[currentDifficulty] || difficultyPresets.adventure;
        return {
        x: startX,
        y: 360 - playerSize.height,
        vx: 0,
        vy: 0,
        jumps: 0,
        lives: diff.startingLives,
        petals: 0,
        relics: 0,
        light: 0,
        invulnerable: 0,
        facing: 1,
        pulse: 0,
        grounded: true,
    };
};

    function updateLevelOptions() {
        levelSelect.replaceChildren(...levels.map((level, index) => {
            const option = document.createElement('option');
            option.value = String(index);
            option.textContent = `Nivel ${index + 1} · ${level.name}`;
            option.disabled = index + 1 > progress.unlockedLevel;
            return option;
        }));
    };

    function setHud() {

        const diff = difficultyPresets[currentDifficulty] || difficultyPresets.adventure;
        levelLabel.textContent = "Nivel " + (currentLevel + 1) + " de " + levels.length + " · " + levelData().name + " [" + diff.name + "]";
        petalsLabel.textContent = "Pétalos: " + player.petals + " de " + levelData().requiredPetals;
        livesLabel.textContent = "Corazones: " + '♥'.repeat(player.lives) + '♡'.repeat(Math.max(0, diff.maxLives - player.lives));
        scoreLabel.textContent = "Puntuación: " + runScore.toLocaleString('es');
        bestLevelLabel.textContent = "Récord del nivel: " + progress.bestLevelScores[currentLevel].toLocaleString('es');
        bestCampaignLabel.textContent = "Récord de campaña: " + progress.bestScore.toLocaleString('es');
        abilityLabel.textContent = "Habilidad: " + levelData().ability + (currentLevel >= 2 ? " · Destellos: " + player.light : "");
        relicsLabel.textContent = levelData().collectible.name + ": " + player.relics + " de " + levelData().collectible.positions.length;
        levelSelect.value = String(currentLevel);
        if (letterSnippet) {
            const letter = loveLetters[currentLevel] || loveLetters[0];
            letterSnippet.textContent = letter.snippet;
        }

    };

        function stopControls() {
        keys.clear();
        touch.clear();
        screen.querySelectorAll('[data-platformer-control]').forEach((button) => button.setAttribute('aria-pressed', 'false'));
        if (player) player.jumpHeld = false;
    };

    function startLevel(index, {
        resumed = false,
        automatic = false,
        preserveRunScore = false,
        preserveCampaign = false,
        message,
    } = {}) {
        currentLevel = Math.min(Math.max(index, 0), progress.unlockedLevel - 1, levels.length - 1);
        if (!preserveRunScore) runScore = 0;
        if (!preserveCampaign) campaignAttempt = currentLevel === 0;
        levelScore = 0;
        levelScoreStart = runScore;
        const data = levelData();
        player = createPlayer();
        petals = data.petals.map(([x, y]) => ({ x, y, collected: false }));
        relics = data.collectible.positions.map(([x, y]) => ({ x, y, collected: false }));
        charges = data.charges.map(([x, y]) => ({ x, y, collected: false }));
        
        const diff = difficultyPresets[currentDifficulty] || difficultyPresets.adventure;
        enemies = data.enemies.map(([x, right, left, floor, speed, kind = 'shadow'], id) => ({

            x, right, left, floor, speed: (id % 2 ? speed : -speed) * diff.speedMultiplier, id, kind,
            defeated: false, stunned: 0, dashCooldown: 1 + (id % 3) * 0.6, dashTime: 0, dashDirection: 0,
        }));
        checkpoints = data.checkpoints.map((x) => ({ x, active: false }));
        activeCheckpoint = 0;
        cameraX = 0;
        elapsed = 0;
        gameComplete = false;
        paused = false;
        nextLevelDelay = 0;
        stopControls();
        pauseButton.textContent = 'Pausar';
        pauseButton.setAttribute('aria-pressed', 'false');
        nextButton.hidden = true;
        finalePanel.hidden = true;
        gateMessageCooldown = 0;
        setHud();
        announce(message ?? (automatic
            ? `Comienza el nivel ${currentLevel + 1}: ${data.name}. Reúne ${data.requiredPetals} pétalos y llega al arco.`
            : resumed
                ? `Retomas el nivel ${currentLevel + 1}. Reúne pétalos, evita las zarzas y alcanza el arco.`
                : `Nivel ${currentLevel + 1}: reúne ${data.requiredPetals} pétalos y llega al arco.`));
        draw();
    };

    function addScore(points) {
        runScore += points;
        levelScore += points;
    };

    function restartCurrentLevel(message) {
        runScore = levelScoreStart;
        startLevel(currentLevel, { preserveRunScore: true, preserveCampaign: true, message });
    };

    function resize() {
        const bounds = canvas.getBoundingClientRect();
        const ratio = Math.min(window.devicePixelRatio || 1, 1.5);
        canvas.width = Math.round(bounds.width * ratio);
        canvas.height = Math.round(bounds.height * ratio);
        draw();
    };

    function roundedRect(x, y, width, height, radius) {
        context.beginPath();
        context.roundRect(x, y, width, height, radius);
    };

    function drawBackground() {
        const [sky, hill, ground] = levelData().theme;
        const gradient = context.createLinearGradient(0, 0, 0, canvasHeight);
        gradient.addColorStop(0, sky);
        gradient.addColorStop(1, '#fff7ec');
        context.fillStyle = gradient;
        context.fillRect(0, 0, canvasWidth, canvasHeight);
        context.fillStyle = 'rgba(255, 249, 225, .75)';
        context.beginPath();
        context.arc(790, 92, 38, 0, Math.PI * 2);
        context.fill();
        for (let row = 0; row < 3; row += 1) {
            const parallax = cameraX * (0.12 + row * 0.1);
            context.fillStyle = row === 2 ? ground : hill;
            context.globalAlpha = 0.25 + row * 0.12;
            context.beginPath();
            context.moveTo(0, 290 + row * 28);
            for (let x = -130; x <= canvasWidth + 160; x += 130) {
                const waveX = x - (parallax % 130);
                context.quadraticCurveTo(waveX + 65, 215 + row * 30, waveX + 130, 290 + row * 28);
            }
            context.lineTo(canvasWidth, canvasHeight);
            context.lineTo(0, canvasHeight);
            context.closePath();
            context.fill();
        }
        context.globalAlpha = 1;
        for (let index = 0; index < 15; index += 1) {
            const x = ((index * 173 - cameraX * 0.32) % (canvasWidth + 50) + canvasWidth + 50) % (canvasWidth + 50);
            const y = 45 + (index * 61) % 180;
            context.fillStyle = 'rgba(255,255,255,.46)';
            context.beginPath();
            context.arc(x, y, 1.5 + index % 3, 0, Math.PI * 2);
            context.fill();
        }
    };

    function drawPlayer() {
        if (player.invulnerable > 0 && Math.floor(elapsed * 14) % 2 === 0) return;
        const x = player.x - cameraX;
        const y = player.y;
        const running = player.grounded && Math.abs(player.vx) > 1;
        const stride = running ? Math.sin(elapsed * 15) * 5 : 0;
        const lift = player.grounded ? 0 : Math.min(8, Math.abs(player.vy) / 90);
        context.fillStyle = 'rgba(76, 58, 67, .17)';
        context.beginPath();
        context.ellipse(x + 15, y + 50 + lift, Math.max(7, 14 - lift / 2), 3, 0, 0, Math.PI * 2);
        context.fill();
        if (player.pulse > 0) {
            context.strokeStyle = `rgba(255, 230, 151, ${player.pulse / 0.35})`;
            context.lineWidth = 5;
            context.beginPath();
            context.arc(x + 15, y + 23, (0.35 - player.pulse) * 240, 0, Math.PI * 2);
            context.stroke();
        }
        context.save();
        context.translate(x + 15, y + 24);
        context.scale(player.facing, 1);
        context.strokeStyle = '#56464f';
        context.lineWidth = 4;
        context.lineCap = 'round';
        context.beginPath();
        context.moveTo(-5, 18);
        context.lineTo(-6 - stride, 23);
        context.moveTo(5, 18);
        context.lineTo(6 + stride, 23);
        context.stroke();
        context.fillStyle = '#56464f';
        context.beginPath();
        context.arc(0, -10, 10, Math.PI, Math.PI * 2);
        context.fill();
        context.fillStyle = '#edc0a8';
        context.beginPath();
        context.arc(0, -9, 8, 0, Math.PI * 2);
        context.fill();
        context.fillStyle = '#55474a';
        context.beginPath();
        context.arc(4, -10, 1.3, 0, Math.PI * 2);
        context.fill();
        context.fillStyle = '#98728f';
        context.beginPath();
        context.moveTo(-10, 1);
        context.lineTo(10, 1);
        context.lineTo(14, 19);
        context.lineTo(-14, 19);
        context.closePath();
        context.fill();
        context.strokeStyle = '#edc0a8';
        context.lineWidth = 3;
        context.beginPath();
        context.moveTo(-9, 5);
        context.lineTo(-13, 11 - stride * 0.45);
        context.moveTo(9, 5);
        context.lineTo(13, 11 + stride * 0.45);
        context.stroke();
        context.fillStyle = '#d6b36e';
        context.beginPath();
        context.moveTo(-5, -20);
        context.lineTo(0, -32);
        context.lineTo(5, -20);
        context.closePath();
        context.fill();
        context.fillStyle = '#d6b36e';
        context.fillRect(-8, -21, 16, 3);
        context.fillStyle = '#55474a';
        context.fillRect(-10 - stride, 22 + Math.abs(stride) * 0.35, 8, 4);
        context.fillRect(2 + stride, 22 + Math.abs(stride) * 0.35, 8, 4);
        if (currentLevel >= 2 && player.light > 0) {
            context.fillStyle = '#f2d88c';
            context.beginPath();
            context.arc(0, -37, 4 + Math.sin(elapsed * 5) * 1.2, 0, Math.PI * 2);
            context.fill();
        }
        context.restore();
    };

    function draw() {
        if (!context || !player) return;
        context.save();
        context.scale(canvas.width / canvasWidth, canvas.height / canvasHeight);
        drawBackground();
        const offset = cameraX;

        levelData().hazards.forEach(([x, y, width, height]) => {
            context.fillStyle = '#896d80';
            for (let spike = 0; spike < width; spike += 18) {
                context.beginPath();
                context.moveTo(x + spike - offset, y + height);
                context.lineTo(x + spike + 9 - offset, y);
                context.lineTo(x + spike + 18 - offset, y + height);
                context.closePath();
                context.fill();
            }
        });

        worldPlatforms().forEach((platform) => {
            const x = platform.x - offset;
            if (x + platform.width < -10 || x > canvasWidth + 10) return;
            context.fillStyle = '#816e70';
            roundedRect(x, platform.y, platform.width, platform.height, 7);
            context.fill();
            context.fillStyle = '#82956c';
            roundedRect(x, platform.y - 5, platform.width, 11, 5);
            context.fill();
            context.fillStyle = 'rgba(255,255,255,.22)';
            context.fillRect(x + 8, platform.y + 12, Math.max(0, platform.width - 16), 2);
        });

        petals.forEach((petal) => {
            if (petal.collected) return;
            const x = petal.x - offset;
            if (x < -20 || x > canvasWidth + 20) return;
            context.save();
            context.translate(x, petal.y + Math.sin(elapsed * 3 + petal.x) * 3);
            context.rotate(Math.PI / 4);
            context.fillStyle = '#e7bb66';
            context.fillRect(-7, -7, 14, 14);
            context.restore();
            context.fillStyle = 'rgba(255,255,255,.55)';
            context.beginPath();
            context.arc(x, petal.y - 8, 2, 0, Math.PI * 2);
            context.fill();
        });

        relics.forEach((relic) => {
            if (relic.collected) return;
            const x = relic.x - offset;
            if (x < -24 || x > canvasWidth + 24) return;
            const y = relic.y + Math.sin(elapsed * 4 + relic.x) * 4;
            context.save();
            context.shadowColor = levelData().collectible.color;
            context.shadowBlur = 13;
            context.fillStyle = 'rgba(255,255,255,.8)';
            context.beginPath();
            context.arc(x, y, 13, 0, Math.PI * 2);
            context.fill();
            context.shadowBlur = 0;
            context.fillStyle = levelData().collectible.color;
            context.font = '20px serif';
            context.textAlign = 'center';
            context.textBaseline = 'middle';
            context.fillText(levelData().collectible.symbol, x, y);
            context.restore();
        });

        charges.forEach((charge) => {
            if (charge.collected) return;
            const x = charge.x - offset;
            context.fillStyle = '#f3d98d';
            context.beginPath();
            context.arc(x, charge.y + Math.sin(elapsed * 4 + charge.x) * 3, 8, 0, Math.PI * 2);
            context.fill();
            context.strokeStyle = 'rgba(255,245,203,.65)';
            context.lineWidth = 2;
            context.stroke();
        });

        checkpoints.forEach((checkpoint) => {
            const x = checkpoint.x - offset;
            if (x < -20 || x > canvasWidth + 20) return;
            context.fillStyle = '#806b72';
            context.fillRect(x, 286, 4, 74);
            context.fillStyle = checkpoint.active ? '#e3c477' : '#c99da0';
            context.beginPath();
            context.moveTo(x + 4, 288);
            context.lineTo(x + 37, 300);
            context.lineTo(x + 4, 312);
            context.closePath();
            context.fill();
        });

        enemies.forEach((enemy) => {
            if (enemy.defeated) return;
            const x = enemy.x - offset;
            if (x < -40 || x > canvasWidth + 40) return;
            context.globalAlpha = enemy.stunned > 0 ? 0.48 : 1;
            const bob = Math.sin(elapsed * 6 + enemy.id) * 2;
            const verticalOffset = enemyVerticalOffset(enemy);
            const enemyFloor = enemy.floor + verticalOffset;
            if (enemy.kind === 'bat') {
                context.fillStyle = '#65556d';
                context.beginPath();
                context.moveTo(x - 19, enemyFloor - 14 + bob);
                context.lineTo(x - 9, enemyFloor - 23 + bob);
                context.lineTo(x, enemyFloor - 14 + bob);
                context.lineTo(x + 9, enemyFloor - 23 + bob);
                context.lineTo(x + 19, enemyFloor - 14 + bob);
                context.quadraticCurveTo(x, enemyFloor + bob, x - 19, enemyFloor - 14 + bob);
                context.fill();
            } else if (enemy.kind === 'wisp') {
                context.fillStyle = '#91a6b7';
                context.beginPath();
                context.arc(x, enemyFloor - 15 + bob, 15, 0, Math.PI * 2);
                context.fill();
                context.fillStyle = 'rgba(219,236,247,.55)';
                context.beginPath();
                context.arc(x, enemyFloor - 15 + bob, 21, 0, Math.PI * 2);
                context.fill();
            } else {
                context.fillStyle = '#68566e';
                context.beginPath();
                context.ellipse(x, enemyFloor - 12, 19, 13 + bob, 0, Math.PI, Math.PI * 2);
                context.fill();
            }
            context.fillStyle = '#fff0cb';
            context.beginPath();
            context.arc(x - 6, enemyFloor - 15 + bob, 2.4, 0, Math.PI * 2);
            context.arc(x + 5, enemyFloor - 15 + bob, 2.4, 0, Math.PI * 2);
            context.fill();
            context.globalAlpha = 1;
        });

        const goalX = levelData().worldWidth - 70 - offset;
        context.strokeStyle = player.petals >= levelData().requiredPetals ? '#d6b36e' : '#a58c88';
        context.lineWidth = 8;
        context.beginPath();
        context.moveTo(goalX - 20, 360);
        context.lineTo(goalX - 20, 295);
        context.quadraticCurveTo(goalX - 20, 267, goalX + 8, 267);
        context.quadraticCurveTo(goalX + 36, 267, goalX + 36, 295);
        context.lineTo(goalX + 36, 360);
        context.stroke();
        context.fillStyle = '#fff8ed';
        context.font = '13px sans-serif';
        context.textAlign = 'center';
        context.fillText(player.petals >= levelData().requiredPetals ? 'SALIDA' : `${levelData().requiredPetals - player.petals} PÉTALOS`, goalX + 8, 250);
        drawVisualParticles();
        drawPlayer();
        if (paused) {
            context.fillStyle = 'rgba(54, 43, 51, .48)';
            context.fillRect(0, 0, canvasWidth, canvasHeight);
            context.fillStyle = '#fff8ed';
            context.textAlign = 'center';
            context.font = '600 30px sans-serif';
            context.fillText('Aventura en pausa', canvasWidth / 2, canvasHeight / 2);
            context.font = '16px sans-serif';
            context.fillText('Pulsa P o Reanudar para continuar', canvasWidth / 2, canvasHeight / 2 + 32);
        }
        context.restore();
    };

    const overlaps = (a, b) => a.x < b.x + b.width && a.x + a.width > b.x
        && a.y < b.y + b.height && a.y + a.height > b.y;

    function respawn(message) {
        player.lives -= 1;
        if (player.lives <= 0) {
            restartCurrentLevel(`Sultana se quedó sin corazones. El nivel ${currentLevel + 1} vuelve a empezar desde el inicio.`);
            return;
        }
        announce(message);
        const checkpoint = checkpoints[activeCheckpoint];
        player.x = checkpoint ? checkpoint.x + 20 : 70;
        player.y = 360 - playerSize.height;
        player.vx = 0;
        player.vy = 0;
        player.jumps = 0;
        player.grounded = true;
        player.invulnerable = 1.5;
        setHud();
    };

    function setPaused(value) {
        if (paused === value) return;
        paused = value;
        if (paused) stopControls();
        pauseButton.textContent = paused ? 'Reanudar' : 'Pausar';
        pauseButton.setAttribute('aria-pressed', String(paused));
        announce(paused ? 'Aventura en pausa. El nivel y el progreso se conservaron.' : 'Partida reanudada.');
        draw();
    };

    function collectObjects() {
        const playerBox = { x: player.x, y: player.y, width: playerSize.width, height: playerSize.height };
        petals.forEach((petal) => {
            if (!petal.collected && overlaps(playerBox, { x: petal.x - 10, y: petal.y - 10, width: 20, height: 20 })) {
                
                petal.collected = true;
                for (let k = 0; k < 8; k++) {
                    spawnParticle(petal.x, petal.y, (Math.random() - 0.5) * 80, (Math.random() - 0.5) * 80, '#fde382', 3, 0.6, 'star');
                }

                player.petals += 1;
                addScore(100);
                setHud();
            }
        });
        charges.forEach((charge) => {
            if (!charge.collected && overlaps(playerBox, { x: charge.x - 11, y: charge.y - 11, width: 22, height: 22 })) {
                charge.collected = true;
                player.light += 1;
                announce('Recogiste un destello. Pulsa E o Acción para ahuyentar una sombra cercana.');
                setHud();
            }
        });
        relics.forEach((relic) => {
            if (relic.collected || !overlaps(playerBox, { x: relic.x - 12, y: relic.y - 12, width: 24, height: 24 })) return;
            
            relic.collected = true;
            for (let k = 0; k < 12; k++) {
                spawnParticle(relic.x, relic.y, (Math.random() - 0.5) * 110, (Math.random() - 0.5) * 110, levelData().collectible.color, 3.5, 0.8, 'petal');
            }

            player.relics += 1;
            addScore(250);
            if (player.lives < 3) player.lives += 1;
            else if (currentLevel >= 2) player.light += 1;
            announce(`¡Encontraste ${levelData().collectible.name}! ${player.relics} de ${levelData().collectible.positions.length} recogidos.`);
            setHud();
        });
    };

    function update(delta) {
        if (gameComplete) {
            if (!paused && currentLevel < levels.length - 1) {
                nextLevelDelay -= delta;
                if (nextLevelDelay <= 0) {
                    startLevel(currentLevel + 1, { automatic: true, preserveRunScore: true, preserveCampaign: true });
                }
            }
            return;
        }
        elapsed += delta;

        if (Math.random() < 0.25) {
            const letter = loveLetters[currentLevel] || loveLetters[0];
            const eff = letter.envEffect || 'stars';
            const spawnX = cameraX + Math.random() * canvasWidth;
            const spawnY = Math.random() * (canvasHeight - 60);
            if (eff === 'fireflies') {
                spawnParticle(spawnX, spawnY, (Math.random() - 0.5) * 20, (Math.random() - 0.5) * 20, '#fff494', 2.2, 2.5, 'star');
            } else if (eff === 'clouds') {
                spawnParticle(spawnX, 10, (Math.random() - 0.3) * 35, 20 + Math.random() * 25, '#d8f3dc', 2.8, 4.0, 'petal');
            } else if (eff === 'crystals') {
                spawnParticle(spawnX, spawnY, (Math.random() - 0.5) * 15, -15 - Math.random() * 20, '#b2f0e8', 2.5, 2.0, 'star');
            } else if (eff === 'dawn') {
                spawnParticle(spawnX, spawnY, (Math.random() - 0.5) * 25, -20, '#f9cf86', 3.0, 2.2, 'star');
            } else {
                spawnParticle(spawnX, 0, (Math.random() - 0.5) * 30, 40 + Math.random() * 30, '#ffe8a3', 2.5, 3.5, 'star');
            }
        }

        player.invulnerable = Math.max(0, player.invulnerable - delta);
        player.pulse = Math.max(0, player.pulse - delta);
        gateMessageCooldown = Math.max(0, gateMessageCooldown - delta);
        enemies.forEach((enemy) => {
            if (enemy.defeated) return;
            if (enemy.stunned > 0) {
                enemy.stunned = Math.max(0, enemy.stunned - delta);
                return;
            }
            if (enemy.kind === 'wisp') {
                enemy.dashCooldown = Math.max(0, enemy.dashCooldown - delta);
                if (enemy.dashTime <= 0 && enemy.dashCooldown === 0 && Math.abs(player.x - enemy.x) < 260) {
                    enemy.dashTime = 0.42;
                    enemy.dashCooldown = 2.8;
                    enemy.dashDirection = Math.sign(player.x - enemy.x) || 1;
                }
                if (enemy.dashTime > 0) {
                    enemy.dashTime = Math.max(0, enemy.dashTime - delta);
                    enemy.x += enemy.dashDirection * Math.abs(enemy.speed) * 2.1 * delta;
                } else {
                    enemy.x += enemy.speed * delta;
                }
            } else {
                enemy.x += enemy.speed * delta;
            }
            if (enemy.x < enemy.left || enemy.x > enemy.right) {
                enemy.x = Math.min(Math.max(enemy.x, enemy.left), enemy.right);
                enemy.speed *= -1;
                enemy.dashDirection *= -1;
            }
        });

        const left = keys.has('a') || keys.has('arrowleft') || touch.has('left');
        const right = keys.has('d') || keys.has('arrowright') || touch.has('right');
        player.vx = (Number(right) - Number(left)) * 245;
        if (left) player.facing = -1;
        if (right) player.facing = 1;

        const jumpPressed = keys.has(' ') || keys.has('w') || keys.has('arrowup') || touch.has('jump');
        if (jumpPressed && !player.jumpHeld) {
            const jumpLimit = currentLevel >= 1 ? 2 : 1;
            if (player.jumps < jumpLimit) {
                
                const diff = difficultyPresets[currentDifficulty] || difficultyPresets.adventure;
                player.vy = (player.jumps ? -455 : -540) * diff.jumpBoost;
                for (let k = 0; k < 6; k++) {
                    spawnParticle(player.x + 15, player.y + 44, (Math.random() - 0.5) * 60, Math.random() * -40, '#ffd89f', 2.5, 0.45, 'star');
                }

                player.jumps += 1;
                player.grounded = false;
            }
        }
        player.jumpHeld = jumpPressed;

        const previousBottom = player.y + playerSize.height;
        player.vy = Math.min(player.vy + 1450 * delta, 850);
        player.x = Math.max(0, Math.min(levelData().worldWidth - playerSize.width, player.x + player.vx * delta));
        player.y += player.vy * delta;
        let landed = false;
        worldPlatforms().forEach((platform) => {
            const horizontalOverlap = player.x + playerSize.width > platform.x && player.x < platform.x + platform.width;
            if (horizontalOverlap && player.vy >= 0 && previousBottom <= platform.y && player.y + playerSize.height >= platform.y) {
                player.y = platform.y - playerSize.height;
                player.vy = 0;
                player.jumps = 0;
                landed = true;
            }
        });
        player.grounded = landed;

        checkpoints.forEach((checkpoint, index) => {
            if (!checkpoint.active && player.x >= checkpoint.x) {
                checkpoint.active = true;
                activeCheckpoint = index;
                announce('Punto de control activado. Si caes, continuarás desde aquí.');
            }
        });

        collectObjects();
        if (player.invulnerable === 0) {
            const playerBox = { x: player.x + 4, y: player.y + 4, width: playerSize.width - 8, height: playerSize.height - 4 };
            let hitHazard = false;
            for (const [x, y, width, height] of levelData().hazards) {
                if (overlaps(playerBox, { x, y, width, height })) {
                    respawn('¡Cuidado con las zarzas! Perdiste un corazón y vuelves al punto de control.');
                    hitHazard = true;
                    break;
                }
            }
            for (const enemy of hitHazard ? [] : enemies) {
                if (enemy.defeated || enemy.stunned > 0) continue;
                const enemyBox = enemyCollisionBox(enemy);
                if (!overlaps(playerBox, enemyBox)) continue;
                if (player.vy > 80 && previousBottom <= enemyBox.y + 8) {
                    enemy.defeated = true;
                    addScore(150);
                    player.vy = -370;
                    player.jumps = 0;
                    setHud();
                    announce(enemy.kind === 'bat'
                        ? '¡Buen salto! El murciélago emprendió el vuelo.'
                        : enemy.kind === 'wisp'
                            ? '¡Buen salto! El espíritu se disipó entre destellos.'
                            : '¡Buen salto! La sombra se retiró.');
                } else {
                    respawn('Una sombra te alcanzó. Intenta saltarla y conserva tus corazones.');
                }
                break;
            }
        }
        if (player.y > canvasHeight + 110 && player.invulnerable === 0) {
            respawn('Sultana cayó del sendero. Regresa al último punto de control.');
        }

        const goalX = levelData().worldWidth - 70;
        if (player.x + playerSize.width >= goalX && player.petals >= levelData().requiredPetals && !gameComplete) {
            gameComplete = true;
            addScore(500 + player.lives * 100);
            progress.bestLevelScores[currentLevel] = Math.max(progress.bestLevelScores[currentLevel], levelScore);
            const nextUnlocked = Math.min(levels.length, currentLevel + 2);
            progress.unlockedLevel = Math.max(progress.unlockedLevel, nextUnlocked);
            const completedCampaign = currentLevel === levels.length - 1 && campaignAttempt;
            if (completedCampaign) {
                progress.completed = true;
                progress.bestScore = Math.max(progress.bestScore, runScore);
            }
            const progressSaved = saveProgress();
            updateLevelOptions();
            setHud();
            stopControls();
            nextButton.hidden = false;
            const saveWarning = progressSaved ? '' : ' No se pudieron guardar el avance y los récords en este navegador.';
            if (currentLevel === levels.length - 1) {
                finalePanel.hidden = false;
                nextButton.textContent = 'Jugar de nuevo desde el inicio';
                announce(completedCampaign
                    ? "¡Felicidades mi Carla Lorena! Devolviste la luz a los " + levels.length + " rincones de Sultana. Adrián celebra tu victoria." + saveWarning
                    : "¡Hermoso nivel superado, Carla Lorena! Preparando el siguiente rincón para ti..." + saveWarning);
                window.requestAnimationFrame(() => {
                    finalePanel.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    finaleTitle.focus({ preventScroll: true });
                });
            } else {
                nextLevelDelay = 2.5;
                nextButton.textContent = `Pasar al nivel ${currentLevel + 2} ahora`;
                announce(`¡Nivel ${currentLevel + 1} superado! El nivel ${currentLevel + 2} comenzará automáticamente en un momento.${saveWarning}`);
            }
        } else if (player.x + playerSize.width >= goalX && player.petals < levelData().requiredPetals && gateMessageCooldown === 0) {
            gateMessageCooldown = 2;
            announce(`El arco está cerrado. Aún necesitas ${levelData().requiredPetals - player.petals} pétalos.`);
        }

        cameraX = Math.max(0, Math.min(levelData().worldWidth - canvasWidth, player.x - canvasWidth * 0.35));
        draw();
    };

    function pulseLight() {
        if (paused) return;
        if (currentLevel < 2 || player.light < 1) {
            announce(currentLevel < 2 ? 'El destello protector se desbloquea en el nivel 3.' : 'Recoge un destello antes de usar la acción.');
            return;
        }
        player.light -= 1;
        player.pulse = 0.35;
        enemies.forEach((enemy) => {
            if (!enemy.defeated && Math.abs(enemy.x - player.x) < 125) enemy.stunned = 3;
        });
        announce('¡Destello protector! Las sombras cercanas quedaron aturdidas por unos segundos.');
        setHud();
    };

    function setTouch(button, pressed) {
        const action = button.dataset.platformerControl;
        if (action === 'action') {
            if (pressed) pulseLight();
            return;
        }
        if (pressed) touch.add(action);
        else touch.delete(action);
        button.setAttribute('aria-pressed', String(pressed));
    };

function loop(now) {
        if (screen.hidden || document.hidden) {
            frameId = 0;
            lastTime = 0;
            return;
        }
        const delta = lastTime ? Math.min((now - lastTime) / 1000, 0.04) : 1 / 60;
        lastTime = now;
        updateVisualParticles(delta);
        update(delta);
        frameId = window.requestAnimationFrame(loop);
    };

    function resume() {
        if (!screen.hidden && !document.hidden && !frameId) frameId = window.requestAnimationFrame(loop);
    };

    window.addEventListener('keydown', (event) => {
        if (screen.hidden || event.target instanceof HTMLInputElement || event.target instanceof HTMLSelectElement) return;
        const key = event.key.toLowerCase();
        if (key === 'p' && !event.repeat) {
            setPaused(!paused);
            return;
        }
        if (paused) return;
        if (['arrowleft', 'arrowright', 'arrowup', ' ', 'a', 'd', 'w'].includes(key)) {
            event.preventDefault();
            keys.add(key);
        }
        if ((key === 'e' || key === 'x') && !event.repeat) pulseLight();
    });
    window.addEventListener('keyup', (event) => {
        keys.delete(event.key.toLowerCase());
        if (event.key === ' ' || event.key.toLowerCase() === 'w' || event.key === 'ArrowUp') player.jumpHeld = false;
    });
    window.addEventListener('blur', stopControls);
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopControls();
        else resume();
    });
    screen.querySelectorAll('[data-platformer-control]').forEach((button) => {
        button.addEventListener('pointerdown', (event) => {
            event.preventDefault();
            setTouch(button, true);
            button.setPointerCapture(event.pointerId);
        });
        const release = () => setTouch(button, false);
        button.addEventListener('pointerup', release);
        button.addEventListener('pointercancel', release);
        button.addEventListener('lostpointercapture', release);
    });
    levelSelect.addEventListener('change', () => startLevel(Number(levelSelect.value)));

    if (difficultySelect) {
        difficultySelect.value = currentDifficulty;
        difficultySelect.addEventListener('change', () => {
            currentDifficulty = difficultySelect.value;
            restartCurrentLevel("Dificultad cambiada a " + difficultyPresets[currentDifficulty].name + ".");
        });
    }
    if (scrollButton) scrollButton.addEventListener('click', openLetterModal);
    if (readLetterBtn) readLetterBtn.addEventListener('click', openLetterModal);
    if (modalClose) modalClose.addEventListener('click', closeLetterModal);
    if (modalConfirm) modalConfirm.addEventListener('click', closeLetterModal);

    restartButton.addEventListener('click', () => restartCurrentLevel());
    pauseButton.addEventListener('click', () => setPaused(!paused));
    nextButton.addEventListener('click', () => {
        if (!gameComplete) return;
        const replay = currentLevel === levels.length - 1;
        startLevel(replay ? 0 : currentLevel + 1, {
            automatic: !replay,
            preserveRunScore: !replay,
            preserveCampaign: !replay,
        });
    });
    replayButton.addEventListener('click', () => startLevel(0));
    screen.querySelector('[data-platformer-clear]').addEventListener('click', () => {
        progress = {
            version: 2,
            unlockedLevel: 1,
            completed: false,
            bestScore: 0,
            bestLevelScores: Array(levels.length).fill(0),
        };
        const progressSaved = saveProgress();
        updateLevelOptions();
        startLevel(0);
        announce(progressSaved
            ? 'Avance y récords reiniciados. Empieza de nuevo en el primer nivel.'
            : 'Avance y récords reiniciados solo para esta sesión; no se pudieron guardar los cambios en este navegador.');
    });
    const resizeObserver = new ResizeObserver(resize);
    resizeObserver.observe(canvas);
    window.addEventListener('resize', resize);
    new MutationObserver(() => {
        if (screen.hidden) {
            window.cancelAnimationFrame(frameId);
            frameId = 0;
            stopControls();
        } else {
            resume();
        }
    }).observe(screen, { attributes: true, attributeFilter: ['hidden'] });

    updateLevelOptions();
    startLevel(currentLevel, { resumed: currentLevel > 0 });
    resize();
    resume();
}
