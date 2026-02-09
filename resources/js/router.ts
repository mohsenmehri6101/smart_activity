import { createRouter, createWebHistory } from 'vue-router';
import Index from './pages/Activities/Index.vue';
import Show from './pages/Activities/Show.vue';

const routes = [
    { path: '/activities', component: Index },
    { path: '/activities/:id', component: Show, props: true },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.path !== to.path.toLowerCase()) {
        next(to.path.toLowerCase());
    } else {
        next();
    }
});
