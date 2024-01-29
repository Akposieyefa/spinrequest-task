import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";

const store = createStore({
    state : {
        user: {},
        isProcessing: false
    },
    getters: {
        user: (state) => {
            return state.user;
        }
    },
    actions: {
        user(context, user) {
            context.commit('user', user);
        },
        setIsProcessing(context, value) {
            context.commit('setIsProcessing', value);
        }
    },
    mutations: {
        user(state, user) {
            state.user = user;
        },
        setIsProcessing(state, value) {
            state.isProcessing = value;
        }
    },
    plugins: [createPersistedState()],
});

export default store;
