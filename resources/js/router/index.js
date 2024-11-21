import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../pages/auth/Login.page.vue";
import DashboardPage from "../pages/admin/Dashboard.page.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            component: LoginPage,
        },
        {
            path: "/dashboard",
            component: DashboardPage,
        }
    ],
});

export default router;
