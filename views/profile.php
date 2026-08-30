<?php
$profileError = '';
$profileNotice = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'profile') {
    try {
        tt_require_csrf();
        $name = trim((string) ($_POST['display_name'] ?? ''));
        $avatar = trim((string) ($_POST['avatar_url'] ?? ''));
        if ($name === '') throw new RuntimeException('Enter a display name.');
        if ($avatar !== '' && !filter_var($avatar, FILTER_VALIDATE_URL)) throw new RuntimeException('Avatar must be a valid image URL or left blank.');
        if (!empty($_POST['new_password'])) {
            $newPassword = (string) $_POST['new_password'];
            if (strlen($newPassword) < 8) throw new RuntimeException('Your new password must be at least 8 characters.');
            $stmt = $db->prepare('UPDATE users SET display_name = ?, avatar_url = ?, password_hash = ?, must_change_password = 0 WHERE id = ?');
            $stmt->execute([$name, $avatar, password_hash($newPassword, PASSWORD_DEFAULT), (int) $currentUser['id']]);
            $currentUser['must_change_password'] = 0;
            $profileNotice = 'Profile and password updated.';
        } else {
            if (!empty($currentUser['must_change_password'])) throw new RuntimeException('Choose a new password before continuing.');
            $stmt = $db->prepare('UPDATE users SET display_name = ?, avatar_url = ? WHERE id = ?');
            $stmt->execute([$name, $avatar, (int) $currentUser['id']]);
            $profileNotice = 'Profile updated.';
        }
        $currentUser['display_name'] = $name; $currentUser['avatar_url'] = $avatar;
    } catch (Throwable $exception) { $profileError = $exception->getMessage(); }
}
$siteName = tt_setting($db, 'site_name', 'Tea & Toast NAS Player');
$accent = tt_setting($db, 'accent_colour', '#8b5cf6');
$forced = !empty($currentUser['must_change_password']) || isset($_GET['force_password']);
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Profile · <?= tt_h($siteName) ?></title><link rel="stylesheet" href="assets/app.css?v=0.3.0"><style>:root{--accent:<?= tt_h($accent) ?>}.profile-shell{max-width:620px;margin:5rem auto;padding:1.5rem}.profile-shell .card{padding:2rem}.profile-avatar{width:72px;height:72px;border-radius:50%;object-fit:cover;background:#222}</style></head><body class="login-page"><main class="profile-shell"><section class="card"><p class="eyebrow">TEA &amp; TOAST</p><h1><?= $forced ? 'Set your password' : 'Your profile' ?></h1><?php if ($forced): ?><p class="muted">Your administrator created this account. Set a new password before using the player.</p><?php endif; ?><?php if ($profileError): ?><div class="alert error"><?= tt_h($profileError) ?></div><?php endif; ?><?php if ($profileNotice): ?><div class="alert success"><?= tt_h($profileNotice) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?= tt_h(tt_csrf_token()) ?>"><input type="hidden" name="action" value="profile"><label>Display name<input name="display_name" value="<?= tt_h($currentUser['display_name']) ?>" required></label><label>Avatar URL <span class="muted">(optional)</span><input type="url" name="avatar_url" value="<?= tt_h($currentUser['avatar_url'] ?? '') ?>" placeholder="https://…"></label><label>New password<input type="password" name="new_password" minlength="8" <?= $forced ? 'required' : '' ?> autocomplete="new-password"></label><button class="button primary"><?= $forced ? 'Set password and continue' : 'Save profile' ?></button></form><?php if (!$forced): ?><p><a class="button" href="./">Back to player</a></p><?php endif; ?><p><a href="?logout=1">Sign out</a></p></section></main></body></html>
