import {watch} from "vue"
import axios from 'axios';
import {useProgress} from '@marcoschulte/vue3-progress';
import store from "../store.js";

const API_BASE_URL = import.meta.env.VITE_MIX_API_BASE_URL;

const progresses = [];

watch(() => app.mounted, () => {

    console.log('here')
});

axios.interceptors.request.use(config => {
    store.dispatch('setIsProcessing', true);

    const progress = useProgress()?.start();
    progresses.push(progress);

    config.headers = config.headers || {};
    const accessToken = localStorage.getItem("token")
    if (accessToken) {
        config.headers['Authorization'] = `Bearer ${accessToken}`;
    }

    return config;
});

axios.interceptors.response.use(
    resp => {
        store.dispatch('setIsProcessing', false);

        const progress = progresses.pop();
        if (progress) {
            progress.finish();
        }

        return resp;
    },
    error => {
        store.dispatch('setIsProcessing', false);

        const progress = progresses.pop();
        if (progress) {
            progress.finish();
        }

        return Promise.reject(error);
    }
);


const ApiService = {
    post: (url, data) => {
        const apiUrl = `${API_BASE_URL}/${url}`;
        return axios.post(apiUrl, data);
    },

    put: (url, data) => {
        const apiUrl = `${API_BASE_URL}/${url}`;
        return axios.put(apiUrl, data);
    },

    patch: (url, data) => {
        const apiUrl = `${API_BASE_URL}/${url}`;
        return axios.patch(apiUrl, data);
    },

    delete: (url) => {
        const apiUrl = `${API_BASE_URL}/${url}`;
        return axios.delete(apiUrl);
    },

    get: (url, params) => {
        const apiUrl = `${API_BASE_URL}/${url}`;
        return axios.get(apiUrl, { params });
    },
};

export default ApiService;
