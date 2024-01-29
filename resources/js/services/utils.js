import { toast } from 'vue3-toastify';

const toaster  = (msg, type = 'success', closeTime = 3000) => {
    toast[type](msg, {
        autoClose: closeTime,
        position: toast.POSITION.TOP_RIGHT,
    });
}

export default { toaster };
