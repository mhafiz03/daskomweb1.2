import axios from 'axios';
import { router } from '@inertiajs/vue3';

const LOGIN_PATH = '/login';

async function performLogout(role) {
    const endpoint = role === 'praktikan'
        ? '/auth/praktikan/logout'
        : '/auth/asisten/logout';

    try {
        await axios.get(endpoint);
    } catch (error) {
        // Ignore network issues here so that we can still force the redirect below.
    } finally {
        router.get(LOGIN_PATH, { comingFrom: role }, { replace: true });
    }
}

export function useLogout() {
    return {
        logoutAsisten: () => performLogout('asisten'),
        logoutPraktikan: () => performLogout('praktikan'),
    };
}
