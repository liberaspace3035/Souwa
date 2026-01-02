import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { copyFileSync, mkdirSync, existsSync } from 'fs';
import { join } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        // Bootstrap Iconsフォントファイルをコピーするプラグイン
        (() => {
            const copyFonts = () => {
                const fontsDir = join(process.cwd(), 'public', 'build', 'assets', 'fonts');
                const sourceDir = join(process.cwd(), 'node_modules', 'bootstrap-icons', 'font', 'fonts');
                
                if (!existsSync(fontsDir)) {
                    mkdirSync(fontsDir, { recursive: true });
                }
                
                const fontFiles = ['bootstrap-icons.woff', 'bootstrap-icons.woff2'];
                fontFiles.forEach(file => {
                    const source = join(sourceDir, file);
                    const dest = join(fontsDir, file);
                    if (existsSync(source)) {
                        try {
                            copyFileSync(source, dest);
                            console.log(`✓ Copied ${file} to ${fontsDir}`);
                        } catch (error) {
                            console.error(`✗ Error copying ${file}:`, error);
                        }
                    }
                });
            };
            
            return {
                name: 'copy-bootstrap-icons-fonts',
                buildStart() {
                    copyFonts();
                },
                buildEnd() {
                    // ビルド完了後にフォントファイルをコピー
                    copyFonts();
                },
                writeBundle() {
                    // バンドル書き込み後にフォントファイルをコピー
                    copyFonts();
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
