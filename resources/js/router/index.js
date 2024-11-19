import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../pages/auth/Login.page.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            component: LoginPage,
        },
    ],
});

export default router;
