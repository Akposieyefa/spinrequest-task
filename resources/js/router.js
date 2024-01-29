import { createWebHistory, createRouter } from "vue-router";
import {useProgress} from '@marcoschulte/vue3-progress';

const routes = [
    {  path: "/", component: () => import("./Home.vue") },
    {  path: "/dashboard", component: () => import("./Dashboard.vue") },
    {  path: "/:pathMatch(.*)*", component: () => import("./Notfound.vue") },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

let progress = '';

router.beforeEach((to, from, next) => {
    const publicPages = ['/'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('token');

    if(to.path) {
        progress = useProgress().start();
    }
    if (authRequired && !loggedIn) {
        progress.finish();
        return next('/');
    }else {
        next();
    }
});

router.afterEach(() => {
    progress.finish();
});

export default router;
