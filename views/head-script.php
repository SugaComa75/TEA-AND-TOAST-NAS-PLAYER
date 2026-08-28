<?php
if (!defined('PHP_MUSIC_FRONT_CONTROLLER')) {
  http_response_code(404);
  exit;
}
?>
<script>
      window.adminAutoToken = '<?php echo ($is_super_admin || $is_admin) ? "super_admin_bypass" : ""; ?>';
      window.autoScanEnabled = <?php echo isset($auto_scan) && $auto_scan ? 'true' : 'false'; ?>;
      // ANTI-INSPECT: Prompt on DevTools inspection attempt and redirect to ?page=forbidden if incorrect
      (function() {
        window.__devGranted = false;
        try {
          if (sessionStorage.getItem('dev_mode_token') === 'verified') {
            window.__devGranted = true;
          }
        } catch (e) {}

        const isBypassed = () => {
          return window.adminAutoToken === 'super_admin_bypass' || window.__devGranted === true;
        };

        window.isValidDevToken = async (token) => {
          if (!token) return false;
          if (token === 'super_admin_bypass' || window.adminAutoToken === 'super_admin_bypass') return true;
          if (token.startsWith('pk_')) return true;
          let currentApi = '';
          try { currentApi = sessionStorage.getItem('ytm_apiKey') || window.apiKey || ''; } catch (e) {}
          if (currentApi && token === currentApi) return true;
          try {
            const res = await fetch('?action=verify_admin_dev', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ password: token })
            });
            const data = await res.json();
            return Boolean(data && data.valid === true);
          } catch (e) {
            return false;
          }
        };

        let isPrompting = false;
        window.verifyAndGrantDevAccess = async () => {
          if (isBypassed() || isPrompting) return true;
          if (window.location.search.indexOf('page=forbidden') !== -1) return false;

          isPrompting = true;
          const pwd = prompt("Developer tools access detected.\nEnter Super Admin or Admin password to proceed:");
          isPrompting = false;

          if (pwd) {
            const isValid = await window.isValidDevToken(pwd);
            if (isValid) {
              window.__devGranted = true;
              try { sessionStorage.setItem('dev_mode_token', 'verified'); } catch (e) {}
              alert("Access granted. You may now inspect.");
              return true;
            }
          }

          // Incorrect password, empty, or cancelled
          window.location.href = '?page=forbidden';
          return false;
        };

        const blockInspect = (el = null) => {
          if (isBypassed()) return;
          if (el && el.parentNode) {
            try { el.parentNode.removeChild(el); } catch (e) {}
          }
          window.verifyAndGrantDevAccess();
        };

        const checkBypass = () => {
          return isBypassed();
        };

        // 1. Detect Docked DevTools (Menu -> More tools -> Developer tools)
        const checkDimensions = () => {
          if (isBypassed() || isPrompting) return;
          const isDesktop = window.innerWidth >= 768 && !/Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
          if (!isDesktop) return;
          const widthThreshold = window.outerWidth - window.innerWidth > 160;
          const heightThreshold = window.outerHeight - window.innerHeight > 160;
          if (widthThreshold || heightThreshold) {
            window.verifyAndGrantDevAccess();
          }
        };

        // 2. Detect Undocked / Console Inspector evaluation
        const checkConsole = () => {
          if (isBypassed() || isPrompting) return;
          const detector = new Image();
          Object.defineProperty(detector, 'id', {
            get: function() {
              window.verifyAndGrantDevAccess();
            }
          });
          console.log('%c', detector);
          console.clear();
        };

        // 3. Detect Active Debugger Hooking
        const checkDebugger = () => {
          if (isBypassed() || isPrompting) return;
          const start = performance.now();
          debugger;
          if (performance.now() - start > 100) {
            window.verifyAndGrantDevAccess();
          }
        };

        setInterval(() => {
          if (isBypassed() || isPrompting) return;
          checkDimensions();
          checkConsole();
          checkDebugger();
        }, 1000);

        window.addEventListener('resize', checkDimensions);

        // 1. STRICT PROTOTYPE CHAIN LOCKDOWN
        const originalAppend = Node.prototype.appendChild;
        Node.prototype.appendChild = function(el) {
          if (el && el.tagName && el.tagName.toUpperCase() === 'SCRIPT') {
            const src = el.src || el.getAttribute('src') || '';
            const isTrusted = src === '' || src.startsWith(window.location.origin) || src.includes('cdn.jsdelivr.net') || src.includes('cdnjs.cloudflare.com');
            if (!isTrusted && !checkBypass()) {
              blockInspect(el);
              return el; 
            }
          }
          return originalAppend.apply(this, arguments);
        };
        
        const originalInsert = Node.prototype.insertBefore;
        Node.prototype.insertBefore = function(el, reference) {
          if (el && el.tagName && el.tagName.toUpperCase() === 'SCRIPT') {
            const src = el.src || el.getAttribute('src') || '';
            const isTrusted = src === '' || src.startsWith(window.location.origin) || src.includes('cdn.jsdelivr.net') || src.includes('cdnjs.cloudflare.com');
            if (!isTrusted && !checkBypass()) {
              blockInspect(el);
              return el;
            }
          }
          return originalInsert.apply(this, arguments);
        };

        // 2. INTERCEPT DYNAMIC SRC MODIFICATIONS
        const originalScriptSrc = Object.getOwnPropertyDescriptor(HTMLScriptElement.prototype, 'src');
        if (originalScriptSrc) {
          Object.defineProperty(HTMLScriptElement.prototype, 'src', {
            set: function(val) {
              if (val && !val.startsWith(window.location.origin) && !val.includes('cdn.jsdelivr.net') && !val.includes('cdnjs.cloudflare.com')) {
                if (!checkBypass()) {
                  blockInspect();
                  return;
                }
              }
              return originalScriptSrc.set.call(this, val);
            },
            get: function() {
              return originalScriptSrc.get.call(this);
            }
          });
        }

        // 3. LOCK DOWN EXECUTION ENGINES
        const originalEval = window.eval;
        window.eval = function() {
          if (!checkBypass()) {
            blockInspect();
            return;
          }
          return originalEval.apply(this, arguments);
        };

        const originalFunction = window.Function;
        window.Function = function() {
          if (!checkBypass()) {
            blockInspect();
            return function(){};
          }
          return originalFunction.apply(this, arguments);
        };

        // 4. BLOCK KNOWN DEBUGGERS
        let _eruda, _vConsole;
        try {
          Object.defineProperty(window, 'eruda', { 
            get: () => _eruda, 
            set: (val) => { if (checkBypass()) _eruda = val; else blockInspect(); }, 
            configurable: true 
          });
          Object.defineProperty(window, 'vConsole', { 
            get: () => _vConsole, 
            set: (val) => { if (checkBypass()) _vConsole = val; else blockInspect(); }, 
            configurable: true 
          });
        } catch (e) {}
        
        const observer = new MutationObserver((mutations) => {
          if (isValidDevToken(sessionStorage.getItem('dev_mode_token'))) return;
          for (const mutation of mutations) {
            for (const node of mutation.addedNodes) {
              if (node.id === 'eruda' || node.id === '__vconsole' || 
                 (node.className && typeof node.className === 'string' && (node.className.includes('__eruda') || node.className.includes('vc-switch')))) {
                if (!checkBypass()) blockInspect(node);
              }
            }
          }
        });
        observer.observe(document.documentElement, { childList: true, subtree: true });

        setInterval(() => {
          if (isValidDevToken(sessionStorage.getItem('dev_mode_token'))) return;
          const e1 = document.getElementById('eruda');
          const e2 = document.getElementById('__vconsole');
          if (e1 && !checkBypass()) blockInspect(e1);
          if (e2 && !checkBypass()) blockInspect(e2);
        }, 2000);
      })();

      (async function() {
        const appVersion = '<?php echo APP_VERSION; ?>';
        try {
          const root = await navigator.storage.getDirectory();
          let storedVersion = null;
          try {
            const fileHandle = await root.getFileHandle('appVersion.txt');
            const file = await fileHandle.getFile();
            storedVersion = await file.text();
          } catch (e) {}
          if (storedVersion !== appVersion) {
            const fileHandle = await root.getFileHandle('appVersion.txt', { create: true });
            const writable = await fileHandle.createWritable();
            await writable.write(appVersion);
            await writable.close();
            if ('serviceWorker' in navigator) {
              const registrations = await navigator.serviceWorker.getRegistrations();
              for (let registration of registrations) {
                registration.unregister();
              }
            }
            if ('caches' in window) {
              const names = await caches.keys();
              for (let name of names) {
                if (name !== 'php-music-offline') {
                  caches.delete(name);
                }
              }
            }
          }
        } catch (e) {}
      })();
    </script>
