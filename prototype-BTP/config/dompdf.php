<?php

return array(

    'show_warnings' => false,   // Throw an Exception on warnings from dompdf
    'orientation' => 'portrait',
    'defines' => [
        // Change this if you have constant problems with DOMPDF and PHP configurations
        __DIR__ . '/../../../dompdf/dompdf_config.inc.php',
    ],
    'font_dir' => storage_path('fonts'), // recommended by dompdf (https://github.com/dompdf/dompdf)
    'font_cache' => storage_path('fonts'),
    'temp_dir' => storage_path('app/temp'),
    'chroot' => base_path(),
    'log_output_file' => storage_path('logs/dompdf.html'),
    'default_media_type' => 'screen',
    'default_paper_size' => 'a4',
    'default_font' => 'serif',
    'dpi' => 96,
    'enable_php' => false,
    'enable_remote' => true,
    'enable_css_float' => true,
    'enable_javascript' => true,
    'font_height_ratio' => 1.1,
    'is_html5_parser_enabled' => true,
    'is_font_subsetting_enabled' => false,
    'debug_png' => false,
    'debug_keep_temp' => false,
    'debug_css' => false,
    'debug_layout' => false,
    'debug_layout_lines' => true,
    'debug_layout_blocks' => true,
    'debug_layout_inline' => true,
    'debug_layout_padding_box' => true,

);
