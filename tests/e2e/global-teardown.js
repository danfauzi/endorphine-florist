import { rmSync } from 'node:fs';

export default async function globalTeardown() {
    const temporaryRoot = process.env.ENDORPHINE_E2E_ROOT;

    if (temporaryRoot && temporaryRoot.includes('endorphine-florist-e2e-')) {
        rmSync(temporaryRoot, { recursive: true, force: true });
    }
}
