import { closeSync, existsSync, mkdirSync, openSync } from 'node:fs';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const configDirectory = path.dirname(fileURLToPath(import.meta.url));
const projectRoot = path.resolve(configDirectory, '..', '..');

export default async function globalSetup() {
    const temporaryRoot = process.env.ENDORPHINE_E2E_ROOT;
    const databasePath = process.env.DB_DATABASE;

    if (!temporaryRoot || !databasePath || process.env.DB_CONNECTION !== 'sqlite') {
        throw new Error('E2E requires its isolated SQLite database configuration.');
    }

    mkdirSync(path.dirname(databasePath), { recursive: true });
    mkdirSync(process.env.LARAVEL_STORAGE_PATH, { recursive: true });

    if (!existsSync(databasePath)) {
        closeSync(openSync(databasePath, 'w'));
    }

    const options = {
        cwd: projectRoot,
        env: process.env,
        stdio: 'inherit',
    };

    execFileSync('php', ['artisan', 'migrate:fresh', '--force'], options);
    execFileSync('php', ['artisan', 'db:seed', '--class=Database\\Seeders\\DatabaseSeeder', '--force'], options);
    execFileSync('php', ['tests/e2e/seed.php'], options);
}
