import { getCurrentInstance } from 'vue';
import { toast as toastApi } from 'vue3-toastify';

const DEFAULT_ERROR_MESSAGE = 'Terjadi kesalahan. Silakan coba lagi.';

function normalizeMessage(message, fallback = '') {
    if (typeof message === 'string' && message.trim().length > 0) {
        return message;
    }

    if (typeof fallback === 'string' && fallback.trim().length > 0) {
        return fallback;
    }

    return DEFAULT_ERROR_MESSAGE;
}

export function useToast() {
    const toast = {
        success: (message, options) => toastApi.success(normalizeMessage(message, ''), options),
        error: (message, options) => toastApi.error(normalizeMessage(message), options),
        info: (message, options) => toastApi.info(normalizeMessage(message, ''), options),
        warning: (message, options) => toastApi.warning(normalizeMessage(message, ''), options),
    };

    const instance = getCurrentInstance();
    if (instance?.proxy) {
        instance.proxy.toast = toast;
    }

    return toast;
}
