<?php

return [
    'quiz' => [
        'rate_limit_attempts' => 10,
        'rate_limit_window' => 1,
        'questions_required' => 10,
    ],
    'upload' => [
        'max_size_mb' => 100,
        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'webp'],
        'allowed_video_types' => ['mp4', 'webm', 'mov'],
        'allowed_audio_types' => ['mp3', 'm4a', 'wav', 'ogg'],
    ],
];