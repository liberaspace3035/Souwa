import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { copyFileSync, mkdirSync, existsSync } from 'fs';
import { join } from 'path';

export default defineConfig({
    publicDir: 'public',
    resolve: {
        alias: {
            'bootstrap': join(process.cwd(), 'node_modules', 'bootstrap'),
            'bootstrap-icons': join(process.cwd(), 'node_modules', 'bootstrap-icons'),
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                includePaths: [join(process.cwd(), 'node_modules')],
            },
        },
    },
    server: {
        fs: {
            allow: ['..'],
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        // Bootstrap Iconsフォントファイルをコピーするプラグイン
        (() => {
            const copyFonts = (targetDir) => {
                const sourceDir = join(process.cwd(), 'node_modules', 'bootstrap-icons', 'font', 'fonts');
                
                if (!existsSync(targetDir)) {
                    mkdirSync(targetDir, { recursive: true });
                }
                
                const fontFiles = ['bootstrap-icons.woff', 'bootstrap-icons.woff2'];
                fontFiles.forEach(file => {
                    const source = join(sourceDir, file);
                    const dest = join(targetDir, file);
                    if (existsSync(source)) {
                        try {
                            copyFileSync(source, dest);
                            console.log(`✓ Copied ${file} to ${targetDir}`);
                        } catch (error) {
                            console.error(`✗ Error copying ${file}:`, error);
                        }
                    }
                });
            };
            
            return {
                name: 'copy-bootstrap-icons-fonts',
                buildStart() {
                    // 開発モード用: public/fonts
                    const devFontsDir = join(process.cwd(), 'public', 'fonts');
                    copyFonts(devFontsDir);
                },
                buildEnd() {
                    // 本番モード用: public/build/assets/fonts
                    const buildFontsDir = join(process.cwd(), 'public', 'build', 'assets', 'fonts');
                    copyFonts(buildFontsDir);
                },
                writeBundle() {
                    // バンドル書き込み後にフォントファイルをコピー
                    const buildFontsDir = join(process.cwd(), 'public', 'build', 'assets', 'fonts');
                    copyFonts(buildFontsDir);
                },
            };
        })(),
    ],
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name && assetInfo.name.endsWith('.woff2')) {
                        return 'assets/fonts/[name][extname]';
                    }
                    if (assetInfo.name && assetInfo.name.endsWith('.woff')) {
                        return 'assets/fonts/[name][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
    },
});
