# Créer les dossiers nécessaires
New-Item -ItemType Directory -Force -Path "public/assets/css"
New-Item -ItemType Directory -Force -Path "public/assets/js"
New-Item -ItemType Directory -Force -Path "public/assets/images"
New-Item -ItemType Directory -Force -Path "public/assets/plugins"

# Copier les fichiers CSS
Copy-Item "portal-theme-bs5-v2.1/portal-theme-bs5-v2.1/assets/css/*" -Destination "public/assets/css" -Recurse -Force

# Copier les fichiers JS
Copy-Item "portal-theme-bs5-v2.1/portal-theme-bs5-v2.1/assets/js/*" -Destination "public/assets/js" -Recurse -Force

# Copier les images
Copy-Item "portal-theme-bs5-v2.1/portal-theme-bs5-v2.1/assets/images/*" -Destination "public/assets/images" -Recurse -Force

# Copier les plugins
Copy-Item "portal-theme-bs5-v2.1/portal-theme-bs5-v2.1/assets/plugins/*" -Destination "public/assets/plugins" -Recurse -Force

# Copier le favicon
Copy-Item "portal-theme-bs5-v2.1/portal-theme-bs5-v2.1/favicon.ico" -Destination "public/favicon.ico" -Force
