<?php
if (!defined('PHP_MUSIC_FRONT_CONTROLLER')) {
  http_response_code(404);
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $og_title; ?></title>
    
    <!-- Primary Meta Tags -->
    <meta name="title" content="<?php echo $og_title; ?>">
    <meta name="description" content="<?php echo $og_desc; ?>">
    <meta name="keywords" content="music, player, php, streaming, audio, webapp">
    <meta name="author" content="PHP Music">
    <meta name="theme-color" content="#0a0a0a">
    <meta name="application-name" content="PHP Music">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PHP Music">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:site_name" content="PHP Music">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $current_url; ?>">
    <meta property="og:title" content="<?php echo $og_title; ?>">
    <meta property="og:description" content="<?php echo $og_desc; ?>">
    <meta property="og:image" content="<?php echo $og_image; ?>">
    <meta property="og:image:secure_url" content="<?php echo $og_image; ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo $og_title; ?> - PHP Music">

    <!-- Twitter / Discord / Telegram -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:domain" content="<?php echo $domainName; ?>">
    <meta name="twitter:url" content="<?php echo $current_url; ?>">
    <meta name="twitter:title" content="<?php echo $og_title; ?>">
    <meta name="twitter:description" content="<?php echo $og_desc; ?>">
    <meta name="twitter:image" content="<?php echo $og_image; ?>">
    <meta name="twitter:image:alt" content="<?php echo $og_title; ?> - PHP Music">

    <link rel="icon" type="image/svg+xml" href="?action=get_app_icon" />
    <link rel="manifest" href="?pwa=manifest" crossorigin="use-credentials">
    <?php require __DIR__ . '/head-script.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/diff_match_patch/20121119/diff_match_patch.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@multiavatar/multiavatar/multiavatar.min.js"></script>
    <!-- External Language Support Library for multi-language transliteration -->
    <script src="https://cdn.jsdelivr.net/npm/transliteration@2.3.5/dist/browser/bundle.umd.min.js"></script>
    <!-- Confetti Library -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mermaid@10.6.1/dist/mermaid.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@3.6.1/dist/svg-pan-zoom.min.js"></script>
    <?php echo $initialViewJS; ?>
    <link rel="stylesheet" href="assets/css/app.css?v=<?php echo rawurlencode(APP_VERSION); ?>">
  </head>
  <body class="logged-out">
    <div class="app-container">
      <nav class="sidebar offcanvas-md offcanvas-start" tabindex="-1" id="main-nav-offcanvas">
        <div class="offcanvas-header">
          <div class="logo d-none">PHP<span>Music</span></div>
        </div>
        <div class="offcanvas-body d-flex flex-column">
          <div class="d-none d-md-flex align-items-center justify-content-between px-4 pt-4 pb-2 mb-2">
            <div class="logo m-0 p-0">PHP<span>Music</span></div>
            <button class="btn text-secondary p-0" id="main-desktop-sidebar-toggle" title="Toggle Sidebar">
              <i class="bi bi-layout-sidebar fs-4"></i>
            </button>
          </div>
          
          <h6 class="text-uppercase text-secondary fw-bold mx-3 mt-3 mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">Discover</h6>
          <a href="#" class="nav-link active" data-view="get_songs">
            <i class="bi bi-music-note-list"></i>
            <span>All Songs</span>
          </a>
          <a href="#" class="nav-link" data-view="get_albums">
            <i class="bi bi-disc-fill"></i>
            <span>Albums</span>
          </a>
          <a href="#" class="nav-link" data-view="get_artists">
            <i class="bi bi-people-fill"></i>
            <span>Artists</span>
          </a>
          <a href="#" class="nav-link" data-view="get_mixes">
            <i class="bi bi-collection-play-fill"></i>
            <span>Mixes</span>
          </a>
          <a href="#" class="nav-link" id="nav-random-play">
            <i class="bi bi-shuffle"></i>
            <span>Play Random</span>
          </a>
          <a href="#" class="nav-link" data-view="get_genres">
            <i class="bi bi-tags-fill"></i>
            <span>Genres</span>
          </a>
          <a href="#" class="nav-link" data-view="get_years">
            <i class="bi bi-calendar-event-fill"></i>
            <span>Years</span>
          </a>
          <a href="#" class="nav-link" data-view="get_trending">
            <i class="bi bi-graph-up-arrow"></i>
            <span>Top 100 Trending</span>
          </a>
          <a href="#" class="nav-link" data-view="phpboard_index">
            <i class="bi bi-chat-square-text-fill"></i>
            <span>Imageboard</span>
          </a>

          <hr class="text-secondary">
          
          <div class="logged-in-only">
            <h6 class="text-uppercase text-secondary fw-bold mx-3 mt-2 mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">Library & Social</h6>
            <a href="#" class="nav-link" data-view="get_recommendations">
              <i class="bi bi-magic"></i>
              <span>For You</span>
            </a>
            <a href="#" class="nav-link" data-view="user_profile">
              <i class="bi bi-person-fill"></i>
              <span>My Profile</span>
            </a>
            <a href="#" class="nav-link" data-view="get_history">
              <i class="bi bi-clock-history"></i>
              <span>History</span>
            </a>
            <a href="#" class="nav-link" data-view="get_favorites">
              <i class="bi bi-heart-fill"></i>
              <span>Favorites</span>
            </a>
            <a href="#" class="nav-link" data-view="get_user_playlists">
              <i class="bi bi-music-note-beamed"></i>
              <span>Playlists</span>
            </a>
            <a href="#" class="nav-link" data-view="get_collab_playlists">
              <i class="bi bi-people-fill"></i>
              <span>Shared With Me</span>
            </a>
            <a href="#" class="nav-link" data-view="get_offline_songs">
              <i class="bi bi-cloud-arrow-down-fill"></i>
              <span>Offline Library</span>
            </a>
            <a href="#" class="nav-link" data-view="rhythm_game">
              <i class="bi bi-controller"></i>
              <span>Rhythm Game</span>
            </a>
            <a href="#" class="nav-link" data-view="get_following">
              <i class="bi bi-person-lines-fill"></i>
              <span>Following</span>
            </a>
            <a href="#" class="nav-link" data-view="get_listen_later">
              <i class="bi bi-clock-fill"></i>
              <span>Listen Later</span>
            </a>
            <a href="#" class="nav-link" data-view="get_community">
              <i class="bi bi-people"></i>
              <span>Community</span>
            </a>
            <a href="#" class="nav-link" data-view="get_inbox">
              <i class="bi bi-chat-dots-fill"></i>
              <span>Messages</span>
              <span class="badge bg-danger rounded-pill d-none ms-auto inbox-badge">0</span>
            </a>
            <a href="#" class="nav-link" data-view="audio_editor">
              <i class="bi bi-music-note-list"></i>
              <span>PHPAudio</span>
            </a>
            <a href="#imageditorSubmenu" data-bs-toggle="collapse" class="nav-link collapsed">
              <i class="bi bi-image" style="font-size:1.25rem;width:24px;text-align:center;"></i>
              <span>ImagEditor</span>
              <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem; transition: transform 0.2s;"></i>
            </a>
            <div class="collapse" id="imageditorSubmenu">
              <ul class="list-unstyled ms-4 mb-0 pb-2">
                <li><a href="#" class="nav-link py-2 ps-3 border-0 imageditor-filter-link" data-view="get_imageditor_projects" data-filter="all"><i class="bi bi-folder2"></i> All Designs</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 imageditor-filter-link" data-view="get_imageditor_projects" data-filter="starred"><i class="bi bi-star"></i> Starred</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 cat-nav-link" data-view="get_categories" data-cat-type="imageditor"><i class="bi bi-grid-fill"></i> View Categories</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 cat-nav-link" data-view="manage_note_categories" data-cat-type="imageditor"><i class="bi bi-tags"></i> Edit Categories</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 filter-nav-link" data-view="get_projects" data-filter="imageditor"><i class="bi bi-briefcase-fill text-danger"></i> Design Projects</a></li>
              </ul>
            </div>
            <a href="#artsSubmenu" data-bs-toggle="collapse" class="nav-link collapsed">
              <i class="bi bi-images" style="font-size:1.25rem;width:24px;text-align:center;"></i>
              <span>PHPShares</span>
              <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem; transition: transform 0.2s;"></i>
            </a>
            <div class="collapse" id="artsSubmenu">
              <ul class="list-unstyled ms-4 mb-0 pb-2">
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-filter-link" data-view="get_arts" data-filter="all"><i class="bi bi-asterisk"></i> All Artworks</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-filter-link" data-view="get_arts" data-filter="image"><i class="bi bi-image"></i> Illustrations</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-filter-link" data-view="get_arts" data-filter="manga"><i class="bi bi-book"></i> Manga / Comics</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-filter-link" data-view="get_arts" data-filter="my_favorites"><i class="bi bi-heart-fill text-danger"></i> Favorites</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-profile-link" onclick="if(currentUser) { loadView({type: 'user_profile', param: currentUser.artist, sort: 'id_desc', filter_user_id: currentUser.id, open_tab: 'arts'}); } else { showToast('Please login', 'error'); }"><i class="bi bi-person text-success"></i> My Artworks</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" data-view="upload_art_page"><i class="bi bi-upload text-info"></i> Upload Artwork</a></li>
                <li><hr class="dropdown-divider border-secondary opacity-50 my-1"></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-meta-link" data-view="arts_meta" data-meta="tags"><i class="bi bi-tags"></i> Tags</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-meta-link" data-view="arts_meta" data-meta="characters"><i class="bi bi-person-hearts"></i> Characters</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-meta-link" data-view="arts_meta" data-meta="parodies"><i class="bi bi-controller"></i> Parodies</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-meta-link" data-view="arts_meta" data-meta="groups_name"><i class="bi bi-people"></i> Groups</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 arts-meta-link" data-view="arts_meta" data-meta="series"><i class="bi bi-collection"></i> Series</a></li>
              </ul>
            </div>
            <a href="#blogsSubmenu" data-bs-toggle="collapse" class="nav-link collapsed">
              <i class="bi bi-journal-richtext" style="font-size:1.25rem;width:24px;text-align:center;"></i>
              <span>My Blogs</span>
              <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem; transition: transform 0.2s;"></i>
            </a>
            <div class="collapse" id="blogsSubmenu">
              <ul class="list-unstyled ms-4 mb-0 pb-2">
                <li><a href="#" class="nav-link py-2 ps-3 border-0 blog-filter-link" data-view="get_blogs" data-filter="all"><i class="bi bi-folder2"></i> All Blogs</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 blog-filter-link" data-view="get_blogs" data-filter="public"><i class="bi bi-globe"></i> Published</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 blog-filter-link" data-view="get_blogs" data-filter="private"><i class="bi bi-lock"></i> Drafts</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 cat-nav-link" data-view="get_categories" data-cat-type="blog"><i class="bi bi-grid-fill"></i> View Blog Categories</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 cat-nav-link" data-view="manage_note_categories" data-cat-type="blog"><i class="bi bi-tags"></i> Edit Blog Categories</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 filter-nav-link" data-view="get_projects" data-filter="blog"><i class="bi bi-briefcase-fill text-danger"></i> Blog Projects</a></li>
                <li><hr class="dropdown-divider border-secondary opacity-50 my-1"></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" id="import-txt-btn-blogs"><i class="bi bi-file-earmark-text"></i> Upload TXT</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" id="import-json-btn-blogs"><i class="bi bi-filetype-json"></i> Import JSON</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" id="export-json-blogs-menu"><i class="bi bi-download"></i> Export JSON</a></li>
              </ul>
            </div>
            <a href="#notesSubmenu" data-bs-toggle="collapse" class="nav-link collapsed">
              <i class="bi bi-journal-album" style="font-size:1.25rem;width:24px;text-align:center;"></i>
              <span>Personal Notes</span>
              <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem; transition: transform 0.2s;"></i>
            </a>
            <div class="collapse" id="notesSubmenu">
              <ul class="list-unstyled ms-4 mb-0 pb-2">
                <li><a href="#" class="nav-link py-2 ps-3 border-0 note-filter-link" data-view="get_notes" data-filter="all"><i class="bi bi-folder2"></i> All Notes</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 note-filter-link" data-view="get_notes" data-filter="starred"><i class="bi bi-star"></i> Starred</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 cat-nav-link" data-view="get_categories" data-cat-type="note"><i class="bi bi-grid-fill"></i> View All Note Categories</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 cat-nav-link" data-view="manage_note_categories" data-cat-type="note"><i class="bi bi-tags"></i> Edit Note Categories</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 filter-nav-link" data-view="get_projects" data-filter="note"><i class="bi bi-briefcase-fill text-danger"></i> Note Projects</a></li>
                <li><hr class="dropdown-divider border-secondary opacity-50 my-1"></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" id="import-txt-btn-menu"><i class="bi bi-file-earmark-text"></i> Upload TXT</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" id="import-json-btn-menu"><i class="bi bi-filetype-json"></i> Import JSON</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" id="export-json-notes-menu"><i class="bi bi-download"></i> Export JSON</a></li>
              </ul>
            </div>
            
            <a href="#tasksSubmenu" data-bs-toggle="collapse" class="nav-link collapsed">
              <i class="bi bi-check2-square" style="font-size:1.25rem;width:24px;text-align:center;"></i>
              <span>Tasks</span>
              <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem; transition: transform 0.2s;"></i>
            </a>
            <div class="collapse" id="tasksSubmenu">
              <ul class="list-unstyled ms-4 mb-0 pb-2">
                <li><a href="#" class="nav-link py-2 ps-3 border-0 task-filter-link" data-view="get_tasks" data-filter="all"><i class="bi bi-ui-checks"></i> All Tasks</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 task-filter-link" data-view="get_tasks" data-filter="starred"><i class="bi bi-star"></i> Starred Tasks</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 cat-nav-link" data-view="get_categories" data-cat-type="task"><i class="bi bi-grid-fill"></i> View All Task Categories</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 cat-nav-link" data-view="manage_note_categories" data-cat-type="task"><i class="bi bi-tags"></i> Edit Task Categories</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0 filter-nav-link" data-view="get_projects" data-filter="task"><i class="bi bi-briefcase-fill text-danger"></i> Task Projects</a></li>
                <li><hr class="dropdown-divider border-secondary opacity-50 my-1"></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" id="import-json-btn-tasks"><i class="bi bi-filetype-json"></i> Import Tasks</a></li>
                <li><a href="#" class="nav-link py-2 ps-3 border-0" id="export-json-tasks-menu"><i class="bi bi-download"></i> Export Tasks</a></li>
              </ul>
            </div>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#calendar-modal">
              <i class="bi bi-calendar3"></i>
              <span>Calendar</span>
            </a>
          </div>
          
          <div class="logged-out-only">
            <h6 class="text-uppercase text-secondary fw-bold mx-3 mt-2 mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">Account</h6>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#login-modal">
              <i class="bi bi-box-arrow-in-right"></i>
              <span>Login</span>
            </a>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#register-modal">
              <i class="bi bi-person-plus-fill"></i>
              <span>Register</span>
            </a>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#restore-modal">
              <i class="bi bi-key-fill"></i>
              <span>Restore Account</span>
            </a>
          </div>
          
          <div class="mt-auto">
            <hr class="text-secondary">
            <h6 class="text-uppercase text-secondary fw-bold mx-3 mt-2 mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">Utility & Tools</h6>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#console-modal">
              <i class="bi bi-terminal-fill"></i>
              <span>Console Logs</span>
            </a>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#how-to-use-modal">
              <i class="bi bi-question-circle-fill"></i>
              <span>How To Use</span>
            </a>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#shortcuts-modal">
              <i class="bi bi-keyboard-fill"></i>
              <span>Keyboard Shortcuts</span>
            </a>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#playlist-downloader-modal">
              <i class="bi bi-cloud-arrow-down-fill"></i>
              <span>Downloader</span>
            </a>
            <a href="#" class="nav-link logged-in-only" id="nav-upload-btn">
              <i class="bi bi-cloud-upload-fill"></i>
              <span>Upload Song</span>
            </a>
            <a href="#" class="nav-link" id="nav-scan-all" data-bs-toggle="modal" data-bs-target="#rescan-options-modal" style="display: none !important;">
              <i class="bi bi-hdd-stack-fill"></i>
              <span>Re-scan Library</span>
            </a>
            <a href="#" class="nav-link logged-in-only" id="nav-chart-scan" style="display: none !important;">
              <i class="bi bi-controller"></i>
              <span>Scan Charts</span>
            </a>
            <a href="#" class="nav-link logged-in-only" id="nav-chart-config" style="display: none !important;">
              <i class="bi bi-sliders"></i>
              <span>Adjust Chart Scan</span>
            </a>
            <a href="#" class="nav-link logged-in-only" id="nav-cover-scan" data-bs-toggle="modal" data-bs-target="#cover-scan-modal" style="display: none !important;">
              <i class="bi bi-image-fill"></i>
              <span>Re-scan Covers</span>
            </a>
            <a href="?access=admin" class="nav-link logged-in-only" id="nav-admin-panel" style="display: none !important;">
              <i class="bi bi-shield-lock-fill"></i>
              <span>Admin Panel</span>
            </a>
            <a href="#" class="nav-link d-none" id="install-pwa-btn">
              <i class="bi bi-cloud-arrow-down-fill"></i>
              <span>Install App</span>
            </a>
            <a href="#" class="nav-link logged-in-only" data-view="get_my_apis">
              <i class="bi bi-code-slash"></i>
              <span>My APIs</span>
            </a>
            <a href="#" class="nav-link" id="get-api-btn">
              <i class="bi bi-journal-code"></i>
              <span>API Documentation</span>
            </a>
            <a href="#playground" class="nav-link" id="playground-nav-btn">
              <i class="bi bi-window-stack"></i>
              <span>Playground</span>
            </a>
            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#license-modal">
              <i class="bi bi-file-earmark-text-fill"></i>
              <span>License</span>
            </a>
            <a href="#" class="nav-link" id="check-update-btn">
              <i class="bi bi-arrow-clockwise"></i>
              <span>Check Update</span>
            </a>
            <a href="https://github.com/HirotakaDango/PHP-Music/archive/refs/heads/main.zip" target="_blank" class="nav-link">
              <i class="bi bi-file-earmark-zip-fill"></i>
              <span>Download Source Code</span>
            </a>
            <a href="#" class="nav-link" id="clear-cache-btn">
              <i class="bi bi-eraser-fill"></i>
              <span>Clear Cache</span>
            </a>
            <a href="#" class="nav-link" id="clear-cookies-btn">
              <i class="bi bi-cookie"></i>
              <span>Clear Cookies</span>
            </a>
            <a href="#" class="nav-link" id="clear-session-btn">
              <i class="bi bi-person-fill-x"></i>
              <span>Clear Session</span>
            </a>
            <a href="#" class="nav-link" id="fullscreen-btn">
              <i class="bi bi-arrows-fullscreen"></i>
              <span>Full Screen</span>
            </a>
            <div class="text-center mt-5 mb-5 mb-md-0 small text-secondary">
              Made by <a href="https://github.com/HirotakaDango" target="_blank" class="text-decoration-none fw-bold text-white-50">HirotakaDango</a>
            </div>
          </div>
        </div>
      </nav>
      <main class="main-content" id="main-content">
        <div class="mobile-header d-md-none">
          <button class="header-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#main-nav-offcanvas" aria-controls="main-nav-offcanvas">
            <i class="bi bi-list"></i>
          </button>
          <div class="fw-bold fs-4 ms-2 me-auto" style="letter-spacing: -0.5px; z-index: 1;">PHP<span style="color: var(--ytm-accent);">Music</span></div>
          <button class="header-btn ms-auto me-2" type="button" id="mobile-search-toggle-btn" style="z-index: 1;">
            <i class="bi bi-search"></i>
          </button>
          <div class="position-absolute top-50 start-50 translate-middle w-100 px-2 d-none align-items-center" id="mobile-search-container" style="z-index: 1070; background: var(--ytm-surface); height: 100%;">
            <button class="btn border-0 text-white p-0 me-2 flex-shrink-0" type="button" id="mobile-search-back-btn" style="width: 40px; height: 40px;"><i class="bi bi-arrow-left fs-4"></i></button>
            <div class="input-group search-bar flex-grow-1 position-relative">
              <input type="text" class="form-control" id="search-input-mobile" placeholder="Search..." aria-label="Search...">
              <button class="btn" type="button" id="search-btn-mobile"><i class="bi bi-search"></i></button>
              <div id="search-dropdown-mobile" class="search-dropdown d-none" style="position: absolute; top: 100%; left: -48px; width: calc(100vw - 16px); margin-top: 12px; margin-bottom: 80px;"></div>
            </div>
          </div>
          <div class="dropdown logged-in-only position-relative" style="z-index: 1;">
            <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="profile-picture" id="profile-picture-header-mobile" alt="Profile" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-dark rounded-circle d-none notif-dot" style="z-index: 10; width: 10px; height: 10px;"></span>
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end phpmusic-profile-dropdown">
              <li>
                <div class="phpmusic-profile-header-card">
                  <div class="phpmusic-profile-bg-placeholder"></div>
                  <div class="phpmusic-profile-header-card-inner">
                    <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="phpmusic-profile-img-placeholder" alt="Profile">
                    <div class="info" style="min-width: 0; flex-grow: 1;">
                      <div class="name phpmusic-profile-name text-truncate" style="max-width: 170px;">Loading...</div>
                      <div class="meta phpmusic-profile-subtext text-truncate" style="max-width: 170px;">Loading...</div>
                    </div>
                  </div>
                </div>
              </li>
              <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#activity-modal">
                <span><i class="bi bi-bell-fill"></i> My Activity</span>
                <span class="badge bg-danger rounded-pill d-none notif-badge">0</span>
              </a></li>
              <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:void(0);" onclick="loadView({ type: 'get_inbox', param: '', sort: '', filter_user_id: '' });">
                <span><i class="bi bi-chat-dots-fill"></i> Direct Messages</span>
                <span class="badge bg-danger rounded-pill d-none inbox-badge">0</span>
              </a></li>
              <li><a class="dropdown-item" href="javascript:void(0);" onclick="loadView({ type: 'get_inbox', param: '', sort: '', filter_user_id: '' }); setTimeout(() => { const st = document.querySelector('[data-target=\'#tab-status\']'); if(st) st.click(); }, 300);"><i class="bi bi-camera-fill"></i> My Statuses</a></li>
              <li><a class="dropdown-item" href="#" id="profile-dropdown-stats-mobile"><i class="bi bi-bar-chart-line-fill"></i> Statistics</a></li>
              <li><a class="dropdown-item" href="#" id="sleep-timer-btn-mobile"><i class="bi bi-moon-stars-fill"></i> Sleep Timer</a></li>
              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settings-modal"><i class="bi bi-sliders"></i> Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="#" id="profile-dropdown-logout-mobile"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
          </div>
        </div>
        <div class="page-header">
          <h1 id="content-title" class="content-title text-truncate">Home</h1>
          <div class="header-controls">
            <div id="sort-controls" class="d-none">
              <label for="sort-select" class="text-secondary small">Sort by</label>
              <select id="sort-select" class="form-select form-select-sm" style="width: auto;"></select>
            </div>
            <div id="history-controls" class="d-none"></div>
            <div class="input-group search-bar d-none d-md-flex position-relative">
              <input type="text" class="form-control" id="search-input-desktop" placeholder="Search..." aria-label="Search...">
              <button class="btn" type="button" id="search-btn-desktop"><i class="bi bi-search"></i></button>
              <div id="search-dropdown-desktop" class="search-dropdown d-none"></div>
            </div>
            <div class="dropdown logged-in-only d-none d-md-block position-relative">
              <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="profile-picture" id="profile-picture-header-desktop" alt="Profile" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
              <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-dark rounded-circle d-none notif-dot" style="z-index: 10; width: 10px; height: 10px;"></span>
              <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end phpmusic-profile-dropdown">
                <li>
                  <div class="phpmusic-profile-header-card">
                    <div class="phpmusic-profile-bg-placeholder"></div>
                    <div class="phpmusic-profile-header-card-inner">
                      <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="phpmusic-profile-img-placeholder" alt="Profile">
                      <div class="info">
                        <div class="name phpmusic-profile-name">Loading...</div>
                        <div class="meta phpmusic-profile-subtext">Loading...</div>
                      </div>
                    </div>
                  </div>
                </li>
                <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#activity-modal">
                  <span><i class="bi bi-bell-fill"></i> My Activity</span>
                  <span class="badge bg-danger rounded-pill d-none notif-badge">0</span>
                </a></li>
                <li><a class="dropdown-item d-flex justify-content-between align-items-center" href="javascript:void(0);" onclick="loadView({ type: 'get_inbox', param: '', sort: '', filter_user_id: '' });">
                  <span><i class="bi bi-chat-dots-fill"></i> Direct Messages</span>
                  <span class="badge bg-danger rounded-pill d-none inbox-badge">0</span>
                </a></li>
                <li><a class="dropdown-item" href="javascript:void(0);" onclick="loadView({ type: 'get_inbox', param: '', sort: '', filter_user_id: '' }); setTimeout(() => { const st = document.querySelector('[data-target=\'#tab-status\']'); if(st) st.click(); }, 300);"><i class="bi bi-camera-fill"></i> My Statuses</a></li>
                <li><a class="dropdown-item" href="#" id="profile-dropdown-stats-desktop"><i class="bi bi-bar-chart-line-fill"></i> Statistics</a></li>
                <li><a class="dropdown-item" href="#" id="sleep-timer-btn-desktop"><i class="bi bi-moon-stars-fill"></i> Sleep Timer</a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settings-modal"><i class="bi bi-sliders"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" id="profile-dropdown-logout-desktop"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div id="content-area" class="content-area-wrapper"></div>
        <div id="infinite-scroll-loader" class="loader d-none">Loading more...</div>
      </main>
    </div>

    <!-- Edit Art Comment Modal -->
    <div class="modal fade" id="edit-art-comment-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px;">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-pencil-square text-info me-2"></i>Edit Comment</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <form id="edit-art-comment-form">
              <input type="hidden" id="edit-art-comment-id">
              <div class="rich-input-container" data-target-id="edit-art-comment-input">
                <textarea id="edit-art-comment-input" class="form-control bg-dark text-white border-secondary shadow-none modern-custom-scroll rounded-4 p-3 mb-3" placeholder="Type your comment..." required rows="5" style="resize: none;"></textarea>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-info text-dark fw-bold rounded-pill px-5 py-2 shadow-sm">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Art Comment Reply Modal -->
    <div class="modal fade" id="reply-art-comment-modal" tabindex="-1" data-bs-backdrop="static" style="z-index: 1065;">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px;">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-reply-fill text-info me-2"></i>Reply to Comment</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <div id="reply-art-comment-preview" class="p-3 mb-3 rounded-4" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.03);"></div>
            <div class="rich-input-container" data-target-id="reply-art-comment-input-real">
              <form id="reply-art-comment-form" class="d-flex flex-column bg-dark rounded-4 p-2 shadow-inner mb-3" style="border: 1px solid rgba(255,255,255,0.12);">
                <textarea id="reply-art-comment-input-real" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Type your reply..." required rows="4" style="resize: none;"></textarea>
                <div class="d-flex justify-content-end align-items-center mt-2">
                  <button type="submit" class="btn btn-info text-dark fw-bold rounded-pill px-4 shadow-sm">Post Reply</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="console-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white mb-0"><i class="bi bi-terminal-fill text-info me-2"></i> Application Console</h5>
            <div>
              <button type="button" class="btn btn-sm btn-outline-secondary me-3" id="clear-console-btn">Clear Logs</button>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
          </div>
          <div class="modal-body p-0">
            <div id="custom-console-output" class="p-3 font-monospace small" style="background-color: #000; color: #0f0; min-height: 300px; max-height: 60vh; overflow-y: auto; white-space: pre-wrap; word-break: break-word;"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="how-to-use-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white"><i class="bi bi-info-circle-fill text-danger me-2"></i>Comprehensive User Guide</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-light p-4" style="line-height: 1.7; font-size: 0.95rem;">
            
            <div class="text-center mb-5 mt-2">
              <i class="bi bi-journal-album text-danger" style="font-size: 4rem;"></i>
              <h2 class="fw-bold mt-3 text-white">The Ultimate Guide</h2>
              <p class="text-secondary">Master every advanced feature, gesture, and tool available in the PHP Music platform.</p>
            </div>

            <!-- SECTION 1: PLAYBACK & NAVIGATION -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-play-circle-fill text-danger me-2"></i> 1. Playback & Core Navigation</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-mouse-fill"></i></div>
                      <div>
                        <strong class="text-white">Instant Playback</strong><br>
                        <span class="text-secondary">Simply click or tap on any song row in any list, album, or playlist. The audio will immediately stream, and the persistent player bar will appear at the bottom of your screen.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-arrows-collapse"></i></div>
                      <div>
                        <strong class="text-white">Fullscreen Mode & Visualizer</strong><br>
                        <span class="text-secondary">Click the square album artwork inside the bottom player bar. This triggers the immersive Fullscreen Player, which features an audio-reactive visualizer that bounces to the beat, synced lyrics, and the Up Next queue.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-fast-forward-fill"></i></div>
                      <div>
                        <strong class="text-white">Seek Gestures</strong><br>
                        <span class="text-secondary">Click and hold (long press) the <strong>Next</strong> <i class="bi bi-skip-end-fill"></i> or <strong>Previous</strong> <i class="bi bi-skip-start-fill"></i> buttons. This will seamlessly fast-forward or rewind the currently playing track in precise 5-second increments.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-pip"></i></div>
                      <div>
                        <strong class="text-white">Picture-in-Picture (PiP) Mini Player</strong><br>
                        <span class="text-secondary">On desktop, click the <i class="bi bi-pip"></i> icon to detach the player into a floating window. It stays visible over all other tabs and applications, complete with interactive playback controls and real-time scrolling lyrics!</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-moon-stars-fill"></i></div>
                      <div>
                        <strong class="text-white">Sleep Timer & Wake Lock</strong><br>
                        <span class="text-secondary">Open your profile dropdown (top right) and select "Sleep Timer". Enter the number of minutes, and the music will gracefully pause when time is up. You can optionally toggle the <i class="bi bi-display"></i> Wake Lock icon to physically prevent your phone screen from dimming while you read lyrics.</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 2: AUDIO ENGINE -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-sliders text-info me-2"></i> 2. The Advanced Audio Engine</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-soundwave"></i></div>
                      <div>
                        <strong class="text-white">5-Band Equalizer & Crossfade</strong><br>
                        <span class="text-secondary">Inside the <i class="bi bi-sliders"></i> Settings menu, toggle the Equalizer to sculpt the frequencies (Bass, Mids, Treble). You can also adjust the Crossfade slider to seamlessly blend the end of one song into the beginning of the next!</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-arrow-down-up"></i></div>
                      <div>
                        <strong class="text-white">Volume Normalization (AGC)</strong><br>
                        <span class="text-secondary">Enabled by default, Automatic Gain Control ensures that quiet songs and loud songs play at the exact same volume level, eliminating the need to constantly adjust your speakers.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-headset"></i></div>
                      <div>
                        <strong class="text-white">3D Spatial Audio (HRTF)</strong><br>
                        <span class="text-secondary">Enable this toggle in Settings to process the stereo signal through a Head-Related Transfer Function, simulating a surround-sound room environment for headphone users.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-toggles"></i></div>
                      <div>
                        <strong class="text-white">Per-Song Overrides</strong><br>
                        <span class="text-secondary">If a specific song was mastered poorly, open its Context Menu <i class="bi bi-three-dots-vertical"></i> and click "Audio Settings (This Song)". You can set a unique volume multiplier and EQ curve that will permanently trigger <i>only</i> when that specific song plays!</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 3: MULTI-SELECT & BULK ACTIONS -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-ui-checks-grid text-success me-2"></i> 3. Multi-Select Mode</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-hand-index-thumb-fill"></i></div>
                      <div>
                        <strong class="text-white">Activating Selection Mode</strong><br>
                        <span class="text-secondary">To manage many songs at once, press and hold (long-click) on any song row for exactly 1 second. A translucent red highlight will appear, and a floating toolbar will slide up from the bottom of your screen.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-check2-square"></i></div>
                      <div>
                        <strong class="text-white">Selecting Multiple Tracks</strong><br>
                        <span class="text-secondary">Once activated, you can tap on any other song rows to add them to your selection bundle. You can also click the <i class="bi bi-check-all"></i> icon in the floating bar to instantly select every track currently loaded on the screen.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-layers-fill"></i></div>
                      <div>
                        <strong class="text-white">Bulk Actions</strong><br>
                        <span class="text-secondary">Click the three dots <i class="bi bi-three-dots-vertical"></i> on the floating bar. From here, you can instantly inject all selected tracks into a Playlist, dump them into your Favorites, forcefully Cache them for Offline playback, or Bulk Delete them!</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 4: PLAYLISTS & SORTING -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-music-note-list text-warning me-2"></i> 4. Playlists & Organization</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-lock-fill"></i></div>
                      <div>
                        <strong class="text-white">Public vs. Private Playlists</strong><br>
                        <span class="text-secondary">When creating a playlist, you can toggle privacy. Public playlists can be searched and viewed by anyone, while Private playlists are strictly visible only to your account.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-people-fill"></i></div>
                      <div>
                        <strong class="text-white">Collaborative Sessions</strong><br>
                        <span class="text-secondary">Open your playlist's menu and select "Make Collaborative". You can then click "Manage Collaborators" and invite friends by typing their exact Username or Email. They will instantly gain the ability to add, reorder, and remove tracks in your playlist!</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-arrows-move"></i></div>
                      <div>
                        <strong class="text-white">Drag and Drop Sorting</strong><br>
                        <span class="text-secondary">When viewing your Playlists, Favorites, or Offline library, ensure the sort dropdown is set to "My Order". You can then seamlessly drag and drop songs up and down the list. The database saves your new arrangement automatically!</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-sort-down-alt"></i></div>
                      <div>
                        <strong class="text-white">Intelligent Filtering</strong><br>
                        <span class="text-secondary">Use the Sort Dropdown located at the top right of the interface to instantly reorganize massive lists by Title, Artist, Album, Release Year, or Recently Added.</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 5: OFFLINE CACHING & PWA -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-cloud-arrow-down-fill text-primary me-2"></i> 5. Offline Library & Caching</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-phone-fill"></i></div>
                      <div>
                        <strong class="text-white">Installing the App (PWA)</strong><br>
                        <span class="text-secondary">Click "Install App" in the sidebar. This registers PHP Music as a Progressive Web App directly onto your Home Screen, bypassing the browser UI, accelerating load times via Service Workers, and enabling true disconnected offline usage.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-cloud-check-fill"></i></div>
                      <div>
                        <strong class="text-white">Downloading Tracks</strong><br>
                        <span class="text-secondary">Open a song's menu and select "Make Available Offline". The audio stream and album art will physically download into your browser's encrypted Storage Quota. A green checkmark <i class="bi bi-cloud-check-fill text-success"></i> will confirm it is secure.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-exclamation-triangle-fill"></i></div>
                      <div>
                        <strong class="text-white">Cache Management & Warnings</strong><br>
                        <span class="text-secondary">If your device runs extremely low on storage, iOS/Android might silently delete cache chunks. If a song shows a warning <i class="bi bi-cloud-slash-fill text-warning"></i>, simply click "Re-download Cache" to repair the file, or use "Re-cache All" in the Offline view.</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 6: SOCIAL & COMMUNITY -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-people-fill text-secondary me-2"></i> 6. Community & Interaction</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-chat-quote-fill"></i></div>
                      <div>
                        <strong class="text-white">Global Community Feed</strong><br>
                        <span class="text-secondary">Access the Community tab to broadcast text posts to all users on the server. You can edit, delete, and Like/Dislike posts globally.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-chat-left-text-fill"></i></div>
                      <div>
                        <strong class="text-white">Song Threads & Mentions</strong><br>
                        <span class="text-secondary">Every single track contains a dedicated comment section. Open the song menu and click "View Comments". You can reply to specific users, use <code>@Username</code> to tag them, and vote on track popularity.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-person-plus-fill"></i></div>
                      <div>
                        <strong class="text-white">Following Users</strong><br>
                        <span class="text-secondary">Click the "Follow" button on any user's profile. Their newly uploaded songs and albums will automatically surface in your personalized "For You" feed!</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-journal-check"></i></div>
                      <div>
                        <strong class="text-white">Personal Notes</strong><br>
                        <span class="text-secondary">Need to write down a lyric draft or a diary entry while listening? Use the Personal Notes tab. These notes are completely private, heavily encrypted in the database, and timestamped upon modification.</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 7: UPLOADING & METADATA -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-file-earmark-music-fill text-muted me-2"></i> 7. Uploading & Deep Metadata</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-upload"></i></div>
                      <div>
                        <strong class="text-white">Upload Pipeline</strong><br>
                        <span class="text-secondary">Verified users can upload up to 10 tracks daily. The system accepts MP3, FLAC, M4A, OGG, and WAV. The server automatically parses the ID3 Tags (Title, Artist, Album, Genre) and extracts embedded Cover Art during upload.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-pencil-square"></i></div>
                      <div>
                        <strong class="text-white">Live Metadata Editor</strong><br>
                        <span class="text-secondary">If the automated ID3 parsing is incorrect, click "Edit Info" on any song you uploaded. You can dynamically overwrite the database fields and attach a new cover art file (which will be perfectly 1:1 cropped using the CropperJS engine).</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-mic-fill"></i></div>
                      <div>
                        <strong class="text-white">Synchronized LRC Lyrics</strong><br>
                        <span class="text-secondary">When editing Metadata, you can paste standard <code>[mm:ss.xx]</code> LRC format strings into the Lyrics box. The player engine will automatically parse these timestamps and scroll the lyrics perfectly to the audio track during playback!</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 8: PORTABILITY & BACKUPS -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-box-arrow-up text-info me-2"></i> 8. Data Portability & Downloads</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-filetype-json"></i></div>
                      <div>
                        <strong class="text-white">JSON Library Exports</strong><br>
                        <span class="text-secondary">Never lose your curated lists. Navigate to any Playlist, your Favorites, or your Offline Library, and click the Export button. The server generates a lightweight `.json` manifest that can be imported to perfectly reconstruct the list anywhere.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-hdd-network-fill"></i></div>
                      <div>
                        <strong class="text-white">The Playlist Downloader</strong><br>
                        <span class="text-secondary">Open the Downloader tool from the sidebar. Paste the Public ID of any playlist, and the system will queue all tracks. Click "Start Sequential Download" to rip the physical MP3s directly to your hard drive, one by one.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-shield-lock-fill"></i></div>
                      <div>
                        <strong class="text-white">Cryptographic Account Backups</strong><br>
                        <span class="text-secondary">In Settings, you can choose to "Delete Account but Keep Data". The server destroys your email/password logic, turns you into an anonymous ghost account, and provides a complex Backup Key. Keep this key safeâ€”you can enter it into the "Restore Account" module later to reclaim your exact library under a totally different name!</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 9: DEVELOPER & ADMIN TOOLS -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-terminal-fill text-light me-2"></i> 9. Developer & Power-User Tools</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled mb-0">
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-code-slash"></i></div>
                      <div>
                        <strong class="text-white">Open API Endpoints</strong><br>
                        <span class="text-secondary">Click "Get API" in the sidebar. This tool reveals all the internal backend URL hooks (e.g., <code>?action=get_songs</code>). You can copy these endpoints to write python scripts, discord bots, or external UI interfaces that tap directly into your PHP Music database.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-3">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-hdd-stack-fill"></i></div>
                      <div>
                        <strong class="text-white">Full Library Scan</strong><br>
                        <span class="text-secondary">If a server administrator physically drags thousands of MP3s into the server folder using FTP, they can trigger a "Scan All" from the sidebar. The engine sweeps the directory tree, analyzes every ID3 tag, and aggressively injects them into the SQLite database.</span>
                      </div>
                    </div>
                  </li>
                  <li class="mb-0">
                    <div class="d-flex align-items-start gap-3">
                      <div class="p-2 bg-dark rounded text-white fs-5"><i class="bi bi-eraser-fill"></i></div>
                      <div>
                        <strong class="text-white">Clear Application Cache</strong><br>
                        <span class="text-secondary">If the player starts acting buggy or storage quota is overloaded, click "Clear Cache" in the sidebar. This securely unregisters Service Workers, deletes old Offline caches, resets DOM memory, and forces a hard reload of the interface.</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- SECTION 10: ICONS DICTIONARY -->
            <div class="card bg-transparent border-secondary mb-4">
              <div class="card-header bg-dark border-secondary">
                <h5 class="mb-0 text-white"><i class="bi bi-info-circle-fill text-primary me-2"></i> 10. Core Icon Dictionary</h5>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <div class="p-2 bg-dark rounded text-white fs-5" style="min-width: 45px; text-align: center;"><i class="bi bi-play-fill"></i></div>
                    <span class="text-secondary"><strong>Play / Pause:</strong> Tap to toggle audio playback state.</span>
                  </div>
                  <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <div class="p-2 bg-dark rounded text-white fs-5" style="min-width: 45px; text-align: center;"><i class="bi bi-skip-start-fill"></i></div>
                    <span class="text-secondary"><strong>Prev / Next:</strong> Skip tracks, or hold to scrub the timeline.</span>
                  </div>
                  <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <div class="p-2 bg-dark rounded text-white fs-5" style="min-width: 45px; text-align: center;"><i class="bi bi-shuffle"></i></div>
                    <span class="text-secondary"><strong>Shuffle:</strong> Randomize the play queue securely.</span>
                  </div>
                  <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <div class="p-2 bg-dark rounded text-white fs-5" style="min-width: 45px; text-align: center;"><i class="bi bi-repeat"></i></div>
                    <span class="text-secondary"><strong>Repeat:</strong> Cycle (Off â†’ Repeat All â†’ Repeat One).</span>
                  </div>
                  <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <div class="p-2 bg-dark rounded text-white fs-5" style="min-width: 45px; text-align: center;"><i class="bi bi-three-dots-vertical"></i></div>
                    <span class="text-secondary"><strong>Context Menu:</strong> Access sharing, metadata, and playlist tools.</span>
                  </div>
                  <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                    <div class="p-2 bg-dark rounded text-white fs-5" style="min-width: 45px; text-align: center;"><i class="bi bi-heart-fill"></i></div>
                    <span class="text-secondary"><strong>Favorite:</strong> Pin a song globally to your profile collection.</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- SECTION 11: LEGAL -->
            <div class="card bg-transparent border-danger">
              <div class="card-header bg-dark border-danger">
                <h5 class="mb-0 text-danger"><i class="bi bi-shield-exclamation text-danger me-2"></i> 11. Disclaimers & Fair Use</h5>
              </div>
              <div class="card-body">
                <p class="text-secondary mb-2"><strong>Copyright Responsibility:</strong> Users are solely responsible for the audio files they upload. Ensure you have the explicit right, license, or explicit permission from the original artist to use, stream, and distribute the content on this instance.</p>
                <p class="text-secondary mb-2"><strong>Personal Use Only:</strong> Advanced scraping utilities, including the Playlist Downloader, Open API, and high-quality streaming engines, are intended strictly for personal, private, and entirely non-commercial listening curation.</p>
                <p class="text-secondary mb-0"><strong>Content Moderation:</strong> Instance administrators reserve the unconditional right to instantly terminate sessions, indefinitely ban accounts, remove files, or delete altered metadata that violates copyright laws or general community guidelines without any prior notice.</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="shortcuts-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content" style="background-color: var(--ytm-bg); border: none;">
          <div class="modal-header border-0 pb-2 px-4" style="border-bottom: 1px solid var(--ytm-surface-2) !important; background-color: var(--ytm-surface);">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-keyboard-fill text-danger me-2"></i>Keyboard Shortcuts</h5>
            <button type="button" class="btn-close btn-close-white fs-5" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-light px-4 py-4 mx-auto">
            
            <div class="d-flex flex-column gap-3">
              
              <!-- PLAYBACK CONTROLS -->
              <h5 class="text-white mt-2 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Playback Controls</h5>
              
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="70" height="36" viewBox="0 0 70 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="70" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SPACE</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Play / Pause</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the Spacebar once to toggle the current audio state between active playing and paused.</li>
                  <li><strong>Context & Requirements:</strong> Works globally across all views. Will not trigger if a text input field, search bar, comment box, or note editor is actively focused.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><path d="M14 12L22 18L14 24V12Z" fill="#ffffff"/></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Next Track</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the Right Arrow key once to skip the current track.</li>
                  <li><strong>Context & Requirements:</strong> Triggers the subsequent song in the active queue. Respects current repeat and shuffle parameters. If at the end of the queue, it automatically queries Autoplay/Radio tracks for continuous streaming.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><path d="M22 12L14 18L22 24V12Z" fill="#ffffff"/></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Previous Track</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the Left Arrow key once.</li>
                  <li><strong>Context & Requirements:</strong> Rewinds to <code>0:00</code> if the current song has played for more than 3 seconds. Navigates to the previously played queue item if the song has played for less than 3 seconds.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><path d="M14 12L22 18L14 24V12Z" fill="#ffffff"/></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Seek Forward 10s</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the Right Arrow key.</li>
                  <li><strong>Context & Requirements:</strong> Instantly seeks the timeline forward by precisely 10 seconds. Processes the shift locally through the HTML5 audio element without reloading the streaming buffer.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><path d="M22 12L14 18L22 24V12Z" fill="#ffffff"/></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Seek Backward 10s</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the Left Arrow key.</li>
                  <li><strong>Context & Requirements:</strong> Rewinds the playback head by exactly 10 seconds. Enables fine-grained backtracking without requiring manual progress bar scrubbing.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="50" height="36" viewBox="0 0 50 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="50" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="14" font-weight="bold">1-9</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Jump 10% - 90%</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Tap any number key from 1 to 9 on the keyboard or numpad.</li>
                  <li><strong>Context & Requirements:</strong> Snaps playback position directly to the relative percentage of the song (e.g. <code>5</code> seeks to 50%). Ideal for rapid indexing of long mixes and podcasts.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">0</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Restart Song</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the '0' key once.</li>
                  <li><strong>Context & Requirements:</strong> Snaps the timeline tracker instantly to <code>0:00</code>. This is an absolute reset action and preserves your current loop, volume, and EQ settings.</li>
                </ul>
              </div>
    
              <!-- AUDIO & MODES -->
              <h5 class="text-white mt-4 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Audio & Modes</h5>
              
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><path d="M18 12L12 18H24L18 12Z" fill="#ffffff"/></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Volume Up</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the Up Arrow key once.</li>
                  <li><strong>Context & Requirements:</strong> Increments the master output volume by exactly 5% per press. Smoothly communicates with the Web Audio Gain Node to prevent digital crackling.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><path d="M18 24L12 18H24L18 24Z" fill="#ffffff"/></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Volume Down</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the Down Arrow key once.</li>
                  <li><strong>Context & Requirements:</strong> Decrements the master output volume by exactly 5% per press, scaling cleanly down to absolute zero. Updates the player's visual volume slider in real-time.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">M</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Mute / Unmute</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'M' key once.</li>
                  <li><strong>Context & Requirements:</strong> Instantly toggles the master gain level between muted and its prior non-zero value. Audio tracks continue processing silently in the background while muted.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">S</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Toggle Shuffle</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'S' key once.</li>
                  <li><strong>Context & Requirements:</strong> Randomizes the upcoming track order using the Fisher-Yates array shuffle. Pressing again restores the original folder or view order.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">R</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Toggle Repeat Mode</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'R' key sequentially to cycle through repeat states.</li>
                  <li><strong>Context & Requirements:</strong> Cycles through the three primary modes: Repeat Off â†’ Repeat All (loops active playlist) â†’ Repeat One (loops current song).</li>
                </ul>
              </div>
    
              <!-- INTERFACE & ACTIONS -->
              <h5 class="text-white mt-4 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Interface & Actions</h5>
              
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">F</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Toggle Fullscreen Player</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'F' key once.</li>
                  <li><strong>Context & Requirements:</strong> Expands the interface to full screen via the browser Fullscreen API. Tap again or press `ESC` to return to windowed mode.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">P</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Picture-in-Picture (PiP)</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'P' key once.</li>
                  <li><strong>Context & Requirements:</strong> Spawns a Document Picture-in-Picture floating interface (or Canvas Video fallback) on top of other desktop windows. Supports system-level playback commands.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">L</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Show Lyrics</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'L' key once.</li>
                  <li><strong>Context & Requirements:</strong> Summons the lyrics modal instantly. Tracks containing LRC structures will scroll automatically to match vocals.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">C</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Open Comments</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'C' key once.</li>
                  <li><strong>Context & Requirements:</strong> Opens the comment/reaction modal for the playing track. Requires active account authentication to write, reply, or rate comments.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">I</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">View Metadata (Info)</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'I' key once.</li>
                  <li><strong>Context & Requirements:</strong> Pulls exact information logs from SQLite regarding the active track, detailing codec bitrate, genre tags, and physical file path maps.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">E</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Per-Song Audio Settings</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'E' key once.</li>
                  <li><strong>Context & Requirements:</strong> Opens local equalizer configuration panel for this specific track. Any changes will write directly to SQLite and trigger automatically on future playback of this track.</li>
                </ul>
              </div>
    
              <!-- LIBRARY MANAGEMENT -->
              <h5 class="text-white mt-4 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Library Management</h5>
              
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">H</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Toggle Favorite (Heart)</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'H' key once.</li>
                  <li><strong>Context & Requirements:</strong> Instantly toggles the active track's placement in your global Favorites playlist. Requires active login session.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">O</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Make Offline / Re-cache</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'O' key once.</li>
                  <li><strong>Context & Requirements:</strong> Forces the PWA service worker to download and save the raw audio, metadata, and artwork files directly to your browser's persistent cache. Allows smooth offline playback.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">B</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Toggle Listen Later (Bookmark)</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'B' key once.</li>
                  <li><strong>Context & Requirements:</strong> Add or remove the active track from your bookmarks. Requires active account authentication.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">D</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Download MP3 File</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'D' key once.</li>
                  <li><strong>Context & Requirements:</strong> Triggers a direct download of the active audio file. Renames the downloaded file to matches standard `Title - Artist` structure.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">U</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Copy Share Link</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'U' key once.</li>
                  <li><strong>Context & Requirements:</strong> Automatically copy a deep link to the active track to your system clipboard.</li>
                </ul>
              </div>
    
              <!-- NAVIGATION & QUICK ACCESS -->
              <h5 class="text-white mt-4 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Navigation & Quick Access</h5>
              
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">Q</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Focus Up Next (Queue)</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'Q' key once.</li>
                  <li><strong>Context & Requirements:</strong> Summons the fullscreen player view and focuses the queue panel (Up Next) directly.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">N</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Navigate to Notes</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'N' key once.</li>
                  <li><strong>Context & Requirements:</strong> Navigates you to the Notes board, ensuring you can quickly write down notes. Needs active login session.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">K</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Navigate to Tasks</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'K' key once.</li>
                  <li><strong>Context & Requirements:</strong> Opens the Tasks view directly. Requires active login session.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">V</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Global Audio Settings</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'V' key once.</li>
                  <li><strong>Context & Requirements:</strong> Summons the settings window directly to the global Audio Engine tab. Requires active login session.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">W</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Toggle Wake Lock</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the 'W' key once.</li>
                  <li><strong>Context & Requirements:</strong> Instantly toggles the screen awake state, preventing your device from dimming or sleeping while you are reading lyrics.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">P</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Open Playlists View</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the 'P' key.</li>
                  <li><strong>Context & Requirements:</strong> Jumps directly to your Playlists view. Requires active login session.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">U</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Launch Uploader</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the 'U' key.</li>
                  <li><strong>Context & Requirements:</strong> Summons the music uploader modal. Requires verification clearance.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">M</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Open Direct Messages</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the 'M' key.</li>
                  <li><strong>Context & Requirements:</strong> Summons the direct messages modal instantly. Requires active login session.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">F</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Open Favorites</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the 'F' key.</li>
                  <li><strong>Context & Requirements:</strong> Navigates you to your Favorites collection. Requires active login session.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">A</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Open Activity Feed</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the 'A' key.</li>
                  <li><strong>Context & Requirements:</strong> Summons the activity feed modal instantly. Requires active login session.</li>
                </ul>
              </div>
    
              <!-- SYSTEM ACTIONS -->
              <h5 class="text-white mt-4 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">System Actions</h5>
              
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">S</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Focus Search Bar</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the 'S' key.</li>
                  <li><strong>Context & Requirements:</strong> Instantly focuses the navigation search bar, allowing you to search without using the mouse.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="12" font-weight="bold">SHIFT</text></svg>
                    <span class="text-secondary fw-bold">+</span>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="36" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="16" font-weight="bold">C</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Clear Listening History</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Hold the Shift key down and press the 'C' key.</li>
                  <li><strong>Context & Requirements:</strong> Only works while viewing the Playback History tab. Opens a system confirmation dialog before clearing SQLite statistics.</li>
                </ul>
              </div>
    
              <div class="d-flex flex-column p-3 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <svg width="60" height="36" viewBox="0 0 60 36" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="36" rx="6" fill="#282828" stroke="#555555" stroke-width="2"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="monospace" font-size="14" font-weight="bold">ESC</text></svg>
                  </div>
                  <span class="fw-bold text-white fs-5">Close Modals / Context Menu</span>
                </div>
                <ul class="mb-0 text-secondary" style="font-size: 0.85rem; padding-left: 1.2rem; line-height: 1.6;">
                  <li><strong>Trigger Instructions:</strong> Press the Escape key.</li>
                  <li><strong>Context & Requirements:</strong> Closes any active modals, dropdowns, and context menu layers. Focuses the main content window.</li>
                </ul>
              </div>
    
            </div>
    
          </div>
        </div>
      </div>
    </div>

    <div id="multi-select-bar" class="d-none shadow-lg">
      <div class="d-flex align-items-center gap-2 position-relative">
        <span id="multi-select-count" class="badge bg-danger rounded-pill fs-6 px-3 py-2 me-1 shadow-sm">0</span>
        <button class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center border-0" id="multi-cancel-btn" title="Cancel" style="width: 44px; height: 44px; background: rgba(255,255,255,0.1);"><i class="bi bi-x-lg fs-5"></i></button>
        <button class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center border-0" id="multi-select-all-btn" title="Select All Loaded" style="width: 44px; height: 44px; background: rgba(255,255,255,0.1);"><i class="bi bi-check-all fs-4"></i></button>
        
        <div class="vr bg-secondary opacity-50 mx-1" style="width: 2px; min-height: 30px;"></div>
        
        <button class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center border-0" type="button" id="multi-action-dropdown-btn" title="Actions" style="width: 44px; height: 44px; background: rgba(255,255,255,0.1);">
          <i class="bi bi-three-dots-vertical fs-5"></i>
        </button>
        
        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg mb-2" id="multi-action-dropdown-menu" style="background-color: var(--ytm-surface-2); border: 1px solid #404040; border-radius: 12px; overflow: hidden; position: absolute; bottom: 100%; right: 0;">
          <li><button class="dropdown-item d-flex align-items-center gap-3 py-2 text-white" id="multi-add-playlist-btn"><i class="bi bi-music-note-list fs-5 text-secondary"></i> Add to Playlist</button></li>
          <li><button class="dropdown-item d-flex align-items-center gap-3 py-2 text-white" id="multi-add-favorite-btn"><i class="bi bi-heart-fill fs-5 text-danger"></i> Add to Favorites</button></li>
          <li><button class="dropdown-item d-flex align-items-center gap-3 py-2 text-white" id="multi-offline-btn"><i class="bi bi-cloud-arrow-down-fill fs-5 text-info"></i> Re-cache / Offline</button></li>
          <li><hr class="dropdown-divider border-secondary opacity-50 my-1"></li>
          <li><button class="dropdown-item d-flex align-items-center gap-3 py-2 text-danger" id="multi-remove-btn"><i class="bi bi-trash2-fill fs-5"></i> Remove</button></li>
        </ul>
      </div>
    </div>
    <div class="player-bar d-none" id="player-bar">
      <div class="track-info d-none d-md-flex">
        <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" alt="Album Art" class="track-info-art" id="player-art-desktop">
        <div class="track-info-text" style="min-width: 0; flex-grow: 1;">
          <div class="marquee-container">
            <div class="title marquee-content" id="player-title-desktop">Song Title</div>
          </div>
          <div class="marquee-container">
            <div class="artist marquee-content" id="player-artist-desktop">Artist Name</div>
          </div>
        </div>
      </div>
      <div class="player-controls">
        <div class="track-info d-md-none">
          <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" alt="Album Art" class="track-info-art" id="player-art-mobile">
          <div class="track-info-text" style="min-width: 0; flex-grow: 1;">
            <div class="marquee-container mb-1">
              <div class="title marquee-content" id="player-title-mobile">Song Title</div>
            </div>
            <div class="marquee-container">
              <div class="artist marquee-content" id="player-artist-mobile">Artist Name</div>
            </div>
          </div>
          <button class="player-btn ms-1" id="player-more-btn-mobile" title="More"><i class="bi bi-three-dots-vertical"></i></button>
        </div>
        <div class="playback-bar">
          <span class="time" id="current-time">0:00</span>
          <div class="progress-bar-container" id="progress-container">
            <div class="progress-bar-bg"></div>
            <div class="progress-bar-fg" id="progress-bar"></div>
          </div>
          <span class="time" id="time-left">0:00</span>
        </div>
        <div class="player-buttons d-none d-md-flex mt-md-2">
          <button class="player-btn" id="shuffle-btn-desktop" title="Shuffle"></button>
          <button class="player-btn" id="prev-btn-desktop" title="Previous"></button>
          <button class="player-btn play-btn" id="play-pause-btn-desktop" title="Play"></button>
          <button class="player-btn" id="next-btn-desktop" title="Next"></button>
          <button class="player-btn" id="repeat-btn-desktop" title="Repeat"></button>
        </div>
         <div class="player-buttons-mobile d-md-none">
          <button class="player-btn" id="shuffle-btn-mobile" title="Shuffle"></button>
          <button class="player-btn" id="prev-btn-mobile" title="Previous"></button>
          <button class="player-btn play-btn" id="play-pause-btn-mobile" title="Play"></button>
          <button class="player-btn" id="next-btn-mobile" title="Next"></button>
          <button class="player-btn" id="repeat-btn-mobile" title="Repeat"></button>
        </div>
      </div>
      <div class="extra-controls d-none d-md-flex">
        <div class="volume-control d-flex align-items-center">
          <button class="player-btn" id="volume-btn" title="Mute">
            <i class="bi bi-volume-up-fill"></i>
          </button>
          <div class="volume-slider-container">
            <input type="range" class="form-range" id="volume-slider" min="0" max="1" step="0.01" value="1">
          </div>
        </div>
        <button class="player-btn ms-2" id="pip-btn-desktop" title="Mini Player"><i class="bi bi-pip"></i></button>
        <button class="player-btn" id="player-more-btn-desktop" title="More"><i class="bi bi-three-dots-vertical"></i></button>
      </div>
    </div>
    <ul class="context-menu" id="context-menu"></ul>

    <div class="modal fade" id="player-modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content player-modal-content">
          <div class="dynamic-blur-bg" id="mobile-player-bg"></div>
          
          <div class="modal-header border-0 d-flex justify-content-between align-items-center px-3 pt-3 pb-1">
            <button type="button" class="btn player-btn text-white p-0" data-bs-dismiss="modal"><i class="bi bi-chevron-down fs-1"></i></button>
            <ul class="nav nav-tabs border-0 d-flex align-items-center justify-content-center m-0" id="mp-tabs" role="tablist">
              <li class="nav-item"><button class="nav-link active px-3 py-2" data-bs-toggle="tab" data-bs-target="#mp-player-pane">Player</button></li>
              <li class="nav-item"><button class="nav-link px-3 py-2" data-bs-toggle="tab" data-bs-target="#mp-queue-pane">Up Next</button></li>
            </ul>
            <button type="button" class="btn player-btn text-white p-0" id="player-modal-more-btn" title="More"><i class="bi bi-three-dots-vertical fs-2"></i></button>
          </div>
          
          <div class="modal-body p-0 tab-content flex-grow-1 overflow-hidden d-block">
            
            <!-- PLAYER TAB -->
            <div class="tab-pane show active h-100" id="mp-player-pane">
              <div class="h-100 w-100 overflow-hidden px-4 pb-4 pt-1 d-flex flex-column justify-content-center align-items-center">
                
                <div class="d-flex flex-column justify-content-center align-items-center w-100" style="min-height: 0;">
                  <div class="position-relative" style="width: 100%; max-width: 400px; max-height: 42vh; aspect-ratio: 1/1; border-radius: 12px; overflow: hidden; margin: 0 auto;">
                    <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" id="player-modal-art" alt="Album Art" style="width: 100%; height: 100%; object-fit: cover;">
                    <canvas class="visualizer-canvas" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; pointer-events: none; z-index: 5;"></canvas>
                  </div>
                </div>
                
                <div class="w-100 mx-auto mt-3" style="max-width: 400px; flex-shrink: 0;">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-start pe-3" style="min-width: 0; flex-grow: 1; overflow: hidden;">
                      <div class="marquee-container mb-1">
                        <h3 id="player-modal-title" class="title fw-bold m-0 marquee-content" style="font-size: 1.5rem;">Song Title</h3>
                      </div>
                      <div class="marquee-container">
                        <p id="player-modal-artist" class="artist text-white m-0 marquee-content" style="font-size: 1.1rem; opacity: 0.85;">Artist Name</p>
                      </div>
                    </div>
                    <button class="btn p-0 border-0 logged-in-only" id="player-modal-favorite-btn" style="background: transparent; flex-shrink: 0;">
                      <i class="bi bi-heart"></i>
                    </button>
                  </div>
                  
                  <div class="mb-4 w-100">
                    <div class="progress-bar-container" id="player-modal-progress-container" style="padding: 10px 0;">
                      <div class="progress-bar-bg"></div><div class="progress-bar-fg" id="player-modal-progress-bar"></div>
                    </div>
                    <div class="d-flex justify-content-between small text-white mt-1 fw-medium" style="font-size: 0.85rem; opacity: 0.85;">
                      <span id="player-modal-current-time">0:00</span><span id="player-modal-time-left">0:00</span>
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-between align-items-center w-100 mx-auto mb-2">
                    <button class="player-btn fs-3 text-white" id="player-modal-shuffle-btn"><i class="bi bi-shuffle"></i></button>
                    <button class="player-btn text-white" id="player-modal-prev-btn" style="font-size: 2.5rem;"><i class="bi bi-skip-start-fill"></i></button>
                    <button class="player-btn play-btn bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" id="player-modal-play-pause-btn" style="width: 72px; height: 72px;"><i class="bi bi-play-fill" style="font-size: 3rem; margin-left: 4px;"></i></button>
                    <button class="player-btn text-white" id="player-modal-next-btn" style="font-size: 2.5rem;"><i class="bi bi-skip-end-fill"></i></button>
                    <button class="player-btn fs-3 text-white" id="player-modal-repeat-btn"><i class="bi bi-repeat"></i></button>
                  </div>
                </div>
                
              </div>
            </div>

            <!-- UP NEXT TAB -->
            <div class="tab-pane h-100 overflow-auto" id="mp-queue-pane">
               <div id="mobile-player-queue-list" class="p-2"></div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="desktop-player-modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content player-modal-content" id="dp-modal-content-wrapper">
          <div class="dynamic-blur-bg" id="desktop-player-bg"></div>
          <canvas class="visualizer-canvas immersive-visualizer d-none" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1; opacity: 0.4;"></canvas>
          <div class="modal-header player-modal-header py-0 px-4 border-0">
            <button type="button" class="btn player-btn text-white" data-bs-dismiss="modal" aria-label="Close">
              <i class="bi bi-chevron-down fs-2"></i>
            </button>
            <div>
              <button type="button" class="btn player-btn text-white d-inline-block" id="desktop-player-modal-more-btn" title="More">
                <i class="bi bi-three-dots-vertical fs-3"></i>
              </button>
            </div>
          </div>
          <div class="modal-body d-flex h-100 overflow-hidden pt-1 gap-4 align-items-center">
            
            <div class="w-50 d-flex flex-column align-items-center justify-content-center h-100 px-4" id="dp-left-pane" style="min-width: 0;">
              <div class="position-relative shadow-lg mx-auto" style="width: 100%; max-width: 50vh; aspect-ratio: 1/1; border-radius: 12px; overflow: hidden; flex-shrink: 1;">
                <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" id="desktop-player-modal-art" style="width: 100%; height: 100%; object-fit: cover; background-color: var(--ytm-surface-2);">
                <canvas class="visualizer-canvas" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; pointer-events: none; z-index: 5;"></canvas>
                <button type="button" class="btn text-white position-absolute top-0 start-0 m-1 z-3 p-2 border-0 rounded-circle d-flex align-items-center justify-content-center border border-secondary" id="dp-immersive-btn" title="Immersive Fullscreen" style="width: 44px; height: 44px; backdrop-filter: blur(4px); transition: all 0.2s;">
                  <i class="bi bi-arrows-fullscreen fs-5"></i>
                </button>
              </div>
              <div class="mb-3 text-center mt-4 w-100 px-4">
                <div class="marquee-container mb-1">
                  <h3 id="desktop-player-modal-title" class="fw-bold m-0 marquee-content" style="max-width: 100%;">Song Title</h3>
                </div>
                <div class="marquee-container">
                  <p id="desktop-player-modal-artist" class="text-secondary m-0 marquee-content" style="cursor: pointer; max-width: 100%;">Artist Name</p>
                </div>
              </div>
            </div>

            <div class="w-50 d-flex flex-column h-100 py-3 pe-4" id="dp-right-pane">
              
              <ul class="nav nav-tabs border-secondary d-flex align-items-center justify-content-center border-0" id="dp-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="dp-queue-tab" data-bs-toggle="tab" data-bs-target="#dp-queue-pane" type="button" role="tab">Up Next</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="dp-lyrics-tab" data-bs-toggle="tab" data-bs-target="#dp-lyrics-pane" type="button" role="tab">Lyrics</button>
                </li>
              </ul>
              
              <div class="tab-content flex-grow-1 overflow-hidden d-flex flex-column mb-4 rounded" style="background-color: rgba(18, 18, 18, 0.4); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.05);" id="dp-tabs-content">
                
                <div class="tab-pane show active h-100 overflow-auto" id="dp-queue-pane" role="tabpanel">
                   <div id="desktop-player-queue-list" class="p-2">
                     <!-- Populated dynamically by JS -->
                   </div>
                </div>

                <div class="tab-pane h-100 overflow-hidden text-start position-relative fs-4" id="dp-lyrics-pane" role="tabpanel">
                   <div class="h-100 overflow-auto p-3 p-md-4" id="desktop-player-modal-lyrics-container">
                     <div id="desktop-synced-lyrics"></div>
                   </div>
                </div>

              </div>
              
              <div class="mt-auto">
                <div class="d-flex align-items-center gap-3 mb-4" id="dp-progress-row">
                  <span id="desktop-player-modal-current-time" class="small text-secondary">0:00</span>
                  <div class="progress-bar-container flex-grow-1" id="desktop-player-modal-progress-container">
                    <div class="progress-bar-bg"></div>
                    <div class="progress-bar-fg" id="desktop-player-modal-progress-bar"></div>
                  </div>
                  <span id="desktop-player-modal-time-left" class="small text-secondary">0:00</span>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-4">
                  <button class="player-btn" id="desktop-player-modal-shuffle-btn" title="Shuffle"><i class="bi bi-shuffle"></i></button>
                  <button class="player-btn fs-2" id="desktop-player-modal-prev-btn" title="Previous"><i class="bi bi-skip-start-fill"></i></button>
                  <button class="player-btn play-btn" id="desktop-player-modal-play-pause-btn" title="Play" style="width: 70px; height: 70px;"><i class="bi bi-play-fill" style="font-size: 3.5rem;"></i></button>
                  <button class="player-btn fs-2" id="desktop-player-modal-next-btn" title="Next"><i class="bi bi-skip-end-fill"></i></button>
                  <button class="player-btn" id="desktop-player-modal-repeat-btn" title="Repeat"><i class="bi bi-repeat"></i></button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="connections-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold" id="connections-modal-title"><i class="bi bi-people-fill text-info me-2"></i>Connections</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-3 pb-4">
            <div class="d-flex flex-column gap-2" id="connections-list"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="reply-comment-modal" tabindex="-1" data-bs-backdrop="static" style="z-index: 1065;">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-reply-fill text-info me-2"></i>Reply</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <div id="reply-comment-preview" class="mb-3 px-1"></div>
            <form id="reply-comment-form">
              <input type="hidden" id="reply-comment-parent-id">
              <input type="hidden" id="reply-comment-reply-to-id">
              <div class="rich-input-container" data-target-id="reply-comment-input">
                <div class="d-flex flex-column rounded-4 p-2 mb-3" style="border: 1px solid rgba(255,255,255,0.12); background: transparent; transition: border-color 0.3s;" onfocusin="this.style.borderColor='var(--ytm-accent)'" onfocusout="this.style.borderColor='rgba(255,255,255,0.12)'">
                  <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 mb-2 px-2 py-1 rounded-3" style="background: transparent;">
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="bold" title="Bold"><i class="bi bi-type-bold fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="italic" title="Italic"><i class="bi bi-type-italic fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ul" title="Bullet List"><i class="bi bi-list-ul fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ol" title="Numbered List"><i class="bi bi-list-ol fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="task" title="Task List"><i class="bi bi-ui-checks fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="quote" title="Blockquote"><i class="bi bi-quote fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="code" title="Code Block"><i class="bi bi-code-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="link" title="Link"><i class="bi bi-link-45deg fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="image" title="Image"><i class="bi bi-image fs-6"></i></button>
                  </div>
                  <textarea id="reply-comment-input" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Type your reply..." maxlength="5000" required rows="4" style="resize: none; min-height: 100px; font-size: 1rem; line-height: 1.5; padding: 10px 14px;"></textarea>
                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-info text-dark fw-bold rounded-pill px-5 py-2 shadow-sm">Post Reply</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="reply-blog-comment-modal" tabindex="-1" data-bs-backdrop="static" style="z-index: 1065;">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-reply-fill text-info me-2"></i>Reply to Comment</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <div id="reply-blog-comment-preview" class="p-3 mb-3 rounded-4" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.03);"></div>
            <form id="reply-blog-comment-form">
              <input type="hidden" id="reply-blog-comment-parent-id">
              <input type="hidden" id="reply-blog-comment-reply-to-id">
              <div class="rich-input-container" data-target-id="reply-blog-comment-input">
                <div class="d-flex flex-column bg-dark rounded-4 p-2 shadow-inner mb-3" style="border: 1px solid rgba(255,255,255,0.12); transition: border-color 0.3s;" onfocusin="this.style.borderColor='var(--ytm-accent)'" onfocusout="this.style.borderColor='rgba(255,255,255,0.12)'">
                  <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 mb-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #212121; border: 1px solid rgba(255,255,255,0.05);">
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="bold" title="Bold"><i class="bi bi-type-bold fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="italic" title="Italic"><i class="bi bi-type-italic fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ul" title="Bullet List"><i class="bi bi-list-ul fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ol" title="Numbered List"><i class="bi bi-list-ol fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="task" title="Task List"><i class="bi bi-ui-checks fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="quote" title="Blockquote"><i class="bi bi-quote fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="code" title="Code Block"><i class="bi bi-code-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="link" title="Link"><i class="bi bi-link-45deg fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="image" title="Image"><i class="bi bi-image fs-6"></i></button>
                  </div>
                  <textarea id="reply-blog-comment-input" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Type your reply..." maxlength="5000" required rows="4" style="resize: none; min-height: 100px; font-size: 1rem; line-height: 1.5; padding: 10px 14px;"></textarea>
                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-info text-dark fw-bold rounded-pill px-5 py-2 shadow-sm">Post Reply</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="reply-community-post-modal" tabindex="-1" data-bs-backdrop="static" style="z-index: 1065;">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-reply-fill text-info me-2"></i>Reply to Post</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <div id="reply-community-post-preview" class="p-3 mb-3 rounded-4" style="background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.03);"></div>
            <form id="reply-community-post-form">
              <input type="hidden" id="reply-community-post-parent-id">
              <input type="hidden" id="reply-community-post-reply-to-id">
              <div class="rich-input-container" data-target-id="reply-community-post-input">
                <div class="d-flex flex-column bg-dark rounded-4 p-2 shadow-inner mb-3" style="border: 1px solid rgba(255,255,255,0.12); transition: border-color 0.3s;" onfocusin="this.style.borderColor='var(--ytm-accent)'" onfocusout="this.style.borderColor='rgba(255,255,255,0.12)'">
                  <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 mb-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #212121; border: 1px solid rgba(255,255,255,0.05);">
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="bold" title="Bold"><i class="bi bi-type-bold fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="italic" title="Italic"><i class="bi bi-type-italic fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ul" title="Bullet List"><i class="bi bi-list-ul fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ol" title="Numbered List"><i class="bi bi-list-ol fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="task" title="Task List"><i class="bi bi-ui-checks fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="quote" title="Blockquote"><i class="bi bi-quote fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="code" title="Code Block"><i class="bi bi-code-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="link" title="Link"><i class="bi bi-link-45deg fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="image" title="Image"><i class="bi bi-image fs-6"></i></button>
                  </div>
                  <textarea id="reply-community-post-input" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Type your reply..." maxlength="5000" required rows="4" style="resize: none; min-height: 100px; font-size: 1rem; line-height: 1.5; padding: 10px 14px;"></textarea>
                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-info text-dark fw-bold rounded-pill px-5 py-2 shadow-sm">Post Reply</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="comments-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="background: rgba(30, 30, 30, 0.95); backdrop-filter: blur(10px); border: 1px solid #444;">
          <div class="modal-header border-secondary">
            <h5 class="modal-title w-100 text-white">Song Comments</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
              <div class="d-flex align-items-center gap-3">
                <span class="text-secondary small fw-bold"><span id="total-comments-count">0</span> Comments</span>
              </div>
              <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link text-secondary text-decoration-none p-0 d-flex align-items-center gap-2" id="song-like-btn" style="transition: color 0.2s;">
                  <i class="bi bi-hand-thumbs-up fs-5"></i> <span id="song-like-count" class="fw-bold">0</span>
                </button>
                <button class="btn btn-link text-secondary text-decoration-none p-0 d-flex align-items-center gap-2" id="song-dislike-btn" style="transition: color 0.2s;">
                  <i class="bi bi-hand-thumbs-down fs-5"></i> <span id="song-dislike-count" class="fw-bold">0</span>
                </button>
              </div>
            </div>
            <div class="d-flex gap-3 mb-3">
              <img src="?action=get_profile_picture&id=<?php echo $_SESSION['user_id'] ?? 0; ?>" class="rounded-circle shadow-sm flex-shrink-0 d-none d-sm-block mt-1" style="width: 44px; height: 44px; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
              <div class="flex-grow-1 rich-input-container" data-target-id="comment-input">
                <form id="comment-form" class="bg-transparent position-relative">
                  <input type="hidden" id="comment-parent-id" value="">
                  <div class="d-flex flex-column bg-dark rounded-4 p-2 shadow-inner" style="border: 1px solid rgba(255,255,255,0.12); transition: border-color 0.3s;" onfocusin="this.style.borderColor='var(--ytm-accent)'" onfocusout="this.style.borderColor='rgba(255,255,255,0.12)'">
                    <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 mb-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #212121; border: 1px solid rgba(255,255,255,0.05);">
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="bold" title="Bold"><i class="bi bi-type-bold fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="italic" title="Italic"><i class="bi bi-type-italic fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="heading" title="Heading"><i class="bi bi-type-h1 fs-6"></i></button>
                      <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ul" title="Bullet List"><i class="bi bi-list-ul fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ol" title="Numbered List"><i class="bi bi-list-ol fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="task" title="Task List"><i class="bi bi-ui-checks fs-6"></i></button>
                      <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="quote" title="Blockquote"><i class="bi bi-quote fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="code" title="Code Block"><i class="bi bi-code-slash fs-6"></i></button>
                      <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="table" title="Table"><i class="bi bi-table fs-6"></i></button>
                      <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-left" title="Align Left"><i class="bi bi-text-left fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-center" title="Align Center"><i class="bi bi-text-center fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-right" title="Align Right"><i class="bi bi-text-right fs-6"></i></button>
                      <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="link" title="Link"><i class="bi bi-link-45deg fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="image" title="Image"><i class="bi bi-image fs-6"></i></button>
                      <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="video" title="Video"><i class="bi bi-camera-video fs-6"></i></button>
                    </div>
                    <div class="d-flex align-items-end">
                      <textarea id="comment-input" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Start typing here... (Markdown & Task-lists supported)" maxlength="5000" rows="4" required style="resize: none; min-height: 110px; max-height: 350px; padding: 10px 14px; font-size: 1rem; line-height: 1.5;" oninput="this.style.height = ''; this.style.height = Math.max(110, this.scrollHeight) + 'px'"></textarea>
                      <button type="submit" class="btn btn-danger rounded-pill d-flex align-items-center justify-content-center m-1 flex-shrink-0 shadow-sm fw-bold text-dark" style="transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class="bi bi-send-fill fs-5 me-2"></i> Post This</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="d-flex justify-content-end align-items-center mb-4 ps-2">
              <select id="comments-sort-select" class="form-select form-select-sm w-auto bg-dark text-white border-secondary rounded-pill">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="most_replied">Most Replied</option>
              </select>
            </div>
            <div id="comments-list" class="d-flex flex-column gap-3"></div>
            <div class="text-center mt-4 mb-2 d-none" id="load-more-comments-container">
              <button class="btn btn-outline-light btn-sm px-4 rounded-pill" id="load-more-comments-btn">Load More Comments</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Media Preview Modal -->
    <div class="modal fade" id="media-preview-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen bg-black bg-opacity-75">
        <div class="modal-content bg-transparent border-0 h-100">
          <div class="modal-header border-0 justify-content-end p-3 position-absolute w-100 z-3" style="top: 0; gap: 10px;">
            <button id="media-preview-download-btn" class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: rgba(0,0,0,0.6); border: none; color: #fff;" title="Download Media"><i class="bi bi-download fs-5"></i></button>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="background-color: rgba(0,0,0,0.6); border-radius: 50%; padding: 12px;"></button>
          </div>
          <div class="modal-body text-center p-0 d-flex align-items-center justify-content-center h-100 overflow-auto" id="media-preview-body">
            <!-- Media dynamically injected here -->
          </div>
        </div>
      </div>
    </div>


    <div class="editor-overlay" id="editorOverlay">
      <!-- Single Header Bar -->
      <header class="editor-header px-2 px-sm-3 py-2 d-flex align-items-center justify-content-between gap-2 flex-nowrap overflow-x-auto" style="scrollbar-width: none;">
        <!-- Left: Back Button, Icon, Path Slash & Inline Title Rename -->
        <div class="d-flex align-items-center gap-1 gap-sm-2 text-truncate me-auto" style="min-width: 0;">
          <button class="btn btn-sm btn-outline-secondary p-1 border-0 me-1 text-light flex-shrink-0" id="closeEditorBtn" title="Back">
            <i class="bi bi-arrow-left fs-5"></i>
          </button>
          <i class="bi bi-journal-album text-warning fs-5 flex-shrink-0"></i>
          <span class="text-muted opacity-50 flex-shrink-0">/</span>
          <input type="text" id="editorTitle" class="form-control form-control-sm border-0 bg-transparent text-white fw-bold px-1 px-sm-2" placeholder="Untitled Note" style="max-width: 250px; font-size: 1.05rem; box-shadow: none;">
          <input type="hidden" id="editorNoteId">
          <input type="hidden" id="editorNoteType" value="note">
          <span id="noteSaveStatus" class="fw-bold text-info small flex-shrink-0 ms-2"></span>
        </div>

        <!-- Right: View Modes, Star & Data Dropdown -->
        <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-auto">
          <div class="d-flex align-items-center gap-1 bg-dark rounded-pill p-1 border border-secondary shadow-sm flex-shrink-0">
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold active" id="editorModeEditBtn" title="Editor"><i class="bi bi-pencil-fill me-1"></i> Edit</button>
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold d-none d-sm-inline-flex" id="editorSplitBtn" title="Split View"><i class="bi bi-columns me-1"></i> Split</button>
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold" id="editorMarkdownBtn" title="Preview"><i class="bi bi-eye-fill me-1"></i> View</button>
          </div>

          <button class="note-icon-btn flex-shrink-0" id="editorStarBtn" title="Toggle Star"><i class="bi bi-star" id="editorStarIcon"></i></button>

          <div class="position-relative flex-shrink-0 custom-opt-dropdown" id="editorDropdown">
            <button class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center gap-2 custom-opt-toggle" type="button" id="editorMoreBtn" style="border-color: rgba(255,255,255,0.2); white-space: nowrap; width: auto !important; height: 36px !important; border-radius: 50rem !important;">
              <i class="bi bi-list"></i> Menu
            </button>
            <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-secondary custom-opt-menu dropdown-menu-end" id="editorMoreMenu" style="position: absolute; right: 0; top: 100%; display: none; z-index: 1060; min-width: 220px;">
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="editorForceSaveBtn"><i class="bi bi-floppy"></i> Save Note</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="editorCopyBtn"><i class="bi bi-copy"></i> Copy Content</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="editorUndoBtn"><i class="bi bi-arrow-counterclockwise"></i> Undo</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="editorRedoBtn"><i class="bi bi-arrow-clockwise"></i> Redo</a></li>
              <li><hr class="dropdown-divider border-secondary"></li>
              <li><a class="dropdown-item text-info fw-bold d-flex align-items-center gap-2" href="#" id="editorMoveProjectBtn" data-bs-toggle="modal" data-bs-target="#project-move-modal"><i class="bi bi-arrow-left-right"></i> Move to Project...</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="editorMarkdownHelpBtn" data-bs-toggle="modal" data-bs-target="#markdown-info-modal"><i class="bi bi-info-circle"></i> Formatting Guide</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="editorDownloadModalBtn" data-bs-toggle="modal" data-bs-target="#download-note-modal"><i class="bi bi-download"></i> Download Note...</a></li>
              <li><hr class="dropdown-divider border-secondary"></li>
              <li><a class="dropdown-item text-danger d-flex align-items-center gap-2" href="#" id="editorDeleteBtn"><i class="bi bi-trash2"></i> Delete Note</a></li>
            </ul>
          </div>
        </div>
      </header>

      <!-- Rich Text Formatting Toolbar -->
      <div class="px-2 px-sm-3 py-2" style="background-color: #030303;">
        <div class="editor-toolbar d-flex flex-nowrap align-items-center gap-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #121212; border: 1px solid rgba(255,255,255,0.08); overflow-x: auto; scrollbar-width: none;">
          <!-- Category & Controls Moved to Second Header -->
          <select id="editorCategorySelect" class="form-select form-select-sm flex-shrink-0" style="width: auto; max-width: 140px; height: 36px;"></select>
          
          <button class="btn btn-sm btn-outline-success text-white rounded-pill border-0 fw-bold px-3 d-inline-flex align-items-center gap-2 shadow-sm flex-shrink-0" id="editorPresentBtn" title="Start Presentation" style="background-color: rgba(25, 135, 84, 0.2); height: 36px;">
            <i class="bi bi-play-fill fs-5"></i> Present
          </button>
          
          <button class="toolbar-btn flex-shrink-0" id="editorPipBtn" title="Pop Out PiP"><i class="bi bi-pip"></i></button>
          
          <button class="toolbar-btn flex-shrink-0" id="editorTocBtn" data-bs-toggle="offcanvas" data-bs-target="#tocOffcanvasNote" title="Table of Contents"><i class="bi bi-list-nested"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" id="editorUndoToolbarBtn" title="Undo (Ctrl+Z)"><i class="bi bi-arrow-counterclockwise"></i></button>
          <button class="toolbar-btn flex-shrink-0" id="editorRedoToolbarBtn" title="Redo (Ctrl+Y)"><i class="bi bi-arrow-clockwise"></i></button>
          
          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>
          
          <button class="toolbar-btn flex-shrink-0" id="editorFindBtn" title="Find & Replace (Ctrl+F)"><i class="bi bi-search"></i></button>
          
          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>
          
          <button class="toolbar-btn flex-shrink-0" data-md="bold" title="Bold"><i class="bi bi-type-bold"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="italic" title="Italic"><i class="bi bi-type-italic"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="heading" title="Heading"><i class="bi bi-type-h1"></i></button>
          
          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>
          
          <button class="toolbar-btn flex-shrink-0" data-md="ul" title="Bullet List"><i class="bi bi-list-ul"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="ol" title="Numbered List"><i class="bi bi-list-ol"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="task" title="Task List"><i class="bi bi-ui-checks"></i></button>
          
          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>
          
          <button class="toolbar-btn flex-shrink-0" data-md="quote" title="Blockquote"><i class="bi bi-quote"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="code" title="Code Block"><i class="bi bi-code-slash"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="table" title="Table"><i class="bi bi-table"></i></button>
          
          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>
          
          <button class="toolbar-btn flex-shrink-0" data-md="align-left" title="Align Left"><i class="bi bi-text-left"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="align-center" title="Align Center"><i class="bi bi-text-center"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="align-right" title="Align Right"><i class="bi bi-text-right"></i></button>
          
          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>
          
          <button class="toolbar-btn flex-shrink-0" data-md="link" title="Link"><i class="bi bi-link-45deg"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="image" title="Image"><i class="bi bi-image"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="video" title="Video"><i class="bi bi-camera-video"></i></button>
          <button class="toolbar-btn text-warning flex-shrink-0" data-md="mermaid" title="Mermaid Diagram"><i class="bi bi-diagram-3"></i></button>
        </div>
      </div>

      <div class="find-replace-panel" id="findReplacePanel">
        <div class="d-flex justify-content-between align-items-center mb-2 fw-bold text-white">
          <span>Find and Replace</span>
          <button class="note-icon-btn py-0 px-1" id="closeFindBtn"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="find-row pe-3">
          <i class="bi bi-search text-secondary flex-shrink-0"></i>
          <input type="text" id="findInput" placeholder="Find in text..." style="min-width: 0;" />
          <span class="text-secondary small text-end flex-shrink-0" id="findCounter" style="min-width: 45px;">0/0</span>
          <div class="d-flex flex-shrink-0 ms-1 gap-1">
            <button class="note-icon-btn py-0 px-1" id="findPrevBtn" title="Previous"><i class="bi bi-chevron-up"></i></button>
            <button class="note-icon-btn py-0 px-1" id="findNextBtn" title="Next"><i class="bi bi-chevron-down"></i></button>
          </div>
        </div>
        <div class="find-row pe-3">
          <i class="bi bi-pencil text-secondary flex-shrink-0"></i>
          <input type="text" id="replaceInput" placeholder="Replace with..." style="min-width: 0;" />
        </div>
        <div class="d-flex gap-2 mt-1">
          <button class="btn btn-sm btn-outline-light flex-grow-1" id="replaceBtn">Replace</button>
          <button class="btn btn-sm btn-outline-light flex-grow-1" id="replaceAllBtn">Replace All</button>
        </div>
      </div>

      <div class="editor-body position-relative p-0 d-flex flex-column h-100 bg-black">
        <div id="editorFloatingPresence" class="floating-presence-container"></div>
        <div id="noteSplitContainer" class="editor-split-container flex-grow-1 w-100">
          <textarea class="editor-content p-3 border-0 rounded-0" id="editorContent" placeholder="Start typing here... (Markdown & Task-lists supported)" style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; background: transparent;"></textarea>
          <div class="editor-resizer" id="noteResizer"></div>
          <div class="editor-content p-3 d-none rounded-0" id="editorMarkdownPreview" style="user-select: text; overflow-y: auto; background: var(--ytm-bg);"></div>
        </div>
      </div>

      <footer class="editor-footer">
        <div class="d-flex align-items-center gap-3 w-100">
          <span id="editorWordCount">0 words</span>
          <span id="editorCharCount">0 characters</span>
          <span id="editorDate" class="fw-bold d-none d-sm-inline ms-4 text-white"></span>
          <span id="editorReadTime" class="text-info fw-bold ms-auto"><i class="bi bi-book"></i> 0 min read</span>
        </div>
      </footer>

      <!-- TOC Offcanvas -->
      <div class="offcanvas offcanvas-end bg-dark text-light shadow" tabindex="-1" id="tocOffcanvasNote" style="width: 300px; z-index: 100000;">
        <div class="offcanvas-header border-bottom border-secondary">
          <h6 class="offcanvas-title text-uppercase text-muted fw-bold"><i class="bi bi-list-nested me-2"></i>Table of Contents</h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
          <div id="toc-list-note" class="d-flex flex-column small"></div>
        </div>
      </div>
    </div>

    <div class="editor-overlay" id="blogEditorOverlay">
      <!-- Single Header Bar -->
      <header class="editor-header px-2 px-sm-3 py-2 d-flex align-items-center justify-content-between gap-2 flex-nowrap overflow-x-auto" style="scrollbar-width: none;">
        <!-- Left: Back Button, Icon, Path Slash & Inline Title Rename -->
        <div class="d-flex align-items-center gap-1 gap-sm-2 text-truncate me-auto" style="min-width: 0;">
          <button class="btn btn-sm btn-outline-secondary p-1 border-0 me-1 text-light flex-shrink-0" id="closeBlogEditorBtn" title="Back">
            <i class="bi bi-arrow-left fs-5"></i>
          </button>
          <i class="bi bi-journal-richtext text-danger fs-5 flex-shrink-0"></i>
          <span class="text-muted opacity-50 flex-shrink-0">/</span>
          <input type="text" id="blogEditorTitle" class="form-control form-control-sm border-0 bg-transparent text-white fw-bold px-1 px-sm-2" placeholder="Blog Title" style="max-width: 250px; font-size: 1.05rem; box-shadow: none;">
          <input type="hidden" id="blogEditorId">
          <input type="hidden" id="blogEditorPublicId">
          <span id="blogSaveStatus" class="fw-bold text-info small flex-shrink-0 ms-2"></span>
        </div>

        <!-- Right: View Modes & Data Dropdown -->
        <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-auto">
          <div class="d-flex align-items-center gap-1 bg-dark rounded-pill p-1 border border-secondary shadow-sm flex-shrink-0">
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold active" id="blogEditorModeEditBtn" title="Editor"><i class="bi bi-pencil-fill me-1"></i> Edit</button>
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold d-none d-sm-inline-flex" id="blogEditorSplitBtn" title="Split View"><i class="bi bi-columns me-1"></i> Split</button>
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold" id="blogEditorMarkdownBtn" title="Preview"><i class="bi bi-eye-fill me-1"></i> View</button>
          </div>

          <div class="position-relative flex-shrink-0 custom-opt-dropdown" id="blogEditorDropdown">
            <button class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center gap-2 custom-opt-toggle" type="button" id="blogEditorMoreBtn" style="border-color: rgba(255,255,255,0.2); white-space: nowrap; width: auto !important; height: 36px !important; border-radius: 50rem !important;">
              <i class="bi bi-list"></i> Menu
            </button>
            <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-secondary custom-opt-menu dropdown-menu-end" id="blogEditorMoreMenu" style="position: absolute; right: 0; top: 100%; display: none; z-index: 1060; min-width: 220px;">
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="blogEditorForceSaveBtn"><i class="bi bi-floppy"></i> Save Blog</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="blogEditorCopyBtn"><i class="bi bi-copy"></i> Copy Content</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="blogEditorUndoBtn"><i class="bi bi-arrow-counterclockwise"></i> Undo</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="blogEditorRedoBtn"><i class="bi bi-arrow-clockwise"></i> Redo</a></li>
              <li><hr class="dropdown-divider border-secondary"></li>
              <li><a class="dropdown-item text-info fw-bold d-flex align-items-center gap-2" href="#" id="blogEditorMoveProjectBtn" data-bs-toggle="modal" data-bs-target="#project-move-modal"><i class="bi bi-arrow-left-right"></i> Move to Project...</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#markdown-info-modal"><i class="bi bi-info-circle"></i> Formatting Guide</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#download-note-modal"><i class="bi bi-download"></i> Download Blog...</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="blogEditorViewBtn"><i class="bi bi-box-arrow-up-right text-info"></i> View Published Blog</a></li>
              <li><hr class="dropdown-divider border-secondary"></li>
              <li><a class="dropdown-item text-danger d-flex align-items-center gap-2" href="#" id="blogEditorDeleteBtn"><i class="bi bi-trash2"></i> Delete Blog</a></li>
            </ul>
          </div>
        </div>
      </header>

      <!-- Rich Text Formatting Toolbar -->
      <div class="px-2 px-sm-3 py-2" style="background-color: #030303;" id="blogEditorToolbar">
        <div class="editor-toolbar d-flex flex-nowrap align-items-center gap-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #121212; border: 1px solid rgba(255,255,255,0.08); overflow-x: auto; scrollbar-width: none;">
          <!-- Status, Category & Controls Moved to Second Header -->
          <select id="blogEditorStatusSelect" class="form-select form-select-sm flex-shrink-0" style="width: auto; max-width: 120px; height: 36px;">
            <option value="private">Draft</option>
            <option value="public">Published</option>
          </select>

          <select id="blogEditorCategorySelect" class="form-select form-select-sm flex-shrink-0" style="width: auto; max-width: 130px; height: 36px;"></select>

          <button class="btn btn-sm btn-outline-success text-white rounded-pill border-0 fw-bold px-3 d-inline-flex align-items-center gap-2 shadow-sm flex-shrink-0" id="blogEditorPresentBtn" title="Start Presentation" style="background-color: rgba(25, 135, 84, 0.2); height: 36px;">
            <i class="bi bi-play-fill fs-5"></i> Present
          </button>

          <button class="toolbar-btn flex-shrink-0" id="blogEditorPipBtn" title="Pop Out PiP"><i class="bi bi-pip"></i></button>

          <button class="toolbar-btn flex-shrink-0" id="blogEditorTocBtn" data-bs-toggle="offcanvas" data-bs-target="#tocOffcanvasBlog" title="Table of Contents"><i class="bi bi-list-nested"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" id="blogEditorUndoToolbarBtn" title="Undo (Ctrl+Z)"><i class="bi bi-arrow-counterclockwise"></i></button>
          <button class="toolbar-btn flex-shrink-0" id="blogEditorRedoToolbarBtn" title="Redo (Ctrl+Y)"><i class="bi bi-arrow-clockwise"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" id="blogEditorFindBtn" title="Find & Replace (Ctrl+F)"><i class="bi bi-search"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" data-md="bold" title="Bold"><i class="bi bi-type-bold"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="italic" title="Italic"><i class="bi bi-type-italic"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="heading" title="Heading"><i class="bi bi-type-h1"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" data-md="ul" title="Bullet List"><i class="bi bi-list-ul"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="ol" title="Numbered List"><i class="bi bi-list-ol"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="task" title="Task List"><i class="bi bi-ui-checks"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" data-md="quote" title="Blockquote"><i class="bi bi-quote"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="code" title="Code Block"><i class="bi bi-code-slash"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="table" title="Table"><i class="bi bi-table"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" data-md="align-left" title="Align Left"><i class="bi bi-text-left"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="align-center" title="Align Center"><i class="bi bi-text-center"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="align-right" title="Align Right"><i class="bi bi-text-right"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" data-md="link" title="Link"><i class="bi bi-link-45deg"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="image" title="Image"><i class="bi bi-image"></i></button>
          <button class="toolbar-btn flex-shrink-0" data-md="video" title="Video"><i class="bi bi-camera-video"></i></button>
          <button class="toolbar-btn text-warning flex-shrink-0" data-md="mermaid" title="Mermaid Diagram"><i class="bi bi-diagram-3"></i></button>
        </div>
      </div>

      <div class="find-replace-panel" id="blogFindReplacePanel">
        <div class="d-flex justify-content-between align-items-center mb-2 fw-bold text-white">
          <span>Find and Replace</span>
          <button class="note-icon-btn py-0 px-1" id="closeBlogFindBtn"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="find-row pe-3">
          <i class="bi bi-search text-secondary flex-shrink-0"></i>
          <input type="text" id="blogFindInput" placeholder="Find in blog..." style="min-width: 0;" />
          <span class="text-secondary small text-end flex-shrink-0" id="blogFindCounter" style="min-width: 45px;">0/0</span>
          <div class="d-flex flex-shrink-0 ms-1 gap-1">
            <button class="note-icon-btn py-0 px-1" id="blogFindPrevBtn" title="Previous"><i class="bi bi-chevron-up"></i></button>
            <button class="note-icon-btn py-0 px-1" id="blogFindNextBtn" title="Next"><i class="bi bi-chevron-down"></i></button>
          </div>
        </div>
        <div class="find-row pe-3">
          <i class="bi bi-pencil text-secondary flex-shrink-0"></i>
          <input type="text" id="blogReplaceInput" placeholder="Replace with..." style="min-width: 0;" />
        </div>
        <div class="d-flex gap-2 mt-1">
          <button class="btn btn-sm btn-outline-light flex-grow-1" id="blogReplaceBtn">Replace</button>
          <button class="btn btn-sm btn-outline-light flex-grow-1" id="blogReplaceAllBtn">Replace All</button>
        </div>
      </div>

      <div class="editor-body position-relative p-0 d-flex flex-column h-100 bg-black">
        <div id="blogFloatingPresence" class="floating-presence-container"></div>
        <div id="blogSplitContainer" class="editor-split-container flex-grow-1 w-100">
          <textarea class="editor-content p-3 border-0 rounded-0" id="blogEditorContent" placeholder="Write your amazing blog here... (Markdown supported)" style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; background: transparent;"></textarea>
          <div class="editor-resizer" id="blogResizer"></div>
          <div class="editor-content p-3 d-none rounded-0" id="blogEditorMarkdownPreview" style="user-select: text; overflow-y: auto; background: var(--ytm-bg);"></div>
        </div>
      </div>

      <footer class="editor-footer">
        <div class="d-flex align-items-center gap-3 w-100">
          <span id="blogEditorWordCount">0 words</span>
          <span id="blogEditorCharCount">0 characters</span>
          <span id="blogEditorDate" class="fw-bold d-none d-sm-inline ms-4 text-white"></span>
          <span id="blogEditorReadTime" class="text-info fw-bold ms-auto"><i class="bi bi-book"></i> 0 min read</span>
        </div>
      </footer>

      <!-- TOC Offcanvas for Blogs -->
      <div class="offcanvas offcanvas-end bg-dark text-light shadow" tabindex="-1" id="tocOffcanvasBlog" style="width: 300px; z-index: 100000;">
        <div class="offcanvas-header border-bottom border-secondary">
          <h6 class="offcanvas-title text-uppercase text-muted fw-bold"><i class="bi bi-list-nested me-2"></i>Table of Contents</h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
          <div id="toc-list-blog" class="d-flex flex-column small"></div>
        </div>
      </div>
    </div>

    <div class="editor-overlay" id="taskEditorOverlay">
      <!-- Single Header Bar -->
      <header class="editor-header px-2 px-sm-3 py-2 d-flex align-items-center justify-content-between gap-2 flex-nowrap overflow-x-auto" style="scrollbar-width: none;">
        <!-- Left: Back Button, Icon, Path Slash & Inline Title Rename -->
        <div class="d-flex align-items-center gap-1 gap-sm-2 text-truncate me-auto" style="min-width: 0;">
          <button class="btn btn-sm btn-outline-secondary p-1 border-0 me-1 text-light flex-shrink-0" id="closeTaskEditorBtn" title="Back">
            <i class="bi bi-arrow-left fs-5"></i>
          </button>
          <i class="bi bi-check2-square text-success fs-5 flex-shrink-0"></i>
          <span class="text-muted opacity-50 flex-shrink-0">/</span>
          <input type="text" id="taskEditorTitle" class="form-control form-control-sm border-0 bg-transparent text-white fw-bold px-1 px-sm-2" placeholder="Task List Title" style="max-width: 250px; font-size: 1.05rem; box-shadow: none;">
          <input type="hidden" id="taskEditorId">
          <span id="taskSaveStatus" class="fw-bold text-info small flex-shrink-0 ms-2"></span>
        </div>

        <!-- Right: View Modes, Star & Data Dropdown -->
        <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-auto">
          <div class="d-flex align-items-center gap-1 bg-dark rounded-pill p-1 border border-secondary shadow-sm flex-shrink-0">
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold active" id="taskEditorModeEditBtn" title="Editor"><i class="bi bi-pencil-fill me-1"></i> Edit</button>
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold d-none d-sm-inline-flex" id="taskEditorSplitBtn" title="Split View"><i class="bi bi-columns me-1"></i> Split</button>
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill border-0 px-3 fw-bold" id="taskEditorMarkdownBtn" title="Preview"><i class="bi bi-eye-fill me-1"></i> View</button>
          </div>

          <button class="note-icon-btn flex-shrink-0" id="taskEditorStarBtn" title="Toggle Star"><i class="bi bi-star" id="taskEditorStarIcon"></i></button>

          <div class="position-relative flex-shrink-0 custom-opt-dropdown" id="taskEditorDropdown">
            <button class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center gap-2 custom-opt-toggle" type="button" id="taskEditorMoreBtn" style="border-color: rgba(255,255,255,0.2); white-space: nowrap; width: auto !important; height: 36px !important; border-radius: 50rem !important;">
              <i class="bi bi-list"></i> Menu
            </button>
            <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-secondary custom-opt-menu dropdown-menu-end" id="taskEditorMoreMenu" style="position: absolute; right: 0; top: 100%; display: none; z-index: 1060; min-width: 220px;">
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="taskEditorForceSaveBtn"><i class="bi bi-floppy"></i> Save List</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="taskEditorCopyBtn"><i class="bi bi-copy"></i> Copy Tasks</a></li>
              <li><hr class="dropdown-divider border-secondary"></li>
              <li><a class="dropdown-item text-info fw-bold d-flex align-items-center gap-2" href="#" id="taskMoveProjectBtn" data-bs-toggle="modal" data-bs-target="#project-move-modal"><i class="bi bi-arrow-left-right"></i> Move to Project...</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#markdown-info-modal"><i class="bi bi-info-circle"></i> Formatting Guide</a></li>
              <li><a class="dropdown-item text-light d-flex align-items-center gap-2" href="#" id="taskEditorDownloadModalBtn" data-bs-toggle="modal" data-bs-target="#download-note-modal"><i class="bi bi-download"></i> Download Task List...</a></li>
              <li><hr class="dropdown-divider border-secondary"></li>
              <li><a class="dropdown-item text-danger d-flex align-items-center gap-2" href="#" id="taskEditorDeleteBtn"><i class="bi bi-trash2"></i> Delete List</a></li>
            </ul>
          </div>
        </div>
      </header>

      <!-- Rich Text / Task Toolbar -->
      <div class="px-2 px-sm-3 py-2" style="background-color: #030303;" id="taskEditorToolbar">
        <div class="editor-toolbar d-flex flex-nowrap align-items-center gap-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #121212; border: 1px solid rgba(255,255,255,0.08); overflow-x: auto; scrollbar-width: none;">
          <select id="taskEditorCategorySelect" class="form-select form-select-sm flex-shrink-0" style="width: auto; max-width: 140px; height: 36px;"></select>

          <button class="toolbar-btn flex-shrink-0" id="taskEditorPipBtn" title="Pop Out PiP"><i class="bi bi-pip"></i></button>
          <button class="toolbar-btn flex-shrink-0" id="taskEditorTocBtn" data-bs-toggle="offcanvas" data-bs-target="#tocOffcanvasTask" title="Table of Contents"><i class="bi bi-list-nested"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="toolbar-btn flex-shrink-0" id="taskEditorFindBtn" title="Find in Tasks (Ctrl+F)"><i class="bi bi-search"></i></button>

          <div class="vr mx-1 bg-secondary opacity-25 flex-shrink-0" style="width: 2px; min-height: 24px;"></div>

          <button class="btn btn-sm btn-danger rounded-pill px-3 py-1 fw-bold text-white d-inline-flex align-items-center gap-1 shadow-sm flex-shrink-0" id="addTaskItemBtnToolbar" title="Add New Item">
            <i class="bi bi-plus-lg"></i> Add Item
          </button>
        </div>
      </div>

      <div class="find-replace-panel" id="taskFindReplacePanel">
        <div class="d-flex justify-content-between align-items-center mb-2 fw-bold text-white">
          <span>Find and Replace</span>
          <button class="note-icon-btn py-0 px-1" id="closeTaskFindBtn"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="find-row pe-3">
          <i class="bi bi-search text-secondary flex-shrink-0"></i>
          <input type="text" id="taskFindInput" placeholder="Find in tasks..." style="min-width: 0;" />
          <span class="text-secondary small text-end flex-shrink-0" id="taskFindCounter" style="min-width: 45px;">0/0</span>
          <div class="d-flex flex-shrink-0 ms-1 gap-1">
            <button class="note-icon-btn py-0 px-1" id="taskFindPrevBtn" title="Previous"><i class="bi bi-chevron-up"></i></button>
            <button class="note-icon-btn py-0 px-1" id="taskFindNextBtn" title="Next"><i class="bi bi-chevron-down"></i></button>
          </div>
        </div>
        <div class="find-row pe-3">
          <i class="bi bi-pencil text-secondary flex-shrink-0"></i>
          <input type="text" id="taskReplaceInput" placeholder="Replace with..." style="min-width: 0;" />
        </div>
        <div class="d-flex gap-2 mt-1">
          <button class="btn btn-sm btn-outline-light flex-grow-1" id="taskReplaceBtn">Replace</button>
          <button class="btn btn-sm btn-outline-light flex-grow-1" id="taskReplaceAllBtn">Replace All</button>
        </div>
      </div>

      <div class="editor-body position-relative p-0 d-flex flex-column h-100 bg-black">
        <div id="taskFloatingPresence" class="floating-presence-container"></div>
        <div id="taskSplitContainer" class="editor-split-container flex-grow-1 w-100">
          <div class="editor-content p-3 border-0 rounded-0 d-flex flex-column h-100" id="taskEditorContentArea" style="background: transparent;">
            <div class="task-list-container flex-grow-1 overflow-auto pe-2" id="taskItemsContainer"></div>
            <button class="btn btn-outline-danger w-100 mt-3 fw-bold flex-shrink-0" id="addTaskItemBtn" style="border-style: dashed; padding: 12px; border-radius: 12px;"><i class="bi bi-plus-lg"></i> Add New Task</button>
          </div>
          <div class="editor-resizer" id="taskResizer"></div>
          <div class="editor-content p-3 d-none rounded-0" id="taskMarkdownPreview" style="user-select: text; overflow-y: auto; background: var(--ytm-bg);"></div>
        </div>
      </div>

      <footer class="editor-footer">
        <div class="d-flex align-items-center gap-3 w-100">
          <span id="taskEditorTotalCount">0 items</span>
          <span id="taskEditorCompletedCount" class="text-success fw-bold">0 completed</span>
          <span id="taskEditorDate" class="fw-bold d-none d-sm-inline ms-4 text-white"></span>
          <span id="taskEditorProgressBadge" class="text-info fw-bold ms-auto"><i class="bi bi-check2-circle"></i> 0% Done</span>
        </div>
      </footer>

      <!-- TOC Offcanvas for Tasks -->
      <div class="offcanvas offcanvas-end bg-dark text-light shadow" tabindex="-1" id="tocOffcanvasTask" style="width: 300px; z-index: 100000;">
        <div class="offcanvas-header border-bottom border-secondary">
          <h6 class="offcanvas-title text-uppercase text-muted fw-bold"><i class="bi bi-list-nested me-2"></i>Task Sections</h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
          <div id="toc-list-task" class="d-flex flex-column small"></div>
        </div>
      </div>
    </div>

    <div class="selection-bar" id="selectionBarNotes">
      <div class="d-flex align-items-center gap-2">
        <button class="note-icon-btn" id="toggleSelectAllNotesBtn" title="Select / Unselect All"><i class="bi bi-check-all fs-5"></i></button>
        <span class="fw-bold fs-6 ms-2" id="selectionCountNotes">0</span>
      </div>
      <div class="d-flex gap-2">
        <button class="note-icon-btn" id="bulkDownloadNotesBtn" title="Download ZIP"><i class="bi bi-download fs-5"></i></button>
        <button class="note-icon-btn text-danger" id="bulkDeleteNotesBtn" title="Delete Selected"><i class="bi bi-trash2 fs-5"></i></button>
        <button class="note-icon-btn" id="cancelSelectNotesBtn" title="Cancel"><i class="bi bi-x-lg fs-5"></i></button>
      </div>
    </div>

    <div class="selection-bar" id="selectionBarBlogs">
      <div class="d-flex align-items-center gap-2">
        <button class="note-icon-btn" id="toggleSelectAllBlogsBtn" title="Select / Unselect All"><i class="bi bi-check-all fs-5"></i></button>
        <span class="fw-bold fs-6 ms-2" id="selectionCountBlogs">0</span>
      </div>
      <div class="d-flex gap-2">
        <button class="note-icon-btn" id="bulkDownloadBlogsBtn" title="Download ZIP"><i class="bi bi-download fs-5"></i></button>
        <button class="note-icon-btn text-danger" id="bulkDeleteBlogsBtn" title="Delete Selected"><i class="bi bi-trash2 fs-5"></i></button>
        <button class="note-icon-btn" id="cancelSelectBlogsBtn" title="Cancel"><i class="bi bi-x-lg fs-5"></i></button>
      </div>
    </div>

    <input type="file" id="fileImportTxt" accept=".txt" multiple style="display: none;" />
    <input type="file" id="fileImportJson" accept=".json" style="display: none;" />
    <input type="file" id="fileImportTasks" accept=".json" style="display: none;" />
    <input type="file" id="fileImportTxtBlogs" accept=".txt" multiple style="display: none;" />
    <input type="file" id="fileImportJsonBlogs" accept=".json" style="display: none;" />

    <div class="modal fade" id="bbcode-info-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white"><i class="bi bi-info-circle text-info me-2"></i> Formatting Help</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-light">
            <p class="text-secondary small mb-3">You can use special formatting in your text!</p>
            <ul class="list-group list-group-flush rounded">
              <li class="list-group-item bg-dark text-white border-secondary">
                <strong>Auto Links:</strong><br>
                <span class="text-secondary small">URLs like <code>phpmusic.rf.gd</code> or <code>https://example.com</code> will automatically become clickable links.</span>
              </li>
              <li class="list-group-item bg-dark text-white border-secondary">
                <strong>Manual Links:</strong><br>
                <span class="text-secondary small">Use <code>[url] yourlink.com [/url]</code> to explicitly create a clickable link.</span>
              </li>
              <li class="list-group-item bg-dark text-white border-secondary">
                <strong>Images:</strong><br>
                <span class="text-secondary small">Use <code>[img] yourimage.jpg [/img]</code> to embed images safely without immediate bandwidth drain.</span>
              </li>
              <li class="list-group-item bg-dark text-white border-secondary">
                <strong>Mentions:</strong><br>
                <span class="text-secondary small">Use <code>@Username</code> (without spaces) to link directly to a user's profile.</span>
              </li>
              <li class="list-group-item bg-dark text-white border-secondary">
                <strong>Video Embeds:</strong><br>
                <span class="text-secondary small">Use <code>[video] youtube_or_mp4_link [/video]</code> to securely embed playable videos.</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="markdown-info-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white"><i class="bi bi-info-circle-fill text-danger me-2"></i> Guide</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-light">
            <p class="text-secondary small mb-3">Use these markdown formats to style your personal notes. Toggle the <i class="bi bi-markdown"></i> button in the editor to see the preview!</p>
            <div class="table-responsive">
              <table class="table table-dark table-bordered table-striped text-white small m-0">
                <thead>
                  <tr>
                    <th>Element</th>
                    <th>Syntax</th>
                    <th>Example Preview</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>Headings</strong></td>
                    <td><code># H1<br>## H2<br>### H3</code></td>
                    <td><span class="fs-5 fw-bold">H1</span><br><span class="fs-6 fw-bold">H2</span></td>
                  </tr>
                  <tr>
                    <td><strong>Bold</strong></td>
                    <td><code>**bold text**</code></td>
                    <td><strong>bold text</strong></td>
                  </tr>
                  <tr>
                    <td><strong>Italic</strong></td>
                    <td><code>*italicized text*</code></td>
                    <td><em>italicized text</em></td>
                  </tr>
                  <tr>
                    <td><strong>Strikethrough</strong></td>
                    <td><code>~~strikethrough~~</code></td>
                    <td><del>strikethrough</del></td>
                  </tr>
                  <tr>
                    <td><strong>Blockquote</strong></td>
                    <td><code>> blockquote</code></td>
                    <td><blockquote class="border-start border-4 border-danger ps-2 m-0 text-secondary">blockquote</blockquote></td>
                  </tr>
                  <tr>
                    <td><strong>Ordered List</strong></td>
                    <td><code>1. First item<br>2. Second item</code></td>
                    <td><ol class="mb-0 ps-3"><li>First item</li><li>Second item</li></ol></td>
                  </tr>
                  <tr>
                    <td><strong>Unordered List</strong></td>
                    <td><code>- First item<br>- Second item</code></td>
                    <td><ul class="mb-0 ps-3"><li>First item</li><li>Second item</li></ul></td>
                  </tr>
                  <tr>
                    <td><strong>Task List</strong></td>
                    <td><code>- [ ] To do<br>- [x] Done</code></td>
                    <td><ul class="list-unstyled mb-0"><li><i class="bi bi-square"></i> To do</li><li><i class="bi bi-check2-square text-success"></i> Done</li></ul></td>
                  </tr>
                  <tr>
                    <td><strong>Code</strong></td>
                    <td><code>`code`</code></td>
                    <td><code class="bg-dark p-1 rounded">code</code></td>
                  </tr>
                  <tr>
                    <td><strong>Code Block</strong></td>
                    <td><code>```<br>code block<br>```</code></td>
                    <td><pre class="m-0 bg-dark p-1 rounded">code block</pre></td>
                  </tr>
                  <tr>
                    <td><strong>Link</strong></td>
                    <td><code>[title](https://url.com)</code></td>
                    <td><a href="#" class="text-info text-decoration-none">title</a></td>
                  </tr>
                  <tr>
                    <td><strong>Image</strong></td>
                    <td><code>![alt](https://img.url)</code></td>
                    <td><i class="bi bi-image"></i> image</td>
                  </tr>
                  <tr>
                    <td><strong>Table</strong></td>
                    <td><pre class="m-0">| Col | Col |
| --- | --- |
| Val | Val |</pre></td>
                    <td>
                      <table class="table table-sm table-bordered m-0 text-white" style="background: transparent;">
                        <tr><th class="bg-dark text-white">Col</th><th class="bg-dark text-white">Col</th></tr>
                        <tr><td>Val</td><td>Val</td></tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Align Left</strong></td>
                    <td><code>&lt;div style="text-align: left;"&gt;Left&lt;/div&gt;</code></td>
                    <td><div style="text-align: left;" class="m-0">Left</div></td>
                  </tr>
                  <tr>
                    <td><strong>Align Center</strong></td>
                    <td><code>&lt;div style="text-align: center;"&gt;Center&lt;/div&gt;</code></td>
                    <td><div style="text-align: center;" class="m-0">Center</div></td>
                  </tr>
                  <tr>
                    <td><strong>Align Right</strong></td>
                    <td><code>&lt;div style="text-align: right;"&gt;Right&lt;/div&gt;</code></td>
                    <td><div style="text-align: right;" class="m-0">Right</div></td>
                  </tr>
                  <tr>
                    <td><strong>Resize Image</strong></td>
                    <td><code>&lt;img src="url" width="50%" height="auto"&gt;</code></td>
                    <td><i class="bi bi-image"></i> Resized Image</td>
                  </tr>
                  <tr>
                    <td><strong>Video / YouTube</strong></td>
                    <td><code>&lt;video src="..."&gt;</code> or <code>&lt;iframe&gt;</code></td>
                    <td><i class="bi bi-camera-video"></i> Embedded Video</td>
                  </tr>
                  <tr>
                    <td><strong>Horizontal Rule</strong></td>
                    <td><code>---</code></td>
                    <td><hr class="m-0 border-secondary"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="download-note-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white"><i class="bi bi-cloud-arrow-down-fill text-danger me-2"></i> Download</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <label class="form-label text-secondary small fw-bold mb-2">SELECT FORMAT</label>
            <div style="position: relative; display: flex; align-items: center; margin-bottom: 1.5rem;">
              <select id="dlFormat" class="form-control bg-dark text-white border-secondary" style="appearance: none; -webkit-appearance: none; padding-right: 48px; cursor: pointer; z-index: 1; height: 45px; font-weight: 500;">
                <option value="txt">Plain Text (.txt)</option>
                <option value="md">Markdown (.md)</option>
                <option value="html">HTML Document (.html)</option>
                <option value="pdf">PDF Document (.pdf)</option>
              </select>
              <i class="bi bi-chevron-down text-secondary" style="position: absolute; right: 16px; pointer-events: none; font-size: 1.2rem; z-index: 2;"></i>
            </div>
            <button type="button" class="btn btn-danger w-100 fw-bold" id="confirm-download-note-btn" style="height: 45px;">Download</button>
            <div class="progress mt-3 d-none" id="download-progress-container" style="height: 16px; background-color: #000; border-radius: 8px; border: 1px solid #333;">
              <div id="download-progress-bar" class="progress-bar bg-danger progress-bar-striped progress-bar-animated fw-bold" role="progressbar" style="width: 0%; font-size: 0.75rem;">0%</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="calendar-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg" style="background-color: var(--ytm-surface); border: 1px solid #404040; border-radius: 16px;">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-calendar3 text-danger me-2"></i> Time & Date</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-4">
            <div class="p-3 mb-4 rounded-4" style="background: linear-gradient(135deg, rgba(255,0,0,0.1), rgba(0,0,0,0.2)); border: 1px solid rgba(255,255,255,0.05);">
              <h2 id="calendar-time-display" class="fw-bold text-white mb-1" style="font-size: clamp(2rem, 6vw, 3.2rem); font-family: 'Roboto', sans-serif; letter-spacing: 1px; text-shadow: 0 4px 12px rgba(0,0,0,0.5);">00:00:00</h2>
              <p id="calendar-date-display" class="text-secondary fs-5 mb-0 fw-medium"></p>
            </div>
            
            <div id="calendar-grid" class="bg-dark rounded-4 p-3 border border-secondary shadow-sm mb-4" style="overflow: hidden;">
              <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                <button class="btn btn-sm btn-outline-secondary border-0 rounded-circle" id="cal-prev-month" style="width: 35px; height: 35px;"><i class="bi bi-chevron-left"></i></button>
                <h5 id="cal-month-year" class="mb-0 text-white fw-bold text-uppercase" style="letter-spacing: 1px;"></h5>
                <button class="btn btn-sm btn-outline-secondary border-0 rounded-circle" id="cal-next-month" style="width: 35px; height: 35px;"><i class="bi bi-chevron-right"></i></button>
              </div>
              <div class="d-grid mb-2" style="grid-template-columns: repeat(7, 1fr); gap: 4px; text-align: center;">
                <div class="text-danger small fw-bold">Su</div>
                <div class="text-secondary small fw-bold">Mo</div>
                <div class="text-secondary small fw-bold">Tu</div>
                <div class="text-secondary small fw-bold">We</div>
                <div class="text-secondary small fw-bold">Th</div>
                <div class="text-secondary small fw-bold">Fr</div>
                <div class="text-info small fw-bold">Sa</div>
              </div>
              <div id="cal-days-grid" class="d-grid" style="grid-template-columns: repeat(7, 1fr); gap: 4px; text-align: center; min-height: 210px; align-items: center;">
              </div>
            </div>
            
            <div class="d-flex flex-column gap-2">
              <div class="d-flex gap-2">
                <input type="date" id="cal-jump-date" class="form-control bg-dark text-white border-secondary rounded-pill px-3" title="Jump to Date">
                <button class="btn btn-outline-light fw-bold rounded-pill px-3 text-nowrap" id="cal-today-btn"><i class="bi bi-calendar-event me-1"></i> Today</button>
              </div>
              <button class="btn btn-danger fw-bold rounded-pill w-100 mt-2 py-2" id="cal-search-date-btn" data-bs-dismiss="modal"><i class="bi bi-search me-1"></i> Search Songs by Selected Date</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="login-modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen auth-modal-fullscreen">
        <div class="modal-content auth-modal-content">
          <div class="auth-ambient-glow"></div>
          <div class="auth-mountain-backdrop"></div>

          <div class="auth-container-shell">
            <div class="auth-glass-card position-relative">
              <!-- Close Button Inside Card -->
              <button type="button" class="auth-card-close-btn" data-bs-dismiss="modal" aria-label="Close" title="Close">
                <i class="bi bi-x-lg"></i>
              </button>

              <!-- Left Welcome Banner (Desktop Only) -->
              <div class="auth-left-banner d-none d-md-flex">
                <div class="auth-brand-badge">
                  <i class="bi bi-music-note-beamed"></i> PHP Music
                </div>
                <h2 class="auth-banner-title">Welcome<br>to signin</h2>
                <p class="auth-banner-sub">Sign in to continue your streaming experience</p>

                <div class="auth-switch-box">
                  <div class="auth-switch-label">Don't have an account?</div>
                  <div class="d-flex align-items-center justify-content-center gap-2">
                    <button type="button" class="auth-pill-btn" data-bs-dismiss="modal">
                      <i class="bi bi-chevron-left me-1"></i> back
                    </button>
                    <button type="button" class="auth-pill-btn" data-bs-toggle="modal" data-bs-target="#register-modal" data-bs-dismiss="modal">
                      Sign up
                    </button>
                  </div>
                </div>

                <div class="mt-auto pt-4">
                  <p class="auth-terms-text">
                    Having trouble with your <a href="#" data-bs-toggle="modal" data-bs-target="#forgot-password-modal" data-bs-dismiss="modal">account</a>?
                  </p>
                </div>
              </div>

              <!-- Right Form Section (Mobile & Desktop) -->
              <div class="auth-right-form">
                <!-- Mobile Header (Mobile Only) -->
                <div class="d-md-none text-center mb-3">
                  <div class="auth-brand-badge mb-2">
                    <i class="bi bi-music-note-beamed"></i> PHP Music
                  </div>
                  <h3 class="fw-bold text-white mb-1" style="font-size: 1.45rem;">Welcome to signin</h3>
                  <p class="text-white-50 small mb-0">Sign in to continue</p>
                </div>

                <!-- Desktop Header (Desktop Only) -->
                <div class="auth-form-header pe-4 d-none d-md-flex">
                  <h3 class="auth-form-title">Sign In</h3>
                </div>

                <form id="login-form">
                  <div class="auth-floating-group">
                    <input type="email" class="form-control" id="login-email" placeholder=" " required maxlength="50">
                    <label for="login-email">Email address</label>
                    <span class="auth-input-action"><i class="bi bi-envelope"></i></span>
                  </div>

                  <div class="auth-floating-group">
                    <input type="password" class="form-control" id="login-password" placeholder=" " required>
                    <label for="login-password">Password</label>
                    <button type="button" class="auth-input-action" onclick="const p = document.getElementById('login-password'); p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('i').classList.toggle('bi-eye'); this.querySelector('i').classList.toggle('bi-eye-slash');" title="Show / Hide Password">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>

                  <button type="submit" class="auth-btn-submit">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                  </button>

                  <!-- Mobile Switch Box (Mobile Only) -->
                  <div class="d-md-none text-center mt-3 pt-3 border-top border-secondary border-opacity-25">
                    <p class="text-white-50 small mb-2">Don't have an account?</p>
                    <div class="d-flex align-items-center justify-content-center gap-2">
                      <button type="button" class="auth-pill-btn" data-bs-dismiss="modal">
                        <i class="bi bi-chevron-left me-1"></i> back
                      </button>
                      <button type="button" class="auth-pill-btn" data-bs-toggle="modal" data-bs-target="#register-modal" data-bs-dismiss="modal">
                        Sign up
                      </button>
                    </div>
                  </div>

                  <div class="auth-footer-help">
                    <a href="#" class="auth-help-link" data-bs-toggle="modal" data-bs-target="#forgot-password-modal" data-bs-dismiss="modal">
                      <i class="bi bi-key-fill text-warning"></i> Forgot password?
                    </a>
                    <a href="#" class="auth-help-link" data-bs-toggle="modal" data-bs-target="#appeal-ban-modal" data-bs-dismiss="modal">
                      <i class="bi bi-shield-exclamation text-danger"></i> Appeal ban
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="register-modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen auth-modal-fullscreen">
        <div class="modal-content auth-modal-content">
          <div class="auth-ambient-glow"></div>
          <div class="auth-mountain-backdrop"></div>

          <div class="auth-container-shell">
            <div class="auth-glass-card position-relative">
              <!-- Close Button Inside Card -->
              <button type="button" class="auth-card-close-btn" data-bs-dismiss="modal" aria-label="Close" title="Close">
                <i class="bi bi-x-lg"></i>
              </button>

              <!-- Left Welcome Banner (Desktop Only) -->
              <div class="auth-left-banner d-none d-md-flex">
                <div class="auth-brand-badge">
                  <i class="bi bi-stars"></i> PHP Music
                </div>
                <h2 class="auth-banner-title">Welcome<br>to signup</h2>
                <p class="auth-banner-sub">Sign up to create playlists and explore music</p>

                <div class="auth-switch-box">
                  <div class="auth-switch-label">Already have an account?</div>
                  <div class="d-flex align-items-center justify-content-center gap-2">
                    <button type="button" class="auth-pill-btn" data-bs-dismiss="modal">
                      <i class="bi bi-chevron-left me-1"></i> back
                    </button>
                    <button type="button" class="auth-pill-btn" data-bs-toggle="modal" data-bs-target="#login-modal" data-bs-dismiss="modal">
                      Sign in
                    </button>
                  </div>
                </div>

                <div class="mt-auto pt-4">
                  <p class="auth-terms-text">
                    Need help getting started? <a href="#" data-bs-toggle="modal" data-bs-target="#how-to-use-modal" data-bs-dismiss="modal">User Guide</a>
                  </p>
                </div>
              </div>

              <!-- Right Form Section (Mobile & Desktop) -->
              <div class="auth-right-form">
                <!-- Mobile Header (Mobile Only) -->
                <div class="d-md-none text-center mb-3">
                  <div class="auth-brand-badge mb-2">
                    <i class="bi bi-stars"></i> PHP Music
                  </div>
                  <h3 class="fw-bold text-white mb-1" style="font-size: 1.45rem;">Welcome to signup</h3>
                  <p class="text-white-50 small mb-0">Sign up to explore & create playlists</p>
                </div>

                <!-- Desktop Header (Desktop Only) -->
                <div class="auth-form-header pe-4 d-none d-md-flex">
                  <h3 class="auth-form-title">Sign Up</h3>
                </div>

                <form id="register-form">
                  <div class="auth-floating-group">
                    <input type="text" class="form-control" id="register-artist" placeholder=" " required maxlength="40">
                    <label for="register-artist">Your name / Artist handle</label>
                    <span class="auth-input-action"><i class="bi bi-person"></i></span>
                  </div>

                  <div class="auth-floating-group">
                    <input type="email" class="form-control" id="register-email" placeholder=" " required maxlength="50">
                    <label for="register-email">Email address</label>
                    <span class="auth-input-action"><i class="bi bi-envelope"></i></span>
                  </div>

                  <div class="auth-floating-group">
                    <input type="password" class="form-control" id="register-password" placeholder=" " required minlength="6">
                    <label for="register-password">Password (min. 6 characters)</label>
                    <button type="button" class="auth-input-action" onclick="const p = document.getElementById('register-password'); p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('i').classList.toggle('bi-eye'); this.querySelector('i').classList.toggle('bi-eye-slash');" title="Show / Hide Password">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>

                  <div class="auth-terms-box">
                    <input class="auth-terms-checkbox" type="checkbox" id="register-terms-check" required>
                    <label class="auth-terms-text" for="register-terms-check">
                      By clicking this, you agree with the <a href="#" data-bs-toggle="modal" data-bs-target="#license-modal" data-bs-dismiss="modal">terms of service</a>.
                    </label>
                  </div>

                  <button type="submit" class="auth-btn-submit">
                    <i class="bi bi-person-check-fill me-2"></i> Register
                  </button>

                  <!-- Mobile Switch Box (Mobile Only) -->
                  <div class="d-md-none text-center mt-3 pt-3 border-top border-secondary border-opacity-25">
                    <p class="text-white-50 small mb-2">Already have an account?</p>
                    <div class="d-flex align-items-center justify-content-center gap-2">
                      <button type="button" class="auth-pill-btn" data-bs-dismiss="modal">
                        <i class="bi bi-chevron-left me-1"></i> back
                      </button>
                      <button type="button" class="auth-pill-btn" data-bs-toggle="modal" data-bs-target="#login-modal" data-bs-dismiss="modal">
                        Sign in
                      </button>
                    </div>
                  </div>

                  <div class="auth-footer-help justify-content-center d-none d-md-flex">
                    <span class="text-secondary small">
                      Already registered? <a href="#" class="text-white fw-bold ms-1" data-bs-toggle="modal" data-bs-target="#login-modal" data-bs-dismiss="modal">Log in here</a>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="appeal-ban-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white"><i class="bi bi-shield-exclamation text-warning me-2"></i> Appeal Account Ban</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <form id="appeal-ban-form">
              <p class="text-secondary small mb-4">If you believe your account was falsely flagged by the anti-cheat system in the Rhythm Game, please submit an appeal below.</p>
              <div class="mb-3">
                <label for="appeal-email" class="form-label text-secondary fw-bold small">EMAIL ADDRESS</label>
                <input type="email" class="form-control bg-dark text-white border-secondary" id="appeal-email" required>
              </div>
              <div class="mb-4">
                <label for="appeal-text" class="form-label text-secondary fw-bold small">REASON FOR APPEAL</label>
                <textarea class="form-control bg-dark text-white border-secondary" id="appeal-text" rows="4" required placeholder="Explain why your ban was a false positive..."></textarea>
              </div>
              <button type="submit" class="btn btn-warning text-dark fw-bold w-100 mb-3">Submit Appeal</button>
              <div class="text-center">
                <a href="#" class="text-secondary text-decoration-none small" data-bs-toggle="modal" data-bs-target="#login-modal" data-bs-dismiss="modal">Back to Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="settings-appeal-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white"><i class="bi bi-shield-exclamation text-warning me-2"></i> Appeal Game Suspension</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <form id="settings-appeal-form">
              <div class="alert alert-danger py-2 px-3 small border-danger fw-bold mb-4">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> WARNING: 3 cheat strikes will permanently ban your entire account and revoke site access.
              </div>
              <p class="text-secondary small mb-3">Submit your reasoning below to have your rhythm game access restored by an admin.</p>
              <div class="mb-4">
                <label for="settings-appeal-text" class="form-label text-secondary fw-bold small">REASON FOR APPEAL</label>
                <textarea class="form-control bg-dark text-white border-secondary" id="settings-appeal-text" rows="4" required placeholder="Explain why the anti-cheat falsely flagged you..."></textarea>
              </div>
              <button type="submit" class="btn btn-warning text-dark fw-bold w-100">Submit Appeal</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="forgot-password-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white"><i class="bi bi-key-fill text-warning me-2"></i> Reset Password</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <form id="forgot-password-form">
              <p class="text-secondary small mb-4">Enter your email address and an administrator will generate a secure reset link for you.</p>
              <div class="mb-4">
                <label for="forgot-email" class="form-label text-secondary fw-bold small">EMAIL ADDRESS</label>
                <input type="email" class="form-control bg-dark text-white border-secondary" id="forgot-email" required>
              </div>
              <button type="submit" class="btn btn-warning text-dark fw-bold w-100 mb-3">Request Reset Link</button>
              <div class="text-center">
                <a href="#" class="text-secondary text-decoration-none small" data-bs-toggle="modal" data-bs-target="#login-modal" data-bs-dismiss="modal">Back to Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="reset-password-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white"><i class="bi bi-shield-lock-fill text-success me-2"></i> Set New Password</h5>
          </div>
          <div class="modal-body p-4">
            <form id="reset-password-form">
              <input type="hidden" id="reset-token-input" value="">
              <div class="mb-4">
                <label for="reset-new-password" class="form-label text-secondary fw-bold small">NEW PASSWORD</label>
                <input type="password" class="form-control bg-dark text-white border-secondary" id="reset-new-password" required minlength="6">
              </div>
              <button type="submit" class="btn btn-success text-dark fw-bold w-100">Update Password & Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="restore-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Restore Account</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="restore-form">
              <div class="mb-3">
                <label for="restore-key" class="form-label">Backup Key</label>
                <input type="text" class="form-control" id="restore-key" required>
              </div>
              <div class="mb-3">
                <label for="restore-email" class="form-label">New Email address</label>
                <input type="email" class="form-control" id="restore-email" required>
              </div>
              <div class="mb-3">
                <label for="restore-artist" class="form-label">New Artist Name</label>
                <input type="text" class="form-control" id="restore-artist" required>
              </div>
              <div class="mb-3">
                <label for="restore-password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="restore-password" required minlength="6">
              </div>
              <button type="submit" class="btn btn-danger w-100">Restore</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="edit-comment-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-pencil-square text-danger me-2"></i>Edit Comment</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <form id="edit-comment-form">
              <input type="hidden" id="edit-comment-id">
              <div class="rich-input-container" data-target-id="edit-comment-input">
                <div class="d-flex flex-column bg-dark rounded-4 p-2 shadow-inner mb-3" style="border: 1px solid rgba(255,255,255,0.12); transition: border-color 0.3s;" onfocusin="this.style.borderColor='var(--ytm-accent)'" onfocusout="this.style.borderColor='rgba(255,255,255,0.12)'">
                  <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 mb-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #212121; border: 1px solid rgba(255,255,255,0.05);">
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="bold" title="Bold"><i class="bi bi-type-bold fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="italic" title="Italic"><i class="bi bi-type-italic fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="heading" title="Heading"><i class="bi bi-type-h1 fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ul" title="Bullet List"><i class="bi bi-list-ul fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ol" title="Numbered List"><i class="bi bi-list-ol fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="task" title="Task List"><i class="bi bi-ui-checks fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="quote" title="Blockquote"><i class="bi bi-quote fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="code" title="Code Block"><i class="bi bi-code-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="table" title="Table"><i class="bi bi-table fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-left" title="Align Left"><i class="bi bi-text-left fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-center" title="Align Center"><i class="bi bi-text-center fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-right" title="Align Right"><i class="bi bi-text-right fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="link" title="Link"><i class="bi bi-link-45deg fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="image" title="Image"><i class="bi bi-image fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="video" title="Video"><i class="bi bi-camera-video fs-6"></i></button>
                  </div>
                  <textarea id="edit-comment-input" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Start typing here... (Markdown & Task-lists supported)" maxlength="5000" required rows="8" style="resize: none; min-height: 180px; font-size: 1rem; line-height: 1.5; padding: 10px 14px;"></textarea>
                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-danger text-white fw-bold rounded-pill px-5 py-2 shadow-sm">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="edit-phpboard-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Post</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <form id="edit-phpboard-form">
              <input type="hidden" id="edit-phpboard-id">
              <input type="hidden" id="edit-phpboard-type">
              <div class="rich-input-container" data-target-id="edit-phpboard-input">
                <div class="d-flex flex-column bg-dark rounded-4 p-2 shadow-inner mb-3" style="border: 1px solid rgba(255,255,255,0.12); transition: border-color 0.3s;" onfocusin="this.style.borderColor='var(--ytm-accent)'" onfocusout="this.style.borderColor='rgba(255,255,255,0.12)'">
                  <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 mb-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #212121; border: 1px solid rgba(255,255,255,0.05);">
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="bold" title="Bold"><i class="bi bi-type-bold fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="italic" title="Italic"><i class="bi bi-type-italic fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="heading" title="Heading"><i class="bi bi-type-h1 fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ul" title="Bullet List"><i class="bi bi-list-ul fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ol" title="Numbered List"><i class="bi bi-list-ol fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="task" title="Task List"><i class="bi bi-ui-checks fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="quote" title="Blockquote"><i class="bi bi-quote fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="code" title="Code Block"><i class="bi bi-code-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="table" title="Table"><i class="bi bi-table fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-left" title="Align Left"><i class="bi bi-text-left fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-center" title="Align Center"><i class="bi bi-text-center fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-right" title="Align Right"><i class="bi bi-text-right fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="link" title="Link"><i class="bi bi-link-45deg fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="image" title="Image"><i class="bi bi-image fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="video" title="Video"><i class="bi bi-camera-video fs-6"></i></button>
                  </div>
                  <textarea id="edit-phpboard-input" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Start typing here... (Markdown & Task-lists supported)" maxlength="5000" required rows="8" style="resize: none; min-height: 180px; font-size: 1rem; line-height: 1.5; padding: 10px 14px;"></textarea>
                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-5 py-2 shadow-sm">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="edit-post-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-pencil-square text-info me-2"></i>Edit Post</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <form id="edit-post-form">
              <input type="hidden" id="edit-post-id">
              <div class="rich-input-container" data-target-id="edit-post-input">
                <div class="d-flex flex-column bg-dark rounded-4 p-2 shadow-inner mb-3" style="border: 1px solid rgba(255,255,255,0.12); transition: border-color 0.3s;" onfocusin="this.style.borderColor='#3ea6ff'" onfocusout="this.style.borderColor='rgba(255,255,255,0.12)'">
                  <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 mb-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #212121; border: 1px solid rgba(255,255,255,0.05);">
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="bold" title="Bold"><i class="bi bi-type-bold fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="italic" title="Italic"><i class="bi bi-type-italic fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="heading" title="Heading"><i class="bi bi-type-h1 fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ul" title="Bullet List"><i class="bi bi-list-ul fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ol" title="Numbered List"><i class="bi bi-list-ol fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="task" title="Task List"><i class="bi bi-ui-checks fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="quote" title="Blockquote"><i class="bi bi-quote fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="code" title="Code Block"><i class="bi bi-code-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="table" title="Table"><i class="bi bi-table fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-left" title="Align Left"><i class="bi bi-text-left fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-center" title="Align Center"><i class="bi bi-text-center fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-right" title="Align Right"><i class="bi bi-text-right fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="link" title="Link"><i class="bi bi-link-45deg fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="image" title="Image"><i class="bi bi-image fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="video" title="Video"><i class="bi bi-camera-video fs-6"></i></button>
                  </div>
                  <textarea id="edit-post-input" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Start typing here... (Markdown & Task-lists supported)" maxlength="5000" required rows="8" style="resize: none; min-height: 180px; font-size: 1rem; line-height: 1.5; padding: 10px 14px;"></textarea>
                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-info text-dark fw-bold rounded-pill px-5 py-2 shadow-sm">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="edit-blog-comment-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(25, 25, 25, 0.95); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2 px-4 pt-4">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-pencil-square text-info me-2"></i>Edit Blog Comment</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body px-4 pb-4">
            <form id="edit-blog-comment-form-modal">
              <input type="hidden" id="edit-blog-comment-id">
              <div class="rich-input-container" data-target-id="edit-blog-comment-input">
                <div class="d-flex flex-column bg-dark rounded-4 p-2 shadow-inner mb-3" style="border: 1px solid rgba(255,255,255,0.12); transition: border-color 0.3s;" onfocusin="this.style.borderColor='#3ea6ff'" onfocusout="this.style.borderColor='rgba(255,255,255,0.12)'">
                  <div class="editor-toolbar d-flex flex-wrap align-items-center gap-1 mb-2 px-3 py-2 rounded-4 shadow-sm" style="background-color: #212121; border: 1px solid rgba(255,255,255,0.05);">
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="bold" title="Bold"><i class="bi bi-type-bold fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="italic" title="Italic"><i class="bi bi-type-italic fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="strikethrough" title="Strikethrough"><i class="bi bi-type-strikethrough fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="spoiler" title="Spoiler"><i class="bi bi-eye-slash fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="heading" title="Heading"><i class="bi bi-type-h1 fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ul" title="Bullet List"><i class="bi bi-list-ul fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="ol" title="Numbered List"><i class="bi bi-list-ol fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="task" title="Task List"><i class="bi bi-ui-checks fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="quote" title="Blockquote"><i class="bi bi-quote fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="code" title="Code Block"><i class="bi bi-code-slash fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="table" title="Table"><i class="bi bi-table fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-left" title="Align Left"><i class="bi bi-text-left fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-center" title="Align Center"><i class="bi bi-text-center fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="align-right" title="Align Right"><i class="bi bi-text-right fs-6"></i></button>
                    <div class="vr bg-secondary mx-2 opacity-25" style="width: 2px; border-radius: 2px; min-height: 20px;"></div>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="link" title="Link"><i class="bi bi-link-45deg fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="image" title="Image"><i class="bi bi-image fs-6"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-secondary border-0 hover-white text-decoration-none" data-md="video" title="Video"><i class="bi bi-camera-video fs-6"></i></button>
                  </div>
                  <textarea id="edit-blog-comment-input" class="form-control bg-transparent text-white border-0 shadow-none modern-custom-scroll" placeholder="Start typing here... (Markdown & Task-lists supported)" maxlength="5000" required rows="8" style="resize: none; min-height: 180px; font-size: 1rem; line-height: 1.5; padding: 10px 14px;"></textarea>
                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-info text-dark fw-bold rounded-pill px-5 py-2 shadow-sm">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Dynamic Modals for Editing and Deleting Direct Messages -->
    <div class="modal fade" id="edit-chat-msg-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.8);">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-pencil-square text-danger me-2"></i>Edit Message</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4 pt-2">
            <form id="edit-chat-msg-form">
              <input type="hidden" id="edit-chat-msg-id">
              <div class="d-flex gap-2 mb-2">
                <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1 fw-bold" id="chat-edit-undo-btn"><i class="bi bi-arrow-counterclockwise"></i> Undo</button>
                <button type="button" class="btn btn-sm btn-outline-secondary flex-grow-1 fw-bold" id="chat-edit-redo-btn"><i class="bi bi-arrow-clockwise"></i> Redo</button>
              </div>
              <textarea id="edit-chat-msg-input" class="form-control bg-dark text-white border-secondary mb-3" rows="4" placeholder="Edit your message..." maxlength="50000" required></textarea>
              <div class="d-flex justify-content-end mb-3 mt-n2">
                <a href="#" class="text-info small text-decoration-none" data-bs-toggle="modal" data-bs-target="#bbcode-info-modal"><i class="bi bi-info-circle"></i> Formatting Help</a>
              </div>
              <button type="submit" class="btn btn-danger text-white fw-bold w-100 rounded-pill py-2 shadow-sm">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="delete-chat-msg-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040; border-radius: 16px;">
          <div class="modal-body p-4 text-center">
            <i class="bi bi-trash2-fill text-danger mb-3" style="font-size: 3rem; display: block;"></i>
            <h5 class="text-white mb-2 fw-bold">Delete Message?</h5>
            <p class="text-secondary small mb-4">Are you sure you want to permanently delete this message? This action cannot be undone.</p>
            <input type="hidden" id="delete-chat-msg-id">
            <div class="d-flex gap-2">
              <button type="button" class="btn btn-outline-light flex-grow-1 rounded-pill fw-bold" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger flex-grow-1 rounded-pill fw-bold" id="confirm-delete-chat-btn">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="settings-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content" style="background-color: var(--ytm-bg);">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white"><i class="bi bi-sliders text-secondary me-2"></i> Settings</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-0 d-flex flex-column flex-md-row phpmusic-settings-wrapper">
            
            <div class="phpmusic-settings-sidebar">
              <div class="nav flex-row flex-md-column nav-pills phpmusic-settings-nav" id="settings-tabs" role="tablist">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#settings-profile" type="button" role="tab"><i class="bi bi-person-badge"></i> Profile</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#settings-appearance" type="button" role="tab"><i class="bi bi-palette"></i> Appearance</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#settings-audio" type="button" role="tab"><i class="bi bi-sliders"></i> Audio Engine</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#settings-account" type="button" role="tab"><i class="bi bi-shield-lock"></i> Account & Data</button>
              </div>
            </div>
            
            <div class="phpmusic-settings-content tab-content flex-grow-1 p-3 p-md-5" id="settings-tabContent">
              
              <!-- Profile Tab -->
              <div class="tab-pane fade show active phpmusic-settings-pane" id="settings-profile" role="tabpanel">
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-person-bounding-box text-danger"></i> Profile Picture</h6>
                  <form id="profile-picture-form" class="text-center">
                    <div style="max-width: 200px; width: 100%; margin: 0 auto;" class="mb-3">
                      <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" id="profile-picture-preview" style="display: block; max-width: 100%; border-radius: 12px; border: 4px solid var(--ytm-surface-2); box-shadow: 0 8px 30px rgba(0,0,0,0.5); margin: 0 auto;" alt="Profile Preview">
                    </div>
                    <div class="mb-3">
                      <input class="form-control" type="file" id="profile-picture-input" accept="image/png, image/jpeg, image/gif">
                    </div>
                    <div class="mb-4 text-start">
                      <label class="form-label text-secondary small fw-bold mb-2">OR CHOOSE A PRESET</label>
                      <div class="d-flex align-items-center gap-3 overflow-auto pb-2" id="preset-avatar-container" style="scrollbar-width: thin;"></div>
                      <button type="button" class="btn btn-sm btn-outline-secondary mt-1" id="refresh-presets-btn"><i class="bi bi-arrow-clockwise"></i> Generate New Presets</button>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold" id="profile-picture-submit-btn">Save Picture</button>
                    <div class="progress mt-3 d-none" id="profile-pic-progress-container" style="height: 15px;">
                      <div id="profile-pic-progress" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 0%;">0%</div>
                    </div>
                  </form>
                </div>
                
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-textarea-t text-primary"></i> Public Info</h6>
                  <form id="change-name-form" class="mb-4">
                    <div class="mb-3">
                      <label for="new-name" class="form-label text-secondary small fw-bold mb-1">DISPLAY NAME</label>
                      <input type="text" class="form-control" id="new-name" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold">Save Name</button>
                  </form>
                  <hr class="border-secondary mb-4 mt-4">
                  <form id="bio-form">
                    <div class="mb-3">
                      <label for="settings-bio" class="form-label text-secondary small fw-bold mb-1">BIOGRAPHY</label>
                      <textarea class="form-control" id="settings-bio" rows="4" placeholder="Tell us about yourself..."></textarea>
                      <div class="d-flex justify-content-end mt-2">
                        <a href="#" class="text-info small text-decoration-none" data-bs-toggle="modal" data-bs-target="#bbcode-info-modal"><i class="bi bi-info-circle"></i> Formatting Help</a>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold">Save Bio</button>
                  </form>
                </div>
              </div>

              <!-- Appearance Tab -->
              <div class="tab-pane fade phpmusic-settings-pane" id="settings-appearance" role="tabpanel">
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-image text-success"></i> Custom Background</h6>
                  <form id="profile-bg-form" class="mb-2">
                    <div class="mb-3 text-center" id="profile-bg-preview-container" style="display: none;">
                      <div style="max-width: 100%; margin: 0 auto;">
                        <img id="profile-bg-preview" src="" style="display: block; max-width: 100%; border-radius: 8px; border: 2px solid var(--ytm-surface-2); margin: 0 auto;">
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label text-secondary small fw-bold mb-1">UPLOAD IMAGE</label>
                      <input class="form-control" type="file" id="profile-bg-input" accept="image/png, image/jpeg, image/gif, image/webp">
                      <small class="text-secondary d-block mt-1">Upload a new background (3:1 crop)</small>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold" id="profile-bg-submit-btn">Save Uploaded Background</button>
                  </form>
                </div>
                
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-magic text-warning"></i> Wallpaper Generator</h6>
                  <div class="mb-2">
                    <canvas id="bg-gen-canvas" class="w-100 mb-4 rounded shadow-lg border border-secondary" style="height: 160px; object-fit: cover; background-color: var(--ytm-surface-2);"></canvas>
                    <div class="row g-3 mb-4">
                      <div class="col-12 col-md-6">
                        <label class="form-label text-secondary small fw-bold mb-1">PATTERN</label>
                        <select id="bg-gen-pattern" class="form-select bg-dark text-white border-secondary">
                          <optgroup label="Classic Patterns">
                            <option value="blobs">Blobs</option>
                            <option value="geometric">Geometric</option>
                            <option value="mesh">Mesh</option>
                            <option value="waves">Waves</option>
                            <option value="stripes">Stripes</option>
                            <option value="dots">Dots</option>
                            <option value="particles">Particles</option>
                            <option value="triangles">Triangles</option>
                            <option value="rays">Rays</option>
                            <option value="squares">Squares</option>
                            <option value="hexagons">Hexagons</option>
                            <option value="concentric">Concentric</option>
                            <option value="noise">Noise</option>
                            <option value="scribble">Scribble</option>
                            <option value="diamonds">Diamonds</option>
                            <option value="checkers">Checkers</option>
                            <option value="maze">Maze</option>
                            <option value="lines">Lines</option>
                            <option value="crosses">Crosses</option>
                            <option value="spirals">Spirals</option>
                          </optgroup>
                          <optgroup label="Scatter Forms">
                            <option value="scatter_circle">Scatter Circles</option>
                            <option value="scatter_square">Scatter Squares</option>
                            <option value="scatter_diamond">Scatter Diamonds</option>
                            <option value="scatter_triangle">Scatter Triangles</option>
                            <option value="scatter_star">Scatter Stars</option>
                            <option value="scatter_cross">Scatter Crosses</option>
                            <option value="scatter_hexagon">Scatter Hexagons</option>
                            <option value="scatter_pentagon">Scatter Pentagons</option>
                            <option value="scatter_octagon">Scatter Octagons</option>
                            <option value="scatter_ring">Scatter Rings</option>
                            <option value="scatter_heart">Scatter Hearts</option>
                            <option value="scatter_moon">Scatter Moons</option>
                            <option value="scatter_spade">Scatter Spades</option>
                            <option value="scatter_club">Scatter Clubs</option>
                            <option value="scatter_leaf">Scatter Leaves</option>
                            <option value="scatter_shield">Scatter Shields</option>
                            <option value="scatter_gem">Scatter Gems</option>
                            <option value="scatter_droplet">Scatter Droplets</option>
                            <option value="scatter_burst">Scatter Bursts</option>
                            <option value="scatter_sparkle">Scatter Sparkles</option>
                            <option value="scatter_clover">Scatter Clovers</option>
                            <option value="scatter_flower">Scatter Flowers</option>
                          </optgroup>
                          <optgroup label="Grid Layouts">
                            <option value="grid_circle">Grid Circles</option>
                            <option value="grid_square">Grid Squares</option>
                            <option value="grid_diamond">Grid Diamonds</option>
                            <option value="grid_triangle">Grid Triangles</option>
                            <option value="grid_star">Grid Stars</option>
                            <option value="grid_cross">Grid Crosses</option>
                            <option value="grid_hexagon">Grid Hexagons</option>
                            <option value="grid_pentagon">Grid Pentagons</option>
                            <option value="grid_octagon">Grid Octagons</option>
                            <option value="grid_ring">Grid Rings</option>
                            <option value="grid_heart">Grid Hearts</option>
                            <option value="grid_moon">Grid Moons</option>
                            <option value="grid_spade">Grid Spades</option>
                            <option value="grid_club">Grid Clubs</option>
                            <option value="grid_leaf">Grid Leaves</option>
                            <option value="grid_shield">Grid Shields</option>
                            <option value="grid_gem">Grid Gems</option>
                            <option value="grid_droplet">Grid Droplets</option>
                            <option value="grid_burst">Grid Bursts</option>
                            <option value="grid_sparkle">Grid Sparkles</option>
                            <option value="grid_clover">Grid Clovers</option>
                            <option value="grid_flower">Grid Flowers</option>
                          </optgroup>
                          <optgroup label="Isometric Grids">
                            <option value="isometric_circle">Isometric Circles</option>
                            <option value="isometric_square">Isometric Squares</option>
                            <option value="isometric_diamond">Isometric Diamonds</option>
                            <option value="isometric_triangle">Isometric Triangles</option>
                            <option value="isometric_star">Isometric Stars</option>
                            <option value="isometric_cross">Isometric Crosses</option>
                            <option value="isometric_hexagon">Isometric Hexagons</option>
                            <option value="isometric_pentagon">Isometric Pentagons</option>
                            <option value="isometric_octagon">Isometric Octagons</option>
                            <option value="isometric_ring">Isometric Rings</option>
                            <option value="isometric_heart">Isometric Hearts</option>
                            <option value="isometric_moon">Isometric Moons</option>
                            <option value="isometric_spade">Isometric Spades</option>
                            <option value="isometric_club">Isometric Clubs</option>
                            <option value="isometric_leaf">Isometric Leaves</option>
                            <option value="isometric_shield">Isometric Shields</option>
                            <option value="isometric_gem">Isometric Gems</option>
                            <option value="isometric_droplet">Isometric Droplets</option>
                            <option value="isometric_burst">Isometric Bursts</option>
                            <option value="isometric_sparkle">Isometric Sparkles</option>
                            <option value="isometric_clover">Isometric Clovers</option>
                            <option value="isometric_flower">Isometric Flowers</option>
                          </optgroup>
                          <optgroup label="Concentric Clusters">
                            <option value="concentric_circle">Concentric Circles</option>
                            <option value="concentric_square">Concentric Squares</option>
                            <option value="concentric_diamond">Concentric Diamonds</option>
                            <option value="concentric_triangle">Concentric Triangles</option>
                            <option value="concentric_star">Concentric Stars</option>
                            <option value="concentric_cross">Concentric Crosses</option>
                            <option value="concentric_hexagon">Concentric Hexagons</option>
                            <option value="concentric_pentagon">Concentric Pentagons</option>
                            <option value="concentric_octagon">Concentric Octagons</option>
                            <option value="concentric_ring">Concentric Rings</option>
                            <option value="concentric_heart">Concentric Hearts</option>
                            <option value="concentric_moon">Concentric Moons</option>
                            <option value="concentric_spade">Concentric Spades</option>
                            <option value="concentric_club">Concentric Clubs</option>
                            <option value="concentric_leaf">Concentric Leaves</option>
                            <option value="concentric_shield">Concentric Shields</option>
                            <option value="concentric_gem">Concentric Gems</option>
                            <option value="concentric_droplet">Concentric Droplets</option>
                            <option value="concentric_burst">Concentric Bursts</option>
                            <option value="concentric_sparkle">Concentric Sparkles</option>
                            <option value="concentric_clover">Concentric Clovers</option>
                            <option value="concentric_flower">Concentric Flowers</option>
                          </optgroup>
                          <optgroup label="Radial Bursts">
                            <option value="radial_circle">Radial Circles</option>
                            <option value="radial_square">Radial Squares</option>
                            <option value="radial_diamond">Radial Diamonds</option>
                            <option value="radial_triangle">Radial Triangles</option>
                            <option value="radial_star">Radial Stars</option>
                            <option value="radial_cross">Radial Crosses</option>
                            <option value="radial_hexagon">Radial Hexagons</option>
                            <option value="radial_pentagon">Radial Pentagons</option>
                            <option value="radial_octagon">Radial Octagons</option>
                            <option value="radial_ring">Radial Rings</option>
                            <option value="radial_heart">Radial Hearts</option>
                            <option value="radial_moon">Radial Moons</option>
                            <option value="radial_spade">Radial Spades</option>
                            <option value="radial_club">Radial Clubs</option>
                            <option value="radial_leaf">Radial Leaves</option>
                            <option value="radial_shield">Radial Shields</option>
                            <option value="radial_gem">Radial Gems</option>
                            <option value="radial_droplet">Radial Droplets</option>
                            <option value="radial_burst">Radial Bursts</option>
                            <option value="radial_sparkle">Radial Sparkles</option>
                            <option value="radial_clover">Radial Clovers</option>
                            <option value="radial_flower">Radial Flowers</option>
                          </optgroup>
                          <optgroup label="Spiral Galaxies">
                            <option value="spiral_circle">Spiral Circles</option>
                            <option value="spiral_square">Spiral Squares</option>
                            <option value="spiral_diamond">Spiral Diamonds</option>
                            <option value="spiral_triangle">Spiral Triangles</option>
                            <option value="spiral_star">Spiral Stars</option>
                            <option value="spiral_cross">Spiral Crosses</option>
                            <option value="spiral_hexagon">Spiral Hexagons</option>
                            <option value="spiral_pentagon">Spiral Pentagons</option>
                            <option value="spiral_octagon">Spiral Octagons</option>
                            <option value="spiral_ring">Spiral Rings</option>
                            <option value="spiral_heart">Spiral Hearts</option>
                            <option value="spiral_moon">Spiral Moons</option>
                            <option value="spiral_spade">Spiral Spades</option>
                            <option value="spiral_club">Spiral Clubs</option>
                            <option value="spiral_leaf">Spiral Leaves</option>
                            <option value="spiral_shield">Spiral Shields</option>
                            <option value="spiral_gem">Spiral Gems</option>
                            <option value="spiral_droplet">Spiral Droplets</option>
                            <option value="spiral_burst">Spiral Bursts</option>
                            <option value="spiral_sparkle">Spiral Sparkles</option>
                            <option value="spiral_clover">Spiral Clovers</option>
                            <option value="spiral_flower">Spiral Flowers</option>
                          </optgroup>
                          <optgroup label="Wave Matrices">
                            <option value="waveGrid_circle">Wave Circles</option>
                            <option value="waveGrid_square">Wave Squares</option>
                            <option value="waveGrid_diamond">Wave Diamonds</option>
                            <option value="waveGrid_triangle">Wave Triangles</option>
                            <option value="waveGrid_star">Wave Stars</option>
                            <option value="waveGrid_cross">Wave Crosses</option>
                            <option value="waveGrid_hexagon">Wave Hexagons</option>
                            <option value="waveGrid_pentagon">Wave Pentagons</option>
                            <option value="waveGrid_octagon">Wave Octagons</option>
                            <option value="waveGrid_ring">Wave Rings</option>
                            <option value="waveGrid_heart">Wave Hearts</option>
                            <option value="waveGrid_moon">Wave Moons</option>
                            <option value="waveGrid_spade">Wave Spades</option>
                            <option value="waveGrid_club">Wave Clubs</option>
                            <option value="waveGrid_leaf">Wave Leaves</option>
                            <option value="waveGrid_shield">Wave Shields</option>
                            <option value="waveGrid_gem">Wave Gems</option>
                            <option value="waveGrid_droplet">Wave Droplets</option>
                            <option value="waveGrid_burst">Wave Bursts</option>
                            <option value="waveGrid_sparkle">Wave Sparkles</option>
                            <option value="waveGrid_clover">Wave Clovers</option>
                            <option value="waveGrid_flower">Wave Flowers</option>
                          </optgroup>
                          <optgroup label="Zigzag Arrays">
                            <option value="zigzag_circle">Zigzag Circles</option>
                            <option value="zigzag_square">Zigzag Squares</option>
                            <option value="zigzag_diamond">Zigzag Diamonds</option>
                            <option value="zigzag_triangle">Zigzag Triangles</option>
                            <option value="zigzag_star">Zigzag Stars</option>
                            <option value="zigzag_cross">Zigzag Crosses</option>
                            <option value="zigzag_hexagon">Zigzag Hexagons</option>
                            <option value="zigzag_pentagon">Zigzag Pentagons</option>
                            <option value="zigzag_octagon">Zigzag Octagons</option>
                            <option value="zigzag_ring">Zigzag Rings</option>
                            <option value="zigzag_heart">Zigzag Hearts</option>
                            <option value="zigzag_moon">Zigzag Moons</option>
                            <option value="zigzag_spade">Zigzag Spades</option>
                            <option value="zigzag_club">Zigzag Clubs</option>
                            <option value="zigzag_leaf">Zigzag Leaves</option>
                            <option value="zigzag_shield">Zigzag Shields</option>
                            <option value="zigzag_gem">Zigzag Gems</option>
                            <option value="zigzag_droplet">Zigzag Droplets</option>
                            <option value="zigzag_burst">Zigzag Bursts</option>
                            <option value="zigzag_sparkle">Zigzag Sparkles</option>
                            <option value="zigzag_clover">Zigzag Clovers</option>
                            <option value="zigzag_flower">Zigzag Flowers</option>
                          </optgroup>
                          <optgroup label="Orbital Paths">
                            <option value="orbit_circle">Orbit Circles</option>
                            <option value="orbit_square">Orbit Squares</option>
                            <option value="orbit_diamond">Orbit Diamonds</option>
                            <option value="orbit_triangle">Orbit Triangles</option>
                            <option value="orbit_star">Orbit Stars</option>
                            <option value="orbit_cross">Orbit Crosses</option>
                            <option value="orbit_hexagon">Orbit Hexagons</option>
                            <option value="orbit_pentagon">Orbit Pentagons</option>
                            <option value="orbit_octagon">Orbit Octagons</option>
                            <option value="orbit_ring">Orbit Rings</option>
                            <option value="orbit_heart">Orbit Hearts</option>
                            <option value="orbit_moon">Orbit Moons</option>
                            <option value="orbit_spade">Orbit Spades</option>
                            <option value="orbit_club">Orbit Clubs</option>
                            <option value="orbit_leaf">Orbit Leaves</option>
                            <option value="orbit_shield">Orbit Shields</option>
                            <option value="orbit_gem">Orbit Gems</option>
                            <option value="orbit_droplet">Orbit Droplets</option>
                            <option value="orbit_burst">Orbit Bursts</option>
                            <option value="orbit_sparkle">Orbit Sparkles</option>
                            <option value="orbit_clover">Orbit Clovers</option>
                            <option value="orbit_flower">Orbit Flowers</option>
                          </optgroup>
                          <optgroup label="Pyramid Stacks">
                            <option value="pyramid_circle">Pyramid Circles</option>
                            <option value="pyramid_square">Pyramid Squares</option>
                            <option value="pyramid_diamond">Pyramid Diamonds</option>
                            <option value="pyramid_triangle">Pyramid Triangles</option>
                            <option value="pyramid_star">Pyramid Stars</option>
                            <option value="pyramid_cross">Pyramid Crosses</option>
                            <option value="pyramid_hexagon">Pyramid Hexagons</option>
                            <option value="pyramid_pentagon">Pyramid Pentagons</option>
                            <option value="pyramid_octagon">Pyramid Octagons</option>
                            <option value="pyramid_ring">Pyramid Rings</option>
                            <option value="pyramid_heart">Pyramid Hearts</option>
                            <option value="pyramid_moon">Pyramid Moons</option>
                            <option value="pyramid_spade">Pyramid Spades</option>
                            <option value="pyramid_club">Pyramid Clubs</option>
                            <option value="pyramid_leaf">Pyramid Leaves</option>
                            <option value="pyramid_shield">Pyramid Shields</option>
                            <option value="pyramid_gem">Pyramid Gems</option>
                            <option value="pyramid_droplet">Pyramid Droplets</option>
                            <option value="pyramid_burst">Pyramid Bursts</option>
                            <option value="pyramid_sparkle">Pyramid Sparkles</option>
                            <option value="pyramid_clover">Pyramid Clovers</option>
                            <option value="pyramid_flower">Pyramid Flowers</option>
                          </optgroup>
                          <optgroup label="Waterfall Streams">
                            <option value="waterfall_circle">Waterfall Circles</option>
                            <option value="waterfall_square">Waterfall Squares</option>
                            <option value="waterfall_diamond">Waterfall Diamonds</option>
                            <option value="waterfall_triangle">Waterfall Triangles</option>
                            <option value="waterfall_star">Waterfall Stars</option>
                            <option value="waterfall_cross">Waterfall Crosses</option>
                            <option value="waterfall_hexagon">Waterfall Hexagons</option>
                            <option value="waterfall_pentagon">Waterfall Pentagons</option>
                            <option value="waterfall_octagon">Waterfall Octagons</option>
                            <option value="waterfall_ring">Waterfall Rings</option>
                            <option value="waterfall_heart">Waterfall Hearts</option>
                            <option value="waterfall_moon">Waterfall Moons</option>
                            <option value="waterfall_spade">Waterfall Spades</option>
                            <option value="waterfall_club">Waterfall Clubs</option>
                            <option value="waterfall_leaf">Waterfall Leaves</option>
                            <option value="waterfall_shield">Waterfall Shields</option>
                            <option value="waterfall_gem">Waterfall Gems</option>
                            <option value="waterfall_droplet">Waterfall Droplets</option>
                            <option value="waterfall_burst">Waterfall Bursts</option>
                            <option value="waterfall_sparkle">Waterfall Sparkles</option>
                            <option value="waterfall_clover">Waterfall Clovers</option>
                            <option value="waterfall_flower">Waterfall Flowers</option>
                          </optgroup>
                          <optgroup label="Vortex Swirls">
                            <option value="vortex_circle">Vortex Circles</option>
                            <option value="vortex_square">Vortex Squares</option>
                            <option value="vortex_diamond">Vortex Diamonds</option>
                            <option value="vortex_triangle">Vortex Triangles</option>
                            <option value="vortex_star">Vortex Stars</option>
                            <option value="vortex_cross">Vortex Crosses</option>
                            <option value="vortex_hexagon">Vortex Hexagons</option>
                            <option value="vortex_pentagon">Vortex Pentagons</option>
                            <option value="vortex_octagon">Vortex Octagons</option>
                            <option value="vortex_ring">Vortex Rings</option>
                            <option value="vortex_heart">Vortex Hearts</option>
                            <option value="vortex_moon">Vortex Moons</option>
                            <option value="vortex_spade">Vortex Spades</option>
                            <option value="vortex_club">Vortex Clubs</option>
                            <option value="vortex_leaf">Vortex Leaves</option>
                            <option value="vortex_shield">Vortex Shields</option>
                            <option value="vortex_gem">Vortex Gems</option>
                            <option value="vortex_droplet">Vortex Droplets</option>
                            <option value="vortex_burst">Vortex Bursts</option>
                            <option value="vortex_sparkle">Vortex Sparkles</option>
                            <option value="vortex_clover">Vortex Clovers</option>
                            <option value="vortex_flower">Vortex Flowers</option>
                          </optgroup>
                        </select>
                      </div>
                      <div class="col-12 col-md-6">
                        <label class="form-label text-secondary small fw-bold mb-1">STYLE</label>
                        <select id="bg-gen-style" class="form-select bg-dark text-white border-secondary">
                          <option value="fill">Fill</option>
                          <option value="stroke">Line</option>
                          <option value="mixed">Mixed</option>
                        </select>
                      </div>
                      <div class="col-12 d-flex flex-column gap-1 mt-3">
                        <label class="form-label text-secondary small fw-bold mb-1">HUE SPECTRUM</label>
                        <input type="range" class="form-range" id="bg-gen-hue" min="0" max="360" value="260" style="background: linear-gradient(to right, #f00, #ff0, #0f0, #0ff, #00f, #f0f, #f00); height: 12px; border-radius: 6px; -webkit-appearance: none;">
                      </div>
                    </div>
                    <div class="d-flex gap-3">
                      <button type="button" class="btn btn-outline-light w-50 py-2 fw-bold" id="bg-gen-random-btn"><i class="bi bi-shuffle"></i> Randomize</button>
                      <button type="button" class="btn btn-danger w-50 py-2 fw-bold" id="bg-gen-save-btn">Set Background</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Audio Tab -->
              <div class="tab-pane fade phpmusic-settings-pane" id="settings-audio" role="tabpanel">
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-speaker-fill text-info"></i> Playback Controls</h6>
                  <div class="mb-4 mt-3">
                    <label class="form-label d-flex justify-content-between text-secondary fw-bold small">
                      <span>GLOBAL VOLUME MULTIPLIER</span>
                      <span id="global-vol-val" class="text-white">1.0x</span>
                    </label>
                    <input type="range" class="form-range" id="global-vol-slider" min="0" max="3" step="0.1" value="1">
                  </div>
                  <div class="mb-2">
                    <label class="form-label d-flex justify-content-between text-secondary fw-bold small">
                      <span>CROSSFADE DURATION</span>
                      <span id="crossfade-val" class="text-white">3.0s</span>
                    </label>
                    <input type="range" class="form-range" id="crossfade-slider" min="0" max="10" step="0.5" value="3.0">
                  </div>
                </div>
                
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-cpu-fill text-primary"></i> Audio Processors</h6>
                  <div class="form-check form-switch mb-4 d-flex align-items-center gap-3">
                    <input class="form-check-input fs-4 m-0" type="checkbox" id="toggle-normalization" checked>
                    <label class="form-check-label text-white m-0" for="toggle-normalization">Volume Normalization (AGC)<br><small class="text-secondary fw-normal">Balance volumes between different songs automatically</small></label>
                  </div>
                  <div class="form-check form-switch mb-4 d-flex align-items-center gap-3">
                    <input class="form-check-input fs-4 m-0" type="checkbox" id="toggle-spatial">
                    <label class="form-check-label text-white m-0" for="toggle-spatial">Enable Spatial Audio (3D HRTF)<br><small class="text-secondary fw-normal">Simulate surround sound depth for headphone users</small></label>
                  </div>
                  <div class="form-check form-switch mb-2 d-flex align-items-center gap-3">
                    <input class="form-check-input fs-4 m-0" type="checkbox" id="toggle-eq">
                    <label class="form-check-label text-white m-0" for="toggle-eq">Enable Equalizer<br><small class="text-secondary fw-normal">Customize frequency bands globally</small></label>
                  </div>
                </div>

                <div class="phpmusic-settings-section d-none" id="eq-sliders">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-soundwave text-warning"></i> 5-Band Equalizer</h6>
                  <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold mb-1">PRESET</label>
                    <select class="form-select bg-dark text-white border-secondary" id="eq-preset-select">
                      <option value="Custom">Custom</option>
                      <option value="Flat">Flat</option>
                      <option value="Rock">Rock</option>
                      <option value="Jazz">Jazz</option>
                      <option value="Classical">Classical</option>
                      <option value="Pop">Pop</option>
                      <option value="Bass Boost">Bass Boost</option>
                    </select>
                  </div>
                  <div class="d-flex justify-content-between text-center small text-secondary fw-bold" style="padding: 0 10px;">
                    <span style="width: 18%;">60Hz</span><span style="width: 18%;">230Hz</span><span style="width: 18%;">910Hz</span><span style="width: 18%;">3.6kHz</span><span style="width: 18%;">14kHz</span>
                  </div>
                  <div class="d-flex justify-content-between mt-4 mb-5">
                    <input type="range" class="form-range eq-band" data-band="0" min="-12" max="12" step="1" value="0" style="width: 18%; transform: rotate(-90deg); margin: 60px 0;">
                    <input type="range" class="form-range eq-band" data-band="1" min="-12" max="12" step="1" value="0" style="width: 18%; transform: rotate(-90deg); margin: 60px 0;">
                    <input type="range" class="form-range eq-band" data-band="2" min="-12" max="12" step="1" value="0" style="width: 18%; transform: rotate(-90deg); margin: 60px 0;">
                    <input type="range" class="form-range eq-band" data-band="3" min="-12" max="12" step="1" value="0" style="width: 18%; transform: rotate(-90deg); margin: 60px 0;">
                    <input type="range" class="form-range eq-band" data-band="4" min="-12" max="12" step="1" value="0" style="width: 18%; transform: rotate(-90deg); margin: 60px 0;">
                  </div>
                </div>
              </div>

              <!-- Account Tab -->
              <div class="tab-pane fade phpmusic-settings-pane" id="settings-account" role="tabpanel">
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-bell-fill text-warning"></i> Notifications</h6>
                  <p class="text-secondary small mb-3">Enable OS-level push notifications to receive alerts for new messages and activity even when the app is minimized.</p>
                  <button type="button" class="btn btn-outline-light w-100 fw-bold" id="enable-os-notif-btn"><i class="bi bi-app-indicator me-2"></i>Enable Push Notifications</button>
                </div>
                
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-key text-white"></i> Security</h6>
                  <form id="change-password-form">
                    <div class="mb-3">
                      <label for="new-password" class="form-label text-secondary small fw-bold mb-1">NEW PASSWORD</label>
                      <input type="password" class="form-control" id="new-password" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold mb-3">Update Password</button>
                    <div class="text-center">
                      <a href="#" class="text-info text-decoration-none small fw-medium" data-bs-toggle="modal" data-bs-target="#forgot-password-modal" data-bs-dismiss="modal">I forgot my current password...</a>
                    </div>
                  </form>
                </div>
                
                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-shield-exclamation text-warning"></i> Game Ban Status</h6>
                  <p class="text-secondary small mb-3">If you are locked out of the Rhythm Game due to false anti-cheat flags, you can appeal the restriction here.</p>
                  <button type="button" class="btn btn-warning text-dark w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#settings-appeal-modal" data-bs-dismiss="modal"><i class="bi bi-envelope-paper me-2"></i> Submit Game Ban Appeal</button>
                </div>

                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-box-arrow-down text-info"></i> Data Backup</h6>
                  <p class="text-secondary small mb-3">Export or import your account data (Followings, Notes, Tasks, Blogs, Rhythm Favorites, and Playlists) as a structured JSON file.</p>
                  <div class="d-flex gap-2 mb-2">
                    <button type="button" class="btn btn-outline-light w-50 fw-bold" id="btn-export-user-data"><i class="bi bi-box-arrow-up me-2"></i>Export</button>
                    <button type="button" class="btn btn-outline-light w-50 fw-bold" id="btn-import-user-data-trigger"><i class="bi bi-box-arrow-in-down me-2"></i>Import</button>
                    <input type="file" id="import-user-data-file" accept=".json" class="d-none">
                  </div>
                </div>

                <div class="phpmusic-settings-section">
                  <h6 class="phpmusic-settings-section-title"><i class="bi bi-eye-slash-fill text-danger"></i> Content Filtering</h6>
                  <div class="form-check form-switch mb-2 d-flex align-items-center gap-3">
                    <input class="form-check-input fs-4 m-0" type="checkbox" id="toggle-nsfw-arts">
                    <label class="form-check-label text-white m-0" for="toggle-nsfw-arts">Show NSFW Content (18+)<br><small class="text-secondary fw-normal">Display sensitive artworks in PHPShares</small></label>
                  </div>
                </div>

                <div class="phpmusic-settings-section border-danger" style="background-color: rgba(255,0,0,0.03);">
                  <h6 class="phpmusic-settings-section-title text-danger border-danger"><i class="bi bi-exclamation-triangle-fill"></i> Danger Zone</h6>
                  <p class="text-secondary small mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                  <button type="button" class="btn btn-outline-danger w-100 mb-3 fw-bold py-2" id="btn-delete-keep">Delete Account but Keep Data</button>
                  <button type="button" class="btn btn-danger w-100 fw-bold py-2" id="btn-delete-all">Permanently Delete Account & Data</button>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="group-manage-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040; border-radius: 16px; box-shadow: 0 15px 35px rgba(0,0,0,0.5);">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white fw-bold" id="group-manage-title"><i class="bi bi-people-fill text-info me-2"></i>Create Group</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <form id="group-manage-form">
              <input type="hidden" id="group-manage-id">
              
              <div class="p-3 mb-4 rounded shadow-sm" style="background-color: var(--ytm-surface-2); border: 1px solid rgba(255,255,255,0.05);">
                <div class="text-center d-flex flex-column align-items-center">
                  <div style="width: 100%; max-width: 250px; margin: 0 auto;" class="mb-3 position-relative">
                    <img id="group-manage-image-preview" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="border border-secondary shadow-lg" style="width: 100%; height: 100%; border-radius: 8px; object-fit: cover; display: none; margin: 0 auto;">
                  </div>
                  <label class="form-label text-secondary small fw-bold text-center w-100 mb-2" style="letter-spacing: 1px;">UPLOAD IMAGE</label>
                  <input type="file" id="group-manage-image" class="form-control form-control-sm bg-dark text-white border-secondary mb-3 w-100" accept="image/png, image/jpeg, image/gif, image/webp">
                  <label class="form-label text-secondary small fw-bold text-center w-100 mb-2" style="letter-spacing: 1px;">OR CHOOSE PRESET</label>
                  <div class="d-flex align-items-center justify-content-center gap-2 overflow-auto w-100 pb-2 modern-custom-scroll" id="group-preset-avatar-container"></div>
                </div>
              </div>
              
              <div class="mb-3">
                <label class="form-label text-secondary small fw-bold" style="letter-spacing: 1px;">GROUP NAME</label>
                <input type="text" id="group-manage-name" class="form-control bg-dark text-white border-secondary py-2" placeholder="e.g. Study Session" required maxlength="50">
              </div>
              <div class="mb-4">
                <label class="form-label text-secondary small fw-bold" style="letter-spacing: 1px;">DESCRIPTION</label>
                <textarea id="group-manage-desc" class="form-control bg-dark text-white border-secondary py-2" rows="3" placeholder="What is this group about?" maxlength="200"></textarea>
              </div>
              <button type="submit" class="btn btn-info text-dark fw-bold w-100 py-2 rounded-pill shadow-sm" id="group-manage-submit" style="font-size: 1.05rem;">Create Group</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="group-info-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040; border-radius: 16px; box-shadow: 0 15px 35px rgba(0,0,0,0.5);">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-info-circle text-info me-2"></i>Group Info</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <div class="text-center mb-4">
              <div class="rounded-circle bg-dark d-flex align-items-center justify-content-center mx-auto mb-3 border border-secondary shadow-lg position-relative" style="width: 120px; height: 120px; overflow: hidden;" id="group-info-img-container">
                <i class="bi bi-people-fill text-secondary" style="font-size: 4rem;"></i>
              </div>
              <h4 class="text-white fw-bold mb-1" id="group-info-name"></h4>
              <p class="text-secondary small mb-0" id="group-info-desc"></p>
            </div>

            <div id="group-owner-controls" class="d-none mb-4 p-3 rounded shadow-sm" style="background-color: var(--ytm-surface-2); border: 1px solid rgba(255,255,255,0.05);">
              <h6 class="text-white small fw-bold mb-3 text-uppercase" style="letter-spacing: 1px;"><i class="bi bi-shield-lock text-warning me-1"></i> OWNER CONTROLS</h6>
              <div class="d-flex gap-2 mb-3">
                <button class="btn btn-sm btn-outline-light flex-grow-1 fw-bold rounded-pill" id="group-btn-edit"><i class="bi bi-pencil-square"></i> Edit</button>
                <button class="btn btn-sm btn-outline-danger flex-grow-1 fw-bold rounded-pill" id="group-btn-delete"><i class="bi bi-trash2"></i> Delete</button>
              </div>
              <hr class="border-secondary my-3 opacity-50">
              <label class="form-label text-secondary small fw-bold mb-2" style="letter-spacing: 1px;">GENERATE INVITE LINK</label>
              <div class="input-group input-group-sm mb-1 shadow-sm rounded-pill overflow-hidden">
                <select id="group-invite-expire" class="form-select bg-dark text-white border-secondary border-0" style="max-width: 120px;">
                  <option value="1440">1 Day</option>
                  <option value="10080">1 Week</option>
                  <option value="forever">Forever</option>
                </select>
                <button class="btn btn-info text-dark fw-bold border-0 px-3" id="group-btn-invite"><i class="bi bi-link-45deg"></i> Copy Link</button>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="text-white small fw-bold m-0 text-uppercase" style="letter-spacing: 1px;">Members (<span id="group-info-count">0</span>)</h6>
            </div>
            <div class="list-group list-group-flush bg-transparent modern-custom-scroll" id="group-info-members" style="max-height: 250px; overflow-y: auto; border-radius: 8px;"></div>
            
            <button class="btn btn-outline-danger w-100 mt-4 fw-bold rounded-pill py-2" id="group-btn-leave"><i class="bi bi-box-arrow-left"></i> Leave Group</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="activity-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header border-0 pb-2 d-flex justify-content-between align-items-center">
            <h5 class="modal-title mb-0"><i class="bi bi-activity text-danger me-2"></i>Activity Feed</h5>
            <div>
              <button class="btn btn-sm btn-outline-secondary me-3" id="clear-activity-btn">Clear All</button>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
          </div>
          <div class="modal-body p-0" id="activity-modal-body"></div>
        </div>
      </div>
    </div>
    <!-- Auth Required Warning Modal -->
    <div class="modal fade" id="auth-required-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040; border-radius: 16px; box-shadow: 0 15px 35px rgba(0,0,0,0.8);">
          <div class="modal-body text-center p-4">
            <i class="bi bi-person-lock text-warning mb-3" style="font-size: 3.5rem; display: block;"></i>
            <h5 class="text-white fw-bold mb-3">Authentication Required</h5>
            <p class="text-secondary small mb-4">Your session has expired or you are not logged in. Please log in or create an account to access this page.</p>
            <div class="d-flex flex-column gap-2">
              <button class="btn btn-danger w-100 fw-bold rounded-pill py-2 shadow-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#login-modal">Log In</button>
              <button class="btn btn-outline-light w-100 fw-bold rounded-pill py-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#register-modal">Create Account</button>
              <button class="btn btn-link text-secondary text-decoration-none mt-1 fw-medium" data-bs-dismiss="modal" onclick="loadView({ type: 'get_songs', param: '', sort: 'random', filter_user_id: '' })">Return to Home</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="request-verification-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white"><i class="bi bi-patch-check-fill text-info me-2"></i>Account Verification</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-4">
            <i class="bi bi-cloud-upload text-secondary mb-3" style="font-size: 3rem; display: block;"></i>
            <h5 class="text-white mb-3">Upload Permissions Required</h5>
            <p class="text-secondary mb-4">Please notify the admin to verify your account so you can upload your own songs and share them with the community.</p>
            <button class="btn btn-info w-100 fw-bold text-dark" id="send-verification-request-btn">Request Verification</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="upload-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Upload Music</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="song-files" class="form-label">Select songs to upload</label>
              <input class="form-control" type="file" id="song-files" multiple accept="audio/*">
              <div class="d-flex justify-content-between">
                <small class="form-text text-secondary" id="upload-limit-text"></small>
                <small class="form-text text-secondary" id="upload-remaining-text"></small>
              </div>
            </div>
            <div class="mb-3">
              <label for="song-genre" class="form-label">Custom Genre</label>
              <input type="text" class="form-control" id="song-genre" placeholder="Pop, Rock, J-Pop">
            </div>
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" id="song-is-private">
              <label class="form-check-label text-white" for="song-is-private"><i class="bi bi-lock-fill text-warning"></i> Private Song</label>
            </div>
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" id="song-is-collaborative" checked>
              <label class="form-check-label text-white" for="song-is-collaborative"><i class="bi bi-people-fill text-info"></i> Official Collaboration</label>
            </div>
            <div class="mb-3" id="upload-collaborator-container" style="display: none;">
              <h6 class="text-white small mb-2">Manage Collaborators</h6>
              <div class="position-relative mb-2">
                <div class="input-group">
                  <input type="text" id="upload-collab-search-input" class="form-control" placeholder="Search Artist Name...">
                  <button type="button" class="btn btn-danger" id="upload-collab-add-btn">Add User</button>
                </div>
                <div id="upload-collab-search-dropdown" class="search-dropdown d-none w-100" style="top: 100%; position: absolute; z-index: 2000; background-color: var(--ytm-surface-2); border: 1px solid #404040; border-radius: 0 0 8px 8px; max-height: 250px; overflow-y: auto;"></div>
              </div>
              <div id="upload-collab-list" class="list-group list-group-flush bg-transparent"></div>
              <input type="hidden" id="song-artist" value="">
            </div>
            <button id="start-upload-btn" class="btn btn-danger">Start Upload</button>
            <div id="upload-progress-area" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="genres-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">All Genres</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" id="genres-modal-body">
            <div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="song-collab-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Manage Song Collaborators</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="song-collab-song-id">
            <div class="position-relative mb-3">
              <div class="input-group">
                <input type="text" id="song-collab-input" class="form-control" placeholder="Search Artist Name...">
                <button class="btn btn-danger" id="song-collab-add-btn">Add User</button>
              </div>
              <div id="song-collab-search-dropdown" class="search-dropdown d-none w-100" style="top: 100%; position: absolute; z-index: 2000; background-color: var(--ytm-surface-2); border: 1px solid #404040; border-radius: 0 0 8px 8px; max-height: 250px; overflow-y: auto;"></div>
            </div>
            <div class="mb-3 p-3 rounded" style="background-color: var(--ytm-surface-2); border: 1px solid #404040;">
              <label for="song-collab-expire-select" class="form-label text-white small mb-1">Invite Link Expiration</label>
              <select id="song-collab-expire-select" class="form-select form-select-sm bg-dark text-white border-secondary mb-2">
                <option value="1440">1 Day</option>
                <option value="10080">1 Week</option>
                <option value="43200">1 Month</option>
                <option value="forever">Forever</option>
                <option value="custom">Custom (Minutes)</option>
              </select>
              <input type="number" id="song-collab-custom-expire" class="form-control form-control-sm bg-dark text-white border-secondary d-none mb-2" placeholder="Enter minutes (e.g. 60)">
              <button class="btn btn-outline-light w-100" id="song-collab-copy-link-btn"><i class="bi bi-link-45deg"></i> Generate & Copy Link</button>
            </div>
            <h6 class="text-secondary mt-2">Current Collaborators</h6>
            <div id="song-collab-list" class="list-group list-group-flush bg-transparent"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="song-collab-invite-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-secondary">
            <h5 class="modal-title text-white">Song Collaboration Invite</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-4">
            <i class="bi bi-music-note-list text-info mb-3" style="font-size: 3rem; display: block;"></i>
            <h5 class="text-white mb-2">You've been invited!</h5>
            <p class="text-secondary mb-4">You have been invited to collaborate on the song <strong id="invite-song-title" class="text-white"></strong> by <strong id="invite-song-creator" class="text-white"></strong>.</p>
            <div class="d-flex gap-2 justify-content-center">
              <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" id="song-invite-reject-btn">Decline</button>
              <button class="btn btn-danger px-4" id="song-invite-accept-btn">Accept & Join</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="collab-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Manage Collaborators</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="position-relative mb-3">
              <div class="input-group">
                <input type="text" id="collab-input" class="form-control" placeholder="Search Artist Name...">
                <button class="btn btn-danger" id="collab-add-btn">Add User</button>
              </div>
              <div id="collab-search-dropdown" class="search-dropdown d-none w-100" style="top: 100%; position: absolute; z-index: 2000; background-color: var(--ytm-surface-2); border: 1px solid #404040; border-radius: 0 0 8px 8px; max-height: 250px; overflow-y: auto;"></div>
            </div>
            <div class="mb-3 p-3 rounded" style="background-color: var(--ytm-surface-2); border: 1px solid #404040;">
              <label for="collab-expire-select" class="form-label text-white small mb-1">Invite Link Expiration</label>
              <select id="collab-expire-select" class="form-select form-select-sm bg-dark text-white border-secondary mb-2">
                <option value="1440">1 Day</option>
                <option value="10080">1 Week</option>
                <option value="43200">1 Month</option>
                <option value="forever">Forever</option>
                <option value="custom">Custom (Minutes)</option>
              </select>
              <input type="number" id="collab-custom-expire" class="form-control form-control-sm bg-dark text-white border-secondary d-none mb-2" placeholder="Enter minutes (e.g. 60)">
              <button class="btn btn-outline-light w-100" id="collab-copy-link-btn"><i class="bi bi-link-45deg"></i> Generate & Copy Link</button>
            </div>
            <h6 class="text-secondary mt-2">Current Collaborators</h6>
            <div id="collab-list" class="list-group list-group-flush bg-transparent"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="collab-invite-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-secondary">
            <h5 class="modal-title text-white">Collaboration Invite</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center p-4">
            <i class="bi bi-envelope-paper-heart text-danger mb-3" style="font-size: 3rem; display: block;"></i>
            <h5 class="text-white mb-2">You've been invited!</h5>
            <p class="text-secondary mb-4">You have been invited to collaborate on the playlist <strong id="invite-playlist-name" class="text-white"></strong> by <strong id="invite-playlist-creator" class="text-white"></strong>.</p>
            <div class="d-flex gap-2 justify-content-center">
              <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" id="invite-reject-btn">Decline</button>
              <button class="btn btn-danger px-4" id="invite-accept-btn">Accept & Join</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="create-playlist-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Create New Playlist</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="create-playlist-form">
              <div class="mb-3">
                <label for="playlist-name-input" class="form-label">Playlist Name</label>
                <input type="text" class="form-control" id="playlist-name-input" required>
              </div>
              <div class="mb-3">
                <label for="playlist-desc-input" class="form-label">Description (Bio)</label>
                <textarea class="form-control" id="playlist-desc-input" rows="3" placeholder="Tell us about this playlist..."></textarea>
                <div class="d-flex justify-content-end mt-1">
                  <a href="#" class="text-info small text-decoration-none" data-bs-toggle="modal" data-bs-target="#bbcode-info-modal"><i class="bi bi-info-circle"></i> Formatting Help</a>
                </div>
              </div>
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="playlist-is-private">
                <label class="form-check-label text-white" for="playlist-is-private"><i class="bi bi-lock-fill text-warning"></i> Private Playlist</label>
              </div>
              <button type="submit" class="btn btn-danger w-100">Create</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="edit-playlist-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Edit Playlist</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="edit-playlist-form">
              <input type="hidden" id="edit-playlist-id-input">
              <div class="mb-3">
                <label for="edit-playlist-name-input" class="form-label">Playlist Name</label>
                <input type="text" class="form-control" id="edit-playlist-name-input" required>
              </div>
              <div class="mb-3">
                <label for="edit-playlist-desc-input" class="form-label">Description (Bio)</label>
                <textarea class="form-control" id="edit-playlist-desc-input" rows="3" placeholder="Tell us about this playlist..."></textarea>
                <div class="d-flex justify-content-end mt-1">
                  <a href="#" class="text-info small text-decoration-none" data-bs-toggle="modal" data-bs-target="#bbcode-info-modal"><i class="bi bi-info-circle"></i> Formatting Help</a>
                </div>
              </div>
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="edit-playlist-is-private">
                <label class="form-check-label text-white" for="edit-playlist-is-private"><i class="bi bi-lock-fill text-warning"></i> Private Playlist</label>
              </div>
              <button type="submit" class="btn btn-danger w-100">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="import-playlist-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Import Playlist</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="import-playlist-form">
              <div class="mb-3">
                <label for="import-playlist-file" class="form-label">Select JSON file</label>
                <input type="file" class="form-control" id="import-playlist-file" accept="application/json,.json" required>
              </div>
              <button type="submit" class="btn btn-danger w-100">Import</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="import-offline-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Import Offline Library</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="import-offline-form">
              <div class="mb-3">
                <label for="import-offline-file" class="form-label">Select JSON file</label>
                <input type="file" class="form-control" id="import-offline-file" accept="application/json,.json" required>
              </div>
              <button type="submit" class="btn btn-danger w-100">Import</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="import-favorites-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Import Favorites</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="import-favorites-form">
              <div class="mb-3">
                <label for="import-favorites-file" class="form-label">Select JSON file</label>
                <input type="file" class="form-control" id="import-favorites-file" accept="application/json,.json" required>
              </div>
              <button type="submit" class="btn btn-danger w-100">Import</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="import-listen-later-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Import Listen Later</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="import-listen-later-form">
              <div class="mb-3">
                <label for="import-listen-later-file" class="form-label">Select JSON file</label>
                <input type="file" class="form-control" id="import-listen-later-file" accept="application/json,.json" required>
              </div>
              <button type="submit" class="btn btn-danger w-100">Import</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="import-following-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Import Following</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="import-following-form">
              <div class="mb-3">
                <label for="import-following-file" class="form-label">Select JSON file</label>
                <input type="file" class="form-control" id="import-following-file" accept="application/json,.json" required>
              </div>
              <button type="submit" class="btn btn-danger w-100">Import</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="import-notes-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface);">
          <div class="modal-header border-0">
            <h5 class="modal-title text-white">Import Notes</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="import-notes-form">
              <div class="mb-3">
                <label for="import-notes-file" class="form-label text-white">Select JSON file</label>
                <input type="file" class="form-control bg-dark text-white border-secondary" id="import-notes-file" accept="application/json,.json" required>
              </div>
              <button type="submit" class="btn btn-danger w-100">Import Notes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="add-to-playlist-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Add to Playlist</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" id="add-to-playlist-modal-body">
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="metadata-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(30, 30, 30, 0.95); backdrop-filter: blur(10px); border: 1px solid #444;">
          <div class="modal-header border-0 pb-0">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body pt-0" id="metadata-modal-body">
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="lyrics-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content" style="background: rgba(10, 10, 10, 0.85); backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px); border: none;">
          <div class="modal-header border-0 pb-0 pt-4 position-absolute w-100 z-3 align-items-center pe-5">
            <h5 class="modal-title text-start fw-bold text-white opacity-75 text-truncate ps-1" id="lyrics-modal-title" style="letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0,0,0,0.5); max-width: 90%;">Lyrics</h5>
            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-4" data-bs-dismiss="modal" style="top: 1.8rem;"></button>
          </div>
          <div class="modal-body p-0 position-relative" id="lyrics-modal-body" style="overflow-y: auto;">
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="edit-metadata-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Edit Metadata</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="edit-metadata-form" enctype="multipart/form-data">
              <input type="hidden" id="edit-metadata-id">
              <div class="mb-3 text-center">
                <div style="max-width: 300px; margin: 0 auto;" class="mb-2">
                   <img id="edit-metadata-cover-preview" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" class="img-thumbnail bg-transparent border-secondary" style="width: 100%; display: block; max-width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 8px;">
                </div>
                <input type="file" class="form-control form-control-sm" id="edit-metadata-cover" accept="image/*">
                <small class="text-secondary d-block mt-1">Upload a new cover image (1:1 crop)</small>
              </div>
              <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" id="edit-metadata-title">
              </div>
              <div class="mb-3">
                <label class="form-label">Artist(s) / Collaborators</label>
                <input type="text" class="form-control" id="edit-metadata-artist" placeholder="Artist 1, Artist 2 (Comma separated)">
              </div>
              <div class="mb-3">
                <label class="form-label">Album</label>
                <input type="text" class="form-control" id="edit-metadata-album">
              </div>
              <div class="mb-3">
                <label class="form-label">Genre</label>
                <input type="text" class="form-control" id="edit-metadata-genre">
              </div>
              <div class="mb-3">
                <label class="form-label">Lyrics</label>
                <textarea class="form-control" id="edit-metadata-lyrics" rows="4"></textarea>
              </div>
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="edit-metadata-is-private">
                <label class="form-check-label text-white" for="edit-metadata-is-private"><i class="bi bi-lock-fill text-warning"></i> Private Song</label>
              </div>
              <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="edit-metadata-is-collaborative">
                <label class="form-check-label text-white" for="edit-metadata-is-collaborative"><i class="bi bi-people-fill text-info"></i> Official Collaboration</label>
              </div>
              <div id="edit-song-collab-container" class="d-none mb-3 p-3 rounded" style="background-color: var(--ytm-surface-2); border: 1px solid #404040;">
                <label class="form-label text-white small mb-1">Manage Collaborators</label>
                <button type="button" class="btn btn-outline-info btn-sm w-100 mb-2" id="manage-song-collab-btn">Manage Collaborators</button>
              </div>
              <button type="submit" class="btn btn-danger w-100" id="edit-metadata-submit-btn">Save Changes</button>
              <div class="progress mt-3 d-none" id="metadata-progress-container" style="height: 15px;">
                <div id="metadata-progress" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 0%;">0%</div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="artists-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
        <div class="modal-content" style="background: var(--ytm-surface); border: 1px solid #444;">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title">Artists</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-0" id="artists-modal-body">
          </div>
        </div>
      </div>
    </div>
    <style>
      .share-platform-btn .icon-box { transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1); }
      .share-platform-btn:hover .icon-box { transform: scale(1.15) translateY(-2px); box-shadow: 0 8px 16px rgba(0,0,0,0.6) !important; }
    </style>
    <div class="modal fade" id="share-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(20, 20, 20, 0.95); backdrop-filter: blur(15px); border: 1px solid #444; border-radius: 24px;">
          <div class="modal-header border-0 pb-1">
            <h5 class="modal-title fw-bold text-white" id="share-modal-title">Share</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body pt-0 pb-4 px-4">
            
            <div class="d-flex align-items-center gap-3 mb-4 mt-2 p-3 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
              <img id="share-modal-cover" src="" class="rounded-3 shadow" style="width: 70px; height: 70px; object-fit: cover; display: none;">
              <div class="overflow-hidden flex-grow-1">
                <h6 class="text-white fw-bold mb-1 text-truncate" id="share-modal-preview-title">Title</h6>
                <p class="text-secondary small mb-0 text-truncate" id="share-modal-preview-desc">Description</p>
              </div>
            </div>

            <button class="btn btn-light w-100 mb-4 fw-bold rounded-pill py-2 shadow-lg text-dark" id="system-share-btn" style="display: none; border: none;">
              <i class="bi bi-share-fill me-2"></i> Share via System Apps
            </button>
            
            <p class="small text-secondary fw-bold mb-2 text-uppercase" style="letter-spacing: 1px;">Share to Apps</p>
            <div class="d-flex gap-4 overflow-auto pb-3 pt-2 mb-2 modern-custom-scroll" style="scroll-snap-type: x mandatory;">
              <a href="#" id="share-whatsapp" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #25D366; color: #fff; font-size: 1.6rem;"><i class="bi bi-whatsapp"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">WhatsApp</span>
              </a>
              <a href="#" id="share-twitter" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #000000; border: 1px solid #333; color: #fff; font-size: 1.6rem;"><i class="bi bi-twitter-x"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">X (Twitter)</span>
              </a>
              <a href="#" id="share-facebook" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #1877F2; color: #fff; font-size: 1.6rem;"><i class="bi bi-facebook"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Facebook</span>
              </a>
              <a href="#" id="share-telegram" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #26A5E4; color: #fff; font-size: 1.6rem;"><i class="bi bi-telegram"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Telegram</span>
              </a>
              <a href="#" id="share-messenger" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #0084FF; color: #fff; font-size: 1.6rem;"><i class="bi bi-messenger"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Messenger</span>
              </a>
              <a href="#" id="share-reddit" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #FF4500; color: #fff; font-size: 1.6rem;"><i class="bi bi-reddit"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Reddit</span>
              </a>
              <a href="#" id="share-linkedin" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #0A66C2; color: #fff; font-size: 1.6rem;"><i class="bi bi-linkedin"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">LinkedIn</span>
              </a>
              <a href="#" id="share-pinterest" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #E60023; color: #fff; font-size: 1.6rem;"><i class="bi bi-pinterest"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Pinterest</span>
              </a>
              <a href="#" id="share-line" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #00C300; color: #fff; font-size: 1.6rem;"><i class="bi bi-line"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">LINE</span>
              </a>
              <a href="#" id="share-discord" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #5865F2; color: #fff; font-size: 1.6rem;"><i class="bi bi-discord"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Discord</span>
              </a>
              <a href="#" id="share-skype" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #00AFF0; color: #fff; font-size: 1.6rem;"><i class="bi bi-skype"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Skype</span>
              </a>
              <a href="#" id="share-wechat" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #7BB32E; color: #fff; font-size: 1.6rem;"><i class="bi bi-wechat"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">WeChat</span>
              </a>
              <a href="#" id="share-tumblr" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #36465D; color: #fff; font-size: 1.6rem;"><i class="bi bi-wordpress"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Tumblr</span>
              </a>
              <a href="#" id="share-mastodon" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #6364FF; color: #fff; font-size: 1.6rem;"><i class="bi bi-mastodon"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Mastodon</span>
              </a>
              <a href="#" id="share-hackernews" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #FF6600; color: #fff; font-size: 1.6rem;"><i class="bi bi-h-square"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">H. News</span>
              </a>
              <a href="#" id="share-pocket" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #EF4056; color: #fff; font-size: 1.6rem;"><i class="bi bi-bookmark-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Pocket</span>
              </a>
              <a href="#" id="share-vk" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #0077FF; color: #fff; font-size: 1.6rem;"><i class="bi bi-vimeo"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">VKontakte</span>
              </a>
              <a href="#" id="share-flipboard" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #E12828; color: #fff; font-size: 1.6rem;"><i class="bi bi-front"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Flipboard</span>
              </a>
              <a href="#" id="share-email" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #EA4335; color: #fff; font-size: 1.6rem;"><i class="bi bi-envelope-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Email</span>
              </a>
              <a href="#" id="share-sms" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #34B7F1; color: #fff; font-size: 1.6rem;"><i class="bi bi-chat-text-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">SMS</span>
              </a>
              
              <a href="#" id="share-threads" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #000000; border: 1px solid #333; color: #fff; font-size: 1.6rem;"><i class="bi bi-threads"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Threads</span>
              </a>
              <a href="#" id="share-snapchat" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #FFFC00; color: #000; font-size: 1.6rem;"><i class="bi bi-snapchat"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Snapchat</span>
              </a>
              <a href="#" id="share-slack" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #4A154B; color: #fff; font-size: 1.6rem;"><i class="bi bi-slack"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Slack</span>
              </a>
              <a href="#" id="share-twitch" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #9146FF; color: #fff; font-size: 1.6rem;"><i class="bi bi-twitch"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Twitch</span>
              </a>
              <a href="#" id="share-medium" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #000000; border: 1px solid #333; color: #fff; font-size: 1.6rem;"><i class="bi bi-medium"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Medium</span>
              </a>
              <a href="#" id="share-quora" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #B92B27; color: #fff; font-size: 1.6rem;"><i class="bi bi-quora"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Quora</span>
              </a>
              <a href="#" id="share-tiktok" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #000000; border: 1px solid #333; color: #fff; font-size: 1.6rem;"><i class="bi bi-tiktok"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">TikTok</span>
              </a>
              <a href="#" id="share-instagram" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #E1306C; color: #fff; font-size: 1.6rem;"><i class="bi bi-instagram"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Instagram</span>
              </a>
              <a href="#" id="share-youtube" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #FF0000; color: #fff; font-size: 1.6rem;"><i class="bi bi-youtube"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">YouTube</span>
              </a>
              <a href="#" id="share-spotify" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #1DB954; color: #fff; font-size: 1.6rem;"><i class="bi bi-spotify"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Spotify</span>
              </a>
              <a href="#" id="share-github" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #333333; color: #fff; font-size: 1.6rem;"><i class="bi bi-github"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">GitHub</span>
              </a>
              <a href="#" id="share-wordpress" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #21759B; color: #fff; font-size: 1.6rem;"><i class="bi bi-wordpress"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">WordPress</span>
              </a>
              <a href="#" id="share-dribbble" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #EA4C89; color: #fff; font-size: 1.6rem;"><i class="bi bi-dribbble"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Dribbble</span>
              </a>
              <a href="#" id="share-weibo" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #DF2029; color: #fff; font-size: 1.6rem;"><i class="bi bi-eye-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Weibo</span>
              </a>
              <a href="#" id="share-qq" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #12B7F5; color: #fff; font-size: 1.6rem;"><i class="bi bi-chat-dots-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Tencent QQ</span>
              </a>
              <a href="#" id="share-kakaotalk" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #FEE500; color: #000; font-size: 1.6rem;"><i class="bi bi-chat-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">KakaoTalk</span>
              </a>
              <a href="#" id="share-viber" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #7360F2; color: #fff; font-size: 1.6rem;"><i class="bi bi-telephone-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Viber</span>
              </a>
              <a href="#" id="share-signal" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #3A76F0; color: #fff; font-size: 1.6rem;"><i class="bi bi-chat-square-dots-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Signal</span>
              </a>
              <a href="#" id="share-buffer" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #232428; color: #fff; font-size: 1.6rem;"><i class="bi bi-layers-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Buffer</span>
              </a>
              <a href="#" id="share-digg" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #000000; border: 1px solid #333; color: #fff; font-size: 1.6rem;"><i class="bi bi-hand-thumbs-up-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Digg</span>
              </a>
              <a href="#" id="share-douban" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #007722; color: #fff; font-size: 1.6rem;"><i class="bi bi-book-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Douban</span>
              </a>
              <a href="#" id="share-trello" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #0079BF; color: #fff; font-size: 1.6rem;"><i class="bi bi-kanban-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Trello</span>
              </a>
              <a href="#" id="share-xing" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #006567; color: #fff; font-size: 1.6rem;"><i class="bi bi-x-diamond-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Xing</span>
              </a>
              <a href="#" id="share-yammer" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #0072C6; color: #fff; font-size: 1.6rem;"><i class="bi bi-yelp"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Yammer</span>
              </a>
              <a href="#" id="share-blogger" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #FF5722; color: #fff; font-size: 1.6rem;"><i class="bi bi-pen-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Blogger</span>
              </a>
              <a href="#" id="share-evernote" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #00A82D; color: #fff; font-size: 1.6rem;"><i class="bi bi-journal-check"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Evernote</span>
              </a>
              <a href="#" id="share-mewe" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #006E98; color: #fff; font-size: 1.6rem;"><i class="bi bi-people-fill"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">MeWe</span>
              </a>
              <a href="#" id="share-diaspora" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #000000; border: 1px solid #333; color: #fff; font-size: 1.6rem;"><i class="bi bi-asterisk"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Diaspora</span>
              </a>
              <a href="#" id="share-taringa" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #015697; color: #fff; font-size: 1.6rem;"><i class="bi bi-globe"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Taringa</span>
              </a>
              <a href="#" id="share-teams" target="_blank" class="text-decoration-none d-flex flex-column align-items-center share-platform-btn" style="scroll-snap-align: start; min-width: 60px;">
                <div class="icon-box rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" style="width: 55px; height: 55px; background: #6264A7; color: #fff; font-size: 1.6rem;"><i class="bi bi-microsoft"></i></div><span class="text-secondary text-truncate w-100 text-center" style="font-size: 0.7rem;">Teams</span>
              </a>
            </div>
            
            <p class="small text-secondary fw-bold mb-2 mt-3 text-uppercase" style="letter-spacing: 1px;">Copy Link</p>
            <div class="input-group">
              <input type="text" class="form-control bg-dark border-secondary text-white rounded-start-pill ps-4" id="share-url-input" readonly>
              <button class="btn btn-danger px-4 rounded-end-pill fw-bold" type="button" id="copy-share-url-btn">Copy</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="embed-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white"><i class="bi bi-code-slash text-info me-2"></i>Embed Song</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-light p-4">
            <p class="text-secondary text-center mb-3">Copy the HTML snippet below to embed this song onto your website or blog.</p>
            <div id="embed-preview-container" class="mb-4"></div>
            <div class="input-group">
              <input type="text" class="form-control bg-dark text-info border-secondary font-monospace" id="embed-code-input" readonly>
              <button class="btn btn-danger fw-bold px-4" type="button" id="copy-embed-code-btn"><i class="bi bi-clipboard"></i> Copy</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="rescan-options-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white"><i class="bi bi-arrow-repeat text-info me-2"></i> Re-scan Options</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4 text-center">
            <p class="text-secondary small mb-4">Choose how you want to re-scan your library. Forced rescans will ignore file modification times and update the database directly from the ID3 tags. Useful for fixing corrupted metadata or missing artists.</p>
            <div class="d-flex flex-column gap-3">
              <button class="btn btn-outline-light fw-bold py-2" id="btn-rescan-artists" data-bs-dismiss="modal"><i class="bi bi-people-fill me-2"></i> Re-scan Artists Only</button>
              <button class="btn btn-outline-light fw-bold py-2" id="btn-rescan-songs" data-bs-dismiss="modal"><i class="bi bi-music-note-list me-2"></i> Re-scan Songs Metadata</button>
              <button class="btn btn-danger fw-bold py-2" id="btn-rescan-all" data-bs-dismiss="modal"><i class="bi bi-hdd-stack-fill me-2"></i> Full Forced Re-scan (Everything)</button>
              <hr class="border-secondary opacity-50 my-1">
              <button class="btn btn-outline-warning fw-bold py-2" id="btn-rescan-standard" data-bs-dismiss="modal"><i class="bi bi-search me-2"></i> Standard Scan (New files only)</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="emergency-scan-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #ff0000; box-shadow: 0 0 20px rgba(255, 0, 0, 0.4);">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Database Empty</h5>
          </div>
          <div class="modal-body text-center p-4">
            <i class="bi bi-hdd-stack text-secondary mb-3" style="font-size: 3.5rem; display: block;"></i>
            <h5 class="text-white mb-3">Scan Library First!</h5>
            <p class="text-secondary mb-4">Your music database is completely empty. Please run the Full Library Scan to analyze your files and build the database so the site can function.</p>
            <button class="btn btn-danger w-100 fw-bold py-2" id="trigger-emergency-scan-btn" data-bs-dismiss="modal">
              <i class="bi bi-search me-1"></i> Scan Library Now
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="full-scan-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header border-0 d-flex align-items-center flex-nowrap gap-3">
            <div class="marquee-container flex-grow-1 m-0" style="min-width: 0;">
              <h5 class="modal-title m-0 text-nowrap marquee-content scan-title-marquee">Full Library Scan Log</h5>
            </div>
            <div class="d-flex align-items-center flex-shrink-0">
              <button type="button" class="btn btn-outline-light btn-sm me-3 hide-any-scan-btn" data-target="full-scan-modal"><i class="bi bi-dash-lg"></i> Hide</button>
              <button type="button" class="btn-close btn-close-white m-0" data-bs-dismiss="modal"></button>
            </div>
          </div>
          <div class="modal-body p-0">
            <iframe id="full-scan-iframe" src="about:blank" style="width: 100%; height: 60vh; border: none; background-color: #030303;"></iframe>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="chart-scan-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header border-0 d-flex align-items-center flex-nowrap gap-3">
            <div class="marquee-container flex-grow-1 m-0" style="min-width: 0;">
              <h5 class="modal-title m-0 text-nowrap marquee-content scan-title-marquee">Rhythm Game Charts Scanner Log</h5>
            </div>
            <div class="d-flex align-items-center flex-shrink-0">
              <button type="button" class="btn btn-outline-light btn-sm me-3 hide-any-scan-btn" data-target="chart-scan-modal"><i class="bi bi-dash-lg"></i> Hide</button>
              <button type="button" class="btn-close btn-close-white m-0" data-bs-dismiss="modal"></button>
            </div>
          </div>
          <div class="modal-body p-0">
            <iframe id="chart-scan-iframe" src="about:blank" style="width: 100%; height: 60vh; border: none; background-color: #030303;"></iframe>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="chart-config-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-sliders text-danger me-2"></i> Adjust Chart Scan</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4 text-white">
            <label class="form-label text-secondary small fw-bold mb-2">CHART DENSITY MODIFIER</label>
            <div style="position: relative; display: flex; align-items: center; margin-bottom: 1.5rem;">
              <select id="rhythm-global-density-select" class="form-control bg-dark text-white border-secondary" style="appearance: none; -webkit-appearance: none; padding-right: 48px; cursor: pointer; z-index: 1; height: 45px; font-weight: 500;">
                <option value="0.5">0.5x (Very Sparse - Casual)</option>
                <option value="0.8">0.8x (Sparse)</option>
                <option value="1.0">1.0x (Neutral / Standard 3x)</option>
                <option value="1.2">1.2x (Dense)</option>
                <option value="1.5">1.5x (Very Dense)</option>
                <option value="2.0">2.0x (Extreme / 6x)</option>
              </select>
              <i class="bi bi-chevron-down text-secondary" style="position: absolute; right: 16px; pointer-events: none; font-size: 1.2rem; z-index: 2;"></i>
            </div>
            <button type="button" class="btn btn-danger w-100 fw-bold mb-3" id="save-rhythm-global-density-btn" style="height: 45px;">Save Settings</button>
            <hr class="border-secondary opacity-50 mb-3">
            <button type="button" class="btn btn-outline-warning w-100 fw-bold" id="vacuum-database-btn" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#vacuum-modal" style="height: 45px;"><i class="bi bi-database-fill-gear me-1"></i> Optimize Storage</button>
            <div class="text-secondary small mt-2 text-center" style="line-height: 1.4;">Frees up disk space by removing remnants of old replaced charts. Does not delete active data.</div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="vacuum-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title">Database Optimization Log</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-0">
            <iframe id="vacuum-iframe" src="about:blank" style="width: 100%; height: 60vh; border: none; background-color: #030303;"></iframe>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="rg-player-stats-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #030303; border: 1px solid #333; border-radius: 16px;">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-controller text-danger me-2"></i> Player History</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4" id="rg-player-stats-body">
            <!-- Populated dynamically via JS -->
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="rg-how-to-play-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content" style="background-color: var(--ytm-bg); border: none;">
          <div class="modal-header border-0 pb-2 px-4" style="border-bottom: 1px solid var(--ytm-surface-2) !important; background-color: var(--ytm-surface);">
            <h5 class="modal-title text-white fw-bold"><i class="bi bi-info-circle-fill text-info me-2"></i>How to Play: Rhythm Game</h5>
            <button type="button" class="btn-close btn-close-white fs-5" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-light px-4 py-4 mx-auto" style="width: 100%;">
            
            <div class="text-center mb-5 mt-2">
              <i class="bi bi-controller text-danger" style="font-size: 4rem;"></i>
              <h2 class="fw-bold mt-3 text-white">Master the Beat</h2>
              <p class="text-secondary">Learn the core mechanics, note types, and scoring system to climb the leaderboards.</p>
            </div>

            <div class="d-flex flex-column gap-3">
              
              <h5 class="text-white mt-2 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Note Types</h5>
              
              <!-- Tap Notes -->
              <div class="d-flex flex-column p-4 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-4 mb-3">
                  <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                    <svg width="60" height="20" viewBox="0 0 60 20" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0" y="0" width="60" height="20" fill="#00d2ff" stroke="#ffffff" stroke-width="2" rx="4"/>
                      <line x1="10" y1="10" x2="50" y2="10" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                  </div>
                  <div>
                    <span class="fw-bold text-white fs-4 d-block mb-1">Tap Notes (Cyan)</span>
                    <span class="text-secondary" style="font-size: 0.9rem;">The standard note. Tap the corresponding lane key exactly when the note aligns with the red judgment line at the bottom.</span>
                  </div>
                </div>
              </div>

              <!-- Hold Notes -->
              <div class="d-flex flex-column p-4 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-4 mb-3">
                  <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 100px;">
                    <svg width="60" height="90" viewBox="0 0 60 90" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0" y="0" width="60" height="90" fill="rgba(46, 204, 113, 0.4)" stroke="#2ecc71" stroke-width="2" rx="4"/>
                      <rect x="0" y="0" width="60" height="20" fill="#2ecc71" stroke="#ffffff" stroke-width="2" rx="4"/>
                      <line x1="10" y1="10" x2="50" y2="10" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                  </div>
                  <div>
                    <span class="fw-bold text-white fs-4 d-block mb-1">Hold Notes (Green)</span>
                    <span class="text-secondary" style="font-size: 0.9rem;">Press and hold the key when the bottom of the note reaches the line, and release it exactly when the top tail passes. Letting go too early breaks your combo.</span>
                  </div>
                </div>
              </div>

              <!-- Swipe Notes -->
              <div class="d-flex flex-column p-4 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-4 mb-3">
                  <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                    <svg width="60" height="20" viewBox="0 0 60 20" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0" y="0" width="60" height="20" fill="#ff4da6" stroke="#ffffff" stroke-width="2" rx="4"/>
                      <polyline points="20,14 30,6 40,14" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <div>
                    <span class="fw-bold text-white fs-4 d-block mb-1">Flick Notes (Pink)</span>
                    <span class="text-secondary" style="font-size: 0.9rem;">Swipe up or quickly flick your finger/mouse on the lane when it hits the line. On desktop, releasing the key rapidly counts as a flick.</span>
                  </div>
                </div>
              </div>

              <!-- Hold + Swipe Notes -->
              <div class="d-flex flex-column p-4 rounded mt-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="d-flex align-items-center gap-4 mb-3">
                  <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 100px;">
                    <svg width="60" height="90" viewBox="0 0 60 90" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0" y="0" width="60" height="90" fill="rgba(255, 77, 166, 0.4)" stroke="#ff4da6" stroke-width="2" rx="4"/>
                      <rect x="0" y="0" width="60" height="20" fill="#ff4da6" stroke="#ffffff" stroke-width="2" rx="4"/>
                      <polyline points="20,14 30,6 40,14" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <div>
                    <span class="fw-bold text-white fs-4 d-block mb-1">Hold + Flick Notes</span>
                    <span class="text-secondary" style="font-size: 0.9rem;">A combination of Hold and Flick. Keep the key pressed during the transparent body, and release it with a flick/swipe exactly as the pink tail passes the judgment line.</span>
                  </div>
                </div>
              </div>

              <h5 class="text-white mt-4 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Navigation & Difficulties</h5>
              
              <div class="p-4 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <ul class="text-secondary mb-0" style="font-size: 0.95rem; line-height: 1.8;">
                  <li><strong class="text-white"><i class="bi bi-compass text-info"></i> Hub Navigation:</strong> Use the bottom navigation bar to switch between <strong>Songs</strong>, <strong>Artists</strong>, <strong>Favorites</strong>, <strong>Ranks</strong>, your <strong>Profile</strong>, or <strong>Offline</strong> tracks.</li>
                  <li><strong class="text-white"><i class="bi bi-bar-chart-fill text-warning"></i> Difficulty Scaling:</strong>
                    <ul class="mt-1 mb-2">
                      <li><strong>Easy / Normal:</strong> Uses 4 lanes (D, F, J, K). Best for beginners.</li>
                      <li><strong>Hard / Expert / Master:</strong> Uses 6 lanes (S, D, F, J, K, L). Requires faster reaction times.</li>
                      <li><strong>Demon:</strong> Uses all 10 lanes! <span class="text-danger fw-bold">Requires Landscape orientation on mobile devices.</span></li>
                    </ul>
                  </li>
                  <li><strong class="text-white"><i class="bi bi-robot text-primary"></i> Autoplay (Bot Mode):</strong> Toggle "Autoplay" on the song menu to let the bot achieve a perfect score automatically. <i>Note: Autoplay scores are not saved to the leaderboards.</i></li>
                </ul>
              </div>

              <h5 class="text-white mt-4 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Scoring & Ranks</h5>
              
              <div class="p-4 rounded" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                <div class="row g-3 text-center mb-4">
                  <div class="col-3">
                    <div class="fw-bold fs-5 text-white">PERFECT</div>
                    <div class="text-success small">Â±45ms</div>
                    <div class="text-secondary small">100% Acc</div>
                  </div>
                  <div class="col-3">
                    <div class="fw-bold fs-5" style="color: #ff3b30;">GREAT</div>
                    <div class="text-success small">Â±80ms</div>
                    <div class="text-secondary small">75% Acc</div>
                  </div>
                  <div class="col-3">
                    <div class="fw-bold fs-5" style="color: #ffa000;">GOOD</div>
                    <div class="text-success small">Â±125ms</div>
                    <div class="text-secondary small">40% Acc</div>
                  </div>
                  <div class="col-3">
                    <div class="fw-bold fs-5" style="color: #8e1c1c;">BAD / MISS</div>
                    <div class="text-danger small">&gt;125ms</div>
                    <div class="text-secondary small">Breaks Combo</div>
                  </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                  <span class="badge bg-danger text-white fs-6 px-3 py-2">SS <small>(98%+)</small></span>
                  <span class="badge bg-warning text-dark fs-6 px-3 py-2">S <small>(95%+)</small></span>
                  <span class="badge text-white fs-6 px-3 py-2" style="background: #a78bfa;">A <small>(90%+)</small></span>
                  <span class="badge text-white fs-6 px-3 py-2" style="background: #60a5fa;">B <small>(80%+)</small></span>
                  <span class="badge text-dark fs-6 px-3 py-2" style="background: #34d399;">C <small>(70%+)</small></span>
                </div>
              </div>

              <h5 class="text-white mt-4 mb-2 fw-bold" style="border-bottom: 2px solid #444; padding-bottom: 8px;">Tips & Settings</h5>
              <ul class="text-secondary" style="font-size: 0.95rem; line-height: 1.8;">
                <li><strong class="text-white">Calibration:</strong> If notes feel out of sync with the beat, use the Calibration Tool in the Settings tab to adjust your audio offset (in milliseconds).</li>
                <li><strong class="text-white">Note Speed:</strong> Adjusting the Tick Speed in settings spreads the notes further apart, making fast sections easier to read without altering the song's BPM.</li>
                <li><strong class="text-white">HP Bar:</strong> Missing notes drains your green health bar. If it empties completely, you fail the stage!</li>
                <li><strong class="text-white">Anti-Cheat:</strong> The server actively detects inhuman macros and auto-clickers. Do not use scripts, or you will be permanently banned.</li>
              </ul>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="cover-scan-modal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header border-0 d-flex align-items-center flex-nowrap gap-3">
            <div class="marquee-container flex-grow-1 m-0" style="min-width: 0;">
              <h5 class="modal-title m-0 text-nowrap marquee-content scan-title-marquee">Re-scan Empty Cover Arts Log</h5>
            </div>
            <div class="d-flex align-items-center flex-shrink-0">
              <button type="button" class="btn btn-outline-light btn-sm me-3 hide-any-scan-btn" data-target="cover-scan-modal"><i class="bi bi-dash-lg"></i> Hide</button>
              <button type="button" class="btn-close btn-close-white m-0" data-bs-dismiss="modal"></button>
            </div>
          </div>
          <div class="modal-body p-0">
            <iframe id="cover-scan-iframe" src="about:blank" style="width: 100%; height: 60vh; border: none; background-color: #030303;"></iframe>
          </div>
        </div>
      </div>
    </div>

    <!-- Beautiful Scanning Pill -->
    <div id="scan-progress-pill" class="d-none shadow-lg rounded-pill" style="position: fixed; left: 50%; transform: translateX(-50%); background-color: var(--ytm-surface-2); border: 1px solid var(--ytm-accent); z-index: 9999; min-width: 270px; height: 52px; padding: 0 16px;">
      <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; height: 100%;">
        <div style="display: flex; align-items: center; gap: 12px; height: 100%;">
          <div id="scan-pill-spinner" class="spinner-border text-danger" role="status" style="width: 20px; height: 20px; border-width: 2.5px; flex-shrink: 0; margin: 0;"></div>
          <div style="display: flex; flex-direction: column; justify-content: center; height: 100%;">
            <div id="scan-pill-title" style="color: #ffffff; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; margin: 0; padding: 0; line-height: 1.2;">Scanning</div>
            <div id="scan-pill-stats" style="color: #aaaaaa; font-weight: 700; font-size: 11px; font-family: monospace; margin: 0; padding: 0; line-height: 1.2; margin-top: 2px;">0 / 0</div>
          </div>
        </div>
        <button id="show-scan-modal-btn" class="btn btn-sm btn-danger rounded-pill fw-bold" style="font-size: 12px; height: 32px; padding: 0 14px; display: inline-flex; align-items: center; justify-content: center; gap: 6px; margin: 0; flex-shrink: 0; border: none; line-height: 1;">
          <i class="bi bi-arrows-angle-expand" style="font-size: 12px; line-height: 1;"></i> View
        </button>
      </div>
    </div>
    
    <div class="modal fade" id="update-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface);">
          <div class="modal-header border-0">
            <h5 class="modal-title"><i class="bi bi-arrow-clockwise"></i> Check for Updates</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center" id="update-modal-body">
            <!-- Dynamic Content populated by JS -->
          </div>
        </div>
      </div>
    </div>

    <!-- MAIN COMPREHENSIVE API MODAL -->
    <div class="modal fade" id="api-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content" style="background-color: var(--ytm-bg);">
          
          <div class="modal-header border-0 align-items-center px-4 py-3" style="border-bottom: 1px solid var(--ytm-surface-2) !important; background-color: var(--ytm-surface);">
            <h4 class="modal-title text-white m-0 fw-bold"><i class="bi bi-code-slash text-danger me-2"></i> Developer API Documentation</h4>
            <div class="d-flex gap-3 align-items-center">
              <button type="button" class="btn-close btn-close-white ms-2 fs-5" data-bs-dismiss="modal"></button>
            </div>
          </div>

          <div class="modal-body p-0 d-flex flex-column flex-lg-row h-100 overflow-hidden">
            
            <!-- DESKTOP LEFT SIDEBAR: API ENDPOINT NAVIGATOR -->
            <div class="api-sidebar border-end border-secondary d-none d-lg-flex flex-column" style="width: 350px; background-color: var(--ytm-surface-2); overflow-y: auto; flex-shrink: 0;">
              <div class="p-3 border-bottom border-secondary position-sticky top-0 bg-dark z-3 shadow-sm">
                <h6 class="text-white m-0 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.85rem;"><i class="bi bi-list-nested me-2 text-danger"></i> Endpoint Index</h6>
              </div>
              <ul class="nav nav-pills flex-column p-3 gap-2" id="api-docs-scrollspy">
                
                <li class="nav-item mt-2"><span class="nav-link text-secondary fw-bold small text-uppercase disabled py-1" style="letter-spacing: 1px; border-bottom: 1px solid #444;">Library Data</span></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_songs"><i class="bi bi-music-note-list text-info me-2 fs-5"></i> Get All Songs</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_artists"><i class="bi bi-people-fill text-info me-2 fs-5"></i> Get Artists</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_albums"><i class="bi bi-disc-fill text-info me-2 fs-5"></i> Get Albums</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_genres"><i class="bi bi-tags-fill text-info me-2 fs-5"></i> Get Genres</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_years"><i class="bi bi-calendar-event-fill text-info me-2 fs-5"></i> Get Years</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-search"><i class="bi bi-search text-info me-2 fs-5"></i> Search Library</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_song_data"><i class="bi bi-info-circle-fill text-info me-2 fs-5"></i> Get Song Metadata</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_playlist_songs"><i class="bi bi-music-note-beamed text-info me-2 fs-5"></i> Get Playlist Songs</a></li>
                
                <li class="nav-item mt-4"><span class="nav-link text-secondary fw-bold small text-uppercase disabled py-1" style="letter-spacing: 1px; border-bottom: 1px solid #444;">Media & Streaming</span></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_stream"><i class="bi bi-play-circle-fill text-warning me-2 fs-5"></i> Stream Audio Data</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_image"><i class="bi bi-image text-warning me-2 fs-5"></i> Get Cover Art</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_profile_picture"><i class="bi bi-person-bounding-box text-warning me-2 fs-5"></i> Get User Avatar</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-download_song"><i class="bi bi-download text-warning me-2 fs-5"></i> Download MP3 File</a></li>
                
                <li class="nav-item mt-4"><span class="nav-link text-secondary fw-bold small text-uppercase disabled py-1" style="letter-spacing: 1px; border-bottom: 1px solid #444;">User & Discovery</span></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_explore"><i class="bi bi-compass-fill text-success me-2 fs-5"></i> Get Explore Hub</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_recommendations"><i class="bi bi-magic text-success me-2 fs-5"></i> Get For You AI</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_history"><i class="bi bi-clock-history text-success me-2 fs-5"></i> Get Play History</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_favorites"><i class="bi bi-heart-fill text-success me-2 fs-5"></i> Get Favorites</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_user_playlists"><i class="bi bi-collection-play-fill text-success me-2 fs-5"></i> Get User Playlists</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_collab_playlists"><i class="bi bi-people-fill text-success me-2 fs-5"></i> Get Shared Playlists</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-get_session"><i class="bi bi-shield-check text-success me-2 fs-5"></i> Get Session Config</a></li>

                <li class="nav-item mt-4"><span class="nav-link text-secondary fw-bold small text-uppercase disabled py-1" style="letter-spacing: 1px; border-bottom: 1px solid #444;">State Mutations (POST)</span></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-toggle_favorite"><i class="bi bi-heart text-danger me-2 fs-5"></i> Toggle Favorite</a></li>
                <li class="nav-item"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-log_play"><i class="bi bi-play-circle text-danger me-2 fs-5"></i> Log Play Count</a></li>
                <li class="nav-item mb-5"><a class="nav-link text-white py-2 px-3 rounded" href="#doc-create_playlist"><i class="bi bi-plus-circle text-danger me-2 fs-5"></i> Create Playlist</a></li>
              </ul>
            </div>

            <!-- RIGHT SIDEBAR: DOCUMENTATION & PLAYGROUND -->
            <div class="api-content flex-grow-1 overflow-auto position-relative" data-bs-spy="scroll" data-bs-target="#api-docs-scrollspy" data-bs-smooth-scroll="true" tabindex="0" style="background-color: var(--ytm-bg);">
              
              <!-- MOBILE STICKY NAVIGATOR -->
              <div class="d-block d-lg-none sticky-top bg-dark p-3 border-bottom border-secondary z-3 shadow-lg" style="top: 0;">
                <label class="form-label text-white small fw-bold mb-1" style="letter-spacing: 1px;"><i class="bi bi-list-ul text-danger me-1"></i> JUMP TO ENDPOINT</label>
                <select class="form-select form-select-lg bg-black text-white border-secondary fw-bold shadow-sm" id="mobile-api-nav-select" onchange="document.getElementById(this.value).scrollIntoView({behavior: 'smooth', block: 'start'});">
                  <optgroup label="Library Data (GET)">
                    <option value="doc-get_songs">1. Get All Songs</option>
                    <option value="doc-get_artists">2. Get Artists</option>
                    <option value="doc-get_albums">3. Get Albums</option>
                    <option value="doc-get_genres">4. Get Genres</option>
                    <option value="doc-get_years">5. Get Years</option>
                    <option value="doc-search">6. Search Library</option>
                    <option value="doc-get_song_data">7. Get Song Metadata</option>
                    <option value="doc-get_playlist_songs">8. Get Playlist Songs</option>
                  </optgroup>
                  <optgroup label="Media & Streaming (GET)">
                    <option value="doc-get_stream">9. Stream Audio Data</option>
                    <option value="doc-get_image">10. Get Cover Art Image</option>
                    <option value="doc-get_profile_picture">11. Get User Avatar</option>
                    <option value="doc-download_song">12. Download MP3 File</option>
                  </optgroup>
                  <optgroup label="User & Discovery (GET)">
                    <option value="doc-get_explore">13. Get Explore Hub</option>
                    <option value="doc-get_recommendations">14. Get For You AI</option>
                    <option value="doc-get_history">15. Get Play History</option>
                    <option value="doc-get_favorites">16. Get User Favorites</option>
                    <option value="doc-get_user_playlists">17. Get User Playlists</option>
                    <option value="doc-get_collab_playlists">18. Get Shared Playlists</option>
                    <option value="doc-get_session">19. Get Session Data</option>
                  </optgroup>
                  <optgroup label="State Mutations (POST)">
                    <option value="doc-toggle_favorite">20. Toggle Favorite (POST)</option>
                    <option value="doc-log_play">21. Log Song Play (POST)</option>
                    <option value="doc-create_playlist">22. Create Playlist (POST)</option>
                  </optgroup>
                </select>
              </div>

              <!-- INTERACTIVE PLAYGROUND BOX -->
              <div class="p-4 p-md-5" style="background-color: var(--ytm-surface); border-bottom: 2px solid var(--ytm-accent);">
                <h4 class="text-white mb-3 fw-bold"><i class="bi bi-terminal-fill me-2 text-primary"></i> Live Request Playground</h4>
                <p class="text-secondary fs-6 mb-4" style="max-width: 900px;">Select an endpoint below to immediately generate the secure URL string and test the live JSON response returned straight from your SQLite database. The iframe below executes the generated query using your locally cached Admin Key.</p>
                
                <div class="mb-4">
                  <label for="custom-api-key-input" class="form-label text-white small fw-bold" style="letter-spacing: 1px;">YOUR API KEY</label>
                  <input type="text" id="custom-api-key-input" class="form-control bg-dark text-white border-secondary" placeholder="Enter your API Key (pk_...)">
                </div>
                <div class="row g-4 align-items-end">
                  <div class="col-lg-5">
                    <label for="api-action-select" class="form-label text-white small fw-bold" style="letter-spacing: 1px;">ENDPOINT ACTION</label>
                    <select class="form-select form-select-lg bg-dark text-white border-secondary shadow-sm" id="api-action-select">
                      <optgroup label="Library Data (GET)">
                        <option value="get_songs">Fetch All Songs</option>
                        <option value="get_artists">Fetch Artists</option>
                        <option value="get_albums">Fetch Albums</option>
                        <option value="get_genres">Fetch Genres</option>
                        <option value="get_explore">Fetch Explore / Discovery Data</option>
                        <option value="search&q=YOUR_QUERY">Search Music</option>
                        <option value="get_song_data&id=SONG_ID">Get Song Metadata</option>
                        <option value="get_playlist_songs&public_id=PLAYLIST_ID">Get Playlist Songs</option>
                      </optgroup>
                      <optgroup label="Media & Files (GET)">
                        <option value="get_stream&id=SONG_ID">Stream Audio Data</option>
                        <option value="get_image&id=SONG_ID">Get Cover Art Image</option>
                        <option value="get_profile_picture&id=USER_ID">Get User Profile Picture</option>
                        <option value="download_song&id=SONG_ID">Download MP3 File</option>
                      </optgroup>
                      <optgroup label="User Data (GET)">
                        <option value="get_session">Get Current Logged-in User</option>
                        <option value="get_favorites">Get User Favorites</option>
                        <option value="get_history">Get Playback History</option>
                        <option value="get_user_playlists">Get User Playlists</option>
                        <option value="get_recommendations">Get Personalized Recommendations</option>
                      </optgroup>
                      <optgroup label="Interactions (POST)">
                        <option value="toggle_favorite" data-method="POST" data-body='{"id": 123}'>Toggle Favorite</option>
                        <option value="log_play" data-method="POST" data-body='{"id": 123, "played_at": "2026-06-28T14:27:00.000Z"}'>Log Song Play</option>
                        <option value="create_playlist" data-method="POST" data-body='{"name": "My API Playlist", "is_private": 0}'>Create Playlist</option>
                      </optgroup>
                    </select>
                  </div>
                  <div class="col-lg-7">
                    <label class="form-label text-white d-flex justify-content-between small fw-bold" style="letter-spacing: 1px;">
                      <span>GENERATED ENDPOINT URL</span>
                      <span id="api-method-badge" class="badge bg-primary fs-6 shadow-sm">GET</span>
                    </label>
                    <div class="input-group input-group-lg shadow-sm flex-nowrap rounded-3 overflow-hidden" style="border: 1px solid var(--ytm-surface-2);">
                      <input type="text" class="form-control bg-dark text-info border-0 font-monospace fs-6 py-3 px-4" id="api-url-input" readonly style="min-width: 0; background-color: #0b0b0b !important;">
                      <button class="btn btn-danger fw-bold px-4 flex-shrink-0 d-inline-flex align-items-center gap-2 border-0" type="button" id="copy-api-btn" style="transition: all 0.2s ease-in-out; background-color: var(--ytm-accent) !important;"><i class="bi bi-clipboard2-data-fill"></i> Copy</button>
                    </div>
                  </div>
                </div>

                <div class="bg-black p-4 rounded border border-secondary mt-4 d-none shadow-sm" id="api-payload-container">
                  <h6 class="text-white mb-2 text-uppercase fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;"><i class="bi bi-filetype-json text-warning me-2"></i> Required JSON Body Payload</h6>
                  <pre class="m-0"><code class="text-warning font-monospace fs-6" id="api-payload-code"></code></pre>
                </div>
                
                <div class="mt-4 pt-2">
                  <ul class="nav nav-tabs border-secondary mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active bg-dark text-white border-secondary border-bottom-0 fw-bold px-4 py-2" data-bs-toggle="tab" data-bs-target="#api-tab-json" type="button" role="tab"><i class="bi bi-filetype-json text-warning me-2"></i> Raw JSON Response</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link bg-transparent text-secondary border-0 fw-bold px-4 py-2" id="api-visual-tab-btn" data-bs-toggle="tab" data-bs-target="#api-tab-visual" type="button" role="tab"><i class="bi bi-play-circle-fill text-danger me-2"></i> Visual Client Tester</button>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="api-tab-json" role="tabpanel">
                      <iframe id="api-example-iframe" class="w-100 rounded border border-secondary shadow-lg" style="height: 400px; background-color: #050505; overflow: auto; display: block;" src="about:blank"></iframe>
                    </div>
                    <div class="tab-pane fade" id="api-tab-visual" role="tabpanel">
                      <div class="iframe-container shadow-lg" id="api-visual-container" style="width: 100%; aspect-ratio: 16/9; position: relative; overflow: hidden; border: 1px solid var(--ytm-surface-2); border-radius: 8px; background-color: #030303; cursor: pointer;">
                        <iframe id="api-visual-iframe" style="position: absolute; top: 0; left: 0; border: none; overflow: hidden; width: 1280px; height: 720px; transform-origin: 0 0;" src="about:blank"></iframe>
                        <button id="api-visual-open-tab-btn" class="btn btn-dark rounded-circle" style="position: absolute; bottom: 15px; right: 70px; z-index: 10; width: 44px; height: 44px; background: rgba(0,0,0,0.8); border: 1px solid rgba(255,255,255,0.2); color: #fff; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease-in-out;" title="Open Playground in Standalone Tab"><i class="bi bi-box-arrow-up-right"></i></button>
                        <button id="api-visual-fullscreen-btn" class="btn btn-dark rounded-circle" style="position: absolute; bottom: 15px; right: 15px; z-index: 10; width: 44px; height: 44px; background: rgba(0,0,0,0.8); border: 1px solid rgba(255,255,255,0.2); color: #fff; display: flex; align-items: center; justify-content: center;" title="Fullscreen"><i class="bi bi-fullscreen"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- MASSIVE DOCUMENTATION START -->
              <div class="p-4 p-md-5 text-light" style="max-width: 1100px; margin: 0 auto;">

                <div class="text-center mb-5 pb-5 border-bottom border-secondary">
                  <h1 class="fw-bold text-white mb-4" style="font-size: clamp(2.5rem, 5vw, 4rem);">PHP Music Core API</h1>
                  <p class="text-secondary fs-5 mx-auto" style="line-height: 1.7;">Welcome to the comprehensive reference documentation. This manual details the endpoints for querying database entities, streaming byte ranges, extracting binary blobs, and manipulating state via the RESTful JSON interface. All endpoints are protected by CORS firewalls and require strict Master Key authentication to access externally.</p>
                </div>

                <!-- 1. GET SONGS -->
                <section id="doc-get_songs" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-primary fs-5 px-4 py-2 shadow-sm">GET</span>
                    <h2 class="text-white fw-bold m-0" style="font-size: 2.2rem;">Retrieve All Songs</h2>
                  </div>
                  
                  <div class="bg-black p-4 rounded border border-secondary mb-4 shadow-sm">
                    <code class="text-success fw-bold fs-5">GET</code> <code class="text-light ms-2 fs-6">/?access=api&action=get_songs&api_key=YOUR_ADMIN_KEY</code>
                  </div>

                  <h5 class="text-white mt-4 fw-bold">Overview</h5>
                  <p class="text-secondary" style="font-size: 1.05rem; line-height: 1.7;">This is the primary pipeline for fetching your music library. It retrieves a highly optimized, paginated array of song entities from the SQLite database. The backend automatically enforces strict privacy checks, entirely omitting tracks marked as <code>is_private=1</code> unless the <code>filter_user_id</code> specifically matches the track owner, or the global <code>api_key</code> bypass is initiated. Furthermore, it dynamically computes and attaches the <code>play_count</code> integer by executing a fast subquery against the <code>play_counts</code> relationship table.</p>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-danger ps-3">Query Parameters</h5>
                  <div class="table-responsive bg-dark rounded border border-secondary mb-5 shadow-sm mt-3">
                    <table class="table table-dark table-borderless table-striped m-0">
                      <thead class="border-bottom border-secondary">
                        <tr><th class="py-3 px-4">Parameter</th><th class="py-3 px-4">Type</th><th class="py-3 px-4">Required</th><th class="py-3 px-4">Description</th></tr>
                      </thead>
                      <tbody>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">access</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-success">Yes</span></td><td class="py-3 px-4 text-secondary">Must be exactly <code class="text-light">api</code> to bypass the HTML renderer and trigger the JSON header response.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">action</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-success">Yes</span></td><td class="py-3 px-4 text-secondary">Must be exactly <code class="text-light">get_songs</code>.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">api_key</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-success">Yes</span></td><td class="py-3 px-4 text-secondary">The master Admin Password established in <code>index.php</code>. Requests without this will drop a 401 Unauthorized block.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">page</code></td><td class="py-3 px-4 text-info">integer</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Pagination multiplier. Defaults to <code class="text-light">1</code>. Multiplies against the global <code>PAGE_SIZE</code> constant (25).</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">sort</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Determines the ORDER BY clause. Options: <code class="text-light">id_desc</code>, <code class="text-light">id_asc</code>, <code class="text-light">artist_asc</code>, <code class="text-light">title_asc</code>, <code class="text-light">album_asc</code>, <code class="text-light">year_desc</code>. Defaults to <code class="text-light">id_desc</code>.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">artist</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">URL Encoded artist name. Filters the database using the internal <code>match_artist()</code> custom SQLite function for precise collision detection.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">filter_user_id</code></td><td class="py-3 px-4 text-info">integer</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Limits results strictly to tracks uploaded by this specific integer User ID.</td></tr>
                      </tbody>
                    </table>
                  </div>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-success ps-3">Code Integration Examples</h5>
                  <ul class="nav nav-tabs border-secondary mb-0 mt-3" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active bg-dark text-white border-secondary border-bottom-0 fw-bold px-4 py-3" data-bs-toggle="tab" data-bs-target="#js-1">Node.js / Fetch</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link bg-transparent text-secondary border-0 fw-bold px-4 py-3" data-bs-toggle="tab" data-bs-target="#py-1">Python</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link bg-transparent text-secondary border-0 fw-bold px-4 py-3" data-bs-toggle="tab" data-bs-target="#php-1">PHP cURL</button></li>
                  </ul>
                  <div class="tab-content mb-5">
                    <div class="tab-pane fade show active" id="js-1">
                      <pre class="bg-black p-4 rounded-bottom rounded-end border border-secondary text-light font-monospace m-0 shadow-sm" style="font-size: 0.9rem; overflow-x: auto;"><code>const fetchLibrary = async () => {
  const endpoint = 'https://yourdomain.com/?access=api&action=get_songs&api_key=YOUR_API_KEY&page=1&sort=title_asc';
  
  try {
    const response = await fetch(endpoint, {
      method: 'GET',
      headers: { 'Accept': 'application/json' }
    });
    
    if (!response.ok) {
      throw new Error(`HTTP Error: ${response.status}`);
    }
    
    const songs = await response.json();
    console.log(`Successfully fetched ${songs.length} tracks.`);
    
    // Map over the results
    songs.forEach(song => {
      console.log(`[${song.id}] ${song.title} - ${song.artist} (${song.duration}s)`);
    });
    
  } catch (error) {
    console.error('API Pipeline failed:', error);
  }
};

fetchLibrary();</code></pre>
                    </div>
                    <div class="tab-pane fade" id="py-1">
                      <pre class="bg-black p-4 rounded-bottom rounded-end border border-secondary text-light font-monospace m-0 shadow-sm" style="font-size: 0.9rem; overflow-x: auto;"><code>import requests
import json

def get_all_songs():
    url = "https://yourdomain.com/"
    
    payload = {
        "access": "api",
        "action": "get_songs",
        "api_key": "YOUR_API_KEY", # Replace with actual key
        "page": 1,
        "sort": "title_asc"
    }
    
    try:
        response = requests.get(url, params=payload, timeout=10)
        response.raise_for_status() # Trigger exception for 4xx/5xx errors
        
        data = response.json()
        print(f"Acquired {len(data)} music objects.")
        print(json.dumps(data[0], indent=2)) # Print first object beautifully
        
    except requests.exceptions.RequestException as e:
        print(f"Fatal System Error: {e}")

get_all_songs()</code></pre>
                    </div>
                    <div class="tab-pane fade" id="php-1">
                      <pre class="bg-black p-4 rounded-bottom rounded-end border border-secondary text-light font-monospace m-0 shadow-sm" style="font-size: 0.9rem; overflow-x: auto;"><code>&lt;?php
$url = "https://yourdomain.com/?access=api&action=get_songs&api_key=YOUR_API_KEY&page=1";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore if self-signed cert

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} elseif ($httpCode !== 200) {
    echo "HTTP Blocked: " . $httpCode;
} else {
    $songs = json_decode($response, true);
    print_r($songs);
}
curl_close($ch);
?&gt;</code></pre>
                    </div>
                  </div>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-info ps-3">Expected JSON Response (HTTP 200 OK)</h5>
                  <p class="text-secondary small mb-3">Returns an array of JSON objects. If the query yields no results, it strictly returns an empty array <code>[]</code>, never null.</p>
                  <pre class="bg-black p-4 rounded border border-secondary text-info font-monospace mb-4 shadow-sm" style="font-size: 0.9rem; overflow-x: auto;"><code>[
  {
    "id": 1042,
    "title": "Stairway to Heaven",
    "artist": "Led Zeppelin",
    "album": "Led Zeppelin IV",
    "genre": "Classic Rock",
    "duration": 482,
    "user_id": 1,
    "is_private": 0,
    "last_modified": 1698765432,
    "is_favorite": 1,
    "play_count": 8750
  },
  {
    "id": 1043,
    "title": "Hotel California",
    "artist": "Eagles",
    "album": "Hotel California",
    "genre": "Rock",
    "duration": 390,
    "user_id": 2,
    "is_private": 0,
    "last_modified": 1698765999,
    "is_favorite": 0,
    "play_count": 6420
  }
]</code></pre>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-warning ps-3">Error Responses & Troubleshooting</h5>
                  <div class="p-4 rounded bg-dark border border-secondary mt-3">
                    <p class="mb-2"><strong class="text-danger">HTTP 401 Unauthorized:</strong> Thrown if the <code>api_key</code> parameter is entirely missing, blank, or cryptographically invalid against the server's Master Password.</p>
                    <pre class="bg-black p-3 rounded border border-danger text-danger font-monospace mb-3 small"><code>{
  "status": "error",
  "message": "API access denied. Valid api_key (Admin Password) required."
}</code></pre>
                    <p class="mb-2"><strong class="text-warning">HTTP 429 Too Many Requests:</strong> Thrown if your script requests the endpoint more than 150 times within a 60-second rolling window.</p>
                    <p class="mb-0"><strong class="text-info">Pagination Empty:</strong> If you pass <code>page=9999</code> and it exceeds the database bounds, it safely returns <code>[]</code> without throwing a 404 exception.</p>
                  </div>
                </section>


                <!-- 2. GET ARTISTS -->
                <section id="doc-get_artists" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-primary fs-5 px-4 py-2 shadow-sm">GET</span>
                    <h2 class="text-white fw-bold m-0" style="font-size: 2.2rem;">Retrieve Artists Matrix</h2>
                  </div>
                  
                  <div class="bg-black p-4 rounded border border-secondary mb-4 shadow-sm">
                    <code class="text-success fw-bold fs-5">GET</code> <code class="text-light ms-2 fs-6">/?access=api&action=get_artists&api_key=YOUR_ADMIN_KEY</code>
                  </div>

                  <h5 class="text-white mt-4 fw-bold">Overview</h5>
                  <p class="text-secondary" style="font-size: 1.05rem; line-height: 1.7;">An extremely advanced aggregation endpoint that crawls the entire SQLite database to extract unique artist strings from embedded ID3 tags. It intelligently executes regex delimiter parsing against strings containing formats like <code>"Daft Punk feat. Pharrell Williams"</code> or <code>"Justice & Kavinsky"</code> to dynamically split them into individual, distinct identities. It then returns a structurally mapped array providing a canonical <code>id</code> pointer, which is crucial for fetching the correct cover art image for that artist via the image endpoint.</p>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-danger ps-3">Query Parameters</h5>
                  <div class="table-responsive bg-dark rounded border border-secondary mb-5 shadow-sm mt-3">
                    <table class="table table-dark table-borderless table-striped m-0">
                      <thead class="border-bottom border-secondary">
                        <tr><th class="py-3 px-4">Parameter</th><th class="py-3 px-4">Type</th><th class="py-3 px-4">Required</th><th class="py-3 px-4">Description</th></tr>
                      </thead>
                      <tbody>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">action</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-success">Yes</span></td><td class="py-3 px-4 text-secondary">Must be <code class="text-light">get_artists</code>.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">page</code></td><td class="py-3 px-4 text-info">integer</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Array slice offset. Defaults to <code class="text-light">1</code> (25 items).</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">sort</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Options: <code class="text-light">name_asc</code>, <code class="text-light">name_desc</code>. Defaults to alphabetical <code class="text-light">name_asc</code>.</td></tr>
                      </tbody>
                    </table>
                  </div>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-success ps-3">cURL Request Example</h5>
                  <pre class="bg-black p-4 rounded border border-secondary text-light font-monospace mb-4 shadow-sm" style="font-size: 0.9rem; overflow-x: auto;"><code>curl -X GET "https://yourdomain.com/?access=api&action=get_artists&api_key=admin&sort=name_asc" \
  -H "Accept: application/json" \
  -H "User-Agent: API-Client/1.0"</code></pre>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-info ps-3">Expected JSON Response</h5>
                  <pre class="bg-black p-4 rounded border border-secondary text-info font-monospace mb-0 shadow-sm" style="font-size: 0.9rem; overflow-x: auto;"><code>[
  {
    "name": "Daft Punk",
    "id": 84,
    "has_img": 1
  },
  {
    "name": "David Bowie",
    "id": 92,
    "has_img": 1
  },
  {
    "name": "Dire Straits",
    "id": 105,
    "has_img": 0
  }
]</code></pre>
                  <p class="text-secondary small mt-3 px-2"><strong>Architecture Note:</strong> The <code>id</code> field points to the absolute highest integer song ID uploaded by this artist that contains a valid <code>has_img=1</code> flag in the database. You must append this integer to the <code>get_image</code> endpoint to retrieve the visual artist avatar.</p>
                </section>


                <!-- 3. GET ALBUMS -->
                <section id="doc-get_albums" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-primary fs-5 px-4 py-2 shadow-sm">GET</span>
                    <h2 class="text-white fw-bold m-0" style="font-size: 2.2rem;">Retrieve Albums Collection</h2>
                  </div>
                  
                  <div class="bg-black p-4 rounded border border-secondary mb-4 shadow-sm">
                    <code class="text-success fw-bold fs-5">GET</code> <code class="text-light ms-2 fs-6">/?access=api&action=get_albums&api_key=YOUR_ADMIN_KEY</code>
                  </div>

                  <h5 class="text-white mt-4 fw-bold">Overview</h5>
                  <p class="text-secondary" style="font-size: 1.05rem; line-height: 1.7;">Aggregates all music records grouped strictly by the <code>album</code> database field. The server processor automatically scrubs and excludes blank variables or corrupted "Unknown Album" entries to maintain UI integrity. The backend natively computes the <code>song_count</code> length and executes a heavy join to output the <code>total_plays</code> property for the entire album.</p>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-danger ps-3">Query Parameters</h5>
                  <div class="table-responsive bg-dark rounded border border-secondary mb-5 shadow-sm mt-3">
                    <table class="table table-dark table-borderless table-striped m-0">
                      <thead class="border-bottom border-secondary">
                        <tr><th class="py-3 px-4">Parameter</th><th class="py-3 px-4">Type</th><th class="py-3 px-4">Required</th><th class="py-3 px-4">Description</th></tr>
                      </thead>
                      <tbody>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">action</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-success">Yes</span></td><td class="py-3 px-4 text-secondary">Must be <code class="text-light">get_albums</code>.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">sort</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Options: <code class="text-light">album_asc</code>, <code class="text-light">album_desc</code>, <code class="text-light">year_desc</code>, <code class="text-light">artist_asc</code>. Defaults to <code class="text-light">album_asc</code>.</td></tr>
                      </tbody>
                    </table>
                  </div>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-info ps-3">Expected JSON Response</h5>
                  <pre class="bg-black p-4 rounded border border-secondary text-info font-monospace mb-0 shadow-sm" style="font-size: 0.9rem; overflow-x: auto;"><code>[
  {
    "album": "Dark Side of the Moon",
    "artist": "Pink Floyd",
    "user_id": 1,
    "id": 340,
    "year": 1973,
    "song_count": 10,
    "total_plays": 54200
  },
  {
    "album": "Discovery",
    "artist": "Daft Punk",
    "user_id": 2,
    "id": 412,
    "year": 2001,
    "song_count": 14,
    "total_plays": 88030
  }
]</code></pre>
                  <p class="text-secondary small mt-3 px-2"><strong>Tip:</strong> The <code>id</code> attribute returned here points to the absolute highest song ID associated with this album. Using this ID in the <code>get_image</code> route guarantees you receive the album's unified cover artwork.</p>
                </section>


                <!-- 4. GET GENRES & YEARS -->
                <section id="doc-get_genres" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="row g-5">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-primary fs-6 px-3 py-2 shadow-sm">GET</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Get Genres</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?access=api&action=get_genres</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Provides a clean, distinct array of all unique string properties recorded inside the <code>genre</code> column across the entire music library table. Highly optimized via <code>GROUP BY COLLATE NOCASE</code> algorithms.</p>
                      <pre class="bg-black p-3 rounded border border-secondary text-info font-monospace shadow-sm" style="font-size: 0.85rem; overflow-x: auto;"><code>[
  { "name": "Alternative Rock", "id": 55 },
  { "name": "Electronic Dance", "id": 89 }
]</code></pre>
                    </div>
                    
                    <div class="col-lg-6" id="doc-get_years">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-primary fs-6 px-3 py-2 shadow-sm">GET</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Get Years</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?access=api&action=get_years</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Groups the database entirely by the numeric <code>year</code> ID3 tag field. Automatically filters out <code>0</code> or <code>null</code> integer fallbacks and sorts chronologically descending.</p>
                      <pre class="bg-black p-3 rounded border border-secondary text-info font-monospace shadow-sm" style="font-size: 0.85rem; overflow-x: auto;"><code>[
  { "name": "2024", "id": 904 },
  { "name": "2023", "id": 822 }
]</code></pre>
                    </div>
                  </div>
                </section>


                <!-- 6. SEARCH -->
                <section id="doc-search" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-primary fs-5 px-4 py-2 shadow-sm">GET</span>
                    <h2 class="text-white fw-bold m-0" style="font-size: 2.2rem;">Global Aggregated Search</h2>
                  </div>
                  
                  <div class="bg-black p-4 rounded border border-secondary mb-4 shadow-sm">
                    <code class="text-success fw-bold fs-5">GET</code> <code class="text-light ms-2 fs-6">/?access=api&action=search&q=QUERY&api_key=YOUR_KEY</code>
                  </div>

                  <h5 class="text-white mt-4 fw-bold">Overview</h5>
                  <p class="text-secondary" style="font-size: 1.05rem; line-height: 1.7;">The core intelligence of the library discovery engine. It performs a massive, multi-table cross-referenced <code>LIKE</code> operation against Titles, Artists, Albums, Playlists, and internal Users. Instead of returning a flat array, it structures the response into beautifully nested UI "Shelves", allowing you to render categorical blocks identical to modern streaming platforms immediately upon receipt.</p>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-danger ps-3">Query Parameters</h5>
                  <div class="table-responsive bg-dark rounded border border-secondary mb-4 shadow-sm mt-3">
                    <table class="table table-dark table-borderless table-striped m-0">
                      <thead class="border-bottom border-secondary">
                        <tr><th class="py-3 px-4">Parameter</th><th class="py-3 px-4">Type</th><th class="py-3 px-4">Required</th><th class="py-3 px-4">Description</th></tr>
                      </thead>
                      <tbody>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">q</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-success">Yes</span></td><td class="py-3 px-4 text-secondary">The URL-encoded search keyword or phrase.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">f_date</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Time boundary limits. Options: <code class="text-light">today</code>, <code class="text-light">week</code>, <code class="text-light">month</code>, <code class="text-light">year</code>.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">f_dur</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Length limits. Options: <code class="text-light">short</code> (under 4 mins), <code class="text-light">long</code> (over 20 mins).</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">f_sort</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Advanced sorting matrix. Options: <code class="text-light">relevance</code>, <code class="text-light">date</code>, <code class="text-light">views</code>, <code class="text-light">likes</code>.</td></tr>
                      </tbody>
                    </table>
                  </div>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-info ps-3">Expected JSON Response</h5>
                  <pre class="bg-black p-4 rounded border border-secondary text-info font-monospace mb-0 shadow-sm" style="font-size: 0.85rem; overflow-x: auto;"><code>{
  "shelves": [
    {
      "title": "Top Result",
      "type": "top_result",
      "items": [
        { "id": 401, "title": "Random Access Memories", "artist": "Daft Punk" }
      ]
    },
    {
      "title": "Artists",
      "type": "artists",
      "items": [
        { "name": "Daft Punk", "id": 401, "is_user": false }
      ]
    },
    {
      "title": "Songs",
      "type": "songs_list",
      "items": [
        { "id": 402, "title": "Get Lucky", "artist": "Daft Punk", "duration": 369 }
      ]
    }
  ]
}</code></pre>
                </section>


                <!-- 7. GET SONG DATA -->
                <section id="doc-get_song_data" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-primary fs-5 px-4 py-2 shadow-sm">GET</span>
                    <h2 class="text-white fw-bold m-0" style="font-size: 2.2rem;">Retrieve Deep Song Metadata</h2>
                  </div>
                  
                  <div class="bg-black p-4 rounded border border-secondary mb-4 shadow-sm">
                    <code class="text-success fw-bold fs-5">GET</code> <code class="text-light ms-2 fs-6">/?access=api&action=get_song_data&id=SONG_ID&api_key=YOUR_ADMIN_KEY</code>
                  </div>

                  <h5 class="text-white mt-4 fw-bold">Overview</h5>
                  <p class="text-secondary" style="font-size: 1.05rem; line-height: 1.7;">Provides absolute, hyper-detailed JSON structures regarding a singular specific audio track. It exposes system-level technical details including explicitly generated <code>stream_url</code> overrides, internally embedded raw <code>lyrics</code> text blocks (capable of feeding LRC synchronized UI elements), physical file bitrates, ReplayGain offsets, and critically, the per-user custom <code>eq_bands</code> matrix alterations tied to the <code>user_song_settings</code> relationship table.</p>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-info ps-3">Expected JSON Response</h5>
                  <pre class="bg-black p-4 rounded border border-secondary text-info font-monospace mb-0 shadow-sm" style="font-size: 0.85rem; overflow-x: auto;"><code>{
  "id": 1042,
  "file": "/var/www/html/music/uploads/le/led_zeppelin/m_a4b9x.mp3",
  "title": "Stairway to Heaven",
  "artist": "Led Zeppelin",
  "album": "Led Zeppelin IV",
  "genre": "Classic Rock",
  "year": 1971,
  "duration": 482,
  "bitrate": 320000,
  "lyrics": "[00:15.30] There's a lady who's sure...\n[00:22.10] All that glitters is gold...",
  "user_id": 1,
  "is_private": 0,
  "last_modified": 1698765432,
  "replaygain": -4.2,
  "is_favorite": 1,
  "volume_multiplier": 1.2,
  "eq_bands": [2, 0, -1, 3, 5],
  "stream_url": "?action=get_stream&id=1042",
  "image_url": "?action=get_image&id=1042&v=1698765432"
}</code></pre>
                </section>


                <!-- 8. GET PLAYLIST SONGS -->
                <section id="doc-get_playlist_songs" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-primary fs-5 px-4 py-2 shadow-sm">GET</span>
                    <h2 class="text-white fw-bold m-0" style="font-size: 2.2rem;">Retrieve Playlist Contents</h2>
                  </div>
                  
                  <div class="bg-black p-4 rounded border border-secondary mb-4 shadow-sm">
                    <code class="text-success fw-bold fs-5">GET</code> <code class="text-light ms-2 fs-6">/?access=api&action=get_playlist_songs&public_id=PLAYLIST_ID&api_key=YOUR_KEY</code>
                  </div>

                  <h5 class="text-white mt-4 fw-bold">Overview</h5>
                  <p class="text-secondary" style="font-size: 1.05rem; line-height: 1.7;">Extracts all song objects associated via the <code>playlist_songs</code> junction table, pointing explicitly to a specific <code>public_id</code> cryptographic token. It enforces extremely tight architectural security rules, outright rejecting query attempts on <code>is_private=1</code> collections unless directly authenticated by the owner's session token or globally overridden via the <code>api_key</code>.</p>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-danger ps-3">Query Parameters</h5>
                  <div class="table-responsive bg-dark rounded border border-secondary mb-4 shadow-sm mt-3">
                    <table class="table table-dark table-borderless table-striped m-0">
                      <thead class="border-bottom border-secondary">
                        <tr><th class="py-3 px-4">Parameter</th><th class="py-3 px-4">Type</th><th class="py-3 px-4">Required</th><th class="py-3 px-4">Description</th></tr>
                      </thead>
                      <tbody>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">public_id</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-success">Yes</span></td><td class="py-3 px-4 text-secondary">The 16-character hexadecimal token assigned to the playlist entity.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">sort</code></td><td class="py-3 px-4 text-info">string</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Order definitions. Options: <code class="text-light">manual_order</code>, <code class="text-light">added_newest</code>, <code class="text-light">added_oldest</code>.</td></tr>
                        <tr><td class="py-3 px-4"><code class="text-warning fs-6">all</code></td><td class="py-3 px-4 text-info">integer</td><td class="py-3 px-4"><span class="badge bg-secondary">No</span></td><td class="py-3 px-4 text-secondary">Boolean state <code class="text-light">1</code> or <code class="text-light">0</code>. If 1, it entirely bypasses the 25-item chunking constraints and dumps the entire list array simultaneously.</td></tr>
                      </tbody>
                    </table>
                  </div>
                </section>


                <!-- 9. MEDIA & STREAMING -->
                <section id="doc-get_stream" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="row g-5">
                    <div class="col-12 col-xl-6">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 shadow-sm">MEDIA</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Stream Audio Data</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?action=get_stream&id=SONG_ID</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">The highest priority internal API route. Operates completely outside the JSON formatter to return heavy binary payloads. Native support for <code>HTTP/1.1 206 Partial Content</code> allows HTML5 <code>&lt;audio&gt;</code> tags to seamlessly transmit <code>Range: bytes=</code> requests, enabling instant timeline scrubbing without transferring gigabytes of unneeded buffer chunks.</p>
                      <div class="alert alert-dark border border-warning text-warning small mt-3">
                        <i class="bi bi-shield-lock-fill"></i> <strong>Security Override:</strong> This route naturally bypasses CORS when instantiated natively via DOM media elements.
                      </div>
                    </div>
                    
                    <div class="col-12 col-xl-6" id="doc-get_image">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 shadow-sm">MEDIA</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Get Cover Art Image</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?action=get_image&id=SONG_ID&v=TIMESTAMP</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Transmits the ultra-compressed WebP base64 blob embedded in the SQLite music architecture. If no image physically exists in the database for the given ID, the server intercepts the null pointer and dynamically builds an immense SVG vector mathematical graphic bounded to the hexadecimal seed derived from the song's title string!</p>
                      <div class="alert alert-dark border border-info text-info small mt-3">
                        <i class="bi bi-lightning-fill"></i> <strong>Performance:</strong> The <code>&v=</code> param explicitly fractures strict HTTP caching laws to force UI updates.
                      </div>
                    </div>

                    <div class="col-12 col-xl-6" id="doc-get_profile_picture">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 shadow-sm">MEDIA</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Get User Avatar</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?action=get_profile_picture&id=USER_ID</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Translates the user integer pointer into a <code>image/webp</code> output stream. If the account lacks a custom profile picture, it initiates a complex fallback algorithm: searching the DB for the newest <code>music</code> row uploaded by them that contains cover art, and if that fails, builds an SVG geometric shape.</p>
                    </div>

                    <div class="col-12 col-xl-6" id="doc-download_song">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 shadow-sm">MEDIA</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Download Raw MP3</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?action=download_song&id=SONG_ID</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Overrides normal streaming directives to enforce a hard physical system download operation. Injects <code>Content-Disposition: attachment</code> headers while intelligently formatting the filename to <code>"Title - Artist.mp3"</code> based securely on the database tags, ignoring the random alphanumeric disk hash.</p>
                    </div>
                  </div>
                </section>


                <!-- 10. GET EXPLORE -->
                <section id="doc-get_explore" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-success fs-5 px-4 py-2 shadow-sm">DATA</span>
                    <h2 class="text-white fw-bold m-0" style="font-size: 2.2rem;">Get Explore / Discovery Hub</h2>
                  </div>
                  
                  <div class="bg-black p-4 rounded border border-secondary mb-4 shadow-sm">
                    <code class="text-success fw-bold fs-5">GET</code> <code class="text-light ms-2 fs-6">/?access=api&action=get_explore&api_key=YOUR_ADMIN_KEY</code>
                  </div>

                  <h5 class="text-white mt-4 fw-bold">Overview</h5>
                  <p class="text-secondary" style="font-size: 1.05rem; line-height: 1.7;">A tremendously heavy computational endpoint containing massive multi-table <code>JOIN</code> subqueries designed to construct randomized algorithm-driven "Shelves" for the Explore tab. It pulls deep track recommendations, aggregates distinct album groupings randomly, parses global play statistics to surface trending records, and identifies prolific artists across the server. Due to execution load, this endpoint automatically serializes its output to a hardware <code>sys_get_temp_dir()</code> cache file governed by a strict 5-minute invalidation clock.</p>

                  <h5 class="text-white mt-5 fw-bold border-start border-4 border-info ps-3">Expected JSON Response</h5>
                  <pre class="bg-black p-4 rounded border border-secondary text-info font-monospace mb-0 shadow-sm" style="font-size: 0.85rem; overflow-x: auto;"><code>{
  "shelves": [
    {
      "title": "Discover Songs",
      "type": "songs",
      "items": [
        { "id": 401, "title": "Random Access Memories", "artist": "Daft Punk" }, ...
      ]
    },
    {
      "title": "Discover Albums",
      "type": "albums",
      "items": [
        { "album": "Discovery", "artist": "Daft Punk", "id": 84, "song_count": 14 }
      ]
    }
  ]
}</code></pre>
                </section>

                <!-- 11. GET RECOMMENDATIONS & HISTORY -->
                <section id="doc-get_recommendations" class="api-doc-section mb-5 pb-5 border-bottom border-secondary">
                  <div class="row g-5">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-success fs-6 px-3 py-2 shadow-sm">DATA</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Get For You AI</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?access=api&action=get_recommendations</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Identical to the Explore layout engine but intensely localized against the authenticated API Session parameters. Re-calculates mathematical boundaries based exclusively on user history logs, followed relationships, and favorite flags. Requires severe backend processing load.</p>
                    </div>
                    
                    <div class="col-lg-6" id="doc-get_history">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-success fs-6 px-3 py-2 shadow-sm">DATA</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Get Play History</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?access=api&action=get_history</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Targets the <code>history</code> database mapping. Executes a complex grouping schema to safely collapse tracks played multiple times into a singular row driven by a <code>MAX(played_at)</code> ISO string resolver. Appends fully functional UI objects to build timeline interfaces.</p>
                    </div>

                    <div class="col-lg-6" id="doc-get_favorites">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-success fs-6 px-3 py-2 shadow-sm">DATA</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Get User Favorites</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?access=api&action=get_favorites</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Outputs the array of tracks securely bound to the user's <code>favorites</code> cross-reference table. Enforces a <code>sort_order</code> directional flag to allow for drag-and-drop structural preservation. Core foundation for the internal offline-caching loop capabilities.</p>
                    </div>

                    <div class="col-lg-6" id="doc-get_user_playlists">
                      <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="badge bg-success fs-6 px-3 py-2 shadow-sm">DATA</span>
                        <h2 class="text-white fw-bold m-0" style="font-size: 1.8rem;">Get Playlists Collections</h2>
                      </div>
                      <div class="bg-black p-3 rounded border border-secondary mb-3 shadow-sm">
                        <code class="text-success fw-bold">GET</code> <code class="text-light ms-2">/?access=api&action=get_user_playlists</code>
                      </div>
                      <p class="text-secondary" style="font-size: 1rem; line-height: 1.6;">Aggregates the total array of <code>playlist</code> constructs exclusively tied to the master authentication identifier. Employs heavy aggregation logic to dynamically formulate the internal <code>song_count</code> and the highly complex <code>image_id</code> thumbnail pointing parameter.</p>
                    </div>
                  </div>
                </section>


                <!-- 12. POST ACTIONS OVERVIEW -->
                <section id="doc-toggle_favorite" class="api-doc-section pb-3">
                  <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-warning text-dark fs-5 px-4 py-2 shadow-sm">POST</span>
                    <h2 class="text-white fw-bold m-0" style="font-size: 2.2rem;">Database Mutations (POST Hooks)</h2>
                  </div>
                  <p class="text-secondary mb-4" style="font-size: 1.05rem; line-height: 1.7;">These specialized endpoints are explicitly designed to mutate database states securely. They completely ignore URL parameters for data manipulation, strictly demanding rigorous JSON payloads deployed within the body stream. All requests mandate <code>Content-Type: application/json</code>.</p>
                  
                  <div class="row g-4 mt-2">
                    <!-- Toggle Favorite -->
                    <div class="col-lg-12">
                      <div class="card bg-dark border-secondary shadow-sm">
                        <div class="card-header border-bottom border-secondary bg-black py-3 d-flex align-items-center gap-3">
                          <code class="text-danger fw-bold fs-5">POST</code> <code class="text-light fs-6">/?access=api&action=toggle_favorite</code>
                        </div>
                        <div class="card-body p-4">
                          <h6 class="text-white fw-bold mb-2">JSON Body Schema:</h6>
                          <pre class="bg-black p-3 rounded border border-secondary text-warning font-monospace small mb-3"><code>{
  "id": 1042 // The integer ID of the target song
}</code></pre>
                          <p class="text-secondary small mb-0"><strong>Functionality:</strong> Scans the <code>favorites</code> binding logic. If the integer ID already exists in the matrix, it physically destroys the row. If absent, it injects a new row calculating the <code>MAX(sort_order) + 1</code>. Responds with the new calculated boolean state <code>{"status":"added", "is_favorite":true}</code>.</p>
                        </div>
                      </div>
                    </div>

                    <!-- Log Play -->
                    <div class="col-lg-12" id="doc-log_play">
                      <div class="card bg-dark border-secondary shadow-sm">
                        <div class="card-header border-bottom border-secondary bg-black py-3 d-flex align-items-center gap-3">
                          <code class="text-danger fw-bold fs-5">POST</code> <code class="text-light fs-6">/?access=api&action=log_play</code>
                        </div>
                        <div class="card-body p-4">
                          <h6 class="text-white fw-bold mb-2">JSON Body Schema:</h6>
                          <pre class="bg-black p-3 rounded border border-secondary text-warning font-monospace small mb-3"><code>{
  "id": 1042, 
  "played_at": "2026-06-28T14:27:00.000Z" // Standard ISO string
}</code></pre>
                          <p class="text-secondary small mb-0"><strong>Functionality:</strong> Highly volatile transaction handler. Executes a deep <code>ON CONFLICT DO UPDATE</code> SQL sequence against both the <code>history</code> mapping (to update the chronological timeline) and the <code>play_counts</code> mapping (incrementing the algorithm scalar). It is intensely protected by a looping Retry matrix to mitigate localized SQLite busy-lock scenarios under massive concurrent traffic.</p>
                        </div>
                      </div>
                    </div>

                    <!-- Create Playlist -->
                    <div class="col-lg-12" id="doc-create_playlist">
                      <div class="card bg-dark border-secondary shadow-sm">
                        <div class="card-header border-bottom border-secondary bg-black py-3 d-flex align-items-center gap-3">
                          <code class="text-danger fw-bold fs-5">POST</code> <code class="text-light fs-6">/?access=api&action=create_playlist</code>
                        </div>
                        <div class="card-body p-4">
                          <h6 class="text-white fw-bold mb-2">JSON Body Schema:</h6>
                          <pre class="bg-black p-3 rounded border border-secondary text-warning font-monospace small mb-3"><code>{
  "name": "Midnight Drive Array", 
  "is_private": 0 // Integer boolean (0 = Public, 1 = Private)
}</code></pre>
                          <p class="text-secondary small mb-0"><strong>Functionality:</strong> Dynamically validates and executes the generation of a new global playlist construct. Generates an exceptionally secure, random 16-character hexadecimal token bound to the <code>public_id</code> column to bypass easily-guessable standard integer indexing methodologies.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>

              </div>
              <!-- MASSIVE DOCUMENTATION END -->

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- PROJECT MANAGEMENT MODALS -->
    <div class="modal fade" id="project-manage-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-secondary">
            <h5 class="modal-title text-white">Manage Project</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <input type="hidden" id="manage-project-id">
            <div class="mb-4 p-3 rounded" style="background-color: var(--ytm-surface-2); border: 1px solid #404040;">
              <label for="project-expire-select" class="form-label text-white small mb-1">Invite Link Expiration</label>
              <select id="project-expire-select" class="form-select form-select-sm bg-dark text-white border-secondary mb-2">
                <option value="1440">1 Day</option>
                <option value="10080">1 Week</option>
                <option value="43200">1 Month</option>
                <option value="forever">Forever</option>
              </select>
              <button class="btn btn-info text-dark fw-bold w-100" id="project-copy-link-btn"><i class="bi bi-link-45deg"></i> Generate & Copy Link</button>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="text-secondary m-0">Project Members</h6>
            </div>
            <div id="project-members-list" class="list-group list-group-flush bg-transparent"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="project-move-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2">
            <h5 class="modal-title text-white"><i class="bi bi-briefcase-fill text-danger me-2"></i> Move Item</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <label class="form-label text-secondary small fw-bold mb-2">SELECT DESTINATION</label>
            <select id="project-move-select" class="form-select bg-dark text-white border-secondary mb-4">
              <option value="">🏠 Personal (Private)</option>
              <!-- Populated dynamically via JS -->
            </select>
            <button type="button" class="btn btn-info w-100 fw-bold" id="confirm-move-project-btn">Move to Destination</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="project-invite-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-secondary">
            <h5 class="modal-title text-white">Project Invitation</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4 text-center">
            <i class="bi bi-briefcase text-info mb-3" style="font-size: 3rem; display: block;"></i>
            <h5 class="text-white mb-2">You've been invited!</h5>
            <p class="text-secondary mb-4">You have been invited to collaborate on a private project workspace.</p>
            <button class="btn btn-info px-4 w-100 fw-bold" id="project-invite-accept-btn">Accept & Join Workspace</button>
          </div>
        </div>
      </div>
    </div>

    <!-- PLAY.HTML VISUAL CLIENT TEMPLATE (Injected into iframe) -->
    <template id="play-client-template">
      <!DOCTYPE html>
      <html lang="en" data-bs-theme="dark">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>PHPMusic Client</title>
          <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;utf8,%3Csvg%20width=%22800px%22%20height=%22800px%22%20viewBox=%220%200%2024%2024%22%20fill=%22none%22%20xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath%20d=%22M4%2010V13%22%20stroke=%22%23ffffff%22%20stroke-width=%221.7%22%20stroke-linecap=%22round%22/%3E%3Cpath%20d=%22M16%2010V13%22%20stroke=%22%23ffffff%22%20stroke-width=%221.7%22%20stroke-linecap=%22round%22/%3E%3Cpath%20d=%22M7%207L7%2016%22%20stroke=%22%23DF1463%22%20stroke-width=%221.7%22%20stroke-linecap=%22round%22/%3E%3Cpath%20d=%22M13%207L13%2016%22%20stroke=%22%23ffffff%22%20stroke-width=%221.7%22%20stroke-linecap=%22round%22/%3E%3Cpath%20d=%22M19%207L19%2016%22%20stroke=%22%23ffffff%22%20stroke-width=%221.7%22%20stroke-linecap=%22round%22/%3E%3Cpath%20d=%22M10%204L10%2019%22%20stroke=%22%23ffffff%22%20stroke-width=%221.7%22%20stroke-linecap=%22round%22/%3E%3C/svg%3E">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
          <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
          <style>
            :root {
              --ytm-bg: #030303;
              --ytm-surface: #0f0f0f;
              --ytm-surface-hover: #1f1f1f;
              --ytm-border: #272727;
              --ytm-primary-text: #ffffff;
              --ytm-secondary-text: #aaaaaa;
              --ytm-accent: #ff0000;
              --sidebar-width: 240px;
            }
        
            html,
            body {
              background-color: #030303 !important;
            }

            body {
              font-family: 'Roboto', sans-serif;
              background-color: var(--ytm-bg);
              color: var(--ytm-primary-text);
              margin: 0;
              overflow-x: hidden;
              padding-top: 0;
              padding-bottom: 96px;
            }
        
            @media (max-width: 768px) {
              body {
                padding-top: 72px;
              }
            }
        
            ::-webkit-scrollbar {
              width: 8px;
            }
        
            ::-webkit-scrollbar-track {
              background: var(--ytm-bg);
            }
        
            ::-webkit-scrollbar-thumb {
              background: #3e3e3e;
              border-radius: 4px;
            }
        
            ::-webkit-scrollbar-thumb:hover {
              background: #5e5e5e;
            }

            .dynamic-blur-bg {
              position: absolute;
              top: -60px;
              left: -60px;
              right: -60px;
              bottom: -60px;
              background-size: cover;
              background-position: center;
              filter: blur(45px) brightness(0.6);
              opacity: 0.95;
              z-index: 0;
              transition: background-image 0.8s ease, filter 0.4s ease;
              pointer-events: none;
              transform: scale(1.3);
              transform-origin: center;
            }
        
            .ytm-header {
              position: fixed;
              top: 0;
              left: 0;
              right: 0;
              height: 72px;
              background-color: var(--ytm-surface);
              border-bottom: 1px solid var(--ytm-border);
              z-index: 1100;
            }
        
            @media (min-width: 769px) {
              .ytm-header {
                display: none !important;
              }
            }
        
            .app-container {
              display: flex;
              min-height: calc(100vh - 72px);
              min-height: calc(100dvh - 72px);
            }
        
            .sidebar {
              width: var(--sidebar-width);
              background-color: var(--ytm-surface);
              border-right: 1px solid var(--ytm-border);
              position: fixed;
              top: 0;
              bottom: 0;
              left: 0;
              height: 100vh;
              height: 100dvh;
              padding: 1.25rem 1rem;
              display: flex;
              flex-direction: column;
              z-index: 1200;
              transition: transform 0.3s ease, padding 0.3s ease, width 0.3s ease;
            }
        
            .form-control,
            .form-select {
              background-color: #212121;
              border: 1px solid var(--ytm-border);
              color: var(--ytm-primary-text);
              border-radius: 8px;
            }
        
            .form-control:focus,
            .form-select:focus {
              background-color: #212121;
              border-color: #555;
              color: var(--ytm-primary-text);
              box-shadow: none;
            }
        
            /* Modernized Sort Dropdown Styling */
            select[id*="sort"],
            select#source-type {
              appearance: none;
              -webkit-appearance: none;
              background-color: rgba(255, 255, 255, 0.05) !important;
              border: 1px solid rgba(255, 255, 255, 0.1) !important;
              border-radius: 20px !important;
              color: var(--ytm-primary-text) !important;
              font-weight: 600;
              font-size: 0.85rem;
              height: 40px !important;
              padding: 0 2rem 0 1rem !important;
              cursor: pointer;
              transition: all 0.2s ease-in-out;
              background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23aaaaaa'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E") !important;
              background-repeat: no-repeat !important;
              background-position: right 0.75rem center !important;
              background-size: 12px 12px !important;
              backdrop-filter: blur(10px);
              box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
            }
        
            select[id*="sort"]:hover,
            select#source-type:hover {
              background-color: rgba(255, 255, 255, 0.1) !important;
              border-color: rgba(255, 255, 255, 0.2) !important;
            }
        
            select[id*="sort"]:focus,
            select#source-type:focus {
              outline: none;
              border-color: var(--ytm-accent) !important;
              box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.2) !important;
            }
        
            select[id*="sort"] option,
            select#source-type option {
              background-color: #212121;
              color: #ffffff;
              font-weight: 500;
            }
        
            label[for*="sort"],
            label[for="source-type"] {
              text-transform: uppercase;
              letter-spacing: 1px;
              font-size: 0.7rem !important;
              font-weight: 700;
              color: var(--ytm-secondary-text) !important;
              margin-right: 0.25rem;
            }
        
            .songs-header {
              display: grid;
              grid-template-columns: 48px 4fr 3fr 80px;
              gap: 1rem;
              padding: 0.75rem 1rem;
              color: var(--ytm-secondary-text);
              font-size: 0.85rem;
              font-weight: 500;
              text-transform: uppercase;
              letter-spacing: 0.5px;
            }
        
            .song-item {
              display: grid;
              grid-template-columns: 48px 4fr 3fr 80px;
              gap: 1rem;
              align-items: center;
              padding: 0.75rem 1rem;
              border-radius: 8px;
              cursor: pointer;
              transition: background-color 0.15s;
              border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            }
        
            .song-item:hover {
              background-color: var(--ytm-surface-hover);
            }
        
            .song-item.active {
              background-color: rgba(255, 255, 255, 0.08);
            }
        
            .song-item.active .song-title {
              color: var(--ytm-accent);
            }
        
            .song-thumb {
              width: 48px;
              height: 48px;
              border-radius: 4px;
              object-fit: cover;
            }
        
            .song-title {
              font-weight: 500;
              color: var(--ytm-primary-text);
              margin-bottom: 2px;
            }
        
            .song-artist {
              font-size: 0.9rem;
              color: var(--ytm-secondary-text);
            }
        
            .song-album {
              color: var(--ytm-secondary-text);
              font-size: 0.9rem;
            }
        
            .song-duration {
              font-size: 0.9rem;
              color: var(--ytm-secondary-text);
              text-align: right;
            }
        
            .player-bar {
              position: fixed;
              bottom: -3px;
              left: 0;
              right: 0;
              height: 100px;
              background-color: var(--ytm-surface, #0f0f0f) !important;
              border-top: 1px solid var(--ytm-border, #272727) !important;
              box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.5) !important;
              display: grid;
              grid-template-columns: 1fr 2fr 1fr;
              align-items: center;
              padding: 0 2rem 4px 2rem;
              z-index: 1050;
              transform: translateY(100%);
              transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), left 0.3s ease;
              overflow: hidden;
            }

            @media (max-width: 768px) {
              .player-bar {
                grid-template-columns: 1.5fr 1fr;
                padding: 0 1rem 4px 1rem;
                height: 84px;
              }
            }
        
            .player-bar.visible {
              transform: translateY(0);
            }
        
            .pb-left {
              display: flex;
              align-items: center;
              gap: 1rem;
              min-width: 0;
            }
        
            .pb-art-container {
              position: relative;
              width: 56px;
              height: 56px;
              border-radius: 4px;
              overflow: hidden;
              cursor: pointer;
              flex-shrink: 0;
            }
        
            .pb-art {
              width: 100%;
              height: 100%;
              object-fit: cover;
            }
        
            .pb-art-hover {
              position: absolute;
              top: 0;
              left: 0;
              right: 0;
              bottom: 0;
              background-color: rgba(0, 0, 0, 0.5);
              display: flex;
              align-items: center;
              justify-content: center;
              opacity: 0;
              transition: opacity 0.2s;
            }
        
            .pb-art-container:hover .pb-art-hover {
              opacity: 1;
            }
        
            .pb-metadata {
              overflow: hidden;
              min-width: 0;
            }
        
            .pb-title {
              font-weight: 500;
              margin-bottom: 2px;
            }
        
            .pb-artist,
            .pb-artist * {
              font-size: 0.85rem;
              color: var(--ytm-secondary-text);
              transition: color 0.3s ease;
            }

            .player-bar.theme-light-bg .pb-artist,
            .player-bar.theme-light-bg .pb-artist * {
              color: rgba(0, 0, 0, 0.7) !important;
            }
        
            .pb-center {
              display: flex;
              flex-direction: column;
              align-items: center;
              width: 100%;
              max-width: 600px;
              margin: 0 auto;
            }
        
            .pb-buttons {
              display: flex;
              align-items: center;
              gap: 1.5rem;
              margin-bottom: 4px;
            }
        
            .pb-btn {
              background: none;
              border: none;
              color: var(--ytm-secondary-text);
              display: flex;
              align-items: center;
              justify-content: center;
              cursor: pointer;
              transition: color 0.2s;
              padding: 4px;
            }
        
            .pb-btn:hover {
              color: var(--ytm-primary-text);
            }
        
            .pb-btn.active {
              color: var(--ytm-accent) !important;
            }
        
            .pb-btn .bi {
              font-size: 1.3rem;
            }
        
            .pb-btn-large .bi {
              font-size: 1.8rem;
            }
        
            .pb-play-circle {
              width: 42px;
              height: 42px;
              border-radius: 50%;
              background-color: var(--ytm-primary-text);
              color: var(--ytm-bg) !important;
              transition: transform 0.15s;
            }
        
            .pb-play-circle:hover {
              transform: scale(1.08);
            }
        
            .pb-play-circle .bi {
              font-size: 1.8rem;
            }

            .pb-play-circle .bi-play-fill {
              margin-left: 4px;
            }
        
            .pb-timeline {
              width: 100%;
              display: flex;
              align-items: center;
              gap: 0.75rem;
            }
        
            .pb-time {
              font-size: 0.75rem;
              color: var(--ytm-secondary-text);
              width: 35px;
              text-align: center;
            }
        
            .timeline-container {
              flex: 1;
              height: 24px;
              position: relative;
              cursor: pointer;
              display: flex;
              align-items: center;
            }
        
            .timeline-bg {
              position: absolute;
              left: 0;
              right: 0;
              height: 4px;
              background-color: rgba(255, 255, 255, 0.2);
              border-radius: 2px;
              pointer-events: none;
            }
        
            .timeline-filled {
              height: 4px;
              background-color: var(--ytm-primary-text);
              width: 0%;
              position: absolute;
              left: 0;
              pointer-events: none;
              border-radius: 2px;
              z-index: 2;
              transition: background-color 0.2s;
            }

            .timeline-filled::after {
              content: '';
              position: absolute;
              right: -6px;
              top: -4px;
              width: 12px;
              height: 12px;
              border: none;
              border-radius: 50%;
              background: #ffffff;
              box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
              transition: background-color 0.2s, transform 0.1s, box-shadow 0.2s;
            }
        
            .timeline-container:hover .timeline-filled {
              background-color: var(--ytm-accent, #ff0000) !important;
            }

            .timeline-container:hover .timeline-filled::after {
              border-color: var(--ytm-accent, #ff0000) !important;
              background: var(--ytm-accent, #ff0000) !important;
              box-shadow: 0 0 8px rgba(255, 0, 0, 0.5) !important;
              transform: scale(1.15);
            }
        
            .pb-right {
              display: flex;
              align-items: center;
              justify-content: flex-end;
              gap: 1rem;
              color: var(--ytm-secondary-text);
            }
        
            .volume-bar {
              width: 100px;
              height: 24px;
              position: relative;
              cursor: pointer;
              display: flex;
              align-items: center;
            }
        
            .volume-bg {
              position: absolute;
              left: 0;
              right: 0;
              height: 4px;
              background-color: #555555;
              border-radius: 2px;
              pointer-events: none;
            }
        
            .volume-filled {
              height: 4px;
              background-color: var(--ytm-primary-text);
              width: 100%;
              position: absolute;
              left: 0;
              border-radius: 2px;
              pointer-events: none;
              z-index: 2;
            }
        
            #infinite-scroll-sentinel {
              height: 50px;
              display: flex;
              align-items: center;
              justify-content: center;
              margin-top: 1rem;
            }
        
            .content-wrapper {
              flex: 1;
              margin-left: var(--sidebar-width);
              padding: 2rem;
              max-width: 1200px;
              transition: margin-left 0.3s ease;
            }
        
            .ytm-modal {
              position: fixed;
              top: 0;
              left: 0;
              right: 0;
              bottom: 0;
              background-color: #070707;
              z-index: 2000;
              transform: translateY(100%);
              transition: transform 0.4s cubic-bezier(0.1, 0.76, 0.55, 0.94);
              display: flex;
              flex-direction: column;
            }
        
            .ytm-modal.open {
              transform: translateY(0);
            }
        
            .ytm-modal-header {
              height: 64px;
              padding: 0 1.5rem;
              display: flex;
              align-items: center;
            }
        
            .ytm-modal-body {
              flex: 1;
              display: flex;
              flex-direction: column;
              align-items: center;
              justify-content: center;
              padding: 2rem;
              padding-top: 0;
              overflow-y: auto;
            }
        
            .ytm-modal-content {
              width: 100%;
              max-width: 380px;
              display: flex;
              flex-direction: column;
              align-items: center;
            }
        
            .ytm-modal-art-box {
              width: 100%;
              aspect-ratio: 1/1;
              border-radius: 12px;
              overflow: hidden;
              box-shadow: 0 12px 36px rgba(0, 0, 0, 0.6);
              margin-bottom: 2rem;
            }
        
            .ytm-modal-art-box img {
              width: 100%;
              height: 100%;
              object-fit: cover;
            }
        
            .ytm-modal-details {
              width: 100%;
              display: flex;
              justify-content: center;
              align-items: center;
              text-align: center;
              min-width: 0;
            }
        
            .btn-modal-lg {
              font-size: 1.5rem;
            }
        
            .btn-modal-xl {
              font-size: 2.2rem;
            }
        
            .pb-modal-play-circle {
              width: 76px;
              height: 76px;
              min-width: 76px;
              border-radius: 50%;
              background-color: var(--ytm-primary-text);
              color: var(--ytm-bg) !important;
              transition: transform 0.15s;
            }
        
            .pb-modal-play-circle:hover {
              transform: scale(1.08);
            }
        
            .pb-modal-play-circle .bi {
              font-size: 2.8rem;
            }
        
            @media (min-width: 769px) {
              .player-bar.visible {
                z-index: 1030;
              }
        
              body:has(.player-bar.visible) .sidebar {
                padding-bottom: calc(96px + 1.25rem);
              }
            }
        
            @media (max-width: 768px) {
              .sidebar {
                transform: translateX(-100%);
                bottom: 0 !important;
                height: 100dvh !important;
                top: 0 !important;
                box-shadow: 5px 0 15px rgba(0, 0, 0, 0.5);
              }
        
              .sidebar.show {
                transform: translateX(0);
              }
        
              .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
              }
        
              .songs-header {
                display: none !important;
              }
        
              .song-item {
                grid-template-columns: 48px 1fr 50px !important;
                gap: 0.75rem !important;
              }
        
              .song-album {
                display: none !important;
              }
        
              .player-bar {
                grid-template-columns: 1.5fr 1fr;
                padding: 0 1rem;
                height: 80px;
              }
        
              .player-bar .pb-center {
                display: none;
              }
        
              .player-bar .pb-right {
                justify-content: flex-end;
              }
        
              .player-bar .volume-bar {
                display: none;
              }
            }
          </style>
        </head>
        <body>
          <audio id="audio-player" preload="metadata"></audio>
          <header class="ytm-header">
            <div class="container-fluid d-flex align-items-center justify-content-between h-100 px-4">
              <div class="d-flex align-items-center gap-2 d-md-none">
                <h4 class="m-0 fw-bold">PHP<span class="fw-light">Music Client</span></h4>
              </div>
              <button class="btn btn-link text-white d-md-none p-2 ms-auto" type="button" id="sidebar-toggle-btn">
                <i class="bi bi-sliders fs-5"></i>
              </button>
            </div>
          </header>

          <div class="app-container">
            <aside class="sidebar">
              <div class="d-none d-md-flex align-items-center gap-2 mb-4 flex-shrink-0" style="height: 72px; margin-top: -1.25rem; margin-left: -1rem; margin-right: -1rem; padding: 0 1.25rem; border-bottom: 1px solid var(--ytm-border);">
                <h4 class="m-0 fw-bold">PHP<span class="fw-light">Music Client</span></h4>
              </div>

              <div class="mb-4 flex-grow-1 overflow-auto pe-2" style="min-height: 0; scrollbar-width: thin;">
                <h6 class="text-uppercase text-secondary fw-bold mb-3 d-flex align-items-center gap-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                  <i class="bi bi-sliders"></i> API Configuration
                </h6>
                <form id="api-form" class="w-100">
                  <div class="mb-3">
                    <label for="source-type" class="form-label small text-secondary mb-1">Source Type</label>
                    <select class="form-select form-select-sm" id="source-type">
                      <option value="all">All Tracks</option>
                      <option value="playlist">Playlist Feed</option>
                      <option value="artist">Artist Feed</option>
                      <option value="album">Album Feed</option>
                      <option value="search">Search Songs</option>
                    </select>
                  </div>
                  <div class="mb-3 d-none" id="playlist-id-container">
                    <label for="playlist-id" class="form-label small text-secondary mb-1">Playlist ID</label>
                    <input type="text" class="form-control form-control-sm" id="playlist-id" placeholder="Playlist ID">
                  </div>
                  <div class="mb-3 d-none" id="artist-id-container">
                    <label for="artist-id" class="form-label small text-secondary mb-1">Artist ID / Name</label>
                    <input type="text" class="form-control form-control-sm" id="artist-id" placeholder="Artist ID or Name">
                  </div>
                  <div class="mb-3 d-none" id="album-name-container">
                    <label for="album-name" class="form-label small text-secondary mb-1">Album Name</label>
                    <input type="text" class="form-control form-control-sm" id="album-name" placeholder="Album Name">
                  </div>
                  <div class="mb-3 d-none" id="search-query-container">
                    <label for="search-query" class="form-label small text-secondary mb-1">Search Query</label>
                    <input type="text" class="form-control form-control-sm" id="search-query" placeholder="Enter keywords...">
                  </div>
                  <div class="mb-3" id="sort-by-container">
                    <label for="sort-by" class="form-label small text-secondary mb-1">Sort By</label>
                    <select class="form-select form-select-sm" id="sort-by">
                      <option value="id_desc">Recently Added</option>
                      <option value="title_asc">Title (A-Z)</option>
                      <option value="artist_asc">Artist (A-Z)</option>
                      <option value="album_asc">Album (A-Z)</option>
                      <option value="year_desc">Year (Newest)</option>
                      <option value="year_asc">Year (Oldest)</option>
                      <option value="random">Random Shuffle</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="api-url" class="form-label small text-secondary mb-1">Backend URL</label>
                    <input type="url" class="form-control form-control-sm" id="api-url" placeholder="https://your-api.com" required>
                  </div>
                  <div class="mb-3">
                    <label for="api-key-input" class="form-label small text-secondary mb-1">API Key</label>
                    <input type="text" class="form-control form-control-sm bg-dark text-warning border-secondary" id="api-key-input" placeholder="Enter API Key">
                  </div>
                  <button type="submit" class="btn btn-light btn-sm w-100 fw-bold py-2">Connect</button>
                  <button type="button" id="btn-share" class="btn btn-outline-light btn-sm w-100 mt-2 py-2">
                    <i class="bi bi-share"></i> Share Page
                  </button>
                  <button type="button" id="btn-back-main" class="btn btn-danger btn-sm w-100 mt-4 py-2 fw-bold d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-left"></i> Back to Main Site
                  </button>
                </form>
              </div>
              <div class="mt-auto p-2 flex-shrink-0" style="border-top: 1px solid var(--ytm-border);">
                <div class="small text-secondary" id="sidebar-status">
                  <i class="bi bi-dot text-danger animate-pulse"></i> Client Idle
                </div>
              </div>
            </aside>

            <main class="content-wrapper">
              <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="fw-bold m-0 text-truncate">Library Tracks</h3>
                <span class="text-secondary small flex-shrink-0" id="total-tracks-count">0 tracks listed</span>
              </div>
              <div class="songs-table">
                <div class="songs-header">
                  <div>Cover</div>
                  <div>Title</div>
                  <div>Album</div>
                  <div class="text-end"><i class="bi bi-clock"></i></div>
                </div>
                <div id="songs-container">
                  <div class="text-center text-secondary py-5">
                    <i class="bi bi-music-note-beamed text-secondary" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="mt-3">Configure and connect to your PHP Music API in the sidebar.</p>
                  </div>
                </div>
              </div>
              <div id="infinite-scroll-sentinel">
                <div class="spinner-border spinner-border-sm text-secondary d-none" id="scroll-spinner" role="status"></div>
              </div>
            </main>
          </div>

          <div class="player-bar" id="player-bar">
            <div class="pb-left">
              <div class="pb-art-container" id="pb-art-trigger">
                <img id="pb-art" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjMjIyIi8+PC9zdmc+" class="pb-art" alt="Art">
                <div class="pb-art-hover">
                  <i class="bi bi-arrows-angle-expand text-white"></i>
                </div>
              </div>
              <div class="pb-metadata">
                <div class="pb-title text-truncate" id="pb-title">Track Title</div>
                <div class="pb-artist text-truncate" id="pb-artist">Artist</div>
              </div>
            </div>

            <div class="pb-center">
              <div class="pb-buttons">
                <button class="pb-btn" id="btn-shuffle" title="Shuffle"><i class="bi bi-shuffle"></i></button>
                <button class="pb-btn" id="btn-prev"><i class="bi bi-skip-start-fill"></i></button>
                <button class="pb-btn pb-play-circle" id="btn-play-pause"><i class="bi bi-play-fill" id="play-icon"></i></button>
                <button class="pb-btn" id="btn-next"><i class="bi bi-skip-end-fill"></i></button>
                <button class="pb-btn" id="btn-repeat" title="Repeat"><i class="bi bi-repeat"></i></button>
              </div>
              <div class="pb-timeline">
                <span class="pb-time" id="time-current">0:00</span>
                <div class="timeline-container" id="timeline-container">
                  <div class="timeline-bg"></div>
                  <div class="timeline-filled" id="timeline-bar"></div>
                </div>
                <span class="pb-time" id="time-total">0:00</span>
              </div>
            </div>

            <div class="pb-right">
              <button class="pb-btn d-md-none" id="pb-modal-mobile-trigger" title="Open Player"><i class="bi bi-chevron-up fs-4"></i></button>
              <button class="pb-btn d-none d-md-flex" id="btn-mute" title="Volume"><i class="bi bi-volume-up" id="volume-icon"></i></button>
              <div class="volume-bar" id="volume-container">
                <div class="volume-bg"></div>
                <div class="volume-filled" id="volume-filled"></div>
              </div>
              <button class="pb-btn d-none d-md-flex" id="btn-open-panel" title="Now Playing"><i class="bi bi-music-note-list"></i></button>
            </div>
          </div>

          <div class="ytm-modal" id="ytm-modal">
            <div class="ytm-modal-header">
              <button class="btn btn-link text-white p-1" id="btn-close-modal" style="text-decoration: none;">
                <i class="bi bi-chevron-down fs-4"></i>
              </button>
            </div>
            <div class="ytm-modal-body">
              <div class="ytm-modal-content">
                <div class="ytm-modal-art-box">
                  <img id="modal-art" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjMjIyIi8+PC9zdmc+" alt="Cover">
                </div>
                <div class="ytm-modal-details">
                  <div class="text-truncate w-100">
                    <h4 class="fw-bold m-0 text-truncate" id="modal-title">Track Title</h4>
                    <span class="text-secondary text-truncate d-block mt-2" id="modal-artist">Artist Name</span>
                  </div>
                </div>
                <div class="w-100 mt-4">
                  <div class="pb-timeline mb-3">
                    <span class="pb-time" id="modal-time-current">0:00</span>
                    <div class="timeline-container" id="modal-timeline-container">
                      <div class="timeline-bg"></div>
                      <div class="timeline-filled" id="modal-timeline-bar"></div>
                    </div>
                    <span class="pb-time" id="modal-time-total">0:00</span>
                  </div>
                  <div class="d-flex align-items-center justify-content-between w-100">
                    <button class="pb-btn btn-modal-shuffle btn-modal-lg" id="modal-btn-shuffle" title="Shuffle"><i class="bi bi-shuffle"></i></button>
                    <button class="pb-btn btn-modal-xl" id="modal-btn-prev" title="Previous"><i class="bi bi-skip-start-fill"></i></button>
                    <button class="pb-btn pb-modal-play-circle d-flex align-items-center justify-content-center" id="modal-btn-play-pause" title="Play/Pause">
                      <i class="bi bi-play-fill" id="modal-play-icon"></i>
                    </button>
                    <button class="pb-btn btn-modal-xl" id="modal-btn-next" title="Next"><i class="bi bi-skip-end-fill"></i></button>
                    <button class="pb-btn btn-modal-repeat btn-modal-lg" id="modal-btn-repeat" title="Repeat"><i class="bi bi-repeat"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
          <script>
                        const apiForm = document.getElementById('api-form');
            const apiUrlInput = document.getElementById('api-url');
            const apiKeyInput = document.getElementById('api-key-input');
            const btnShare = document.getElementById('btn-share');
            const sourceTypeSelect = document.getElementById('source-type');
            const playlistIdInput = document.getElementById('playlist-id');
            const playlistIdContainer = document.getElementById('playlist-id-container');
            const artistIdInput = document.getElementById('artist-id');
            const artistIdContainer = document.getElementById('artist-id-container');
            const albumNameInput = document.getElementById('album-name');
            const albumNameContainer = document.getElementById('album-name-container');
            const searchQueryInput = document.getElementById('search-query');
            const searchQueryContainer = document.getElementById('search-query-container');
            const sortBySelect = document.getElementById('sort-by');
            const sidebarStatus = document.getElementById('sidebar-status');
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            const sidebar = document.querySelector('.sidebar');
            const totalTracksCount = document.getElementById('total-tracks-count');
            const songsContainer = document.getElementById('songs-container');
            const scrollSpinner = document.getElementById('scroll-spinner');
            const sentinel = document.getElementById('infinite-scroll-sentinel');
            const audioPlayer = document.getElementById('audio-player');
            const playerBar = document.getElementById('player-bar');
            const pbArt = document.getElementById('pb-art');
            const pbTitle = document.getElementById('pb-title');
            const pbArtist = document.getElementById('pb-artist');
            const btnPlayPause = document.getElementById('btn-play-pause');
            const playIcon = document.getElementById('play-icon');
            const btnPrev = document.getElementById('btn-prev');
            const btnNext = document.getElementById('btn-next');
            const btnShuffle = document.getElementById('btn-shuffle');
            const btnRepeat = document.getElementById('btn-repeat');
            const timeCurrent = document.getElementById('time-current');
            const timeTotal = document.getElementById('time-total');
            const timelineContainer = document.getElementById('timeline-container');
            const timelineBar = document.getElementById('timeline-bar');
            const btnMute = document.getElementById('btn-mute');
            const volumeIcon = document.getElementById('volume-icon');
            const volumeContainer = document.getElementById('volume-container');
            const volumeFilled = document.getElementById('volume-filled');
            const pbArtTrigger = document.getElementById('pb-art-trigger');
            const pbModalMobileTrigger = document.getElementById('pb-modal-mobile-trigger');
            const btnOpenPanel = document.getElementById('btn-open-panel');
            const ytmModal = document.getElementById('ytm-modal');
            const btnCloseModal = document.getElementById('btn-close-modal');
            const modalArt = document.getElementById('modal-art');
            const modalTitle = document.getElementById('modal-title');
            const modalArtist = document.getElementById('modal-artist');
            const modalTimeCurrent = document.getElementById('modal-time-current');
            const modalTimeTotal = document.getElementById('modal-time-total');
            const modalTimelineContainer = document.getElementById('modal-timeline-container');
            const modalTimelineBar = document.getElementById('modal-timeline-bar');
            const modalBtnShuffle = document.getElementById('modal-btn-shuffle');
            const modalBtnPrev = document.getElementById('modal-btn-prev');
            const modalBtnPlayPause = document.getElementById('modal-btn-play-pause');
            const modalPlayIcon = document.getElementById('modal-play-icon');
            const modalBtnNext = document.getElementById('modal-btn-next');
            const modalBtnRepeat = document.getElementById('modal-btn-repeat');
            let currentBaseUrl = '';
            let songQueue = [];
            let originalQueue = [];
            let currentIndex = -1;
            let currentPage = 1;
            let isFetching = false;
            let hasMoreSongs = true;
            let lastVolume = 1.0;
            let isShuffle = false;
            let repeatState = 'off';
            let lastSavedTime = 0;
            let isRestoringTime = false;
            const virtualObserver = new IntersectionObserver((entries) => {
              entries.forEach(entry => {
                const el = entry.target;
                if (entry.isIntersecting) {
                  if (el.dataset.virtualHtml) {
                    el.innerHTML = el.dataset.virtualHtml;
                    el.dataset.virtualHtml = '';
                    el.style.height = '';
                  }
                } else {
                  if (!el.dataset.virtualHtml && el.innerHTML !== '') {
                    if (el.classList.contains('now-playing')) return;
                    const h = el.offsetHeight;
                    if (h > 0) {
                      el.style.height = h + 'px';
                      el.dataset.virtualHtml = el.innerHTML;
                      el.innerHTML = '';
                    }
                  }
                }
              });
            }, {
              rootMargin: '800px 0px'
            });
            // FIX: Safely retrieve the Admin Password from shared sessionStorage or parent to prevent 401 crashes
            let apiKey = '';
            try {
              if (window.parent && window.parent.adminApiKey) apiKey = window.parent.adminApiKey;
            } catch (e) {}
            if (!apiKey) apiKey = sessionStorage.getItem('admin_api_key') || sessionStorage.getItem('ytm_apiKey') || '';
            const checkApiKey = () => {
              if (!apiKey) {
                try {
                  if (window.parent && window.parent.adminApiKey) apiKey = window.parent.adminApiKey;
                } catch (e) {}
              }
              if (!apiKey) {
                apiKey = sessionStorage.getItem('admin_api_key') || sessionStorage.getItem('ytm_apiKey') || '';
              }
              if (apiKey && apiKeyInput) {
                apiKeyInput.value = apiKey;
              }
              if (!apiKey) {
                sidebarStatus.innerHTML = `<i class="bi bi-exclamation-circle text-warning me-1"></i> API Key Required`;
              }
            };
            const getSvgPlaceholder = (title) => {
              let hash = 0;
              for (let i = 0; i < title.length; i++) {
                hash = title.charCodeAt(i) + ((hash << 5) - hash);
              }
              const h = Math.abs(hash % 360);
              const c1 = `hsl(${h}, 50%, 35%)`;
              const c2 = `hsl(${(h + 40) % 360}, 60%, 45%)`;
              const c3 = `hsl(${(h + 80) % 360}, 60%, 35%)`;
              const svgString = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="100%" height="100%"><defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="${c1}"/><stop offset="50%" stop-color="${c2}"/><stop offset="100%" stop-color="${c3}"/></linearGradient><filter id="shadow" x="-10%" y="-10%" width="120%" height="120%"><feDropShadow dx="0" dy="8" stdDeviation="12" flood-opacity="0.3"/></filter></defs><rect width="512" height="512" fill="url(#grad)"/><g transform="translate(128, 128) scale(10.66)" fill="none" stroke="#ffffff" stroke-width="1.5" opacity="0.9" filter="url(#shadow)"><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" d="M21.95 13c-.501 5.054-4.765 9-9.95 9c-5.523 0-10-4.477-10-10c0-1.821.487-3.529 1.338-5M11 2.05a9.9 9.9 0 0 0-4 1.288"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12V2.456a10.02 10.02 0 0 1 6.542 6.542"/></g></svg>`;
              return `data:image/svg+xml;charset=utf-8,${encodeURIComponent(svgString)}`;
            };
            sourceTypeSelect.addEventListener('change', (e) => {
              playlistIdContainer.classList.add('d-none');
              playlistIdInput.required = false;
              artistIdContainer.classList.add('d-none');
              artistIdInput.required = false;
              albumNameContainer.classList.add('d-none');
              albumNameInput.required = false;
              searchQueryContainer.classList.add('d-none');
              searchQueryInput.required = false;
              if (e.target.value === 'playlist') {
                playlistIdContainer.classList.remove('d-none');
                playlistIdInput.required = true;
              } else if (e.target.value === 'artist') {
                artistIdContainer.classList.remove('d-none');
                artistIdInput.required = true;
              } else if (e.target.value === 'album') {
                albumNameContainer.classList.remove('d-none');
                albumNameInput.required = true;
              } else if (e.target.value === 'search') {
                searchQueryContainer.classList.remove('d-none');
                searchQueryInput.required = true;
              }
            });
            const formatTime = (seconds) => {
              if (isNaN(seconds) || seconds < 0) return '0:00';
              const m = Math.floor(seconds / 60);
              const s = Math.floor(seconds % 60).toString().padStart(2, '0');
              return `${m}:${s}`;
            };
            const getApiUrl = (page) => {
              let joiner = currentBaseUrl.includes('?') ? '&' : (currentBaseUrl.endsWith('/') ? '?' : '/?');
              let url = `${currentBaseUrl}${joiner}action=`;
              const apiKeyStr = `&api_key=${encodeURIComponent(apiKey)}`;
              const sortVal = sortBySelect.value || 'id_desc';
              if (sourceTypeSelect.value === 'playlist') {
                const pId = encodeURIComponent(playlistIdInput.value.trim());
                url += `get_playlist_songs&public_id=${pId}&sort=${sortVal}&page=${page}${apiKeyStr}`;
              } else if (sourceTypeSelect.value === 'artist') {
                const val = artistIdInput.value.trim();
                if (/^\d+$/.test(val)) {
                  const encodedVal = encodeURIComponent(val);
                  url += `get_songs&filter_user_id=${encodedVal}&sort=${sortVal}&page=${page}${apiKeyStr}`;
                } else {
                  url += `get_songs&artist=${encodeURIComponent(val)}&sort=${sortVal}&page=${page}${apiKeyStr}`;
                }
              } else if (sourceTypeSelect.value === 'album') {
                const val = encodeURIComponent(albumNameInput.value.trim());
                url += `get_songs&album=${val}&sort=${sortVal}&page=${page}${apiKeyStr}`;
              } else if (sourceTypeSelect.value === 'search') {
                const rawVal = searchQueryInput.value.trim();
                const val = encodeURIComponent(rawVal);
                let searchSort = 'relevance';
                if (sortVal === 'id_desc' || sortVal === 'year_desc') searchSort = 'date';
                url += `search&q=${val}&f_sort=${searchSort}${apiKeyStr}`;
                // Utilize external transliteration library to support multi-language variations dynamically
                if (typeof transliterate !== 'undefined') {
                  const transliteratedVal = transliterate(rawVal);
                  if (transliteratedVal && transliteratedVal !== rawVal) {
                    url += `&rom=${encodeURIComponent(transliteratedVal)}`;
                  }
                }
              } else {
                url += `get_songs&sort=${sortVal}&page=${page}${apiKeyStr}`;
              }
              return url;
            };
            const fetchContent = async (isLoadMore = false) => {
              if (isFetching || !hasMoreSongs) return;
              isFetching = true;
              if (!isLoadMore) {
                sidebarStatus.innerHTML = `<span class="spinner-border spinner-border-sm text-danger me-1"></span> Fetching...`;
                songsContainer.innerHTML = '';
                songQueue = [];
                originalQueue = [];
                currentPage = 1;
                scrollSpinner.classList.remove('d-none');
              } else {
                scrollSpinner.classList.remove('d-none');
              }
              try {
                const response = await fetch(getApiUrl(currentPage));
                if (response.status === 401) {
                  sessionStorage.removeItem('ytm_apiKey');
                  apiKey = '';
                  sidebarStatus.innerHTML = `<i class="bi bi-x-circle-fill text-danger me-1"></i> Invalid API Key`;
                  try {
                    alert("API Key was rejected (401 Unauthorized). Please check your password and enter it again.");
                  } catch (e) {}
                  checkApiKey();
                  isFetching = false;
                  scrollSpinner.classList.add('d-none');
                  return;
                }
                if (!response.ok) throw new Error("Connection failed: HTTP " + response.status);
                let newSongs = await response.json();
                // Unpack 'search' endpoint JSON layout into standard song arrays
                if (newSongs && newSongs.shelves) {
                  const songShelf = newSongs.shelves.find(s => s.type === 'songs_list' || s.type === 'songs');
                  newSongs = songShelf ? songShelf.items : [];
                  hasMoreSongs = false; // Search provides bulk chunks, prevent infinite loop attempts
                }
                if (newSongs && newSongs.length > 0) {
                  sidebarStatus.innerHTML = `<i class="bi bi-check-circle-fill text-success me-1"></i> Connected`;
                  appendSongs(newSongs);
                  totalTracksCount.textContent = `${songQueue.length} tracks listed`;
                  if (newSongs.length < 25) {
                    hasMoreSongs = false;
                  }
                } else {
                  hasMoreSongs = false;
                  if (!isLoadMore) {
                    songsContainer.innerHTML = `
                      <div class="text-center text-secondary py-5">
                        <i class="bi bi-exclamation-circle-fill" style="font-size: 3rem;"></i>
                        <p class="mt-2">No tracks returned from this query.</p>
                      </div>`;
                    totalTracksCount.textContent = `0 tracks listed`;
                    // Trigger emergency modal if totally empty on first load
                    if (sourceTypeSelect.value === 'all' && currentPage === 1 && !window.emergencyScanPrompted) {
                      window.emergencyScanPrompted = true;
                      const emergencyModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('emergency-scan-modal'));
                      emergencyModal.show();
                    }
                  }
                }
              } catch (error) {
                sidebarStatus.innerHTML = `<i class="bi bi-x-circle-fill text-danger me-1"></i> Error API Connection`;
                console.error("Fetch Content Error:", error);
                hasMoreSongs = false;
                if (!isLoadMore) {
                  songsContainer.innerHTML = `
                    <div class="text-center text-danger py-5 px-3">
                      <i class="bi bi-exclamation-triangle-fill" style="font-size: 3.5rem;"></i>
                      <h4 class="mt-3 fw-bold">Connection Failed</h4>
                      <p class="mt-2 text-secondary">Failed to connect to backend endpoint.</p>
                      <div class="bg-dark p-3 rounded mt-3 text-start mx-auto border border-secondary" style="max-width: 600px;">
                        <code class="text-warning d-block" style="font-size: 0.85rem; overflow-wrap: break-word;">Error: ${error.message || 'Unknown Network Error'}</code>
                        <code class="text-info d-block mt-2" style="font-size: 0.8rem; overflow-wrap: break-word;">URL: ${getApiUrl(currentPage)}</code>
                      </div>
                      <p class="mt-3 small text-secondary">Verify your Backend URL and API Key in the sidebar menu.</p>
                    </div>`;
                }
              }
              isFetching = false;
              scrollSpinner.classList.add('d-none');
            };
            apiForm.addEventListener('submit', (e) => {
              e.preventDefault();
              if (apiKeyInput && apiKeyInput.value.trim()) {
                apiKey = apiKeyInput.value.trim();
                sessionStorage.setItem('ytm_apiKey', apiKey);
              }
              checkApiKey();
              if (!apiKey) {
                alert("An API Key is required to establish a connection.");
                return;
              }
              let rawUrl = apiUrlInput.value.trim().replace(/\/$/, '');
              if (!rawUrl) return;
              if (!rawUrl.includes('access=api')) {
                rawUrl += (rawUrl.includes('?') ? '&' : '/?') + 'access=api';
              }
              currentBaseUrl = rawUrl;
              apiUrlInput.value = currentBaseUrl;
              localStorage.setItem('ytm_apiUrl', currentBaseUrl);
              localStorage.setItem('ytm_sourceType', sourceTypeSelect.value);
              localStorage.setItem('ytm_playlistId', playlistIdInput.value.trim());
              localStorage.setItem('ytm_artistId', artistIdInput.value.trim());
              localStorage.setItem('ytm_albumName', albumNameInput.value.trim());
              localStorage.setItem('ytm_searchQuery', searchQueryInput.value.trim());
              localStorage.setItem('ytm_sortBy', sortBySelect.value);
              hasMoreSongs = true;
              fetchContent(false);
              if (window.innerWidth <= 768 && sidebar) {
                sidebar.classList.remove('show');
              }
            });
            const observer = new IntersectionObserver((entries) => {
              if (entries[0].isIntersecting && !isFetching && hasMoreSongs && currentBaseUrl !== '') {
                currentPage++;
                fetchContent(true);
              }
            }, {
              rootMargin: '100px'
            });
            observer.observe(sentinel);

            function appendSongs(newSongs) {
              const startIndex = songQueue.length;
              if (isShuffle) {
                originalQueue = originalQueue.concat(newSongs);
                songQueue = songQueue.concat(newSongs);
              } else {
                songQueue = songQueue.concat(newSongs);
                originalQueue = [...songQueue];
              }
              let html = '';
              let joiner = currentBaseUrl.includes('?') ? '&' : (currentBaseUrl.endsWith('/') ? '?' : '/?');
              newSongs.forEach((song, i) => {
                const globalIndex = startIndex + i;
                const isActive = (currentIndex !== -1 && songQueue[currentIndex] && String(songQueue[currentIndex].id) === String(song.id)) ? 'active' : '';
                const coverSvg = getSvgPlaceholder(song.title || 'Unknown');
                const coverImg = `${currentBaseUrl}${joiner}action=get_image&id=${song.id}&v=${song.last_modified || 0}&size=small`;
                html += `
                  <div class="song-item ${isActive}" data-song-id="${song.id}" data-index="${globalIndex}">
                    <img src="${coverImg}" onerror="this.src='${coverSvg}'" class="song-thumb" alt="Cover">
                    <div style="min-width: 0;" class="text-truncate">
                      <div class="song-title text-truncate">${song.title || 'Unknown Title'}</div>
                      <div class="song-artist text-truncate">${song.artist || 'Unknown Artist'}</div>
                    </div>
                    <div class="song-album text-truncate">${song.album || 'Unknown Album'}</div>
                    <div class="song-duration">${formatTime(song.duration)}</div>
                  </div>
                `;
              });
              if (startIndex === 0) {
                songsContainer.innerHTML = html;
              } else {
                songsContainer.insertAdjacentHTML('beforeend', html);
              }
              songsContainer.querySelectorAll('.song-item:not(.v-obs)').forEach(el => {
                el.classList.add('v-obs');
                virtualObserver.observe(el);
              });
            }
            songsContainer.addEventListener('click', (e) => {
              const item = e.target.closest('.song-item');
              if (item && !e.target.closest('button')) {
                const songId = item.getAttribute('data-song-id');
                const targetIndex = songQueue.findIndex(s => String(s.id) === songId);
                if (targetIndex !== -1) {
                  playSong(targetIndex);
                }
              }
            });

            function playSong(index) {
              if (index < 0 || index >= songQueue.length) return;
              currentIndex = index;
              const song = songQueue[currentIndex];
              document.querySelectorAll('.song-item.active').forEach(el => el.classList.remove('active'));
              const activeRow = document.querySelector(`.song-item[data-song-id="${song.id}"]`);
              if (activeRow) activeRow.classList.add('active');
              playerBar.classList.add('visible');
              let joiner = currentBaseUrl.includes('?') ? '&' : (currentBaseUrl.endsWith('/') ? '?' : '/?');
              const coverSvg = getSvgPlaceholder(song.title || 'Unknown');
              const coverImg = `${currentBaseUrl}${joiner}action=get_image&id=${song.id}&v=${song.last_modified || 0}&size=small`;
              const fullCoverImg = `${currentBaseUrl}${joiner}action=get_image&id=${song.id}&v=${song.last_modified || 0}`;
              pbTitle.textContent = song.title || 'Unknown';
              pbArtist.textContent = song.artist || 'Unknown';
              modalTitle.textContent = song.title || 'Unknown';
              modalArtist.textContent = song.artist || 'Unknown';
              pbArt.src = coverImg;
              pbArt.onerror = function() {
                this.src = coverSvg;
              };
              modalArt.src = fullCoverImg;
              modalArt.onerror = function() {
                this.src = coverSvg;
              };
              // Apply dynamic blurred background to modals
              const mobileBg = document.getElementById("mobile-player-bg");
              const desktopBg = document.getElementById("desktop-player-bg");
              if (mobileBg) mobileBg.style.backgroundImage = `url('${fullCoverImg}')`;
              if (desktopBg) desktopBg.style.backgroundImage = `url('${fullCoverImg}')`;
              lastSavedTime = 0;
              isRestoringTime = false;
              audioPlayer.src = `${currentBaseUrl}${joiner}action=get_stream&id=${song.id}&api_key=${encodeURIComponent(apiKey)}`;
              audioPlayer.play().catch(err => console.error("Playback restriction: ", err));
              if ('mediaSession' in navigator) {
                navigator.mediaSession.metadata = new MediaMetadata({
                  title: song.title || 'Unknown Title',
                  artist: song.artist || 'Unknown Artist',
                  album: song.album || 'Unknown Album',
                  artwork: [{
                    src: fullCoverImg,
                    sizes: '512x512',
                    type: 'image/webp'
                  }]
                });
              }
            }
            audioPlayer.addEventListener('loadedmetadata', () => {
              if (isRestoringTime) {
                audioPlayer.currentTime = lastSavedTime;
                isRestoringTime = false;
              }
            });

            function togglePlayPause() {
              if (audioPlayer.paused) {
                if (!audioPlayer.src || audioPlayer.src === window.location.href || audioPlayer.src.endsWith('/')) {
                  const song = songQueue[currentIndex];
                  isRestoringTime = true;
                  let joiner = currentBaseUrl.includes('?') ? '&' : (currentBaseUrl.endsWith('/') ? '?' : '/?');
                  audioPlayer.src = `${currentBaseUrl}${joiner}action=get_stream&id=${song.id}&api_key=${encodeURIComponent(apiKey)}`;
                }
                audioPlayer.play();
              } else {
                audioPlayer.pause();
                lastSavedTime = audioPlayer.currentTime;
                audioPlayer.removeAttribute('src');
                audioPlayer.load();
                playIcon.className = 'bi bi-play-fill';
                modalPlayIcon.className = 'bi bi-play-fill';
              }
            }
            btnPlayPause.addEventListener('click', togglePlayPause);
            modalBtnPlayPause.addEventListener('click', togglePlayPause);

            function playNext() {
              if (repeatState === 'one') {
                audioPlayer.currentTime = 0;
                audioPlayer.play();
                return;
              }
              if (currentIndex + 1 < songQueue.length) {
                playSong(currentIndex + 1);
              } else {
                if (repeatState === 'all') {
                  playSong(0);
                }
              }
            }
            btnNext.addEventListener('click', playNext);
            modalBtnNext.addEventListener('click', playNext);

            function playPrev() {
              if (audioPlayer.currentTime > 3) {
                audioPlayer.currentTime = 0;
              } else if (currentIndex - 1 >= 0) {
                playSong(currentIndex - 1);
              } else {
                if (repeatState === 'all') {
                  playSong(songQueue.length - 1);
                }
              }
            }
            btnPrev.addEventListener('click', playPrev);
            modalBtnPrev.addEventListener('click', playPrev);
            audioPlayer.addEventListener('play', () => {
              playIcon.className = 'bi bi-pause-fill';
              modalPlayIcon.className = 'bi bi-pause-fill';
              if ('mediaSession' in navigator) {
                navigator.mediaSession.playbackState = 'playing';
              }
            });
            audioPlayer.addEventListener('pause', () => {
              playIcon.className = 'bi bi-play-fill';
              modalPlayIcon.className = 'bi bi-play-fill';
              if ('mediaSession' in navigator) {
                navigator.mediaSession.playbackState = 'paused';
              }
            });
            audioPlayer.addEventListener('emptied', () => {
              playIcon.className = 'bi bi-play-fill';
              modalPlayIcon.className = 'bi bi-play-fill';
              if ('mediaSession' in navigator) {
                navigator.mediaSession.playbackState = 'none';
              }
            });
            audioPlayer.addEventListener('ended', playNext);
            audioPlayer.addEventListener('timeupdate', () => {
              const current = audioPlayer.currentTime;
              const duration = audioPlayer.duration;
              if (isFinite(duration)) {
                const percent = (current / duration) * 100;
                timeCurrent.textContent = formatTime(current);
                timeTotal.textContent = formatTime(duration);
                timelineBar.style.width = `${percent}%`;
                modalTimeCurrent.textContent = formatTime(current);
                modalTimeTotal.textContent = formatTime(duration);
                modalTimelineBar.style.width = `${percent}%`;
              }
            });

            function seekTo(e, element) {
              if (!isFinite(audioPlayer.duration)) return;
              const rect = element.getBoundingClientRect();
              const pos = (e.clientX - rect.left) / rect.width;
              audioPlayer.currentTime = pos * audioPlayer.duration;
            }
            timelineContainer.addEventListener('click', (e) => seekTo(e, timelineContainer));
            modalTimelineContainer.addEventListener('click', (e) => seekTo(e, modalTimelineContainer));

            function setVolume(e) {
              const rect = volumeContainer.getBoundingClientRect();
              let pos = (e.clientX - rect.left) / rect.width;
              pos = Math.max(0, Math.min(1, pos));
              audioPlayer.volume = pos;
              if (pos > 0) lastVolume = pos;
              volumeFilled.style.width = `${pos * 100}%`;
              updateVolumeIcon(pos);
            }
            volumeContainer.addEventListener('click', setVolume);

            function updateVolumeIcon(vol) {
              if (vol === 0) {
                volumeIcon.className = 'bi bi-volume-mute';
              } else if (vol < 0.5) {
                volumeIcon.className = 'bi bi-volume-down';
              } else {
                volumeIcon.className = 'bi bi-volume-up';
              }
            }
            btnMute.addEventListener('click', () => {
              if (audioPlayer.volume === 0 || audioPlayer.muted) {
                audioPlayer.muted = false;
                let restoreVol = lastVolume > 0 ? lastVolume : 1;
                audioPlayer.volume = restoreVol;
                volumeFilled.style.width = `${restoreVol * 100}%`;
              } else {
                lastVolume = audioPlayer.volume;
                audioPlayer.muted = true;
                audioPlayer.volume = 0;
                volumeFilled.style.width = '0%';
              }
              updateVolumeIcon(audioPlayer.volume);
            });

            function toggleShuffle() {
              isShuffle = !isShuffle;
              if (isShuffle) {
                btnShuffle.classList.add('active');
                modalBtnShuffle.classList.add('active');
                if (songQueue.length > 0) {
                  const currentSong = songQueue[currentIndex];
                  let tempArray = [...originalQueue];
                  for (let i = tempArray.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [tempArray[i], tempArray[j]] = [tempArray[j], tempArray[i]];
                  }
                  if (currentSong) {
                    tempArray = tempArray.filter(s => s.id !== currentSong.id);
                    tempArray.unshift(currentSong);
                  }
                  songQueue = tempArray;
                  currentIndex = currentSong ? 0 : -1;
                }
              } else {
                btnShuffle.classList.remove('active');
                modalBtnShuffle.classList.remove('active');
                if (songQueue.length > 0) {
                  const currentSong = songQueue[currentIndex];
                  songQueue = [...originalQueue];
                  currentIndex = songQueue.findIndex(s => s.id === currentSong.id);
                }
              }
            }
            btnShuffle.addEventListener('click', toggleShuffle);
            modalBtnShuffle.addEventListener('click', toggleShuffle);

            function cycleRepeat() {
              if (repeatState === 'off') {
                repeatState = 'all';
                btnRepeat.classList.add('active');
                btnRepeat.innerHTML = `<i class="bi bi-repeat"></i>`;
                modalBtnRepeat.classList.add('active');
                modalBtnRepeat.innerHTML = `<i class="bi bi-repeat"></i>`;
              } else if (repeatState === 'all') {
                repeatState = 'one';
                btnRepeat.classList.add('active');
                btnRepeat.innerHTML = `<i class="bi bi-repeat-1"></i>`;
                modalBtnRepeat.classList.add('active');
                modalBtnRepeat.innerHTML = `<i class="bi bi-repeat-1"></i>`;
              } else {
                repeatState = 'off';
                btnRepeat.classList.remove('active');
                btnRepeat.innerHTML = `<i class="bi bi-repeat"></i>`;
                modalBtnRepeat.classList.remove('active');
                modalBtnRepeat.innerHTML = `<i class="bi bi-repeat"></i>`;
              }
            }
            btnRepeat.addEventListener('click', cycleRepeat);
            modalBtnRepeat.addEventListener('click', cycleRepeat);

            function openPlayerModal() {
              ytmModal.classList.add('open');
              document.body.style.overflow = 'hidden';
            }

            function closePlayerModal() {
              ytmModal.classList.remove('open');
              document.body.style.overflow = '';
            }
            pbArtTrigger.addEventListener('click', openPlayerModal);
            pbModalMobileTrigger.addEventListener('click', openPlayerModal);
            btnOpenPanel.addEventListener('click', openPlayerModal);
            btnCloseModal.addEventListener('click', closePlayerModal);
            if (sidebarToggleBtn && sidebar) {
              sidebarToggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
              });
            }
            // MODIFIED: Inject URL securely from Parent frame to avoid domain typing & prevent nullsrcdoc
            let savedApiUrl = '';
            try {
              if (window.parent && window.parent.location && window.parent.location.href && !window.parent.location.href.includes('srcdoc') && !window.parent.location.href.includes('about:blank')) {
                savedApiUrl = window.parent.location.href.split('?')[0].split('#')[0];
              } else {
                savedApiUrl = window.location.href.split('?')[0].split('#')[0];
              }
            } catch (e) {
              savedApiUrl = window.location.href.split('?')[0].split('#')[0];
            }
            if (savedApiUrl.includes('null') || savedApiUrl.includes('srcdoc') || savedApiUrl === 'about:blank') {
              savedApiUrl = '/';
            }
            // Allow explicit local storage override if it exists
            const storedUrl = localStorage.getItem('ytm_apiUrl');
            if (storedUrl) savedApiUrl = storedUrl;
            if (savedApiUrl) {
              savedApiUrl = savedApiUrl.replace(/\/+$/, ''); // Strip trailing slashes to prevent double slash bug
              if (!savedApiUrl.includes('access=api')) {
                savedApiUrl += (savedApiUrl.includes('?') ? '&' : '/?') + 'access=api';
              }
            }
            const savedSourceType = localStorage.getItem('ytm_sourceType');
            const savedPlaylistId = localStorage.getItem('ytm_playlistId');
            const savedArtistId = localStorage.getItem('ytm_artistId');
            const savedAlbumName = localStorage.getItem('ytm_albumName');
            const savedSearchQuery = localStorage.getItem('ytm_searchQuery');
            const savedSortBy = localStorage.getItem('ytm_sortBy');
            if (savedApiUrl) {
              apiUrlInput.value = savedApiUrl;
              currentBaseUrl = savedApiUrl;
            }
            if (savedSourceType) {
              sourceTypeSelect.value = savedSourceType;
              sourceTypeSelect.dispatchEvent(new Event('change'));
            }
            if (savedPlaylistId) playlistIdInput.value = savedPlaylistId;
            if (savedArtistId) artistIdInput.value = savedArtistId;
            if (savedAlbumName) albumNameInput.value = savedAlbumName;
            if (savedSearchQuery) searchQueryInput.value = savedSearchQuery;
            if (savedSortBy) sortBySelect.value = savedSortBy;
            const parseHashParams = () => {
              const hash = window.location.hash.substring(1);
              if (!hash) return null;
              const params = {};
              const pairs = hash.split('&');
              for (let pair of pairs) {
                if (pair === 'playground') continue; // Ignore the routing token
                const [key, val] = pair.split('=');
                if (key && val) {
                  params[decodeURIComponent(key)] = decodeURIComponent(val);
                }
              }
              return params;
            };
            const applyHashParams = () => {
              const hashParams = parseHashParams();
              if (hashParams) {
                const hashBackendUrl = hashParams['backendurl'];
                const hashSourceType = hashParams['sourcetype'];
                const hashIdName = hashParams['id/name'] || hashParams['id'] || hashParams['name'];
                const hashApiKey = hashParams['apikey'];
                if (hashApiKey) {
                  apiKey = hashApiKey;
                  sessionStorage.setItem('ytm_apiKey', apiKey);
                  if (apiKeyInput) apiKeyInput.value = apiKey;
                }
                if (hashBackendUrl) {
                  let rawUrl = hashBackendUrl.replace(/\/$/, '');
                  if (!rawUrl.includes('access=api')) {
                    rawUrl += (rawUrl.includes('?') ? '&' : '/?') + 'access=api';
                  }
                  apiUrlInput.value = rawUrl;
                  currentBaseUrl = rawUrl;
                  localStorage.setItem('ytm_apiUrl', rawUrl);
                }
                if (hashSourceType) {
                  sourceTypeSelect.value = hashSourceType;
                  sourceTypeSelect.dispatchEvent(new Event('change'));
                  localStorage.setItem('ytm_sourceType', hashSourceType);
                }
                if (hashIdName) {
                  if (hashSourceType === 'playlist') {
                    playlistIdInput.value = hashIdName;
                    localStorage.setItem('ytm_playlistId', hashIdName);
                  } else if (hashSourceType === 'artist') {
                    artistIdInput.value = hashIdName;
                    localStorage.setItem('ytm_artistId', hashIdName);
                  } else if (hashSourceType === 'album') {
                    albumNameInput.value = hashIdName;
                    localStorage.setItem('ytm_albumName', hashIdName);
                  } else if (hashSourceType === 'search') {
                    searchQueryInput.value = hashIdName;
                    localStorage.setItem('ytm_searchQuery', hashIdName);
                  }
                }
              }
              checkApiKey();
              if (currentBaseUrl && apiKey) {
                hasMoreSongs = true;
                isFetching = false;
                fetchContent(false);
              }
            };
            window.addEventListener('hashchange', applyHashParams);
            applyHashParams();
            const btnBackMain = document.getElementById('btn-back-main');
            if (btnBackMain) {
              btnBackMain.addEventListener('click', async () => {
                // Inject seamless spinner overlay
                const spinnerOverlay = document.createElement('div');
                spinnerOverlay.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--ytm-bg, #030303); z-index: 999999; display: flex; align-items: center; justify-content: center; flex-direction: column; opacity: 0; transition: opacity 0.3s ease;';
                spinnerOverlay.innerHTML = '<div class="spinner-border text-danger" style="width: 3.5rem; height: 3.5rem; border-width: 0.25em;" role="status"></div><div class="text-white mt-4 fw-bold font-monospace fs-5">Loading Main Site...</div>';
                document.body.appendChild(spinnerOverlay);
                // Fade it in
                requestAnimationFrame(() => {
                  spinnerOverlay.style.opacity = '1';
                });
                try {
                  // Fetch the main site HTML silently in the background
                  const response = await fetch(window.location.pathname);
                  const htmlContent = await response.text();
                  // Seamlessly rebuild the DOM backward without a hard reload
                  setTimeout(() => {
                    history.replaceState(null, '', window.location.pathname);
                    document.open();
                    document.write(htmlContent);
                    document.close();
                  }, 400);
                } catch (error) {
                  // Fallback to hard reload only if network fails
                  setTimeout(() => {
                    history.replaceState(null, '', window.location.pathname);
                    window.location.reload();
                  }, 400);
                }
              });
            }
            if (btnShare) {
              btnShare.addEventListener('click', () => {
                const backendUrl = apiUrlInput.value.trim();
                const sourceType = sourceTypeSelect.value;
                let idName = '';
                if (sourceType === 'playlist') {
                  idName = playlistIdInput.value.trim();
                } else if (sourceType === 'artist') {
                  idName = artistIdInput.value.trim();
                } else if (sourceType === 'album') {
                  idName = albumNameInput.value.trim();
                } else if (sourceType === 'search') {
                  idName = searchQueryInput.value.trim();
                }
                const baseUrl = window.location.origin + window.location.pathname;
                const hashParts = [];
                if (sourceType) hashParts.push(`sourcetype=${encodeURIComponent(sourceType)}`);
                if (idName) hashParts.push(`id/name=${encodeURIComponent(idName)}`);
                if (backendUrl) hashParts.push(`backendurl=${encodeURIComponent(backendUrl)}`);
                const shareUrl = `${baseUrl}#playground&${hashParts.join('&')}`;
                navigator.clipboard.writeText(shareUrl).then(() => {
                  const originalText = btnShare.innerHTML;
                  btnShare.innerHTML = `<i class="bi bi-check-circle-fill"></i> Copied!`;
                  setTimeout(() => {
                    btnShare.innerHTML = originalText;
                  }, 2000);
                }).catch((err) => {
                  console.error('Failed to copy share link: ', err);
                });
              });
            }
            if ('mediaSession' in navigator) {
              navigator.mediaSession.setActionHandler('play', () => {
                togglePlayPause();
              });
              navigator.mediaSession.setActionHandler('pause', () => {
                togglePlayPause();
              });
              navigator.mediaSession.setActionHandler('previoustrack', () => {
                playPrev();
              });
              navigator.mediaSession.setActionHandler('nexttrack', () => {
                playNext();
              });
            }
          </script>
        </body>
      </html>
    </template>

    <div class="modal fade" id="license-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: var(--ytm-surface); border: 1px solid #404040;">
          <div class="modal-header border-0 pb-2" style="border-bottom: 1px solid var(--ytm-surface-2) !important;">
            <h5 class="modal-title text-white"><i class="bi bi-shield-check text-success me-2"></i> Software License</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-light">
            <div class="p-3 rounded" style="background: rgba(0,0,0,0.2); font-family: 'Courier New', Courier, monospace; font-size: 0.85rem; line-height: 1.5; white-space: pre-wrap;">MIT License

Copyright (c) 2026 èµ¤è‘¦ã ã‚“ã”

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.</div>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="playlist-downloader-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content" style="background-color: var(--ytm-bg);">
          <div class="modal-header border-0" style="background-color: var(--ytm-surface-2);">
            <h5 class="modal-title"><i class="bi bi-cloud-arrow-down-fill"></i> Playlist Downloader</h5>
            <button type="button" class="btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-2 p-md-4">
            <div class="container-fluid mx-auto" style="max-width: 1000px;">
              <div class="card mb-4" style="background-color: var(--ytm-surface); border: none;">
                <div class="card-header" style="background-color: var(--ytm-surface-2); font-weight: bold; border: none; color: #ffffff !important;">Load Playlist / Song</div>
                <div class="card-body">
                  <form id="pd-load-form" class="mb-4">
                    <div class="mb-3">
                      <label for="pd-playlist-id" class="form-label" style="color: #ffffff !important;">Playlist ID</label>
                      <input type="text" class="form-control" id="pd-playlist-id" placeholder="Enter Playlist Public ID">
                    </div>
                    <button type="submit" class="btn btn-danger">Load Playlist</button>
                  </form>
                  <hr class="text-secondary">
                  <div class="mb-3">
                    <label for="pd-song-id" class="form-label" style="color: #ffffff !important;">Download a single song by ID</label>
                    <div class="input-group">
                      <input type="number" class="form-control" id="pd-song-id" placeholder="Song ID">
                      <button class="btn btn-outline-light" type="button" id="pd-download-single" style="color: #ffffff !important;">Download</button>
                    </div>
                  </div>
                </div>
              </div>

              <div id="pd-results-card" class="card d-none" style="background-color: var(--ytm-surface); border: none;">
                <div class="card-header" style="background-color: var(--ytm-surface-2); font-weight: bold; border: none; color: #ffffff !important;" id="pd-playlist-title">
                  Playlist Details
                </div>
                <div class="card-body">
                  <button class="btn btn-danger w-100 mb-3" id="pd-start-auto" style="color: #ffffff !important;">
                    <i class="bi bi-play-fill" style="color: #ffffff !important;"></i> Download All Songs (Sequential)
                  </button>
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2" style="color: #ffffff !important;">
                      <span><i class="bi bi-terminal" style="color: #ffffff !important;"></i> Download Log</span>
                      <button class="btn btn-sm btn-outline-secondary" id="pd-clear-log" style="color: #ffffff !important; border-color: #ffffff;">Clear</button>
                    </div>
                    <div class="log-area" id="pd-log" style="background-color: var(--ytm-surface-2); border-radius: 8px; padding: 1rem; font-family: monospace; font-size: 0.85rem; height: 300px; overflow-y: auto; color: #ffffff !important;"></div>
                  </div>
                  <div>
                    <strong style="color: #ffffff !important;">Song List</strong>
                    <div class="song-list mt-2" style="background-color: var(--ytm-surface); border-radius: 12px; overflow: hidden;">
                      <div class="song-item small d-none d-md-grid pd-song-row" style="color: #ffffff !important;">
                        <div style="color: #ffffff !important;" class="d-flex align-items-center"><input class="form-check-input me-2" type="checkbox" id="pd-select-all" checked> #</div>
                        <div style="color: #ffffff !important;">Title</div><div style="color: #ffffff !important;">Artist</div><div style="color: #ffffff !important;">Duration</div><div></div>
                      </div>
                      <div id="pd-song-rows"></div>
                    </div>
                    <div id="pd-infinite-scroll-loader" class="text-center p-3 d-none" style="color: var(--ytm-secondary-text);">Loading more...</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="song-audio-settings-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: rgba(30, 30, 30, 0.95); backdrop-filter: blur(10px); border: 1px solid #444;">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title w-100 text-center text-white">Audio Settings for <br><small id="sas-song-title" class="text-secondary"></small></h5>
            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-white">
            <input type="hidden" id="sas-song-id">
            
            <div class="mb-4">
              <label class="form-label d-flex justify-content-between">
                <span>Song Volume Multiplier</span>
                <span id="sas-vol-val">1.0x</span>
              </label>
              <input type="range" class="form-range" id="sas-vol-slider" min="0" max="3" step="0.1" value="1">
              <small class="text-secondary d-block mt-1">Adjust if this specific song is too quiet or loud compared to others.</small>
            </div>
            
            <div class="mb-3">
              <label class="form-label d-flex justify-content-between align-items-center">
                <span>Per-Song Equalizer</span>
                <select class="form-select form-select-sm w-auto" id="sas-eq-preset-select">
                  <option value="Custom">Custom</option>
                  <option value="Flat">Flat</option>
                  <option value="Rock">Rock</option>
                  <option value="Jazz">Jazz</option>
                  <option value="Classical">Classical</option>
                  <option value="Pop">Pop</option>
                  <option value="Bass Boost">Bass Boost</option>
                </select>
              </label>
              <div class="d-flex justify-content-between text-center small text-secondary mt-3 mb-5">
                <span style="width:18%;">60Hz</span><span style="width:18%;">230Hz</span><span style="width:18%;">910Hz</span><span style="width:18%;">3.6kHz</span><span style="width:18%;">14kHz</span>
              </div>
              <div class="d-flex justify-content-between mt-2 mb-5">
                <input type="range" class="form-range sas-eq-band" data-band="0" min="-12" max="12" step="1" value="0" style="width:18%; transform: rotate(-90deg); margin-top: 40px; margin-bottom: 40px;">
                <input type="range" class="form-range sas-eq-band" data-band="1" min="-12" max="12" step="1" value="0" style="width:18%; transform: rotate(-90deg); margin-top: 40px; margin-bottom: 40px;">
                <input type="range" class="form-range sas-eq-band" data-band="2" min="-12" max="12" step="1" value="0" style="width:18%; transform: rotate(-90deg); margin-top: 40px; margin-bottom: 40px;">
                <input type="range" class="form-range sas-eq-band" data-band="3" min="-12" max="12" step="1" value="0" style="width:18%; transform: rotate(-90deg); margin-top: 40px; margin-bottom: 40px;">
                <input type="range" class="form-range sas-eq-band" data-band="4" min="-12" max="12" step="1" value="0" style="width:18%; transform: rotate(-90deg); margin-top: 40px; margin-bottom: 40px;">
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="button" class="btn btn-outline-secondary w-50" id="sas-reset-btn">Reset to Global</button>
              <button type="button" class="btn btn-danger w-50" id="sas-save-btn">Save to Song</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="sleep-timer-bubble" class="d-none">
      <i class="bi bi-moon-stars-fill text-info"></i>
      <span class="time" id="sleep-timer-countdown">00:00</span>
      <button class="action-btn text-secondary" id="sleep-timer-wake-btn" title="Toggle Screen Awake"><i class="bi bi-display"></i></button>
      <button class="action-btn text-secondary" id="sleep-timer-cancel-btn" title="Cancel Timer"><i class="bi bi-x-circle-fill"></i></button>
    </div>

    <!-- Fullscreen Presentation Mode -->
    <div id="presentation-mode">
      <div class="position-absolute top-0 start-0 w-100 d-flex justify-content-between align-items-center p-3 px-4 z-3" style="background: linear-gradient(to bottom, rgba(0,0,0,0.8), transparent);">
        <div class="d-flex align-items-center gap-2 text-white-50 small fw-bold text-uppercase" style="letter-spacing: 1px;">
          <i class="bi bi-easel-fill text-danger fs-5"></i> Presentation Mode
        </div>
        <button class="btn btn-outline-secondary border-0 text-light p-1" onclick="window.closePresentation()" title="Exit Presentation (Esc)">
          <i class="bi bi-x-lg fs-4"></i>
        </button>
      </div>
      
      <div id="presentation-content">
        <div class="slide-inner" id="presentation-slide-container"></div>
      </div>
      
      <div class="position-absolute bottom-0 w-100 p-3 pb-4 d-flex justify-content-between align-items-center text-muted z-3" style="background: linear-gradient(transparent, #0a0a0a);">
        <div>
          <button class="btn btn-sm btn-outline-secondary border-0" onclick="window.prevSlide()" title="Previous Slide (Left Arrow)"><i class="bi bi-chevron-left fs-5"></i></button>
          <span class="mx-3 fw-medium font-monospace" id="presentation-indicator">1 / 1</span>
          <button class="btn btn-sm btn-outline-secondary border-0" onclick="window.nextSlide()" title="Next Slide (Right Arrow)"><i class="bi bi-chevron-right fs-5"></i></button>
        </div>
        <span class="small opacity-50 d-none d-sm-inline">Use ← / → / Space to navigate. Esc to exit.</span>
      </div>
      
      <!-- Progress Bar -->
      <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: #1e1e1e;">
        <div id="presentation-progress" class="h-100" style="width: 0%; background: var(--ytm-accent); transition: width 0.3s ease;"></div>
      </div>
    </div>

    <!-- Main Client Floating Mini Player -->
    <div id="main-mini-player" class="d-none shadow-lg" style="position: fixed; bottom: 80px; right: 20px; width: 210px; height: 210px; background: #000; border-radius: 12px; z-index: 9999; overflow: hidden; color: #fff; aspect-ratio: 1 / 1; box-shadow: 0 16px 40px rgba(0,0,0,0.8);" onmouseenter="document.getElementById('mmp-overlay').style.opacity='1'" onmouseleave="document.getElementById('mmp-overlay').style.opacity='0'">

      <!-- Media Background -->
      <div style="position: absolute; top:0; left:0; right:0; bottom:0; display: flex; align-items: center; justify-content: center; background: #000;">
        <img id="mmp-cover" src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg'/>" style="width: 100%; height: 100%; object-fit: cover;">
        <canvas class="visualizer-canvas" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 5; opacity: 0.7;"></canvas>
      </div>

      <!-- Overlay Container -->
      <div id="mmp-overlay" style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.2s; display: flex; flex-direction: column; justify-content: space-between; z-index: 10;">

        <!-- Drag Header, PiP & Close -->
        <div id="mmp-header" style="height: 34px; padding: 6px 10px; cursor: move; display: flex; align-items: center; justify-content: flex-end; gap: 6px; background: linear-gradient(to bottom, rgba(0,0,0,0.7), transparent);">
          <button class="btn btn-sm text-white p-0 border-0 rounded-circle d-flex align-items-center justify-content-center" id="mmp-pip" style="width: 24px; height: 24px; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px);" title="Pop Out Mini Player (PiP)"><i class="bi bi-pip" style="font-size: 0.75rem;"></i></button>
          <button class="btn btn-sm text-white p-0 border-0 rounded-circle d-flex align-items-center justify-content-center" id="mmp-close" style="width: 24px; height: 24px; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px);" title="Close Mini Player"><i class="bi bi-x-lg" style="font-size: 0.75rem;"></i></button>
        </div>

        <!-- Center Controls -->
        <div class="d-flex align-items-center justify-content-center gap-3">
          <button class="btn text-white p-0 border-0" id="mmp-prev" title="Previous"><i class="bi bi-skip-start-fill" style="text-shadow: 0 2px 8px rgba(0,0,0,0.6);"></i></button>
          <button class="btn text-white p-0 border-0" id="mmp-play-pause" title="Play/Pause"><i class="bi bi-play-fill" id="mmp-play-icon" style="text-shadow: 0 2px 8px rgba(0,0,0,0.6);"></i></button>
          <button class="btn text-white p-0 border-0" id="mmp-next" title="Next"><i class="bi bi-skip-end-fill" style="text-shadow: 0 2px 8px rgba(0,0,0,0.6);"></i></button>
        </div>

        <!-- Title, Artist & Timeline (Matching IDE style) -->
        <div style="padding: 8px 12px; background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);">
          <div id="mmp-title" class="fw-bold text-truncate text-white text-center mb-0" style="font-size: 0.8rem; text-shadow: 0 1px 3px rgba(0,0,0,0.8);">Track Title</div>
          <div id="mmp-artist" class="text-truncate text-white-50 text-center mb-1 hover-underline" style="font-size: 0.7rem; text-shadow: 0 1px 3px rgba(0,0,0,0.8); cursor: pointer;">Artist Name</div>
          <div style="position: relative; height: 10px; display: flex; align-items: center;">
            <div style="width: 100%; height: 4px; background: rgba(255,255,255,0.3); border-radius: 2px; pointer-events: none;">
              <div id="mmp-progress" style="width: 0%; height: 100%; background: #ff0000; border-radius: 2px;"></div>
            </div>
            <input type="range" id="mmp-seek" min="0" max="100" value="0" step="0.1" style="-webkit-appearance: none; width: 100%; height: 100%; background: transparent; position: absolute; top: 0; left: 0; margin: 0; cursor: pointer; outline: none; opacity: 0;">
          </div>
          <!-- Hidden time elements to prevent JS crashes -->
          <span id="mmp-cur-time" class="d-none"></span>
          <span id="mmp-time-left" class="d-none"></span>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nosleep/0.12.0/NoSleep.min.js"></script>
    <?php require __DIR__ . '/app-script.php'; ?>
  </body>
</html>
