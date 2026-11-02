import { defineConfig } from '@playwright/test';
import { tmpdir } from 'node:os';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const configDirectory = path.dirname(fileURLToPath(import.meta.url));
const projectRoot = path.resolve(configDirectory, '..', '..');
const temporaryRoot = path.join(tmpdir(), `endorphine-florist-e2e-${process.pid}`);
const databasePath = path.join(temporaryRoot, 'database.sqlite');

process.env.APP_ENV = 'testing';
process.env.APP_URL = 'http://127.0.0.1:8010';
process.env.DB_CONNECTION = 'sqlite';
process.env.DB_DATABASE = databasePath;
process.env.DB_URL = '';
process.env.CACHE_STORE = 'array';
process.env.SESSION_DRIVER = 'file';
process.env.FILESYSTEM_DISK = 'public';
process.env.MAIL_MAILER = 'array';
process.env.LARAVEL_STORAGE_PATH = path.join(temporaryRoot, 'storage');
process.env.ENDORPHINE_E2E_ROOT = temporaryRoot;

export default defineConfig({
    testDir: configDirectory,
    testMatch: '**/*.spec.js',
    outputDir: path.join(configDirectory, 'artifacts'),
    globalSetup: path.join(configDirectory, 'global-setup.js'),
    globalTeardown: path.join(configDirectory, 'global-teardown.js'),
    fullyParallel: false,
    workers: 1,
    reporter: [
        ['list'],
        ['json', { outputFile: path.join(configDirectory, 'playwright-results.json') }],
    ],
    use: {
        baseURL: 'http://127.0.0.1:8010',
        browserName: 'chromium',
        headless: true,
        screenshot: 'only-on-failure',
        trace: 'retain-on-failure',
    },
    webServer: {
        command: 'php artisan serve --host=127.0.0.1 --port=8010',
        cwd: projectRoot,
        url: 'http://127.0.0.1:8010/up',
        reuseExistingServer: false,
        timeout: 60000,
    },
});
