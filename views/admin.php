<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin · <?= tt_h($siteName) ?></title>
    <link rel="stylesheet" href="assets/app.css?v=0.3.0">
    <style>
        :root {
            --accent: <?= tt_h($accent) ?>
        }
        .library-editor .table-row { cursor: grab }
        .library-editor .table-row.dragging { opacity: .45 }
        .library-actions { display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end }
        .library-edit { display: grid; grid-template-columns: 1fr 2fr auto; gap: 10px; align-items: end; padding: 14px; border: 1px solid var(--line); border-radius: 12px; background: #0b0c0f }
        .library-edit[hidden] { display: none }
        .library-order-note { margin: 12px 0 0 }
    </style>
</head>

<body class="admin-page">
    <header class="admin-header">
        <div>
            <p class="eyebrow">TEA &amp; TOAST</p>
            <h1>Admin</h1>
        </div><?php if (isset($_GET['embed'])): ?><button type="button" class="button"
                onclick="window.parent.postMessage({type:'tea-toast-close-admin'},window.location.origin)">Back to
                player</button><?php else: ?><a class="button" href="./">Back to player</a><?php endif; ?>
                            
    </header>
    <main class="admin-grid">
        <?php if ($error): ?>
            <div class="alert error wide"><?= tt_h($error) ?></div><?php endif; ?>
        <section class="card wide" id="admin-libraries" tabindex="-1">
            <h2>Libraries</h2>
            <p class="muted">Each path is read directly. Drag libraries to set their order in the player.</p>
            <div class="table library-editor" id="library-list"><?php foreach ($libraries as $library): ?>
                    <div class="table-row" draggable="true" data-library-id="<?= (int) $library['id'] ?>">
                        <div><strong><?= tt_h($library['name']) ?></strong><small><?= tt_h($library['root_path']) ?></small>
                        </div>
                        <div class="library-actions"><button type="button" class="button small" data-edit-library="<?= (int) $library['id'] ?>">Edit</button><form method="post" onsubmit="return confirm('Delete this library? Its favourites and playlist references will also be removed.');"><input type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action" value="delete_library"><input type="hidden" name="id" value="<?= (int) $library['id'] ?>"><button class="button small danger">Delete</button></form></div>
                    </div>
                    <form method="post" class="library-edit" id="edit-library-<?= (int) $library['id'] ?>" hidden><input type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action" value="edit_library"><input type="hidden" name="id" value="<?= (int) $library['id'] ?>"><label>Library name<input name="name" value="<?= tt_h($library['name']) ?>" required></label><label>Absolute NAS path<input name="root_path" value="<?= tt_h($library['root_path']) ?>" required></label><div class="library-actions"><button type="button" class="button small" data-cancel-edit>Cancel</button><button class="button small primary">Save</button></div></form>
                    <?php endforeach; ?>
            </div>
            <p class="muted library-order-note">Drop rows into the order you want, then save when you are ready.</p>
            <form method="post" class="inline-form"><input type="hidden" name="csrf"
                    value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action"
                    value="add_library"><label>Library name<input name="name" required></label><label>Absolute NAS
                    path<input name="root_path" placeholder="/volume1/Music" required></label><button
                    class="button primary">Add library</button></form>
            <form method="post" id="reorder-libraries-form"><input type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action" value="reorder_libraries"><div id="library-order-fields"></div><button type="submit" class="button">Save order</button></form>
            <?php if ($notice && !$updateResult): ?><div class="alert success"><?= tt_h($notice) ?></div><?php endif; ?>
        </section>
        <section class="card" id="admin-users" tabindex="-1">
            <h2>Users</h2>
            <div class="table"><?php foreach ($users as $user): ?>
                    <div class="table-row">
                        <div><strong><?= tt_h($user['display_name']) ?></strong><small><?= tt_h($user['email']) ?> ·
                                <?= tt_h($user['role']) ?></small></div>
                        <?php if ((int) $user['id'] !== (int) $currentUser['id'] && $user['role'] !== 'super_admin'): ?>
                            <form method="post"><input type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input
                                    type="hidden" name="action" value="toggle_user"><input type="hidden" name="id"
                                    value="<?= (int) $user['id'] ?>"><button
                                    class="button small"><?= (int) $user['active'] ? 'Disable' : 'Enable' ?></button></form>
                            <form method="post" onsubmit="return confirm('Delete this user and their favourites?');"><input type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action" value="delete_user"><input type="hidden" name="id" value="<?= (int) $user['id'] ?>"><button class="button small danger">Delete</button></form>
                        <?php endif; ?>
                    </div><?php endforeach; ?>
            </div>
        </section>
        <section class="card" id="admin-create-user" tabindex="-1">
            <h2>Create user</h2>
            <form method="post"><input type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input
                    type="hidden" name="action" value="create_user"><label>Name<input name="display_name"
                        required></label><label>Email<input type="email" name="email" required></label><label>Temporary
                    password is generated automatically and must be changed on first sign-in.</label><label>Role<select
                        name="role">
                        <option value="user">User</option>
                        <option value="admin">Administrator</option>
                    </select></label><button class="button primary">Create user</button></form>
        </section>
        <section class="card wide" id="admin-player-settings" tabindex="-1">
            <h2>Player settings</h2>
            <form method="post" class="inline-form"><input type="hidden" name="csrf"
                    value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action" value="settings"><label>Site
                    name<input name="site_name" value="<?= tt_h($siteName) ?>" required></label><label>Accent
                    colour<input type="color" name="accent_colour" value="<?= tt_h($accent) ?>"></label><label
                    class="check"><input type="checkbox" name="registration_enabled" <?= $registrationEnabled ? 'checked' : '' ?>> Allow public registration</label><button class="button primary">Save settings</button>
            </form>
        </section>
        <?php if (($currentUser['role'] ?? '') === 'super_admin'): ?>
            <section class="card wide update-card" id="admin-updates" tabindex="-1">
                <div class="update-heading">
                    <div>
                        <h2>Application updates</h2>
                        <p class="muted">Downloads only files changed by a published GitHub release. Local modifications,
                            installation settings and private data are never overwritten automatically.</p>
                    </div><span class="pill">Installed
                        <?= tt_h((string) ($updateState['version'] ?? $releaseInfo['version'])) ?></span>
                </div>
                <?php if ($updateStateError): ?>
                    <div class="alert error"><?= tt_h($updateStateError) ?></div><?php endif; ?>
                <form method="post" class="inline-form update-repository"><input type="hidden" name="csrf"
                        value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action"
                        value="update_settings"><label>GitHub repository<input name="update_repository"
                            value="<?= tt_h($updateRepository) ?>" placeholder="owner/repository" required></label><button
                        class="button">Save repository</button></form>
                <?php if ($updateResult && $notice): ?>
                    <div class="alert success"><?= tt_h($notice) ?></div>
                <?php endif; ?>                <div class="update-actions">
                    <form method="post"><input type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input
                            type="hidden" name="action" value="check_update"><button class="button primary">Check for
                            updates</button></form>
                    <?php if ($updateState && !empty($updateState['updated_at'])): ?><small>Last installed state:
                            <?= tt_h((string) $updateState['updated_at']) ?></small><?php endif; ?>
                </div>
                <?php if ($updatePlan): ?>
                    <div class="update-summary">
                        <div><strong><?= tt_h($updatePlan['current_version']) ?></strong><span>Installed</span></div>
                        <div><strong>→</strong><span>Release</span></div>
                        <div><strong><?= tt_h($updatePlan['target_version']) ?></strong><span>Available</span></div>
                    </div>
                    <?php if ($updatePlan['up_to_date']): ?>
                        <div class="alert success">This installation is up to date.</div><?php else: ?>
                        <div class="update-counts"><span class="status-pill safe"><?= (int) $updatePlan['counts']['safe'] ?>
                                safe</span><span class="status-pill conflict"><?= (int) $updatePlan['counts']['conflict'] ?>
                                protected conflicts</span><span
                                class="status-pill local"><?= (int) $updatePlan['counts']['local'] ?> local-only changes</span>
                        </div>
                        <div class="table update-table"><?php foreach ($updatePlan['entries'] as $entry): ?>
                                <div class="table-row">
                                    <div><strong><?= tt_h($entry['path']) ?></strong><small><?= tt_h(ucfirst($entry['action'])) ?> ·
                                            <?= tt_h($entry['label']) ?></small></div><span
                                        class="status-pill <?= tt_h($entry['status']) ?>"><?= tt_h(str_replace('_', ' ', $entry['status'])) ?></span>
                                </div><?php endforeach; ?>
                        </div>
                        <?php if ($updatePlan['counts']['safe'] > 0 || $updatePlan['counts']['already_current'] > 0): ?>
                            <form method="post" class="install-update-form"
                                onsubmit="return confirm('Back up the affected files and install this update now?');"><input
                                    type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action"
                                    value="install_update"><button class="button primary">Back up and install
                                    <?= (int) $updatePlan['counts']['safe'] ?> safe change(s)</button></form><?php endif; ?>
                    <?php endif; ?>    <?php endif; ?>
            </section><?php endif; ?>
    </main>
    <script>(() => { const returnFocus = <?= json_encode($returnFocus, JSON_UNESCAPED_SLASHES) ?>; const list = document.getElementById('library-list'); const orderForm = document.getElementById('reorder-libraries-form'); const fields = document.getElementById('library-order-fields'); const collectOrder = () => { fields.innerHTML = ''; list.querySelectorAll('.table-row[data-library-id]').forEach(row => { const input = document.createElement('input'); input.type = 'hidden'; input.name = 'library_ids[]'; input.value = row.dataset.libraryId; fields.append(input) }) }; let dragged = null; list?.addEventListener('dragstart', event => { dragged = event.target.closest('.table-row[data-library-id]'); dragged?.classList.add('dragging') }); list?.addEventListener('dragend', () => { dragged?.classList.remove('dragging'); dragged = null }); list?.addEventListener('dragover', event => { event.preventDefault(); const target = event.target.closest('.table-row[data-library-id]'); if (!dragged || !target || target === dragged) return; const box = target.getBoundingClientRect(); list.insertBefore(dragged, event.clientY < box.top + box.height / 2 ? target : target.nextSibling) }); orderForm?.addEventListener('submit', collectOrder); document.querySelectorAll('[data-edit-library]').forEach(button => button.addEventListener('click', () => { document.getElementById('edit-library-' + button.dataset.editLibrary).hidden = false })); document.querySelectorAll('[data-cancel-edit]').forEach(button => button.addEventListener('click', () => { button.closest('form').hidden = true })); document.querySelectorAll('.admin-grid form').forEach(form => form.addEventListener('submit', () => { const section = form.closest('.card[id]'); if (!section) return; let input = form.querySelector('input[name="return_focus"]'); if (!input) { input = document.createElement('input'); input.type = 'hidden'; input.name = 'return_focus'; form.append(input) } input.value = section.id })); if (returnFocus) { requestAnimationFrame(() => requestAnimationFrame(() => { const section = document.getElementById(returnFocus); if (!section) return; section.scrollIntoView({ block: 'start' }); section.focus({ preventScroll: true }) })) } })();</script>
</body>

</html>


